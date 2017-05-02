<style>
#contactlevel-background {
	clear: both;
	width: 100%;
	height: 750px;
	border-bottom: 5px #0a346f solid;
	border-top: 10px #0a346f solid;
	text-align: center;
}

.contactlevel-header {
	text-align: center;
	font-weight: bold;
	height: 60px;
}

#mytextarea {
	
	font-family: 'Reem Kufi', sans-serif;
	resize: none;
}


h1 {
	color: red;
	font-size: 18pt;
}

#send-form {
	border: 3px #fff solid;
	background-color: #0050a1;
	box-shadow: 0 0 25px #0250a2;
	color: #fff;
	height: 50px;
	width: 150px;
	border-radius: 5px;
	
}

::-webkit-input-placeholder { /* Chrome */
	color: #000;
}
:-ms-input-placeholder { /* IE 10+ */
	color: #000;
}
::-moz-placeholder { /* Firefox 19+ */
	color: #000;
  opacity: 1;
}
:-moz-placeholder { /* Firefox 4 - 18 */
	color: #000;
  opacity: 1;
}

.contactlevel-contactform select
{
width: 622px;
height: 40px;
	border-radius: 5px;
	border: 1px solid #000;
	color: #000;
	margin: 12px;
	padding: 10px 0px 10px 10px;
}
 .contactlevel-contactform input[type="text"], #mytextarea{
	width: 610px;
	border-radius: 5px;
	border: 1px solid #000;
	color: #000;
	margin: 12px;
	padding: 10px 0px 10px 10px;
}

.bubble-image
{
float: left;
width: 250px;
}

.contact-form
{
 width:770px;
}
</style>

<?php
require_once dirname ( dirname ( __FILE__ ) ) . '/SunLibraryModule.php';

class contactlevel extends SunLibraryModule {

	protected $dbConnection;
	
	const ModuleDescription = 'ContactLevel. <br> Contact form.';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '0.1';
	
	function __construct($dbConnection) {
		parent::__construct ( $dbConnection );
	}
	
	public function contactlevel() {
	}
	

	public function callToFunction() {
		?>
<span class="lineOut" id="Contact"></span>
<div id="contactlevel-background">
<br><br>
	<div class="body-content">
		<div class="whyChooseHeader">CONTACT US</div>
		<div class="contactlevel-header">
			Contact our team to discuss your cleaning needs, <br>or make a
			booking using the form below.
		</div>
		<div class="contactlevel-contactform">
			<form method="POST" action="contactlevel">
				<input type="text" placeholder="Name" required> 
				<input type="text" placeholder="Email" required><br> 
				<select name="service" required>
					<option value="">Please Select Service</option>
					<option>Homely Help Weekly Cleaning</option>
					<option>Homely Feel Fortnightly Cleaning</option>
					<option>Spring Clean</option>
					<option>Deep Clean</option>
					<option>End of Lease Clean + Carpets</option>
					<option>End of Lease Clean + Carpets + Pest</option>
				</select>
				<br> 
				<input type="text" placeholder="Contact Number" required>

				<textarea id="mytextarea" name="comments" cols="10" rows="8"
					placeholder="Comments/Questions" required></textarea>
				<br> 
				<input type="submit" value="SEND" id="send-form">
			</form>
		</div>
	</div>
</div>


<?php
	}
	protected function assertTablesExist() {
		$val = mysqli_query ( $this->objDB, 'select 1 from `contactlevel` LIMIT 1' );
		
		if ($val !== FALSE) {
		} else {
			
			$createTable = $this->objDB->prepare ( "CREATE TABLE contactlevel (contactID INT(11) AUTO_INCREMENT PRIMARY KEY, contact VARCHAR(100) NOT NULL, sliderOrder DECIMAL(3,0) NOT NULL)" );
			$createTable->execute ();
			$createTable->close ();
		}
	}
}
