<?php
require_once 'includes/functions.php';

// Get the 'id' from the URL
$id = $_GET['id'];

// Path to the JSON file
$dataFile = './data/user.json';

// Read JSON data
$users = readJSON($dataFile); // Assuming 'readJSON()' properly returns the parsed array

// Find the specific user
$user = null;
foreach ($users as $u) {
    if ($u['Id'] == $id) { // Match based on 'Id'
        $user = $u;
        break;
    }
}

if ($user) {
    // Display user data
    echo "<pre>";
    print_r($user);
    echo "</pre>";
} else {
    echo "User not found!";
}
?>
