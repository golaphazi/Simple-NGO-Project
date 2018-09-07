<?php
session_start();
require_once("../db_connect.php");
$data = $_REQUEST['data'];
$search = query("SELECT * FROM s_member_list WHERE MEMBER_ID_MA = '".$data."'");
if(num_row($search) == 1){
$res = fetch($search);
$name = $res['MEMBER_NAME'];
$share = $res['SHARE_ID'];
	$result = $share.'__'.$name;
}else{
	$result = 0;
}
echo $result;
?>