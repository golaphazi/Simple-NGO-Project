function removeChar(item)
{ 
	//alert();
	var val = item.value;
  	val = val.replace(/[^0-9,.]/g, "");  
  	if (val == ' '){val = ''};   
  	item.value=val;
}
function removeDate(item)
{ 
	//alert();
	var val = item.value;
  	val = val.replace(/[^0-9-]/g, "");  
  	if (val == ' '){val = ''};   
  	item.value=val;
}
function removeNumber(item)
{ 
	//alert('hi therer');
	var val = item.value;
	val = val.replace(/[^A-Za-z.: ]/g, "");
	if (val == ' '){val = ''};   
	item.value=val;
	//alert();
}

function setChar_int(item)
{ 
	var val = item.value;
	val = val.replace(/[^A-Za-z0-9 ]/g, "");
	if (val == ' '){val = ''};   
	item.value=val;
	//alert();
}

function removeSpcial(item)
{ 
	var val = item.value;
	val = val.replace(/[^A-Za-z0-9@._-]/g, "");
	if (val == ' '){val = ''};   
	item.value=val;
	//alert();
}
function removeSpace(item)
{ 
	var val = item.value;
	val = val.replace(/[^A-Za-z0-9@_.-=><!$]/g, "");
	if (val == ' '){val = ''};   
	item.value=val;
	//alert();
}
