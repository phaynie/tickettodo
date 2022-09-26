<?php


session_start();
session_destroy();

/*Redirect to Login page*/
header('Location: index.php');



?>