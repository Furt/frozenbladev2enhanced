	<div id="topBar"></div>
	<div id="page">
		<div id="page_header">
			<div><div></div></div>
		</div>
		<div id="page_content">
			<div id="page_content_wrapper">
				<div id="page_content_content">
					<div id="page_content_padding">
						<div id="header_bar">
							<div>
								<div><table style="margin-left:35px; height:38px; vertical-align:middle;"><tr><td><?php $this->Title(); ?></td></tr></table></span>
								</div>
							</div>
						</div><br />
						<div id="article">
							<?php $this->Content(); ?>
						</div>
						<div id="article" style="min-height:0px;">
							<table style="margin-left:10px;">
								<tr>
									<td><a href="../../../home.php">Main</a></td>
									<td>&bull;</td>
									<td><a href="?act=vote">Vote Now</a></td>
									<td>&bull;</td>
									<td><a href="?act=rewards">Spend Reward Points</a></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="page_footer">
			<div><div></div></div>
		</div>
	</div>
