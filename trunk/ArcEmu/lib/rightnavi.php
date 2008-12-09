<!-- /**
* Project Name: FrozenBlade V2 Enhanced"
* Date: 25.07.2008 inital version
* Coded by: Furt
* Template by: Kitten - wowps forums
* Email: *****
* License: GNU General Public License (GPL)
  */ -->

<td width="144" valign="top">


	<!-- Create Account Image/Link -->
		
		<a href="#"><div class="join"></div></a>

	<!-- --------- -->


<div class="stats"></div><font class="style30"><center>


			<!-- Server Online/Offline Status PHP Script -->

					<?php    

					
							if (! $sock = @fsockopen($ip, $port, $num, $error, 5))
								echo "<img src='images/temp/server-off.png'>";
							else{
								echo "<img src='images/temp/server-on.png'>";
								fclose($sock);
								}      
            		?>

			<!-- PHP Script Created by DJRavine -->



</center>
&nbsp;				Realmlist:
<center>						<?php echo $config['RealmIP']; ?>
</center><br/>

</font><div class="vote"></div><center><font class="style10">
			

	<!-- Vote Links -->

		<a href="http://www.xtremetop100.com/world-of-warcraft/" target="_blank">
		<img src="images/friends+vote/xtremetop.jpg" border="0" class="opacity1"
		onmouseover="this.className='opacity2'" onmouseout="this.className='opacity1'">
		</a><br/><br/>
		
		<a href="http://www.wowserverslist.com/" target="_blank">
		<img src="images/friends+vote/wowservers.png" border="0" class="opacity1"
		onmouseover="this.className='opacity2'" onmouseout="this.className='opacity1'">
		</a><br/><br/>

	<!-- --------- -->


<br/></font></center><div class="affiliation"></div><font class="style10"><center>
			

	<!-- Affiliation Links -->
		
		<a href="http://wowps.org/forum/">
		<img src="images/friends+vote/wowps.jpg" border="0" class="opacity1"
		onmouseover="this.className='opacity2'" onmouseout="this.className='opacity1'">
		</a><br/><br/>
		
		<a href="http://virtue.nadasoft.net/">
		<img src="images/friends+vote/virtue.jpg" border="0" class="opacity1"
		onmouseover="this.className='opacity2'" onmouseout="this.className='opacity1'">
		</a><br/><br/>
		
		<a href="http://nadacod4.com/">
		<img src="images/friends+vote/nadacod4.gif" border="0" class="opacity1"
		onmouseover="this.className='opacity2'" onmouseout="this.className='opacity1'">
		</a><br/><br/>
		
		<a href="http://nadasoft.net/">
		<img src="images/friends+vote/nadasoft.jpg" border="0" class="opacity1"
		onmouseover="this.className='opacity2'" onmouseout="this.className='opacity1'">
		</a><br/><br/>

	<!-- --------- -->
	

</font><br/><br/><br/><br/></center></td>