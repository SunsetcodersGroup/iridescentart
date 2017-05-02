<style>
    .txtContent
    {

    }

    .quartBox
    {
        height: 420px;
        text-align: center;
        float: left;
        width: 28%;
        margin: 11px;
        background-color: #fff;
        border: 1px #ccc solid;
        border-radius: 15px;
        padding: 15px;
        box-shadow: 0 0 25px #0250a2;
    }

    #bookService
    {
        border: 3px #fff solid;
        background-color: #0050a1;
        box-shadow: 0 0 25px #0250a2;
        color: #fff;
        height: 50px;
        width: 150px;
        border-radius: 5px;
    }
    
    .fullBox
    {
        height: 430px;
        clear: both;
         text-align: center;
        float: left;
        width: 97%;
        margin-top: 40px;
        background-color: #fff;
        border: 1px #ccc solid;
        border-radius: 15px;
        padding: 15px;
        box-shadow: 0 0 25px #0250a2;
    }
    .centerToBox
    {
        text-align: center;
    }
    .service-background
    {
    	padding: 40px;
    	height: 1000px;
    	
    }
    
    #rotatedImage {
    -webkit-animation: rotation 3s infinite linear;
}

@-webkit-keyframes rotation {
    from {-webkit-transform: rotate(0deg);}
    25% {-webkit-transform: rotate(35deg);}
    50% {-webkit-transform: rotate(-35deg);}
    75% {-webkit-transform: rotate(35deg);}
    to   {-webkit-transform: rotate(0deg);}
}

</style>

<?php
$dbTriConnection = databaseConnection();

$val = mysqli_query($dbTriConnection, 'select 1 from `services` LIMIT 1');

if ($val !== FALSE) {
    
} else {
    echo 'Table Doesnt Exist....';

    $createTable = $dbTriConnection->prepare("CREATE TABLE services (serviceID INT(11) AUTO_INCREMENT PRIMARY KEY, iconSetOne VARCHAR(100) NOT NULL, pointSetOne VARCHAR(2000) NOT NULL, iconSetTwo VARCHAR(100) NOT NULL, pointSetTwo VARCHAR(2000) NOT NULL, iconSetThree VARCHAR(100) NOT NULL, pointSetThree VARCHAR(2000) NOT NULL, teamImage VARCHAR(100) NOT NULL, teamContent VARCHAR(2000) NOT NULL)");
    $createTable->execute();
    $createTable->close();

    echo 'Table Created.';
}

class services {

    protected $dbConnection;
    const ModuleDescription = 'Services. <br> <i>Database Driven, Services List..</i>';
    const ModuleAuthor = 'Sunsetcoders Development Team.';
    const ModuleVersion = '0.1';
    
    function __construct($dbConnection) {

        $this->dbConnection = $dbConnection;
    }

