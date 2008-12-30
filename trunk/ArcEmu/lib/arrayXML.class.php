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
		case 29:
			$map = "CashTest";
		break;
		case 30:
			$map = "Alterac Valley";
		break;
		case 33:
			$map = "Shadowfang Keep";
		break;
		case 34:
			$map = "Stormwind Stockade";
		break;
		case 35:
			$map = "Stormwind Prison";
		break;
		case 36:
			$map = "Deadmines";
		break;
		case 37:
			$map = "Azshara Crater";
		break;
		case 42:
			$map = "Collin's Test";
		break;
		case 43:
			$map = "Wailing Caverns";
		break;
		case 44:
			$map = "Monastery";
		break;
		case 47:
			$map = "Razorfen Kraul";
		break;
		case 48:
			$map = "Blackfathom Deeps";
		break;
		case 70:
			$map = "Uldaman";
		break;
		case 90:
			$map = "Gnomeregan";
		break;
		case 109:
			$map = "Sunken Temple";
		break;
		case 129:
			$map = "Razorfen Downs";
		break;
		case 169:
			$map = "Emerald Dream";
		break;
		case 189:
			$map = "Scarlet Monastery";
		break;
		case 209:
			$map = "Zul'Farrak";
		break;
		case 229:
			$map = "Blackrock Spire";
		break;
		case 230:
			$map = "Blackrock Depths";
		break;
		case 249:
			$map = "Onyxia's Lair";
		break;
		case 269:
			$map = "Opening of the Dark Portal";
		break;
		case 289:
			$map = "Scholomance";
		break;
		case 309:
			$map = "Zul'Gurub";
		break;
		case 329:
			$map = "Stratholme";
		break;
		case 349:
			$map = "Maraudon";
		break;
		case 369:
			$map = "Deeprun Tram";
		break;
		case 389:
			$map = "Ragefire Chasm";
		break;
		case 409:
			$map = "Molten Core";
		break;
		case 429:
			$map = "Dire Maul";
		break;
		case 449:
			$map = "Alliance PVP Barracks";
		break;
		case 450:
			$map = "Horde PVP Barracks";
		break;
		case 451:
			$map = "Development Land";
		break;
		case 469:
			$map = "Blackwing Lair";
		break;
		case 489:
			$map = "Warsong Gulch";
		break;
		case 509:
			$map = "Ruins of Ahn'Qiraj";
		break;
		case 529:
			$map = "Arathi Basin";
		break;
		case 530:
			$map = "Outland";
		break;
		case 531:
			$map = "Ahn'Qiraj Temple";
		break;
		case 532:
			$map = "Karazhan";
		break;
		case 533:
			$map = "Naxxramas";
		break;
		case 534:
			$map = "The Battle for Mount Hyjal";
		break;
		case 540:
			$map = "Hellfire Citadel: The Shattered Halls";
		break;
		case 542:
			$map = "Hellfire Citadel: The Blood Furnace";
		break;
		case 543:
			$map = "Hellfire Citadel: Ramparts";
		break;
		case 544:
			$map = "Magtheridon's Lair";
		break;
		case 545:
			$map = "Coilfang: The Steamvault";
		break;
		case 546:
			$map = "Coilfang: The Underbog";
		break;
		case 547:
			$map = "Coilfang: The Slave Pens";
		break;
		case 550:
			$map = "Tempest Keep";
		break;
		case 552:
			$map = "Tempest Keep: The Arcatraz";
		break;
		case 553:
			$map = "Tempest Keep: The Botanica";
		break;
		case 554:
			$map = "Tempest Keep: The Mechanar";
		break;
		case 555:
			$map = "Auchindoun: Shadow Labrinth";
		break;
		case 556:
			$map = "Auchindoun: Sethekk Halls";
		break;
		case 557:
			$map = "Auchindoun: Mana-Tombs";
		break;
		case 558:
			$map = "Auchindoun: Auchenai Crypts";
		break;
		case 559:
			$map = "Nagrand Arena";
		break;
		case 560:
			$map = "The Escape From Durnholde";
		break;
		case 562:
			$map = "Blade's Edge Arena";
		break;
		case 564:
			$map = "Gruul's Lair";
		break;
		case 565:
			$map = "Eye of the Storm";
		break;
		case 568:
			$map = "Zul'Aman";
		break;
		default: // if it is nothing of the above, this will be used
			$map = "Unknown";
		break;
	}
	return $map;
}
function convertZone($areaid) {
	switch($areaid) {
		case 1:
			$areaid = "Dun Morogh";
		break;
		case 2:
			$areaid = "Longshore";
		break;
		case 3:
			$areaid = "Badlands";
		break;
		case 4:
			$areaid = "Blasted Lands";
		break;
		case 7:
			$areaid = "Blackwater Cove";
		break;
		case 8:
			$areaid = "Swamp of Sorrows";
		break;
		case 9:
			$areaid = "Northshire Valley";
		break;
		case 10:
			$areaid = "Duskwood";
		break;
		case 11:
			$areaid = "Wetlands";
		break;
		case 12:
			$areaid = "Elwynn Forest";
		break;
		case 13:
			$areaid = "The World Tree";
		break;
		case 14:
			$areaid = "Durotar";
		break;
		case 15:
			$areaid = "Dustwallow Marsh";
		break;
		case 16:
			$areaid = "Azshara";
		break;
		case 17:
			$areaid = "The Barrens";
		break;
		case 18:
			$areaid = "Crystal Lake";
		break;
		case 19:
			$areaid = "Zul'Gurub";
		break;
		case 20:
			$areaid = "Moonbrook";
		break;
		case 21:
			$areaid = "Kul Tiras";
		break;
		case 22:
			$areaid = "Programmer Isle";
		break;
		case 23:
			$areaid = "Northshire River";
		break;
		case 24:
			$areaid = "Northshire Abbey";
		break;
		case 25:
			$areaid = "Blackrock Mountain";
		break;
		case 26:
			$areaid = "Lighthouse";
		break;
		case 28:
			$areaid = "Western Plaquelands";
		break;
		case 30:
			$areaid = "Nine";
		break;
		case 32:
			$areaid = "The Cemetary";
		break;
		case 33:
			$areaid = "Stranglethorn Vale";
		break;
		case 34:
			$areaid = "Echo Ridge Mine";
		break;
		case 35:
			$areaid = "Booty Bay";
		break;
		case 36:
			$areaid = "Alterac Mountains";
		break;
		case 37:
			$areaid = "Lake Nazferiti";
		break;
		case 38:
			$areaid = "Loch Modan";
		break;
		case 40:
			$areaid = "Westfall";
		break;
		case 41:
			$areaid = "Deadwind Pass";
		break;
		case 42:
			$areaid = "Darkshire";
		break;
		case 43:
			$areaid = "Wild Shore";
		break;
		case 44:
			$areaid = "Redridge Mountains";
		break;
		case 45:
			$areaid = "Arathi Highlands";
		break;
		case 46:
			$areaid = "Burning Steppes";
		break;
		case 47:
			$areaid = "The Hinterlands";
		break;
		case 49:
			$areaid = "Dead Man's Hole";
		break;
		case 51:
			$areaid = "Searing Gorge";
		break;
		case 53:
			$areaid = "Thieves Camp";
		break;
		case 54:
			$areaid = "Jasperlode Mine";
		break;
		case 55:
			$areaid = "Valley of Heroes";
		break;
		case 56:
			$areaid = "Heroes' Vigil";
		break;
		case 57:
			$areaid = "Forgodeep Mine";
		break;
		case 59:
			$areaid = "Northshire Vineyards";
		break;
		case 60:
			$areaid = "Forest's Edge";
		break;
		case 61:
			$areaid = "Thunder Falls";
		break;
		case 62:
			$areaid = "Brackwell Pumpkin Patch";
		break;
		case 63:
			$areaid = "The Stonefield Farm";
		break;
		case 64:
			$areaid = "The Maclure Vineyards";
		break;
		case 65:
			$areaid = "***On Map Dungeon***";
		break;
		case 66:
			$areaid = "***On Map Dungeon***";
		break;
		case 67:
			$areaid = "***On Map Dungeon***";
		break;
		case 68:
			$areaid = "Lake Everstill";
		break;
		case 69:
			$areaid = "Lakeshire";
		break;
		case 70:
			$areaid = "Stonewatch";
		break;
		case 71:
			$areaid = "Stonewatch Falls";
		break;
		case 72:
			$areaid = "The Dark Portal";
		break;
		case 73:
			$areaid = "The Tainted Scar";
		break;
		case 74:
			$areaid = "Pool of Tears";
		break;
		case 75:
			$areaid = "Stonard";
		break;
				default: // if it is nothing of the above, this will be used
			$areaid = "Unknown";
		break;
	}
	return $areaid;
}
?>