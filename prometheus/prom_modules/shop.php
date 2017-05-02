<style>

#shop-background
{
clear: both;
width: 100%;

}

.shop-content
{
	background-color: #fff;
	margin: 0 auto;
	max-width: 1020px;
	height: auto;
     display: table;
}


.shop-window
{
	text-align: center;
	float: left;
	width: 275px;
	padding: 10px;
	min-height: 250px;
	margin: 15px;
	display: table-cell;
	
}
.shop-window img
{
	width: 200px;
}

.close-shop
{
	clear: both;
	width: 100%;
	height: 50px;
}

.product-image
{
	height: 300px;
	
}
.product-name, .product-cost, .product-category
{
	line-height: 40px;
	height: 40px;
}

.product-category
{
	padding-left: 30px;
font-weight: bold;
	width: 100%;
	clear: both;
}
</style>

<?php
$dbTriConnection = databaseConnection ();



require_once dirname ( dirname ( __FILE__ ) ) . '/SunLibraryModule.php';

class shop extends SunLibraryModule {
	
	protected $dbConnection;
	
	const ModuleDescription = 'Ecommerce Shop, Supports Mysqli, Dated Specials.. ';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '0.1';
	
	function __construct($dbConnection) {
		parent::__construct ( $dbConnection );
	}
	public function shop() {
		
		/*
		 * This is prometheus Administrator output.
		 */
	}
	
	public function callToFunction() {
		
		$oldCode = NULL;
		
		echo '<div id="shop-background">';
		echo '<div class="shop-content">';
			
		$baseCode = $this->objDB->prepare ( "SELECT productName, productImage1, productCost, productCategory FROM theshop ORDER BY productCategory, productName" );
		$baseCode->execute ();
		
		$baseCode->bind_result ( $productName, $productImage, $productCost, $productCategory);
		
		while ( $checkRow = $baseCode->fetch () ) {
			
			if ($oldCode!=$productCategory)
			{
				echo '<div class="product-category">'.$productCategory.'</div>';
			}
			echo '<div class="shop-window">';
				
			echo '<div class="product-image"><img src="' . IMAGE_PATH . '/' . $productImage. '" alt=""></div>';
			echo '<div class="product-name">'.$productName.'</div>';
			echo '<div class="product-cost">$'.$productCost.'</div>';
			echo '</div>';
		
			$oldCode = $productCategory;
		}
		echo '</div>';
		echo '</div>';
		echo '<div class="close-shop"></div>';
	}
	
	protected function assertTablesExist() {
		
		$val = mysqli_query ( $this->objDB, 'select 1 from `shop` LIMIT 1' );
		
		if ($val !== FALSE) {
		} else {
			$createTable = $this->objDB->prepare ( "CREATE TABLE shop (shopID INT(11) AUTO_INCREMENT PRIMARY KEY, imageToSlide VARCHAR(100) NOT NULL, sliderOrder DECIMAL(3,0) NOT NULL)" );
			$createTable->execute ();
			$createTable->close ();
		}
	}
	
}
