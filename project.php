<?php

/*Sceneario #1 
User clickes a project from the project dropdown on the nav bar
We arrive here with these name value pairs
  chosenDropdownProjectID = projectID (from query on nav page)
  $projectName = 'true'
  ($projectName is the name of whichever project the user chose)
  The purpose is to choose, or change the project we are wroking in. 
  */

/*Scenario #2
User clicks on "Start new project" from the nav bar*/
/*We arrive with this name Value pair
  myLinkProject = 'true';
  Purpose is to see the Add New Project form so it can be filled out.*/

  /*Scenario #3
newproject form has been filled out and submitted*/
/*We arrive with these name Value pairs
  submit = 'true
  projectName = projectName field value
  description = description field value
  userList[] = user, user, user, user ...
  This scenario is also for the purpose of validating the information coming from the form and then preparing or washing the information before entering data into the database.
  If the information does not validate, is inccorect or has not been filled out, error messages are created and we return to the form where we will see error messages and information that is correct will be prepopulated in the correct text box, area or checkbox so that the user doesn't have to fill out those fields all over again.
  */

  



include 'boilerPlate.php';



if($debug) {
    $debug_string .= "PROJECT.php </br>";
}



include 'nav.php';


/*Variables created in nav
    $useerSessionID = $_SESSION['id']
   
    $possibleProjectNames  (not sure we need this anymore)
    $projectID
    projectName = 'true'
    userID
    userSessionID = $userID*/


//Initialize variables


$chosenProjectName = "";
$projectName = "";
$description = "";
$userName = "";
$addNewProject = "";
$edit = "";
$myLinkProject = "";
$userList = array();

$addNewProjectInsertQueryResult = "";



/*Create Local variables*/
/*Sets the projectId to a session variable */


//Not getting sent anymore?


if(isset($_SESSION['name'])) {  
    $userName = $_SESSION['name'];
}


if(isset($_REQUEST['edit'])) { 
    $edit = $_REQUEST['edit'];
}


/*Info from add new project form*/
if(isset($_REQUEST['newProjectName'])) { 
    $newProjectName = $_REQUEST['newProjectName'];
}

if(isset($_REQUEST['description'])) { 
    $description = $_REQUEST['description'];
}

if(isset($_REQUEST['submit'])) { 
    $submit = $_REQUEST['submit'];
}

if(isset($_REQUEST['myLinkProject'])) { 
    $myLinkProject = $_REQUEST['myLinkProject'];
}

/*is this enough to get the chosen checkbox values into the array? Do I need to loop?*/
if(isset($_REQUEST['userList'])) { 
    $userList = $_REQUEST['userList'];

    var_dump($userList);

}



/*Validate projectID */
/*Validate userName*/


// Scenario #3

/*NEWPROJECT  $submit == 'true*/
/*This section is used when a user is adding a new project*/

