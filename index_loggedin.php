<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/header.php"); 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/logincheck.php"); 

$stmt = $conn->prepare("SELECT * FROM users WHERE id=:t0");
$stmt->bindParam(':t0', $user_id);
$stmt->execute();
foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $user);

$greetings = array(
				"'Lo " . $user->screen_name . "! Tudo bem?",
				"Ahoy " . $user->screen_name . "!",
				"Hala " . $user->screen_name . "!",
				"Mabuhay " . $user->screen_name . "!",
				"Ni hao " . $user->screen_name . "!",
				"Kumusta " . $user->screen_name . "!",
				"Howdy " . $user->screen_name . "!",
				"Hi " . $user->screen_name . "!",
				"Hei " . $user->screen_name . "!",
				"Thar she blows, " . $user->screen_name . "!",
				"Guten Tag  " . $user->screen_name . "!",
				"Hello " . $user->screen_name . "!",
				"Yo " . $user->screen_name . "!",
				"Welcome " . $user->screen_name . "!",
				"Moyo " . $user->screen_name . "!",
				"Ola " . $user->screen_name . "!",
				"G'day " . $user->screen_name . "!",
				"Bonjour " . $user->screen_name . "!",
				"Tere " . $user->screen_name . "!",
				"Szia " . $user->screen_name . "!",
				"Kia ora " . $user->screen_name . "!",
				"Konnichiwa " . $user->screen_name . "!",
				"Aloha " . $user->screen_name . "!",
				"Sawubona " . $user->screen_name . "!",
				"Ahoj " . $user->screen_name . "!",
				"Merhaba, " . $user->screen_name . "!",
				"Oi " . $user->screen_name . "!",
				"Salaam " . $user->screen_name . "!",
				"Kaixo " . $user->screen_name . "!",
				"Mingalaba " . $user->screen_name . "!",
				"Hoi " . $user->screen_name . "!",
				"Salut " . $user->screen_name . "!",
				"Yasou " . $user->screen_name . "!",
				"Shalom " . $user->screen_name . "!",
				"Namaste " . $user->screen_name . "!",
				"Góðan daginn " . $user->screen_name . "!",
				"Fáilte " . $user->screen_name . "!",
				"Ciao " . $user->screen_name . "!",
				"Bangawoyo " . $user->screen_name . "!",
				"Labdien " . $user->screen_name . "!",
				"Mbote " . $user->screen_name . "!",
				"Olá " . $user->screen_name . "!",
				"Jambo " . $user->screen_name . "!",
				"Hej " . $user->screen_name . "!",
				"Moyo " . $user->screen_name . "!",
				"Sawubona " . $user->screen_name . "!",
				"Ya'at'eeh " . $user->screen_name . "!"
			);

?>

<h1><img src="<?php echo $user->display_picture; ?>" width="48" height="48" border="0" align="absmiddle" class="BuddyIconH"><?php echo array_rand(array_flip($greetings)); ?></h1>

	<table>
		<tr>
			<td id="Hint"> 
				<?php if($user->display_picture == "/images/buddyicon.jpg") {
					echo "<div class=\"StartAlert\">Create yourself a <a href=\"iconbuilder.php\">buddy icon!</a></div>";
				}
				?>
				<h3 style="margin-top: 10px;">&raquo; <a href="#">Your groups</a></h3>
				<h3 style="margin-top: 10px;">&raquo; <a href="#">Your contacts</a></h3>
				<h3 style="margin-top: 10px;">&raquo; <a href="profile_edit.php">Your profile</a></h3>
				<h3 style="margin-top: 10px;">&raquo; <a href="account.php">Your account</a></h3>
				<h3 style="margin-top: 10px;">&raquo; <a href="#"><?php echo $website["instance_name"]; ?> Mail</a></h3>
				<img src="/images/spaceball.gif" alt="spacer image" width="220" height="1"> 
			</td>
			
			<td id="GoodStuff" valign="top">
			<h3 style="margin-top: 10px;">&raquo; <a href="upload.php">Upload photos</a></h3>
			
				<div>
					<h3 style="margin-top: 10px; margin-bottom: 10px">&raquo; <a href="profile_photos.php?id=<?php echo $user_id; ?>">Your photos</a></h3>
					<?php
					$stmt = $conn->prepare("SELECT * from photos WHERE uploaded_by=$user_id ORDER BY id DESC LIMIT 4");
					$stmt->execute();
					foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $photo) {
						echo "<a href=\"/photo.php?id=". $photo->id . "\"><img src=\"/photos/" . $photo->id . ".t.jpg\" style=\"margin-left: 4px; margin-right: 14px\"></a>";
					}
					?>
				</div>

				<div>	
					<h3 style="margin-top: 10px; margin-bottom: 10px">&raquo; <a href="/photos.php">Everyone's photos</a></h3>
					<?php
					$stmt = $conn->prepare("SELECT * from photos ORDER BY id DESC LIMIT 4");
					$stmt->execute();
					foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $photo) {
						// Fetch user info
						$stmt = $conn->prepare("SELECT * FROM users WHERE id=:t0");
						$stmt->bindParam(':t0', $photo->uploaded_by);
						$stmt->execute();
						foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $uploader);
						echo "<p class=\"StreamList\">
						<a href=\"/photo.php?id=" . $photo->id . "\"><img src=\"/photos/" . $photo->id . ".t.jpg\" border=\"0\"></a><br>
						From <a href=\"/profile_photos.php?id=" . $photo->uploaded_by . "\">". $uploader->screen_name . "</a>
					</p>";
					}
					?>
				</div>
			<td>
			<img src="/images/spaceball.gif" alt="spacer image" width="10" height="1" style="border: none;"> 
			</td>
			</td>
		</tr>
	</table>

<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/footer.php"); ?>