<style>

    #whyChoose-background
    {
        width: 100%;
        clear: both;
        height: 600px;
    }
    
    .chooseWindow
    {
        text-align: center;
        font-size: 12pt;
        width: 27%;
        float: left;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 0 35px #0250a2;
        height: 400px;
        margin-left: 7px;
        margin-right: 7px;
        padding: 25px;

    }

    .full
    {
        height: 100px;
        text-align: center;
    }


</style>

<?php
require_once dirname ( dirname ( __FILE__ ) ) . '/SunLibraryModule.php';

class whychoose  extends SunLibraryModule {

    protected $dbConnection;
    const ModuleDescription = 'Why Choose. <br> <i>Database Driven 3 Image Window Displayer with text under the images..</i>';
    const ModuleAuthor = 'Sunsetcoders Development Team.';
    const ModuleVersion = '0.1';
    
    function __construct($dbConnection) {
    	parent::__construct ( $dbConnection );
    }

    public function whychoose() {

        /*
         * This is prometheus Administrator output.
         */
    }


    public function callToFunction() {

        if ($stmt = $this->objDB->prepare("SELECT windowOne, windowOneImage, windowTwo, windowTwoImage, windowThree, windowThreeImage  FROM whyChoose WHERE whychooseID=1 ")) {

            $stmt->execute();
            $stmt->bind_result($windowOne, $windowOneImage, $windowTwo, $windowTwoImage, $windowThree, $windowThreeImage);
            $stmt->fetch();
            ?>
            <div id="whyChoose-background">
                <div class="body-content">
                    <div class="whyChooseHeader">Why Choose Us?</div>
                   <br><br> <div class="chooseWindow">
                        <img class="centerImage" src="<?php echo IMAGE_PATH . '/' . $windowOneImage; ?>" alt="">
                        <?php echo '<br>' . $windowOne; ?>
                    </div>
                    <div class="chooseWindow">
                        <img class="centerImage" src="<?php echo IMAGE_PATH . '/' . $windowTwoImage; ?>" alt="">
                        <?php echo '<br>' . $windowTwo; ?>
                    </div>
                    <div class="chooseWindow">
                        <img class="centerImage" src="<?php echo IMAGE_PATH . '/' . $windowThreeImage; ?>" alt="">
                        <?php echo '<br>' . $windowThree; ?>
                    </div>

                </div>
            </div>
            <div class="body-content">
                <div class="full"><button id="book-now">BOOK NOW</button></div>
            </div>

            <?php
        }
        echo '<div class="moduleSpacer"></div>';
    }
    
    protected function assertTablesExist() {
    	
    	$val = mysqli_query($this->objDB, 'select 1 from `whychoose` LIMIT 1');
    	
    	if ($val !== FALSE) {
    		
    	} else {
    		$createTable = $this->objDB->prepare("CREATE TABLE whychoose (whychooseID INT(11) AUTO_INCREMENT PRIMARY KEY, windowOne VARCHAR(1000) NOT NULL, windowTwo VARCHAR(1000) NOT NULL, windowThree VARCHAR(1000) NOT NULL, windowOneImage VARCHAR(100) NOT NULL, windowTwoImage VARCHAR(100) NOT NULL, windowThreeImage VARCHAR(100) NOT NULL)");
    		$createTable->execute();
    		$createTable->close();
    	}
    	
    }

}
