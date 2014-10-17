<?php
require 'vendor/autoload.php';
$app = new \Slim\Slim();
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

$mysqli = new mysqli("localhost", "root", "compassstudios", "mydb");
if ($mysqli->connect_errno)
    die("Connection failed: " . $mysqli->connect_error);

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

$app->get('/getLastOrder/:userID', function ($id) { //currently untested
    global $mysqli;
    $orderList=$mysqli->query("SELECT idOrder FROM BurgerOrder WHERE id=".$id);
    $largestID=0;
    for($i=0; $i<sizeOf($orderList); $i++){ //find the most recent order
        if($orderList[$i]>$largestID){
            $largestID=$orderList[$i];
        }
    }
    //get list of burgers in the most recent order and create list of components of each burger
    $burgerSet=array();
    $burgerList=$mysqli->query("SELECT idBurger FROM Burger Where BurgerOrder_idOrder = " . $largestID);
    for($i=0; $i<sizeOf($burgerList); $i++){
        $theQuery="SELECT BurgerComponent_idBurgerComponent FROM Burger_has_BurgerComponent WHERE Burger_idBurger=".$burgerList[$i];
        $burgerComp=$mysqli->query($theQuery);
        array_push($burgerSet, $burgerComp);
    }
    json_encode($burgerSet);
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
    global $mysqli;
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $CCprovider = $_POST['CCprovider'];
    $CCNumber = $_POST['CCNumber'];
    if($fName === "" || $lName === "" || $email === "" || $password === "" || $CCprovider === "" || $CCNumber === "")
	$outputJSON = array ('u_id'=>-2);
    else{
	$dupCheck = $mysqli->query("SELECT email FROM User WHERE email = '$email' LIMIT 1");
	$checkResults = $dupCheck->fetch_assoc();
	    if(!($checkResults === NULL))
		$outputJSON = array ('u_id'=>-1);
	    else{
		$prevUser = $mysqli->query("SELECT idUser FROM User ORDER BY idUser DESC LIMIT 1");
		$row = $prevUser->fetch_assoc();
		if($row === NULL){
		    $outputJSON = array ('u_id'=>1);
		    $CCNumber = (int) $CCNumber;
		    $insertion = $mysqli->query("INSERT INTO User (idUser, fName, lName, email, password, ccProvider, ccNumber) VALUES (1, '$fName', '$lName', '$email', '$password', '$CCprovider', $CCNumber)");
		}
		else{
		    $newID = $row['idUser']+1;
		    $outputJSON = array ('u_id'=>$newID);
		    $CCNumber = (int) $CCNumber;
		    $insertion = $mysqli->query("INSERT INTO User (idUser, fName, lName, email, password, ccProvider, ccNumber) VALUES ($newID, '$fName', '$lName', '$email', '$password', '$CCprovider', $CCNumber)");
		}
            }
        }
	echo json_encode($outputJSON);
});

$app->post('/loginUser', function () {
    $dummyJSON = array ('status'=>"Success", "user_id"=>1,"fName"=>"Austin","lName"=>"Wells","CCnum"=>1234,"CCprovider"=>"Visa");
    $email = $_POST['email'];
    $password = $_POST['password'];
    echo json_encode($dummyJSON);
});

$app->post('/placeUserOrder', function () {
    global $mysqli;
    $outputJSON = array ('status'=>"Success");
    $userID = $_POST['userID'];
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $CCprovider = $_POST['CCprovider'];
    $CCNumber = $_POST['CCNumber'];
    $burgers = $_POST['burgers'];
    $userID = (int) $userID;

    $getOrderID = $mysqli->query("SELECT idOrder FROM burgerOrder ORDER BY idOrder DESC LIMIT 1");
    if($getOrderID === false)
	$prevOrderID = 0;
    else
	$prevOrderID = $getOrderID->fetch_assoc();


    $getBurgerID = $mysqli->query("SELECT idBurger FROM Burger ORDER BY idBurger DESC LIMIT 1");
    if($getBurgerID === false)
	$prevBurgerID = 0;
    else
	$prevBurgerID = $getBurgerID->fetch_assoc();

    $newOrderID = (int) $prevOrderID['idOrder'] + 1;
    if(!($userID === NULL))
	$order = $mysqli->query("INSERT INTO burgerOrder VALUES ($newOrderID,$userID)");
    else{
	if($fName === NULL || $lName === NULL || $CCprovider === NULL || $CCNumber === NULL)
	    $outputJSON = array ('status'=>"Failure");
	else
		$order = $mysqli->query("INSERT INTO burgerOrder VALUES ($newOrderID,$userID)");
	}
	$burgerList = json_decode($burgers);
	$burgerID = $prevBurgerID['idBurger'];
	foreach($burgerList as $burger)	{
	    $burgerID = (int) $burgerID+1;
	    $burger = (array) $burger;
	    $quantity = (int) $burger['quantity'];
	    $orderIDString = (string) $newOrderID;
	    $newBurger = $mysqli->query("INSERT INTO Burger VALUES ($burgerID,'$orderIDString',$quantity)");
	    
	    foreach($burger["components"] as $component){
		$getComponentID = $mysqli->query("SELECT idBurgerComponent FROM BurgerComponent WHERE ComponentName = '$component' LIMIT 1");
		if(!($getComponentID === false))
		    $componentID = $getComponentID->fetch_assoc();
		else{
		    $outputJSON = array('status'=>"Failure");
		    break 2;
		}
		$componentID = (int) $componentID['idBurgerComponent'];
		$newComponent = $mysqli->query("INSERT INTO Burger_has_BurgerComponent VALUES ('$burgerID','$componentID')");
		}
	    }
	
    
    
    echo json_encode($outputJSON);
});



$app->run();
?>
