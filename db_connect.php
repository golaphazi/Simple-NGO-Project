<?php 
include("function.php");

define("DB_SERVER","localhost");
define("DB_USER","root");
define("DB_PASSWORD","");
define("DB_NAME","ngo_db");

function Database(){
	
	$conncetion = @mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
	if(!$conncetion){
		die("Could Not Found".mysqli_connect_error());
	}
	//$bd_select = mysql_select_db(DB_NAME,$conncetion);
	/*
		if(!$bd_select){
			die("Database Could Not Found".mysql_error());
		}		
	*/
	return $conncetion;
}



function query($query){
	$con = Database();
	if(strlen($query) > 0){
		$search = mysqli_query($con, $query);
		return $search;
	}
}

function fetch($queryData){
	return mysqli_fetch_array($queryData);
}

function num_row($queryData){
	return mysqli_num_rows($queryData);
}

function comapny_info($data = '*'){
	$comap = query("SELECT $data FROM company WHERE COMPANY_ID = '1' AND COMPANY_STATUS = 'Active' ");
	$rowCount = num_row($comap);
	$result = fetch($comap);
	if($rowCount > 0){
		if(strlen($data) > 1){
			return $result[$data];
		}else{
			return $result;
		}
		
	}
}

?>