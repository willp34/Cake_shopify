<?php

		include_once 'src/Orders.php';
		
		try {
			new Orders();
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
}
		
?>