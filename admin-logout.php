<?php
session_start();

unset($_SESSION["admin_id"]);
unset($_SESSION["admin_name"]);

session_regenerate_id(true);

header("Location: Admin-login.php");
exit();
?>