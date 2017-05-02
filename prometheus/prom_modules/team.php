<style>
.team-content-left {
	float: left;
	width: 50%;
	font-size: 12pt;
	background-color: #fff;
}

#founder-content-left, #founder-content-right {
	height: 600px;
}

#team-content-right {
	float: right;
	width: 50%;
	background-color: #0050a1;
}

#founder-background {
	width: 100%;
	clear: both;
	border: 1px solid green;
}

#founder-content-left {
	clear: both;
	background-repeat: no-repeat;
	background-position: right;
	float: left;
	width: 50%;
	background-size: auto 100%; background-color : #0050a1;
	background-image: url("../Images/teamright.jpg");
	background-color: #0050a1;
}

#founder-content-right {
	float: right;
	width: 50%;
	font-size: 12pt;
	background-color: #fff;
}

.left-body-cut {

	margin: 0 auto;
	max-width: 512px;
}

.founder-right-side {
	text-align: left;
	float: left;
	margin: 0 auto;
	width: 512px;
}

.right-body-cut {
	text-align: right;
	float: left;
	margin: 0 auto;
	width: 512px;
}

.imageContent {
	float: left;
	width: 30%;
}

img.team-image {
	position: relative;
	text-align: left;
	max-width: 300px;
}

h2 {
	color: red;
	text-transform: uppercase;
}

img.right-arrow {
	height: 600px;
	float: left;
	z-index: -997;
}

.header-text {
	padding: 10px;
}

#totalCoverage {
	height: 1200px;
	width: 100%;
	clear: both;
	background-color: #fff;
	background-image: linear-gradient(right, #0050a1, #0050a1 50%, transparent 50%,
		transparent 100%);
	background-image: -webkit-linear-gradient(right, #0050a1, #0050a1 50%, transparent 50%,
		transparent 100%);
}

#topBar {
	height: 600px;
	width: 100%;
	clear: both;
	border-bottom: 15px solid #0a3470;
	background-color: #fff;
	background-image: linear-gradient(right, #0050a1, #0050a1 50%, transparent 50%,
		transparent 100%);
	background-image: -webkit-linear-gradient(right, #0050a1, #0050a1 50%, transparent 50%,
		transparent 100%);
}

#bottomBar {

position: absolute;
	height: 600px;
	width: 100%;
	clear: both;
	background-color: #fff;
	background-image: linear-gradient(left, #0050a1, #0050a1 50%, transparent 50%, transparent
		100%);
	background-image: -webkit-linear-gradient(left, #0050a1, #0050a1 50%, transparent 50%,
		transparent 100%);
		border-bottom: 15px solid #0a3470;
}

.whyChooseHeader {
	text-align: center;
	height: 70px;
	line-height: 70px;
	font-size: 22pt;
	text-transform: uppercase;
	color: red;
	text-shadow: /* first layer at 1px */ -2px -2px 0px #fff, 0px -2px 0px
		#fff, 1px -2px 0px #fff, -2px 0px 0px #fff, 2px 0px 0px #fff, -2px 2px
		0px #fff, 0px 2px 0px #fff, 2px 2px 0px #fff, 0 0 45px #0250a2;;
	font-weight: bold;
}

.team-centered {
	max-width: 1024px;
	margin: 0 auto;

}

.team-triwindow {
	width: 30%;
	float: left;
	margin-top: -100px;
}

.body-content {
	max-width: 1024px;
	margin: 0 auto;
}

.image1
{
left: 12%;
position: absolute;
z-index: 999;
}

.image2
{
left: 40%;
position: absolute;
z-index: 999;
}

.image3
{
left: 65%;
position: absolute;
z-index: 999;
}

.founder-image
{
  display: block;
    margin: auto;
border: 1px dotted red;

}
</style>

<?php

require_once dirname ( dirname ( __FILE__ ) ) . '/SunLibraryModule.php';

class team extends SunLibraryModule {
	
	protected $dbConnection;
	const ModuleDescription = 'TeamPanel. <br> <i>Dual Sided</i>';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '0.1';
	
	function __construct($dbConnection) {
		parent::__construct ( $dbConnection );
	}
	
