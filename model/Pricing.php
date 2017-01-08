<?php

// Model to calculate pricing

Class Pricing {

    private $total; // Final Price
    // Pricing pre defined array
    public $productPricing = array('A' => array('1' => 2.00, '4' => 7.00), 'B' => array('1' => 12.00), 'C' => array('1' => 1.25, '6' => 6.00), 'D' => array('1' => 0.15)); // Product Pricing Array
    public $subTotal; // Total of each product group
    public $productInput; // Product input
    public $combinedPrice; // Group price
    public $combinedTotal;

    function __construct() {
        $this->totalPrice = 0.0;
        $this->subTotal = 0.0;
    }

    // Calculate product total
    public function calculateTotal($productArray = array()) {
        try {
            if (($productMapCount = array_count_values($productArray)) > 0) { // Count each product count in array
                foreach ($productMapCount as $product => $totalProduct) {
                    if (array_key_exists($product, $this->productPricing)) { // Check, if product exist in pre defined array
                        $subtotal = $this->process($product, $totalProduct, $this->productPricing);
                        $this->total += $subtotal;
                    }
                }
                return number_format($this->total, 2); // Return total, upto 2 decimals
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    // Calculate each product price
    public function process($product, $totalProduct, $products) {
        if ($totalProduct > 1) { // Greater than 1
            $combinedPriceArray = (array_keys($products[$product])); // Get all group prices for particular product 
            rsort($combinedPriceArray); // Start with maximum first
            $this->combinedTotal = 0;
            foreach ($combinedPriceArray as $countCombined) {// Process for multiple group prices, if any
                if ($countCombined > 1) { // If total product count greater than 1
                    $this->combinedTotal = $this->combinedTotal + (intval($totalProduct / $countCombined) * $products[$product][$countCombined]);
                    $totalProduct = $totalProduct % $countCombined; // Calculate remaining product after particular group price
                }
            }
            $this->subTotal = $this->combinedTotal + ($totalProduct * $products[$product]['1']);
        } else { // Equal to 1
            $this->subTotal = $totalProduct * $products[$product]['1'];
        }
        return $this->subTotal;
    }

}

?>