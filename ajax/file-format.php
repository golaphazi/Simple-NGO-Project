<?php

  $getFolder  = isset($_GET['folder']) ? $_GET['folder']: '';
  $getFile  = isset($_GET['file']) ? $_GET['file']: '';
	if(strlen($getFolder) > 0 AND strlen($getFile) == ''){  
		$files = glob(''.$getFolder.'/*'); 
		foreach($files as $file){
			if(is_file($file))
			unlink($file); 
		}
	}
	if(strlen($getFile) > 0){
			$path = $_SERVER['DOCUMENT_ROOT'].''.$getFolder.'/'.$getFile.'';
			unlink($path);
			
	}

?>