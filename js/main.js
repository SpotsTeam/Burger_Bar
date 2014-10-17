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





var meatPrices = new Array();
var bunPrices = new Array();
var cheesePrices = new Array();
var toppingPrices = new Array();
var saucePrices = new Array();
var sidePrices = new Array();

var total = 0;

var url = "./api/index.php/getMeats";
var request = new XMLHttpRequest();
request.open('GET', url, false);
request.send();
if(request.status === 200){
    var json = JSON.parse(request.responseText);
    var html = '';
	for(var i = 0; i < json.meats.length; i++){
		html += '<input type="radio" name="meat" value="'+json.meats[i].name+'" id="'+json.meats[i].name+'">'+json.meats[i].name;
                if(json.meats[i].name.indexOf("Beef") > -1){
                    html += '<br><img class = "MenuPics" src="img/Beef.png">';
                }
                else{
                    html+= '<br><img class = "MenuPics" src="img/' + json.meats[i].name + '.png">';
                }
		meatPrices.push(json.meats[i].price);
	}
	document.getElementById("meats").innerHTML = html;
}

url = "./api/index.php/getBuns";
request.open('GET', url, false);
request.send();
if(request.status === 200){
    var json = JSON.parse(request.responseText);
    var html = '';
	for(var i = 0; i < json.buns.length; i++){
		html += '<input type="radio" name="bun" value="'+json.buns[i].name+'" id="'+json.buns[i].name+'">'+json.buns[i].name;
		bunPrices.push(json.buns[i].price);
	}
	document.getElementById("buns").innerHTML = html;
}

url = "./api/index.php/getCheeses";
request.open('GET', url, false);
request.send();
if(request.status === 200){
    var json = JSON.parse(request.responseText);
    var html = '';
	for(var i = 0; i < json.cheeses.length; i++){
		html += '<input type="radio" name="cheese" value="'+json.cheeses[i].name+'" id="'+json.cheeses[i].name+'">'+json.cheeses[i].name;
		cheesePrices.push(json.cheeses[i].price);
	}
	document.getElementById("cheeses").innerHTML = html;
}

url = "./api/index.php/getToppings";
request.open('GET', url, false);
request.send();
if(request.status === 200){
    var json = JSON.parse(request.responseText);
    var html = '';
	for(var i = 0; i < json.toppings.length; i++){
		html += '<input type="checkbox" name="topping" value="'+json.toppings[i].name+'" id="'+json.toppings[i].name+'">'+json.toppings[i].name;
		toppingPrices.push(json.toppings[i].price);
	}
	document.getElementById("toppings").innerHTML = html;
}

url = "./api/index.php/getSauces";
request.open('GET', url, false);
request.send();
if(request.status === 200){
    var json = JSON.parse(request.responseText);
    var html = '';
	for(var i = 0; i < json.sauces.length; i++){
		html += '<input type="checkbox" name="sauce" value="'+json.sauces[i].name+'" id="'+json.sauces[i].name+'">'+json.sauces[i].name;
		saucePrices.push(json.sauces[i].price);
	}
	document.getElementById("sauces").innerHTML = html;
}

url = "./api/index.php/getSides";
request.open('GET', url, false);
request.send();
if(request.status === 200){
    var json = JSON.parse(request.responseText);
    var html = '';
	for(var i = 0; i < json.sides.length; i++){
		html += '<input type="radio" name="side" value="'+json.sides[i].name+'" id="'+json.sides[i].name+'">'+json.sides[i].name;
		sidePrices.push(json.sides[i].price);
	}
	document.getElementById("sides").innerHTML = html;
}





$(document).on('click', '.button', function(){ 
   var bttn = $(this).attr('id'); 
   if(bttn === "register"){
		document.getElementById("signInEmail").removeAttribute("required");
		document.getElementById("signInPass").removeAttribute("required");

   } else {
   		return false;
   }
});





var meats = document.getElementsByName("meat");
function selectMeat(){
	for (var i=0; i < meats.length; i++){
	   if (meats[i].checked){
	      document.getElementById("burgerMeat").innerHTML = meats[i].value + ': $' + meatPrices[i];
	      total += meatPrices[i];
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
	      document.getElementById("burgerBun").innerHTML = buns[i].value + ': $' + bunPrices[i];
	      total += bunPrices[i];
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
	      document.getElementById("burgerCheese").innerHTML = cheeses[i].value + ': $' + cheesePrices[i];
	      total += cheesePrices[i];
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
	      document.getElementById("burgerSide").innerHTML = sides[i].value + ': $' + sidePrices[i];
	      total += sidePrices[i];
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
	var price = 0;
	for (var i = 0; i < toppings.length; ++i) {
	  if(toppings[i].checked){
	  	toppingsSelected.push(toppings[i].value);
	  	price += toppingPrices[i];
	  }
	}
	document.getElementById("burgerToppings").innerHTML = toppingsSelected + ': $' + price;
	total += price;
}

var sauces = document.getElementsByName("sauce");
for (var i = 0; i < sauces.length; ++i) {
  var sauce = sauces[i];
  sauce.addEventListener("click", selectSauces, false);
}
function selectSauces(){
	var saucesSelected = new Array();
	var price = 0;
	for (var i = 0; i < sauces.length; ++i) {
	  if(sauces[i].checked){
	  	saucesSelected.push(sauces[i].value);
	  	price += toppingPrices[i];
	  }
	}
	document.getElementById("burgerSauces").innerHTML = saucesSelected + ': $' + price;
	total += price;
}

document.getElementById("totalPrice").innerHTML = "Total Price: $" + total;