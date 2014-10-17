/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//var url = "http://lyle.smu.edu/~jmmurphy/cse3345/http/menu.json";
//var request = new XMLHttpRequest();
//request.open('GET', url, false);
//request.send();

//if(request.status === 200){
//    var json = JSON.parse(request.responseText);
//}


//document.getElementById("signInEmail").removeAttribute("required");
//document.getElementById("signInPass").removeAttribute("required");


/*$(document).on('click', '.button', function(){ 
   var bttn = $(this).attr('id'); 
   if(bttn === "register"){
		document.getElementById("signInEmail").removeAttribute("required");
		document.getElementById("signInPass").removeAttribute("required");

   } else {
   		return false;
   }
});*/

var meats = document.getElementsByName("meat");
function selectMeat(){
	for (var i=0; i < meats.length; i++){
	   if (meats[i].checked){
	      document.getElementById("burgerMeat").innerHTML = meats[i].value;
	      break;
	   }
	}
};
for (var i = 0; i < meats.length; ++i) {
  var meat = meats[i];
  meat.addEventListener("click", selectMeat, false);
}

var buns = document.getElementsByName("bun");
function selectBun(){
	for (var i=0; i < buns.length; i++){
	   if (buns[i].checked){
	      document.getElementById("burgerBun").innerHTML = buns[i].value;
	      break;
	   }
	}
};
for (var i = 0; i < buns.length; ++i) {
  var bun = buns[i];
  bun.addEventListener("click", selectBun, false);
}

var cheeses = document.getElementsByName("cheese");
function selectCheese(){
	for (var i=0; i < cheeses.length; i++){
	   if (cheeses[i].checked){
	      document.getElementById("burgerCheese").innerHTML = cheeses[i].value;
	      break;
	   }
	}
};
for (var i = 0; i < cheeses.length; ++i) {
  var cheese = cheeses[i];
  cheese.addEventListener("click", selectCheese, false);
}

var sides = document.getElementsByName("side");
function selectSide(){
	for (var i=0; i < sides.length; i++){
	   if (sides[i].checked){
	      document.getElementById("burgerSide").innerHTML = sides[i].value;
	      break;
	   }
	}
}
for (var i = 0; i < sides.length; ++i) {
  var side = sides[i];
  side.addEventListener("click", selectSide, false);
}

var toppings = document.getElementsByName("topping");
for (var i = 0; i < toppings.length; ++i) {
  var t = toppings[i];
  t.addEventListener("click", selectToppings, false);
}
function selectToppings(){
	var toppingsSelected = new Array();
	for (var i = 0; i < toppings.length; ++i) {
	  if(toppings[i].checked){
	  	toppingsSelected.push(toppings[i].value);
	  }
	}
	document.getElementById("burgerToppings").innerHTML = toppingsSelected;
}

var sauces = document.getElementsByName("sauce");
for (var i = 0; i < sauces.length; ++i) {
  var sauce = sauces[i];
  sauce.addEventListener("click", selectSauces, false);
}
function selectSauces(){
	var saucesSelected = new Array();
	for (var i = 0; i < sauces.length; ++i) {
	  if(sauces[i].checked){
	  	saucesSelected.push(sauces[i].value);
	  }
	}
	document.getElementById("burgerSauces").innerHTML = saucesSelected;
}
