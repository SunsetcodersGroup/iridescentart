<?php

$dbConnection = databaseConnection();
$dbSecondary = secondaryConnection();
/*
 * Make sure header.php exists
 * if so use it as a header in the website
 */

function get_head() {
    $filename = 'header.php';

    if (file_exists($filename)) {
        include_once (dirname(__FILE__) . '/' . $filename);
    }
}

/*
 * Make sure footer.php exists
 * if so use it as a footer in the website
 */

function get_foot() {
    $filename = 'footer.php';

    if (file_exists($filename)) {
        include_once (dirname(__FILE__) . '/' . $filename);
    }
}

function call_page() {

    global $dbConnection;
    unset($getPageName);

    $page = $_SERVER['REQUEST_URI'];
    $halfValue = explode('.php/', $page);

    if (!empty($halfValue[1])) {
        $getPageName = $halfValue[1];
    }

    $pageName = (empty($getPageName)) ? "Home" : $getPageName;

    if(mysqli_query($dbConnection,"DESCRIBE  pages ")){
    
    	
    	$pageRef = $dbConnection->prepare("SELECT pages.pageID, moduleCode FROM pages INNER JOIN page_settings ON pages.pageID=page_settings.pageID && pageName='$pageName' ORDER BY rowID ");
    	$pageRef->execute();
    	$pageRef->bind_result($pageID, $moduleCode);
    	
    	while ($checkRow = $pageRef->fetch()) {

    		call_to_module($moduleCode);
    	}
    	
    	
    }else{
    	echo 'Dead Wood';
    }
}

function call_to_module($moduleName) {

    global $dbTriConnection;
    global $dbSecondary;
    $contentEditor = 0;

    $stmt = $dbSecondary->prepare("SELECT contentCode FROM content_editor ORDER BY contentID");
    $stmt->execute();

    $stmt->bind_result($contentCode);
   
    while ($checkRow = $stmt->fetch()) {

        if ($moduleName == (substr($contentCode, 1, -1))) {
            $contentEditor ++;
        }
    }

    if ($contentEditor == 1) {
        
        $_SESSION['contentString'] = '[' . $moduleName . ']';

        include_once ("prometheus/prom_content/prom_content.php");
        
        $moduleClass = new content_editor($dbSecondary);
        $moduleClass->callToFunction();
        
    } else {

        if ($stmt = $dbSecondary->prepare("SELECT settingsFilename FROM settings WHERE settingsName=?")) {

            $stmt->bind_param('s', $moduleName);
            $stmt->execute();

            $stmt->bind_result($settingsFilename);
            $stmt->fetch();

            $filepath = 'prometheus/prom_modules/' . $settingsFilename;

            include_once ($filepath);

            $moduleClass = new $moduleName($dbTriConnection);
            $moduleClass->callToFunction();

        }
    }
}
