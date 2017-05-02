<style>
    #content-background
    {
        padding: 20px;
    }
    
    #webstats_window
    {
    	width: 200px;
    	border: 1px solid #000;
    	background-color: #fff;
    	border-radius: 4px;
    	margin: 15px;
    	height: 200px;
    }
    .window-header
    {
    color: #fff;
    	height: 25px;
    	line-height: 25px;
    	background-color: #333;
    	text-align: center;
    	text-transform: uppercase;
    }
    
    .browser-name
    {
    	float: left;
    	width: 120px;
    	padding: 5px;
    }
    
    .browser-numbers
    {
    	float: right;
    	padding: 5px;
    }
</style>

<?php

require_once dirname(dirname(__FILE__)) . '/SunLibraryModule.php';


class webstats extends SunLibraryModule {

    protected $dbConnection;

    function __construct($dbConnection) {
        parent::__construct($dbConnection);
    }

    public function webstats() {
    	
    	
    }
    
    public function callToFunction() {
    	
		?>
		
		<div id="webstats_window">
			<div class="window-header">Browsers</div>
	
			<?php 
			$stmt = $this->objDB->prepare("SELECT browser_type, COUNT(*) numbers FROM webstats GROUP BY browser_type");
			$stmt->execute();
			
			$stmt->bind_result($browser_type, $numbers);
			
			while ($checkRow = $stmt->fetch()) {
				
				echo '<div class="browser-name">' . $browser_type. '</div><div class="browser-numbers">' . $numbers. '</div>';
			}
			?>
	
		</div>
	
		<?php 
    }
    

}
