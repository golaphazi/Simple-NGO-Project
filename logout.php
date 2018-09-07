<?php
session_start();
require_once("db_connect.php");
session_destroy();
pageRedirect('index.php');
?>