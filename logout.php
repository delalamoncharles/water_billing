<?php
session_start();
session_destroy();
header("Location: login.php?Success fully logged out");
exit();
?>