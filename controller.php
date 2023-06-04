<?php
include "model.php";
$obj = new Query();

if (isset($_GET['type']) && $_GET['type'] === 'insert') {
    $name = mysqli_real_escape_string($obj->connect(), $_POST['name']);
    $email = mysqli_real_escape_string($obj->connect(), $_POST['email']);
    $phone = mysqli_real_escape_string($obj->connect(), $_POST['phone']);

    $data = array(
        'name' => $name,
        'email' => $email,
        'phone' => $phone
    );
    $obj->insertData('users', $data);
}

// Calling getData() to fetch data
$result = $obj->getData('users', '*', '', 'id', 'DESC');

// Convert the result to JSON format
$jsonData = json_encode($result);

// Send the JSON response
header('Content-Type: application/json');
echo $jsonData;





// ================================UPDATE QUERY EXECTING=============================
// Update Query Execution
if (isset($_GET['type']) && $_GET['type'] === 'update') {
    $ID = $obj->get_safe_str($_POST['id']);
    $name = $obj->get_safe_str($_POST['name']);
    $email = $obj->get_safe_str($_POST['email']);
    $phone = $obj->get_safe_str($_POST['phone']);
    
    $condition_arr = array('id' => $ID);
    $update_arr = array('name' => $name, 'email' => $email, 'phone' => $phone);
    $obj->updateData('users', $update_arr, $condition_arr);
}


// ================================UPDATE QUERY EXECTING=============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_GET['type']) && $_GET['type'] === 'delete') {
    $ID = $obj->get_safe_str($_POST['id']);
    $condition_arr = array('id' => $ID);
    $obj->deleteData('users', $condition_arr);
}


?>
