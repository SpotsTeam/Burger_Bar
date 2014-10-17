<?php
require 'vendor/autoload.php';
$app = new \Slim\Slim();
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

/*$mysqli = new mysqli("localhost", "root", "root", "burgerDB");
if ($mysqli->connect_errno)
    die("Connection failed: " . $mysqli->connect_error);*/

$app->get('/getMeats', function () {
	$meats = '{
		"meats": [
		{
			"name": "1/3 lb. Beef",
			"price": 2
		},
		{
			"name": "1/2 lb. Beef",
			"price": 2.25
		},
		{
			"name": "2/3 lb. Beef",
			"price": 2.5
		},
		{
			"name": "Turkey",
			"price": 2
		},
		{
			"name": "Veggie",
			"price": 2
		}
		]
	}'; 

    echo json_encode(json_decode($meats, true));
});

$app->get('/getBuns', function () {
	$buns = '{"buns": [
	{
		"name": "White",
		"price": 0.50
	},
	{
		"name": "Wheat",
		"price": 0.50
	},
	{
		"name": "Texas Toast",
		"price": 0.75
	}
	] } ';
    echo json_encode(json_decode($buns, true));
});

$app->get('/getCheeses', function () {
	$cheeses =  '{ "cheeses": [
	{
		"name": "Cheddar",
		"price": 0.35
	},
	{
		"name": "American",
		"price": 0.35
	},
	{
		"name": "Swiss",
		"price": 0.35
	}
	] }';
    echo json_encode(json_decode($cheeses, true));
});

$app->get('/getToppings', function () {
    $toppings =  '{ "toppings": [
			{
                "name": "Tomatoes",
                "price": 0
            },
			{
                "name": "Lettuce",
                "price": 0
            },
            {
                "name": "Onions",
                "price": 0
            },
			{
                "name": "Pickles",
                "price": 0
            },
			{
				"name": "Bacon",
				"price": 1
			},
			{
                "name": "Red onion",
                "price": 0
            },
            {
                "name": "Mushrooms",
                "price": 0
            },
			{
                "name": "Jalapenos",
                "price": 0
            }
        ] }';
       echo json_encode(json_decode($toppings, true));

});

$app->get('/getSauces', function () {
    $sauces =  '{"sauces": [
            {
                "name": "Ketchup",
                "price": 0
            },
            {
                "name": "Mustard",
                "price": 0
            },
            {
                "name": "Mayonnaise",
                "price": 0
            },
            {
                "name": "BBQ",
                "price": 0
            }
        ]}';
        echo json_encode(json_decode($sauces, true));

});

$app->get('/getSides', function () {
    $sides =  '{"sides": [
            {
                "name": "French fries",
                "price": 1
            },
            {
                "name": "Tater tots",
                "price": 1
            },
            {
                "name": "Onion rings",
                "price": 1
            }
        ]}';
        echo json_encode(json_decode($sides, true));

});

$app->get('/getLastOrder/:userID', function ($id) { //unfinished don't call this
    global $mysqli;
    $orderList=$mysqli->query("SELECT idOrder FROM order WHERE id=".$id);
    $largestID=0;
    for($i=0; $i<sizeOf($orderList); $i++){ //find the most recent order
        if($orderList[$i]>$largestID){
            $largestID=$orderList[$i];
        }
    }
    //get list of burgers in last order and create list of components of each burger
    $burgerList=$mysqli->query("SELECT idBurger FROM Burger Where Order_idOrder = ".largestID);
    for($i=0; $i<sizeOf($burgerList); $i++){
        $theQuery="SELECT BurgerComponent_idBurgerComponent FROM Burger_has_BurgerComponent WHERE Burger_idBurger=".$burgerList[$i];
        $burgerComp=$mysqli->query($theQuery);
        //under construction

    }
    /*$componentsForBurger1 = array ("1/3 lb. Beef","White","Cheddar","Onions", "Bacon","French fries");
    $quantityForBurger1 = 1;
    $burger1 = array("components"=>$componentsForBurger1,"quantity"=>$quantityForBurger1);
    $query = "select idOrder from order";
    $result= mysql_query($query);

    $componentsForBurger2 = array ("1/3 lb. Beef","White","Cheddar","Onions", "Mustard","Mayonnaise","Bacon");
    $quantityForBurger2 = 5; 
    $burger2 = array("components"=>$componentsForBurger1,"quantity"=>$quantityForBurger2);

    $burgers = array("1" => $burger1, "2" => $burger2);
    echo json_encode($burgers);*/
});

$app->post('/createUserAccount', function () {
    $dummyJSON = array ('u_id'=>1);
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $CCprovider = $_POST['CCprovider'];
    $CCNumber = $_POST['CCNumber'];
    echo json_encode($dummyJSON);
});

$app->post('/loginUser', function () {
    $dummyJSON = array ('status'=>"Success", "user_id"=>1,"fName"=>"Austin","lName"=>"Wells","CCnum"=>1234,"CCprovider"=>"Visa");
    $email = $_POST['email'];
    $password = $_POST['password'];
    echo json_encode($dummyJSON);
});

$app->post('/placeUserOrder', function () {
    $dummyJSON = array ('status'=>"Success");
    $fName = $_POST['userID'];
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $CCprovider = $_POST['CCprovider'];
    $CCNumber = $_POST['CCNumber'];
    $burgers = $_POST['burgers'];

    echo json_encode($dummyJSON);
});



$app->run();
?>