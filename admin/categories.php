<? 
define("TOTAL_ACTIVITY",12);

include_once('../../../../wp-config.php');
include_once('../../../../wp-includes/wp-db.php');


global $wpdb;

$table_Cat = $wpdb->prefix.'list_category';

$table_Loc = $wpdb->prefix.'list_location';

$action = $_REQUEST['action'];

switch ($action)
{
	case 'manage':
	
		$rows=$wpdb->get_results("SELECT * FROM $table_Cat",ARRAY_A);

		$i=0;
		$str_category = "success=true&";
		if( $wpdb->num_rows >0 )
		{

			foreach($rows as $row)
			{
				$i++;
				$str_category .= "categoryId".$i."=".$row['id']."&";
				$str_category .= "category".$i."=".$row['activity']."&";
				$str_category .= "markerColor".$i."=".$row['markerColor']."&";
			}
		}
		echo $str_category;

		include("admin_flash_map_data.php");
	break;	
	case 'update':
	$MapCode=get_option( 'MapSecurityCode' );
	
	if( $_POST["verify_code"] == $MapCode ) {
		
		$rows=$wpdb->get_results("SELECT * FROM $table_Cat",ARRAY_A);
		
		if($wpdb->num_rows > 0)
		{
			for($i=1;$i<=TOTAL_ACTIVITY;$i++)
			{
				
				$data=array();
				
				$data["activity"]=$_POST['category'.$i];
				$data["markerColor"]=$_POST['markerColor'.$i];
				
				$sql_updateActivity = $wpdb->update( $table_Cat, $data , array( 'id' => $i ) );
				
				}	
		}
		else
		{
			for($i=1;$i<=TOTAL_ACTIVITY;$i++)
			{
				//$sql_updateActivity = mysql_query("INSERT INTO list_category set category='".$_POST['category'.$i]."',markerColor='".$_POST['markerColor'.$i]."'");

				$data=array();
				if($_POST['category'.$i] != "undefined" ) {
				
					$data["activity"]=$_POST['category'.$i];
					$data["markerColor"]=$_POST['markerColor'.$i];
				
				
					$sql_updateActivity = $wpdb->insert( $table_Cat, $data  );
				}
				
			}
		}	
		echo "success=true&";
		include("admin_flash_map_data.php");
	}
	
	break;	
	default:
			header("Location:admin-flash-map.htm");
			exit;
	break;	
}
?>