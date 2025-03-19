<?php
session_name('admin');
session_start();
session_destroy();
header("Location: adminlog.php");
exit();
?>
