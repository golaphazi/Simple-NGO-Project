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
		   $("#Date, #Date1").datepicker({ dateFormat: "yy-mm-dd",
			beforeShow: function(input, inst) {
			 if ($("#dateplanedcheck").is(':checked')) {
			  $(".ui-datepicker-calendar").css("display", "none");
			}}
		   });
		  });
		</script>
		
		<script type="text/javascript">     
			function PrintDiv() {    
				  var divToPrint = document.getElementById('divToPrint');
				  var popupWin = window.open('', '_blank', 'width=auto,height=auto,');
				  popupWin.document.open();
				  popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="print/bootstrap.min.css"/><link rel="stylesheet" type="text/css" href="print/components.css"/><link rel="stylesheet" type="text/css" media="all" href="print/print.css"/></head><body onload="window.print();window.close();"><center>' + divToPrint.innerHTML + '<center></html>');
				  popupWin.document.close();
				}
		   
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
	$Date = date("Y-m-d");
	$DateF = isset($_POST['DATER']) ? $_POST['DATER'] : $Date;
	$DateE = isset($_POST['DATEE']) ? $_POST['DATEE'] : $Date;
	?>
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12"  >
                    <h4 class="page-head-line" style="cursor:pointer;"><a href="add_saving.php"> Saving History</a> </h4>
                </div>
            </div>
            <div class="row">
                
                <div class="col-md-12">
                   <div class="panel panel-default">
                        <div class="panel-heading"><div class="row">
						<form action="" method="post">
                           <div class="col-md-5">	
								<label class="control-label" for="success">Search ID</label>
								<input type="text" class="form-control" id="warning" id="search" name="search"  value="" placeholder="Search ID"/></div>
							<div class="col-md-3">	
								<label class="control-label" for="success">Start Date</label>
								<input type="text" class="form-control" id="Date" name="DATER" value="<?= $DateF;?>"/>
							</div>
							<div class="col-md-3">	
								<label class="control-label" for="success">End Date</label>
								<input type="text" class="form-control" id="Date1" name="DATEE" value="<?= $DateE;?>"/>
							</div>
						   <div class="col-md-1"><label class="control-label" for="success">Action</label><button class="btn btn-default" name="search_data" type="submit"><i class=" fa fa-search "></i></button></div>
                        </form>
						</div>
                        </div>
						
						<div class="row" style="position:relative;">
						<p style="top:20px;right:20px;position:absolute;"><img src='img/print_icon.jpg' style='width:30px;height:30px;cursor:pointer;'  onclick='PrintDiv()'/> </p>
						<?php
						$get = isset($_GET['show']) ? $_GET['show'] : '0';
						$search = '';
						if(isset($_POST['search_data'])){
							$search = isset($_POST['search']) ? $_POST['search'] : '';
						}
						
						if($DateF > $DateE){
							$DateF = $DateE;
						}
						//echo $DateF.'-'.$DateE;
						if(strlen($search) > 0){
							$searchG = query("SELECT * FROM s_saving WHERE MEMBER_ID_MA = '".$search."' AND SAVING_STATUS = 'Active' AND DATE_SAVING BETWEEN '".$DateF."' AND '".$DateE."'  AND TYPE = 'Saving' ORDER BY SAVING_ID DESC");
						
						}else{
							$searchG = query("SELECT * FROM s_saving WHERE SAVING_STATUS = 'Active' AND DATE_SAVING BETWEEN '".$DateF."' AND '".$DateE."' AND TYPE = 'Saving' ORDER BY SAVING_ID DESC");
						
						}
						$rowTotal = num_row($searchG);
						if($rowTotal > 0){							
						?>
                        <div id='divToPrint'>
							<div class='page'>
								<div class='subpage'>
						
									<div class="panel-body">
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<td colspan="8" align="center">
														<h4><?= comapny_info('COMPANY_NAME');?></h4>
														<h5>Email: <?= comapny_info('COMPANY_EMAIL');?></h5>
														<h5>Phone: <?= comapny_info('COMPANY_PHONE');?></h5>
														<h5>Report Period: <b><?= $DateF?></b> to <b><?= $DateE?></b></h5>
														<h5>Report Title: Saving History Report</h5>
														</td>
													   
													</tr>
													<tr>
														<th>#SL</th>
														<th>Member ID</th>
														<th>Share ID</th>
														<th>Amount</th>
														<th>Fine Amount</th>
														<th>Token</th>
														<th>Days</th>
														<th>Date</th>
													   
													</tr>
												</thead>
												<tbody>
												<?php 
												$sl = $get+1;
												$totalRec = 0;
												$totalRec1 = 0;
												while($fetch = fetch($searchG)){?>
																<tr>
																	<td><center><?= $sl;?></center></td>
																	<td><?= $fetch['MEMBER_ID_MA'];?></td>
																	<td><?= $fetch['SHARE_ID'];?></td>
																	<td><?= number_format($fetch['REC_AMOUNT'], 2);?></td>
																	<td><?= number_format($fetch['FINE_AMOUNT'], 2);?></td>
																	<td><?= $fetch['TOKEN_ID'];?></td>
																	<td><?= $fetch['DAY_ID'];?></td>
																	<td><?= date("d M y", strtotime($fetch['DATE_SAVING']));?></td>
																	
																</tr>
												<?php 
												$totalRec = $totalRec + $fetch['REC_AMOUNT'];
												$totalRec1 = $totalRec1 + $fetch['FINE_AMOUNT'];
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
								</div>
							</div>
                        </div>
					   <?php
					   
					   }else{
						   ?>
							<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<td colspan="8" align="center">
													<h4><?= comapny_info('COMPANY_NAME');?></h4>
													<h5>Email: <?= comapny_info('COMPANY_EMAIL');?></h5>
													<h5>Phone: <?= comapny_info('COMPANY_PHONE');?></h5>
													<h5>Report Period: <b><?= $DateF?></b> to <b><?= $DateE?></b></h5>
													<h5>Report Title: Saving History Report</h5>
													</td>
												   
												</tr>
												<tr>
													<td colspan="8" align="center" ><b>Not found transcation</b> </td>
													
												</tr>
										  </head>
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
