<?php

   class Orders{
	   
	   private $no_orders =0;
	   private  $shopify_orders = array();
	   
	   /*
	   * The constructor will firstly get the content of the json  file an turn it into an array. 
	   * If error 500 is generated an exception will be thrown.
	   * If no Erros are found calculate the number of orders along with the average cost of sales 
	   */
	   public  function __construct(){
					
				$url='https://fauxdata.codelayer.io/api/orders';
				$json	= @file_get_contents('https://fauxdata.codelayer.io/api/orders');
				
				if ($json === false) {
					throw new Exception("Failed to retrieve data from $url");
				
					
				}
				$this->shopify_orders =json_decode($json,true);
				$this->no_orders= count($this->shopify_orders["orders"]);
				
				if (php_sapi_name() == "cli") {
					$this->display();
				}else{
					$this->display_browser();
				}
		   
	   }
	   
	   /*
	   * Calculate The revenue by looping throught the shopify_orders["orders"] and fing key price 
	   * within Items array and add them all up
	   * @return float
	   */
	   private function cost_of_revenue(){
		   
		   $revenue = 0.00;
		   foreach($this->shopify_orders["orders"] as $order){
			  
			   foreach($order['items'] as $product){
					$revenue+=$product['price'];
			   }
		   }
		   return $revenue; 
		   
	   }
	   
	   /*
	   *   Revenue /number of Orders 
	   *  @return String
	   */
	   
	   private function getAverageOrderValue(){

		 // Prevent division by zero
		if ($this->no_orders === 0) {
            return "No Orders"; 
        }

		   $average_order_value =  $this->cost_of_revenue()/$this->no_orders;
		   return number_format($average_order_value,2);
		   
	   }
	   /*
	   *  Display the Average order value to the user
	   * 	Void
	   */
	   private function display(){
				
				//echo "<br  />orders  :  ". $this->no_orders; 
				//echo "<br  />Revenue  :  £".  number_format($this->cost_of_revenue(), 2);
				echo "Average order Value  :  £". $this->getAverageOrderValue();
		   
	   }
	   
	   private function display_browser(){
	
			?>
			<h1>Orders   <?php  echo   $this->no_orders ?></h1>
			<?php
		 		   foreach($this->shopify_orders["orders"] as $order){
							?>
									<h2><?php echo $order['customer']['name']  ?></h2>
							
							
							<ul>
							
							<?php
								$order_total  = 0.00; 
								 foreach($order['items'] as $product){
										$order_total += $product['price'];
									?> 
										
									<li>
										<?php echo $product['name']."    <strong>£ ".$product['price']."</strong>";  ?>
									</li>
									<?php
							   }
							?>
							</ul>
							<p>Order Total  : <?php echo number_format($order_total,2) ;  ?></p>
							<?php
							
							
				   }


				$this->display();
	   }
	   	   
		   
   }
   ?>