<style>
#tri-image-background {
	height: 300px;
	width: 100%;
	clear: both;
}

.tri-image-content
{
	padding-top: 10px;
	height: 300px;
	background-color: #000;
	margin: 0 auto;
	max-width: 1024px;
	
}
.triImage {

	float: left;
	height: 700px;
	margin-left: 15px; /* equals max image height */
	width: 30%;
	white-space: nowrap;
	text-align: center;
}

.helper {
	display: inline-block;
	height: 100%;
	vertical-align: middle;
}

img {
	vertical-align: middle;
	max-height: 50%;
}

.tri-window-header
{
	background: url("../../Images/triimageheaderbackground.jpg");
	height: 63px;
	line-height: 63px;
	width: 100%;
	clear: both;
	color: #fff;
	text-align: center;
	text-transform: uppercase;
	font-size: 16pt;
}

.tri-image-window
{
color: #fff;
float: left;
width: 27%;
margin-left: 40px;
height: 100px;
	
}

.tri-image-window img
{
	border: 5px solid #fff;
	width: 125px;
	height: 125px;
}

.tri-window-left
{
	float: left;
	width: 50%;
	
}
.tri-window-right
{
	float: right;
	font-size: 10pt;
	width: 45%;

}

.cat-header
{
	font-size: 12pt;
	text-transform: uppercase;
}

.cat-header, .cat-button
{
	height: 40px;
	line-height: 40px;

}
div.cat-body
{
height: 120px;
}
</style>

<?php
/**
 * Three window module.
 *
 * @author Andrew Jeffries <andrew.jeffries@sunsetcoders.com.au>
 * @version 1.0.0 2016-11-28 08:46:13 SM: Prototype
 */
try {
    $dbTriConnection = databaseConnection();
} catch (Exception $objException) {
    die($objException);
}

require_once dirname(dirname(__FILE__)) . '/SunLibraryModule.php';

class tri_image extends SunLibraryModule
{
	protected $dbConnection;
	const ModuleDescription = 'Three Column. <br> Database drive, left and right sides left is Image, right is Database of Services that are included.';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '0.1';
	
	function __construct($dbConnection)
	{
		parent::__construct($dbConnection);
	}
	
	public function tri_image()
	{
		
	}

    public function callToFunction()
    {
		?>
		<div id="tri-image-background">
			<div class="tri-image-content">
			
			<div class="tri-window-header">The Store</div>
		
		<br>
			<?php 
			$baseCode = $this->objDB->prepare("SELECT catName, catImage, catDescription FROM theshop_categorys ORDER BY RAND() LIMIT 3");
        	$baseCode->execute();
        	$baseCode->bind_result($catName, $catImage, $catDescription);
        
        	while ($checkRow = $baseCode->fetch()) {
            
        		?>
        		
           		<div class="tri-image-window">
           			<div class="tri-window-left"><img src="<?php echo IMAGE_PATH; ?>/<?php echo $catImage; ?>" alt=""></div>
                
           			<div class="tri-window-right">
						<div class="cat-header"><?php echo $catName; ?></div>
           				<div class="cat-body"><hr><?php echo $catDescription; ?></div>
						<div class="cat-button"><button> More Info </button></div>
                	</div>
                </div>
                <?php
        }
        
?>
			
		</div>
		</div>
		<?php 
    }
}
?>
