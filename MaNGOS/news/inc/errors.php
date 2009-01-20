<?php

/* Copyright (c) 2007-08 Alec Henriksen
 * phpns is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public Licence (GPL) as published by the Free
 * Software Foundation; either version 2 of the Licence, or (at your option) any
 * later version.
 * Please see the GPL at http://www.gnu.org/copyleft/gpl.html for a complete
 * understanding of what this license means and how to abide by it.
*/

// doesn't seem to do anything, commenting out until I find out otherwise.
//$live = "no";

//Arrays are created below for each custom error message.

$error['connection'] = '<p>Phpns could not contact the database server. This may happen when you have supplied the wrong information in the /inc/config.php file, or the server has been overloaded, and is denying requests from our system.</p>';

$error['database'] = "<p>Phpns couldn't select the database specified in the config.php file.</p>";

?>
