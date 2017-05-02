<?php

$dbConnection = databaseConnection();

function showUserScreen() {

    global $dbConnection;

    if ($output = mysqli_query($dbConnection, "SHOW COLUMNS FROM users")):
        $columns = array();
        while ($result = mysqli_fetch_assoc($output)):
            $columns[] = $result['Field'];
        endwhile;
    endif;
    echo '<table cellpadding=7 cellspacing=0 border=1>';
    echo '<tr><td>Users <a href="?id=Users&&moduleID=AddUser"><button>Add User</button></a></td></tr>';
    echo '<tr bgcolor=skyblue>';
    foreach ($columns as $value) {
        $value = substr($value, 4);
        echo '<td>' . $value . '</td>';
    }
    echo '</tr>';

    $resource = $dbConnection->query('SELECT * FROM users WHERE 1');
    while ($rows = $resource->fetch_assoc()) {
        echo '<tr class="userRow" >';
        $userID = 0;
        foreach ($rows as $value) {

            if ($userID == 0) {
                $userID = $value;
            }
            echo '<td onclick="location.href=\'?id=Users&&moduleID=editUser&&userID=' . $userID . '\'">' . $value . '</td>';
        }
        echo '</tr>';
        unset($userID);
    }
    $resource->free();
    echo '</table>';
}

function addUser() {

    global $dbConnection;
    $x = 1;

    $table = 'users';
    $query = "SHOW COLUMNS FROM $table";
    if ($output = mysqli_query($dbConnection, $query)):
        $columns = array();
        while ($result = mysqli_fetch_assoc($output)):
            $columns[] = $result['Field'];
        endwhile;
    endif;

    $stmt = $dbConnection->prepare("SELECT userID FROM users ORDER BY userID DESC LIMIT 1");
    $stmt->execute();

    $stmt->bind_result($userID);

    while ($checkRow = $stmt->fetch()) {

        $getNewValue = $userID + 1;
    }
    echo '<form method="POST" action="?id=Users&&moduleID=UploadUser">';

            echo '<table border=0 cellpadding=10 cellspacing=0 width=50%>';
    echo '<tr><td colspan=2><h2>User Panel: Add User</h2></td></tr>';
    echo '<tr><td></td></tr>';
    
    echo '<tr class="headerMenu"><td></td><td></td></tr>';
    echo '<tr><td>UserFullname</td><td><input type="text" name="userFullname"></td></tr>';
    echo '<tr><td>UserUsername</td><td><input type="text" name="userUsername"></td></tr>';
    echo '<tr><td>UserPassword</td><td><input type="text" name="userPassword1"></td></tr>';
    echo '<tr><td>Confirm Password</td><td><input type="text" name="userPassword2"></td></tr>';
    echo '<tr><td>Status</td><td>';

    echo '<select name="userStatus">';
    echo '<option>Select Status</option>';
    echo '<option>Client</option>';
    echo '<option>Administrator</option>';
    echo '</select>';

    echo '</td></tr>';

    echo '<tr><td colspan=2><input type="submit" name="submit" value="Upload"></td></tr>';
    echo '</table>';
}

function uploaduser() {

    global $dbConnection;

    $setFullname = filter_input(INPUT_POST, 'userFullname');
    $setEmail = filter_input(INPUT_POST, 'userEmail');
    $userPhone = filter_input(INPUT_POST, 'userPhone');
    $userAddress = filter_input(INPUT_POST, 'userAddress');
    $userNewsletter = filter_input(INPUT_POST, 'userNewsletter');
    $userUsername = filter_input(INPUT_POST, 'userUsername');
    $userPassword1 = filter_input(INPUT_POST, 'userPassword1');
    $userPassword2 = filter_input(INPUT_POST, 'userPassword2');
    $userDomestic = filter_input(INPUT_POST, 'userDomestic');
    $userStatus = filter_input(INPUT_POST, 'userStatus');
    $setDate = date('Y-m-d');

    if ($userPassword1 == $userPassword2) {

        $userRef = $dbConnection->prepare("INSERT INTO users (userFullName, userUsername, userPassword, userStatus) VALUES (?,?,?,?)");
        $userRef->bind_param('ssss', $userFullName, $userUsername, $userPassword, $userStatus);

        $status = $userRef->execute();

        echo 'You have successfully registered a new User. <br><br><br>Please Wait.....<br>';
    } else {
        echo 'Password MisMatch!';
    }
    echo '<meta http-equiv="refresh" content="3;url=?id=Users">';
}

function EditUser() {

    global $dbConnection;

    $getID = filter_input(INPUT_GET, 'userID');

    $table = 'users';
    $query = "SHOW COLUMNS FROM $table";
    if ($output = mysqli_query($dbConnection, $query)):
        $columns = array();
        while ($result = mysqli_fetch_assoc($output)):
            $columns[] = $result['Field'];
        endwhile;
    endif;

    echo '<form method="POST" action="?id=UpdateUser">';
    echo '<input type="hidden" name="userID" value="' . $getID . '">';

    echo '<table cellpadding=7 cellspacing=0 width=100%>';
    echo '<tr><td colspan=2><h1>Edit Users Page</h1></td></tr>';
    echo '<tr bgcolor=skyblue>';
    foreach ($columns as $value) {
        $newValue = substr($value, 4);
        echo '<tr><td align="right"><b>' . $newValue . '</b></td><td>';

        echo '<table>';
        $stmt = $dbConnection->prepare("SELECT $value FROM users WHERE userID='$getID' ");
        $stmt->execute();

        $stmt->bind_result($fieldValue);

        while ($checkRow = $stmt->fetch()) {

            echo '<tr><td><input type="text" name="' . $value . '" value="' . $fieldValue . '" size=100 required></td></tr>';
        }
        echo '</table>';

        echo '</tr>';
    }
    echo '<tr><td colspan=2><input type="submit" name="submit" value="Upload"></td></tr>';
    echo '</table>';
}

function updateUser() {

    global $dbConnection;

    $getID = filter_input(INPUT_POST, 'userID');
    $showQuery = $param = $string = NULL;


    $table = 'users';
    $query = "SHOW COLUMNS FROM $table";
    if ($output = mysqli_query($dbConnection, $query)):
        $columns = array();
        while ($result = mysqli_fetch_assoc($output)):
            $columns[] = $result['Field'];
        endwhile;
    endif;
    foreach ($columns as $value) {
        $$value = filter_input(INPUT_POST, $value);

        $showQuery .= ', ' . $value . '=?';
        $param .= '$' . $value . ', ';
        $string .= 's';
    }
    $string = substr($string, 0, -1);
    $string .= 'i';

    $newQuery = substr($showQuery, 11);
    $newParam = substr($param, 9);
    $newQuery = 'UPDATE users SET ' . substr($newQuery, 1) . ' WHERE userID=?';
    $checkParameters = $newParam . ' $userID';

    echo $newQuery . '<br>';
    echo $checkParameters . '<br>';

    $stmt = $dbConnection->prepare($newQuery);
    $stmt->bind_param("$string", $checkParameters);

    if ($stmt === false) {
        trigger_error($this->dbConnection->error, E_USER_ERROR);
    }

    $status = $stmt->execute();

    if ($status === false) {
        trigger_error($stmt->error, E_USER_ERROR);
    }
    echo '<font color=black><b>Page Updated <br><br> Please Wait!!!!<br>';
    #  echo '<meta http-equiv="refresh" content="1;url=?id=Pages">';
}
