<?php
/*Because boiler plate always comes before include nav, Nav bar only shows if user is logged in...Might have changed this. */

/*We need to determine who the user is and what project has been chosen*/
$userSessID = $_SESSION['id'];

$activeProject = $_SESSION['activeProject'];

if($debug) {
    $debug_string .= "5activeproject =" . $activeProject . "</br>";
}

if(isset($_SESSION['projectID'])) {
$projectID = $_SESSION['projectID'];
}



if(isset($_SESSION['name'])) {
    $currentUserName = $_SESSION['name'];
}

$adminStatus = "";

$adminTypeQuery = "SELECT u.user_name, r.roles_name
FROM user AS u
JOIN adminstatusroles AS r ON u.roles_ID = r.roles_ID
WHERE user_name = '$currentUserName'";

$adminTypeQueryResult = $conn->query($adminTypeQuery);


if ($debug) {
    $debug_string .= 'adminTypeQuery = ' . $adminTypeQuery . '<br/><br/>';
    if (!$adminTypeQueryResult) {
        $queryError = "\n Error description: adminTypeQuery " . mysqli_error($conn) . "\n<br/>";
        outputError($queryError);
    }
}/*end debug*/

if ($adminTypeQueryResult) {
    $numberOfAdminTypeQueryRows = $adminTypeQueryResult->num_rows;

    for ($j = 0; $j < $numberOfAdminTypeQueryRows; ++$j) {
        $row = $adminTypeQueryResult->fetch_array(MYSQLI_NUM);

        $QueryUserName = $row[0];
        $adminStatus = $row[1];

    }

    if($adminStatus == 'MAIN ADMIN' || $adminStatus == 'ADMIN') {
        $adminTab = "
        
        <li class='nav-item dropdown'>
        <a href='#' class='nav-link dropdown-toggle mb-3' data-toggle='dropdown'>ADMIN <span
                class='caret'></span>
        </a>
        <div class='dropdown-menu' style='z-index:999;'>
            <a href='admin.php?adminCreateNewProject=true' class='dropdown-item'>Create New Project</a>
            <a href='admin.php?adminDeleteExistingProject=true' class='dropdown-item'>Delete Existing Project</a>
           <!-- <a href='admin.php?adminChangeProjectUsers=true' class='dropdown-item'>Change Project Users</a>
            <a href='admin.php?adminGetUserInfo=true' class='dropdown-item'>Get User Information</a>-->
            <a href='admin2.php?adminEditUser=true' class='dropdown-item'>Get/Edit User Info</a>
        </div>
    </li>";

    }
}

if($debug) {
    $debug_string .= "QueryUserName = " . $QueryUserName . "</br>";
    $debug_string .= "adminStatus = " . $adminStatus . "</br>";
} 



// if(isset($_REQUEST['chosenDropdownProjectID'])) {
//     $_SESSION['projectID'] = $_REQUEST['chosenDropdownProjectID'];
//     header ('Location: project.php?projectName=$projectName&$projectName=true');
//     exit();

// }

/*For the time when the project has not been set yet*/
if($activeProject == ""){
    
    $styleInsert = "style='display:inline;' ";
    $activeProject = "<h6 style='color:red; display:inline;'> Please Choose a project </h6><br/>";
}

/*Here we need to gather the names of all the projects our user has access to
We are going to loop them into a list of projects (links?) that user can choose from from the nav bar. HTML below.
Select project_name from project Where user_ID = current logged in user
*/

$possibleProjectNames = "SELECT p.project_name
FROM project AS p
WHERE p.ID = $userSessID
";

$possibleProjectNamesResult = $conn->query($possibleProjectNames);


if ($debug) {
    $debug_string .= 'possibleProjectNamesQuery = ' . $possibleProjectNames . '<br/><br/>';
    if (!$possibleProjectNamesResult) {
        $queryError = "\n Error description: possibleProjectNames " . mysqli_error($conn) . "\n<br/>";
        outputError($queryError);
    }
}/*end debug*/

if ($possibleProjectNamesResult) {

    $numberOfPossibleProjectNamesRows = $possibleProjectNamesResult->num_rows;


    for ($j = 0; $j < $numberOfPossibleProjectNamesRows; ++$j) {
        $row = $possibleProjectNamesResult->fetch_array(MYSQLI_NUM);

        $possibleProjectNames = $row[0];


    }

}

 /*This seems like it could replace the query above.*/

$projectQuery = "SELECT p.ID, p.project_name, u.ID
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


    for ($j = 0; $j < $numberOfProjectRows; ++$j) {
    $row = $projectQueryResult->fetch_array(MYSQLI_NUM);

    $projectID = $row[0];
    $projectName = $row[1];
    $userID = $row[2];

    $projectListItem .="<a href='project.php?chosenDropdownProjectID=$projectID&projectName=" . urlencode($projectName) . "&" . urlencode($projectName) . "=true' class='dropdown-item'> $projectName</a>";

    }

}
echo $debug_string;
//echo "projectListItem =" . $projectListItem . "</br></br>";

/*HTML Code for nav bar
No qualifying if. We will always see the nav bar if nav.php is included on the php page.*/

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" >
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar"
                aria-controls="navbar"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">TicketToDo</a>
    <div class="collapse navbar-collapse mb-3 mb-lg-0" id="navbar">

        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link active" href="home.php">Home<span class="sr-only">(current)</span></a>
            </li>
            <?php echo $adminTab ?>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="howto.php">How to</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="createNewTicket.php">Create Ticket</a>
            </li>
            <!-- Drop Down Menu for advanced Search tab-->
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle mb-3" data-toggle="dropdown">Advanced Search<span
                        class="caret"></span>
                </a>
                <div class="dropdown-menu" style="z-index:999;">
                    <a href="advSearch.php?myLinkStatus=true" class="dropdown-item">Status</a>
                    <a href="advSearch.php?myLinkPriority=true" class="dropdown-item">Priority</a>
                    <a href="advSearch.php?myLinkCategory=true" class="dropdown-item">Category</a>
                    <a href="advSearch.php?myLinkIdNum=true" class="dropdown-item">ID Number</a>
                    <!-- <a href="advSearch.php?myLinkProject=true" class="dropdown-item">Project </a> -->
                    <a href="advSearch.php?myLinkDate=true" class="dropdown-item">Date</a>
                    <a href="displayAdvSearch.php?remaining=true" class="dropdown-item">Remaining</a>
                </div>
            </li>
            <!-- Drop Down Menu for project tab-->
            <li class="nav-item dropdown" >
                <a href="#" class="nav-link dropdown-toggle mb-3"
                   data-toggle="dropdown">Project<span
                            class="caret"></span>
                </a>
                <div class="dropdown-menu">
                    <a href="project.php?myLinkProject=true" class="dropdown-item">Start New Project</a>
                    <?php echo $projectListItem; ?>


                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
            </li> &nbsp;
            <li class="nav-item">
                <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
            </li> &nbsp; &nbsp;
        </ul>

        <form action="displaySearch.php" method="post">
            <input type="text" name="searchBox" id="search" placeholder="General Search...">
        </form>
    </div>
</nav>
<div class=" descriptionBar fixed-top container-fluid">
    <div class="row justify-content-end">
        <div class="col-sm-auto">
            <?php echo "Project: " . $activeProject   ?>
         </div>
         <div class="col-sm-auto">
             <?php echo "UserName: " .  $currentUserName  ?>
        </div>
    </div>
</div>






