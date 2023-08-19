<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/header.php"); 

if(!isset($_GET['start'])) {  
	$start_from = 0;  
} else {  
	$start_from = intval($_GET['start']); 
}

if($start_from < 0) {
	$start_from = 0;
}

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
			$stmt = $conn->prepare("SELECT * from photos ORDER BY id");
			$stmt->execute();
			$limit = 16;
			// Back to the usual
			$stmt = $conn->prepare("SELECT * from photos ORDER BY id DESC LIMIT " . $start_from . ',' . $limit);
			$stmt->execute();
			foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $photo) {
				// Fetch user info
				$stmt = $conn->prepare("SELECT * FROM users WHERE id=:t0");
				$stmt->bindParam(':t0', $photo->uploaded_by);
				$stmt->execute();
				foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $uploader);
				echo "<p class=\"StreamList\">
				<a href=\"/photo.php?id=" . $photo->id . "\"><img src=\"/photos/" . $photo->id . ".t.jpg\" border=\"0\"></a><br>
				From <a href=\"/profile_photos.php?id=" . $photo->uploaded_by . "\">" . $uploader->screen_name . "</a>
			</p>";
			}
			?>
			</div>
			<br clear="all" />

			<p style="border-top: 1px solid #eee; padding: 5px;"></p>
				<div style="float: right; padding-right: 10px;"><a href="/photos.php?start=<?php echo $start_from + 16; ?>">Earlier &raquo;</a></div>
				<?php
				if($start_from > 1) {
					echo "<div style=\"float: left; padding-left: 10px;\"><a href=\"/photos.php?start=" . $start_from - 16 . "\">&laquo; More recently</a></div>";
				}
				?>
			

			</td>
		</tr>
	</table>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/incl/footer.php"); ?>