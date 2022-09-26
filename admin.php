<?php


include 'boilerPlate.php';



if($debug) {
    echo "ADMIN.php </br>";
}

include 'nav.php';

/*HTML for Cards*/



/*Scenario #1 - WORKING
ADMIN user clickes the Admin Tab in the nav bar and chooses Create New Project*/
/*Secnario #2 - IN PROCESS...
ADMIN user clickes the Admin Tab in the nav bar and chooses Delete Existing Project */
/*Scenario #3
ADMIN user clickes the Admin Tab in the nav bar and chooses Change Project Users*/
/*Secnario #4
ADMIN user clickes the Admin Tab in the nav bar and chooses Change User Admin Status */
/*Secnario #5
ADMIN user clickes the Admin Tab in the nav bar and chooses Get User info */



$welcome = "";
$adminCreateNewProject = "";
$newProjectName = "";
$description = "";
$userList = array();
$admNewProjSubmit = "";


$adminDeleteExistingProject = "";
$adminProjectValue = "";
$admDeleteExistingProjSubmit = "";

$adminChangeProjectUsers = "";
$adminUserDropdownValue = "";
$admChangeProjUsersSubmit = "";
$addUserToProj = "";
$deleteUserFromProj = "";

$removeUserSubmit = "";

/*Don't think accessUserName ever gets used for change User Admin Status. */
$accessUsername = "";
$accessProjectName = "";
$adminStatusDropdownValue = "";



$success = "";

$adminGetUserInfo = "";
$admGetUserInfoSubmit = "";
$admStatusUserName = "";

$accessUserName = "";
$accessUserID = ""; 

/*Not needed anymore? changed to active or inactive*/
$adminRemoveUser = "";







/*Create Local variables*/
if(isset($_REQUEST['welcome'])) {
  $welcome = $_REQUEST['welcome'];
}

if(isset($_REQUEST['adminCreateNewProject'])) {
  $adminCreateNewProject = $_REQUEST['adminCreateNewProject'];
}
echo "2 adminCreateNewProject = " . $adminCreateNewProject . "</br> </br>";
if(isset($_REQUEST['newProjectName'])) {
  $newProjectName = $_REQUEST['newProjectName'];
}

if(isset($_REQUEST['description'])) {
  $description = $_REQUEST['description'];
}

if(isset($_REQUEST['userList'])) { 
  $userList = $_REQUEST['userList'];
  var_dump($userList);
}

if(isset($_REQUEST['admNewProjSubmit'])) {
  $admNewProjSubmit = $_REQUEST['admNewProjSubmit'];
}




if(isset($_REQUEST['adminDeleteExistingProject'])) {
  $adminDeleteExistingProject = $_REQUEST['adminDeleteExistingProject'];
}

if(isset($_REQUEST['adminProjectValue'])) {
  $adminProjectValue = $_REQUEST['adminProjectValue'];
  var_dump($adminProjectValue);
}

if(isset($_REQUEST['admDeleteExistingProjSubmit'])) { 
  $admDeleteExistingProjSubmit = $_REQUEST['admDeleteExistingProjSubmit'];
}




if(isset($_REQUEST['adminChangeProjectUsers'])) {
  $adminChangeProjectUsers = $_REQUEST['adminChangeProjectUsers'];
}

if(isset($_REQUEST['adminUserDropdownValue'])) {
  $adminUserDropdownValue = $_REQUEST['adminUserDropdownValue'];
}

if(isset($_REQUEST['admChangeProjUsersSubmit'])) {
  $admChangeProjUsersSubmit = $_REQUEST['admChangeProjUsersSubmit'];
}

if(isset($_REQUEST['addUserToProj'])) {
  $addUserToProj = $_REQUEST['addUserToProj'];
}

if(isset($_REQUEST['deleteUserFromProj'])) {
  $deleteUserFromProj = $_REQUEST['deleteUserFromProj'];
}


if(isset($_REQUEST['accessUserName'])) {
  $accessUserName = $_REQUEST['accessUserName'];
}
if(isset($_REQUEST['accessProjectName'])) {
  $accessProjectName = $_REQUEST['accessProjectName'];
}
/*may not need...*/
if(isset($_REQUEST['removeUserSubmit'])) {
  $removeUserSubmit = $_REQUEST['removeUserSubmit'];
}

if(isset($_REQUEST['adminStatusDropdownValue'])) {
  $adminStatusDropdownValue = $_REQUEST['adminStatusDropdownValue'];
}



if(isset($_REQUEST['adminGetUserInfo'])) {
  $adminGetUserInfo = $_REQUEST['adminGetUserInfo'];
}
if(isset($_REQUEST['admGetUserInfoSubmit'])) {
  $admGetUserInfoSubmit = $_REQUEST['admGetUserInfoSubmit'];
}

if(isset($_REQUEST['admStatusUserName'])) {
  $admStatusUserName = $_REQUEST['admStatusUserName'];
}

if(isset($_REQUEST['accessUserID'])) {
  $accessUserID = $_REQUEST['accessUserID'];
}



if(isset($_REQUEST['adminRemoveUser'])) {
  $adminRemoveUser = $_REQUEST['adminRemoveUser'];
}



if($debug) {
  echo "1admDeleteExistingProjSubmit = " . $admDeleteExistingProjSubmit . "</br>";
  echo "1adminProjectValue = " . $adminProjectValue . "</br></br>";
  echo "5adminStatusDropdownValue = " . $adminStatusDropdownValue . "</br>";
  echo "5admPickUserSubmit = " . $admPickUserSubmit . "</br>";
  }

if($welcome == 'true') {
  ?>
<div class="container">
  <div class="card">
    <div class="card-header">Welcome to the Admin Page</div>
    <div class="card-body">
      <p>Choose an Item from the Nav bar above to Continue. </p>
    </div>
  </div>
</div>

<?php
}

/*USER LIST  and USER TYPE QUERY*/

/*Query to find all users and create a checkbox list to choose from
We will add more posible times this could be used as we build the page */
/*Needed for Create New Project  Change User Admin Status, Change Project Users*/

