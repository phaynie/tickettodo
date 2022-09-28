<?php
/*Because boiler plate always comes before include nav, Nav bar only shows if user is logged in*/

/*We need to determine who the user is and what project has been chosen*/
$userSessID = $_SESSION['id'];


if($userSessID) {
    $myLinkPriority = $_REQUEST['myLinkPriority'];
}

if(isset($_SESSION['projectID'])) {
    $currentProjectID = $_SESSION['projectID'];
}

if(isset($_SESSION['activeProject'])) {
    $activeProject = $_SESSION['activeProject'];
}

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

    echo 'possibleProjectNamesQuery = ' . $possibleProjectNames . '<br/><br/>';
    if (!$possibleProjectNamesResult) echo("\n Error description query possibleProjectNames " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

if ($possibleProjectNamesResult) {



    $numberOfPossibleProjectNamesRows = $possibleProjectNamesResult->num_rows;




    for ($j = 0; $j < $numberOfPossibleProjectNamesRows; ++$j) {
        $row = $possibleProjectNamesResult->fetch_array(MYSQLI_NUM);

        $possibleProjectNames = $row[0];


    }

}


$projectQuery = "SELECT p.ID, p.project_name, u.ID
FROM project AS p
LEFT JOIN user2project ON p.ID = user2project.project_ID
LEFT JOIN user AS u ON u.ID = user2project.user_ID
WHERE u.ID = $userSessID
ORDER BY project_name ASC";

$projectQueryResult = $conn->query($projectQuery);


if ($debug) {

echo 'projectQuery = ' . $projectQuery . '<br/><br/>';
if (!$projectQueryResult) echo("\n Error description query projectQuery: " . mysqli_error($conn) . "\n<br/>");
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
    $userID = $row[3];

    $projectListItem .="<a href='project.php?projectID=$projectID&$projectName=true' class='dropdown-item'> $projectName</a>";

    }

}
?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
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
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="createNewTicket.php">Create Ticket</a>
            </li>

            <!-- Drop Down Menu for project tab-->
            <li class="nav-item dropdown">
                <a href="project.php?projectID" class="nav-link dropdown-toggle mb-3" data-toggle="dropdown" id="k3">Project<span class="caret"></span>
                </a>
                <div class="dropdown-menu">
                    <a href="project.php?myLinkProject=true" class="dropdown-item">
                    Start New Project
                    </a>
                    <?php echo $projectListItem; ?>
                </div>
            </li>

            <!-- Drop Down Menu for advanced Search tab-->
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle mb-3" data-toggle="dropdown" id="k2">
                    Advanced Search<span class="caret"></span>
                </a>
                <div class="dropdown-menu">
                    <a href="advSearch.php?myLinkStatus=true" class="dropdown-item">Status</a>
                    <a href="advSearch.php?myLinkPriority=true" class="dropdown-item">Priority</a>
                    <a href="advSearch.php?myLinkCategory=true" class="dropdown-item">Category</a>
                    <a href="advSearch.php?myLinkIdNum=true" class="dropdown-item">ID Number</a>
                    <a href="advSearch.php?myLinkDate=true" class="dropdown-item">Date</a>
                    <a href="displayAdvSearch.php?remaining=true" class="dropdown-item">Remaining</a>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
            </li> &nbsp;
            <li class="nav-item">
                <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
            </li> &nbsp; &nbsp;
        </ul>

        <form action="displaySearch.php" method="post"">
            <input type="text" name="searchBox" id="search" placeholder="General Search...">
        </form>
    </div>


</nav>


<div class="dropdown show">
  <a class="dropdown-toggle" href="#" data-toggle="dropdown" id="k1">
    Dropdown link
  </a>

  <div class="dropdown-menu" >
    <a class="dropdown-item" href="#">Action</a>
    <a class="dropdown-item" href="#">Another action</a>
    <a class="dropdown-item" href="#">Something else here</a>
  </div>
</div>

<?php 




echo "<h6>User Name:   " . $_SESSION['name']  . "</h6> <h6 " .  $styleInsert . ">Project Name: " . $activeProject .  "</h6>";

