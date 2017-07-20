<?php
/*
	Plugin Name: flash_image_carousel
	Plugin URI: http://www.webpsilon.com/wordpress-plugins/flash-image-carousel/
	Description: Flash Image Carousel in Actionscript 3.
	Version: 0.1
	Author: Webpsilon
	Author URI: http://www.webpsilon.com/wordpress-plugins
*/	
$contador=0;
function flash_image_carousel_head() {
	
	$site_url = get_option( 'siteurl' );
			echo '<script src="' . $site_url . '/wp-content/plugins/flash-image-carousel/Scripts/swfobject_modified.js" type="text/javascript"></script>';
			
}
function flash_image_carousel($content){
	$content = preg_replace_callback("/\[flash_image_carousel ([^]]*)\/\]/i", "flash_image_carousel_render", $content);
	return $content;
	
}

function flash_image_carousel_render($tag_string){
$contador=rand(9, 9999999);
	$site_url = get_option( 'siteurl' );
global $wpdb; 	
$table_name = $wpdb->prefix . "flash_image_carousel";	


if(isset($tag_string[1])) {
	$auxi1=str_replace(" ", "", $tag_string[1]);
	$myrows = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = ".$auxi1.";" );
}
if(count($myrows)<1) $myrows = $wpdb->get_results( "SELECT * FROM $table_name;" );
	$conta=0;
	$id= $myrows[$conta]->id;
	$row= $myrows[$conta]->row;
	$folder = $myrows[$conta]->folder;
	$zoom = $myrows[$conta]->zoom;
	$speed = $myrows[$conta]->speed;
	$onover = $myrows[$conta]->onover;
	$vertical = $myrows[$conta]->vertical;
	$transparency = $myrows[$conta]->transparency;
	$target = $myrows[$conta]->target;
	$width = $myrows[$conta]->width;
	$height = $myrows[$conta]->height;
	$imageslink = $myrows[$conta]->imageslink;
	$links = $myrows[$conta]->links;
	$titles = $myrows[$conta]->titles;
	
	
		$type 		= 'png';
		$type1 		= 'jpg';
		$type2 		= 'gif';
		
		$files	= array();
		$images	= array();

		$dir = $folder;

		// check if directory exists
		if (is_dir($dir))
		{
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != '.' && $file != '..' && $file != 'CVS' && $file != 'index.html' ) {
						$files[] = $file;
					}
				}
			}
			closedir($handle);

			$i = 0;
			foreach ($files as $img)
			{
				if (!is_dir($dir .DS. $img))
				{
					if (eregi($type, $img) || eregi($type1, $img)|| eregi($type2, $img)) {
						$images[$i]->name 	= $img;
						$images[$i]->folder	= $folder;
						++$i;
					}
				}
			}
			$cantidad=$i;
		}
		else $cantidad=0;




	$texto='';
	$texto='cantidad='.$cantidad.'&row='.$row.'&colorbordes='.'cccccc'.'&colortextos='.'cccccc'.'&vertical='.$vertical.'&zoom1='.$zoom.'&zoom2='.'1'.'&target='.$target.'&onlink='.$imageslink.'&speed='.$speed.'&mouseover='.$onover.'&alpha='.$transparency;
	$conta=0;
	
	$links=split("\n", $titles);
