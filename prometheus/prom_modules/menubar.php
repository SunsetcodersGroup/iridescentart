<style>

#menu-background
{
	background-color: #000;
	clear: both;
	height: 300px;
	width: 1024px;
	margin: 0 auto;
	border-bottom: 1px solid #fff;
}
.menu-bar
{
	
	width: 980px;
    background-image: url("../Images/menubackground.jpg");
	height: 80px;
	margin: 0 auto;

}

.menu-box
{
	float: left;
	width: 245px;
	height: 80px;
	line-height: 80px;
	text-align: center;
	color: #aaa;
	text-transform: uppercase;
}

.menu-box:hover
{
	color: #fff;
}

.menu-box a
{
	color: #aaa;
	text-decoration: none;
}

.menu-box a:hover
{
	color: #fff;
}

.welcome-message
{
	background-color: #000;
	color: #aaa;
	font-size: 12pt;
	text-align: center;
	margin: 0 auto;
	max-width: 980px;
	height: 150px;
	line-height: 60px;
}
.welcome-message h2
{
	color: #fff;
	font-size: 14pt;
}


</style>

<?php
$dbTriConnection = databaseConnection ();



require_once dirname ( dirname ( __FILE__ ) ) . '/SunLibraryModule.php';

class menubar extends SunLibraryModule {
	
	protected $dbConnection;
	
	const ModuleDescription = 'Website Menu Bar. With Welcome Message';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '0.1';
	
	function __construct($dbConnection) {
		parent::__construct ( $dbConnection );
	}
	public function menubar() {
		
		/*
		 * This is prometheus Administrator output.
		 */
	}
	
	public function callToFunction() {
		
		
		?>
		<div id="menu-background">
			<div class="body-content">
				<div class="menu-bar">
  					<div class="menu-box"><a href="<?php echo PATH_NAME; ?>">Home</a></div>
   					<div class="menu-box"><a href="<?php echo PATH_NAME; ?>/index.php/Shop">Shop</a></div>
   					<div class="menu-box">Contact</div>
   					<div class="menu-box"><a href="index.php/Cart">Cart</a></div> 
				</div>
				<div class="welcome-message"> Homemade sugar scrubs, dream catchers, cards and invitations + home decor! <br>Located in Batemans Bay, NSW.</div>
			</div>
		</div>
		<?php
	}
	
	protected function assertTablesExist() {
		
		$val = mysqli_query ( $this->objDB, 'select 1 from `slider` LIMIT 1' );
		
		if ($val !== FALSE) {
		} else {
			$createTable = $this->objDB->prepare ( "CREATE TABLE slider (sliderID INT(11) AUTO_INCREMENT PRIMARY KEY, imageToSlide VARCHAR(100) NOT NULL, sliderOrder DECIMAL(3,0) NOT NULL)" );
			$createTable->execute ();
			$createTable->close ();
		}
	}
	
}
