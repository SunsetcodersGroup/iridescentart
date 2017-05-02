<style>
#inclusive-background {
	width: 100%;
	clear: both;
	border-top: 15px #0a346f solid;
	border-bottom: 15px #0a346f solid;
	background-color: #fff;
	background-image: linear-gradient(left, #0050a1, #0050a1 30%, transparent 30%, transparent 100%);
	background-image: -webkit-linear-gradient(left, #0050a1, #0050a1 30%, transparent 30%, transparent 100%);

	}

#inclusive-background, .inclusive-left
{
	height: 600px;
}

.inclusive-left {
	background-color: #0050a1;
	float: left;
	width: 30%;
	text-align: right;
}

.inclusive-right {
	float: right;
	width: 60%;
	margin-top: 25px;
	height: 570px;	
}

.inclusive-header {
	width: 100%;
	text-transform: uppercase;
	color: red;
	font-size: 12pt;
	font-weight: bold;
	clear: both;
	padding: 5px;
}

.inclusive-baselinks {
	width: 100%;
	font-size: 12pt;
	clear: both;
	height: 170px;
}

.inclusive-subheader {
	width: 32%;
	float: left;
	font-size: 10pt;
	padding-right: 8px;
}

a.inclusive-download-link {
	color: red;
	text-decoration: none;
	font-size: 12pt;
	font-weight: bold;
	line-height:40px;
	margin-left: 0;
}
img.left-arrow
{
	height: 600px;
}
img.right-arrow
{
	height: 600px;
}
img.move-image-left {
	margin-left: -50px;
	height: 40px;
	vertical-align: middle;
}
</style>
<?php
require_once dirname(dirname(__FILE__)) . '/SunLibraryModule.php';

class inclusive extends SunLibraryModule
{
	protected $dbConnection;
	const ModuleDescription = 'Inclusive. <br> Database drive, left and right sides left is Image, right is Database of Services that are included.';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '0.1';
	
    function __construct($dbConnection)
    {
        parent::__construct($dbConnection);
    }

    public function inclusive()
    {

    }

    public function editContent()
    {
        $contentCode = filter_input(INPUT_GET, "ContentID");
        
        $query = "SELECT $contentCode FROM teampanel WHERE teampanelID=1 ";
        
        echo '<form method="POST" action="?id=team&&moduleID=UpdateContent">';
        echo '<input type="hidden" name="contentCode" value="' . $contentCode . '">';
        
        if ($stmt = $this->dbConnection->prepare($query)) {
            
            $stmt->execute();
            $stmt->bind_result($contentCode);
            $stmt->fetch();
            
            echo '<table border=0 cellpadding=20>';
            echo '<tr><td><h1>Content: </h1></td></tr>';
            echo '<tr><td><textarea cols=100 rows=10 name="contentMatter">' . $contentCode . '</textarea></td></tr>';
            echo '<tr><td><input type="submit" name="submit" value="Update"></td></tr>';
        }
        echo '</form>';
    }

    public function updateContent()
    {
        $contentDescription = filter_input(INPUT_POST, 'contentMatter');
        $contentCode = filter_input(INPUT_POST, 'contentCode');
        
        $stmt = $this->dbConnection->prepare("UPDATE teampanel SET $contentCode=? WHERE teampanelID=1");
        $stmt->bind_param('s', $contentDescription);
        
        if ($stmt === false) {
            trigger_error($this->dbConnection->error, E_USER_ERROR);
        }
        
        $status = $stmt->execute();
        
        if ($status === false) {
            trigger_error($stmt->error, E_USER_ERROR);
        }
        echo '<font color=black><b>Content Information Updated <br><br> Please Wait!!!!<br>';
        echo '<meta http-equiv="refresh" content="1;url=?id=Team">';
    }

    public function callToFunction()
    {
        ?>

<div id="inclusive-background">
<div class="body-content">
		<div class="inclusive-left">
			<img class="left-arrow" src="<?php echo IMAGE_PATH; ?>/inclusive.jpg" alt="">
		</div>
		<div class="inclusive-right">


                <?php
        $oldCode = NULL;
        
        $stmt = $this->objDB->prepare("SELECT inclusiveHeader, inclusiveSubheader FROM inclusive ORDER BY inclusiveHeader, inclusiveSubheader ASC");
        $stmt->execute();
        
        $stmt->bind_result($inclusiveHeader, $inclusiveSubheader);
        
        while ($checkRow = $stmt->fetch()) {
            
            if ($inclusiveHeader != $oldCode)
                echo '<div class="inclusive-header"><img class="move-image-left" src="' . IMAGE_PATH . '/smallsponge.png"  alt=""> &nbsp; ' . $inclusiveHeader . '</div>';
            
            echo '<div class="inclusive-subheader">' . $inclusiveSubheader . '</div>';
            
            $oldCode = $inclusiveHeader;
        }
        ?>
                <div class="inclusive-baselinks">
				
				<br>To see the extent of cleaning our one off cleans include, please download the relevant checklist.<br> 
				<a class="inclusive-download-link" href="#">Download our Spring Cleaning Checklist</a> <br>
				<a class="inclusive-download-link" href="#">Download our End of Lease Cleaning Checklist.</a>
			</div>
		</div>
</div>
</div>
<?php
    }
    
    protected function assertTablesExist()
    {
    	$val = mysqli_query($this->objDB, 'select 1 from `inclusive` LIMIT 1');
    	
    	if ($val !== FALSE) {} else {
    		$createTable = $this->objDB->prepare("CREATE TABLE inclusive (inclusiveID INT(11) AUTO_INCREMENT PRIMARY KEY, inclusiveHeader VARCHAR(100) NOT NULL, inclusiveSubheader VARCHAR(100) NOT NULL)");
    		$createTable->execute();
    		$createTable->close();
    	}
    }
}
