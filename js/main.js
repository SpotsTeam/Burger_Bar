
<<<<<<< HEAD
//if(request.status === 200){
//    var json = JSON.parse(request.responseText);
//}
=======

document.getElementById("signInEmail").removeAttribute("required");
document.getElementById("signInPass").removeAttribute("required");

var submit;
>>>>>>> 6f6d3cbfbe5d00fade30b2e9784b7e54e1ee08a4


document.getElementById("signInEmail").removeAttribute("required");
document.getElementById("signInPass").removeAttribute("required");

//Select type of meat.
var meat;
var meats = document.getElementsByName("meat");
for (var i = 0; i < meats.length; ++i) {
  var m = meats[i];
  m.addEventListener("click", selectMeat, false);
}
function selectMeat(){
	if(document.getElementById('ThirdBeef').checked) {
	  	meat = document.getElementById('ThirdBeef').value;
	}else if(document.getElementById('halfBeef').checked) {
		meat = document.getElementById('halfBeef').value;
	}else if(document.getElementById('Turkey').checked) {
		meat = document.getElementById('Turkey').value;
	}else if(document.getElementById('Veggie').checked) {
		meat = document.getElementById('Veggie').value
	}
}

//Select type of bun.
var bun;
var buns = document.getElementsByName("bun");
for (var i = 0; i < buns.length; ++i) {
  var b = buns[i];
  b.addEventListener("click", selectBun, false);
}
function selectBun(){
	if(document.getElementById('White').checked) {
	 	bun = document.getElementById('White').value;
	}else if(document.getElementById('Wheat').checked) {
		bun = document.getElementById('Wheat').value;
	}else if(document.getElementById('TexasToast').checked) {
		bun = document.getElementById('TexasToast').value;
	}
}


//Select type of cheese.
var cheese;
var cheeses = document.getElementsByName("cheese");
for (var i = 0; i < cheeses.length; ++i) {
  var c = cheeses[i];
  c.addEventListener("click", selectCheese, false);
}
function selectCheese(){
	if(document.getElementById('Cheddar').checked) {
	 	cheese = document.getElementById('Cheddar').value;
	}else if(document.getElementById('American').checked) {
		cheese = document.getElementById('American').value;
	}else if(document.getElementById('Swiss').checked) {
		cheese = document.getElementById('Swiss').value;
	}else if(document.getElementById('None').checked) {
		cheese = document.getElementById('None').value;
	}
}

//Select type of side.
var side;
var sides = document.getElementsByName("side");
for (var i = 0; i < sides.length; ++i) {
  var s = sides[i];
  s.addEventListener("click", selectSide, false);
}
function selectSide(){
	if(document.getElementById('FrenchFries').checked) {
	 	side = document.getElementById('FrenchFries').value;
	}else if(document.getElementById('TaterTots').checked) {
		side = document.getElementById('TaterTots').value;
	}else if(document.getElementById('OnionRings').checked) {
		side = document.getElementById('OnionRings').value;
	}else if(document.getElementById('None').checked) {
		side = document.getElementById('None').value;
	}
}