    public function services() {

        echo '<table width=100%>';

        if ($stmt = $this->dbConnection->prepare("SELECT serviceBanner1, serviceBanner2, serviceBanner3, serviceBanner4, serviceBanner5, serviceIcon1, servicePoint1, serviceIcon2, servicePoint2, serviceIcon3, servicePoint3, serviceIcon4, servicePoint4 FROM services WHERE serviceID=1 ")) {

            $stmt->execute();
            $stmt->bind_result($serviceBanner1, $serviceBanner2, $serviceBanner3, $serviceBanner4, $serviceBanner5, $serviceIcon1, $servicePoint1, $serviceIcon2, $servicePoint2, $serviceIcon3, $servicePoint3, $serviceIcon4, $servicePoint4);
            $stmt->fetch();

            echo '<tr><td colspan=2>&nbsp;</td></tr>';
            echo '<tr><td colspan=2 bgcolor=999999 style="color: white; height: 20px;"><b>Banner Information</b></td></tr>';
            echo '<tr><td class="txtContent" width=20>1:</td><td class="txtContent"><a href="?id=Services&&moduleID=EditImage&&ImageID=Banner1">' . $serviceBanner1 . '</a></td></tr>';
            echo '<tr><td class="txtContent">2:</td><td class="txtContent"><a href="?id=Services&&moduleID=EditImage&&ImageID=Banner2">' . $serviceBanner2 . '</td></tr>';
            echo '<tr><td class="txtContent">3:</td><td class="txtContent"><a href="?id=Services&&moduleID=EditImage&&ImageID=Banner3">' . $serviceBanner3 . '</td></tr>';
            echo '<tr><td class="txtContent">4:</td><td class="txtContent"><a href="?id=Services&&moduleID=EditImage&&ImageID=Banner4">' . $serviceBanner4 . '</td></tr>';
            echo '<tr><td class="txtContent">5:</td><td class="txtContent"><a href="?id=Services&&moduleID=EditImage&&ImageID=Banner5">' . $serviceBanner5 . '</td></tr>';

            echo '<tr><td colspan=2>&nbsp;</td></tr>';
            echo '<tr><td colspan=2 bgcolor=999999 style="color: white; height: 20px;"><b>Icon Information</b></td></tr>';
            echo '<tr><td class="txtContent">1:</td><td class="txtContent"><a href="?id=Services&&moduleID=EditImage&&ImageID=serviceIcon1">' . $serviceIcon1 . '</td></tr>';
            echo '<tr><td class="txtContent">2:</td><td class="txtContent"><a href="?id=Services&&moduleID=EditImage&&ImageID=serviceIcon2">' . $serviceIcon2 . '</td></tr>';
            echo '<tr><td class="txtContent">3:</td><td class="txtContent"><a href="?id=Services&&moduleID=EditImage&&ImageID=serviceIcon3">' . $serviceIcon3 . '</td></tr>';
            echo '<tr><td class="txtContent">4:</td><td class="txtContent"><a href="?id=Services&&moduleID=EditImage&&ImageID=serviceIcon4">' . $serviceIcon4 . '</td></tr>';

            echo '<tr><td colspan=2>&nbsp;</td></tr>';
            echo '<tr><td colspan=2 bgcolor=999999 style="color: white; height: 20px;"><b>Point Information</b></td></tr>';
            echo '<tr><td class="txtContent">1:</td><td class="txtContent"><a href="?id=Services&&moduleID=EditContent&&ContentID=servicePoint1">' . $servicePoint1 . '</td></tr>';
            echo '<tr><td class="txtContent">2:</td><td class="txtContent"><a href="?id=Services&&moduleID=EditContent&&ContentID=servicePoint2">' . $servicePoint2 . '</td></tr>';
            echo '<tr><td class="txtContent">3:</td><td class="txtContent"><a href="?id=Services&&moduleID=EditContent&&ContentID=servicePoint3">' . $servicePoint3 . '</td></tr>';
            echo '<tr><td class="txtContent">4:</td><td class="txtContent"><a href="?id=Services&&moduleID=EditContent&&ContentID=servicePoint4">' . $servicePoint4 . '</td></tr>';
        }
        echo '</table>';
    }

    public function editImage() {

        $contentCode = filter_input(INPUT_GET, "ImageID");

        $query = "SELECT $contentCode FROM teampanel WHERE teampanelID=1 ";

        echo '<form action="?id=team&&moduleID=UpdateImage" method="post" enctype="multipart/form-data">';
        echo '<input type="hidden" name="contentCode" value="' . $contentCode . '">';

        if ($stmt = $this->dbConnection->prepare($query)) {

            $stmt->execute();
            $stmt->bind_result($contentCode);
            $stmt->fetch();

            echo '<table border=0 cellpadding=20>';
            echo '<tr><td><h1>Image Information: </h1></td></tr>';
            echo '<tr><td><img src="../Images/' . $contentCode . '"></td></tr>';
            echo '<tr><td><input type="hidden" name="MAX_FILE_SIZE" value="100000" /></td></tr>';
            echo '<tr><td>Choose a replacement image to upload: <br> <input type="file" name="fileToUpload" id="fileToUpload"></td></tr>';
            echo '<tr><td><input type="submit" name="submit" value="Update"></td></tr>';
        }
        echo '</form>';
    }

