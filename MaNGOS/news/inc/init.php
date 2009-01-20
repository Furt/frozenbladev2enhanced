<?php

/* Copyright (c) 2007-08 Alec Henriksen
 * phpns is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public Licence (GPL) as published by the Free
 * Software Foundation; either version 2 of the Licence, or (at your option) any
 * later version.
 * Please see the GPL at http://www.gnu.org/copyleft/gpl.html for a complete
 * understanding of what this license means and how to abide by it.
*/

//initialize variables used in phpns
	$globalvars['pagetype'] = FALSE;
	if (!@$_COOKIE['cookie_auth']) { $_COOKIE['cookie_auth'] = FALSE; }
	if (!@$_GET['do']) { $_GET['do'] = FALSE; }
	$do = FALSE;

?>
