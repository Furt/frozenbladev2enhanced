<?php
/* Copyright 2008 by zerophr34k.com */
function xml2array($text) {
	$reg_exp = '/<(.*?)>(.*?)<\/\\1>/s';
	preg_match_all($reg_exp, $text, $match);
	foreach ($match[1] as $key=>$val) {
		if (preg_match($reg_exp, $match[2][$key])) {
			$array[$val][] = xml2array($match[2][$key]);
		} else {
			$array[$val] = $match[2][$key];
		}
	}
	return $array;
}

class StatsXML {
	//  ///// Variables /////
	var $info;
	//  ///// Constructor /////
	function StatsXML($file) {
		$xml = file_get_contents($file);
		// ATTENTION: DON'T modify the following 2 rows!
		$bad = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<?xml-stylesheet type=\"text/xsl\" href=\"server_stats.xsl\"?>";
		$good = "";
		$xml = str_replace($bad, $good, $xml);
		$this->info = xml2array($xml);
	}
	//  ///// Functions /////
	function getAll() {
		return $this->info;
	}
	
	function getLatency() {
		return $this->info['serverpage'][0]['status'][0]['avglat'];
	}
	function getGMcount() {
		return $this->info['serverpage'][0]['status'][0]['gmcount'];
	}
	function getOnlinePlayers() {
		return $this->info['serverpage'][0]['status'][0]['oplayers'];
	}
	
	function getUptime() {
		return $this->info['serverpage'][0]['status'][0]['uptime'];
	}
	
	function getHorde() {
		return $this->info['serverpage'][0]['status'][0]['horde'];
	}
	
	function getAlliance() {
		return $this->info['serverpage'][0]['status'][0]['alliance'];
	}
	
	function getGMs() {
		return $this->info['serverpage'][0]['status'][0]['gmcount'];
	}
	
	function getConPeak() {
		return $this->info['serverpage'][0]['status'][0]['peakcount'];
	}
	
	function getServerVersion() {
		return $this->info['serverpage'][0]['status'][0]['platform'];
	}
	
	function getPlayersArray() {
		return $this->info['serverpage'][0]['sessions'][0]['plr'];
	}
	function getGMsArray() {
		return $this->info['serverpage'][0]['gms'][0]['gmplr'];
	}
}
?>