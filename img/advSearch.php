<?php


include 'boilerPlate.php';



if($debug) {
    $debug_string .=  "advSearch.php";
}


$status = "";
$priority = "";
$remaining = "";
$project = "";
$myLinkDate = "";
$myLinkStatus = "";
$myLinkPriority = "";
$myLinkProject = "";
$myLinkCategory = "";
$myLinkIdNum = "";

$submit = "";
$from_date = "";
$to_date = "";
$idNum = "";
$category = "";
$doesValidate = "";
$dateInputError = "";





if(isset($_REQUEST['status'])) {
    $status = $_REQUEST['status'];
}

if(isset($_REQUEST['priority'])) {
    $priority = $_REQUEST['priority'];
}

if(isset($_REQUEST['project'])) {
    $project = $_REQUEST['project'];
}

if(isset($_REQUEST['category'])) {
    $category = $_REQUEST['category'];
}

if(isset($_REQUEST['remaining'])) {
    $remaining = $_REQUEST['remaining'];
}

if(isset($_REQUEST['myLinkDate'])) {
    $myLinkDate = $_REQUEST['myLinkDate'];
}

if(isset($_REQUEST['myLinkStatus'])) {
    $myLinkStatus = $_REQUEST['myLinkStatus'];
}

if(isset($_REQUEST['myLinkPriority'])) {
    $myLinkPriority = $_REQUEST['myLinkPriority'];
}

if(isset($_REQUEST['myLinkProject'])) {
    $myLinkProject = $_REQUEST['myLinkPoject'];
}

if(isset($_REQUEST['myLinkCategory'])) {
    $myLinkCategory = $_REQUEST['myLinkCategory'];
}

if(isset($_REQUEST['myLinkIdNum'])) {
    $myLinkIdNum = $_REQUEST['myLinkIdNum'];
}

if(isset($_REQUEST['submit'])) {
    $submit = $_REQUEST['submit'];
}

if(isset($_REQUEST['idNum'])) {
    $idNum = $_REQUEST['idNum'];
}

if(isset($_REQUEST['from_date'])) {
    $from_date = $_REQUEST['from_date'];
}

if(isset($_REQUEST['to_date'])) {
    $to_date = $_REQUEST['to_date'];
}







/*Here we establish the logic and build the page all together below*/

