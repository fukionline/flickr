<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/header.php"); 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/logincheck.php"); 
?>
<script>
function copy() {
  const element = document.querySelector('#textarea');
  element.select();
  element.setSelectionRange(0, 99999);
  document.execCommand('copy');
}
</script>
<h1>Create your own <?php echo $website["instance_name"];?> badge</h1>

	<table>
		<tr>
			<td id="Hint">
				<h4>Preview</h4>
				<script type="text/javascript" src="badge_code.php?nsid=<?php echo $user_id; ?>&count=10&display=latest&name=1&size=thumb&raw=0"></script>
				<img src="/images/spaceball.gif" alt="spacer image" width="100" height="1">
			</td>
			
			<td id="GoodStuff" valign="top">
				<p>Currently there's no reference regarding the html badge page, so i might aswell just do this.</p>
<textarea style="width: 400px;height: 270px" id="textarea">
<!-- <?php echo $website["instance_name"]; ?> Badge Start -->
<script type="text/javascript"> 
<!-- 
flickr_badge_background_color = ""; 
flickr_badge_border = ""; 
flickr_badge_width = "120px"; 
flickr_badge_text_font = "11px Arial, Helvetica, Sans serif"; 
flickr_badge_image_border = "1px solid #000000"; 
flickr_badge_link_color = ""; 
-->
</script>
<script type="text/javascript" src="//<?php echo $_SERVER["SERVER_NAME"]; ?>/badge_code.php?nsid=<?php echo $user_id; ?>&count=10&display=latest&name=1&size=thumb&raw=1"></script>
<!-- <?php echo $website["instance_name"]; ?> Badge End -->
</textarea><br>
<center><input type="submit" class="SmallButt" value="COPY TO CLIPBOARD" style="padding: 5px" onclick="copy();"></center>
			<td width="200" valign="top">
			<div class="MakeBadge">
				<h4>Modifiable Parameters</h4>
				<ul>
					<li>&nsid = Your user ID.</li>
					<li>&count = Amount of photos</li>
					<li>&display = Either "latest" or "random"</li>
					<li>&name = Display your screen name</li>
					<li>&size = Can be either "thumb", or "mid"</li>
					<li>&raw = Set to 1 for no styling, 0 for styling</li>
				</ul>
			</div>
			<img src="/images/spaceball.gif" alt="spacer image" width="200" height="1" style="border: none;">
			</td>
			</td>
		</tr>
	</table>

<?php require("incl/footer.php"); ?>