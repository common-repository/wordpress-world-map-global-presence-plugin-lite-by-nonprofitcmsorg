<? ob_start();
session_start();

include_once('../../../../wp-config.php');
include_once('../../../../wp-includes/wp-db.php');

global $wpdb;

$table_Cat = $wpdb->prefix.'list_category';

$table_Loc = $wpdb->prefix.'list_location';

$action = $_REQUEST['action'];
switch ($action)
{
	case 'add':
	
	$MapCode=get_option( 'MapSecurityCode' );
	
	if( $_POST["verify_code"] == $MapCode ) {
	
	
		$x=$_POST['x']; 
		$y=$_POST['y']; 
		$country=$_POST['country'];
		$details=$_POST['details'];
		$title=$_POST['title'];
		$url=$_POST['url'];
		$continent=$_POST['continent'];
		$category_id=$_POST['category_id'];
		
		$data=array();
		
		$data["category_id"]=$category_id;
		$data["x"]=$x;
		$data["y"]=$y;
		$data["country"]=$country;
		$data["details"]=$details;
		$data["title"]=$title;
		$data["url"]=$url;
		$data["continent"]=$continent;
				
		$qry_add_location = $wpdb->insert( $table_Loc, $data  );
		
		
		
		echo $str_category = "success=true&locationId=".$wpdb->insert_id;
		include("admin_flash_map_data.php");	
	}
		
	break;	
	case 'edit':
	
	$MapCode=get_option( 'MapSecurityCode' );
	
	if( $_POST["verify_code"] == $MapCode ) {
	
		$locationId = $_POST['locationId'];
		$x=$_POST['x']; 
		$y=$_POST['y']; 
		$country=$_POST['country'];
		$details=$_POST['details'];
		$title=$_POST['title'];
		$url=$_POST['url'];
		$continent=$_POST['continent'];
		$category_id=$_POST['category_id'];
		
		$data=array();
		
		$data["category_id"]=$category_id;
		$data["x"]=$x;
		$data["y"]=$y;
		$data["country"]=$country;
		$data["details"]=$details;
		$data["title"]=$title;
		$data["url"]=$url;
		$data["continent"]=$continent;		
		
		$qry_edit_location = $wpdb->update( $table_Loc, $data , array( 'id' => $locationId ) );
		
		
		echo $str_category = "success=true&locationId=".$locationId;
		include("admin_flash_map_data.php");
	}
	
	break;
	case 'delete':
	
	$MapCode=get_option( 'MapSecurityCode' );
	if( $_POST["verify_code"] == $MapCode ) {	
	
		$locationId = $_POST['locationId'];
		
		$del = "DELETE from $table_Loc where id='".$locationId ."' LIMIT 1";
			//echo $del; //exit;
			$wpdb->query($del);
		
		echo $str_category = "success=true&locationId=".$locationId;
		include("admin_flash_map_data.php");
	}
	
	break;	
	default:
			header("Location:admin-flash-map.htm");
			exit;
	break;	
}
?>