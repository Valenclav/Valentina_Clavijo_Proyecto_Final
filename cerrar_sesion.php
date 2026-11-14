<?php
require_once "funciones.php";

$_SESSION = [];
session_destroy();
header("Location: index.php");
exit;

