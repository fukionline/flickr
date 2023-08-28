<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/header.php"); ?>

	<h1>Page not found.</h1>

	<table>
		<tr>
			<td id="Hint">&nbsp;<img src="/images/spaceball.gif" alt="spacer image" width="160" height="1">			</td>
			<td id="GoodStuff">

				<p>Oops! Looks like you followed a bad link. If you think this is a problem with <?php echo $website["instance_name"]; ?>, please <a href="help.php">tell us</a>.</p>
				<p>Here's a link to the <a href="/">home page</a>.</p>
			</td>
		</tr>
	</table>

<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/footer.php"); ?>