	public function team() {
		
		if ($stmt = $this->objDB->prepare ( "SELECT iconSetOne, iconSetTwo, iconSetThree, teamImage, teamContent, teamFounderImage, teamFounderContent FROM teampanel WHERE teampanelID=1 " )) {
			
			$stmt->execute ();
			$stmt->bind_result ( $iconSetOne, $iconSetTwo, $iconSetThree, $teamImage, $teamContent, $teamFounderImage, $teamFounderContent );
			$stmt->fetch ();
			
			echo '<table border=0 cellpadding=5>';
			echo '<tr bgcolor=999999 style="color: white; height: 20px; padding: 10px;"><td>Images</td></tr>';
			echo '<tr><td class="txtContent"><a href="?id=team&&moduleID=editImage&&ContentID=teamImage"><img src="' . IMAGE_PATH . '/' . $teamImage . '" height=50></a>
        		<a href="?id=team&&moduleID=editImage&&ContentID=iconSetOne"><img src="' . IMAGE_PATH . '/' . $iconSetOne . '" height=50></a>
        		<a href="?id=team&&moduleID=editImage&&ContentID=iconSetTwo"><img src="' . IMAGE_PATH . '/' . $iconSetTwo . '" height=50></a>
        		<a href="?id=team&&moduleID=editImage&&ContentID=iconSetThree"><img src="' . IMAGE_PATH . '/' . $iconSetThree . '" height=50></a></td></tr>';
			
			echo '<tr bgcolor=999999 style="color: white; height: 20px; padding: 10px;"><td>Team Content Information</td></tr>';
			echo '<tr><td class="txtContent">' . $teamContent . '<a class="rightLink" href="?id=team&&moduleID=editContent&&ContentID=teamContent">edit</a></td></tr>';
			echo '<tr bgcolor=999999 style="color: white; height: 20px; padding: 10px;"><td>Founder Content Information</td></tr>';
			echo '<tr><td class="txtContent">' . $teamFounderContent . '<a class="rightLink" href="?id=team&&moduleID=editContent&&ContentID=teamFounderContent">edit</a></td></tr>';
			echo '</table>';
		}
	}

	public function callToFunction() {
		
		if ($stmt = $this->objDB->prepare ( "SELECT iconSetOne, iconSetTwo, iconSetThree, teamImage, teamContent, teamFounderImage, teamFounderContent FROM teampanel WHERE teampanelID=1 " )) {
		
			$stmt->execute ();
			$stmt->bind_result ( $iconSetOne, $iconSetTwo, $iconSetThree, $teamImage, $teamContent, $teamFounderImage, $teamFounderContent );
			$stmt->fetch ();
			?>
		
		<span class="lineOut" id="Team"></span>
		<div id="totalCoverage">
			<div id="topBar">
					<div class="body-content">
		
					<div class="team-content-left">
						<div class="whyChooseHeader">Our Team</div>
						<br><?php echo nl2br($teamContent); ?>
								</div>
					<div class="right-body-cut">
						<img class="right-arrow" src="<?php echo IMAGE_PATH; ?>/leftteam.jpg" alt=""> 
						<img src="<?php echo IMAGE_PATH . '/' . $teamImage; ?>" alt="">
					</div>
				</div>
				</div>
					<div class="team-centered">
						<div class="team-triwindow">
							<img class="image1" src="<?php echo IMAGE_PATH; ?>/standards.png" alt="" width=300>
						</div>
						<div class="team-triwindow">
							<img class="image2" src="<?php echo IMAGE_PATH; ?>/service.png" alt="" width=300>
						</div>
						<div class="team-triwindow">
							<img class="image3" src="<?php echo IMAGE_PATH; ?>/police.png" alt="" width=300>
						</div>
					</div>
		
			<div id="bottomBar">
		
				<div id="founder-content-left">
		
					<div class="left-body-cut">
						<br> <br> <br> <img class="founder-image" src="<?php echo IMAGE_PATH . '/' . $teamFounderImage; ?>" alt="">
						
					</div>
				</div>
				<div id="founder-content-right">
					<br> <br> <br> 
					<div class="founder-right-side">
						<div class="whyChooseHeader">Our Founder</div>
						<br><br><?php echo nl2br($teamFounderContent); ?></div>
				</div>
			</div>
		</div>
		
		<?php  } 
	}
	
	
	protected function assertTablesExist() {
		$val = mysqli_query ( $this->objDB, 'select 1 from `teampanel` LIMIT 1' );
		
		if ($val !== FALSE) {
		} else {
			echo 'Table Doesnt Exist....';
			
			$createTable = $this->objDB->prepare ( "CREATE TABLE teampanel (teampanelID INT(11) AUTO_INCREMENT PRIMARY KEY, iconSetOne VARCHAR(100) NOT NULL, pointSetOne VARCHAR(2000) NOT NULL, iconSetTwo VARCHAR(100) NOT NULL, pointSetTwo VARCHAR(2000) NOT NULL, iconSetThree VARCHAR(100) NOT NULL, pointSetThree VARCHAR(2000) NOT NULL, teamImage VARCHAR(100) NOT NULL, teamContent VARCHAR(2000) NOT NULL)" );
			$createTable->execute ();
			$createTable->close ();
			
			echo 'Table Created.';
		}
	}
} 