$imagesc=split("\n", $links);
	sort($images);
			foreach ($images as $img)
			{
 					$auxi1c="";
 					$auxi2c="";
					if(isset($links[$conta])) $auxi1c=$links[$conta];
					if(isset($imagesc[$conta])) $auxi2c=$imagesc[$conta];
					
					if ($imageslink==0) $texto.='&imagen'.$conta.'='.$site_url.'/'.$folder.''.$img->name.'&title'.$conta.'='.$auxi1c.'&link'.$conta.'='.$auxi2c;
					else{
					$texto.='&imagen'.$conta.'='.$site_url.'/'.$folder.''.$img->name.'&title'.$conta.'='.$auxi1c.'&link'.$conta.'='.$folder.$img->name;
					
					}
				
					$conta++;

			}
	
	
	$table_name = $wpdb->prefix . "flash_image_carousel";
	$saludo= $wpdb->get_var("SELECT id FROM $table_name ORDER BY RAND() LIMIT 0, 1; " );
	$output='
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'.$width.'" height="'.$height.'" id="Carousel'.$id.'-'.$contador.'" title="Image Flash carousel">
  <param name="movie" value="'.$site_url.'/wp-content/plugins/flash-image-carousel/mod_flash_rotator.swf" />
  <param name="quality" value="high" />
  <param name="wmode" value="transparent" />
  	<param name="flashvars" value="'.$texto.'" />
  <param name="swfversion" value="9.0.45.0" />
  <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
  <param name="expressinstall" value="'.$site_url.'/wp-content/plugins/flash-image-carousel/Scripts/expressInstall.swf" />
  <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
  <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="'.$site_url.'/wp-content/plugins/flash-image-carousel/mod_flash_rotator.swf" width="'.$width.'" height="'.$height.'">
    <!--<![endif]-->
    <param name="quality" value="high" />
    <param name="wmode" value="transparent" />
    	<param name="flashvars" value="'.$texto.'" />
    <param name="swfversion" value="9.0.45.0" />
    <param name="expressinstall" value="'.$site_url.'/wp-content/plugins/flash-image-carousel/Scripts/expressInstall.swf" />
    <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
    <div>
      <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
    </div>
    <!--[if !IE]>-->
  </object>
  <!--<![endif]-->
</object>
<script type="text/javascript">
<!--
swfobject.registerObject("Carousel'.$id.'-'.$contador.'");
//-->
</script><h6>
<a href="http://www.webpsilon.com/wordpress-plugins/flash-image-carousel/" title="Download Flash image carousel plugin for wordpress">Test Flash image carousel</a> <a href="http://www.posicionamientoenbuscadores.es/" title="Posicionamiento web" >Posicionamiento web
</a></h6>';
	return $output;
}
function flash_image_carousel_instala(){
	global $wpdb; 
	$table_name= $wpdb->prefix . "flash_image_carousel";
   $sql = " CREATE TABLE $table_name(
		id mediumint( 9 ) NOT NULL AUTO_INCREMENT ,
		row tinytext NOT NULL ,
		folder tinytext NOT NULL ,
		zoom tinytext NOT NULL ,
		speed tinytext NOT NULL ,
		onover tinytext NOT NULL ,
		links tinytext NOT NULL ,
		titles tinytext NOT NULL ,
		vertical tinytext NOT NULL ,
		target tinytext NOT NULL ,
		transparency tinytext NOT NULL ,
		width tinytext NOT NULL ,
		height tinytext NOT NULL ,
		imageslink tinytext NOT NULL ,
		PRIMARY KEY ( `id` )	
	) ;";
	$wpdb->query($sql);
	$sql = "INSERT INTO $table_name (row, folder, zoom, speed, onover, links, titles, vertical, target, transparency, width, height, imageslink) VALUES ('1', 'wp-content/plugins/flash-image-carousel/images/', '1', '1', '1', '', '', '0', '_blank', '0', '100%', '250px', '0');";
	$wpdb->query($sql);
}
function flash_image_carousel_desinstala(){
	global $wpdb; 
	$table_name = $wpdb->prefix . "flash_image_carousel";
	$sql = "DROP TABLE $table_name";
	$wpdb->query($sql);
}	
function flash_image_carousel_panel(){
	global $wpdb; 
	$table_name = $wpdb->prefix . "flash_image_carousel";	
	
	if(isset($_POST['crear'])) {
		$re = $wpdb->query("select * from $table_name");
//autos  no existe
if(empty($re))
{
  $sql = " CREATE TABLE $table_name(
		id mediumint( 9 ) NOT NULL AUTO_INCREMENT ,
		row tinytext NOT NULL ,
		folder tinytext NOT NULL ,
		zoom tinytext NOT NULL ,
		speed tinytext NOT NULL ,
		onover tinytext NOT NULL ,
		links tinytext NOT NULL ,
		titles tinytext NOT NULL ,
		vertical tinytext NOT NULL ,
		target tinytext NOT NULL ,
		transparency tinytext NOT NULL ,
		width tinytext NOT NULL ,
		height tinytext NOT NULL ,
		imageslink tinytext NOT NULL ,
		PRIMARY KEY ( `id` )	
	) ;";
	$wpdb->query($sql);

}
		
		$sql = "INSERT INTO $table_name (row, folder, zoom, speed, onover, links, titles, vertical, target, transparency, width, height, imageslink) VALUES ('1', 'wp-content/plugins/flash-image-carousel/images/', '1', '1', '1', '', '', '0', '_blank', '0', '100%', '250px', '0');";
	$wpdb->query($sql);
	}
	