    public function updateImage() {

        $target_dir = "../Images/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $target_filename = basename($_FILES["fileToUpload"]["name"]);

        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";

            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        /*
         * Update Teampanel Database with the new Image information.
         */

        $contentImageName = $target_filename;
        $contentCode = filter_input(INPUT_POST, 'contentCode');

        $stmt = $this->dbConnection->prepare("UPDATE services SET $contentCode=? WHERE serviceID=1");
        $stmt->bind_param('s', $contentImageName);

        if ($stmt === false) {
            trigger_error($this->dbConnection->error, E_USER_ERROR);
        }

        $status = $stmt->execute();

        if ($status === false) {
            trigger_error($stmt->error, E_USER_ERROR);
        }
        echo '<font color=black><b>Content Image Information Updated <br><br> Please Wait!!!!<br>';
        echo '<meta http-equiv="refresh" content="1;url=?id=Services">';
    }

    public function editContent() {

        $contentCode = filter_input(INPUT_GET, "ContentID");

        $query = "SELECT $contentCode FROM services WHERE serviceID=1 ";

        echo '<form method="POST" action="?id=Services&&moduleID=UpdateContent">';
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

    public function updateContent() {

        $contentDescription = filter_input(INPUT_POST, 'contentMatter');
        $contentCode = filter_input(INPUT_POST, 'contentCode');

        $stmt = $this->dbConnection->prepare("UPDATE services SET $contentCode=? WHERE serviceID=1");
        $stmt->bind_param('s', $contentDescription);

        if ($stmt === false) {
            trigger_error($this->dbConnection->error, E_USER_ERROR);
        }

        $status = $stmt->execute();

        if ($status === false) {
            trigger_error($stmt->error, E_USER_ERROR);
        }
        echo '<font color=black><b>Content Information Updated <br><br> Please Wait!!!!<br>';
        echo '<meta http-equiv="refresh" content="1;url=?id=Services">';
    }

    public function callToFunction() {

        if ($stmt = $this->dbConnection->prepare("SELECT serviceBanner1, serviceBanner2, serviceBanner3, serviceBanner4, serviceBanner5, serviceIcon1, servicePoint1, serviceIcon2, servicePoint2, serviceIcon3, servicePoint3, serviceIcon4, servicePoint4 FROM services WHERE serviceID=1 ")) {

            $stmt->execute();
            $stmt->bind_result($serviceBanner1, $serviceBanner2, $serviceBanner3, $serviceBanner4, $serviceBanner5, $serviceIcon1, $servicePoint1, $serviceIcon2, $servicePoint2, $serviceIcon3, $servicePoint3, $serviceIcon4, $servicePoint4);
            $stmt->fetch();
            ?>
            <span class="lineOut" id="Services"></span>
            <div class="whyChooseHeader">OUR SERVICES</div>
            <div class="service-background">
            <div class="body-content">
                <div class="quartBox">
                    <div><img id="rotatedImage" src="<?php echo IMAGE_PATH . '/' . $serviceIcon1; ?>" alt=""></div>
                    <div class="centerToBox"><?php echo nl2br($servicePoint1); ?></div>
                    <div class="centerToBox"><br><button id="bookService">BOOK NOW</button></div>
                </div>
                <div class="quartBox">
                    <div><img id="rotatedImage" src="<?php echo IMAGE_PATH . '/' . $serviceIcon2; ?>" alt=""></div>
                    <div class="centerToBox"><?php echo nl2br($servicePoint2); ?></div>
                    <div class="centerToBox"><br><button id="bookService">BOOK NOW</button></div>
                </div>   
                <div class="quartBox">
                    <div><img id="rotatedImage" src="<?php echo IMAGE_PATH . '/' . $serviceIcon3; ?>" alt=""></div>
                    <div class="centerToBox"><?php echo nl2br($servicePoint3); ?></div>
                    <div class="centerToBox"><br><button id="bookService">BOOK NOW</button></div>
                </div>  
                
                <div class="fullBox">
                    <div><img id="rotatedImage" src="<?php echo IMAGE_PATH . '/' . $serviceIcon4; ?>" alt=""></div>
                    <div class="centerToBox"><?php echo nl2br($servicePoint4); ?></div>
                    <div class="centerToBox"><br><button id="bookService">BOOK NOW</button></div>
                </div>   
            </div>
            </div>
            <?php
        }
    }

}
