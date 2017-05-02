<?php
function showMenu() {
	global $dbConnection;
	
	echo ' <ul>';
	$stmt = $dbConnection->prepare ( "SELECT menuLabel FROM menus WHERE menuLocation='Header' " );
	$stmt->execute ();
	
	$stmt->bind_result ( $menuLabel );
	
	while ( $checkRow = $stmt->fetch () ) {
		
		echo '<li><a href="#' . $menuLabel . '">' . strtoupper ( $menuLabel ) . '</a></li>';
	}
	echo '</ul>';
}
function menu() {
	global $dbConnection;
	$menuLocation = filter_input ( INPUT_GET, "menuLocation" );
	$menuLabel = filter_input ( INPUT_GET, "menuLabel" );
	
	?>
	<style>
	.menuDirectory
	{
	float: left;
	width: 40%;
	}
	</style>
	<?php 
	if (empty ( $menuLabel )) {
		?>
<style>
.menuEditor {
	display: none;
}
</style>
<?php
	}else {
?><style>
.menuEditor {
	
}
</style>
<?php 
} 
?>
<div class="menuDirectory">
	
	<?php
	echo '<table border=0 cellpadding=10 bgcolor=f1f1f1>';
	echo '<tr><td class="header1" colspan=3>Menu Panel</td></tr>';
	echo '<tr><td colspan=3></td></tr>';
	echo '<tr><td colspan=4 bgcolor=white><button><a href="?id=Settings&&moduleID=AddMenu">Create a new menu</a></button></td></tr>';
	echo '<tr><td colspan=4></td></tr>';
	echo '<tr><td>';
	
	echo '<table cellpadding=0 cellspacing=0>';
	
	$stmt = $dbConnection->prepare ( "SELECT DISTINCT menuLocation FROM menus  ORDER BY menuOrder" );
	$stmt->execute ();
	
	$stmt->bind_result ( $menuLocation );
	
	while ( $checkRow = $stmt->fetch () ) {
		
		echo '<tr><td class="darkBorder"><a href="?id=Settings&&moduleID=Menu&&menuLabel=' . $menuLocation . '">' . $menuLocation . '</a></td></tr>';
	}
	
	echo '</table>';
	
	echo '</td></tr>';
	echo '</table>';
	
	?>
	</div>
<div class="menuEditor">
	<?php
	
	echo '<table cellpadding=10 cellspacing=5 border=0 width=50%>';
	echo '<tr><td class="header1" colspan=2>Edit Menu</td></tr>';
	echo '<tr><td><b>Menu Name:</b> '.$menuLocation.'</td></tr>';
	echo '<tr><td>';
	
	echo '<table>';
	
	$stmt = $dbConnection->prepare ( "SELECT menuLabel FROM menus WHERE menuLocation='$menuLocation' ORDER BY menuOrder" );
	$stmt->execute ();
	
	$stmt->bind_result ( $menuLabel );
	
	while ( $checkRow = $stmt->fetch () ) {
		
		echo '<tr><td><input type="checkbox" name=' . $menuLabel . '"> ' . $menuLabel . '</td></tr>';
	}
	echo '</table>';
	
	echo '</td></tr>';
	echo '</table>';
	?>
	</div>
<?php
}

function addMenu() {
	global $dbConnection;
	
	$x = 1;
	
	echo '<form method="POST" action="?id=Settings&&moduleID=UploadMenu">';
	
	echo '<table cellpadding=10 cellspacing=5 border=0 bgcolor=f1f1f1 width=50%>';
	echo '<tr><td colspan=2>Menu Panel</td></tr>';
	echo '<tr><td>Name </td><td><input type=text name=pageName placeholder="enter page name"></td></tr>';
	echo '<tr><td>';
	
	echo '<table>';
	
	$stmt = $dbConnection->prepare ( "SELECT pageName FROM pages " );
	$stmt->execute ();
	
	$stmt->bind_result ( $pageName );
	
	while ( $checkRow = $stmt->fetch () ) {
		
		echo '<tr><td><input type="checkbox" name="page' . $x . '" value="' . $pageName . '"> ' . $pageName . '</td></tr>';
		$x ++;
	}
	echo '</table>';
	
	echo '</td></tr>';
	echo '<tr><td><input type="Submit" name="Submit" value="Create"></td></tr>';
	echo '</table>';
	echo '</form>';
}

function editMenu() {
	
	global $dbConnection;
	$menuLocation = filter_input ( INPUT_GET, "menuID" );
	
	echo '<table cellpadding=10 cellspacing=5 border=0 width=50%>';
	echo '<tr><td><h2>Menu Panel</h2></td></tr>';
	echo '<tr><td><a href="?id=Settings&&moduleID=menuLocation">Edit Menu</a></td><td><a href="?id=Settings&&moduleID=menuLocation">Menu Locations</a></td></tr>';
	echo '<tr><td>';
	
	echo '<table>';
	
	$stmt = $dbConnection->prepare ( "SELECT menuLabel FROM menus WHERE menuLocation='$menuLocation' ORDER BY menuOrder" );
	$stmt->execute ();
	
	$stmt->bind_result ( $menuLabel );
	
	while ( $checkRow = $stmt->fetch () ) {
		
		echo '<tr><td>' . $menuLabel . '</td></tr>';
	}
	echo '</table>';
	
	echo '</td></tr>';
	echo '</table>';
}

function uploadMenu() {
	global $dbConnection;
	
	$pageName = filter_input ( INPUT_POST, "pageName" );
	
	$page = 'page';
	for($x = 1; $x <= 10; $x ++) {
		
		$value = filter_input ( INPUT_POST, 'page' . $x );
		
		if ($value) {
			echo $value . '<br>';
			$createRow = $dbConnection->prepare ( "INSERT INTO menus (menuLocation, menuLabel, menuOrder) VALUES ('$pageName', '$value', '$x')" );
			$createRow->execute ();
			$createRow->close ();
		}
	}
	echo '<font color=black><b>Menu Created <br><br> Please Wait!!!!<br>';
	echo '<meta http-equiv="refresh" content="1;url=?id=Settings&&moduleID=Menu">';
}

function menuLocation() {
	global $dbConnection;
	
	echo '<table cellpadding=10 cellspacing=5 border=0 width=50%>';
	echo '<tr><td class="header1">Menu Panel</td><td></td><td></td></tr>';
	echo '<tr><td><a href="?id=Settings&&moduleID=menuLocation">Edit Menu</a></td><td><a href="?id=Settings&&moduleID=menuLocation">Menu Locations</a></td><td></td></tr>';
	
	echo '<tr><td></td></tr>';
	echo '<tr class="headerMenu"><td colspan=2>Menu Locations</td></tr>';
	echo '<tr><td>';
	
	echo '<table>';
	
	$stmt = $dbConnection->prepare ( "SELECT DISTINCT menuLocation FROM menus ORDER BY menuLocation DESC" );
	$stmt->execute ();
	
	$stmt->bind_result ( $menuLocation );
	
	while ( $checkRow = $stmt->fetch () ) {
		
		echo '<tr><td><a href="?id=Settings&&moduleID=EditMenu&&menuID=' . $menuLocation . '">' . $menuLocation . '</a></td></tr>';
	}
	echo '</table>';
	
	echo '</td></tr>';
	echo '</table>';
}
