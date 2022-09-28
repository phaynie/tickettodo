<?php

include 'boilerPlate.php';
/*registration code*/

$submit = "";


if(isset($_REQUEST['submit'])) {
    $submit = $_REQUEST['submit'];
}

/*Process form fields*/
/*Check for basic validation*/
/*Code for Registration*/


If($submit){
// Now we check if the data was submitted, isset() function will check if the data exists.
    if (!isset($_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['email'], $_POST['password'])) {
        // Could not get the data that should have been sent.
        exit('Please complete the registration form!');
    }
    // Make sure the submitted registration values are not empty.
    if (empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['username']) || empty($_POST['email'])
        || empty($_POST['password'])) {
        // One or more values are empty.
        exit('Please complete the registration form');
    }




    // We need to check if the account with that username exists.
    if ($stmt = $conn->prepare('SELECT id, user_password FROM user WHERE user_name = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();
        // Store the result so we can check if the account exists in the database.
        if ($stmt->num_rows > 0) {
            // Username already exists    
            echo 'Username is already being used, please choose another!';
            header('Location: index.php');
            exit();
        } else {
            // Username doesnt exists, insert new account
            if ($stmt = $conn->prepare('INSERT INTO user (first_name, last_name, user_name, user_email, user_password, roles_ID, active) VALUES (?, ?, ?, ?, ?, 1, 1)')) {
                // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $stmt->bind_param('sssss', $_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['email'], $password );
                $stmt->execute();
                echo 'You have successfully registered, you can now login!';
                header('Location: index.php');
                exit();

            } else {
                // Something is wrong with the sql statement, check to make sure accounts table exists with all 5
                // fields.
                echo 'Could not prepare statement!';
            }
        }
        $stmt->close();
} else {
    // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
    echo 'Could not prepare statement!';
}
$conn->close();





}else if(!$submit) {
/*Code for registration form*/
    echo
    "<div class='container' style='width:50%;'>
        <div class='row'>
            <div class='col'>
                <div class='card'>
                    <div class='card-header'>Create New Account</div>
                        <div class='card-body'>
                            <form action='register.php' method='post' autocomplete='off'>
                                <div class='row'>
                                    <div class='col'>
                                        <label for='firstName'>
                                            <i class='fas fa-user'></i>
                                        </label>
                                        <input type='text' name='firstName' placeholder='First Name' id='firstName' required></br></br>
                                        <label for='lastName'>
                                            <i class='fas fa-user'></i>
                                        </label>
                                        <input type='text' name='lastName' placeholder='Last Name' id='lastName' required></br></br>
                                        <label for='username'>
                                            <i class='fas fa-user'></i>
                                        </label>
                                        <input type='text' name='username' placeholder='Username' id='username' required></br></br>
                                    </div><!--end col-->
                                    <div class='col'>
                                        <label for='password'>
                                            <i class='fas fa-lock'></i>
                                        </label>
                                        <input type='password' name='password' placeholder='Password' id='password' required></br></br>
                                        <label for='email'>
                                            <i class='fas fa-envelope'></i>
                                        </label>
                                        <input type='email' name='email' placeholder='Email' id='email' required></br></br>
                                    </div><!--end col-->
                                </div><!--end row-->
                                <div class='row'>
                                    <div class='col'>
                                        &nbsp &nbsp <input type='submit' value='Register' class='btn siteButton'>
                                        <input type='hidden'  name='submit' value='true'>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </form>

                    </div> <!--end card-body-->
                </div> <!--end card-->
            </div> <!--end col-->
        </div> <!--end row-->
    </div> <!--end container-->";

}
include 'endingBoilerPlate.php';