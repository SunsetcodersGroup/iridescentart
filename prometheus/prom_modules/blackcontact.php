<style>
#contact-background
{
	height: 550px;
	clear: both;
		text-align: center;
}
.contact-header
{
	height: 100px;
	line-height: 100px;
	color: #fff;
	text-align: center;
	font-size: 20pt;
}
.contact-subheader
{
text-align: center;
	height: 75px;
	line-height: 75px;
	color: #fff;
}

.contact-left-input
{
	float: left;
	width: 300px;
}

.contact-middle-input
{
	float: left;
	width: 300px;
	margin-left: 40px;
}

.contact-right-input
{
	float: right;
	width: 300px;
}
.contact-input
{
	margin: 0 auto;
	width: 1000px;
	height: 50px;
}

.contact-input input[type=text]
{
	width: 300px;

	
}

.contact-body textarea
{
	width: 1000px;
}

.contact-middle-input input[type=text], .contact-right-input input[type=text], .contact-left-input input[type=text], .contact-body textarea
{
	background-color: #212121;
	font-size: 8pt;
	color: #e1e1e1;
	border: 0;
	resize: none;
	padding: 10px;
	border-radius: 4px;
}
.contact-body
{
	text-align: center;
	height: 200px;
}
.contact-button
{
	height: 50px;
	text-align: center;
}

.contact-button input[type=submit]
{
	background-color: #212121;
	width: 100px;
	height: 40px;
	color: #e1e1e1;
	border: 0;
	border-radius: 4px;
}
</style>

<?php
$dbTriConnection = databaseConnection ();


require_once dirname ( dirname ( __FILE__ ) ) . '/SunLibraryModule.php';

class blackcontact extends SunLibraryModule {
	
	protected $dbConnection;
	
	const ModuleDescription = '5 Image Database Driver Slider.';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '0.1';
	
	function __construct($dbConnection) {
		parent::__construct ( $dbConnection );
	}
	public function blackcontact() {
		
		/*
		 * This is prometheus Administrator output.
		 */
	}
	
	public function callToFunction() {

	?>
		<div class="body-content">
		<div class="contact-background">
			<div class="contact-header">Enquires</div>
			<div class="contact-subheader">fill in the following contact form to ask questions about anything inquries u have.</div>
			
			<div class="contact-input">	
				<div class="contact-left-input"><input type="text" name="name" placeholder="Name"></div>
				<div class="contact-middle-input"><input type="text" name="email" placeholder="Email"></div>
				<div class="contact-right-input"><input type="text" name="phone" placeholder="Phone"></div>
			</div>
			
			<div class="contact-body"><textarea rows="10" placeholder="Message"></textarea></div>
			<div class="contact-button"><input type="submit" name="submit" value="Send"></div>
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
