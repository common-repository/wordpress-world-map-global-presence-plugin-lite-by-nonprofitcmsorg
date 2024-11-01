<?php 
#     /* 
#     Plugin Name: World Map Global Presence Map by NonprofitCMS.org (LITE)
#     Plugin URI: http://www.nonprofitcms.org/2010/12/wordpress-map-plugin/
#     Description: World Map / Global Presense Map for WordPress.  LITE edition limited to placing 5 points
#     Author: NonprofitCMS.org
#     Version: 1.0 
#     Author URI: http://www.nonprofitcms.org
#     */  


$flashmap_version = "1.0";

if( !class_exists('FlashMap') )
{
	class FlashMap{
	
		function FlashMap() { //constructor
		
			//ACTIONS
				//Add Menu in Left Side bar
				add_action( 'admin_menu', array($this, 'flash_menu') );
				
			//SHORTCODES
				#Add Form Shortcode
				
				add_shortcode('wp-worldmap', array($this, 'FlashMapPage') );
				
			//INSTALL TABLE
				#Runs the database installation for the wp_donations table
				register_activation_hook( __FILE__, array($this, 'FlashMapInstall') );

		}
		
		function flash_menu() {

			global $objMap;
		
			add_menu_page('Flash Map Page Title', 'World Map', 'manage_options', 'FlashMap', array($objMap, 'ShowFlashMap'), 'div' );
			
			//add_submenu_page( 'FlashMap', 'World Map', 'World Map', 'manage_options', 'flashmap', array($objMap, 'ShowFlashMap'));
		
		}



// ShowFlashMap Function start


function ShowFlashMap()
{
		
		    if (!current_user_can('manage_options'))  {
			   wp_die( __('You do not have sufficient permissions to access this page.') );
		    }

			
			global $wpdb;
			
			
			?>
<div class="wrap">
           	<h2><?php _e('World Map');?></h2>

<center>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="900" height="580" id="admin-flash-map" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="<?php echo get_bloginfo('wpurl') ?>/wp-content/plugins/npcms_worldmap/admin/admin-flash-map.swf?xmlpath=<?php echo get_bloginfo('wpurl') ?>/wp-content/plugins/npcms_worldmap/admin/xml/mapdata.xml&category_path=<?php echo get_bloginfo('wpurl') ?>/wp-content/plugins/npcms_worldmap/admin/categories.php&location_path=<?php echo get_bloginfo('wpurl') ?>/wp-content/plugins/npcms_worldmap/admin/locations.php&verify_code=<?php echo get_option( 'MapSecurityCode' ); ?>" /><param name="menu" value="false" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="<?php echo get_bloginfo('wpurl') ?>/wp-content/plugins/npcms_worldmap/admin/admin-flash-map.swf?xmlpath=<?php echo get_bloginfo('wpurl') ?>/wp-content/plugins/npcms_worldmap/admin/xml/mapdata.xml&category_path=<?php echo get_bloginfo('wpurl') ?>/wp-content/plugins/npcms_worldmap/admin/categories.php&location_path=<?php echo get_bloginfo('wpurl') ?>/wp-content/plugins/npcms_worldmap/admin/locations.php&verify_code=<?php echo get_option( 'MapSecurityCode' ); ?>" menu="false" quality="high" bgcolor="#ffffff" width="900" height="580" name="admin-flash-map" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</center>

<div class="clear"></div>


              
            </div>
            
            <?php

} // end of ShowFlashMap Function




// Show World Map In front Area

		function FlashMapPage( $arr )
		{

			//print_r( $arr );
 
			if( count($arr) < 2  )
			{
				echo "Please Enter Complete Argument";
				die();
			}
			
$str = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="'.$arr[0].'" height="'.$arr[1].'" id="flash-map" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="'.get_bloginfo('wpurl').'/wp-content/plugins/npcms_worldmap/flash-map.swf?xmlpath='.get_bloginfo('wpurl').'/wp-content/plugins/npcms_worldmap/xml/mapdata.xml" /><param name="menu" value="false" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="'.get_bloginfo('wpurl').'/wp-content/plugins/npcms_worldmap/flash-map.swf?xmlpath='.get_bloginfo('wpurl').'/wp-content/plugins/npcms_worldmap/xml/mapdata.xml" menu="false" quality="high" bgcolor="#ffffff" width="'.$arr[0].'" height="'.$arr[1].'" name="flash-map" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
<!-- The original map image of the world map is licensed Creative Commons Attribution-Share Alike 3.0 Unported.  The map file and credits can be seen further at http://en.wikipedia.org/wiki/File:World_map_-_low_resolution.svg.  The WordPress World Map is commercially licensed software.</div> -->';

return $str;

		}


		
		
	// Install Plugin

	function FlashMapInstall()
	{

		global $wpdb, $dplus_db_version;
		
		// Create Location Table
		
		$table_name = $wpdb->prefix . "list_location";
		
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$sql = "CREATE TABLE $table_name  (
					  id bigint(10) NOT NULL AUTO_INCREMENT,
					  category_id bigint(10) DEFAULT NULL,
					  x varchar(50) DEFAULT NULL,
					  y varchar(50) DEFAULT NULL,
					  country varchar(250) DEFAULT NULL,
					  details varchar(250) DEFAULT NULL,
					  title text,
					  url text,
					  continent varchar(250) DEFAULT NULL,
					  PRIMARY KEY (id)
				);";
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			
			}
			
		// Create Category Table
					
		$table_name = $wpdb->prefix . "list_category";
		
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$sql = "CREATE TABLE $table_name  (
					  id int(20) NOT NULL AUTO_INCREMENT,
					  activity varchar(250) DEFAULT NULL,
					  markerColor varchar(250) DEFAULT NULL,
					  PRIMARY KEY (id)
				);";
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
			add_option("flashmap_version", $flashmap_version);
			
			add_option("MapSecurityCode", rand(1, 1000000));			
			
	}

	}//END Of FlashMap Class
} //End of Class Check If

if( class_exists('FlashMap') )
	$objMap = new FlashMap();

function ShowFlashMap( $arr ){
	global $objMap;
	echo $objMap->FlashMapPage( $arr );
}

?>