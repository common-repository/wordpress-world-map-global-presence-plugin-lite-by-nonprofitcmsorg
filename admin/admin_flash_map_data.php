<? ob_start();
session_start();
//require_once("../class/DB_class1.php");

include_once('../../../../wp-config.php');
include_once('../../../../wp-includes/wp-db.php');

global $wpdb;

//$qry_category=mysql_query("select * from list_category order by id ASC");

$table_Cat = $wpdb->prefix.'list_category';

$table_Loc = $wpdb->prefix.'list_location';

$CategoryRows = $wpdb->get_results("SELECT * FROM $table_Cat ORDER By id ASC",ARRAY_A);

$i=0;
$str_category = "";

if( $wpdb->num_rows >0)
{
	$k=0;
	//while($row = mysql_fetch_array($qry_category))
	foreach($CategoryRows as $row )
	{

		if($row['activity']!='')
		{
			$str_category .= "\n\t".'<category type="'.str_replace('\"',"&quot;",str_replace("\'","&apos;",$row['activity'])).'" markercolor="'.$row['markerColor'].'" id="'.$row['id'].'" categoryMap="'.$i.'">';
			
			//$qry_location = mysql_query("select * from list_location where category_id='".$row['id']."' order by id ASC");
			
			$LocationRows = $wpdb->get_results("SELECT * FROM $table_Loc where category_id='".$row['id']."' order by id ASC",ARRAY_A);
			
			
			$j=0;
			if($wpdb->num_rows > 0)
			{
				//while($rowLocation = mysql_fetch_array($qry_location))
				foreach($LocationRows as $rowLocation)
				{
				
					$str_category .= "\n\t\t".'<location x="'.$rowLocation['x'].'" y="'.$rowLocation['y'].'" country="'.$rowLocation['country'].'" details="'.str_replace('\"',"&quot;",str_replace("\'","&apos;",$rowLocation['details'])).'" title="'.str_replace('\"',"&quot;",str_replace("\'","&apos;",$rowLocation['title'])).'" url="'.(($rowLocation['url']!='')?$rowLocation['url']:"#").'" continent="'.$rowLocation['continent'].'" id="'.$rowLocation['id'].'" locationMap="'.$j.'">';
					$str_category .= '</location>';
					$j++;
					$k++;
				}
			}
			$str_category .= "\n\t".'</category>';
			$i++;
		}	
	}
}


$str_category .= "\n"."</locations>";
$str_category ='<locations total_point="'.$k.'">'.$str_category;

/* Generate XML for General User */

$xmlFile = "../xml/mapdata.xml";
$fileHandle = fopen($xmlFile,'w');

fwrite($fileHandle, "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n".$str_category);
fclose($fileHandle);

/* Generate XML for Admin User */

$xmlFileForAdmin = "xml/mapdata.xml";
$fileHandle = fopen($xmlFileForAdmin,'w');

fwrite($fileHandle, "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n".$str_category);
fclose($fileHandle);

/* END */



//header('Content-type: text/xml');
//echo $str_category;
?>