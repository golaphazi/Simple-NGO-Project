<?php
session_start();
require_once("../db_connect.php");
$data = $_REQUEST['data'];
$search = query("SELECT * FROM s_loan WHERE MEMBER_ID_MA = '".$data."' AND LOAN_STATUS = 'Active' ORDER BY LOAN_ID DESC");
if(num_row($search) == 1){
$res = fetch($search);
$LOAN_ID = $res['LOAN_ID'];
$PAY_AMOUNT = $res['PAY_AMOUNT'];
	$sum_rec = fetch(query("SELECT SUM(PAY_AMOUNT) AS toal FROM s_saving WHERE MEMBER_ID_MA = '".$data."' AND SHARE_ID = '".$LOAN_ID."' AND SAVING_STATUS = 'Active' AND TYPE = 'Loan'"));
	$due = $PAY_AMOUNT - $sum_rec['toal'];
	$result = number_format($PAY_AMOUNT, 0).'__'.$LOAN_ID.'__'.number_format($due, 0).'__'.number_format($sum_rec['toal'], 0);
}else{
	$result = 0;
}
echo $result;
?>