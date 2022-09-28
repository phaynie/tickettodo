<?php

include 'boilerPlate.php';

include 'nav.php';

if($debug) {
    $debug_string .= "HOME.php";
}
?>
<body>
<div class="jumbotron">
    <div class="welcomeText">
        <h1 class="display-4">Welcome, <? echo $_SESSION['name']?>!</h1>
        <p class="lead">Here's the place to document your project progress!</p>
        <p>Everything you need is on the nav bar above.  </p>
        <p>Choose a project and off we go!</p>
        <a class="btn btn-primary btn-lg siteButton " href="howto.php" role="button">Learn more</a>
    </div>
</div>

    
</body>
   
<?php

include 'endingBoilerPlate.php';

$deleteProjectSuccess = "";
$getProjectName = "";

if(isset($_REQUEST['deleteProjectSuccess'])) {
    $deleteProjectSuccess = $_REQUEST['deleteProjectSuccess'];
}

if(isset($_REQUEST['getProjectName'])) {
    $getProjectName = $_REQUEST['getProjectName'];
}


echo $deleteProjectSuccess;

