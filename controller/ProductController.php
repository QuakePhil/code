<?php
// Controller to manage product pricing
Class ProductController {

    function __construct() {
        
    }
    
    // To calculate product total, return price of products
    public function terminalAction($productArray) {
        try {
            if (strlen(trim($productArray)) > 0) { // If product exist
                $productInput = array_map('strtoupper', str_split($productArray)); // Convert the string into array
                require_once 'model/Pricing.php';
                $pricing = new Pricing(); // Get pricing
                // Calculate product price
                $returnTotal = $pricing->calculateTotal($productInput);
                echo 'Total price is : $'.$returnTotal;
            } else {
                echo 'No product found';
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}

?>