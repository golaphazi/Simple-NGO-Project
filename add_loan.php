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
    <title>Add Loan - <?= comapny_info('COMPANY_NAME');?></title>
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
		$AMOUNT_ID	 	 = isset($_POST['AMOUNT_ID_LOAN']) ? $_POST['AMOUNT_ID_LOAN'] : '0';
		$METHOD_ID	 	 = isset($_POST['METHOD_ID']) ? $_POST['METHOD_ID'] : '';
		$TRANSACTION_ID	 = isset($_POST['TRANSACTION_ID']) ? $_POST['TRANSACTION_ID'] : '0';
		
		if($MEMBER_ID_MA > 0){
			if(strlen($AMOUNT_ID) > 0){
				$search = query("SELECT * FROM s_member_list WHERE MEMBER_ID_MA = '".$MEMBER_ID_MA."'");					
				if(num_row($search) == 1){
					$user_info = fetch($search);
					if($getEdit > 0){
						$update = query("UPDATE s_loan
												SET
													MEMBER_ID = '".$user_info['member_id']."',
													MEMBER_ID_MA = '".$MEMBER_ID_MA."',
													PAY_AMOUNT = '".$AMOUNT_ID."',
													PAYMENT_METHOD = '".$METHOD_ID."',
													PAYMENT_ID = '".$TRANSACTION_ID."',
													DATE_TIME = '".$Date."'
													
												WHERE
													LOAN_ID = '".$getEdit."'
						
											");
						if($update){
							$mass = 'Successfully Update Loan';
						}else{
							$mass = 'System Error';
						}
					}else{
						$insert = query("INSERT INTO
													s_loan
													(
														MEMBER_ID,
														MEMBER_ID_MA,
														PAY_AMOUNT,
														PAYMENT_METHOD,
														PAYMENT_ID,
														DATE_TIME,
														LOAN_STATUS
														
													)
													VALUES
													(
														'".$user_info['member_id']."',
														'".$MEMBER_ID_MA."',
														'".$AMOUNT_ID."',
														'".$METHOD_ID."',
														'".$TRANSACTION_ID."',
														'".$Date."',
														'Active'
														
													)
												");
						if($insert){
							$mass = 'Successfully Added Loan';
						}else{
							$mass = 'System Error';
						}
						
					}
				}else{
					$mass = 'Wrong Customer ID';
				}
				
			}else{
				$mass = 'Please Enter Amount';
			}
		}else{
			$mass = 'Please Member ID';
		}
	}
	
	$Date = date("Y-m-d");
	$MEMBER_ID_MA = '';
	$PAY_AMOUNT = '';
	$PAYMENT_METHOD = '';
	$PAYMENT_ID = '';
	$DAY_ID = '';
	$DATE_SAVING = '';
	$FINE_AMOUNT = '';
	
	$style = 'disabled="disabled"';
	if($getEdit > 0){
		$searchEdit = query("SELECT * FROM s_loan WHERE LOAN_ID = '".$getEdit."'");
		if(num_row($searchEdit) > 0){	
			$edit = fetch($searchEdit);
			$MEMBER_ID_MA = $edit['MEMBER_ID_MA'];
			$PAY_AMOUNT = $edit['PAY_AMOUNT'];
			$PAYMENT_METHOD = $edit['PAYMENT_METHOD'];
			$PAYMENT_ID = $edit['PAYMENT_ID'];
			$Date = $edit['DATE_TIME'];
			
		}
		$style = '';
	}
	?>
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12"  >
                    <h4 class="page-head-line" style="cursor:pointer;"><a href="add_loan.php">Add Loan</a> </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5" id="mamber1" style="">
                   <div class="panel panel-default">
                        <div class="panel-heading">
                           Loan Form
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
							<label class="control-label" for="warning">Amount</label>
							<input type="text" class="form-control" id="AMOUNT_ID_LOAN" name="AMOUNT_ID_LOAN" value="<?= $PAY_AMOUNT;?>" onkeyup="removeChar(this);" />
						</div>
						<div class="form-group has-warning">
							<label class="control-label" for="warning">Paymet Method</label>
							<input type="text" class="form-control" id="METHOD_ID" name="METHOD_ID" value="<?= $PAYMENT_METHOD;?>" list="methood"/>
							<datalist id="methood">
								<select>
									<option value="Bank">Bank</option>
									<option value="Bkash">Bkash</option>
									<option value="DBBL">DBBL</option>
									<option value="Mobicash">Mobicash</option>
								</select>
							</datalist>
						</div>
						<div class="form-group has-warning">
							<label class="control-label" for="warning">Transaction Id</label>
							<input type="text" class="form-control" id="TRANSACTION_ID" name="TRANSACTION_ID" value="<?= $PAYMENT_ID;?>" onkeyup="removeSpcial(this);" />
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
                           <div class="col-md-12"><strong> Loan List </strong></div>
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
							$searchG = query("SELECT * FROM s_loan WHERE MEMBER_ID_MA = '".$search."' AND LOAN_STATUS = 'Active' ORDER BY LOAN_ID DESC LIMIT $get,30");
							$searchf = query("SELECT * FROM s_loan WHERE MEMBER_ID_MA = '".$search."' AND LOAN_STATUS = 'Active'");
						}else{
							$searchG = query("SELECT * FROM s_loan WHERE LOAN_STATUS = 'Active' ORDER BY LOAN_ID DESC LIMIT $get,30");
							$searchf = query("SELECT * FROM s_loan WHERE LOAN_STATUS = 'Active'");
						}
						$rowTotal = num_row($searchG);
						$rowTotal1 = num_row($searchf);
						if($rowTotal > 0){	
						
						
						?>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th valign="middle">#SL</th>
                                            <th valign="middle">Member ID</th>
                                            <th valign="middle">Loan ID</th>
											<th valign="middle">Amount</th>
											<th valign="middle">Rec Amount</th>
                                            <th valign="middle"> Method</th>
                                            <th valign="middle">Transation</th>
                                            <th valign="middle">Date</th>
                                            <th valign="middle"><center>Action</center></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sl = $get+1;
									$totalRec =0;
									$totalRec1 =0;
									while($fetch = fetch($searchG)){
										$sum_rec = fetch(query("SELECT SUM(PAY_AMOUNT) AS toal FROM s_saving WHERE MEMBER_ID_MA = '".$fetch['MEMBER_ID_MA']."' AND SHARE_ID = '".$fetch['LOAN_ID']."' AND SAVING_STATUS = 'Active' AND TYPE = 'Loan'"));
			
										?>
													<tr>
														<td align="middle"><center><?= $sl;?></center></td>
														<td align="middle"> <?= $fetch['MEMBER_ID_MA'];?></td>
														<td align="middle"><?= $fetch['LOAN_ID'];?></td>
														<td align="middle"><?= number_format($fetch['PAY_AMOUNT'], 2);?></td>
														<td align="middle"><?= number_format($sum_rec['toal'], 2);?></td>
														<td><?= $fetch['PAYMENT_METHOD'];?></td>
														<td><?= $fetch['PAYMENT_ID'];?></td>
														<td><?= date("d M y", strtotime($fetch['DATE_TIME']));?></td>
														<td>
														<a class="btn btn-primary" href="add_loan.php?edit=<?= $fetch['LOAN_ID'];?>"><i class="fa fa-edit "></i></a>
														</td>
														
													</tr>
									<?php
									$totalRec = $totalRec + $fetch['PAY_AMOUNT'];
									$totalRec1 = $totalRec1 + $sum_rec['toal'];
									$sl++;
									}?>
									<tr>
										<td colspan="3" align="right" ><b>Total:</b> </td>
										<td><b><?= number_format($totalRec, 2);?></b></td>
										<td><b><?= number_format($totalRec1, 2);?></b></td>
										<td colspan="4"></td>
                                    </tr>
                                    <tr>
										<td colspan="10"><?= paginator('30',$rowTotal1,'show','add_loan.php');?></td>
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
