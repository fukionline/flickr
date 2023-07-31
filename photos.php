<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/header.php");
?>
	<h1>Everyone's photos.</h1>

	<table>
		<tr>
			<td id="Hint"> 
				<h4 style="margin-bottom: 50px;">&raquo; <a href="/tags.php">150 most popular tags</a></h4>
				<img src="/images/spaceball.gif" alt="spacer image" width="160" height="1"> 
			</td>
			<td id="GoodStuff">
			<div>
			<?php
			$stmt = $conn->prepare("SELECT * from photos ORDER BY uploaded_on DESC LIMIT 16");
			$stmt->execute();
			foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $photo) {
				// Fetch user info
				$stmt = $conn->prepare("SELECT * FROM users WHERE id=:t0");
				$stmt->bindParam(':t0', $photo->uploaded_by);
				$stmt->execute();
				foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $uploader);
				echo "<p class=\"StreamList\">
				<a href=\"/photo.php?id=" . $photo->id . "\"><img src=\"/photos/" . $photo->id . ".t.jpg\" border=\"0\"></a><br>
				From <a href=\"/photos.php?user=" . $photo->uploaded_by . "\">" . $uploader->screen_name . "</a>
			</p>";
			}
			?>
			</div>
			<br clear="all" />

			<p style="border-top: 1px solid #eee; padding: 5px;">
				<div style="float: right; padding-right: 10px;"><a href="/photos.php?start=16">Earlier &raquo;</a></div>
			</p>

			</td>
		</tr>
	</table>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/incl/footer.php"); ?>