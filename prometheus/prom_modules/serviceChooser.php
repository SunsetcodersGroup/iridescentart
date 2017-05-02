<style>
    #chooser-background
    {
        width: 100%;
        background-color: #0050a1;
        height: 550px;
        border-top: 20px #0a3470 solid;
        border-bottom: 20px #0a3470 solid;
    }

    .chooser-select
    {

        float: left;
        width: 45%;
        height: 300px;
        text-align: center;
    }
    .chooser-display
    {
        padding: 5px;
        float: right;
        width: 45%;
        border: 3px #fff solid;
        height: 300px;
        border-radius: 10px;
    }
    .chooser-text
    {
        padding: 5px;
        font-weight: bold;
        text-align: center;
        color: #fff;
        font-size: 12pt;
        line-height: 30px;
    }


.chooser-select select
{
	width: 400px;
	border: 1px solid #fff;
	border-radius: 5px;
	margin: 8px;
	background-color: #0050a1;
	padding: 5px;
	color: #fff;
}
.chooser-select input[type="submit"]
{
        border: 3px #fff solid;
        background-color: #0050a1;
        box-shadow: 0 0 25px #0250a2;
        color: #fff;
        height: 50px;
        width: 150px;
        border-radius: 5px;
}
 
</style>
<?php

require_once dirname ( dirname ( __FILE__ ) ) . '/SunLibraryModule.php';

class serviceChooser  extends SunLibraryModule {

    protected $dbConnection;
    const ModuleDescription = 'Service Chooser. <br> <i>Service Chooser, which links to the booking section.</i>';
    const ModuleAuthor = 'Sunsetcoders Development Team.';
    const ModuleVersion = '0.1';
    
    function __construct($dbConnection) {
    	parent::__construct ( $dbConnection );
    }
    public function serviceChooser() {

        /*
         * This is prometheus Administrator output.
         */
    }

    public function callToFunction() {
        ?>
          <div id="chooser-background">
            <div class="body-content">
  				<div class="whyChooseHeader">FIND YOUR SERVICE</div>        
                <div class="chooser-text">So we can recommend the best home-making<br>service for you, please tell us about your residence.</div>
          
          <br><br>
                <div class="chooser-select">
					<form method="POST" action="../../ajax.php" target="chooser-display">
                    
                    <select name="chooseType" required>
                        <option value="">TYPE OF RESIDENCE</option>
                        <option value="Appartment">APPARTMENT</option>
                        <option value="House">HOUSE</option>
                    </select>

                    <br>

                    <select name="chooseBed" required>
                        <option value="">NO. OF BEDROOMS</option>
                        <option value="1">1 BEDROOM</option>
                        <option value="2">2 BEDROOMS</option>
                        <option value="3">3 BEDROOMS</option>
                        <option value="4">4 BEDROOMS</option>
                        <option value="5">5 BEDROOMS</option>
                    </select>
                    <br>
                    <select name="chooseBath" required>
                        <option value="">NO. OF BATHROOMS</option>
                        <option value="1">1 BATHROOM</option>
                        <option value="2">2 BATHROOMS</option>
                        <option value="3">3 BATHROOMS</option>
                    </select>
                    <br>
                    <select name="chooseOther" required>
                        <option value="">NO. OF OTHER ROOMS</option>
                        <option value="1">1 OTHER ROOM</option>
                        <option value="2">2 OTHER ROOMS</option>
                        <option value="3">3 OTHER ROOMS</option>
                        <option value="4">4 OTHER ROOMS</option>
                        <option value="5">5 OTHER ROOMS</option>
                    </select>
                    <br>
                    <select name="chooseFrequency" required>
                        <option value="">FREQUENCY</option>
                        <option value="once">ONCE OFF</option>
                        <option value="weekly">WEEKLY</option>
                        <option value="fortnightly">FORTNIGHTLY</option>
                        <option value="monthly">MONTHLY</option>
                    </select>
       				<br><br> <input type="submit" name="submit" value="Estimate">
        			</form>
                </div>
                <div class="dd">
					<iframe name="chooser-display" src="../../ajax.php" width="500" height="300" frameborder=0 scrolling="no"></iframe>
				</div>
            </div>
            
        </div>
		
        <?php
    }
    
    protected function assertTablesExist() {

    	$val = mysqli_query($this->objDB, 'select 1 from `servicechooser` LIMIT 1');
    	
    	if ($val !== FALSE) {
    		
    	} else {
    		$createTable = $this->objDB->prepare("CREATE TABLE servicechooser (servicechooserID INT(11) AUTO_INCREMENT PRIMARY KEY, chooseType VARCHAR(100) NOT NULL, chooseBed VARCHAR(100) NOT NULL, chooseBath VARCHAR(100) NOT NULL, chooseOther VARCHAR(100) NOT NULL, chooseFrequency VARCHAR(100) NOT NULL)");
    		$createTable->execute();
    		$createTable->close();
    	}
    	
    }
    

}
