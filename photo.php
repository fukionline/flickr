<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/header.php"); 
if(!isset($_GET["id"])) { die("No photo ID set."); }

$photo = array();
$user = array();
$pcomment = array();
$commenter = array();

$result = $conn->query("SELECT * FROM photos WHERE id=" . $_GET["id"]);
if($result->num_rows == 0) {
	die("Photo does not exist.");
	} else while($row = $result->fetch_assoc()) {
		// Fetch photo info
		$photo["title"] = htmlspecialchars($row["title"]);
		$photo["description"] = htmlspecialchars($row["description"]);
		$photo["camera"] = $row["camera"];
		$photo["tags"] = htmlspecialchars($row["tags"]);
		$photo["uploader"] = htmlspecialchars($row["uploaded_by"]);
		$photo["upload_date"] = htmlspecialchars($row["uploaded_on"]);
		// Fetch user info
		$result = $conn->query("SELECT * FROM users WHERE id='" . $photo["uploader"]. "'");
		while($row = $result->fetch_assoc()) {
			$user["screen_name"] = htmlspecialchars($row["screen_name"]);
			$user["buddy_icon"] = htmlspecialchars($row["display_picture"]);
		}
	}

// Parse the date
$Now = new DateTime($photo["upload_date"]);
$photo["date_month"] = $Now->format('M');
$photo["date_day"] = $Now->format('d');
$photo["date_year"] = $Now->format('Y');
$photo["date_hour"] = $Now->format('h');
$photo["date_mins"] = $Now->format('m');
$photo["date_pmam"] = $Now->format('A');

// Handle comments
if(isset($_POST["submit"])) {
	$comment = $_POST["comment"];
	if(mb_strlen($comment, 'utf8') > 200) { die("comment text too long. max length is 200"); }
	$stmt = $conn->prepare("INSERT INTO comments (posted_to, posted_by, text) VALUES (?, ?, ?)");
	$stmt->bind_param("iis", $_GET["id"], $user_id, $comment);
	$stmt->execute();
}

?>

	<h1 style="margin-bottom: 10px;"><?php echo $photo["title"]; ?></h1>
	<table>
		<tr>			
			<td id="GoodStuff"> 
							<table cellspacing="0" cellpadding="0" style="margin-top:0px;">
								<tr>
									<td valign="top" style="padding:0px;">
										<div id="photoImgDiv<?php echo $_GET["id"]; ?>"><img src="/photos/<?php echo $_GET["id"]; ?>.jpg" width="500" height="375"></div>							
									</td>
									
									<td valign="top" style="padding-left: 20px; padding-top: 0px;">
									
										<table cellspacing="0" cellpadding="0" style="margin-top: 0px;">
											<tr>
												<td width="50" valign="top" style="padding-left: 0px; padding-top: 0px;"><a href="/photos/<?php echo $photo["uploader"]; ?>/"><img src="<?php echo $user["buddy_icon"]; ?>" alt="view profile" width="48" height="48" style="border: solid 1px #000; margin: 0px;" /></a></td>
												<td valign="top" style="padding-bottom: 0px; padding-top: 0px; text-align: center;">
												<a href="#" class="ShowUsYerDate">
												<p style="margin-top: 0px; margin-bottom: 0px; font-size: 13px; font-weight: bold; text-transform: uppercase"><?php echo $photo["date_month"]; ?></p>												
												<p style="line-height: 21px; margin-bottom: 0px; margin-top: 0px; font-size: 21px; font-weight: bold;"><?php echo $photo["date_day"]; ?></p>
												<p style="line-height: 12px; margin-top: 0px; font-size: 12px; font-weight: normal; margin-bottom: 0px;"><?php echo $photo["date_year"]; ?></p>
												</a>
												</td>
											</tr>																					
										</table>

										<p class="DateTime" style="margin-top: 3px; margin-bottom: 3px;">From <a href="photos.php?user=<?php echo $photo["uploader"]; ?>" title="Link to <?php echo $user["screen_name"]; ?>'s photos"><?php echo $user["screen_name"]; ?></a> at <a href="#" class="pale"><?php echo $photo["date_hour"] . "." . $photo["date_mins"] . "<span style=\"text-transform: lowercase\">" . $photo["date_pmam"] . "</span>"; ?></a></p>
										<p style="margin-top: 0px;">
										<span class="DateTime">
	<img src="/images/icon_public.gif" style="vertical-align:middle; margin-right: 4px; margin-bottom: 4px; float:left; border:none;" alt="This photo is public" width="15" height="15" />This photo is public.
										</span>
										</p>

										<div class="TagList">
											<h4>TAGS</h4>
											<div id="thetags">
											<?php
											$stmt = mysqli_query($conn, "SELECT tags FROM photos WHERE id=" . $_GET["id"]);
											$thetags = [];
											foreach($stmt as $result) $thetags = array_merge($thetags, explode(" ", $photo['tags']));
											$thetags = array_unique($thetags);
											foreach($thetags as $tag) {
												echo "<div id=\"tagdiv\"><a href=\"#\" class=\"pale\">$tag</a></div>";
											}
											?>
											</div>
											<br />
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2" style="padding-top: 10px; padding-left: 65px;">
										<p style="width: 450px;"><?php echo $photo["description"]; ?></p>
										<?php if(isset($photo["camera"])) {
											echo "<p style=\"font-style: italic; color: #666; width: 450px;\">Taken with a <a href=\"photo_exif.php?id=" . $_GET["id"] . "\" style=\"color: #4B8FE3;\">" . $photo["camera"] . "</a>.</p>";
										}
										?>
									</td>
								</tr>
							</table>
			</td>
		</tr>
	</table>
	<table style="margin-top:0px;">
		<tr>
			<td id="Hint">
				<p style="margin-top: 20px;">TODO: views</p>				
				<img src="/images/spaceball.gif" alt="spacer image" width="180" height="1" style="border: none;">
			</td>
			<td valign="top" width="450"> 
				<table cellspacing="0" cellpadding="0" class="Tease">
					<tr>
					<?php if(!isset($_SESSION["id"])) {
						echo "<td><span style=\"font-weight: bold; color:#FF6699;\">PSST!</span> Would you like to comment?</td>
						<td>Choose a screen name...</td>
						</tr>
						<tr>
							<td class=\"Or\">(Already a member? <a href=\"/login.php\" title=\"Log in to Flickr\">Log in</a>.)</td>
							<td align=\"center\"><input name=\"username\" type=\"text\" size=\"20\">&nbsp;<a href=\"/register.php\"><input type=\"image\" src=\"/images/button_go_up_small.gif\" style=\"border:none;\" alt=\"Get your screen name!\" align=\"absmiddle\"></a></td>
						</tr>
				</table>";
					} else {
						echo "<form method=\"post\">
							<td><h3>Add your comment</h3></td>
						</tr>
						<tr>
							<td><textarea style=\"width: 400px;height:100px\" name=\"comment\"></textarea></td>
						</tr>
						<tr>
							<td><input name=\"submit\" type=\"submit\" class=\"Butt\" value=\"POST COMMENT\">
						</tr>
						</form>
					</table>";
					}
					?>
<p>Comment displays are currently gone due to issues</p>
				<br />
			
			</td>
		</tr>
	</table>	

