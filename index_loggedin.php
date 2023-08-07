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

<h1><img src="<?php echo $user->display_picture; ?>" width="48" height="48" border="0" align="absmiddle" class="BuddyIconH"> <?php echo array_rand(array_flip($greetings)); ?></h1>

	<table>
		<tr>
			<td id="Hint"> 
				<?php if($user->display_picture == "/images/buddyicon.jpg") {
					echo "<div class=\"StartAlert\">Create yourself a <a href=\"iconbuilder.php\">buddy icon!</a></div>";
				}
				?>
				<h3>Other things to do</h3>
				<p>
					&raquo; <a href="profile?user=<?php echo $user_id; ?>">View your own profile</a><br>
						<p style="background: #ECF1FD; padding: 5px;padding-left: 10px">
							&raquo; <a href="edit_profile.php">Your profile</a><br>
							&raquo; <a href="account.php">Your account</a>
						</p>
					&raquo; <a href="#">Most popular images</a><br>
				</p>
				<img src="/images/spaceball.gif" alt="spacer image" width="220" height="1"> 
			</td>
			
			<td id="GoodStuff" valign="top">
				<p class="Focus" style="background: #ECF1FD; padding: 5px;padding-left: 10px">&raquo; <a href="upload.php">Upload your photo</a></p>
				<h3 style="border-bottom: 1px solid #e6e6e6;">Your contacts</h3>
				<p>You haven't hooked up with any friends on <?php echo $website["instance_name"]; ?> yet.</p>
				<p>Feel free to introduce yourself to one of the <?php echo $website["instance_name"]; ?> Dev Team. We're here to help!</p>
				<p>Or, you might like to <a href="#">invite some of your friends</a> to join up too!</p>
				
				<td valign="top">
					<h3 style="border-bottom: 1px solid #e6e6e6; margin-top: -5px">Your groups</h3>
					<p>[TO BE ADDED]</p>
					<img src="/images/spaceball.gif" alt="spacer image" width="180" height="1" style="border: none;">
				</td>
				
			</td>
		</tr>
	</table>


<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/footer.php"); ?>