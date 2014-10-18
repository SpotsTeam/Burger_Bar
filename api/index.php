<?php
require 'vendor/autoload.php';
$app = new \Slim\Slim();
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

$mysqli = new mysqli("localhost", "root", "root", "mydb");
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
    $orderQuery=$mysqli->query("SELECT idOrder FROM BurgerOrder WHERE User_idUser = '$id' ORDER BY idOrder DESC LIMIT 1");
    $largestID=$orderQuery->fetch_assoc();

    //echo "largest = ".$largestID['idOrder'];
   
    $burgerSet=array();
    //get list of burgers in the most recent order and create list of components of each burger
    $burgerList=$mysqli->query("SELECT idBurger FROM Burger Where BurgerOrder_idOrder = '".$largestID['idOrder']."'");
    $counter=1;
    while(true){
        $burger=$burgerList->fetch_assoc();
        
        if($burger===NULL)  //break if no more rows
            break;

        //echo "->".$burger['idBurger'];
        $compQuery="SELECT BurgerComponent_idBurgerComponent FROM Burger_has_BurgerComponent WHERE Burger_idBurger='" . $burger["idBurger"]."'";
        $compList=$mysqli->query($compQuery);
        $burgerSubset=array(/*"u_id"=>"component"*/);
        while(true){
            $comp = $compList->fetch_assoc();  //break if no more rows
            if($comp===NULL)
                break;
            $nameQuery=$mysqli->query("SELECT componentName FROM BurgerComponent WHERE idBurgerComponent='".$comp["BurgerComponent_idBurgerComponent"]."'");
            $name=$nameQuery->fetch_assoc();
            //echo "(".$name['componentName'].")";
           array_push($burgerSubset, $name['componentName']);
        }
        $quantityQuery=$mysqli->query("SELECT quantity FROM Burger WHERE idBurger='" . $burger["idBurger"]."'");
        $quantity=$quantityQuery->fetch_assoc();
        //echo "quantity is". $quantity['quantity'];
        $burgerWrap=array('component'=>$burgerSubset, 'quantity'=>$quantity['quantity']);
        $burgerSet["$counter"]=$burgerWrap;
        //echo "    ";
        $counter+=1;
    }
    echo json_encode($burgerSet);
});

$app->post('/createUserAccount', function () {
    global $mysqli;
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $CCprovider = $_POST['CCprovider'];
    $CCNumber = $_POST['CCNumber'];

	//If input has empty field, return failure.
    if($fName === "" || $lName === "" || $email === "" || $password === "" || $CCprovider === "" || $CCNumber === "")
	$outputJSON = array ('u_id'=>-2);
    else{
		//Check if the email is already in the database. Return "duplicate user" failure message.
	$dupCheck = $mysqli->query("SELECT email FROM User WHERE email = '$email' LIMIT 1");
	$checkResults = $dupCheck->fetch_assoc();
	    if(!($checkResults === NULL))
		$outputJSON = array ('u_id'=>-1);
	    else{		//Get greatest userID.
		$prevUser = $mysqli->query("SELECT idUser FROM User ORDER BY idUser DESC LIMIT 1");
		$row = $prevUser->fetch_assoc();
		if($row === NULL){		//If no previous user, set userID to 1
		    $outputJSON = array ('u_id'=>1);
		    $CCNumber = (int) $CCNumber;		//Insert user information.
		    $insertion = $mysqli->query("INSERT INTO User (idUser, fName, lName, email, password, ccProvider, ccNumber) VALUES (1, '$fName', '$lName', '$email', '$password', '$CCprovider', $CCNumber)");
		}
		else{
		    $newID = $row['idUser']+1;		//Sets userID to previous+1.
		    $outputJSON = array ('u_id'=>$newID);
		    $CCNumber = (int) $CCNumber;		//Insert user information.
		    $insertion = $mysqli->query("INSERT INTO User (idUser, fName, lName, email, password, ccProvider, ccNumber) VALUES ($newID, '$fName', '$lName', '$email', '$password', '$CCprovider', $CCNumber)");
		}
            }
        }
	echo json_encode($outputJSON);
});

