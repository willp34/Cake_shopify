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
				$this->display();
		   
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
            return "0.00"; 
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
	   	   
		   
   }
   ?>