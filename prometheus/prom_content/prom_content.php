<style>
    #content-background
    {
        padding: 20px;
    }
</style>

<?php

require_once dirname(dirname(__FILE__)) . '/SunLibraryModule.php';


class content_editor extends SunLibraryModule {

    protected $dbConnection;

    function __construct($dbConnection) {
        parent::__construct($dbConnection);
    }

    public function content_editor() {

        echo '<table border=0 cellpadding=15 width=50% cellspacing=0>';
        echo '<tr><td colspan=3><h2>Content Management Panel</h2></td></tr>';
        echo '<tr><td colspan=3><button><a href="?id=Content&&moduleID=addContentBox">Add New</a></button></td></tr>';
        echo '<tr><td class="headerMenu">Content Body</td><td class="headerMenu">Content Code</td><td class="headerMenu"></td></tr>';

        $stmt = $this->objDB->prepare("SELECT contentID, contentBody, contentCode FROM content_editor ORDER BY contentID");
        $stmt->execute();

        $stmt->bind_result($contentID, $contentBody, $contentCode);

        while ($checkRow = $stmt->fetch()) {

            echo '<tr><td>' . $contentBody . '</td><td width=180>' . $contentCode . '</td><td width=80><a href="?id=Content&&moduleID=editContent&&ContentID=' . $contentID . '">edit</a></td></tr>';
        }
        echo '</table>';
    }

    public function addContentBox() {

        echo '<form method="POST" action="?id=Content&&moduleID=uploadContent">';
        echo '<table border=1 cellpadding=10 width=50%>';
        echo '<tr><td colspan=3><h2>Content Management Panel</h2></td></tr>';
        echo '<tr><td></td></tr>';
        echo '<tr><td class="headerMenu">Content Code</td></tr>';
        echo '<tr><td><b>[ Content-<input type="text" name="contentCode"> ]</td></tr>';
        echo '<tr><td></td></tr>';
                echo '<tr><td><b>Color: <input type="text" name="contentBackground" placeholder="enter background color" size="30"> </td></tr>';
        echo '<tr><td></td></tr>';
                echo '<tr><td><b>Height: <input type="text" name="contentHeight" placeholder="enter background height" size="30"></td></tr>';
        echo '<tr><td></td></tr>';
        echo '<tr><td class="headerMenu">Content Body</td></tr>';

        echo '<tr><td><textarea name="contentBody" rows="10" cols="150"></textarea></td></tr>';
        echo '<tr><td></td></tr>';
        echo '<tr><td><input type="Submit" name="Submit" value="Submit"></td></tr>';
        echo '</table>';
        echo '</form>';
    }

    public function uploadContent() {

        $contentDescription = filter_input(INPUT_POST, 'contentBody');
        $contentCode = '[Content-' . filter_input(INPUT_POST, 'contentCode') . ']';

        $stmt = $this->objDB->prepare("INSERT INTO `content_editor` ( `contentBody`, `contentCode`) VALUES (?,?)");
        $stmt->bind_param('ss', $contentDescription, $contentCode);

        if ($stmt === false) {
            trigger_error($this->objDB->error, E_USER_ERROR);
        }

        $status = $stmt->execute();

        if ($status === false) {
            trigger_error($stmt->error, E_USER_ERROR);
        }
        echo '<font color=black><b>Content Information Updated <br><br> Please Wait!!!!<br>';
        echo '<meta http-equiv="refresh" content="1;url=?id=Content">';
    }

    public function editContent() {

        $contentID = filter_input(INPUT_GET, "ContentID");

        echo '<form method="POST" action="?id=Content&&moduleID=UpdateContent">';
        echo '<input type="hidden" name="contentID" value="' . $contentID . '">';

        if ($stmt = $this->objDB->prepare("SELECT contentBody FROM content_editor WHERE contentID=? ")) {

            $stmt->bind_param('i', $contentID);
            $stmt->execute();
            $stmt->bind_result($contentBody);
            $stmt->fetch();

            echo '<table border=0 cellpadding=20>';
            echo '<tr><td><h2>Content: </h2></td></tr>';
            echo '<tr><td><textarea cols=100 rows=10 name="contentMatter">' . $contentBody . '</textarea></td></tr>';
            echo '<tr><td><input type="submit" name="submit" value="Update"></td></tr>';
        }
        echo '</form>';
    }

    public function updateContent() {

        $contentDescription = filter_input(INPUT_POST, 'contentMatter');
        $contentID = filter_input(INPUT_POST, 'contentID');

        $stmt = $this->objDB->prepare("UPDATE content_editor SET contentBody=? WHERE contentID=?");
        $stmt->bind_param('si', $contentDescription, $contentID);

        if ($stmt === false) {
            trigger_error($this->objDB->error, E_USER_ERROR);
        }

        $status = $stmt->execute();

        if ($status === false) {
            trigger_error($stmt->error, E_USER_ERROR);
        }
        echo '<font color=black><b>Content Information Updated <br><br> Please Wait!!!!<br>';
        echo '<meta http-equiv="refresh" content="1;url=?id=Content">';
    }

    public function callToFunction() {

        if ($stmt = $this->objDB->prepare("SELECT contentBody, contentBackground, contentHeight FROM content_editor WHERE contentCode=?")) {

            $stmt->bind_param('s', $_SESSION['contentString']);
            $stmt->execute();
            $stmt->bind_result($contentBody, $contentBackground, $contentHeight);
            $stmt->fetch();

            echo '<div id="content-background" style="background-color: #'.$contentBackground.'; height: '.$contentHeight.';">';
            
            echo '<div class="body-content">';

            echo nl2br($contentBody);

            echo '</div>';
            echo '</div>';
        }
    }

    protected function assertTablesExist() {
        
        $val = mysqli_query($this->objDB, 'select 1 from `content_editor` LIMIT 1');

        if ($val !== FALSE) {
            
        } else {
            $createTable = $this->objDB->prepare("CREATE TABLE content_editor (contentID INT(11) AUTO_INCREMENT PRIMARY KEY, contentBody VARCHAR(100) NOT NULL, contentCode VARCHAR(100) NOT NULL)");
            $createTable->execute();
            $createTable->close();
        }
    }

}
