<?php

// ----------------------------------------------------- //
// REDIRECT
function redirect($url, $seconds = FALSE) {
    if (!headers_sent() && $seconds == FALSE) { 
	header("Location:".$url);
    } else {
        if ($seconds == FALSE) { 
			$seconds = "0";
        }
		echo "<meta http-equiv=\"refresh\" content=\"$seconds;url=$url\">";
    }
}

// ----------------------------------------------------- //
// CLEAN INPUT
// This function clean a string to prevent query injection

function cleanInput($input){
return trim(ereg_replace("<[^>]*>","",$input));
}
	

?>