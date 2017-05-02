<style>

.slider-background
{
	height: 330px;
	clear: both;
	background-color: #000;
	margin: 0 auto;
	max-width: 1024px;
}
.slider-content
{
	margin: 0 auto;
	max-width: 980px;
}
@keyframes slidy {
0% { left: 0%; }
20% { left: 0%; }
25% { left: -100%; }
45% { left: -100%; }
50% { left: -200%; }
70% { left: -200%; }
75% { left: -300%; }
95% { left: -300%; }
100% { left: -400%; }
}

div#slider {
	background-color: #fff;
	overflow: hidden;
	height: 300px;
}

div#slider figure img {
	width: 20%;
	float: left;
}

div#slider figure {
	position: relative;
	width: 500%;
	margin: 0;
	left: 0;
	text-align: left;
	animation: 20s slidy infinite;
	z-index: 1;
}


</style>

<?php
$dbTriConnection = databaseConnection ();



require_once dirname ( dirname ( __FILE__ ) ) . '/SunLibraryModule.php';

class slider extends SunLibraryModule {
	
	protected $dbConnection;
	
	const ModuleDescription = '5 Image Database Driver Slider.';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '0.1';
	
	function __construct($dbConnection) {
		parent::__construct ( $dbConnection );
	}
	public function slider() {
		
		/*
		 * This is prometheus Administrator output.
		 */
	}
	
	public function callToFunction() {
		
		
		?>
		<div class="slider-background">
		<div class="slider-content">
		<div id="slider">
			<figure>
		
			<?php 
			$stmt = $this->objDB->prepare ( "SELECT imageToSlide FROM slider ORDER BY sliderOrder" );
			$stmt->execute ();
		
			$stmt->bind_result ( $imageToSlide );
		
			while ( $checkRow = $stmt->fetch () ) {
			
			
				echo '<img src="' . IMAGE_PATH . '/' . $imageToSlide . '" alt="">';
			}
			?>
			</figure>
		</div>
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
