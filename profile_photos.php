<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/header.php"); 

if(!isset($_GET["id"])) { die("No user ID set."); }
$_GET["id"] = (int) $_GET["id"]; // better cast to int

$stmt = $conn->prepare("SELECT * FROM users WHERE id=:t0");
$stmt->bindParam(':t0', $_GET["id"]);
$stmt->execute();
foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $user);

if($stmt->rowCount() == 0) {
	die("user does not exist");
}

if(substr($user->screen_name, -1) == "s") { 
	$sn_display = htmlspecialchars($user->screen_name) . "'"; 
} else {
	$sn_display = htmlspecialchars($user->screen_name) . "'s";
}

if(isset($_GET["delete"])) {
	$_GET["delete"] = intval($_GET['delete']);
	// TODO: make this stuff a whole load better
	$stmt = $conn->prepare("SELECT * FROM photos WHERE id=:t0");
	$stmt->bindParam(':t0', $_GET["delete"]);
	$stmt->execute();
	foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $photo);
	if($_SESSION["id"] == $photo->uploaded_by) {
		$stmt = $conn->prepare("DELETE FROM photos WHERE id=:t0");
		$stmt->bindParam(':t0', $_GET["delete"]);
		$stmt->execute();
	}
}

$dt = NULL;

if(isset($_GET["dt"])) { 
	$dt = (int)$_GET["dt"];
}

if(!isset($_GET['start'])) {  
	$start_from = 0;  
} else {  
	$start_from = intval($_GET['start']); 
}

if($start_from < 0) {
	$start_from = 0;
}

$limit = 10;

$currentpage = round($start_from/$limit)+1;

$pagecount = 0;

$photolist = array();

if($_SESSION["id"] == $_GET["id"]) {
	echo "<h1><img src=\"" . $user->display_picture . "\" width=\"48\" height=\"48\" border=\"0\" align=\"absmiddle\" class=\"BuddyIconH\">Your photos</h1>";
} else {
	echo "<h1><img src=\"" . $user->display_picture . "\" width=\"48\" height=\"48\" border=\"0\" align=\"absmiddle\" class=\"BuddyIconH\">". $sn_display . " photos.</h1>";
}

?>
	
	
	<?php if($user->isBanned == 1) {
			echo "<p class=\"Problem\" style=\"margin-top: 30px; margin-left: 60px;\">This person is no longer active on " . $website["instance_name"] . "</p>";
			die(require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/footer.php"));
	}
	?>
					<table width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td width="100%" valign="top">
<center>
<table width="530" cellspacing="0" cellpadding="0">
	<?php
	$stmt = $conn->prepare("SELECT * FROM photos WHERE uploaded_by=:t0 ORDER by id DESC");
	$stmt->bindParam(':t0', $_GET['id']);
	$stmt->execute();
	$iter = 0;
	$photo_count_act = 0;
	$visiblephotocount = 0;
	
	if($stmt->rowCount() > 0) {
		foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $photo) {
			
			if ($dt != NULL) {
				$first = strtotime(date('Y/m/01', $dt));
				$last  = strtotime(date('Y/m/t', $dt));

				if (!((strtotime($photo->uploaded_on) >= $first) && (strtotime($photo->uploaded_on) <= $last))) {
					$photo_count_act++;
					continue;
				}
			}
			
			$photolist[$iter] = clone $photo;
			
			$photo_count_act++;
			$visiblephotocount++;
			$iter++;
		}
	}
	
	$pagecount = ceil($visiblephotocount/$limit);
		
	$photolist = array_slice($photolist, $start_from, $limit);

	$photo_count = 0;
	foreach ($photolist as $photo) {
		$Now = new DateTime($photo->uploaded_on);
		$stmt = $conn->prepare("SELECT * FROM comments WHERE posted_to = :t0"); 
		$stmt->bindParam(':t0', $photo->id);
		$stmt->execute();
		$comment_count = $stmt->rowCount();
		if($comment_count == 1) {
			$comment_display = $comment_count . " Comment";
		} else {
			$comment_display = $comment_count . " Comments";
			}
		if($user_id == $photo->uploaded_by) { $delete = " | <a href=\"/profile_photos.php?id=". $_GET["id"] . "&delete=" . $photo->id . "\">Delete</a>"; } else { $delete = NULL; }
		if($photo_count == 0) {
			echo "<tr valign=\"top\">";
		}
			echo "		<td>
								<h4 style=\"margin-top: 0px; font-size: 14px; width: 240px;\">" . htmlspecialchars($photo->title) . "</h4>
								<p style=\"margin-top: 5px; margin-bottom: 5px;\"><a href=\"/photo.php?id=". $photo->id . "\"><img src=\"photos/". $photo->id . ".m.jpg\"></a></p>
								<p style=\"width: 225px; margin-left: 6px; margin-top: 5px; margin-bottom: 5px;\">" . htmlspecialchars($photo->description) . "</p>

								<p style=\"font-size: 11px; margin-top: 5px; margin-bottom: 0px; width: 240px;\">
	<img src=\"/images/icon_public.gif\" style=\"vertical-align:middle; margin-right: 4px; margin-bottom: 4px; float:left; border:none;\" alt=\"This photo is public\" width=\"15\" height=\"15\" />This photo is public.
									(<a href=\"/photo.php?id=".$photo->id . "\">" . $comment_display . "</a>)
								</p>
								<p style=\"margin-top: 5px; margin-bottom:10px;\"><span class=\"DateTime\"><a href=\"photo.php?id=". $photo->id . "\" class=\"pale\">" . $Now->format('d') . " " . $Now->format('M') . " '" . $Now->format('y') . ", ". $Now->format('h') . "." . $Now->format('i') . strtolower($Now->format('A')) . "</a>" . $delete . "</span></p>
		</td>
		";
		$photo_count++;
		if($photo_count == 2) {
			echo "</tr><tr valign=\"top\">";
			$photo_count = 0;
		}
	}	
	?>
	</tr>
</table>
</center>

							</div>
							<div class="paginator">
		
		Pages:&nbsp;&nbsp;&nbsp;&nbsp;
		<?php
			$dtarg = "";
			if ($dt != NULL) {
				$dtarg = "&dt=$dt";
			} 
			
			for ($iter = 0 ; $iter < $pagecount; $iter++) {
				if (($iter+1) == $currentpage) {
					echo '<span class="this-page">'.($iter+1).'</span>';
				} else {
					$st = $iter*$limit;
					$cstr = "";
					if ($iter == ($pagecount - 1)) {
						$cstr = 'class="end"';
					}
					echo '<a href="/profile_photos.php?id='.$_GET["id"].$dtarg.'&start='.$st.'" '.$cstr.'>'.($iter+1).'</a>';
				}
			}
		?>
		<span class="DateTime">&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $visiblephotocount; ?> photos)</span>
		

	
