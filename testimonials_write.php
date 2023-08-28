<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/header.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/logincheck.php");

if(!isset($_GET["id"])) { die("No user ID set."); }
$_GET["id"] = (int) $_GET["id"]; // better cast to int

if($_SESSION["id"] == $_GET["id"]) {
	die("you can't write yourself a testimonial");
}

//Get user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id=:t0");
$stmt->bindParam(':t0', $_GET["id"]);
$stmt->execute();
foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $user);

if($stmt->rowCount() == 0) {
	die("user does not exist");
}

//See if user has already added a testimonial
$stmt = $conn->prepare("SELECT * FROM testimonials WHERE sent_by=:t0 AND sent_to=:t1");
$stmt->bindParam(':t0', $_SESSION["id"]);
$stmt->bindParam(':t1', $_GET["id"]);
$stmt->execute();
if($stmt->rowCount() > 0) { die("you have already added a testimonial for this user"); }

if(isset($_POST["Submit"])) {
	$testimonial = $_POST["testimonial"];
	if(mb_strlen($testimonial, 'utf8') > 400) { die("Testimonial is too long"); }
	if(mb_strlen($testimonial, 'utf8') < 1) { die("Testimonial is literally non existent"); }
	$stmt = $conn->prepare("INSERT INTO testimonials (sent_by, sent_to, text) VALUES (:t0, :t1, :t2)");
	$stmt->bindParam(":t0", $_SESSION["id"]);
	$stmt->bindParam(":t1", $_GET["id"]);
	$stmt->bindParam(":t2", $testimonial);
	$stmt->execute();
	header("Location: /testimonials_manage.php?written=1");
}

?>
<h1>Add a testimonial for <?php echo $user->screen_name; ?></h1>

	<table>
		<tr>
			<td id="Hint"> 
				<p><?php echo $user->screen_name; ?> will have the chance to review this testimonial before it is published, so don't bother with something rude or nasty.</p>
				<img src="/images/spaceball.gif" alt="spacer image" width="150" height="1"> 
			</td>
			
			<form method="post">
				<td id="GoodStuff" valign="top">
					<h3>Your Testimonial</h3>
					<textarea style="width:300px;height:120px" name="testimonial"></textarea><br>
					<input type="submit" name="Submit" class="Butt" value="SAVE THIS" style="margin-top: 5px">
					<p>Or, <a href="/">return to your launch page</a>.</p>
				</td>
			</form>
		</tr>
	</table>

<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/footer.php"); ?>