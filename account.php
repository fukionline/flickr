<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/header.php"); 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/logincheck.php"); 

if(isset($_GET["branding"])) {
	if(!isset($_COOKIE["alt_branding"])) {
		setcookie("alt_branding", true, time() + (10 * 365 * 24 * 60 * 60));
		header("Location: /account.php");
	} else {
		setcookie("alt_branding", true, time() - 9999);
		header("Location: /account.php");
	}
}

?>
<p>this page will be revamped soon</p>
<ul>
	<li><a href="iconbuilder.php">Buddy icon builder</a></li>
	<li><a href="account.php?branding">Toggle alt branding</a></li>
</ul>

<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/footer.php"); ?>