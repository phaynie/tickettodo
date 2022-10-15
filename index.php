<?php


include 'boilerPlate.php';




if($debug) {
    $debug_string .= "INDEX.php";
}
echo $debug_string;
$pageNameIndex = true;
?>

<div class="container">
    <div class="row">
        <div class="col-lg-4 ">
            <img class="logoImage" src="img/ticketlogogreen.png" alt="logo" width="300" height="auto">
         </div>
        <div class="col-lg-8">
            <h1 class="welcomeText">Welcome to TicketTodo</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card  float-left " style="width:100%">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form action="authenticate.php" method="post">
                        <label for="username">
                            <i class="fas fa-user"></i>
                        </label>
                        <input type="text" name="username" placeholder="Username" id="username" required><br/><br/>
                        <label for="password">
                            <i class="fas fa-lock"></i>
                        </label>
                        <input type="password" name="password" placeholder="Password" id="password" required><br/><br/>
                        <input type="submit"  class="btn siteButton" value="Log In">
                    </form></br>
                    <form  action="register.php" method="post">
                        <!--Might not need to be a submit button? no trip to db...-->
                        <input type="submit" class="btn siteButton" value="Create a New Account">
                    </form>
                </div> <!--end card-body-->
            </div> <!--end card-->
        </div>  <!--end col-->  
        <div class="col" style="width:90%;" >
            <div class="sample">
                <br><br>
                <p><strong>WANT TO TRY IT OUT?</strong></p>
                <p>Username: sampleUserName</p>
                <p>password: samplePassword</p>
                <p>You will have access to the project called sampleProject</p>
                <p>*Because this is a trial project all data erases every time you leave the site!</p>
            </div>
            
        </div> <!--end col-->
    </div></br></br> <!--end row-->
    
    
</div></br></br> <!--end container-->




<?php
include 'endingBoilerPlate.php';
