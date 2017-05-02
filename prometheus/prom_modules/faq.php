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
a.faq-hyperlink
{
color: #F00;
margin: 0;
}

a.faq-hyperlink:hover
{
color: #F00;
}
</style>

<?php
$dbTriConnection = databaseConnection ();

require_once dirname ( dirname ( __FILE__ ) ) . '/SunLibraryModule.php';

class faq extends SunLibraryModule {
	
	const ModuleDescription = 'Frequent Asked Questions. <br><br> Frequently Asked Question display screen content.';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '0.1';
	
	function __construct($dbTriConnection) {
		parent::__construct ( $dbTriConnection );
	}
	
	public function faq() {
		
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
	
	public function callToFunction() {
	
		?>
		<div id="faq-background">
			<div class="body-content">
				<div class="shadowWindow">
					<div class="whyChooseHeader">Frequently Asked Questions</div>
		
					<?php 
					$stmt = $this->objDB->prepare ( "SELECT faqQuestion, faqAnswer FROM faq ORDER BY faqOrder" );
					$stmt->execute ();
		
					$stmt->bind_result ( $faqQuestion, $faqAnswer );
		
					while ( $checkRow = $stmt->fetch () ) {
			
						echo '<div class="faq-question"> <img class="bubble-image" src="../Images/bubbles.png"> ' . $faqQuestion . '</div>';
						echo '<div class="faq-answer">' . $faqAnswer . '</div>';
					}
					?>
				</div>
			</div>
		</div>
		
		<?php 
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
