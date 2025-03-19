<?php
session_name('user');
session_start();
session_unset(); 
session_destroy(); 
header('Location: login.php');
exit();
?>