/*$app->post('/loginUser', function () {
    $dummyJSON = array ('status'=>"Success", "user_id"=>1,"fName"=>"Austin","lName"=>"Wells","CCnum"=>1234,"CCprovider"=>"Visa");
    $email = $_POST['email'];
    $password = $_POST['password'];
    echo json_encode($dummyJSON);
});*/

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
		
	//Finds previous orderID or 0 if there are no previous orders.
    $getOrderID = $mysqli->query("SELECT idOrder FROM BurgerOrder ORDER BY idOrder DESC LIMIT 1");
    if($getOrderID === false)
	$prevOrderID = 0;
    else
	$prevOrderID = $getOrderID->fetch_assoc();

	//Finds previous burgerID or 0 if there are no previous burgers.
    $getBurgerID = $mysqli->query("SELECT idBurger FROM Burger ORDER BY idBurger DESC LIMIT 1");
    if($getBurgerID === false)
	$prevBurgerID = 0;
    else
	$prevBurgerID = $getBurgerID->fetch_assoc();

	//Increments orderID.
    $newOrderID = (int) $prevOrderID['idOrder'] + 1;

	//If a userID was given, creates an order and adds the burgers and their components.
    if(!($userID === 0)){
	$order = $mysqli->query("INSERT INTO BurgerOrder VALUES ($newOrderID,$userID)");	//Creates new order.
	$burgerList = json_decode($burgers);
	$burgerID = $prevBurgerID['idBurger'];
						
	    //Adds new burger for each set of values in the input json.
	foreach($burgerList as $burger)	{
	    $burgerID = (int) $burgerID+1;
	    $burger = (array) $burger;
	    $quantity = (int) $burger['quantity'];
	    $orderIDString = (string) $newOrderID;
	    $newBurger = $mysqli->query("INSERT INTO Burger VALUES ($burgerID,$quantity,'$orderIDString')");
	        
		//Adds components for each component in the components array.
	    foreach($burger["components"] as $component){
		$getComponentID = $mysqli->query("SELECT idBurgerComponent FROM BurgerComponent WHERE ComponentName = '$component' LIMIT 1");
		if(!($getComponentID === false))
		    $componentID = $getComponentID->fetch_assoc();
		else{				//If there is a component in the input that is not in database, there is a gui problem.
		    $outputJSON = array('status'=>"Failure",'message'=>"GUI don goofed");
		    break 2;
		}
		$componentID = (int) $componentID['idBurgerComponent'];
			//Adds the linking table entry between a burger and its component.
		$newComponent = $mysqli->query("INSERT INTO Burger_has_BurgerComponent VALUES ('$burgerID','$componentID')");
		}
	    }
	}
    else			//If one of the inputs is empty, return failure.
	if($fName === "" || $lName === "" || $CCprovider === "" || $CCNumber === "")
	    $outputJSON = array ('status'=>"Failure");
	
	
    
    
    echo json_encode($outputJSON);
});

$app->post('/loginUser', function(){
    global $mysqli;
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {

	$sql = "SELECT idUser FROM User WHERE email='$email'";
	$stmt = $mysqli -> query($sql);			
	$username_test = $stmt -> fetch_assoc();
		
	if(($username_test === NULL)) {
		$JSONarray = array(
			'status'=>'Failure', 
			'user_id'=>NULL,
			'fName'=>NULL,
			'lName'=>NULL,
			'CCnum'=>NULL,
			'CCprovider'=>NULL);
		echo json_encode($JSONarray);
	}
	else{
		$sql = "SELECT password FROM User WHERE email='$email'";
		$stmt = $mysqli -> query($sql);
		$hashedPassword = $stmt -> fetch_assoc();		
		$hashedPassword = $hashedPassword['password'];
		if($hashedPassword === NULL) {
		        $JSONarray = array(
				'status'=>'Failure', 
				'user_id'=>NULL,
				'fName'=>NULL,
				'lName'=>NULL,
				'CCnum'=>NULL,
				'CCprovider'=>NULL);
			echo json_encode($JSONarray);
		} 
	
		else if($password === $hashedPassword) {				
			$_SESSION['loggedin'] = true;
			$query = "SELECT idUser FROM User WHERE email='$email'";
			$stmt2 = $mysqli -> query($query);			
			$temp = $stmt2 -> fetch_assoc();	
			$_SESSION['userId'] = $temp['idUser'];
			$_SESSION['email'] = $email;	

			$statusFlg = 'Succeed';
	
			$components = "SELECT * FROM User WHERE email='$email'";
			$returnValue = $mysqli -> query($components);
			$iteration = $returnValue -> fetch_assoc();
			$JSONarray = array(
				'status'=>$statusFlg,
				'user_id'=>$iteration['idUser'],
				'fName'=>$iteration['fName'],
				'lName'=>$iteration['lName'],
				'CCnum'=>$iteration['ccNumber'],
				'CCprovider'=>$iteration['ccProvider']);
			
		 	echo json_encode($JSONarray); 
		} 

		//verifies password

		else {
			$JSONarray = array(
				'status'=>'Failure', 
				'user_id'=>NULL,
				'fName'=>NULL,
				'lName'=>NULL,
				'CCnum'=>NULL,
				'CCprovider'=>NULL);
			echo json_encode($JSONarray);
		}
	}

	//returns null when password is wrong

        $mysqli = null;
    } catch(exception $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }
});		

$app->post('/logout', function()  { 
    $_SESSION = array(); 
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
});










$app->run();
?>

