<?php
//database configuration
$config['mysql_host'] = "localhost";
$config['mysql_user'] = "root";
$config['mysql_pass'] = "";
$config['db_name']    = "fruit_store";
$config['table_name'] = "fruit";
 
//connect to host
//$con = mysql_connect($config['mysql_host'],$config['mysql_user'],$config['mysql_pass']);
$con = mysql_connect($config['mysql_host'],$config['mysql_user'],$config['mysql_pass']) or die("Connection Problem" . mysql_errno($con));
//select database
/*if ($con->connect_error) {
    die("Connection failed". $con->connect_error);
} 
echo "Connected successfully";*/
@mysql_select_db($config['db_name']) or die( "Unable to select database");


//@mysql_select_db($con, 'db_name') or die("SQL Problem" . mysql_error($con));


$xml          = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
$root_element = $config['table_name']."s"; //fruits
$xml         .= "<$root_element>";
//select all items in table
$sql = "SELECT * FROM ".$config['table_name'];
 
$result = mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
 
if(mysql_num_rows($result)>0)
{
   while($result_array = mysql_fetch_assoc($result))
   {
      $xml .= "<".$config['table_name'].">";
 
      //loop through each key,value pair in row
      foreach($result_array as $key => $value)
      {
         //$key holds the table column name
         $xml .= "<$key>";
 
         //embed the SQL data in a CDATA element to avoid XML entity issues
         $xml .= "<![CDATA[$value]]>";
 
         //and close the element
         $xml .= "</$key>";
      }
 
      $xml.="</".$config['table_name'].">";
   }
}
//close the root element
$xml .= "</$root_element>";
 
//send the xml header to the browser
header ("Content-Type:text/xml");
 
//output the XML data
echo $xml;
?>