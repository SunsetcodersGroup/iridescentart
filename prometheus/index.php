<?php
require_once dirname ( dirname ( __FILE__ ) ) . '/auth.php';

echo '<link rel="stylesheet" type="text/css" href="prometheus.css">';
foreach ( glob ( "prom_content/*.php" ) as $filename ) {
	require_once $filename;
}

$dbConnection = databaseConnection ();

$authClass = new prometheus ( $dbConnection );
$authClass->landingPage ();
class prometheus {
	protected $dbConnection;
	private $setPostID;
	private $setGetID;
	function __construct($dbConnection) {
		$this->dbConnection = $dbConnection;
		
		$this->setPostID = filter_input ( INPUT_POST, 'id' );
		$this->setGetID = filter_input ( INPUT_GET, 'id' );
		
		if ($this->setGetID == "processLogin") {
			processLogin ();
			exit ();
		}
		
		if (! is_admin ()) {
			loginScreen ();
			exit ();
		}
	}
	public function landingPage() {
		?>

    	<div id="profileClass"><img class="header-image" src="Images/logo.png" width=200px></div>

		<div id="bodyClass">
			<?php echo $this->switchMode(); ?>			
		</div>

		<div id="modulesnippet">
			<?php echo $this->fixedMenu(); ?>
		</div>

		<?php
	}
	
	private function fixedMenu() {
		
		?>
		<div id="fixed-menu">
			<div class="menu-icon"><a class="menu-hyperlink" href="?id=Pages">Pages</a></div>
			<div class="menu-icon"><a class="menu-hyperlink" href="?id=Settings">Settings</a></div>
			<div class="menu-icon"><a class="menu-hyperlink" href="?id=Modules">Modules</a></div>
			<div class="menu-icon"><a class="menu-hyperlink" href="?id=Media"> Media</a></div>
			<div class="menu-icon"><a class="menu-hyperlink" href="?id=Content">Content Editor</a></div>
			<div class="menu-icon"><a class="menu-hyperlink" href="?id=Users">Users</a></div>
			<div class="menu-icon"><a class="menu-hyperlink" href="?id=Settings&&moduleID=StyleSheet">Stylesheet</a></div>
			<div class="menu-icon"><a class="menu-hyperlink" href="?id=Settings&&moduleID=Menu">Menus</a></div>
		</div>
		
		<?php 
	}
	
	public function defaultScreen() {

		echo '<table>';
		echo '<tr><td>Page Stats</td><td>Page Stats</td><td>Page Stats</td></tr>';
		echo '</table>';
	}
	
	public function switchMode() {
	
		$moduleID = filter_input ( INPUT_GET, 'moduleID' );
		$localAction = NULL;
		
		if (isset ( $this->setPostID )) {
			$localAction = $this->setPostID;
		} elseif (isset ( $this->setGetID )) {
			$localAction = urldecode ( $this->setGetID );
		}
		
		$lowerName = strtolower ( $localAction );
		$checkName = strtoupper ( $localAction );
		$lowerModule = strtolower ( $moduleID );
		
		Switch (strtoupper ( $localAction )) {
			case "USERS" :
				if ($moduleID) {
					$moduleID ();
				} else {
					showUserScreen ();
				}
				break;
			case "LOGOUT" :
				session_destroy ();
				header ( "LOCATION:index.php" );
				exit ();
			case "PROCESSLOGIN" :
				$this->processLogin ();
				break;
			case "SETTINGS" :
				if ($moduleID) {
					$moduleID ();
				}
				break;
			case "MODULES" :
				modules ();
				break;
			case "MEDIA" :
				media ();
				break;
			case "CONTENT" :
				if ($moduleID) {
					$content = new content_editor ( $this->dbConnection );
					$content->$moduleID ();
				} else {
					$content = new content_editor ( $this->dbConnection );
					$content->content_editor ();
				}
				break;
			case "PAGES" :
				if ($moduleID) {
					$moduleID ();
				} else {
					pages ();
				}
				break;
			case (NULL) :
				$callClass = new webstats($this->dbConnection);
				$callClass->callToFunction();
				break;
			case ($checkName) :
				include_once ("prom_modules/" . $lowerName . '.php');
				if ($moduleID) {
					$moduleClass = new $lowerName ( $this->dbConnection );
					$moduleClass->$lowerModule ();
				} elseif (! isset ( $moduleID )) {
					$moduleClass = new $lowerName ( $this->dbConnection );
					$moduleClass->$checkName ();
				}
				break;
		}
	}
}
