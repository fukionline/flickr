// Next comes the standard javascript detection that uses the 
// navigator.plugins array. We pack the detector into a function so it loads
// before we run it.

function detectFlash() {  
  // If navigator.plugins exists...
  if (navigator.plugins) {
    // ...then check for flash 2 or flash 3+.
    if (navigator.plugins["Shockwave Flash 2.0"]
        || navigator.plugins["Shockwave Flash"]) {

      // Some version of Flash was found. Time to figure out which.
      
      // Set convenient references to flash 2 and the plugin description.
      var isVersion2 = navigator.plugins["Shockwave Flash 2.0"] ? " 2.0" : "";
      flashDescription = navigator.plugins["Shockwave Flash" + isVersion2].description;

      // DEBUGGING: uncomment next line to see the actual description.
      // alert("Flash plugin description: " + flashDescription);
      
      // A flash plugin-description looks like this: Shockwave Flash 4.0 r5
      // We can get the major version by grabbing the character before the period
      // note that we don't bother with minor version detection. 
      // Do that in your movie with $version or getVersion().
      var flashVersion = parseInt(flashDescription.charAt(flashDescription.indexOf(".") - 1));
     
      // We found the version, now set appropriate version flags. Make sure
      // to use >= on the highest version so we don't prevent future version
      // users from entering the site.
      flash2Installed = flashVersion == 2;    
      flash3Installed = flashVersion == 3;
      flash4Installed = flashVersion == 4;
      flash5Installed = flashVersion == 5;
      flash6Installed = flashVersion == 6;
      flash7Installed = flashVersion >= 7;
    }
  }
  
  // Loop through all versions we're checking, and
  // set actualVersion to highest detected version.
  for (var i = 2; i <= maxVersion; i++) {  
    if (eval("flash" + i + "Installed") == true) actualVersion = i;
  }
  // If we're on webtv, the version supported is 2 (pre-summer2000, 
  // or 3, post-summer2000). Note that we don't bother sniffing varieties
  // of webtv. You could if you were sadistic...
  if(navigator.userAgent.indexOf("WebTV") != -1) actualVersion = 3;  
  
  // DEBUGGING: uncomment next line to display flash version
  // alert("version detected: " + actualVersion);


  // We're finished getting the version on all browsers that support detection.
  // Time to take the appropriate action.

  // If the user has a new enough version...
  if (actualVersion >= requiredVersion) {
    // ...then we'll redirect them to the flash page, unless we've
    // been told not to redirect.
    if (useRedirect) {
      // Need javascript1.1 to do location.replace
      if(jsVersion > 1.0) {
        // It's safe to use replace(). Good...we won't break the back button.
        window.location.replace(flashPage);  
      } else {
        // JavaScript version is too old, so use .location to load
        // the flash page.
        window.location = flashPage;
      }
    }
    
    // If we got here, we didn't redirect. So we make a note that we should
    // write out the object/embed tags later.
    hasRightVersion = true;                
  } else {  
    // The user doesn't have a new enough version.
    // If the redirection option is on, load the appropriate alternate page.
    if (useRedirect) {
      // Do the same .replace() call only if js1.1+ is available.
      if(jsVersion > 1.0) {
        window.location.replace((actualVersion >= 2) ? upgradePage : noFlashPage);
      } else {
        window.location = (actualVersion >= 2) ? upgradePage : noFlashPage;
      }
    }
  }
}


detectFlash();  // call our detector now that it's safely loaded.  