if(isset($_POST['borrar'])) {
		$sql = "DELETE FROM $table_name WHERE id = ".$_POST['borrar'].";";
	$wpdb->query($sql);
	}
	if(isset($_POST['id'])){	
	if($_POST["vertical".$_POST['id']]=="") $_POST["vertical".$_POST['id']]=1;
	if($_POST["transparency".$_POST['id']]=="") $_POST["transparency".$_POST['id']]=1;
			$sql= "UPDATE $table_name SET `row` = '".$_POST["row".$_POST['id']]."', `folder` = '".$_POST["folder".$_POST['id']]."', `zoom` = '".$_POST["zoom".$_POST['id']]."', `speed` = '".$_POST["speed".$_POST['id']]."', `onover` = '".$_POST["onover".$_POST['id']]."', `links` = '".$_POST["links".$_POST['id']]."', `titles` = '".$_POST["titles".$_POST['id']]."', `target` = '".$_POST["target".$_POST['id']]."', `width` = '".$_POST["width".$_POST['id']]."', `height` = '".$_POST["height".$_POST['id']]."', `transparency` = '".$_POST["transparency".$_POST['id']]."', `vertical` = '".$_POST["vertical".$_POST['id']]."', `imageslink` = '".$_POST["imageslink".$_POST['id']]."' WHERE `id` =  ".$_POST["id"]." LIMIT 1";
			$wpdb->query($sql);
	}
	$myrows = $wpdb->get_results( "SELECT * FROM $table_name" );
$conta=0;

include('template/cabezera_panel.html');
while($conta<count($myrows)) {
	$id= $myrows[$conta]->id;
	$row= $myrows[$conta]->row;
	$folder = $myrows[$conta]->folder;
	$zoom = $myrows[$conta]->zoom;
	$speed = $myrows[$conta]->speed;
	$onover = $myrows[$conta]->onover;
	$vertical = $myrows[$conta]->vertical;
	$transparency = $myrows[$conta]->transparency;
	$target = $myrows[$conta]->target;
	$width = $myrows[$conta]->width;
	$height = $myrows[$conta]->height;
	$imageslink = $myrows[$conta]->imageslink;
	$links = $myrows[$conta]->links;
	$titles = $myrows[$conta]->titles;
	include('template/panel.html');			
	$conta++;
	}

}
function flash_image_carousel_add_menu(){	
	if (function_exists('add_options_page')) {
		//add_menu_page
		add_options_page('flash_image_carousel', 'Flash carousel', 8, basename(__FILE__), 'flash_image_carousel_panel');
	}
}
if (function_exists('add_action')) {
	add_action('admin_menu', 'flash_image_carousel_add_menu'); 
}
add_action('wp_head', 'flash_image_carousel_head');
add_filter('the_content', 'flash_image_carousel');
add_action('activate_flash_image_carousel/flash_image_carousel.php','flash_image_carousel_instala');
add_action('deactivate_flash_image_carousel/flash_image_carousel.php', 'flash_image_carousel_desinstala');
?>