if($adminCreateNewProject =='true' || $adminChangeProjectUsers == 'true'|| $admChangeProjUsersSubmit =='true' || $changeStatusSubmit == 'true' || $adminGetUserInfo == 'true' || $admGetUserInfoSubmit == 'true' || $admNewProjSubmit == 'true'){

    $userListQuery = "SELECT u.user_name, u.ID, r.roles_name
    FROM user AS u
    JOIN adminstatusroles AS r ON u.roles_ID = r.roles_ID
    ";

    $userListQueryResult = $conn->query($userListQuery);


    if ($debug) {
        $debug_string .= 'userListQuery = ' . $userListQuery . '<br/><br/>';
        if (!$userListQueryResult){
            $queryError = "\n Error description query userListQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*end debug*/

    if ($userListQueryResult) {


      $numberOfUserListRows = $userListQueryResult->num_rows;

      //Walk this through. Not sure it is correct. 
      // $completeUserListItem = "<div class='container'><form action='action_page.php'>";
      $completeUserListItem = "";
      $completeUserListDropdown = "";


      for ($j = 0; $j < $numberOfUserListRows; ++$j) {
      $row = $userListQueryResult->fetch_array(MYSQLI_NUM);

          $userListName = $row[0];
          $userListID = $row[1];
          $userRoleName = $row[2];

         

          $completeUserListItem .= "<div class='form-check'>
            <input class='form-check-input' type='checkbox' id='$userListID' name='userList[]' value='$userListID' ";

          /*if any value in the complete user list item is the same as the item the user chose from the drop down in the form $userSelected == 'selected'. This helps us prepopulate the form when there are errors to correct. */

            $userSelected = "";
            if($userListID == $adminUserDropdownValue ) {
              $userSelected = 'selected';
            }

          $completeUserListDropdown .= "<option value= $userListID $userSelected >$userListName</option>" ;
            
          /*used to prepopulate the checkbox values if we are sent back to the form to coreect an error.*/
           if(in_array($userListID, $userList)) {
             $completeUserListItem .= " checked ";
             $completeUserListDropdown .= " selected ";
           }

            $completeUserListItem .= "> $userListName</br> 
          <label class='form-check-label sr-only' for=$userListID ></label>
            </div><br>"; 
          
        
      }
    
                
    }/*End if ($userListQueryResult)*/
}/*End if($adminCreateNewProject=='true')*/

if($debug){
  $debug_string .= "2 userListName = " . $userListName . "</br>" ;
  $debug_string .= "2 userListID = " . $userListID . "</br>" ;
  $debug_string .= "2 userRoleName = " . $userRoleName . "</br>" ;
  $debug_string .= "2 userSelected = " . $userSelected . "</br></br></br>" ;
}


/*PROJECT LIST QUERY*/
/*Need code for Delete Existing Project, Change Project Users*/

/*Find all the projects*/
if($adminDeleteExistingProject == 'true' || $admDeleteExistingProjSubmit == 'true' || $adminChangeProjectUsers =='true' || $admChangeProjUsersSubmit=='true'){

  $adminProjectList = "";
  $adminProjectListQuery = "SELECT ID, project_name
  FROM project
  ORDER BY project_name ASC";
  
  $adminProjectListQueryResult = $conn->query($adminProjectListQuery);
  
  if ($debug) {
      $debug_string.= 'adminProjectListQuery = ' . $adminProjectListQuery . '<br/><br/>';
      if (!$adminProjectListQueryResult){
        $queryError = "\n Error description: adminProjectListQuery: " . mysqli_error($conn) . "\n<br/>";
        outputError($queryError);
      }
  }/*end debug*/
  
  if ($adminProjectListQueryResult) {
  
    $numberOfAdminProjectListQueryRows = $adminProjectListQueryResult->num_rows;
  
      //Walk this through. Not sure it is correct. 
      // $completeUserListItem = "<div class='container'><form action='action_page.php'>";
    $completeAdminProjectListItems = "";
         
      
  
    for ($j = 0; $j < $numberOfAdminProjectListQueryRows; ++$j) {
      $row = $adminProjectListQueryResult->fetch_array(MYSQLI_NUM);
  
      $adminProjectID = $row[0];
      $adminProjectName = $row[1];
  
      // $completeUserListItem .= "<div class='form-check'>
      // <input class='form-check-input' type='checkbox' id='$j' name='userList[]' value='$userListID'>
      // <label for='$j '>$userListName</label>
      // </div></br>"; 
  

      $projectSelected = "";
            if($adminProjectID == $adminProjectValue) {
              $projectSelected = 'selected';
            }
      $completeAdminProjectListItems .= "<option value= $adminProjectID $projectSelected  >$adminProjectName</option>" ;
      /*$completeAdminProjectListItems .= "<option><?php echo '$adminProjectName' ?></option> ";*/

      
        
      // if(in_array($userListID, $userList)) {
      //     $completeUserListItem .= " checked ";
      // }
  
    }
  
  }
}/*End if($adminDeleteExistingProject == 'true' || $admDeleteExistingProjSubmit == 'true')*/

if($debug){
  $debug_string .= "1adminProjectID = " . $adminProjectID . "</br>" ;
  $debug_string .= "1adminProjectName = " . $adminProjectName . "</br>" ;
  $debug_string .= "1projectSelected = " . $projectSelected . "</br></br>" ;
  $debug_string .= "helloadminstatusrolesName = " . $adminStatusRolesName . "</br>";
}




/*ADMIN CREATE NEW PROJECT*/
echo "TicknewProjectName = " . $newProjectName . "</br>";

/*scenario 1-A 
  Admin has filled out the createNewProject form and submitted.*/
  /*Code used for Create New Project thread*/

if($admNewProjSubmit == 'true'){

    /*Validate form VALUES*/
    $validatesProj = 'false';
    
    if($newProjectName !== "" && $description !== "" && isset($_REQUEST['userList'])) {
        $validatesProj = 'true';
    }
    if($debug){
    echo "CheckUserList = " . $userList . "</br>";
    }
    /*This is not quite right*/
    /*foreach loop here to validate no because user list is "". */
        
    
    /*check to see if this project name already exists in the db*/
    if($debug){
    $debug_string .= "2 validatesProj = " . $validatesProj . "</br>";
    }
    
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
                  $queryError = "\n Error description: existsQuery: " . mysqli_error($conn) . "\n<br/>";
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
                if($debug){
                  $debug_string .= "2 alreadyExistsResponse = " . $alreadyExistsResponse . "</br>";
                  $debug_string .= "2 alreadyExists = " . $alreadyExists . "</br>";
                }
            //If project name does not yet exist
            }elseif($existsQueryNumberOfRows == 0) {
             
              /*Washed form data above - Check boxes get washed below.*/
                
                  
              $addNewProjectInsertQuery = "INSERT INTO project (project_name, project_description)
              VALUES('$newProjectNameAltered', '$descriptionAltered')";
                  
                  /*Send the query to the database*/
                  $addNewProjectInsertQueryResult = $conn->query($addNewProjectInsertQuery);
                  
                  if ($debug) {
                  $debug_string .= "\n addNewProjectInsertQuery= " . $addNewProjectInsertQuery . "\n<br/>";
                      if (!$addNewProjectInsertQueryResult) {
                      $queryError = "\n Error description addNewProjectInsertQuery: " . mysqli_error($conn) . "\n<br/>";
                      outputError($queryError);
                      }
                  }/*end debug*/
              
                  /*Get Last ID*/
                  if($addNewProjectInsertQueryResult) {
                      $last_ID = $conn->insert_id;
                      if($debug){
                      $debug_string .= "lastID =" . $last_ID . "</br>";
                      }
                  }


              /*Retrieve, wash and insert checkbox values?*/
              

                  if(!empty($_REQUEST['userList'] )){
                      foreach($_REQUEST['userList'] as $ourUserID){
                          if($debug){
                          $debug_string .= "user chosen to have access: " . $ourUserID . "</br>";
                          }
                          $washPostVar = test_input($ourUserID);
                          $ourUserIDAltered = strip_before_insert($conn, $washPostVar);
                          $washPostVar = test_input($last_ID);
                          $lastIDAltered = strip_before_insert($conn, $washPostVar);
    
                            if($debug){
                          $debug_string .= "2 ourUserIDAltered " . $ourUserIDAltered . "</br>";
                          $debug_string .= "2 lastIDAltered " . $lastIDAltered . "</br></br>";
                            }
    
                          $chosenUserInsertQuery = "INSERT INTO user2project (user_ID, project_ID)
                          VALUES('$ourUserIDAltered', '$lastIDAltered')";
                      
                          /*Send the query to the database*/
                          $chosenUserInsertQueryResult = $conn->query($chosenUserInsertQuery);
                      
                          if ($debug) {
                              $debug_string .= "\n chosenUserInsertQuery= " . $chosenUserInsertQuery . "\n<br/>";
                              if (!$chosenUserInsertQueryResult){
                                  $queryError = "\n Error description: chosenUserInsertQuery: " . mysqli_error($conn) . "\n<br/>";
                                  outputError($queryError);
                              }
                          }/*end debug*/
                          
                      }/*end foreach*/
                  
                  }/*end if(!empty($_REQUEST['userList'] ))*/


              /*Used in the Create New Project Thread*/
              if(isset($_POST['admNewProjSubmit'])) {//to run PHP script on submit
                if(!empty($_POST['user_list'])) {
                // Loop to store and display values of individual checked checkboxes.
                    foreach($_POST['user_list'] as $selected){
                    echo $selected."</br>";
                    }/*END foreacj*/
                }/*END if(!empty($_POST['user_list']))*/
              }/*END if(isset($_POST['admNewProjSubmit']))*/
             
              $success =  "You have created a new project called '" . $newProjectName . "'." ;
          }/*END elseif($existsQueryNumberOfRows == 0)*/
      }/*END if($existsQueryResult)*/


    }elseif($validatesProj == 'false'){
        echo "FalsevalidatesProj = " . $validatesProj . "</br>";
          /*error messages */
        if($newProjectName == "" ) {
          $projectNameError = "<span class='error'>Please enter a project name</span>";
        }
        if($description == "") {
          $descriptionError = "<span class='error'>Please enter a description</span>";
        }
        
        /*This is not quite right*/
        if(!isset($_REQUEST['userList'])) { /*foreach loop here to validate no because user list is "". */
          $userError = "<span class='error'>Please choose at least one user who will have access to this project</span>";
        }
        
        if($debug){
            $debug_string .= "</br>newProjectName = " . $newProjectName . "</br>";
            $debug_string .= "projectNameError = " . $projectNameError . "</br>";
            $debug_string .= "description = " . $description . "</br>";
            $debug_string .= "descriptionError = " . $descriptionError . "</br>";
            $debug_string .= "userList = " . $userList . "</br>";
            $debug_string .= "userError = " . $userError . "</br></br>";
        }
          
    
        if(isset($_POST['admNewProjSubmit'])) {//to run PHP script on submit
            if(!empty($_POST['user_list'])) {
            // Loop to store and display values of individual checked checkboxes.
                foreach($_POST['user_list'] as $selected){
                $checkboxSelected = 'selected';
        
                } /*End foreach*/
            } /*End if(!empty($_POST['user_list']))*/
        }/*END if(isset($_POST['admNewProjSubmit']))*/
    }/*END elseif($validatesProj == 'false')*/

}/*End if($admNewProjSubmit == 'true')*/



 




