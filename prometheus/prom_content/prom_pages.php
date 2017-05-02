<?php
$dbConnection = databaseConnection ();
function pages() {
	global $dbConnection;
	
	echo '<table border=0 cellpadding=10 cellspacing=5>';
	
	echo '<tr><td colspan=2>Pages <a href="?id=Pages&&moduleID=AddPage"><button>Add New</button></a><br><br></td></tr>';
	
	echo '<tr><td colspan=2></td></tr>';
	echo '<tr><td>PageName</td></tr>';
	$stmt = $dbConnection->prepare ( "SELECT pageID, pageName FROM pages" );
	$stmt->execute ();
	
	$stmt->bind_result ( $pageID, $pageName );
	
	while ( $checkRow = $stmt->fetch () ) {
		
		echo '<tr bgcolor=white style="cursor: pointer;"  onclick="location.href=\'?id=Pages&&moduleID=EditPage&&pageID=' . $pageID . '\'"><td width="200">' . $pageName . '</td></tr>';
	}
	
	echo '</table>';
}
function addpage() {
	echo '<form method="POST" action="?id=Pages&&moduleID=uploadPage">';
	echo '<table cellpadding=10>';
	echo '<tr><td colspan=2><h1>Add New Page</h1></td></tr>';
	echo '<tr><td width=150><img src="Images/arrows.png"> <b>Page Name</td><td><input type="text" name="pageName" size=60 required></td></tr>';
	echo '<tr><td colspan=2><input type="submit" name="Submit" value="Submit"></td></tr>';
	echo '</table>';
	echo '</form>';
}
function uploadPage() {
	global $dbConnection;
	
	$pageName = filter_input ( INPUT_POST, 'pageName' );
	$pagePublish = filter_input ( INPUT_POST, 'pagePublish' );
	
	$sunset = $dbConnection->prepare ( "INSERT INTO pages (pageName) VALUES (?)" );
	$sunset->bind_param ( 's', $pageName );
	$status = $sunset->execute ();
	
	if ($status === false) {
		trigger_error ( $sunset->error, E_USER_ERROR );
	}
	
	echo 'You have successfully added a new Page. <br><br><br>Please Wait.....<br>';
	echo '<meta http-equiv="refresh" content="3;url=?id=Pages">';
}
function updatePage() {
	global $dbConnection;
	
	$setPageID = filter_input ( INPUT_POST, 'pageID' );
	$getDescription = filter_input ( INPUT_POST, 'area2' );
	
	$stmt = $dbConnection->prepare ( "UPDATE pages SET pageDescription=? WHERE pageID=?" );
	$stmt->bind_param ( 'si', $getDescription, $setPageID );
	
	if ($stmt === false) {
		trigger_error ( $this->dbConnection->error, E_USER_ERROR );
	}
	
	$status = $stmt->execute ();
	
	if ($status === false) {
		trigger_error ( $stmt->error, E_USER_ERROR );
	}
	echo '<font color=black><b>Page Updated <br><br> Please Wait!!!!<br>';
	echo '<meta http-equiv="refresh" content="1;url=?id=Pages">';
}
function updateRow() {
	
	/*
	 * Bring down the mysqli Connections
	 */
	global $dbConnection;
	global $secondaryDBConnection;
	
	/*
	 * Set Values for use with in this function.
	 */
	$setPageID = filter_input ( INPUT_POST, 'pageID' );
	$getModuleCode = '[' . filter_input ( INPUT_POST, 'addModule' ) . ']';
	$getRowID = filter_input ( INPUT_POST, 'rowID' );
	$setRowCode = "pageRow" . $getRowID;
	
	// if Clear Value is set remove the data from the page.
	if ($getModuleCode == '[Clear]') {
		$getModuleCode = '';
	}
	
	if (empty ( $getModuleCode )) {
		
		$deleteRow = $dbConnection->prepare ( "DELETE FROM page_settings WHERE pageID='$setPageID' AND rowID='$getRowID' " );
		$deleteRow->execute ();
		$deleteRow->close ();
		
		$updatePageData = $dbConnection->prepare ( "UPDATE pages SET $setRowCode=? WHERE pageID=?" );
		$updatePageData->bind_param ( 'si', $getModuleCode, $setPageID );
		$updatePageData->execute ();
		$updatePageData->close ();
	} else {
		
		$SettingRef = $secondaryDBConnection->prepare ( "SELECT moduleCode FROM page_settings WHERE pageID='$setPageID' AND rowID='$getRowID' " );
		$SettingRef->execute ();
		$SettingRef->bind_result ( $moduleCode );
		$SettingRef->fetch ();
		
		if (! $SettingRef) {
			
			$updateRow = $dbConnection->prepare ( "UPDATE page_settings SET moduleCode=? WHERE pageID=? AND rowID=?" );
			$updateRow->bind_param ( 'sii', $getModuleCode, $setPageID, $getRowID );
			$updateRow->execute ();
			$updateRow->close ();
			
			$updatePageData = $dbConnection->prepare ( "UPDATE pages SET $setRowCode=? WHERE pageID=?" );
			$updatePageData->bind_param ( 'si', $getModuleCode, $setPageID );
			$updatePageData->execute ();
			$updatePageData->close ();
		} else {
			
			$createRow = $dbConnection->prepare ( "INSERT INTO page_settings (pageID, rowID, moduleCode) VALUES ('$setPageID', '$getRowID', '$getModuleCode')" );
			$createRow->execute ();
			$createRow->close ();
			
			$updatePageData = $dbConnection->prepare ( "UPDATE pages SET $setRowCode=? WHERE pageID=?" );
			$updatePageData->bind_param ( 'si', $getModuleCode, $setPageID );
			$updatePageData->execute ();
			$updatePageData->close ();
		}
	}
	
	echo '<font color=black><b>Page Row Updated <br><br> Please Wait!!!!<br>';
	echo '<meta http-equiv="refresh" content="1;url=?id=Pages&&moduleID=EditPage&&pageID=' . $setPageID . '">';
}
function editpage() {
	global $dbConnection;
	
	$setPageID = filter_input ( INPUT_GET, 'pageID' );
	
	echo '<table border=1 cellpadding=10 width=50% cellspacing=0>';
	
	echo '<tr><td colspan=4><h2>Page Panel</h2></td></tr>';
	echo '<tr class="headerMenu"><td>Row No. </td><td>Module Code</td><td>Modules</td><td>Content Editor</td></tr>';
	
	for($x = 1; $x <= 10; $x ++) {
		echo '<tr><td>' . $x . '</td><td>';
		currentModule ( $x, $setPageID );
		echo '</td><td>';
		moduleSelect ( $x, $setPageID );
		echo '</td><td>';
		contentSelect ( $x, $setPageID );
		echo '</td></tr>';
	}
	echo '</table>';
}
function currentModule($rowID, $pageID) {
	
	global $dbConnection;
	
	if ($stmt = $dbConnection->prepare ( "SELECT moduleCode FROM page_settings WHERE pageID=? AND rowID=?" )) {
		
		$stmt->bind_param ( "ii", $pageID, $rowID);
		$stmt->execute ();
		
		$stmt->bind_result ( $moduleCode );
		$stmt->fetch ();
		
		echo $moduleCode;
	}
}

