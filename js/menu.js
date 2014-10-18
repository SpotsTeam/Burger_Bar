$("#toppings").hide();

$(document).ready(function() {
  	$("#patty_type.tile").click(function(){
		if (!$("#toppings").is(":visible") ) {
			$("#toppings").slideToggle("slow");
		}
  	});

	
});

$(document).ready(function() {
	$("#addToOrder_button").click(function() {
		var burger = new Array();
		burger['type'] = $('input[name=type]:checked', '#burger').val();
		burger['bun'] = $('input[name=bun]:checked', '#burger').val();
		burger['cheese'] = $('input[name=cheese]:checked', '#burger').val();
		
		burger['sauces'] = new Array();
		$('input[name=sauces]:checked', '#burger').each(function() {
			burger['sauces'].push($(this).val());
		});
		
		burger['toppings'] = new Array();
		$('input[name=toppings]:checked', '#burger').each(function() {
			burger['toppings'].push($(this).val());
		});

		return burger;  
	});
});

