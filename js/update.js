function hide(id){
	//alert(id);
	$("#mamber"+id).toggle();
}
$(document).ready(function(){
	var data = $("#MEMBER_ID_MA").val();
	if(data > 0){
		check_customer(data);
	}
})

function check_customer(data){
	$("#SHARE_ID").val('');
	$("#MEMBER_NAME").val('');
	$("#AMOUNT_ID").val('');
	
	$.get("ajax/get_customer_check.php",{ data: data}, function(data1){
		if(data1 != 0){
			var res = data1.split("__");
			//alert(res[0]);
			$("#SHARE_ID").val(res[0]);
			$("#MEMBER_NAME").val(res[1]);
			var amount = res[0]*10;
			$("#AMOUNT_ID").val(amount);
			$("#add_saving").removeAttr("disabled");
		}else{
			$("#add_saving").attr("disabled","disabled");
			alert("Invalid Customer ID");
			
		}
	})
}

function loanAmout(data){
	loanAmountShow(data);
}
function loanAmountShow(data){
	$("#LOAN_ID").val('');
	$("#loan_view").html('');
	$("#AMOUNT_ID_LOAN").val('');
	$("#INTERSET_ID").val('');
	$("#Rec_view").html('');
	$("#due_view").html('');
	$("#total_view").html('');
	$.get("ajax/get_check_loan.php",{ data: data}, function(data1){
		if(data1 != 0){
			var res = data1.split("__");
			//alert(res[0]);
			$("#loan_view").html(res[0]);
			$("#LOAN_ID").val(res[1]);
			$("#Rec_view").html(res[3]);
			$("#due_view").html(res[2]);
			$("#add_saving").removeAttr("disabled");
			loanAmoutMinus();
		}else{
			$("#add_saving").attr("disabled","disabled");
			alert("Invalid Customer ID");
			
		}
	})
}

function loanAmoutMinus(){
	var data = $("#AMOUNT_ID_loan").val().replace(/\,/g,"");
	var total = $("#loan_view").html().replace(/\,/g,"");
	var due = $("#due_view").html().replace(/\,/g,"");
	var totalDue = due - data;
	//alert(totalDue);
	$("#total_view").html('');
	if(due > 0){
		var inter = (totalDue*1.5)/100;
		//var totalGet = inter;
		$("#INTERSET_ID").val(inter);
		//$("#total_view").html(totalGet);
	}
}

function fine_amount(data){
	$("#fine_view").html('');
	if(data > 7){
		var date = data-7;
		var share = $("#SHARE_ID").val();
		var amount = share * date;
		$("#fine_view").html(amount);
	}
}