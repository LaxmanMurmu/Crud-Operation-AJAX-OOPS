<?php
include "model.php";
$obj = new Query();

// ================================UPDATE QUERY EXECTING=============================
$ID = $obj->get_safe_str($_POST['id']);
$name = $obj->get_safe_str($_POST['name']);
$email = $obj->get_safe_str($_POST['email']);
$phone = $obj->get_safe_str($_POST['phone']);

$condition_arr = array('id' => $ID);
$update_arr = array('name' => $name, 'email' => $email, 'phone' => $phone);
$obj->updateData('users', $update_arr, $condition_arr);
?>
