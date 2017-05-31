<?php
$request_method = $_SERVER['REQUEST_METHOD'];
parse_str(file_get_contents('php://input'),$data);
$request_data = array_merge($_GET, $_POST, $data);
?>
