<?php

session_start(); # if we want a global associative array $_SESSION up and running, we have to include this line at the beginning of a file

session_unset(); # destroys session

header('Location: index.php');

?>