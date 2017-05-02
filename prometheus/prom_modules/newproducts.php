<style>
#newproducts-background {
	height: 400px;
	width: 100%;
	clear: both;
}

.newproducts-content {
	min-height: 400px;
	background-color: #000;
	margin: 0 auto;
	max-width: 1024px;
}

.newproducts-window
{
	margin: 0 auto;
	max-width: 980px;
	background-image: url("../../../Images/newproductbackground.jpg");
	z-index: 1;
	height: 400px;
	padding: 40px;
}

.newproducts-window img 
{
	height: 110px;
	width: 110px;
	float: left;
	margin: 8px;
}

.newproducts-header
{
	color: #fff;
	line-height: 25px;
	height: 25px;
}
</style>

<?php
/**
 *        
 * Three window module.
 *
 * @author Andrew Jeffries <andrew.jeffries@sunsetcoders.com.au>
 * @version 1.0.0 2016-11-28 08:46:13 SM: Prototype
 */
try {
	$dbTriConnection = databaseConnection ();
} catch ( Exception $objException ) {
	die ( $objException );
}

require_once dirname ( dirname ( __FILE__ ) ) . '/SunLibraryModule.php';

class newproducts extends SunLibraryModule {

	protected $dbConnection;
	
	const ModuleDescription = 'Database drive, left and right sides left is Image, right is Database of Services that are included.';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '0.1';
	
	function __construct($dbConnection) {
	
		parent::__construct ( $dbConnection );
	}
	
	public function newproducts() {

	}
	
	public function callToFunction() {
		
		?>

		<div id="newproducts-background">
			<div class="newproducts-content">
				<div class="newproducts-window">
				
				<div class="newproducts-header">NEW PRODUCTS</div>
				<?php
				$baseCode = $this->objDB->prepare ( "SELECT productImage1, productName FROM theshop ORDER BY RAND() LIMIT 14" );
				$baseCode->execute ();
				$baseCode->bind_result ( $productImage, $productName);
		
				while ( $checkRow = $baseCode->fetch () ) {
			
					echo '<div><img src="' . IMAGE_PATH . '/' . $productImage . '" title="'.$productName.'"></div>';
				}
	
				?>
				</div>
			</div>
		</div>
		<?php
		
	}
}
?>
