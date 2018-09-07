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
    <title>Add Saving - <?= comapny_info('COMPANY_NAME');?></title>
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
	if(isset($_POST['add_saving'])){
		$Date 			 = isset($_POST['DATE']) ? $_POST['DATE'] : date("Y-m-d");
		$MEMBER_ID_MA	 = isset($_POST['MEMBER_ID_MA']) ? $_POST['MEMBER_ID_MA'] : '';
		$SHARE_ID	 	 = isset($_POST['SHARE_ID']) ? $_POST['SHARE_ID'] : '0';
		$AMOUNT_ID	 	 = isset($_POST['AMOUNT_ID']) ? $_POST['AMOUNT_ID'] : '0';
		$TOKEN_ID	 	 = isset($_POST['TOKEN_ID']) ? $_POST['TOKEN_ID'] : '';
		$DAY_ID	 		 = isset($_POST['DAY_ID']) ? $_POST['DAY_ID'] : '0';
		
		$rescive = ($SHARE_ID * 10) * $DAY_ID;
		$fineAmount = 0;
		if($DAY_ID > 7){
			$daye = $DAY_ID - 7;
			$fineAmount = $SHARE_ID * $daye;
		}
		
		if($MEMBER_ID_MA > 0){
			if(strlen($TOKEN_ID) > 0){
				if(strlen($SHARE_ID) > 0){
					$search = query("SELECT * FROM s_member_list WHERE MEMBER_ID_MA = '".$MEMBER_ID_MA."'");					
					if(num_row($search) == 1){
						$user_info = fetch($search);
						if($getEdit > 0){
							$update = query("UPDATE s_saving
													SET
														MEMBER_ID = '".$user_info['member_id']."',
														MEMBER_ID_MA = '".$MEMBER_ID_MA."',
														SHARE_ID = '".$SHARE_ID."',
														REC_AMOUNT = '".$rescive."',
														FINE_AMOUNT = '".$fineAmount."',
														TOKEN_ID = '".$TOKEN_ID."',
														DAY_ID = '".$DAY_ID."',
														DATE_SAVING = '".$Date."'
													
													WHERE
														SAVING_ID = '".$getEdit."'
							
												");
							if($update){
								$mass = 'Successfully Update Saving';
							}else{
								$mass = 'System Error';
							}
						}else{
							$insert = query("INSERT INTO
																s_saving
																(
																	MEMBER_ID,
																	MEMBER_ID_MA,
																	SHARE_ID,
																	REC_AMOUNT,
																	PAY_AMOUNT,
																	FINE_AMOUNT,
																	TOKEN_ID,
																	DAY_ID,
																	DATE_SAVING,
																	TYPE,
																	SAVING_STATUS
																)
																VALUES
																(
																	'".$user_info['member_id']."',
																	'".$MEMBER_ID_MA."',
																	'".$SHARE_ID."',
																	'".$rescive."',																	
																	'0',
																	'".$fineAmount."',
																	'".$TOKEN_ID."',
																	'".$DAY_ID."',
																	'".$Date."',
																	'Saving',
																	'Active'
																)
													");
							if($insert){
								$mass = 'Successfully Added Saving';
							}else{
								$mass = 'System Error';
							}
							
						}
					}else{
						$mass = 'Wrong Customer ID';
					}
				}else{
					$mass = 'Please Share ID';
				}
			}else{
				$mass = 'Please Enter Token';
			}
		}else{
			$mass = 'Please Member ID';
		}
	}
	
	$Date = date("Y-m-d");
	$MEMBER_ID_MA = '';
	$SHARE_ID = '';
	$REC_AMOUNT = '';
	$TOKEN_ID = '';
	$DAY_ID = '';
	$DATE_SAVING = '';
	$FINE_AMOUNT = '';
	
	$style = 'disabled="disabled"';
	if($getEdit > 0){
		$searchEdit = query("SELECT * FROM s_saving WHERE SAVING_ID = '".$getEdit."' AND TYPE = 'Saving'");
		if(num_row($searchEdit) > 0){	
			$edit = fetch($searchEdit);
			$MEMBER_ID_MA = $edit['MEMBER_ID_MA'];
			$SHARE_ID = $edit['SHARE_ID'];
			$REC_AMOUNT = $edit['REC_AMOUNT'];
			$TOKEN_ID = $edit['TOKEN_ID'];
			$DAY_ID = $edit['DAY_ID'];
			$Date = $edit['DATE_SAVING'];
			$FINE_AMOUNT = $edit['FINE_AMOUNT'];
			
		}
		$style = '';
	}
	?>
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12"  >
                    <h4 class="page-head-line" style="cursor:pointer;"><a href="add_saving.php">Add Saving</a> </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5" id="mamber1" style="">
                   <div class="panel panel-default">
                        <div class="panel-heading">
                           Saving Form
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
							<input type="text" class="form-control" id="MEMBER_ID_MA" name="MEMBER_ID_MA" onkeyup="removeChar(this);"  value="<?= $MEMBER_ID_MA;?>" onblur="check_customer(this.value)"/>
						</div>
						<div class="form-group has-success">
							<label class="control-label" for="success">Customer Name</label>
							<input type="text" class="form-control" id="MEMBER_NAME" name="MEMBER_NAME" readonly="readonly" value=""/>
						</div>
						
						<div class="form-group has-warning">
							<label class="control-label" for="warning">Number of Share ID</label>
							<input type="text" class="form-control" id="SHARE_ID" name="SHARE_ID" readonly="readonly" value="<?= $SHARE_ID;?>" />
						</div>
						<div class="form-group has-warning">
							<label class="control-label" for="warning">Amount</label>
							<input type="text" class="form-control" id="AMOUNT_ID" name="AMOUNT_ID" value="<?= $REC_AMOUNT;?>"  readonly="readonly" onkeyup="removeChar(this);" />
						</div>
						<div class="form-group has-warning">
							<label class="control-label" for="warning">Token ID</label>
							<input type="text" class="form-control" id="TOKEN_ID" name="TOKEN_ID" value="<?= $TOKEN_ID;?>" onkeyup="removeSpcial(this);" />
						</div>
						  <div class="form-group has-warning">
							<label class="control-label" for="warning">Number of Day</label> - Fine Amount: <span id="fine_view"><?= $FINE_AMOUNT;?></span>
							<input type="number" class="form-control" id="DAY_ID" name="DAY_ID" value="<?= $DAY_ID;?>" onkeyup="removeChar(this);" onblur="fine_amount(this.value)"/>
						</div>
						<button class="btn btn-default" name="add_saving" id="add_saving" type="submit" <?= $style;?>><i class=" fa fa-refresh "></i> Submit</button>
						
						</form>
                       </div>
                   </div>
                </div>
                <div class="col-md-7">
                   <div class="panel panel-default">
                        <div class="panel-heading"><div class="row">
						<form action="" method="post">
                           <div class="col-md-12"><strong> Saving List </strong></div>
							<div class="col-md-10">	<input type="text" class="form-control" id="warning" id="search" name="search"  value="" placeholder="Search ID"/></div>
						   <div class="col-md-2"><button class="btn btn-default" name="search_data" type="submit"><i class=" fa fa-search "></i></button></div>
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
							$searchG = query("SELECT * FROM s_saving WHERE MEMBER_ID_MA = '".$search."' AND SAVING_STATUS = 'Active' AND TYPE = 'Saving' ORDER BY SAVING_ID DESC LIMIT $get,30");
							$searchf = query("SELECT * FROM s_saving WHERE MEMBER_ID_MA = '".$search."' AND SAVING_STATUS = 'Active' AND TYPE = 'Saving'");
						}else{
							$searchG = query("SELECT * FROM s_saving WHERE SAVING_STATUS = 'Active' AND TYPE = 'Saving' ORDER BY SAVING_ID DESC LIMIT $get,30");
							$searchf = query("SELECT * FROM s_saving WHERE SAVING_STATUS = 'Active' AND TYPE = 'Saving'");
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
                                            <th>Amount</th>
                                            <th>Token</th>
                                            <th>Days</th>
                                            <th>Date</th>
                                            <th><center>Action</center></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sl = $get+1;
									$totalRec = 0;
									while($fetch = fetch($searchG)){?>
													<tr>
														<td><center><?= $sl;?></center></td>
														<td><?= $fetch['MEMBER_ID_MA'];?></td>
														<td><?= $fetch['SHARE_ID'];?></td>
														<td><?= number_format($fetch['REC_AMOUNT'], 2);?></td>
														<td><?= $fetch['TOKEN_ID'];?></td>
														<td><?= $fetch['DAY_ID'];?></td>
														<td><?= date("d M y", strtotime($fetch['DATE_SAVING']));?></td>
														<td>
														<a class="btn btn-primary" href="add_saving.php?edit=<?= $fetch['SAVING_ID'];?>"><i class="fa fa-edit "></i></a>
														</td>
														
													</tr>
									<?php 
									$totalRec = $totalRec + $fetch['REC_AMOUNT'];
									$sl++;
									}?> 
									<tr>
										<td colspan="3" align="right" ><b>Total:</b> </td>
										<td><b><?= number_format($totalRec, 2);?></b></td>
										<td colspan="4"></td>
                                    </tr>
                                    <tr>
										<td colspan="10"><?= paginator('30',$rowTotal1,'show','add_saving.php');?></td>
                                    </tr>
									</tbody>
									
                                </table>
                            </div>
                        </div>
					   <?php
					   
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
