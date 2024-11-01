<?php 

global $wpdb;

$table_name = $wpdb->prefix . "list_location";

if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) :
	$sql = "DROP TABLE $table_name";
	$wpdb->query($sql);
endif;		  

$table_name = $wpdb->prefix . "list_category";

if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) :
	$sql = "DROP TABLE $table_name";
	$wpdb->query($sql);
endif;		

delete_option('flashmap_version');
delete_option('MapSecurityCode');
?>