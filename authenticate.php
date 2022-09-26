<?php




/*Connect to db. Check to see if connection was complete Else error message. Info is in boilerPlate.php below*/
include 'boilerPlate.php';



if($debug) {
    $debug_string .=  "AUTHENTICATE.php";
}

if ( !isset($_POST['username'], $_POST['password']) ) {
    // Could not get the data that should have been sent.
    exit('Please fill both the username and password fields!');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $conn->prepare('SELECT ID, user_password FROM user WHERE user_name = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"

    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();


    if ($stmt->num_rows > 0) {
        /*binding the results to the variables*/
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if (password_verify($_POST['password'], $password)) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            // echo '<br>ktest';
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            header('Location: home.php');
        } else {
            // Incorrect password
            echo 'Incorrect username and/or password!';
            ?>
        <div> 

            <div class="container ">

            <div class="row">
            <div class="col">
            
                <div class="card mb-4" style="border-color: darkseagreen;">
                
                <div class="card-body">
                <h3>Let's Try again</h3>
                    <form method = "post" action = "index.php">           
                <input class="btn siteButton mt-4" type="submit" value="Back">
                </form>
                            

                </div><!--End card-body-->
                </div><!--End Card-->
            </div><!--End Col-->
            </div><!--End Row-->
            </div><!--End Container-->

        </div>
        <?php

        }
    } else {
        // Incorrect username
        echo 'Incorrect username and/or password!';

        ?>
        <div> 

            <div class="container ">

            <div class="row">
            <div class="col">
            
                <div class="card mb-4" style="border-color: darkseagreen;">
                
                <div class="card-body">
                <h3>Let's Try again</h3>
                    <form method = "post" action = "index.php">           
                <input class="btn siteButton mt-4" type="submit" value="Back">
                </form>
                            

                </div><!--End card-body-->
                </div><!--End Card-->
            </div><!--End Col-->
            </div><!--End Row-->
            </div><!--End Container-->

        </div>
        <?php

    }

    $stmt->close();
}




include 'endingBoilerPlate.php';