function setNewRow() {
	
	global $dbConnection;
	
	$pageID = filter_input ( INPUT_POST, "pageID" );
	$rowID = filter_input ( INPUT_POST, "rowID" );
	$moduleCode1 = filter_input ( INPUT_POST, "moduleCode" );
	
	$query = "SELECT moduleCode FROM page_settings WHERE pageID=? AND rowID=? ";
	
	if ($stmt = $dbConnection->prepare ( $query )) {
		
		$stmt->bind_param ( "ii", $pageID, $rowID );
		
		if ($stmt->execute ()) {
			$stmt->store_result ();
			
			$stmt->bind_result ( $moduleCode );
			$stmt->fetch ();
			
			if ($stmt->num_rows == 1) {
				
				$updatePageData = $dbConnection->prepare ( "UPDATE page_settings SET moduleCode=? WHERE pageID=? AND rowID=?" );
				$updatePageData->bind_param ( 'sii', $moduleCode1, $pageID, $rowID );
				$updatePageData->execute ();
				$updatePageData->close ();
				
			} else {
				
				$createRow = $dbConnection->prepare ( "INSERT INTO page_settings (pageID, rowID, moduleCode) VALUES ('$pageID', '$rowID', '$moduleCode1')" );
				$createRow->execute ();
				$createRow->close ();
			}
		}
	}
	
	echo '<font color=black><b>Page Row Updated <br><br> Please Wait!!!!<br>';
	echo '<meta http-equiv="refresh" content="1;url=?id=Pages&&moduleID=EditPage&&pageID=' . $pageID . '">';
}
function moduleSelect($rowID, $pageID) {
	global $secondaryDBConnection;
	
	$stmt = $secondaryDBConnection->prepare ( "SELECT settingsName FROM settings ORDER BY settingsID " );
	$stmt->execute ();
	
	$stmt->bind_result ( $settingsName );
	
	echo '<form action="index.php?id=Pages&&moduleID=setNewRow" method="POST">';
	echo '<input type="hidden" name="rowID" value="' . $rowID . '">';
	echo '<input type="hidden" name="pageID" value="' . $pageID . '">';
	
	echo '<select name="moduleCode" id="modules"  onchange="this.form.submit()">';
	echo '<option selected>Module To Install</option>';
	while ( $checkRow = $stmt->fetch () ) {
		echo '<option value="' . $settingsName . '">[' . $settingsName . ']</option>';
	}
	echo '</select>';
	echo '</form>';
}
function contentSelect($rowID, $pageID) {
	echo 'Content Select;';
}
function have_row($pageID, $rowNumber) {
	global $secondaryDBConnection;
	
	echo '<table width=60% cellpadding=10 border=1>';
	$x = 1;
	
	if ($stmt = $secondaryDBConnection->prepare ( "SELECT pagesetID, pageID, rowID, rowCount, pagesetColumn1, pagesetColumn2, pagesetColumn3, pagesetColumn4 FROM page_settings WHERE pageID=? AND rowID=?" )) {
		
		$stmt->bind_param ( "ii", $pageID, $rowNumber );
		$stmt->execute ();
		
		$stmt->bind_result ( $pagesetID, $pageID, $rowID, $rowCount, $pagesetColumn1, $pagesetColumn2, $pagesetColumn3, $pagesetColumn4 );
		$stmt->fetch ();
		
		$setArray = array (
				$pagesetColumn1,
				$pagesetColumn2,
				$pagesetColumn3,
				$pagesetColumn4 
		);
		
		echo '<td width=50>' . $rowNumber . '</td><td width=150>Rows: ';
		
		echo '<form method="POST" action="index.php?id=RowCounter">';
		echo '<select onchange="this.form.submit()">';
		
		if ($rowCount) {
			echo '<option>' . $rowCount . '</option>';
		}
		
		if ($rowCount != 1) {
			echo '<option>1</option>';
		}
		
		if ($rowCount != 2) {
			echo '<option>2</option>';
		}
		
		if ($rowCount != 3) {
			echo '<option>3</option>';
		}
		
		if ($rowCount != 4) {
			echo '<option>4</option>';
		}
		
		echo '</select>';
		echo '</form>';
		
		echo '</td><td>';
		foreach ( $setArray as $value ) {
			
			if ($value) {
				echo '<td>' . $value . ' <a class="editpage" href="index.php?id=Pages&&moduleID=checkEdit&&pageID=' . $pageID . '&&pageCode=' . $value . '">edit</a></td>';
			}
		}
		
		unset ( $setArray );
		
		echo '</td></tr>';
	} else {
		echo 'No Connection!';
	}
	
	echo '</table>';
}
