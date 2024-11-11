<?php
session_start();
session_unset();
session_destroy();
header("Location: /livestock/landingpage\index.html");
exit();
?>