if($submit=='true') {
    $validatesProj = 'true';
    
    if($newProjectName == "" ) {
        $projectNameError = "<span class='error'>Please enter a project name</span>";
        $validatesProj = 'false';
    }
    if($description == "") {
        $descriptionError = "<span class='error'>Please enter a description</span>";
        $validatesProj = 'false';
    }
    /*This is not quite right*/
    if(!isset($_REQUEST['userList'])) { /*foreach loop here to validate no because user list is "". */
        $userError = "<span class='error'>Please choose at least one user who will have access to this project</span>";
        $validatesProj = 'false';
    }

                   
       //Does this project name already exist?

    if($validatesProj == 'true'){
        $washPostVar = test_input($newProjectName);
        $newProjectNameAltered = strip_before_insert($conn, $washPostVar);

        $washPostVar = test_input($description);
        $descriptionAltered = strip_before_insert($conn, $washPostVar);

        $existsQuery = "SELECT*
            FROM project
            WHERE project_name = '$newProjectNameAltered' ";

            $existsQueryResult = $conn->query($existsQuery);
            

            if ($debug) {
                $debug_string .= "\n existsQuery= " . $existsQuery . "\n<br/>";
                if (!$existsQueryResult){ 
                    $queryError = "\n Error description existsQuery: " . mysqli_error($conn) . "\n<br/>";
                    outputError($queryError);
                }
               
            }/*end debug*/
            
            /*If ProjectName already exists*/
            /*Added a span element*/
            if($existsQueryResult) {
                $existsQueryNumberOfRows = $existsQueryResult->num_rows;

              if($existsQueryNumberOfRows >= 1 ){
                $alreadyExistsResponse = "<span class='error'>Project $newProjectName already exists. Please choose another name for your project</span>";
                $alreadyExists = 'true';
              //If project name does not yet exist
              }elseif($existsQueryNumberOfRows == 0) {
               
                /*Washed form data above - Check boxes get washed below.*/
                  
                    
                $addNewProjectInsertQuery = "INSERT INTO project (project_name, project_description)
                VALUES('$newProjectNameAltered', '$descriptionAltered')";
                    
                    /*Send the query to the database*/
                    $addNewProjectInsertQueryResult = $conn->query($addNewProjectInsertQuery);
                    
                    if ($debug) {
                    $debug_string .="\n addNewProjectInsertQuery= " . $addNewProjectInsertQuery . "\n<br/>";
                        if (!$addNewProjectInsertQueryResult) {
                        $queryError = "\n Error description: addNewProjectInsertQuery: " . mysqli_error($conn) . "\n<br/>";
                        outputError($queryError);
                        }
                    }/*end debug*/
                
                    /*Get Last ID*/
                    if($addNewProjectInsertQueryResult) {
                        $last_ID = $conn->insert_id;
                        if($debug){
                        $debug_string .= "lastID = $last_ID </br>";
                        }
                    }


                /*Retrieve and insert checkbox values?*/
                /*Wash first?*/ 

                if(!empty($_REQUEST['userList'] )){
                    foreach($_REQUEST['userList'] as $ourUserID){
                        echo "user chosen to have access: " . $ourUserID . "</br>";
                        $washPostVar = test_input($ourUserID);
                        $ourUserIDAltered = strip_before_insert($conn, $washPostVar);


                        $chosenUserInsertQuery = "INSERT INTO user2project (user_ID, project_ID)
                        VALUES('$ourUserIDAltered', '$last_ID')";
                    
                        /*Send the query to the database*/
                        $chosenUserInsertQueryResult = $conn->query($chosenUserInsertQuery);
                    
                        if ($debug) {
                            $debug_string .="\n chosenUserInsertQuery= " . $chosenUserInsertQuery . "\n<br/>";
                            if (!$chosenUserInsertQueryResult){ 
                                $queryError = "\n Error description chosenUserInsertQuery: " . mysqli_error($conn) . "\n<br/>";
                                outputError($queryError);
                            }
                        }/*end debug*/
                        
                    }/*end foreach*/
                
                }/*end if(!empty($_REQUEST['userList'] ))*/





/*to display checkboxes?*/

            if(isset($_POST['submit'])) {//to run PHP script on submit
                if(!empty($_POST['user_list'])) {
                // Loop to store and display values of individual checked checkboxes.
                    foreach($_POST['user_list'] as $selected){
                    echo $selected."</br>";
                    
                    }
                }
            }
            header("Location:home.php");
            exit();

        }/*END elseif($existsQueryNumberOfRows == 0)*/
     }/*END if($existsQueryResult)*/
     
    }elseif($validatesProj == 'false'){
        if(isset($_POST['submit'])) {//to run PHP script on submit
            if(!empty($_POST['user_list'])) {
            // Loop to store and display values of individual checked checkboxes.
                foreach($_POST['user_list'] as $selected){
                $checkboxSelected = 'selected';
                
                }
            }
        }
    }
}/*End if submit is true */












/*scenario #1*/
/*CHOSEN PROJECT*/
/*This section is used when user chooses a project from the nav bar*/

if($chosenDropdownProjectID !== ""){

    $washPostVar = test_input($chosenDropdownProjectID);
    $chosenDropdownProjectIDAltered = strip_before_insert($conn, $washPostVar);


/*Query for all users that have access to this project*/
/*$userSessID comes from nav.php included above*/
$userQuery = "SELECT u.ID, u.user_name, p.project_name
FROM user AS u
LEFT JOIN user2project ON u.ID = user2project.user_ID
LEFT JOIN project AS p ON p.ID = user2project.project_ID
WHERE p.ID = $chosenDropdownProjectIDAltered
ORDER BY u.user_name ASC";

$userQueryResult = $conn->query($userQuery);


if ($debug) {
    $debug_string .= 'userQuery = ' . $userQuery . '<br/><br/>';
    if (!$userQueryResult) {
        $queryError = "\n Error description query userQuery: " . mysqli_error($conn) . "\n<br/>";
        outputError($queryError);
    }
}/*end debug*/

if ($userQueryResult) {

    $numberOfUserRows = $userQueryResult->num_rows;

    /* this begins the process for users  */
    $userListItem = "<ul>";


    for ($j = 0; $j < $numberOfUserRows; ++$j) {
        $row = $userQueryResult->fetch_array(MYSQLI_NUM);

        $userID = $row[0];
        $userAccessName = $row[1];
        $activeProjectName = $row[2]; 


        $userListItem .="<h6 class='pl-4'><li>$userAccessName</li></h6>";

    }
    $userListItem.="</ul>";
    //$_SESSION['activeProject'] = $activeProjectName;
}/*end if ($userQueryResult)*/

if($debug){
$debug_string .= 'Zeus =' . $_SESSION['activeProject'] . '<br/>';
}




/*Query for all Project landing page info */
   $projectQuery = "SELECT p.ID, p.project_name, p.project_description
   FROM project AS p
   WHERE p.ID = $chosenDropdownProjectIDAltered ";

    $projectQueryResult = $conn->query($projectQuery);


    if ($debug) {
    $debug_string .= 'projectQuery = ' . $projectQuery . '<br/><br/>';
    if (!$projectQueryResult) {
        $queryError = "\n Error description query projectQuery: " . mysqli_error($conn) . "\n<br/>";
        outputError($queryError);
    }
    }/*end debug*/

    if ($projectQueryResult) {
    $numberOfProjectRows = $projectQueryResult->num_rows;


        for ($j = 0; $j < $numberOfProjectRows; ++$j) {
        $row = $projectQueryResult->fetch_array(MYSQLI_NUM);

            $queriedProjectID = $row[0];
            $projectName = $row[1];
            $projectDescription = $row[2];

        }

    }/*End if ($projectQueryResult)*/



/*HTML for project landing page info Scenario #1
When  user has clicked on a project name in the dropdown on the nav */


?>
        <div class="container ">
    
            <div class="row">
                <div class="col">
            
                    <div class="card mb-4">
                        <div class="card-header">
                            <h2><strong>Project: </strong><?php echo $projectName ?></h2>
                        </div>
                        <div class="card-body">
                            
                            <h4> Description: </h4>
                                
                                <?php echo $projectDescription; ?></br></br></br>
                            
                            
                                
                            <h4>Users with Access:</h4>
                            
                                
                                <?php echo $userListItem; ?></br></br>
        
                                <form action="#" method="post">
                                    <input type='btn' class='btn siteButton' value='Edit Project'>
                                    <input type='hidden'name='edit' value='true'>
                                    <input type='hidden' name='projectID' value='$projectID'>                          
                                </form>
        
                            
        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
<?php

/* TODO If Edit is true then we find our selves needing to edit the Project info. Add or delete a user or change a spelling. INCOMPLETE*/



}/*End if($chosenDropdownProjectID !== "")*/




