<style>
#about-background {
	clear: both;
	height: 600px;
	width: 100%;
	background-color: #0050a1;
	border-bottom: 15px #0a346f solid;
	font-size: 1em;
}

.about-left {
	height: 600px;
	width: 452px;
	float: right;
	
	color: #fff;
	padding: 5px;
}

.about-right {
	
}

.image-left {
	
	float: left;
	clear: left;
	height: 70px;
	width: 70px;
	
}

.spongeImage
{
	width: 40px;
}
.content-right {
	height: 70px;
	
	vertical-align: top;
}

.larger-text
{
	text-align: center;
	color: #000;
	width: 85%;
	float: left;
	background-color: #fff;
	border-radius: 15px;
	box-shadow: 0 0 35px #f8efc8;
	margin-left: 7px;
	margin-right: 7px;
	padding: 10px;
	margin-bottom: 50px;
	z-index: 3;

}
</style>

<?php
$dbTriConnection = databaseConnection ();

require_once dirname ( dirname ( __FILE__ ) ) . '/SunLibraryModule.php';

class about extends SunLibraryModule {
	
	const ModuleDescription = 'About Us. <br><br> About Us screen content.';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '0.1';
	
	function __construct($dbTriConnection) {
		
		parent::__construct ( $dbTriConnection );
	}
	
	public function about() {
		echo '<table>';
		if ($stmt = $this->objDB->prepare ( "SELECT iconSetOne, reasonSetOne, iconSetTwo, reasonSetTwo, iconSetThree, reasonSetThree, aboutContent, aboutSubContent FROM about WHERE aboutID=1 " )) {
			
			$stmt->execute ();
			$stmt->bind_result ( $iconSetOne, $reasonSetOne, $iconSetTwo, $reasonSetTwo, $iconSetThree, $reasonSetThree, $aboutContent, $aboutSubContent );
			$stmt->fetch ();
			
			echo '<tr><td colspan=2><b>About Content</b></td></tr>';
			echo '<tr><td colspan=2 class="txtContent"><a href="?id=About&&moduleID=editContent&&ContentID=aboutContent">' . $aboutContent . '</a></td></tr>';
			echo '<tr><td>&nbsp;</td></tr>';
		}
		echo '</table>';
	}

	public function callToFunction() {
	
		if ($stmt = $this->objDB->prepare ( "SELECT aboutContent, aboutContent1, aboutContent2, aboutContent3, aboutContent4, aboutContent5, aboutContent6, aboutIcon, aboutImage FROM about WHERE aboutID=1 " )) {
			
			$stmt->execute ();
			$stmt->bind_result ( $aboutContent, $aboutContent1, $aboutContent2, $aboutContent3, $aboutContent4, $aboutContent5, $aboutContent6, $aboutIcon, $aboutImage );
			$stmt->fetch ();
			?>
			<div id="About" class="lineOut"></div>
			<div id="about-background">
				<div class="left-banner-cut">
					<div  class="about-left">
                		<br><?php
						echo '<div class="whyChooseHeader">ABOUT US </div>';
						echo '<div>' . nl2br ( $aboutContent ) . '</div>';
						echo '<br><div class="image-left"><img class="spongeImage" src="' . IMAGE_PATH . '/' . $aboutIcon . '" alt=""></div><div class="content-right">' . $aboutContent1 . '</div>';
						echo '<div class="image-left"><img class="spongeImage" src="' . IMAGE_PATH . '/' . $aboutIcon . '" alt=""></div><div class="content-right">' . $aboutContent2 . '</div>';
						echo '<div class="image-left"><img class="spongeImage" src="' . IMAGE_PATH . '/' . $aboutIcon . '" alt=""></div><div class="content-right">' . $aboutContent3 . '</div>';
						echo '<div class="image-left"><img class="spongeImage" src="' . IMAGE_PATH . '/' . $aboutIcon . '" alt=""></div><div class="content-right">' . $aboutContent4 . '</div>';
						echo '<div class="image-left"><img class="spongeImage" src="' . IMAGE_PATH . '/' . $aboutIcon . '" alt=""></div><div class="content-right">' . $aboutContent5 . '</div>';
						echo '<br><div class="larger-text">' . nl2br ( $aboutContent6 ) . '</div>';
						?>
                	</div>
				</div>
				<div class="right-banner-cut">	
					<div  class="right">
						<img src="<?php echo IMAGE_PATH.'/'.$aboutImage; ?>" alt="" width=100% height=600>
					</div>
				</div>
			</div>
			<?php
		}
	}
	
	protected function assertTablesExist() {
		global $dbTriConnection;
		
		$val = mysqli_query ( $dbTriConnection, 'select 1 from `about` LIMIT 1' );
		
		if ($val !== FALSE) {
		} else {
			echo 'Table Doesnt Exist....';
			
			$createTable = $dbTriConnection->prepare ( "CREATE TABLE about (aboutID INT(11) AUTO_INCREMENT PRIMARY KEY, iconSetOne VARCHAR(100) NOT NULL, reasonSetOne VARCHAR(2000) NOT NULL, iconSetTwo VARCHAR(100) NOT NULL, reasonSetTwo VARCHAR(2000) NOT NULL, iconSetThree VARCHAR(100) NOT NULL, reasonSetThree VARCHAR(2000) NOT NULL, aboutContent VARCHAR(3000) NOT NULL, aboutSubContent VARCHAR(2000) NOT NULL)" );
			$createTable->execute ();
			$createTable->close ();
			
			echo 'Table Created.';
		}
	}
}
