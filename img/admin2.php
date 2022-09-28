<?php


include 'boilerPlate.php';



if($debug) {
    $debug_string .=  "ADMIN2.php </br>";
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


/*initialize variables*/
$adminEditUser = "";
$admPickUserSubmit = "";
$adminUserDropdownValue = "";

$updateUserInfo = "";
$getUserFirstName = "";
$getUserLastName = "";
$getUserUserName = "";
$getUserEmail = "";
$activeStatus = "0";
$adminStatus = "";
$projectList = array();
$adminGetUserID = "";




/*create Local variables*/
if(isset($_REQUEST['adminEditUser'])) {
  $adminEditUser = $_REQUEST['adminEditUser'];
}

if(isset($_REQUEST['admPickUserSubmit'])){
  $admPickUserSubmit = $_REQUEST['admPickUserSubmit'];
}

if(isset($_REQUEST['adminUserDropdownValue'])){
  $adminUserDropdownValue = $_REQUEST['adminUserDropdownValue'];
}





if(isset($_REQUEST['updateUserInfo'])){
  $updateUserInfo = $_REQUEST['updateUserInfo'];
}

if(isset($_REQUEST['getUserFirstName'])){
  $getUserFirstName = $_REQUEST['getUserFirstName'];
}


if(isset($_REQUEST['getUserLastName'])){
  $getUserLastName = $_REQUEST['getUserLastName'];
}


if(isset($_REQUEST['getUserUserName'])){
  $getUserUserName = $_REQUEST['getUserUserName'];
}


if(isset($_REQUEST['getUserEmail'])){
  $getUserEmail = $_REQUEST['getUserEmail'];
}


if(isset($_REQUEST['activeStatus'])){
  $activeStatus = $_REQUEST['activeStatus'];
}


if(isset($_REQUEST['adminStatus'])){
  $adminStatus = $_REQUEST['adminStatus'];
}


if(isset($_REQUEST['projectList'])){
  $projectList = $_REQUEST['projectList'];
  var_dump($projectList);
}

if(isset($_REQUEST['adminGetUserID'])){
  $adminGetUserID = $_REQUEST['adminGetUserID'];
}


/*USER LIST  and USER TYPE QUERY*/

/*Query to find all users and create a checkbox list to choose from
We will add more posible times this could be used as we build the page */

if($adminEditUser == 'true' ){                                                                    
  $userListQuery = "SELECT u.user_name, u.ID, r.roles_name
  FROM user AS u
  JOIN adminstatusroles AS r ON u.roles_ID = r.roles_ID
  ";

  $userListQueryResult = $conn->query($userListQuery);


  if ($debug) {
      $debug_string .= 'userListQuery = ' . $userListQuery . '<br/><br/>';
      if (!$userListQueryResult) {
          $queryError = "\n Error description: userListQuery: " . mysqli_error($conn) . "\n<br/>";
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

        // $completeUserListItem .= "<div class='form-check'>
        // <input class='form-check-input' type='checkbox' id='$j' name='userList[]' value='$userListID'>
        // <label for='$j '>$userListName</label>
        // </div></br>"; 

        $completeUserListItem .= "<div class='form-check'>
          <input class='form-check-input' type='checkbox' id='$userListID' name='userList[]' value='$userListID' ";

        /*if any value in the complete user list item is the same as the item the user chose from the drop down in the form $userSelected == 'selected'. This helps us prepopulate the form when there are errors to correct. */

          $userSelected = "";
          if($userListID == $adminUserDropdownValue ) {
            $userSelected = 'selected';
          }

        $completeUserListDropdown .= "<option value= $userListID $userSelected >$userListName</option>" ;
          
        /*used to prepopulate the checkbox values if we are sent back to the form to coreect an error.*/
        //  if(in_array($userListID, $userList)) {
        //    $completeUserListItem .= " checked ";$completeUserListDropdown .= " selected ";
        //  }

          $completeUserListItem .= "> $userListName</br> 
        <label class='form-check-label ' for=$userListID ></label>
          </div><br>"; 
        
      
    }
    if($debug){
      $debug_string .=  "userListName = " . $userListName . "</br>" ;
      $debug_string .=  "userListID = " . $userListID . "</br>" ;
      $debug_string .=  "userRoleName = " . $userRoleName . "</br>" ;
      $debug_string .=  "completeUserListItem = " . $completeUserListItem . "</br>" ;
      $debug_string .=  "userSelected = " . $userSelected . "</br></br></br>" ;
      }
              
  }/*End if ($userListQueryResult)*/
}/*End if($adminCreateNewProject=='true')*/








/*PROJECT LIST QUERY
   List of all projects*/

/*Find all the projects*/
if($admPickUserSubmit == 'true' ){

   /*wash form value*/  
  
if($adminUserDropdownValue !== "" && is_numeric($adminUserDropdownValue))
  $washPostVar = test_input($adminUserDropdownValue);
  $adminUserDropdownValueAltered = strip_before_insert($conn, $washPostVar);
  

if($debug){
$debug_string .=  "adminUserDropdownValueAltered =" . $adminUserDropdownValueAltered . "<br>";
}


  $adminProjectListQuery = "SELECT distinct p.ID, p.project_name, u2p.user_ID
  FROM project AS p
  LEFT JOIN user2project AS u2p ON p.ID = u2p.project_ID
  AND u2p.user_ID = $adminUserDropdownValueAltered
  ORDER BY project_name ASC";

  $adminProjectListQueryResult = $conn->query($adminProjectListQuery);

  if ($debug) {
      $debug_string .=  'adminProjectListQuery = ' . $adminProjectListQuery . '<br/><br/>';
      if (!$adminProjectListQueryResult) {
          $queryError = "\n Error description: adminProjectListQuery: " . mysqli_error($conn) . "\n<br/>";
          outputError($queryError);
      }
  }/*end debug*/

  if ($adminProjectListQueryResult) {

    $numberOfAdminProjectListQueryRows = $adminProjectListQueryResult->num_rows;

      //Walk this through. Not sure it is correct. 
      // $completeUserListItem = "<div class='container'><form action='action_page.php'>";
    $completeAdminProjectListItems = "";
    $completeProjectCheckboxList = "";
    $completeProjectCheckboxListChecked = "";
    $projectListSimple = "<ul>";
        
      

    for ($j = 0; $j < $numberOfAdminProjectListQueryRows; ++$j) {
      $row = $adminProjectListQueryResult->fetch_array(MYSQLI_NUM);

      $adminProjectID = $row[0];
      $adminProjectName = $row[1];
      $checked = $row[2];

      if($row[2] !== NULL){
        $projectChecked = 'checked';
      }elseif($row[2] == NULL){
        $projectChecked = "";
      }

      // $completeUserListItem .= "<div class='form-check'>
      // <input class='form-check-input' type='checkbox' id='$j' name='userList[]' value='$userListID'>
      // <label for='$j '>$userListName</label>
      // </div></br>"; 


      $projectSelected = "";
            if($adminProjectID == $adminProjectValue) {
              $projectSelected = 'selected';
            }
      $projectListSimple .= "<li> $adminProjectName </li>";

      $completeAdminProjectListItems .= "<option value= $adminProjectID $projectSelected  >$adminProjectName</option>" ;

      $completeProjectCheckboxList .= "<div class='form-check'>
      <input class='form-check-input' type='checkbox' id='$adminProjectID' name='projectList[]' value='$adminProjectID'> $adminProjectName</br> 
      <label class='form-check-label ' for=$adminProjectID ></label>
        </div><br>";


        

      $completeProjectCheckboxListChecked .= "<div class='form-check'>
      <input class='form-check-input' type='checkbox' id='$adminProjectID' name='projectList[]' value='$adminProjectID' $projectChecked >  
      <label class='form-check-label ' for='$adminProjectID' >$adminProjectName</label>
        </div><br>";

      
        
      // if(in_array($userListID, $userList)) {
      //     $completeUserListItem .= " checked ";
      // }

    }
    $projectListSimple.= "</ul>";
    echo "completeProjectCheckboxList = " . $completeProjectCheckboxList . "<br>";
    echo "completeProjectCheckboxListChecked = " . $completeProjectCheckboxListChecked . "<br>";
  } /*End if ($adminProjectListQueryResult) */


  

 
  /*Select user values to post in card*/ 

  $getUserInfoQuery = " SELECT u.ID, u.first_name, u.last_name, u.user_name, u.user_email, u.active, r.roles_name 
  FROM user AS u
  LEFT JOIN adminstatusroles AS r ON u.roles_ID = r.roles_ID
  LEFT JOIN user2project ON u.ID = user2project.user_ID
  LEFT JOIN project AS p ON  user2project.project_ID = p.ID
  WHERE u.ID = $adminUserDropdownValueAltered";

  $getUserInfoQueryResult = $conn->query($getUserInfoQuery);

  if ($debug) {
    $debug_string .=  "getUserInfoQuery= " . $getUserInfoQuery . "<br/><br/>";
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

if($debug){
    $debug_string .=  "getUserActiveStatus = " . $getUserActiveStatus . "<br>";
    $debug_string .=  "getUserID = " . $getUserID . "<br>";
}

  } /*End if ($getUserInfoQueryResult)*/




/* GET USER PROJECT NAME LIST 
    projects user has access to*/

  $getUserProjectNameList = "";

  $getUserProjectInfo ="SELECT p.project_name
  FROM project AS p
   LEFT JOIN user2project ON user2project.project_ID = p.ID
   LEFT JOIN user AS u ON u.ID = user2project.user_ID
  WHERE u.ID = $adminUserDropdownValueAltered
  ";

  $getUserProjectInfoResult = $conn->query($getUserProjectInfo);

  if ($debug) {
    $debug_string .=  "getUserProjectInfo= " . $getUserProjectInfo . "<br/><br/>";
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

    
    
  } /*End if ($getUserInfoQueryResult)*/


} /*End if($getUserInfoValidates == 'true')*/



/* UPDATE USER INFO */



if($updateUserInfo == 'true') {
  /*validate all form info */ 
  /*Default is False incase code has glitch*/
  $updateUserFormValidates = 'false';
  
  
  if(($getUserFirstName !== "" && !is_numeric($getUserFirstName)) &&($getUserLastName !== "" && !is_numeric($getUserLastName)) &&($getUserUserName !== "" ) && ($getUserEmail !== "" ) && ($activeStatus == "0" || $activeStatus == '1') && ($adminStatus !== "" )) {
    $updateUserFormValidates = 'true';
  }

 
  /* skipped active status validation. How would I validate? */
  /* skipped admin status validation. How would I validate? */
  /* skipped projectList validation. How would I validate? Its ok if there is no current project for a user.  */
  if($debug){
  $debug_string .=  "updateUserFormValidates = " . $updateUserFormValidates . "<br>";
  $debug_string .=  "activeStatus = " . $activeStatus . "<br>";
  $debug_string .=  "activeStatusAltered = " . $activeStatusAltered . "<br>";
  $debug_string .=  "checkUpdateUserFormValidates =" . $updateUserFormValidates . "</br>";
}

  if($updateUserFormValidates == 'true'){ 

      $washPostVar = test_input($getUserFirstName);
      $getUserFirstNameAltered = strip_before_insert($conn, $washPostVar);

      $washPostVar = test_input($getUserLastName);
      $getUserLastNameAltered = strip_before_insert($conn, $washPostVar);

      $washPostVar = test_input($getUserUserName);
      $getUserUserNameAltered = strip_before_insert($conn, $washPostVar);

      $washPostVar = test_input($getUserEmail);
      $getUserEmailAltered = strip_before_insert($conn, $washPostVar);

      $washPostVar = test_input($activeStatus);
      $activeStatusAltered = strip_before_insert($conn, $washPostVar);

      $washPostVar = test_input($adminStatus);
      $adminStatusAltered = strip_before_insert($conn, $washPostVar);
      
      $washPostVar = test_input($adminGetUserID);
      $adminGetUserIDAltered = strip_before_insert($conn, $washPostVar);

      /*for second query*/

      $projListSimp = "<ul>";
      $projectListAltered = array();

      foreach($projectList as $value){
        $washPostVar = test_input($value);
        $valueAltered = strip_before_insert($conn, $washPostVar);


        $projQuery = "SELECT  project_name
        FROM project
        WHERE ID = $valueAltered";

        $projQueryResult = $conn->query($projQuery);

        if ($debug) {
          $debug_string .=  "projQuery= " . $projQuery . "<br/><br/>";
          if (!$projQueryResult) {
              $queryError = "\n Error description: projQuery: " . mysqli_error($conn) . "\n<br/>";
              outputError($queryError);
          }
        }/*end debug*/

        if ($projQueryResult) {
          
          $numberOfProjQueryRows = $projQueryResult->num_rows;
          for ($j = 0; $j < $numberOfProjQueryRows; ++$j) {
            $row = $projQueryResult->fetch_array(MYSQLI_NUM);

            $projName = $row[0];
            
            $projListSimp .="<li>$projName</li>";
            
  
          } /*End for loop*/


        } /*end if ($projQueryResult)*/
      } /*end of for each*/
        $projListSimp .="</ul>";  

if($debug){
      $debug_string .=  "getUserActiveStatus = " . $getUserActiveStatus . "<br>";
      $debug_string .=  "getUserActiveStatusAltered = " . $getUserActiveStatusAltered . "<br>"; 
}



      
    /*UPDATE*/
      $updateQuery = "UPDATE user
      SET first_name = '$getUserFirstNameAltered', 
      last_name = '$getUserLastNameAltered',
      user_name = '$getUserUserNameAltered',
      user_email = '$getUserEmailAltered',
      active = $activeStatusAltered,
      roles_ID = $adminStatusAltered
      
      WHERE ID = $adminGetUserIDAltered";

      $updateQueryResult = $conn->query($updateQuery);


      if ($debug) {
        $debug_string .=  'updateQuery = ' . $updateQuery . '<br/><br/>';
        if (!$updateQueryResult) {
            $queryError = "\n Error description: updateQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError );
        }
      }/*end debug*/

      $deleteCurrentUserProjects = "DELETE FROM user2project 
      WHERE user_ID = $adminGetUserIDAltered ";

      $deleteCurrentUserProjectsResult = $conn->query($deleteCurrentUserProjects);

      if ($debug) {
        $debug_string .=  'deleteCurrentUserProjects = ' . $deleteCurrentUserProjects . '<br/><br/>';
        if (!$deleteCurrentUserProjectsResult) {
            $queryError = "\n Error description: deleteCurrentUserProjects: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
      }/*end debug*/


      foreach ($projectList as $value){
      $insertNewValues = " INSERT INTO user2project (user_ID, project_ID)
      VALUES ($adminGetUserIDAltered, $value)";
      $insertNewValuesResult = $conn->query($insertNewValues);
      }

      

      if ($debug) {
        $debug_string .=  'insertNewValues = ' . $insertNewValues . '<br/><br/>';
        if (!$insertNewValuesResult) {
            $queryError = "\n Error description: insertNewValues: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
      }/*end debug*/

    if($insertNewValuesResult){
      $updatedUser = 'true';
    }
  } /*end if($updateUserFormValidates == 'true') */


  if($updateUserFormValidates == 'false'){
    /*Just in case UserUserName is an empty string. We need to have a name of the user in some of the titles.  */
    $washPostVar = test_input($adminGetUserID);
    $adminGetUserIDAltered = strip_before_insert($conn, $washPostVar);
    
    $noUserNameQuery = "SELECT user_name
    FROM user
    WHERE ID = $adminGetUserIDAltered";
    $noUserNameQueryResult = $conn->query($noUserNameQuery);

    if ($debug) {
      $debug_string .=  "noUserNameQuery= " . $noUserNameQuery . "<br/><br/>";
      if (!$noUserNameQueryResult){
       $queryError = "\n Error description: noUserNameQuery: " . mysqli_error($conn) . "\n<br/>";
      outputError($queryError);
      }
    }/*end debug*/

    if ($noUserNameQueryResult) {
      
      $numberOfNoUserNameQueryRows = $noUserNameQueryResult->num_rows;
      for ($j = 0; $j < $numberOfNoUserNameQueryRows; ++$j) {
        $row = $noUserNameQueryResult->fetch_array(MYSQLI_NUM);

        $noUserNameName = $row[0];


      } 
    }/*end if ($noUserNameQueryResult)*/

  echo "Yo getUserNameName = " . $getUserUsername .  "</br>";


     /*error messages for when valiation is false*/
     if($getUserFirstName =="" || is_numeric($getUserFirstName)){
      $getUserFirstNameError = "<span class='error'>Please enter a valid First Name value: no numbers permitted.</span>";
     }
     if($getUserLastName == "" ||  is_numeric($getUserLastName)){
     $getUserLastNameError = "<span class='error'>Please enter a valid Last Name value: no numbers permitted.</span>";
     } 
     if($getUserUserName == ""){
        $getUserUserNameError = "<span class='error'>Please enter a Username.</span>";
     }
     if($getUserEmail == ""){
       $getUserEmailError = "<span class='error'>Please enter a valid email address.</span>";
     }
     if($activeStatus == ""){
       $activeStatusError = "<span class='error'>Please enter a valid active status value. </span>";
     }
     if($adminStatus > 1){
       $adminStatusError = "<span class='error'>You must choose one value. </span>";
     }

    /* GET USER PROJECT NAME LIST 
    projects user has access to*/
    
    /*already washed $adminGetUserID*/
  

    $adminProjectListQuery = "SELECT distinct p.ID, p.project_name, u2p.user_ID
    FROM project AS p
    LEFT JOIN user2project AS u2p ON p.ID = u2p.project_ID
    AND u2p.user_ID = $adminGetUserIDAltered
    ORDER BY project_name ASC";

    $adminProjectListQueryResult = $conn->query($adminProjectListQuery);

    if ($debug) {
        $debug_string .=  'adminProjectListQuery = ' . $adminProjectListQuery . '<br/><br/>';
        if (!$adminProjectListQueryResult) {
            $queryError = "\n Error description: adminProjectListQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*end debug*/

    if ($adminProjectListQueryResult) {

      $numberOfAdminProjectListQueryRows = $adminProjectListQueryResult->num_rows;

      $completeProjectCheckboxListChecked = "";
    
      for ($j = 0; $j < $numberOfAdminProjectListQueryRows; ++$j) {
        $row = $adminProjectListQueryResult->fetch_array(MYSQLI_NUM);

        $adminProjectID = $row[0];
        $adminProjectName = $row[1];
        $checked = $row[2];

        if($row[2] !== NULL){
          $projectChecked = 'checked';
        }elseif($row[2] == NULL){
          $projectChecked = "";
        }


        $completeProjectCheckboxListChecked .= "<div class='form-check'>
        <input class='form-check-input' type='checkbox' id='$adminProjectID' name='projectList[]' value='$adminProjectID' $projectChecked >  
        <label class='form-check-label ' for='$adminProjectID' >$adminProjectName</label>
          </div><br>";


      } /*end for loop*/
    } /*end if ($adminProjectListQueryResult)*/
  }/*end updateUserFormValidates == 'false*/
    
} /* end if($updateUserInfo == 'true') */
  




/*HTML for Selecting user for editing info*/

if($adminEditUser) {
  ?>
<div class="container ">
  <div class="card">
    <div class="card-header"><h2>Admin Edit User </h2></div>
    <div class="card-body mb-4">
   
    <form action='admin2.php' method="post">
                  <h5 class="card-title">Username <span class="error" ><?php echo "$adminUserValueError"; ?> </span></h5>
                  
                  <select class="form-control" id="adminUserDropdown" name="adminUserDropdownValue">
                    <option value=""  disabled selected hidden>Choose a User by username</option>
                    <?php echo "$completeUserListDropdown";?>
                  </select>
                

            
                  <input class="btn siteButton mt-4" type="submit" value="Continue">
                  <input type="hidden" name='admPickUserSubmit' value= 'true'>
                  
                  
                
      </form>
    </div><!--End Card-body-->
  </div> <!--End card-->
</div></br></br></br><!--End Container1-->
<?php

}/*End if($adminChangeProjectUsers == 'true'*/






/*HTML for Edit User */

    /*PREPARE CHECKED VALUES */
if($admPickUserSubmit == 'true' || $updateUserFormValidates == 'false' ) {

if($debug){
  $debug_string .=  "getUserActiveStatus = " . $getUserActiveStatus . "<br>";
  $debug_string .=  "getUserAdminStatus = " . $getUserAdminStatus . "<br>";
  $debug_string .=  "completeProjectCheckboxList = " . $completeProjectCheckboxList . "<br>";
}


  $activeChecked = "";

  if($getUserActiveStatus == '1' || $activeStatus == "1") {
    $activeChecked = 'checked';
  }
  
  

  if($getUserAdminStatus == 'USER' || $adminStatus == '1') {
    $adminStatus1Checked = 'checked';
  }elseif($getUserAdminStatus == 'ADMIN' || $adminStatus == '2') {
    $adminStatus2Checked = 'checked';
  }elseif($getUserAdminStatus == 'MAIN ADMIN' || $adminStatus == '3') {
    $adminStatus3Checked = 'checked';
  }elseif($getUserAdminStatus == 'PROJECT LEAD' || $adminStatus == '4') {
    $adminStatus4Checked = 'checked';
  }
  
  if($debug){
    $debug_string .=  "activeStatus =" . $activeStatus . "</br>"; 
  }

  $activeCheckbox = "<div>
  <input type='checkbox' name='activeStatus' id='active' value='1' $activeChecked> 
  <label for='active'>Active</label><br>
  
  </div>";

  $adminStatusOptions = "<div> 
  <input type='radio' name='adminStatus'  id='user' value='1' $adminStatus1Checked>
  <label for='user'>USER</label><br>
  <input type='radio' name='adminStatus'  id='admin' value='2' $adminStatus2Checked>
  <label for='admin'>ADMIN</label><br>
  <input type='radio' name='adminStatus'  id='mainAdmin' value='3'  $adminStatus3Checked>
  <label for='mainAdmin'>MAIN ADMIN</label><br>
  <input type='radio' name='adminStatus'  id='projectLead' value='4' $adminStatus4Checked>
  <label for='projectLead'>PROJECT LEAD</label>
  </div>";
  
  if($getUserUserName == "") {
      $getUserUserName = "No User Name";
  }

   /*HTML*/
  ?>

<div> 
  <div class="container ">
    <div class="row">
      <div class="col">
        <div class="card mb-4" style="border-color: darkseagreen;">
          <form action='admin2.php' method="post">
          <div class="card-header"><h2></h2></div>
              <div class="card-body">
                <div class="row">
                  <div class="col">
                  <h4>User Info for "<?php echo $getUserUserName ?>" </h4></br>
                    <div class="table-responsive">
                      <table class="table " >
                        <tbody>
                          <tr style="border-top: 2px solid black;">
                            <td >User ID:</td>
                            <td> <?php echo $adminGetUserID . $adminUserDropdownValue  ?></td>
                          
                          </tr>
                          <tr>
                            <td >User First Name:</td>
                            <td><?php echo $getUserFirstNameError ."<br>" ?> <input type="text" name="getUserFirstName" value=" <?php echo $getUserFirstName ?>" ></td> 
                          
                          </tr>
                          <tr>
                            <td >User Last Name:</td>
                            <td><?php echo $getUserLastNameError ."<br>" ?><input type="text" name="getUserLastName" value=" <?php echo $getUserLastName  ?>" ></td>
                            
                          </tr>
                          <tr>
                            <td >User Username:</td>
                            <td><?php echo $getUserUserNameError ."<br>" ?><input type="text"  name="getUserUserName" value=" <?php echo $getUserUserName  ?>" ></td>
                            
                          </tr>
                          <tr>
                            <td >User Email:</td>
                            <td><?php echo $getUserEmailError ."<br>" ?><input type="email" name="getUserEmail" value=" <?php echo $getUserEmail  ?>" ></td>
                          
                          </tr>
                          <tr>
                            <td >User Active Status:</td>
                            <td><?php echo $activeCheckbox  ?></td>
                          
                          </tr>
                        
                          <tr>
                            <td >User Admin Status:</td>
                            <td><?php echo $adminStatusOptions ?></td>
                            
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div> <!--End Col-->
                  
                  <div class="col">
                  <h4>Project Access </h4></br>
                    <div class="card mb-4" style="border-color: darkseagreen;">
                      <div class="card-body">
                      <?php
                      echo $completeProjectCheckboxListChecked;
                      ?>
                      </div>
                    </div>
                  </div> <!--End Col--> 
                </div><!--End Row-->  
                         
                <div class="col">
                  <input class="btn siteButton mt-4" type="submit" value="UPDATE">
                  <input type='hidden' name='updateUserInfo' value='true'>
                  <input type='hidden' name='adminGetUserID' value='<?php echo $adminUserDropdownValue . $adminGetUserID ?>'>
                </div>
              </div><!--End card-body-->
            </div><!--End Row-->
          </form>
        </div><!--End card-->
      </div><!--End Col-->
    </div><!--End Row-->
  </div><!--End Container-->
</div>
<?php
}




if ($updatedUser =='true'){


  $activeChecked = "";

  if($activeStatus == '1') {
    $activeChecked = 'checked';
    $activeState = "Active";
  }elseif($activeStatus !=='1') {
    $activeState = "Inactive";
  }
  
  

  if($adminStatus == '1') {
    $adminStatus1Checked = 'checked';
    $adminStatusList = "User";
  }elseif($adminStatus == '2') {
    $adminStatus2Checked = 'checked';
    $adminStatusList = "Admin";
  }elseif($adminStatus == '3') {
    $adminStatus3Checked = 'checked';
    $adminStatusList = "Main Admin";
  }elseif($adminStatus == '4') {
    $adminStatus4Checked = 'checked';
    $adminStatusList = "ProjectLead";
  }

  

  $activeCheckbox = "<div>
  <input type='checkbox' name='activeStatus' id='active' value='1' $activeChecked> 
  <label for='active'>Active</label><br>
  
  </div>";

  $adminStatusOptions = "<div> 
  <input type='radio' name='adminStatus'  id='user' value='1' $adminStatus1Checked>
  <label for='user'>USER</label><br>
  <input type='radio' name='adminStatus'  id='admin' value='2' $adminStatus2Checked>
  <label for='admin'>ADMIN</label><br>
  <input type='radio' name='adminStatus'  id='mainAdmin' value='3'  $adminStatus3Checked>
  <label for='mainAdmin'>MAIN ADMIN</label><br>
  <input type='radio' name='adminStatus'  id='projectLead' value='4' $adminStatus4Checked>
  <label for='projectLead'>PROJECT LEAD</label>
  </div>";

   /*HTML*/
  ?>

<div> 
  <div class="container ">
    <h4> You successfully updated "<?php echo $getUserUserName?>" Info!</h4>
    <div class="row">
      <div class="col">
        <div class="card mb-4" style="border-color: darkseagreen;">
          <form action='admin2.php' method="post">
          <div class="card-header"><h2></h2></div>
              <div class="card-body">
                <div class="row">
                  <div class="col">
                  <h4>Updated Info for "<?php echo $getUserUserName ?>". </h4></br>
                    <div class="table-responsive">
                      <table class="table " >
                        <tbody>
                          <tr style="border-top: 2px solid black;">
                            <td >User ID:</td>
                            <td> <?php echo $adminGetUserID  ?></td>
                          
                          </tr>
                          <tr>
                            <td >User First Name:</td>
                            <td><?php echo $getUserFirstName ?></td> 
                          
                          </tr>
                          <tr>
                            <td >User Last Name:</td>
                            <td><?php echo $getUserLastName  ?></td>
                            
                          </tr>
                          <tr>
                            <td >User Username:</td>
                            <td><?php 
                            echo $getUserUserName  ?></td>
                            
                          </tr>
                          <tr>
                            <td >User Email:</td>
                            <td><?php echo $getUserEmail  ?></td>
                          
                          </tr>
                          <tr>
                            <td >User Active Status:</td>
                            <td><?php echo $activeState  ?></td>
                          
                          </tr>
                        
                          <tr>
                            <td >User Admin Status:</td>
                            <td><?php echo $adminStatusList ?></td>
                            
                          </tr>
                        </tbody>
                      </table>
                      <h6>Choose from Navbar to continue</h6>
                    </div>
                  </div> <!--End Col-->
                  
                  <div class="col">
                  <h4>Project Access</h4></br>
                    <div class="card mb-4" style="border-color: darkseagreen;">
                      <div class="card-body">
                      <?php
                      echo $projListSimp;
                      ?>
                      </div>
                    </div>
                  </div> <!--End Col--> 
                </div><!--End Row-->  
                         
               
              </div><!--End card-body-->
            </div><!--End Row-->
          </form>
        </div><!--End card-->
      </div><!--End Col-->
    </div><!--End Row-->
  </div><!--End Container-->
</div>
<?php
}




include 'endingBoilerPlate.php';
