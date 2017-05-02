<?php

function appearence() {
    ?>

    <div>

        Appearence List

    </div>

    <?php
}

function media()
{
    echo 'Media Part';
    
}

function stylesheet() {
    
    $styleSheet = file_get_contents('../css/style.css');
    ?>
    <form method="POST" action="?id=Settings&&moduleID=updateStylesheet">
        <div><textarea name="newStyleSheet" style="width: 80%; height: 600px; frameborder: 0; resize: no;" >
    <?php echo strip_tags($styleSheet); ?>
            </textarea>
        </div>
        <input type="submit" name="submit" value="Update">
    </form>

    <?php
}

function updateStylesheet() {
    
    $updatedStyle = filter_input(INPUT_POST, "newStyleSheet");

    $file = fopen("../../css/style.css", "w");
    $cssContent = $updatedStyle;
    fwrite($file, $cssContent);
    fclose($file);

    echo '<br><br><br><center><font color=black><b>Please Wait!!!!';
    echo '<meta http-equiv="refresh" content="1;url=index.php">';
}


function showModules() {
	
    global $dbConnection;
	$moduleID = filter_input(INPUT_GET, "moduleID");
    ?>
    
    <div class="loadModule"><a href="?id=Modules&&moduleID=newModules">Add New Module</a></div>
    
    
    <?php 
    
    if ($moduleID == "newModules")
    {
    	echo '<iframe id="frame-window" src="http://www.sunsetcodersgroup.tk/ModuleList/modules.php" height=100 rows=100>Hello</iframe>';
    	
    } else  {
    	
    if ($handle = opendir('prom_modules/')) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != ".." && $entry != "auth.css") {

                $moduleName = substr($entry, 0, - 4);
                $lowerCaseModuleName = strtolower($entry);
				include ('prom_modules/'.$entry);
                				
                echo '<div class="moduleBox">';
                
                echo '<div class="module-header">' . $moduleName . '</div>';
                echo '<div class="module-body"><br>'.$moduleName::ModuleDescription.'</div>';
                
                if ($stmt = $dbConnection->prepare("SELECT settingsFilename FROM settings WHERE settingsFilename=? ")) {

                    $stmt->bind_param("s", $entry);
                    $stmt->execute();

                    $stmt->bind_result($settingsFilename);
                    $stmt->fetch();

                    if ($settingsFilename) {
                        echo '<div class="module-activation"><a class="redLink" href="?id=Modules&&moduleID=DeactivateModule&&moduleName=' . $moduleName . '">Deactivate</a></div>';
                    } else {
                        echo '<div class="module-activation"><a class="greenLink" href="?id=Modules&&moduleID=ActivateModule&&moduleName=' . $moduleName . '">Activate</a></div>';
                    }
                }
                unset($stmt,$settingsFilename);
                echo '</div>';
            }
        }
        closedir($handle);
    }
    }
}

function activeModule() {

    global $dbConnection;

    $getModuleName = filter_input(INPUT_GET, 'moduleName');
    $getFileName = filter_input(INPUT_GET, 'moduleName');
    $setFileName = $getFileName . '.php';

    $moduleActivation = $dbConnection->prepare("INSERT INTO settings (settingsName, settingsFilename) VALUES (?,?)");
    $moduleActivation->bind_param('ss', $getModuleName, $setFileName);

    $status = $moduleActivation->execute();

    echo '<br><br><br>You have successfully Activated this module<br><br><font color=black><b>Please Wait!!!!';
    echo '<meta http-equiv="refresh" content="3;url=?id=Modules">';
}

function deactivateModule() {

    global $dbConnection;
    
    $getModuleName = filter_input(INPUT_GET, 'moduleName');

    $deleteRef = $dbConnection->prepare("DELETE FROM settings WHERE settingsName=?");
    $deleteRef->bind_param('s', $getModuleName);

    $status = $deleteRef->execute();

    echo '<br><br><br>You have successfully Deactivated This Module<br><br><font color=black><b>Please Wait!!!!';
    echo '<meta http-equiv="refresh" content="3;url=?id=Modules">';
}

function modules() {

    $setGetModuleID = filter_input(INPUT_GET, 'moduleID');
    $setPostModuleID = filter_input(INPUT_POST, 'moduleID');

    $localAction = NULL;

    if (isset($setPostModuleID)) {
        $localAction = $setPostModuleID;
    } elseif (isset($setGetModuleID)) {
        $localAction = urldecode($setGetModuleID);
    }

    Switch (strtoupper($localAction)) {

        case "ACTIVATEMODULE" :
            activeModule();
            break;
        case "DEACTIVATEMODULE" :
            deactivateModule();
            break;
        default :
            showModules();
    }
}