/*HTML Project Name, description etc*/
/*If Logged in Whether project has been chosen or not 
Might want to create a new project before choosing one
If creating a new project user will be sent back to this project page to validate and enter into db then to the home page to choose the new project from the dropdown in the nav.*/

/*Scenario #2  Start a new project  -  form Not submitted yet*/

if($myLinkProject =='true') {
/*Query to find all users and create a checkbox list to choose from */

    $userListQuery = "SELECT user_name, ID
    FROM user
    
    ";
    $userListQueryResult = $conn->query($userListQuery);


    if ($debug) {
        $debug_string .= 'userListQuery = ' . $userListQuery . '<br/><br/>';
        if (!$userListQueryResult) {
            $queryError = "\n Error description query userListQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*end debug*/

        if ($userListQueryResult) {


        $numberOfUserListRows = $userListQueryResult->num_rows;

        //Walk this through. Not sure it is correct. 
        // $completeUserListItem = "<div class='container'><form action='action_page.php'>";
        $completeUserListItem = "";
      

            for ($j = 0; $j < $numberOfUserListRows; ++$j) {
            $row = $userListQueryResult->fetch_array(MYSQLI_NUM);

                $userListName = $row[0];
                $userListID = $row[1];

                // $completeUserListItem .= "<div class='form-check'>
                // <input class='form-check-input' type='checkbox' id='$j' name='userList[]' value='$userListID'>
                // <label for='$j '>$userListName</label>
                // </div></br>"; 

                $completeUserListItem .= "<div class='form-check'>
                 <input class='form-check-input' type='checkbox' id='$userListID' name='userList[]' value='$userListID' ";
                 
                if(in_array($userListID, $userList)) {
                    $completeUserListItem .= " checked ";
                }

                $completeUserListItem .= "> $userListName</br> 
                <label class='form-check-label sr-only' for=$userListID >$userListName</label>
                </div><br>"; 
                
               
            }

            
        }
    }/*End $myLinkProject = 'true'




//HTML to show Start New Project form no submit
/*Form shows when myLinkProject =='true, $alreadyExists = true*/
if($myLinkProject =='true'|| $validates == 'false' || $alreadyExists =='true') {
       
?>
    <div class="container ">

        <div class="row">
            <div class="col">
        
                <div class="card mb-4">
                    <div class="card-header"><h2>Add New Project </h2></div>
                    <div class="card-body">
                        
                        <form action='#' method="post">
                            <h4>Project Information:</h4>
                            <div class="form-group">
                               <label for="newProjectName">Project Name <?php echo $alreadyExistsResponse . $projectNameError ?> </label> 
                                <input type="text" class="form-control" name="newProjectName" id="newProjectName" placeholder="Project Name" value="<?php echo htmlspecialchars($newProjectName, ENT_QUOTES) ?>">
                            </div>
                            <div class="form-group">
                                <label for="description">Description <?php echo $descriptionError ?></label>
                                <textarea class="form-control" id="description" name="description" placeholder="Description" ><?php echo htmlspecialchars($description, ENT_QUOTES) ?></textarea>
                            </div>
                            <h4>Select the Users that will have access to this project</h4>
                            <?php echo $userError ?>
                            
                            <?php echo $completeUserListItem; ?>

                            <input type='submit' class='btn siteButton' value='Submit'>
                            <input type='hidden' name='submit' value='true'>

                        </form>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
   
   
<?php
echo $debug_string;
}/*End  if($myLinkProject =='true'|| $validated == 'false' || $exists =='true') */

include 'endingBoilerPlate.php';



 