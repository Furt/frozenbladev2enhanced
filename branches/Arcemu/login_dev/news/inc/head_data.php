<?php

/* Copyright (c) 2007-08 Alec Henriksen
 * phpns is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public Licence (GPL) as published by the Free
 * Software Foundation; either version 2 of the Licence, or (at your option) any
 * later version.
 * Please see the GPL at http://www.gnu.org/copyleft/gpl.html for a complete
 * understanding of what this license means and how to abide by it.
*/

//This is the 'default' javascript that should be included with every theme/page

$head_data['wysiwyg'] = '
<link rel="alternate" type="application/rss+xml" title="phpns rss feed" href="etc.php?do=rss"/>
<script language="javascript" type="text/javascript" src="inc/js/tinymce/tiny_mce_gzip.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE_GZ.init({
		theme : "advanced",
		mode : "exact",
		elements : "main, full",
		apply_source_formatting : true,
		content_css : "example_advanced.css",
		extended_valid_elements : "a[href|target|name]",
		plugins : "table",
		theme_advanced_toolbar_location : "top",
		theme_advanced_buttons1 : "forecolor,backcolor,separator,bold,italic,underline,separator,link,unlink,image,separator,bullist,numlist,separator,indent,outdent,separator,justifyleft,justifycenter,justifyright,separator,hr,separator,tablecontrols,separator,charmap,formatselect",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		//theme_advanced_buttons2_add : "forecolor,backcolor,seperator",
		//theme_advanced_buttons3_add_before : "tablecontrols,separator",
		//invalid_elements : "a",
		 theme_advanced_path_location : "bottom",
    theme_advanced_resizing : true,
    theme_advanced_resize_horizontal : false,
		theme_advanced_styles : "Header 1=header1;Header 2=header2;Header 3=header3;Table Row=tableRow1", // Theme specific setting CSS classes
		//execcommand_callback : "myCustomExecCommandHandler",
		fix_list_elements : true,
		debug : false
	});
</script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		theme : "advanced",
		mode : "exact",
		elements : "main",
		apply_source_formatting : true,
		content_css : "example_advanced.css",
		extended_valid_elements : "a[href|target|name]",
		plugins : "table",
		theme_advanced_toolbar_location : "top",
		theme_advanced_buttons1 : "forecolor,backcolor,separator,bold,italic,underline,separator,link,unlink,image,separator,bullist,numlist,separator,indent,outdent,separator,justifyleft,justifycenter,justifyright,separator,hr,separator,tablecontrols,separator,charmap,formatselect",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		//theme_advanced_buttons1_add_before : "forecolor,backcolor,separator",
		//theme_advanced_buttons3_add_before : "tablecontrols,separator",
		//invalid_elements : "a",
		 theme_advanced_path_location : "bottom",
		 fix_list_elements : true,
    theme_advanced_resizing : true,
    theme_advanced_resize_horizontal : false,
		//execcommand_callback : "myCustomExecCommandHandler",
		debug : false
	});
</script>
';

$head_data['tour'] = '
<script type="text/javascript" src="inc/js/tour/amberjack.pack.js"></script>
';

$head_data['tour_text'] = '
<!-- Tour created with Amberjack wizard: http://amberjack.org -->
	<div class="ajTourDef" id="phpns" style="display:none">
		<div title="index.php">
			<strong>Index</strong>
			<p>This is the phpns index, where you can view some statistics and latest articles. This is the page that you will be sent to after a successful login.</p>
		</div>
		
		<div title="article.php">
			<strong>New Article</strong>
			<p>In this page, you create an article in a WYSIWYG (What You See Is What You Get) environment. This will result in a very professional and clean news post. To simplify the process, you only need two fields: the title, and the main article.</p>
		</div>
		
		<div title="manage.php">
			<strong>Article Management</strong>
			<p>The article management page will let you edit/delete/search articles that have been posted on phpns.</p>
			<p>To edit an article, simply click on the title (or hover over the row, and click the edit icon). To delete articles, you can "tick" the box on each row, and click "Delete Selected" on the bottom of the page.</p>
		</div>
		
		<div title="user.php">
			<strong>User Management</strong>
			<p>The User management lets you create, delete, and edit current users and their settings.</p>
			<p>To edit a user, click on the username in the row (or hover over the row, and click the edit icon). To delete users, simply "tick" the box on each row, and click "Delete Selected" on the bottom of the page.</p>
		</div>
		
		<div title="preferences.php">
			<strong>Preferences</strong>
			<p>The preferences page will give you a list of things you can change on phpns. Configuration options include: RSS and ATOM, clean URLs, templates, categories, and much more.</p>
		</div>
		
		<div title="about.php">
			<strong>About</strong>
			<p>The about page is where you can find out information about the developers who created phpns and how to contact them. You can also check if your phpns installation is up to date. Legal information and licensing information is also included.</p>
		</div>
	</div>
	<script type="text/javascript" defer="true">
		Amberjack.onCloseClickStay = true;
		Amberjack.BASE_URL = \'inc/js/tour/\';
		Amberjack.ADD_STYLE = \'inc/js/tour/skin/black_beauty/style.css\';
		Amberjack.open();
	</script>
';

$head_data['other_js'] = '
<script language="javascript" type="text/javascript">
	function togglewysiwyg(id) {
		var elm = document.getElementById(id);
		if (tinyMCE.getInstanceById(id) == null)
			tinyMCE.execCommand(\'mceAddControl\', false, id);
		else
			tinyMCE.execCommand(\'mceRemoveControl\', false, id);
	}
		
	function expandwysiwyg(id) {
		var expelm = document.getElementById(id);
		var expstyle = expelm.style.height;
		document.getElementById(id).style.height = "500px";
		togglewysiwyg(id);
		togglewysiwyg(id);
	}
		
	function Checkall(form) { 
		for (var i = 1; i < form.elements.length; i++) {    
			eval("form.elements[" + i + "].checked = form.elements[0].checked");  
		} 
	}

	function new_window(url) {
		var newwindow;
		newwindow=window.open(url,\'name\',\'height=500,width=710,left=100,top=100,resizable=yes,scrollbars=yes,status=yes\');
		if (window.focus) {
			newwindow.focus()
		}
	}
	
	function expand() {
		for (var i=0; i<expand.arguments.length; i++) {
			var element = document.getElementById(expand.arguments[i]);
			element.style.display = (element.style.display == "none") ? "block" : "none";

		}
	}
</script>
<script language="javascript" type="text/javascript" src="inc/js/highlight.js"></script>
<script src="inc/js/codepress/codepress.js" type="text/javascript"></script>
';

//end head declarations
?>
