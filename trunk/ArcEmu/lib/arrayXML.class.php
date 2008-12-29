<?php
function convertGender($gender) {
	if($gender == 1) {
		$gender = "Female";
		} else {
			$gender = "Male";
		}
		return $gender;
}
function convertFaction($race) {
	if($race == 2 || $race == 5 ||$race == 6 || $race == 8 || $race == 10) {
		$race = '<img src="images/char/rank_default_1.gif" alt="Horde">';
		} else {
			$race = '<img src="images/char/rank_default_0.gif" alt="Alliance">';
		}
		return $race;
}
?>