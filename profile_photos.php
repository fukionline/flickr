<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/header.php"); 

if(!isset($_GET["id"])) { die("No user ID set."); }
$_GET["id"] = (int) $_GET["id"]; // better cast to int

$stmt = $conn->prepare("SELECT * FROM users WHERE id=:t0");
$stmt->bindParam(':t0', $_GET["id"]);
$stmt->execute();
foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $user);


?>

	<h1><img src="<?php echo $user->display_picture; ?>" width="48" height="48" border="0" align="absmiddle" class="BuddyIconH"><?php echo $user->screen_name; ?>'s photos.</h1>
					<table width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td width="100%" valign="top">
<center>
<table width="530" cellspacing="0" cellpadding="0">
	<?php
	$stmt = $conn->prepare("SELECT * FROM photos WHERE uploaded_by=:t0 ORDER by id DESC");
	$stmt->bindParam(':t0', $_GET['id']);
	$stmt->execute();
	$photo_count = 0;
	if($stmt->rowCount() > 0) {
		foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $photo) {
			$Now = new DateTime($photo->uploaded_on);
			$stmt = $conn->prepare("SELECT * FROM comments WHERE posted_to = :t0");
			$stmt->bindParam(':t0', $photo->id);
			$stmt->execute();
			$comment_count = $stmt->rowCount();
			if($photo_count == 0) {
				echo "<tr valign=\"top\">";
			}
			echo "		<td>
								<h4 style=\"margin-top: 0px; font-size: 14px; width: 240px;\">" . $photo->title . "</h4>
								<p style=\"margin-top: 5px; margin-bottom: 5px;\"><a href=\"/photo.php?id=". $photo->id . "\"><img src=\"photos/". $photo->id . ".m.jpg\"></a></p>
								<p style=\"width: 225px; margin-left: 6px; margin-top: 5px; margin-bottom: 5px;\">" . $photo->description . "</p>

								<p style=\"font-size: 11px; margin-top: 5px; margin-bottom: 0px; width: 240px;\">
	<img src=\"/images/icon_public.gif\" style=\"vertical-align:middle; margin-right: 4px; margin-bottom: 4px; float:left; border:none;\" alt=\"This photo is public\" width=\"15\" height=\"15\" />This photo is public.
									(<a href=\"/photo.php?id=".$photo->id . "\">" . $comment_count . " Comments</a>)
								</p>
								<p style=\"margin-top: 5px; margin-bottom:10px;\"><span class=\"DateTime\"><a href=\"photo.php?id=". $photo->id . "\" class=\"pale\">" . $Now->format('d') . " " . $Now->format('M') . " '" . $Now->format('y') . ", ". $Now->format('h') . "." . $Now->format('i') . strtolower($Now->format('A')) . "</a></span></p>
		</td>
		";
		$photo_count++;
		if($photo_count == 2) {
			echo "</tr><tr valign=\"top\">";
			$photo_count = 0;
		}
	}
	}
	?>
	</tr>
</table>
</center>

							</div>
							<div class="paginator">
		<!--
		Pages:&nbsp;&nbsp;&nbsp;&nbsp;
			<span class="this-page">1</span>
			<a href="/photos/underbunny/page2/">2</a>
			<a href="/photos/underbunny/page3/">3</a>
			<a href="/photos/underbunny/page4/">4</a>
			<a href="/photos/underbunny/page5/" class="end">5</a>
		<span class="DateTime">&nbsp;&nbsp;&nbsp;&nbsp;(46 photos)</span>
		-->

	
</div>



				
						</td>
						<td style="vertical-align:top;">
				<!-- <h3 style="margin-top: 10px;">&raquo; <a href="/photos/underbunny/calendar/">Calendar view</a></h3> 
				<h3 style="margin-top: 10px;">&raquo; <a href="/photos/underbunny/tags/">underbunny's tags</a></h3>	-->									
				<h3 style="margin-top: 10px;">&raquo; <a href="/profile.php?user=<?php echo $_GET["id"]; ?>">About <?php echo $user->screen_name; ?></a></h3>
				<br />
				<!--
								<h4>Search underbunny's photos</h4>
				<form action="/photos_search.gne" method="get">
				<input type="hidden" name="user" value="35034347254@N01">
				<input type="text" name="q" size="16">&nbsp;<input type="submit" class="SmallButt" value="SEARCH">
				</form>

				<h3>Archive</h3>
				<p style="margin-left: 10px;">
					<b>All photos</b> (46)<br>
					<a href="/photos/underbunny/date/2004/03/">March 2004</a> (3)<br>
					<a href="/photos/underbunny/date/2004/04/">April 2004</a> (6)<br>
					<a href="/photos/underbunny/date/2004/05/">May 2004</a> (15)<br>
					<a href="/photos/underbunny/date/2004/06/">June 2004</a> (15)<br>
					<a href="/photos/underbunny/date/2004/07/">July 2004</a> (7)<br>
				</p>
				
				<span id="Feeds">
					<h4>Feeds for this photostream</h4>
					<p>
						<a href="/services/feeds/photos_public.gne?id=35034347254@N01&format=rss_091">RSS (0.91)</a>,
						<a href="/services/feeds/photos_public.gne?id=35034347254@N01&format=rss_100">RDF</a>,
						<a href="/services/feeds/photos_public.gne?id=35034347254@N01&format=atom_03">Atom</a>
						(also available in RSS <a href="/services/feeds/photos_public.gne?id=35034347254@N01&format=rss_092">0.92</a>
						and <a href="/services/feeds/photos_public.gne?id=35034347254@N01&format=rss_200">2.0</a>)
					</p>
				</span>
				-->
				<p style="margin-bottom: 60px;">&nbsp;</p>
											<img src="/images/spaceball.gif" alt="spacer image" width="200" height="1" style="border: none;"> 
						</td>
					</tr>
				</table>				

<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/footer.php"); ?>