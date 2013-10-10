<?php
/*

 Simple Image Rotation Script
 Version 1.0
 Marie-Lynn Richard
 http://marie-lynn.org
 May 1, 2012
 
 Latest Version, Notes and News here:
 http://marie-lynn.org/wp-db-header-rotation/#scroll
  
 This script functions as a replacement script for
 Matt Mullenweg's classic rotation script from 2003.
 http://ma.tt/scripts/randomimage/
 
 This script fetches a random image from the native
 WordPress gallery using the WordPress database of Media.
 
 This script lets you give your client control over
 their rotating images using native WordPress functionalities
 rather than using FTP.
 
 It is not a plugin, therefore the footpath and
 render time is minimal.
 
 All your images should be the right size.
 Works with WordPress 2.6+.
 Based on standard installs.
 Modify and distribute as you wish.
 
 HINTS:
 
 If you are rotating images of varying sizes,
 you can add Timthumb to this process at line 67.
 http://www.binarymoon.co.uk/projects/timthumb/
 
 INSTRUCTIONS:
 
 1. Edit the $wildcard with the name of your images.
 2. Upload all your images in WordPress' Media interface.
 3. Place this file in a folder named scripts in /wp-content
 4. Test your results by calling this file directly.
	at http://yourdomain.com/wp-content/scripts/rotator.php
 5. Change the value of $test to 0 so the script redirects to your image.
 6. In your theme, change the name of the image you wish to rotate to:
    /wp-content/scripts/rotator.php

*/

$test			= 0;                        // Change this value to 0 to
                                      // activate the image redirect
$folder			= '/wp-content/uploads/'; // Where you upload your files
$wildcard		= 'wildcard';             // Part of the name of your files

// Serving multiple random image groups? Uncomment the switch block and 
// Use as many cases then add ?place=case when calling this script

/*
switch ($_GET['place']) {
	case 'header':
        $wildcard = 'my_headers';
        break;
    case 'category':
        $wildcard = 'my_categories';
        break;
}
*/

/* Database information */
require_once '../../wp-config.php';

$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_select_db(DB_NAME);

$query =   "SELECT meta_value AS imagefile
			FROM `".$table_prefix."postmeta`
			WHERE meta_key = '_".$table_prefix."attached_file'
			AND meta_value LIKE '%$wildcard%'
			ORDER BY RAND()
			LIMIT 0,1";
$result	= mysql_query($query, $link) or die('failed:'.$query);
$row = mysql_fetch_array($result);
$file = $row['imagefile'];
$image = $folder.$file;

if($test==1){
	echo "<img src=$image><br>$image";
}else{
	header('Location: '.$image);
}
?>
