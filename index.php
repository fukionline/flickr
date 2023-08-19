<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/config.php");
if(!isset($_SESSION["id"])) {
	require_once($_SERVER["DOCUMENT_ROOT"] . "/index_nosession.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"] . "/index_loggedin.php");
}
?>