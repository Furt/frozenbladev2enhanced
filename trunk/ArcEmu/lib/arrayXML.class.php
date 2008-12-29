<?php
function convertFaction($race) {
	if($race == 2 || $race == 5 ||$race == 6 || $race == 8 || $race == 10) {
		$race = '<img src="images/char/rank_default_1.gif" alt="Horde">';
		} else {
			$race = '<img src="images/char/rank_default_0.gif" alt="Alliance">';
		}
		return $race;
}
function convertMap($map) {
	switch($map) {
		case 0:
			$map = "Eastern Kingdoms";
		break;
		case 1:
			$map = "Kalimdor";
		break;
		case 13:
			$map = "Testing";
		break;
		case 25:
			$map = "Scott Test";
		break;
		default: // if it is nothing of the above, this will be used
			$map = "Unknown";
		break;
	}
	return $map;
}
?>