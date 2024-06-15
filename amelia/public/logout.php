<?php
session_start();
session_destroy();
echo "Debug: session destroyed<br>";
header('Location: login.php');
exit();
?>
