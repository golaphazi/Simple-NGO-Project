<?php
 function pageRedirect($pageRedirect='') {					
	echo '<script>window.location = "'.host().'/'.$pageRedirect.'";</script>';
}

function host(){	
	$app_url = (!empty($_SERVER['HTTPS'])? 'https' : 'http'). '://' . $_SERVER['HTTP_HOST'].'/ngo';
	return $app_url;
  }
  //echo host();
  
function paginator($perLimit='', $total='', $showName='show', $page='', $extra=''){
		$menu ='';
		if($perLimit > 0 AND $total > $perLimit){
			$average = ceil($total/$perLimit);
			$menu .='<span style="float:left;"><ul class="paginationUl">';
			
			if(strlen($extra) > 0){
				$extraUrl = '&'.$extra.'';
			}else{
				$extraUrl = '';
			}
			
			$display = isset($_GET[$showName]) ? $_GET[$showName] : '0';
			if($display >= $perLimit){
				$pre = $display - $perLimit;
				$menu .='<li><a href="'.host().'/'.$page.'?'.$showName.'='.$pre.''.$extraUrl.'"> &#8678; </a></li>';
			}	
			$nextData = '';
			for($i=1; $i <= $average; $i++){
				$data = $perLimit*$i;
				$class = 'DeActive';
				$data = $data - $perLimit;
				if($display == $data){
					$class = 'Active';
					$nextData = $data;
				}
				
				/**---start----**/
				$limit = 1;
				if($average > $limit){					
					$menu .='<li class="'.$class.'"><a href="'.host().'/'.$page.'?'.$showName.'='.$data.''.$extraUrl.'"> '.$i.' </a></li>';										
				}else{
					$menu .='<li class="'.$class.'"><a href="'.host().'/'.$page.'?'.$showName.'='.$data.''.$extraUrl.'"> '.$i.' </a></li>';
					
				}
			}
			//echo $nextData;exit();
			if($data > $nextData){
				$next = $nextData + $perLimit;
				$menu .='<li><a href="'.host().'/'.$page.'?'.$showName.'='.$next.''.$extraUrl.'"> &#8680; </a></li>';
			}
			$menu .='</ul></span><span style="float:right;font-size:12px;color:#222222;">Per page '.$perLimit.' rows - Total '.$total.' rows </span>';
		}else{$menu ='<span style="float:left;font-size:12px;color:#222222;">'.$total.' rows found</span>';
		}
	  return $menu;
	  }
?>