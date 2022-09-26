<?php
include 'boilerPlate.php';

include 'nav.php';
$projectListItem = "";

if($debug) {
    $debug_string .= "PROFILE.php </br>";
}

// get the results from the database.
$stmt = $conn->prepare('SELECT first_name, last_name, user_email, user_password FROM user WHERE id = ?');
//  use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($firstName,$lastName,$email,$password);
$stmt->fetch();
$stmt->close();



/*Here we need to gather the names of all the projects our user has access to
We are going to loop them into a list. HTML below.
Select project_name from project Where user_ID = current logged in user
First lets just list all of the projects that exist*/




//$projectQuery = "SELECT ID, project_name
//    FROM project
//    ORDER BY project_name ASC";
//
//    $projectQueryResult = $conn->query($projectQuery);
//
//
//    if ($debug) {
//
//        echo 'projectQuery = ' . $projectQuery . '<br/><br/>';
//        if (!$projectQueryResult) echo("\n Error description query projectQuery: " . mysqli_error($conn) . "\n<br/>");
//    }/*end debug*/
//
//    if ($projectQueryResult) {
//
//
//        /*This requires the function if we want to use it*/
//
//// failureToExecute ($projectQueryResult, 'S1', 'Select ');
//
//
//        $numberOfProjectRows = $projectQueryResult->num_rows;
//
//        /* this begins the process for projects  */
//        $projectListItem = "<ul>";
//
//        for ($j = 0; $j < $numberOfProjectRows; ++$j) {
//            $row = $projectQueryResult->fetch_array(MYSQLI_NUM);
//
//            $projectID = $row[0];
//            $projectName = $row[1];
//
//            $projectListItem.="<li>$projectName</li>";
//
//        }
//        $projectListItem.="</ul>";
//    }





/*This query asks for just the projects that the user has access to. */


$projectQuery = "SELECT p.ID, p.project_name, u.ID, u.user_name
FROM project AS p
LEFT JOIN user2project ON p.ID = user2project.project_ID
LEFT JOIN user AS u ON u.ID = user2project.user_ID
WHERE u.ID = $userSessID
ORDER BY project_name ASC";

$projectQueryResult = $conn->query($projectQuery);


if ($debug) {
    $debug_string .= 'projectQuery = ' . $projectQuery . '<br/><br/>';
    if (!$projectQueryResult) {
        $queryError = "\n Error description: projectQuery: " . mysqli_error($conn) . "\n<br/>";
        outputError($queryError);
    }
}/*end debug*/

if ($projectQueryResult) {

    /*This requires the function if we want to use it*/

// failureToExecute ($projectQueryResult, 'S1', 'Select ');

    $numberOfProjectRows = $projectQueryResult->num_rows;

    /* this begins the process for projects  */
    $projectListItem = "";
    $projectListItem .= "<ul>";
    $userName = "";

    for ($j = 0; $j < $numberOfProjectRows; ++$j) {
        $row = $projectQueryResult->fetch_array(MYSQLI_NUM);

        $projectID = $row[0];
        $projectName = $row[1];
        $userID = $row[2];
        $userName= $row[3];

        $projectListItem .="<li>$projectName</li>";

    }
    $projectListItem.="</ul>";
}
echo $debug_string;

?>

<div class=" container loggedin ticketTable">
    <div class="row">
        <div class="col-lg-9">
             <div class="table-responsive-lg">
                <h2>Profile Page: "<?php echo $userName ?>" </h2>

                <table style="width:100%" class="table table-bordered">
                    <tbody>
                    <tr class="d-flex">
                        <td  class="d-none d-lg-block" style="width:100%; background-color:lightgoldenrodyellow;
                                        border-radius:10px 10px 0px
                                        0px;"><h6>Your account details are below:</h6></td>

                    </tr>
                        <tr class="d-flex">
                            <td style="width:25%">First Name:</td>
                            <td style="width:75%"><?=$firstName?></td>
                        </tr>
                        <tr class="d-flex">
                            <td style="width:25%">Last Name:</td>
                            <td style="width:75%"><?=$lastName?></td>
                        </tr>
                        <tr class="d-flex">
                            <td style="width:25%">Username:</td>
                            <td style="width:75%"><?=$_SESSION['name']?></td>
                        </tr>
                        <tr class="d-flex">
                            <td style="width:25%">Email:</td>
                            <td style="width:75%"><?=$email?></td>
                        </tr>
                    </tbody>
                </table>
             </div> <!--end table-responsive-->
         </div> <!--end col-->
    </div> <!--end row-->
</div> <!--end container--->


<div class="container pb-4">
    <div class="row">
        <div class="col-lg-9">
            <div class="card profilecard">
                <h6 class="pl-3  pt-3">Projects available to <?=$_SESSION['name']?>:</h6>
                <div class="card-body">
                    <div> <?php echo $projectListItem; ?> </div>
                </div> <!--end card-body-->
                <h6 class="pl-3"> You can change to a different project in the nav bar above.</h6>
                <div class="card-footer" style="background-color: lightgoldenrodyellow; border-color:black;"></div>
            </div> <!--end card-->
        </div> <!--end col-->
    </div> <!--end row-->
</div> <!--end container-->


<?php
include 'endingBoilerPlate.php';