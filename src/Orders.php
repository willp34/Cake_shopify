<?php

   class Orders{
	   
	   private $no_orders =0;
	   private  $shopify_orders = array();
	   public  function __construct(){
					
				$url='https://fauxdata.codelayer.io/api/orders';
				$json	= @file_get_contents('https://fauxdata.codelayer.io/api/orders');
				
				if ($json === false) {
					throw new Exception("Failed to retrieve data from $url");
				
					exit;
				}
				$this->shopify_orders =json_decode($json,true);
				
				$this->display();
		   
	   }
	   
	   private function cost_of_revenue(){
		   
		   $key = "price";
		    $revenue = 0.00;
		   foreach($this->shopify_orders["orders"] as $order){
			  
			   foreach($order['items'] as $product){
					$revenue+=$product['price'];
			   }
		   }
		   return $revenue; 
		   
	   }
	   
	   private function getAverageOrderValue(){
		
		if ($this->no_orders === 0) {
            return "0.00";  // Prevent division by zero
        }

		   $average_order_value =  $this->cost_of_revenue()/$this->no_orders;
		   return number_format($average_order_value,2);
		   
	   }
	   
	   private function display(){
		   $this->no_orders= count($this->shopify_orders["orders"]);
				//echo "<br  />orders  :  ". $this->no_orders; 
				//echo "<br  />Revenue  :  £".  number_format($this->cost_of_revenue(), 2);
				echo "Average order Value  :  £". $this->getAverageOrderValue();
		   
	   }
	   	   
		   
   }
   ?>