/*STATUS*/
if($myLinkStatus == 'true') {

     /*We will sanitize just before use of $status variable in db (displayAdvSearch.php)*/
    if($submit == 'true' && $status !== ""){

        /*Validation happens with JS function; if $status == "". The JS function creates an alert that says 'Please
        choose a value for status.'*/

        header('Location: displayAdvSearch.php?status=' . $status);
        exit();

        /*we will be sending information by header to displayAdvSearch.php and then sanitizing variable before using
        in db query.*/
    }




    /*PRIORITY*/
} elseif($myLinkPriority == 'true') {
    if($submit == 'true' && $priority !== "") {

        /*Validation happens with JS function. sends alert that says 'Please choose a value for priority.'
        We will sanitize just before use of $priority variable in db (displayAdvSearch.php)*/

        header('Location: displayAdvSearch.php?priority=' . $priority);
        exit();

    }

        /*PROJECT*/
} elseif($myLinkProject == 'true') {
    if($submit == 'true' && $project !== "") {

        /*Validation happens with JS function. sends alert that says 'Please choose a value for project.'
        We will sanitize just before use of $project variable in db (displayAdvSearch.php)*/

        header('Location: displayAdvSearch.php?project=' . $project);
        exit();

    }




/*CATEGORY*/
} elseif($myLinkCategory == 'true') {
/*We must first collect all the categories already in the db so the user can choose from those already created*/

    if($submit == 'true') {
        /*Data integrity validation?*/

        /*header with theses variables */
        header('Location: displayAdvSearch.php?category=' . $category );
        exit();
    }

// here I am trying to find all the categories for my drop down so user can choose a category to search by.
//nothing to do with searching only the current project
$categoryQuery = "SELECT ID, category_name
    FROM category 
    ORDER BY category_name ASC";

    $categoryQueryResult = $conn->query($categoryQuery);


    if ($debug) {

        $debug_string .=  'categoryQuery = ' . $categoryQuery . '<br/><br/>';
        if (!$categoryQueryResult) {
            $queryError = "\n Error description: categoryQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*end debug*/

    if ($categoryQueryResult) {


        /*This requires the function if we want to use it*/

// failureToExecute ($categoryQueryResult, 'S1', 'Select ');


        $numberOfCategoryRows = $categoryQueryResult->num_rows;

        /* this begins the process for categories from the db being displayed in <option> s. */
        $categoryOptionRows = "";

        for ($j = 0; $j < $numberOfCategoryRows; ++$j) {
            $row = $categoryQueryResult->fetch_array(MYSQLI_NUM);

            $categoryID = $row[0];
            $categoryName = $row[1];
            


            $categoryOptionRows .= "<option value='$categoryID'>$categoryName</option>";
        }
    }



    /*IdNum*/
} elseif($myLinkIdNum == 'true') {
    if ($submit == 'true') {

            if(is_numeric($idNum)){
               $doesValidate = true;

            }else{
                $idNumInputError = "<span class='error' > *Please enter a numeric value in the box.</span>";
                $doesValidate = false;
            }

            if ($doesValidate) {

            /*header with theses variables */
            header('Location: displayAdvSearch.php?idNum=' . $idNum );
            exit();
            }

            /*We have code here that will never run. It will never use the $does not validate. JS checks to see if
            the input is an empty string. HTML prevents the user from entering anything but a numeric value.
            $doesValidate == false will never happen And  $idInputError will never be used.
            Is it still necessary to this necessary to prevent against hacking? */

    }/*end if submit is true*/



    /*DATE*/
} elseif($myLinkDate == 'true') {
    if ($submit == 'true') {
        /* validation and error messages*/
        if (validateDate($from_date) && validateDate($to_date)) {
            $doesValidate = true;

        } else {
            $dateInputError = "<span class='error' > *Please enter a date in both date boxes.</span>";
            $doesValidate = false;
        }


        /*how do I verify that this info passes validation?
        what variable will I use to indicate variable validated?
        if these two values pass validation then it would go on to wash the info and select info from db
        if the two values do not validate the form would show again and error messages be displayed. */

        /*this is washing and should happen right before contact with the db*/
        if ($doesValidate) {

            /*header with these two variables and the $ticketDate */
            header('Location: displayAdvSearch.php?from_date=' . $from_date . '&to_date=' .
                $to_date . '&ticketDate=true');
            exit();
        }
    }


   /*REMAINING*/
} elseif($remaining == 'true') {
    if ($submit == 'true' && $remaining !== "") {

        /*?Validation happens with JS function. sends alert that says 'Please choose a value for priority.'
        We will sanitize just before use of $priority variable in db (displayAdvSearch.php)*/

        header('Location: displayAdvSearch.php?remaining=' . $remaining);
        exit();

    }


}
include 'nav.php';

/*____________________________________________________*/


/*Here I will begin to build the page after all the logic has been created*/




/*JS code connected to Input button below. When it is clicked it runs a JS function that checks to see if the
     was a value chosen. If not, an alert pops up that suggests that the user needs to choose an option. */

if($myLinkStatus == 'true' && $submit !== 'true') {

?>



    <div class="container ">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Search Status</div>
                    <div class="card-body">
                            <form action="" id="task-form" method="post" >
                                  <div class="form-group">
                                      <label for="status">Ticket Status:</label>
                                      <select class="form-control" name="status" id="status">
                                          <option value="" disabled selected>Ticket Status</option>
                                          <option value="1"<?php if ($status == "1") {echo("selected");}
                                          ?>>New</option>
                                          <option value="2"<?php if ($status == "2") {echo("selected");}
                                          ?>>Open</option>
                                          <option value="3"<?php if ($status == "3") {echo("selected");}
                                          ?>>Closed</option>
                                          <option value="4"<?php if ($status == "4") {echo("selected");} ?>>On
                                              Hold</option>
                                          <option value="5"<?php if ($status == "5") {echo("selected");}
                                          ?>>Saved</option>
                                      </select>
                                  </div>
                                  <div class="col">
                                    <input type="submit"  name="searchByStatus" id="searchByStatus" value="Search"
                                           class="btn siteButton searchStatus"/>

                                    <input type="hidden" name ="submit" value="true" />
                                  </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>









<?php

}




/*PRIORITY*/
/*JS code connected to Input button below. When it is clicked it runs a JS function that checks to see if the
     was a value chosen. If not, an alert pops up that suggests that the user needs to choose an option. */

if($myLinkPriority == 'true' && $submit !== 'true') {

    ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Search Priority</div>
                    <div class="card-body">
                            <form action="" id="task-form" method='post'>
                                <div class="form-group">
                                    <label for="priority">Ticket Priority:</label>
                                    <select class="form-control" name="priority" id="priority">
                                        <option value="" disabled selected>Ticket Priority</option>
                                        <option value="1" <?php if ($priority == "1") {
                                            echo("selected");} ?>>Low
                                        </option>
                                        <option value="2" <?php if ($priority == "2") {
                                            echo("selected");
                                        } ?>>Medium
                                        </option>
                                        <option value="3" <?php if ($priority == "3") {
                                            echo("selected");
                                        } ?>>High
                                        </option>
                                        <option value="4" <?php if ($priority == "4") {
                                            echo("selected");
                                        } ?>>URGENT
                                        </option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="submit" name="searchByPriority" id="searchByPriority"
                                    value="Search"
                                    class="btn siteButton
                                       searchPriority"/>
                                    <input type="hidden" name ="submit" value="true" />
                                </div>
                            </form>
                    </div><!--card body-->
                    </div><!--end card-header-->
                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->

    <?php
}






  


/*CATEGORY*/
/*JS code connected to Input button below. When it is clicked it runs a JS function that checks to see if the
    user chose an option (not ""). If not, an alert pops up that suggests that the user needs to choose an option. */

if($myLinkCategory == 'true' && $submit !== 'true') {

    ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Search By Existing Category</div>
                    <div class="card-body">
                        <form action="" id="task-form" method='post'>
                            <div class="form-group">
                                <label for="category">Ticket Category:</label>
                                <select class="form-control" name="category" id="category">
                                    <option value="" disabled selected>Ticket Category</option>
                                    <?php echo $categoryOptionRows ?>

                                </select>
                            </div>
                            <div class="col">
                                <input type="submit" id="searchByCategory" name="searchByCategory"
                                       value="Search" class="btn siteButton
                                   searchCategory"/>
                                <input type="hidden" name="submit" value="true"/>
                                <input type="hidden" name="myLinkCategory" value="true"/>
                            </div>
                        </form>
                    </div><!--card-body-->
                    </div><!--end card-header-->
                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->

    <?php
}

/*IDNum*/
/* TODO This may not be tru and only applies to the category info above JS code connected to Input button below. When
the button is clicked it runs a JS function
that checks
 to see if the
 user chose an option (not ""). If not, an alert pops up that suggests that the user needs to choose an option. */

if($myLinkIdNum == 'true' && ($submit !== 'true' ||  $doesValidate == false)){

    ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Search Ticket ID Number</div>
                    <div class="card-body">
                        <form action='displayAdvSearch.php' id="task-form" method='post'>
                            <div class="form-group">
                                <label for="IDNumberInputBox">Ticket Id Number: <?php echo $idNumInputError
                                    ?></label>
                                <input type="number" class="form-control" name="idNum" id="IDNumberInputBox"
                                       placeholder="Type Id Number"/>
                            </div>
                            <div class="col s3">
                                <input type="submit" id="searchByIDNumber" value="Search"
                                       class="btn siteButton searchIdNum"/>
                                <input type="hidden" name="submit" value="true"/>
                                <input type="hidden" name="myLinkIdNum" value="true"/>
                            </div>
                        </form>
                    </div><!--end card-body-->
                    </div><!--end card-header-->
                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->


    <?php
}

/*DATE*/
/*JS code connected to Input button below. When it is clicked it runs a JS function that checks to see if the
     was a value chosen. If not, an alert pops up that suggests that the user needs to choose an option. */

if($myLinkDate == 'true' && $submit !== 'true') {

?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card" >
                        <div class="card-header">Search Ticket Submit Date</div>
                        <div class="card-body">
                            <form action="" id="task-form"
                                  method='post'>
                                <div class="form-group">
                                    <label for="from_date">
                                        &nbsp;&nbsp;Input the START date: <?php echo $dateInputError ?>
                                        <input type="date" class="form-control"
                                               name="from_date" id="from_date" />
                                  </label> &nbsp; &nbsp; &nbsp;

                                    <label for="to_date">
                                        &nbsp;&nbsp;Input the END date: <?php echo $dateInputError ?>
                                        <input type="date" class="form-control"
                                               name="to_date" id="to_date" />
                                    </label></br></br></br>
                                    HINT:
                                    <p class="hint">If you are searching for a single date rather than a date range, put
                                        the same date into both date boxes</p></br>
                                    <input type="hidden" name ="submit" value="true" />
                                    <input type="hidden" name ="myLinkDate" value="true" />

                                    <input type="submit"  id="searchByDate" value="Search" class="btn
                                    siteButton searchDate"/>
                                </div><!--end form-group-->
                            </form>
                        </div><!--end card-body-->
                        </div><!--end card-header-->
                    </div><!--end card-->
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->

<?php
}

include 'endingBoilerPlate.php';

?>
