<style>
#faq-background {
	width: 100%;
	min-height: 700px;
}

.shadowWindow {
	margin-top: 150px;
	width: 100%;
	float: left;
	background-color: #fff;
	border-radius: 15px;
	box-shadow: 0 0 35px #0250a2;
	margin-left: 7px;
	margin-right: 7px;
	padding: 25px;
	margin-bottom: 50px;
}

.faq-question {
	margin-top: 20px;
	font-size: 12pt;
	font-weight: bold;
	padding: 10px;
}

.faq-answer {
	margin-left: 60px;
	font-style: italic;
}

.bubble-image {
	margin-right: 10px;
}

button, input[type=submit] {
	border-radius: 5px;
	border: 2px solid #000;
	background: url("../Images/noise.png");
	padding: 7px;
	text-transform: uppercase;
	font-size: 8pt;
	letter-spacing: .1em;
}

textarea, input[type=text]
{
color: #000;
background-color: white;
font-weight: normal;

}
</style>

<?php
$dbTriConnection = databaseConnection ();

require_once dirname ( dirname ( __FILE__ ) ) . '/SunLibraryModule.php';

class privacy extends SunLibraryModule {
	
	const ModuleDescription = 'Privacy. <br><br> Frequently Asked Question display screen content.';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '0.1';
	
	function __construct($dbTriConnection) {
		parent::__construct ( $dbTriConnection );
	}
	
	public function privacy() {
		
		echo '<table border=1 width=80% cellpadding=10>';
		echo '<tr><td><input type="text" name="faqQuestion"><input type="text" name="faqAnswer"><input type="submit" name="submit" value="Add New"></td></tr>';
		
		$stmt = $this->objDB->prepare ( "SELECT faqID, faqQuestion, faqAnswer FROM faq ORDER BY faqOrder" );
		$stmt->execute ();
		
		$stmt->bind_result ($faqID, $faqQuestion, $faqAnswer );
		
		while ( $checkRow = $stmt->fetch () ) {
			
			echo '<tr><td> ' . $faqQuestion . '</td><td><button><a href="?id=faq&&moduleID=editContent&&faqID='.$faqID.'">Edit</a></button></td></tr>';
		}
		echo '</table>';
	}
	
	public function editContent() {
		
		$faqID = filter_input ( INPUT_GET, "faqID" );
		
		echo '<form method="POST" action="?id=faq&&moduleID=UpdateContent">';
		echo '<input type="hidden" name="faqID" value="' . $faqID . '">';
		
		if ($stmt = $this->objDB->prepare ( "SELECT faqQuestion, faqAnswer FROM faq WHERE faqID='$faqID' " )) {
			
			$stmt->execute ();
			$stmt->bind_result ( $faqQuestion, $faqAnswer );
			$stmt->fetch ();
			
			echo '<table border=0 cellpadding=20>';
			echo '<tr><td><h1>Frequently Asked Question: </h1></td></tr>';
			echo '<tr><td><input type="text" name="faqQuestion" value="'.$faqQuestion.'" size=70></td></tr>';
			echo '<tr><td><textarea cols=100 rows=10 name="contentMatter">' . $faqAnswer . '</textarea></td></tr>';
			echo '<tr><td><input type="submit" name="submit" value="Update"></td></tr>';
		}
		echo '</form>';
	}
	
	public function updateContent() {
		
		$contentDescription = filter_input ( INPUT_POST, 'contentMatter' );
		$contentCode = filter_input ( INPUT_POST, 'contentCode' );
		
		$stmt = $this->objDB->prepare ( "UPDATE about SET $contentCode=? WHERE aboutID=1" );
		$stmt->bind_param ( 's', $contentDescription );
		
		if ($stmt === false) {
			trigger_error ( $this->objDB->error, E_USER_ERROR );
		}
		
		$status = $stmt->execute ();
		
		if ($status === false) {
			trigger_error ( $stmt->error, E_USER_ERROR );
		}
		echo '<font color=black><b>Content Information Updated <br><br> Please Wait!!!!<br>';
		echo '<meta http-equiv="refresh" content="1;url=?id=About">';
	}
	
	public function callToFunction() {
		
		echo '<div id="faq-background">';
		echo '<div class="body-content">';
		echo '<div class="shadowWindow">';
		
		echo '<div class="whyChooseHeader">Privacy Policy</div>';
		
		$stmt = $this->objDB->prepare ( "SELECT privacyContent FROM privacy WHERE privacyID=1" );
		$stmt->execute ();
		
		$stmt->bind_result ( $privacyContent);
		
		while ( $checkRow = $stmt->fetch () ) {
			
			echo '<div class="privacy-content">' . nl2br($privacyContent). '</div>';
		}
		echo '</div></div></div>';
	}
	
	protected function assertTablesExist() {
	
		$val = mysqli_query ( $this->objDB, 'select 1 from `faq` LIMIT 1' );
		
		if ($val !== FALSE) {
		} else {
			echo 'Table Doesnt Exist....';
			
			$createTable = $this->objDB->prepare ( "CREATE TABLE faq (faqID INT(11) AUTO_INCREMENT PRIMARY KEY, faqQuestion VARCHAR(1000) NOT NULL, faqAnswer VARCHAR(2000) NOT NULL, faqOrder VARCHAR(100) NOT NULL" );
			$createTable->execute ();
			$createTable->close ();
			
			echo 'Table Created.';
		}
	}
}
