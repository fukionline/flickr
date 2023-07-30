<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/header.php");
$photo_count = mysqli_num_rows(mysqli_query($conn, "SELECT id from photos ORDER BY uploaded_on DESC"));

if(!isset($_GET['limit'])) { $page_number = 1; } else { $page_number = $_GET['limit']; }
$limit = 16;
$initial_page = ($page_number-1) * $limit;
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
			$sql = mysqli_query($conn, "SELECT * from photos ORDER BY uploaded_on DESC"); 
			$total_rows = mysqli_num_rows($sql);
			$total_pages = ceil ($total_rows / $limit); 
			$sql = mysqli_query($conn, "SELECT * FROM photos ORDER BY uploaded_on DESC LIMIT " . $initial_page . ',' . $limit);
			while ($row = mysqli_fetch_assoc($sql)) {
				$photo["id"] = $row["id"];
				$photo["uploader"] = $row["uploaded_by"];
				$result = $conn->query("SELECT * FROM users WHERE id='" . $photo["uploader"]. "'");
				while($row = $result->fetch_assoc()) { $user["screen_name"] = $row["screen_name"]; }
				echo "<p class=\"StreamList\">
					<a href=\"/photo.php?id=" . $photo["id"] . "\"><img src=\"/photos/" . $photo["id"] . ".t.jpg\" border=\"0\"></a><br>
					From <a href=\"/photos.php?user=" . $photo["uploader"] . "\">" . $user["screen_name"] . "</a>
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