/*ADMIN DELETE PROJECT code*/
/*Need Code for Delete Existing Project*/
if($debug){
$debug_string .= "1admDeleteExistingProjSubmit = " . $admDeleteExistingProjSubmit . "</br></br>";
}

if($admDeleteExistingProjSubmit == 'true'){
  /*send a warning ARE YOU SURE?*/
  /*Validate that $adminProjectValue is not empty string and it is numeric*/
  /*Check to see if project even exists in the db*/
  /*Run Delete query */
  /*Create confirmation text "%^*&^%$#@#$%^&^& has been deleted" */

  /*scenario 2-B 
  Admin has filled out the DELETE form and submitted.*/


  /*Validate form VALUES*/
  $validatesProj = 'false';
  

  if($adminProjectValue !== "" && is_numeric($adminProjectValue) ) {
      $validatesProj = 'true';
  }
  
  if($debug){
   $debug_string .= "</br>1validatesProj = " . $validatesProj . "</br>";
   $debug_string .= "1adminProjectValue = " . $adminProjectValue . "</br></br>";
  }   

  /*check to see if this project name already exists in the db*/
  if($validatesProj == 'true'){
    $washPostVar = test_input($adminProjectValue);
    $adminProjectValueAltered = strip_before_insert($conn, $washPostVar);

    

    $existsQuery = "SELECT*
        FROM project
        WHERE ID = $adminProjectValueAltered ";

        $existsQueryResult = $conn->query($existsQuery);
        

        if ($debug) {
            $debug_string .= "\n existsQuery= " . $existsQuery . "\n<br/>";
            if (!$existsQueryResult){ 
                $queryError = "\n Error description: existsQuery: " . mysqli_error($conn) . "\n<br/>";
                outputError($queryError);
            }
        }/*end debug*/
        
        /*If ProjectName already exists*/
        /*Added a span element*/
        if($existsQueryResult) {
            $existsQueryNumberOfRows = $existsQueryResult->num_rows;

          if($existsQueryNumberOfRows == 0 ){
            $doesNotExistError = "<span class='error'>This project does not Exist</span>";
             /*At this point we want to drop to form again with error messages. */
              $doesNotExist = 'true';
          }elseif($existsQueryNumberOfRows >= 1) {
            /*washed above*/
            

            $getProjectName = "SELECT project_name FROM project WHERE ID = $adminProjectValueAltered ";
              $getProjectNameResult = $conn->query($getProjectName);
              if ($debug) {
              $debug_string .= "\n getProjectName= " . $getProjectName . "\n<br/>";
                if (!$getProjectNameResult){ 
                    $queryError = "\n Error description getProjectName: " . mysqli_error($conn) . "\n<br/>";
                    outputError($queryError);
                }
              }/*end debug*/
              if ($getProjectNameResult) {
        
                $numberOfGetProjectNameRows = $getProjectNameResult->num_rows;

                for ($j = 0; $j < $numberOfGetProjectNameRows; ++$j) {
                  $row = $getProjectNameResult->fetch_array(MYSQLI_NUM);
              
                  $getProjectNameName = $row[0];
                  
            
                }/*end for loop*/
            
              }/*END if ($getProjectNameResult)*/
          }/*END elseif($existsQueryNumberOfRows >= 1)*/


        /*DELETE PROJECT PROCESS START*/          
              /*create query to delete project*/
              $deleteCommentQuery = "DELETE com
              FROM comment AS com
                WHERE com.id IN 
                (
                SELECT x.id FROM
                (
                  SELECT c.id
                  FROM project AS p
                  INNER JOIN ticket AS t
                  ON p.id = t.project_ID
                  INNER JOIN comment AS c
                  ON t.id = c.comment_ticket_ID
                  WHERE p.id = $adminProjectValueAltered
                    ) AS x
              )";

              $deleteCommentQueryResult = $conn->query($deleteCommentQuery);


              if ($debug) {
                  $debug_string .= 'deleteCommentQuery = ' . $deleteCommentQuery . '<br/><br/>';
                  if (!$deleteCommentQueryResult){
                      $queryError = "\n Error description query deleteCommentQuery: " . mysqli_error($conn) . "\n<br/>";
                      outputError($queryError);
                      outputError($deleteCommentQuery);
              }/*end debug*/


              $deleteTicketQuery = "DELETE tic
              FROM ticket AS tic 
              WHERE tic.id IN ( 
                SELECT x.id FROM ( 
                  SELECT t.id 
                  FROM project AS p 
                  INNER JOIN ticket AS t ON p.id = t.project_ID 
                  WHERE p.id = $adminProjectValueAltered 
                ) AS x 
                )";


                $deleteTicketQueryResult = $conn->query($deleteTicketQuery);


              if ($debug) {
                  $debug_string .= 'deleteTicketQuery = ' . $deleteTicketQuery . '<br/><br/>';
                  if (!$deleteTicketQueryResult){
                      $queryError = "\n Error description: deleteTicketQuery: " . mysqli_error($conn) . "\n<br/>";
                      outputError($queryError);
                  }
              }/*end debug*/

              

              $deleteUser2projectQuery = "DELETE 
              FROM user2project
              WHERE project_ID = $adminProjectValueAltered  ";

              $deleteUser2projectQueryResult = $conn->query($deleteUser2projectQuery);


              if ($debug) {
                  $debug_string .= 'deleteUser2projectQuery = ' . $deleteUser2projectQuery . '<br/><br/>';
                  if (!$deleteUser2projectQueryResult){
                      $queryError = "\n Error description: deleteUser2projectQuery: " . mysqli_error($conn) . "\n<br/>";
                      outputError($queryError);
                  }
              }/*end debug*/




              $deleteProjectQuery = "DELETE p
              FROM project AS p 
              WHERE p.id = $adminProjectValueAltered ";


              $deleteProjectQueryResult = $conn->query($deleteProjectQuery);


              if ($debug) {
                  $debug_string .= 'deleteProjectQuery = ' . $deleteProjectQuery . '<br/><br/>';
                  if (!$deleteProjectQueryResult){
                      $queryError = "\n Error description query deleteProjectQuery: " . mysqli_error($conn) . "\n<br/>";
                      outputError($queryError);
                      outputError($deleteProjectQuery);
                  }
              }/*end debug*/


      /*DELETE PROJECT PROCESS END*/

              if ($deleteProjectQueryResult) {
             
                  $success =  "The project '" .$getProjectNameName . "' has been successfully deleted.";
    
                  if($_SESSION['activeProject'] == $getProjectNameName){
                    $_SESSION['activeProject'] = "";
                  }

              }/*End deleteProjectQueryResult*/

         
        }/*END if($existsQueryResult)*/

        

            
  }elseif($validatesProj == 'false'){
    echo 'Project does not validate </br>';
    if($adminProjectValue == "" || !is_numeric($adminProjectValue) ) {
      $projectValueError = "<span class='error'>Please choose a project.</span>";
    }/*End if($adminProjectValue == "" || !is_numeric($adminProjectValue) ) */
  }/*END elseif($validatesProj == 'false')*/

}/*End if($admDeleteExistingProjSubmit == 'true')*/


/*Separated the wash and query because sometimes we don't have the info for both.*/
/*When coming from Nav we do not have access to any of these variables.*/

if($adminUserDropdownValue !=="" && is_numeric($adminUserDropdownValue)){
  /*Wash Variable*/
  $washPostVar = test_input($adminUserDropdownValue);
  $adminUserDropdownValueAltered = strip_before_insert($conn, $washPostVar);
  if ($debug){
    $debug_string .= "adminUserDropdownValueAltered = " . $adminUserDropdownValueAltered . "</br></br>" ;
  }

}



/*When coming from nav we dont need this*/
/*UserName chosen by user and ProjectName chosen by user*/
/*code needed for Change User Admin Status*/
if($admChangeProjUsersSubmit == 'true') {

    $userInfoQuery = "SELECT u.ID, u.user_name
    FROM user AS u 
    WHERE u.ID = $adminUserDropdownValueAltered
     ";
    
    $userInfoQueryResult = $conn->query($userInfoQuery);
      
    if ($debug) {
        $debug_string .= "userInfoQuery = " . $userInfoQuery . "<br/><br/>";
        if (!$userInfoQueryResult){
            $queryError = "\n Error description query userInfoQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*end debug*/
      
    if ($userInfoQueryResult) {
        $numberOfUserInfoQueryRows = $userInfoQueryResult->num_rows;
    
        for ($j = 0; $j < $numberOfUserInfoQueryRows; ++$j) {
          $row = $userInfoQueryResult->fetch_array(MYSQLI_NUM);
      
          $accessUserID = $row[0];
          $accessUserName = $row[1];
        }
    }
}/*END if($admChangeProjUsersSubmit == 'true')*/

if ($debug){
  $debug_string .= "accessUserName = " . $accessUserName . "<br/>";
  $debug_string .= "1adminProjectValue = " . $adminProjectValue . "</br>";
}



if( $adminProjectValue !== "" && is_numeric($adminProjectValue)){
  /*Wash Variables*/
  
  $washPostVar = test_input($adminProjectValue);
  $adminProjectValueAltered = strip_before_insert($conn, $washPostVar);
  }
if($debug){
  $debug_string .= "adminProjectValueAltered = " . $adminProjectValueAltered . "</br>";
}


  /*When coming from nav we dont need this*/
  /*UserName chosen by user and ProjectName chosen by user*/

if($admChangeProjUsersSubmit == 'true' ) {

    $projectInfoQuery = "SELECT  p.project_name
    FROM  project AS p 
    WHERE p.ID = $adminProjectValueAltered ";
  
    $projectInfoQueryResult = $conn->query($projectInfoQuery);
    
    if ($debug) {
        $debug_string .= "projectInfoQuery = " . $projectInfoQuery . "<br/><br/>";
        if (!$projectInfoQueryResult) {
            $queryError = "\n Error description query projectInfoQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*end debug*/
    
    if ($projectInfoQueryResult ) {
    
      $numberOfProjectInfoQueryRows = $projectInfoQueryResult->num_rows;
  
      for ($j = 0; $j < $numberOfProjectInfoQueryRows; ++$j) {
        $row = $projectInfoQueryResult->fetch_array(MYSQLI_NUM);
        $accessProjectName = htmlspecialchars($row[0], ENT_QUOTES);
      }
    }
}

if ($debug) {
  $debug_string .= "accessProjectName = " . $accessProjectName . "</br>";
}
/*TODO Is this incomplete code? there are two sections, one above and one below, that start with the same if, but do different things.   Seems to be working. Keep for now and step through */

}/*END if($admChangeProjUsersSubmit == 'true' )*/


/*CHANGE USER ACCESS*/

if($admChangeProjUsersSubmit == 'true'){
  $userFormValidates = 'false';

  if(($adminUserDropdownValue !== "" && is_numeric($adminUserDropdownValue)) && ($adminProjectValue !== "" && is_numeric($adminProjectValue))){
    $userFormValidates = 'true';
  }
  

  if ($debug) {
    $debug_string .= "userFormValidates = " . $userFormValidates . "</br>";
  }

  if($userFormValidates == 'true'){

    /*Does the connection between user and project already exist?*/

    $userAccessExistsQuery = "SELECT * 
    FROM user2project 
    WHERE user_ID = $adminUserDropdownValueAltered
    AND project_ID = $adminProjectValueAltered";

    $userAccessExistsQueryResult = $conn->query($userAccessExistsQuery);


    if ($debug) {
      $debug_string .= "userAccessExistsQuery= " . $userAccessExistsQuery . "<br/><br/>";
      if (!$userAccessExistsQueryResult) {
          $queryError = "\n Error description query userAccessExistsQuery: " . mysqli_error($conn) . "\n<br/>";
          outputError($queryError);
      }
    }/*end debug*/

    if ($userAccessExistsQueryResult) {

      $numberOfUserAccessRows = $userAccessExistsQueryResult->num_rows;

      if($numberOfUserAccessRows == 0){

      /*if this is true, then there user does not have access to this project
      options are to leave the user without access or to give them access */

      $userProjAccess='false';

      }elseif($numberOfUserAccessRows >= 1){

        /*if this is true, then the user currently has access to this project  options are to leave the user with current access or to take the access away.  */

        $userProjAccess='true';
      }

    }/*END if ($userAccessExistsQueryResult)*/

  }elseif($userFormValidates == 'false'){
    
    if($adminUserDropdownValue == "" || !is_numeric($adminUserDropdownValue)){
      $adminUserValueError = "Please Choose a User Name.";
    }
    if($adminProjectValue=="" || !is_numeric($adminProjectValue)){
      $adminProjectValueError = "Please Choose a Project Name.";
    }
  }
}/*END if($admChangeProjUsersSubmit == 'true')*/

/*Add User to a project */
if($addUserToProj == 'true') {
  
  $addUserToProject = "INSERT INTO user2project (user_ID, project_ID)
  VALUES($adminUserDropdownValueAltered, $adminProjectValueAltered)";

   /*Send the query to the database*/
   $addUserToProjectResult = $conn->query($addUserToProject);
                  
   if ($debug) {
      $debug_string .= "\n addUserToProject= " . $addUserToProject . "\n<br/>";
       if (!$addUserToProjectResult) {
       $queryError = "\n Error description addUserToProject: " . mysqli_error($conn) . "\n<br/>";
       outputError($queryError);
       }
   }/*end debug*/

   if($addUserToProjectResult) {
     $success = "You have successfully added User \" " . $accessUserName . " \"to Project \" " . $accessProjectName . " \".";
   }

}elseif($deleteUserFromProj == 'true'){
  $deleteUserFromProject = "DELETE FROM user2project
  WHERE user_ID = $adminUserDropdownValueAltered 
  AND project_ID = $adminProjectValueAltered
  ";

  /*Send the query to the database*/
  $deleteUserFromProjectResult = $conn->query($deleteUserFromProject);
                  
  if ($debug) {
     $debug_string .= "\n deleteUserFromProject= " . $deleteUserFromProject . "\n<br/>";
      if (!$deleteUserFromProjectResult) {
      $queryError = "\n Error description: deleteUserFromProject: " . mysqli_error($conn) . "\n<br/>";
      outputError($queryError);
      }
  }/*end debug*/

  if($deleteUserFromProjectResult) {
    $success = "You have successfully removed User \" " . $accessUserName . " \"from Project \" " . $accessProjectName . " \".";
  }
}/*ENd elseif($deleteUserFromProj == 'true')*/




/*Get User INFO Code*/
if($debug) {
  $debug_string .= "3admGetUserInfoSubmit=" . $admGetUserInfoSubmit . "</br>";
  $debug_string .= "3adminUserDropdownValue=" . $adminUserDropdownValue . "</br>";
}

/*Needed for...*/
if($admGetUserInfoSubmit == 'true') {
  $getUserInfoValidates = 'true';
  /*validate form <info></info>*/
  if($adminUserDropdownValue == "" || !is_numeric($adminUserDropdownValue)) {
    $getUserInfoValidatesError = "Please Select a User";
    $getUserInfoValidates = 'false';
  }

  if($debug) {
  $debug_string .= "3getUserInfoValidates=" . $getUserInfoValidates . "</br>";
  }

  if($getUserInfoValidates == 'true') {
    /*wash form value*/  
    $washPostVar = test_input($adminUserDropdownValue);
    $adminUserDropdownValueAltered = strip_before_insert($conn, $washPostVar);

    /*Select user values to post in card*/ 

    $getUserInfoQuery = " SELECT u.ID, u.first_name, u.last_name, u.user_name, u.user_email, u.active, r.roles_name 
    FROM user AS u
    LEFT JOIN adminstatusroles AS r ON u.roles_ID = r.roles_ID
    LEFT JOIN user2project ON u.ID = user2project.user_ID
    LEFT JOIN project AS p ON  user2project.project_ID = p.ID
    WHERE u.ID = $adminUserDropdownValueAltered";

    $getUserInfoQueryResult = $conn->query($getUserInfoQuery);

    if ($debug) {
      $debug_string .= "getUserInfoQuery= " . $getUserInfoQuery . "<br/><br/>";
      if (!$getUserInfoQueryResult) {
          $queryError = "\n Error description: getUserInfoQuery: " . mysqli_error($conn) . "\n<br/>";
          outputError($queryError);
      }
    }/*end debug*/

    if ($getUserInfoQueryResult) {

      $numberOfUserInfoQueryRows = $getUserInfoQueryResult->num_rows;
      for ($j = 0; $j < $numberOfUserInfoQueryRows; ++$j) {
        $row = $getUserInfoQueryResult->fetch_array(MYSQLI_NUM);

        $getUserID = $row[0];
        $getUserFirstName = $row[1];
        $getUserLastName = $row[2];
        $getUserUserName = $row[3];
        $getUserEmail = $row[4];
        $getUserActiveStatus = $row[5];
        $getUserAdminStatus = $row[6];
      } /*End for loop*/
    } /*End if ($getUserInfoQueryResult)*/

    $getUserProjectNameList = "";

    $getUserProjectInfo ="SELECT p.project_name
    FROM project AS p
     LEFT JOIN user2project ON user2project.project_ID = p.ID
     LEFT JOIN user AS u ON u.ID = user2project.user_ID
    WHERE u.ID = $adminUserDropdownValueAltered
    ";

    $getUserProjectInfoResult = $conn->query($getUserProjectInfo);

    if ($debug) {
      $debug_string .= "getUserProjectInfo= " . $getUserProjectInfo . "<br/><br/>";
      if (!$getUserProjectInfoResult) {
          $queryError = "\n Error description: getUserProjectInfo: " . mysqli_error($conn) . "\n<br/>";
          outputError($queryError);
      }
    }/*end debug*/

    if ($getUserProjectInfoResult) {
      
      $numberOfProjectInfoRows = $getUserProjectInfoResult->num_rows;
      for ($j = 0; $j < $numberOfProjectInfoRows; ++$j) {
        $row = $getUserProjectInfoResult->fetch_array(MYSQLI_NUM);
        $getUserProjectName = $row[0];
        $getUserProjectNameList .= "<h6>" . $getUserProjectName . "</h6> </br>";
      } /*End for loop*/

    } /*End if ($getUserProjectInfoResult)*/
  } /*End if($getUserInfoValidates == 'true')*/
} /*End if($admGetUserInfoSubmit == 'true')*/

if($debug) {  
  $debug_string .= "2getUserProjectName =" . $getUserProjectName . "</br>";
  $debug_string .= "2getUserProjectNameList =" . $getUserProjectNameList . "</br>";
}


/*HTML Components CREATE NEW PROJECT*/
/*Needed for Create New Project*/
if($debug) { 
$debug_string .= "</br>success =" . $success . "</br>";
$debug_string .= "adminCreateNewProject =" . $adminCreateNewProject . "</br>";
$debug_string .= "admNewProjSubmit =" . $admNewProjSubmit . "</br>";
$debug_string .= "validatesProj =" . $validatesProj . "</br>";
$debug_string .= "alreadyExists =" . $alreadyExists . "</br></br>";
}


if($success == ""  && ($adminCreateNewProject == 'true' ||  (($admNewProjSubmit == 'true') && ($validatesProj == 'false' || $alreadyExists == 'true')))){ 
  if($debug){
      $debug_string .= "2 Made it into Create New Project Form";
  }
  ?>
<div class="container ">

 <div class="row">
   <div class="col">
   
     <div class="card mb-4">
       <div class="card-header"><h2>Add New Project </h2></div>
       <div class="card-body">
                   
         <form action='admin.php' method="post">
           <h4>Project Information:</h4>
           <div class="form-group">
             <label for="newProjectName"> <?php echo $alreadyExistsResponse . $projectNameError ?> </label> 
             <input type="text" class="form-control" name="newProjectName" id="newProjectName" placeholder="Project Name" value="<?php echo htmlspecialchars($newProjectName, ENT_QUOTES) ?>">
           </div>
           <div class="form-group">
             <label for="description"> <?php echo $descriptionError ?></label>
             <textarea class="form-control" id="description" name="description" placeholder="Description" ><?php echo htmlspecialchars($description, ENT_QUOTES) ?></textarea>
           </div>
           <h4>Select the Users that will have access to this project</h4>
           <?php echo $userError ?>
           
           <?php echo $completeUserListItem; ?></br></br>

           <input type='submit' class='btn siteButton' value='Submit'>
           <input type='hidden' name='admNewProjSubmit' value='true'>

         </form>
                   

       </div><!--End card-body-->
     </div><!--End Card-->
   </div><!--End Col-->
 </div><!--End Row-->
</div><!--End Container-->


<?php
}/*End if($success == ""  && ($adminCreateNewProject == 'true' ||  (($admNewProjSubmit == 'true') && ($validatesProj == 'false' || $alreadyExists == 'true'))))*/




if($debug){
    $debug_string .= "xxxsuccess =" . $success . "</br>";
    $debug_string .= "1adminDeleteExistingProject =" . $adminDeleteExistingProject . "</br>";
    $debug_string .= "1admDeleteExistingProjSubmit =" . $admDeleteExistingProjSubmit . "</br>";
    $debug_string .= "1validatesProj =" . $validatesProj . "</br>";
}

/*HTML components DELETE PROJECT*/
/*Code needed for Delete Existing Project*/
 if($success == "" && ($adminDeleteExistingProject == 'true' || ($admDeleteExistingProjSubmit == 'true' && $validatesProj == 'false'))){
  ?>

<div class="container ">
 <div class="row">
   <div class="col">
     <div class="card mb-4">
       <div class="card-header"><h2>Delete Existing Project </h2></div>
       <div class="card-body">
         <h4 class="error ">WARNING: Sumbitting this form WILL DELETE the project you choose AND ALL TICKETS related to the chosen project.</h4> <h4 class="error mb-4">It WILL NOT BE RECOVERABLE. Please proceed with caution. </h4>
                   
         <form action='admin.php' method="post">
         
           <div class="form-group">
              <label for="adminProjectList"> <?php echo $projectValueError .  $doesNotExistError ?></label>
              
              <select class="form-control" id="adminProjectList" name="adminProjectValue">
                <option value=""  disabled selected hidden>Choose a project</option>
                <?php echo "$completeAdminProjectListItems";?>
              
              </select>
           </div>

           <input type='submit' class='btn siteButton' value='Delete this Project from Database'>
           <input type='hidden' name='admDeleteExistingProjSubmit' value='true'>

         </form>
                   

       </div><!--End card-body-->
     </div><!--End Card-->
   </div><!--End Col-->
 </div><!--End Row-->
</div><!--End Container-->


<?php

 }/*END if($success == "" && ($adminDeleteExistingProject == 'true' || ($admDeleteExistingProjSubmit == 'true' && $validatesProj == 'false')))*/



/*HTML componants CHANGE PROJECT USERS*/
/*Code needed for Change Project Users*/

if($success == ""  &&  ($adminChangeProjectUsers == 'true' || ($admChangeProjUsersSubmit == 'true' && $userFormValidates=='false' )) )  {
  ?>

<div class="container ">
  <div class="card">
    <div class="card-header"><h2>Change Project Users </h2></div>
    <div class="card-body">
    <h4>Select the UserName and the Project Name </h4></br>
    <form action='admin.php' method="post">
      <div class="container">
        <div class="row">
        
            <div class="col-sm-6">
              <div class="card">
                <div class="card-body">
                  
                  <h5 class="card-title">User Name <span class="error" ><?php echo "$adminUserValueError"; ?> </span></h5>
                  
                  <select class="form-control" id="adminUserDropdown" name="adminUserDropdownValue">
                    <option value=""  disabled selected hidden>Choose a User</option>
                    <?php echo "$completeUserListDropdown";?>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Project Name <span class="error" ><?php echo "$adminProjectValueError"; ?></h5>
                  <select class="form-control" id="adminProjectList" name="adminProjectValue">
                    <option value=""  disabled selected hidden>Choose a project</option>
                    <?php echo "$completeAdminProjectListItems";?>
                  </select>
                </div>
              </div>
            </div>
            <input class="btn siteButton m-4" type="submit" value="Continue">
            <input type="hidden" name='admChangeProjUsersSubmit'value= 'true'>
            <input type="hidden" name='accessUserName'value= '<?php echo $accessUserName ?> '>
            <input type="hidden" name='accessProjectName'value= '<?php echo $accessProjectName ?> '>
            
          
        </div> <!--End Row-->
      </div> <!--End Container2-->
      </form>
    </div><!--End Card-body-->
  </div> <!--End card-->
</div><!--End Container1-->
<?php

}/*End if($success == ""  &&  ($adminChangeProjectUsers == 'true' || ($admChangeProjUsersSubmit == 'true' && $userFormValidates=='false' )) )*/



/*The part that tells us if the chosen user has access to the chosen project */
if($userProjAccess == 'false'){
  ?>

  <div class="container">
    <div class="card">
      <div class="card-body">
        <h4 class="pt-4 pb-4"><?php echo "User \" " . $accessUserName . " \" currently Does not have access to Project \" " . $accessProjectName . "\"." ; ?></h4>

        <form action='admin.php' method="post">
          <div class="form-group">
            <input type="submit" class="btn siteButton" value="Maintain NO ACCESS">
            <input type="hidden" name="welcome" value='true'>
          </div>
        </form>

        <form action='admin.php' method="post">
          <div class="form-group">
            <input type="submit" class="btn siteButton" value= "<?php echo "Add ". $accessUserName . " to " . $accessProjectName; ?> ">
            <input type="hidden" name="addUserToProj" value='true'>
            <input type="hidden" name="adminUserDropdownValue" value="<?php echo $adminUserDropdownValue ?>">
            <input type="hidden" name="adminProjectValue" value='<?php echo $adminProjectValue ?>'>
            <input type="hidden" name="accessUserName" value='<?php echo $accessUserName ?>'>
            <input type="hidden" name="accessProjectName" value='<?php echo $accessProjectName ?>'>
            
          </div>
        </form>

      </div>
    </div>
  </div>

 <?php
}elseif($userProjAccess == 'true' ){
  ?>
  <div class="container">
    <div class="card">
      <div class="card-body ">
        <h4 class="pt-4 pb-4"><?php echo "User \"" . $accessUserName . "\" currently has access to Project \"" . $accessProjectName . "\"." ; ?></h4>

        <form action='admin.php' method="post">
          <div class="form-group">
            <input type="submit" class="btn siteButton" value="Maintain Access">
            <input type="hidden" name="welcome" value='true'>
          </div>
        </form>

        <form action='admin.php' method="post">
          <div class="form-group">
            <input type="submit" class="btn siteButton" value= "<?php echo"Remove ". $accessUserName . " From " . $accessProjectName ; ?> ">
            <input type="hidden" name="deleteUserFromProj" value='true'>
            <input type="hidden" name="adminUserDropdownValue" value="<?php echo $adminUserDropdownValue ?>">
            <input type="hidden" name="adminProjectValue" value='<?php echo $adminProjectValue ?>'>
            <input type="hidden" name="accessUserName" value='<?php echo $accessUserName ?>'>
            <input type="hidden" name="accessProjectName" value='<?php echo $accessProjectName ?>'>
          </div>
        </form>

      </div>
    </div>
  </div>
 <?php
 }/*END elseif($userProjAccess == 'true' )*/

 if($debug) {
    $debug_string .= "hereaccessUsername = " . $accessUserName . "</br>" ;
    $debug_string .= "accessUserIDAltered = " . $accessUserIDAltered . "</br>" ;
    $debug_string .= "accessUserID = " . $accessUserID . "</br>" ;
    $debug_string .= "getUserInfoValidatesError = " . $getUserInfoValidatesError  . "</br>";
}

/*HTML Components GET USER INFO*/


if(($adminGetUserInfo == 'true' || $getUserInfoValidates == 'false') && $adminUserDropDownValue !== "") {
?>
<div class="container ">
  <div class="card">
    <div class="card-header"><h2>Get User Information </h2></div>
    <div class="card-body">
    <h4 class="pt-4 pb-4">Select a User</h4>
    <form action='admin.php' method="post">
      <div class="container">
        <div class="row">
        
            <div class="col">
              <div class="card">
                <div class="card-body">
                  
                  <h5 class="card-title">User Name <span class="error" ><?php echo "$getUserInfoValidatesError"; ?> </span></h5>
                  
                  <select class="form-control" id="adminUserDropdown" name="adminUserDropdownValue">
                    <option value=""  disabled selected hidden>Choose a User</option>
                    <?php echo "$completeUserListDropdown";?>
                  </select>
                

            
                  <input class="btn siteButton mt-4" type="submit" value="Continue">
                  <input type="hidden" name='admGetUserInfoSubmit'value= 'true'>
                  
                </div>
              </div>
            </div>   
          
        </div> <!--End Row-->
      </div> <!--End Container2-->
      </form>
    </div><!--End Card-body-->
  </div> <!--End card-->
</div><!--End Container1-->
<?php

}/*End if(($adminGetUserInfo == 'true' || $getUserInfoValidates == 'false') && $adminUserDropDownValue !== "")*/




/*HTML Components DISPLAY USER INFO as a table*/

if( $getUserInfoValidates == 'true') {
  if($getUserActiveStatus == 0) {
    $getUserActiveStatus = "Not Active";
  }elseif($getUserActiveStatus > 0){
    $getUserActiveStatus = "Active";
  }
  ?>
  
  <div> 

  <div class="container ">

  <div class="row">
    <div class="col">
    
      <div class="card mb-4" style="border-color: darkseagreen;">
      <div class="card-header"><h2></h2></div>
        <div class="card-body">
          <div class="row">
            <div class="col">
            <h4>User Info for "<?php echo $getUserUserName ?>". </h4></br>
          <div class="table-responsive">
        <table class="table " >
    
    <tbody>
      <tr>
        <td >User ID:</td>
        <td> <?php echo $getUserID ?></td>
      
      </tr>
      <tr>
        <td >User First Name:</td>
        <td><?php echo $getUserFirstName ?></td>
      
      </tr>
      <tr>
        <td >User Last Name:</td>
        <td><?php echo $getUserLastName ?></td>
        
      </tr>
      <tr>
        <td >User User Name:</td>
        <td><?php echo $getUserUserName ?></td>
        
      </tr>
      <tr>
        <td >User Email:</td>
        <td><?php echo $getUserEmail ?></td>
      
      </tr>
      <tr>
        <td >User Active Status:</td>
        <td><?php echo $getUserActiveStatus ?></td>
      
      </tr>
      <tr>
        <td >User Admin Status:</td>
        <td><?php echo $getUserAdminStatus ?></td>
        
      </tr>
    </tbody>
  </table>
  </div>
  <h6>Choose option in Nav bar above to continue</h6>
  </div> <!--End Col-->
  <div class="col">
        

  <h4>List of projects "<?php echo $getUserUserName ?>" has access to: </h4></br>
        <div class="card mb-4" style="border-color: darkseagreen;">
        
        <div class="card-body">
        <?php
        echo $getUserProjectNameList ;
        ?>
        </div>
  </div>
        
  </div> <!--End Col-->            

        </div><!--End card-body-->
      </div><!--End Card-->
    </div><!--End Col-->
  </div><!--End Row-->
  </div><!--End Container-->

  </div>
  <?php
}/*END if( $getUserInfoValidates == 'true')*/



/*HTML Components SUCCESS!*/
/*Needed for Create New Project thread*/

if($success !==""   && ($admDeleteExistingProjSubmit =='true' || $admChangeProjUsersSubmit == 'true' || $addUserToProj == 'true' || $deleteUserFromProj == 'true' || $admNewProjSubmit == 'true')){ 
  ?>
  
  <div> 

  <div class="container ">

  <div class="row">
    <div class="col">
    
      <div class="card mb-4" style="border-color: darkseagreen;">
      
        <div class="card-body">
        <h3>SUCCESS!</h3>
                    
          <h5><?php echo $success ?> </h5>
          <h6>Choose an option from the nav bar above to continue.</h6>
                    

        </div><!--End card-body-->
      </div><!--End Card-->
    </div><!--End Col-->
  </div><!--End Row-->
  </div><!--End Container-->

  </div>
  <?php
}/*End if($success !==""   && ($admDeleteExistingProjSubmit =='true' || $admChangeProjUsersSubmit == 'true' || $addUserToProj == 'true' || $deleteUserFromProj == 'true' || $admNewProjSubmit == 'true'))*/



include 'endingBoilerPlate.php';
