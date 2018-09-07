<?php
session_start();
require_once("db_connect.php");
	
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <title>Add Member - <?= comapny_info('COMPANY_NAME');?></title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/pagination.css" rel="stylesheet" />
    <script src="js/jquery.js"></script>
   <!-- BOOTSTRAP SCRIPTS  -->
    <script src="js/bootstrap.js"></script>
    <script src="js/update.js"></script>
    <script src="js/operation.js"></script>
</head>
	
	<link rel="stylesheet" href="css/calender.css">
	<script src="js/calender.js"></script>
	<script>
		  $(document).ready(function() {
		   $("#Date").datepicker({ dateFormat: "yy-mm-dd",
			beforeShow: function(input, inst) {
			 if ($("#dateplanedcheck").is(':checked')) {
			  $(".ui-datepicker-calendar").css("display", "none");
			}}
		   });
		  });
		</script>
<body>
   <!-- LOGO HEADER END-->
   
    <!-- MENU SECTION END-->
    <?php
	$userIDLoogin = isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
	$typeLogin 	= isset($_SESSION['USER_TYPE']) ? $_SESSION['USER_TYPE'] : '';
	if($userIDLoogin > 0 AND strlen($typeLogin) > 0){
	?>
	<?php include("include/manu.php");?>
	
	<?php
	$mass = '';
	$getEdit = isset($_GET['edit']) ? $_GET['edit'] : '0';
	if(isset($_POST['add_member'])){
		$Date = isset($_POST['DATE']) ? $_POST['DATE'] : date("Y-m-d");
		$MEMBER_ID_MA = isset($_POST['MEMBER_ID_MA']) ? $_POST['MEMBER_ID_MA'] : '';
		$MEMBER_NAME = isset($_POST['MEMBER_NAME']) ? $_POST['MEMBER_NAME'] : '';
		$FATHER_NAME = isset($_POST['FATHER_NAME']) ? $_POST['FATHER_NAME'] : '';
		$MOTHER_NAME = isset($_POST['MOTHER_NAME']) ? $_POST['MOTHER_NAME'] : '';
		$PRE_ADDRESS = isset($_POST['PRE_ADDRESS']) ? $_POST['PRE_ADDRESS'] : '';
		$MOBILE_NUM  = isset($_POST['MOBILE_NUM']) ? $_POST['MOBILE_NUM'] : '';
		$SHARE_ID	 = isset($_POST['SHARE_ID']) ? $_POST['SHARE_ID'] : '';
		
		if($MEMBER_ID_MA > 0){
			if(strlen($MEMBER_NAME) > 0){
				if($SHARE_ID > 0){
					if($getEdit > 0){
						$search = query("SELECT * FROM s_member_list WHERE MEMBER_ID_MA = '".$MEMBER_ID_MA."' AND member_id != '".$getEdit."'");
					}else{
						$search = query("SELECT * FROM s_member_list WHERE MEMBER_ID_MA = '".$MEMBER_ID_MA."'");					
					}
					if(num_row($search) == 0){
						if($getEdit > 0){
							$update = query("UPDATE s_member_list
													SET
														MEMBER_ID_MA = '".$MEMBER_ID_MA."',
														MEMBER_NAME = '".$MEMBER_NAME."',
														FATHER_NAME = '".$FATHER_NAME."',
														MOTHER_NAME = '".$MOTHER_NAME."',
														PRE_ADDRESS = '".$PRE_ADDRESS."',
														MOBILE_NUM = '".$MOBILE_NUM."',
														SHARE_ID = '".$SHARE_ID."',
														DATE = '".$Date."'
													
													WHERE
														member_id = '".$getEdit."'
							
												");
							if($update){
								$mass = 'Successfully Update Customer Info';
							}else{
								$mass = 'System Error';
							}
						}else{
							$insert = query("INSERT INTO
																s_member_list
																(
																	MEMBER_ID_MA,
																	MEMBER_NAME,
																	FATHER_NAME,
																	MOTHER_NAME,
																	PRE_ADDRESS,
																	MOBILE_NUM,
																	SHARE_ID,
																	DATE,
																	STATUS
																)
																VALUES
																(
																	'".$MEMBER_ID_MA."',
																	'".$MEMBER_NAME."',
																	'".$FATHER_NAME."',
																	'".$MOTHER_NAME."',
																	'".$PRE_ADDRESS."',
																	'".$MOBILE_NUM."',
																	'".$SHARE_ID."',
																	'".$Date."',
																	'Active'
																)
													");
							if($insert){
								$mass = 'Successfully Added Customer Info';
							}else{
								$mass = 'System Error';
							}
							
						}
					}else{
						$mass = 'Sorry Already Added Customer ID';
					}
				}else{
					$mass = 'Please Share ID';
				}
			}else{
				$mass = 'Please Member Name';
			}
		}else{
			$mass = 'Please Member ID';
		}
	}
	
	$Date = date("Y-m-d");
	$MEMBER_ID_MA = '';
	$MEMBER_NAME = '';
	$FATHER_NAME = '';
	$MOTHER_NAME = '';
	$PRE_ADDRESS = '';
	$MOBILE_NUM  = '';
	$SHARE_ID	 = '';
	$style = 'display:block;';
	if($getEdit > 0){
		$searchEdit = query("SELECT * FROM s_member_list WHERE member_id = '".$getEdit."'");
		if(num_row($searchEdit) > 0){	
			$edit = fetch($searchEdit);
			$Date = $edit['DATE'];
			$MEMBER_ID_MA = $edit['MEMBER_ID_MA'];
			$MEMBER_NAME = $edit['MEMBER_NAME'];
			$FATHER_NAME = $edit['FATHER_NAME'];
			$MOTHER_NAME = $edit['MOTHER_NAME'];
			$PRE_ADDRESS = $edit['PRE_ADDRESS'];
			$MOBILE_NUM  = $edit['MOBILE_NUM'];
			$SHARE_ID	 = $edit['SHARE_ID'];
		}
		$style = 'display:block;';
	}
	?>
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12" onclick="hide(1)" >
                    <h4 class="page-head-line" style="cursor:pointer;">Add Member </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4" id="mamber1" style="<?= $style;?>">
                   <div class="panel panel-default">
                        <div class="panel-heading">
                           BASIC FORM ELEMENTS
                        </div>
						<div class="form-group has-success" style="margin-left:13px;">
							<label class="control-label" for="success" style="color:red;"><?= $mass;?></label>
						</div>
						
                        <div class="panel-body">
                       <form action="" method="POST">
					   <fieldset class="date">
						  <label class="control-label" for="success">Start Date</label>
							<input type="text" class="form-control" id="Date" name="DATE" value="<?= $Date;?>"/>
						</fieldset>
						<div class="form-group has-success">
							<label class="control-label" for="success">Customer ID</label>
							<input type="text" class="form-control" id="MEMBER_ID_MA" onkeyup="removeChar(this);"  name="MEMBER_ID_MA" value="<?= $MEMBER_ID_MA;?>" />
						</div>
						<div class="form-group has-success">
							<label class="control-label" for="success">Customer Name</label>
							<input type="text" class="form-control" id="MEMBER_NAME" name="MEMBER_NAME" value="<?= $MEMBER_NAME;?>"/>
						</div>
						<div class="form-group has-warning">
							<label class="control-label" for="warning">Father / Husband's Name</label>
							<input type="text" class="form-control" id="FATHER_NAME" name="FATHER_NAME" value="<?= $FATHER_NAME;?>"/>
						</div>
						<div class="form-group has-error">
							<label class="control-label" for="error">Mother's Name</label>
							<input type="text" class="form-control" id="MOTHER_NAME" name="MOTHER_NAME" value="<?= $MOTHER_NAME;?>"/>
						</div>
						<hr />
						   <textarea class="form-control" rows="3" placeholder="Present Address" id="PRE_ADDRESS" name="PRE_ADDRESS"> <?= $PRE_ADDRESS;?></textarea>
						
						
						<div class="form-group has-success">
							<label class="control-label" for="success">Mobile Number</label>
							<input type="text" class="form-control" id="success" id="MOBILE_NUM" onkeyup="removeChar(this);"  name="MOBILE_NUM"  value="<?= $MOBILE_NUM;?>"/>
						</div>
						<div class="form-group has-warning">
							<label class="control-label" for="warning">Number of Share ID</label>
							<input type="text" class="form-control" id="warning" id="SHARE_ID" onkeyup="removeChar(this);"  name="SHARE_ID"  value="<?= $SHARE_ID;?>"/>
						</div>
						
						  
						<button class="btn btn-default" name="add_member" type="submit"><i class=" fa fa-refresh "></i> Submit</button>
						
						</form>
                       </div>
                   </div>
                </div>
                <div class="col-md-8">
                   <div class="panel panel-default">
                        <div class="panel-heading"><div class="row">
						<form action="" method="post">
                           <div class="col-md-12"><strong> Member List </strong></div>
							<div class="col-md-10">	<input type="text" class="form-control" id="warning" id="search" name="search"  value="" placeholder="Search ID"/></div>
						   <div class="col-md-2"><button class="btn btn-default" name="search_data" type="submit"><i class=" fa fa-search "></i> Search</button></div>
                        </form>
						</div>
                        </div>
						<div class="row">
                        <?php
						$get = isset($_GET['show']) ? $_GET['show'] : '0';
						$search = '';
						if(isset($_POST['search_data'])){
							$search = isset($_POST['search']) ? $_POST['search'] : '';
						}
						
						if(strlen($search) > 0){
							$searchG = query("SELECT * FROM s_member_list WHERE MEMBER_ID_MA = '".$search."' AND STATUS = 'Active' ORDER BY member_id DESC LIMIT $get,40");
							$searchf = query("SELECT * FROM s_member_list WHERE MEMBER_ID_MA = '".$search."' AND STATUS = 'Active'");
						}else{
							$searchG = query("SELECT * FROM s_member_list WHERE STATUS = 'Active' ORDER BY member_id DESC LIMIT $get,40");
							$searchf = query("SELECT * FROM s_member_list WHERE STATUS = 'Active'");
						}
						
						$rowTotal1 = num_row($searchf);
						$rowTotal = num_row($searchG);
						if($rowTotal > 0){							
						?>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#SL</th>
                                            <th>Member ID</th>
											<th>Share ID</th>
                                            <th>Member Name</th>
                                            <th>Father Name</th>
                                            <th>Mother Name</th>
                                            <th>Address</th>
                                            <th>Mobile No</th>
                                            <th>Date</th>
                                            <th><center>Action</center></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sl = $get+1;
									while($fetch = fetch($searchG)){?>
													<tr>
														<td><center><?= $sl;?></center></td>
														<td><?= $fetch['MEMBER_ID_MA'];?></td>
														<td><?= $fetch['SHARE_ID'];?></td>
														<td><?= $fetch['MEMBER_NAME'];?></td>
														<td><?= $fetch['FATHER_NAME'];?></td>
														<td><?= $fetch['MOTHER_NAME'];?></td>
														<td><?= $fetch['PRE_ADDRESS'];?></td>
														<td><?= $fetch['MOBILE_NUM'];?></td>
														<td><?= date("d M y", strtotime($fetch['DATE']));?></td>
														<td>
														<a class="btn btn-primary" href="add_member.php?edit=<?= $fetch['member_id'];?>"><i class="fa fa-edit "></i></a>
														</td>
														
													</tr>
									<?php 
									$sl++;
									}?>               
                                    <tr>
										<td colspan="10"><?= paginator('40',$rowTotal1,'show','add_member.php');?></td>
                                    </tr>
									</tbody>
									
                                </table>
                            </div>
                        </div>
					   <?php
					   
					   }else{
							echo '<div class="col-md-12" style="margin-left:10px;">Not Found Customer</div>';
					   }
					   ?>
                    </div>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>
	 <?php include("include/footer.php");?>
	<?php
	}else{
		pageRedirect('index.php');
	}
	?>
    <!-- CONTENT-WRAPPER SECTION END-->
    
    
</body>
</html>
