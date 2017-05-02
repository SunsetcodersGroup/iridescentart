<style>
#column-background {
	clear: both;
	height: 600px;
	width: 100%;
	background-color: #eaeaea;
	margin-top: -100px;
	font-size: 1em;
}

.tri-column, .tri-column-two {
	margin: 15px;
	color: #000;
	height: 500px;
}

.tri-column {
	float: left;
	width: 30%;
}

.tri-column img
{
	border: 5px solid #fff;
}
.tri-column-two {
	float: right;
	width: 60%;
}

.tri-column h1, .tri-column-two h1{
	font-size: 24pt;
	color: #000;
}
</style>

<?php
require_once dirname ( dirname ( __FILE__ ) ) . '/SunLibraryModule.php';
class tricolumn extends SunLibraryModule {
	const ModuleDescription = 'Picture Gallery. <br><br> Picture Gallery screen content.';
	const ModuleAuthor = 'TheSatedan WebDevelopment.';
	const ModuleVersion = '0.1';
	function __construct($dbTriConnection) {
		parent::__construct ( $dbTriConnection );
	}
	public function tricolumn() {
	}
	public function callToFunction() {
		if ($stmt = $this->objDB->prepare ( "SELECT columnOneContent, columnTwoContent FROM tricolumn WHERE columnID=1" )) {
			
			$stmt->execute ();
			$stmt->bind_result ( $columnOneContent, $columnTwoContent );
			$stmt->fetch ();
			
			?>
			<span class="lineOut" id="About"></span>
<div id="column-background">
	<div class="body-content">
		<div class="tri-column">
		<br>
			<h1>A Little About Me</h1>
			<br>
			<img src="Images/aria.jpg">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
		</div>
		<br>
		<div class="tri-column-two"><h1>My Experiences</h1><br><?php echo nl2br($columnTwoContent); ?></div>
	</div>
</div>
<?php
		}
	}
	protected function assertTablesExist() {
		$val = mysqli_query ( $this->objDB, 'select 1 from `tricolumn` LIMIT 1' );
		
		if ($val !== FALSE) {
		} else {
			echo 'Table Doesnt Exist....';
			
			$createTable = $this->objDB->prepare ( "CREATE TABLE tricolumn (columnID INT(11) AUTO_INCREMENT PRIMARY KEY, columnOneContent TEXT NOT NULL, columnTwoContent TEXT NOT NULL, columnThreeContent TEXT NOT NULL)" );
			$createTable->execute ();
			$createTable->close ();
			
			echo 'Table Created.';
		}
	}
}