</div>



				
						</td>
						<td style="vertical-align:top;">
				<!--
				<h3 style="margin-top: 10px;">&raquo; <a href="/photos/underbunny/calendar/">Calendar view</a></h3>
				<h3 style="margin-top: 10px;">&raquo; <a href="/photos/underbunny/tags/">underbunny's tags</a></h3>
				-->
				<?php
				if($_SESSION["id"] == $_GET["id"]) {
					echo "<h3 style=\"margin-top: 10px;\">&raquo; <a href=\"/upload.php\">Upload</a></h3>
					<h3 style=\"margin-top: 10px;\">&raquo; <a href=\"/profile.php?id=" . $_GET["id"] . "\">Your profile</a></h3>";
				} else {
					echo "<h3 style=\"margin-top: 10px;\">&raquo; <a href=\"/profile.php?id=" . $_GET["id"] . "\">About ". $user->screen_name . "</a></h3>";
				}
				?>
				
				<br />
				<!--
				<h4>Search underbunny's photos</h4>
				<form action="/photos_search.gne" method="get">
				<input type="hidden" name="user" value="35034347254@N01">
				<input type="text" name="q" size="16">&nbsp;<input type="submit" class="SmallButt" value="SEARCH">
				</form>
				-->
				<?php if($_SESSION["id"] == $_GET["id"]) {
					echo "<p><b>Share your photos</b></p>
					<p>Did you know you can publish your photos on another website with a <a href=\"/badge.php\">". $website["instance_name"] . " badge</a>?</p>";
				} else {
					echo "<h3>Archive</h3>
				<p style=\"margin-left: 10px;\">";

					if ($dt != NULL) {
						echo '<a href="/profile_photos.php?id='.$_GET["id"].'">All photos</a> ('.$photo_count_act.')<br>';
					} else { 
						echo "<b>All photos</b> ($photo_count_act) <br>";
					}
					
					$stmt = $conn->prepare("SELECT * FROM photos WHERE uploaded_by=:t0 ORDER by uploaded_on ASC");
					$stmt->bindParam(':t0', $_GET['id']);
					$stmt->execute();
					$wantedtimestrcache = NULL;
					$photomonths = array();
					$count = 0; 
					$iter = 0;
					$itercache = 0;
					
					if($stmt->rowCount() > 0) {
						foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $photo) {
							$timestr = strtotime($photo->uploaded_on);
							$month = date("F",$timestr);
							$year = date("Y",$timestr);
							$wantedtimestr = $month . " " . $year;
							if ($wantedtimestr != $wantedtimestrcache) {
								$count = 1; 
								$itercache = $iter;
								$photomonths[$iter] = array($wantedtimestr, $count);
							} else {
								$count++;
								$photomonths[$itercache] = array($wantedtimestr, $count);
							}
							$wantedtimestrcache = $wantedtimestr;
							$iter++;
						}
					}
					
					foreach ($photomonths as $photomonth) {
						$skip = FALSE;
						if ($dt != NULL) {
							if (strtotime($photomonth[0]) == $dt) {
								echo "<b>".$photomonth[0]."</b> (".$photomonth[1].") <br>";
								$skip = TRUE;
							}
						}
						if ($skip == FALSE) {
							echo '<a href="/profile_photos.php?id='.$_GET["id"].'&dt='.strtotime($photomonth[0]).'">'.$photomonth[0].'</a> ('.$photomonth[1].')<br>';
						}
					}
				}
					?>
				</p>
						<!--
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
