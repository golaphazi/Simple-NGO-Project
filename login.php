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
    <title>Welcome <?= comapny_info('COMPANY_NAME');?></title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="css/style.css" rel="stylesheet" />
    <script src="js/jquery.js"></script>
   <!-- BOOTSTRAP SCRIPTS  -->
    <script src="js/bootstrap.js"></script>
</head>
<body>
   <!-- LOGO HEADER END-->
   
    <!-- MENU SECTION END-->
    <?php
	$userIDLoogin = isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
	$typeLogin 	= isset($_SESSION['USER_TYPE']) ? $_SESSION['USER_TYPE'] : '';
	if($userIDLoogin > 0 AND strlen($typeLogin) > 0){
	
	?>
	<?php include("include/manu.php");?>
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Welcome <?= comapny_info('COMPANY_NAME');?></h4>

                </div>
				<div class="col-md-6">
                   <div class="panel panel-default">
                        <div class="panel-heading"><div class="row">
						<form action="" method="post">
                           <div class="col-md-12"><strong>Daily Report for Loan</strong></div>
						</form>
						</div>
                        </div>
						<div class="row">
                        <?php
						$get = isset($_GET['show']) ? $_GET['show'] : '0';
						$search1 = '';
						$Date = date("Y-m-d");
						if(isset($_POST['search_data'])){
							$search1 = isset($_POST['search']) ? $_POST['search'] : '';
						}
						$DateF = $Date;
						$DateE = $Date;
						if(strlen($search1) > 0){
							$searchG1 = query("SELECT * FROM s_loan WHERE MEMBER_ID_MA = '".$search1."' AND LOAN_STATUS = 'Active' AND( DATE_TIME BETWEEN '".$DateF."' AND '".$DateE."') ORDER BY LOAN_ID DESC");
						
						}else{
							$searchG1 = query("SELECT * FROM s_loan WHERE LOAN_STATUS = 'Active' AND( DATE_TIME BETWEEN '".$DateF."' AND '".$DateE."') ORDER BY LOAN_ID DESC");
						
						}
						$rowTotal1 = num_row($searchG1);
						if($rowTotal1 > 0){	
						
						
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
                                            <th valign="middle">Date</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sl = $get+1;
									$totalRec =0;
									$totalRec1 =0;
									while($fetch = fetch($searchG1)){
										$sum_rec = fetch(query("SELECT SUM(PAY_AMOUNT) AS toal FROM s_saving WHERE MEMBER_ID_MA = '".$fetch['MEMBER_ID_MA']."' AND SHARE_ID = '".$fetch['LOAN_ID']."' AND SAVING_STATUS = 'Active' AND TYPE = 'Loan'"));
			
										?>
													<tr>
														<td align="middle"><center><?= $sl;?></center></td>
														<td align="middle"> <?= $fetch['MEMBER_ID_MA'];?></td>
														<td align="middle"><?= $fetch['LOAN_ID'];?></td>
														<td align="middle"><?= number_format($fetch['PAY_AMOUNT'], 2);?></td>
														<td align="middle"><?= number_format($sum_rec['toal'], 2);?></td>
														<td><?= date("d M y", strtotime($fetch['DATE_TIME']));?></td>
														
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
				
				
				<div class="col-md-6">
                   <div class="panel panel-default">
                        <div class="panel-heading"><div class="row">
						<form action="" method="post">
                           <div class="col-md-12"><strong>Daily Report for Saving </strong></div>
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
							$searchG = query("SELECT * FROM s_saving WHERE MEMBER_ID_MA = '".$search."' AND SAVING_STATUS = 'Active' AND TYPE = 'Saving' AND( DATE_SAVING BETWEEN '".$DateF."' AND '".$DateE."') ORDER BY SAVING_ID DESC");
						
						}else{
							$searchG = query("SELECT * FROM s_saving WHERE SAVING_STATUS = 'Active' AND TYPE = 'Saving' AND( DATE_SAVING BETWEEN '".$DateF."' AND '".$DateE."') ORDER BY SAVING_ID DESC");
						
						}
						//$searchf = mysql_query("SELECT * FROM s_saving WHERE SAVING_STATUS = 'Active' AND TYPE = 'Saving'");
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
                                            
                                            <th>Date</th>
                                            
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
														<td><?= date("d M y", strtotime($fetch['DATE_SAVING']));?></td>
														
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
				
				 <div class="col-md-6">
                   <div class="panel panel-default">
                        <div class="panel-heading"><div class="row">
						<form action="" method="post">
                           <div class="col-md-12"><strong>Last Loan History </strong></div>
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
							$searchG = query("SELECT * FROM s_loan WHERE MEMBER_ID_MA = '".$search."' AND LOAN_STATUS = 'Active' ORDER BY LOAN_ID DESC LIMIT $get,20");
						
						}else{
							$searchG = query("SELECT * FROM s_loan WHERE LOAN_STATUS = 'Active' ORDER BY LOAN_ID DESC LIMIT $get,20");
						
						}
						$rowTotal = num_row($searchG);
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
                                            <th valign="middle">Date</th>
                                            
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
														<td><?= date("d M y", strtotime($fetch['DATE_TIME']));?></td>
														
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
				<div class="col-md-6">
                   <div class="panel panel-default">
                        <div class="panel-heading"><div class="row">
						<form action="" method="post">
                           <div class="col-md-12"><strong>Last Saving History </strong></div>
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
							$searchG = query("SELECT * FROM s_saving WHERE MEMBER_ID_MA = '".$search."' AND SAVING_STATUS = 'Active' AND TYPE = 'Saving' ORDER BY SAVING_ID DESC LIMIT $get,20");
						
						}else{
							$searchG = query("SELECT * FROM s_saving WHERE SAVING_STATUS = 'Active' AND TYPE = 'Saving' ORDER BY SAVING_ID DESC LIMIT $get,20");
						
						}
						//$searchf = mysql_query("SELECT * FROM s_saving WHERE SAVING_STATUS = 'Active' AND TYPE = 'Saving'");
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
                                            
                                            <th>Date</th>
                                            
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
														<td><?= date("d M y", strtotime($fetch['DATE_SAVING']));?></td>
														
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
