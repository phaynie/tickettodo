<?php
include 'config.php';

error_reporting(E_ERROR | E_PARSE); // disabling all warnings because interference with nav.

// error_reporting (E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
// Came from local settings



// CREATE SOME DEBUG CODE TO HELP YOU OUT
$debug = false;
if($debug !== true) {
    error_reporting(E_ERROR | E_PARSE); // only show most serious errors, like for production.
}
$debug_string = "";

/*start session*/
session_start();

// If the user is not logged in redirect to the login page...
//if (!isset($_SESSION['loggedin'])) {
//    header('Location: index.php');
//    exit;
//}

//Establish variables to create connection to the db
$hn = 'localhost';  //server name
$db = 'cleverbu_tickettodo';
$un = 'cleverbu_tickettodo';       //user name
/*password coming from config.php */

// CREATE DB CONNECTION
$conn = new mysqli($hn, $un, $pw, $db);

// CHECK DB CONNECTION
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error);
}else {
    if ($debug) {
        $debug_string .= "Connected successfully <br/>";
    }
}

?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Import Google Icon Font-->

<!--    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
<!--    Import materialize.css-->
<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">-->


        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>TicketToDo boilerplate</title>
</head>

<body>



<?php
/*For when user changes the project*/

$chosenDropdownProjectID = "";
$projectName = "";
$activeProject = "";
  
  
  if(isset($_REQUEST['chosenDropdownProjectID'])) {
      $chosenDropdownProjectID = $_REQUEST['chosenDropdownProjectID'];
      $_SESSION['projectID']= $chosenDropdownProjectID;
  }
  
  if(isset($_REQUEST['projectName'])) {
      $projectName = $_REQUEST['projectName'];
      $_SESSION['activeProject'] = $projectName;
     
  }

  $activeProject = $_SESSION['activeProject'];




/*Let's print out what is in the post and Get array each time this page wakes up.*/
if($debug) {
    $debug_string .=  <<<_END
    <h5> POST VALUES </h5>

_END;

    foreach ($_POST as $key => $value)
        echo $key . '=' . $value . '<br />';
} /*end debug*/

if($debug) {
    $debug_string .=  <<<_END
    <h5> GET VALUES </h5>

_END;

    foreach ($_GET as $key => $value)
        echo $key . '=' . $value . '<br />';
} /*end debug*/


if($debug) {
    $debug_string .=  <<<_END
    <h5> SESSION VALUES </h5>

_END;

    foreach ($_SESSION as $key => $value)
        echo $key . '=' . $value . '<br />';
} /*end debug*/















/*function to wash data in my forms*/

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


/*function to validate the user date entry*/
function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/*error output to */
function outputError($Error) {
    $debug_string.= "<span class='error'>$Error</span>";
    file_put_contents('debug.txt', date("
    d D g:ia").$Error, FILE_APPEND);
}

/*Code from catalog it project. Is this the mysqli code Ken was talking about? is $conn the mysqli?*/
function strip_before_insert($conn, $var){
    return $conn->real_escape_string($var);
}