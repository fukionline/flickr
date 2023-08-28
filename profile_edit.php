<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/header.php"); 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/logincheck.php"); 

$fields = array("fname", "lname", "about", "site_addr", "site_name", "off_occ", "off_hometown", "off_city", "off_country", "things_interests", "things_books", "things_movies", "things_music");

$stmt = $conn->prepare("SELECT * FROM users WHERE id=:t0");
$stmt->bindParam(':t0', $user_id);
$stmt->execute();
foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $user);

if(isset($_POST["Submit"])) {
	
	foreach($fields as $field) {
		if(empty($_POST[$field])) {
			$_POST[$field] = NULL;
		}
	}
	
	// Variable hell
	$fname				= $_POST["fname"];
	$lname				= $_POST["lname"];
	$about 				= $_POST["about"];
	$site_addr 			= $_POST["site_addr"];
	$site_name 			= $_POST["site_name"];
	$off_occ 			= $_POST["off_occ"];
	$off_hometown 		= $_POST["off_hometown"];
	$off_city 			= $_POST["off_city"];
	$off_country 		= $_POST["off_country"];
	$things_interests 	= $_POST["things_interests"];
	$things_books 		= $_POST["things_books"];
	$things_movies 		= $_POST["things_movies"];
	$things_music 		= $_POST["things_music"];
	
	// SQL Hell
	$stmt = $conn->prepare("UPDATE users SET fname=:t0, lname=:t1, about=:t2, site_addr=:t3, site_name=:t4, off_occ=:t5, off_hometown=:t6, off_city=:t7, off_country=:t8, things_interests=:t9, things_books=:t10, things_movies=:t11, things_music=:t12 WHERE id=:uid");
	$stmt->bindParam(":t0", $fname);
	$stmt->bindParam(":t1", $lname);
	$stmt->bindParam(":t2", $about);
	$stmt->bindParam(":t3", $site_addr);
	$stmt->bindParam(":t4", $site_name);
	$stmt->bindParam(":t5", $off_occ);
	$stmt->bindParam(":t6", $off_hometown);
	$stmt->bindParam(":t7", $off_city);
	$stmt->bindParam(":t8", $off_country);
	$stmt->bindParam(":t9", $things_interests);
	$stmt->bindParam(":t10", $things_books);
	$stmt->bindParam(":t11", $things_movies);
	$stmt->bindParam(":t12", $things_music);
	$stmt->bindParam(":uid", $user_id);
	$stmt->execute();
	header("Location: /profile_edit.php");
}

?>
<h1><a href="#" style="text-decoration: none">Edit your profile</a> / Edit</h1>

	<table>
		<tr>
			<td id="Hint"> 
				<img src="/images/spaceball.gif" alt="spacer image" width="160" height="1"> 
			</td>
			
			<td id="GoodStuff" valign="top">
				<form method="post">
				<table style="margin-left: 27px">
					<tr>
						<td align="right"><b>First Name:</b></td>
						<td><input type="text" name="fname"  size="30" value="<?php echo htmlspecialchars($user->fname); ?>" /></td>
					</tr>
					<tr>
						<td align="right"><b>Last Name:</b></td>
						<td><input type="text" name="lname"  size="30" value="<?php echo htmlspecialchars($user->lname); ?>" /></td>
					</tr>
					<tr>
						<td valign="top" align="right"><b>Describe Yourself...</b></td>
						<td><textarea style="width:300px;height:120px" name="about"><?php echo htmlspecialchars($user->about); ?></textarea></td>
					</tr>
				</table>
				
				<h3>Online bits</h3>
				
				<table style="margin-left: 10px">
					<tr>
						<td align="right"><b>Your website address:</b></td>
						<td><input type="text" name="site_addr"  size="30" value="<?php echo htmlspecialchars($user->site_addr); ?>" /></td>
					</tr>		
					<tr>
						<td align="right"><b>Website name:</b></td>
						<td><input type="text" name="site_name"  size="30" value="<?php echo htmlspecialchars($user->site_name); ?>" /></td>
					</tr>
				</table>
				
				<h3>Offline bits</h3>
				
				<table style="margin-left: 27px">
					<tr>
						<td align="right"><b>Your Occupation:</b></td>
						<td><input type="text" name="off_occ"  size="30" value="<?php echo htmlspecialchars($user->off_occ); ?>" /></td>
					</tr>
					<tr>
						<td align="right"><b>Your Hometown:</b></td>
						<td><input type="text" name="off_hometown"  size="30" value="<?php echo htmlspecialchars($user->off_hometown); ?>" /></td>
					</tr>
					<tr>
						<td align="right"><b>City you live in now:</b></td>
						<td><input type="text" name="off_city"  size="30" value="<?php echo htmlspecialchars($user->off_city); ?>" /></td>
					</tr>
					<tr>
						<td align="right"><b>Country:</b></td>
						<td><input type="text" name="off_country"  size="30" value="<?php echo htmlspecialchars($user->off_country); ?>" /></td>
					</tr>
				</table>
				
				<h3>Things you like...</h3>
				<p>For the sections below, if you put in more than one thing please separate them with commas. Like this: -- > Tennis, Scrabble, Origami</p>
				
				<table>
					<tr>
						<td valign="top" align="right"><b>Interests:</b></td>
						<td><textarea style="width:300px;height:120px" name="things_interests"><?php echo htmlspecialchars($user->things_interests); ?></textarea></td>
					</tr>
					<tr>
						<td valign="top" align="right"><b>Favorite Books & Authors:</b></td>
						<td><textarea style="width:300px;height:120px" name="things_books"><?php echo htmlspecialchars($user->things_books); ?></textarea></td>
					</tr>
					<tr>
						<td valign="top" align="right"><b>Favorite Movies, Stars & Directors:</b></td>
						<td><textarea style="width:300px;height:120px" name="things_movies"><?php echo htmlspecialchars($user->things_movies); ?></textarea></td>
					</tr>
					<tr>
						<td valign="top" align="right"><b>Favorite Music & Artists:</b></td>
						<td><textarea style="width:300px;height:120px" name="things_music"><?php echo htmlspecialchars($user->things_music); ?></textarea></td>
					</tr>
				</table>
				
				<input name="Submit" type="submit" class="Butt" value="SAVE IT">
				</form>
				<p>Or, <a href="/profile.php?id=<?php echo $_SESSION["id"]; ?>">go back to your profile page</a>.</p>
			</td>
		</tr>
	</table>

<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/footer.php"); ?>