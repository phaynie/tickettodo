<?php


include 'boilerPlate.php';



if($debug) {
    $debug_string .= "createNewTicket.php<br/>";
}


// echo "<br/> projectID = " . $_SESSION['projectID'] . "<br/>";  
// echo "activeProject = " . $_SESSION['activeProject'] . "<br/> ";



//<!--get ready to insert-->
//<!--Initialize variables coming from createNewTicket.php-->

$last_id = "";
$newTicketSubmit = "";
$ticketInsertQuery = "";


$name = "";
$description = "";
$comment = "";


$category = "";
$status = "";
$priority = "";
$date = "";
$ticketID = "";

/*Add New Category code*/
$addCatSubmit = "";
$newCategoryField = "";
$newCatSubmit = "";
$prepop = "";
$editTicket = "";
$last_category_ID = "";
$createTicket = "";




//variable created to check in with the current project
$currentProjectID = $_SESSION['projectID'];

//echo "2 currentProjectID =" . $currentProjectID . "</br></br>";

//Create local variables for values coming from CreateNewTicket form

if(isset($_REQUEST['newTicketSubmit'])) {
    $newTicketSubmit = $_REQUEST['newTicketSubmit'];
}

if(isset($_REQUEST['name'])) {
    $name = $_REQUEST['name'];
    $sendName = "<input type='hidden' name='name' value='$name' />";
}

if(isset($_REQUEST['description'])) {
    $description = $_REQUEST['description'];
    $sendDescription = "<input type='hidden' name='description' value='$description' />";
}

if(isset($_REQUEST['comment'])) {
    $comment = $_REQUEST['comment'];

}

if(isset($_REQUEST['category']) AND is_numeric($_REQUEST['category'])) {
    $category = $_REQUEST['category'];
}

if(isset($_REQUEST['status']) AND is_numeric($_REQUEST['status'])) {
    $status = $_REQUEST['status'];
    $sendStatus = "<input type='hidden' name='status' value='$status' />";
}

if(isset($_REQUEST['priority']) AND is_numeric($_REQUEST['priority'])) {
    $priority = $_REQUEST['priority'];
    $sendPriority = "<input type='hidden' name='priority' value='$priority' />";
}

if(isset($_REQUEST['prepop'])) {
    $prepop = $_REQUEST['prepop'];
    $prepopText = "<p>Your new category has been added. Complete remainder of form and Add Ticket</p>";
}

if(isset($_REQUEST['editTicket'])) {
    $editTicket = $_REQUEST['editTicket'];
    $sendEditTicket = "<input type='hidden' name='editTicket' value='true'/>";

}

if(isset($_REQUEST['ticketID']) AND is_numeric($_REQUEST['ticketID'])) {
    $ticketID = $_REQUEST['ticketID'];
}


if(isset($_REQUEST['lastCategoryID'])) {
    $last_category_ID = $_REQUEST['lastCategoryID'];

}




//Create local variables for values coming from Add New Category form


if(isset($_REQUEST['addCatSubmit'])) {
    $addCatSubmit = $_REQUEST['addCatSubmit'];
}

if(isset($_REQUEST['newCategoryField'])) {
    $newCategory = $_REQUEST['newCategoryField'];
}

if(isset($_REQUEST['newCatSubmit'])) {
    $newCatSubmit = $_REQUEST['newCatSubmit'];
}

if(isset($_REQUEST['createTicket'])) {
    $createTicket = $_REQUEST['createTicket'];
    $sendCreateTicket = "<input type='hidden' name='createTicket' value='true'/>";
}

if(isset($_REQUEST['brandNewCategory'])) {
    $brandNewCategory = $_REQUEST['brandNewCategory'];
    $sendBrandNewCategory = "<input type='hidden' name='brandNewCategory' value='true'/>";

}







/*When submit button, "ADD"  from Add New Category form is clicked*/
if($addCatSubmit) {

    /* display a card with a add New Category text field that allows user to add a new category to db */
    /*send along all the info from create new ticket form*/
    /*Could use include here for the include form. Then all the variables would already be set up on createNewTicket
    .php*/

 ?>



<div class="container">
    <div class="row">
        <div class="col">
            <div class="card" >

                    <div class="card-header">Add New Category</div>
                    <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <form action= "createNewTicket.php" id="task-form" method='post'>
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="newCategoryField" 
                                    id="addCategoryInputBox"
                                           placeholder="New Category Name"/>
                                </div>
                                <div class="col">
                                   <input type="submit"  value="ADD" class="btn siteButton searchIdNum"/>
                                   <input type="hidden"  name="submit" value="true"/>
                                   <input type="hidden" name="prepop" value="true"/>
                                   <input type="hidden" name="ticketID" value="$ticketID"/>

                                    <?=   $sendName?>
                                    <?=   $sendDescription?>
                                    <?=   $sendStatus?>
                                    <?=   $sendPriority?>
                                    <?=   $sendEditTicket?>
                                    <?=   $sendBrandNewCategory?>
                                    <?=   $sendCreateTicket?>
                                </div>
                            </form>
                        </div> <!--end col-->
                    </div><!--end row-->
                    </div><!--end card-body-->

            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
</div><!--end container-->



<?php


} /*end if($addCatSubmit)*/

elseif($newCategory ) {
//
//    Validate user info from newCategoryField

    $washPostVar = test_input($newCategory);
    $newCategory = strip_before_insert($conn, $washPostVar);

//    Input the new category ($newCategory) into db
    $categoryInsertQuery = "INSERT INTO category (category_named)
VALUES ('$newCategory')";

    /*Send the query to the database*/
    $categoryInsertQueryResult = $conn->query($categoryInsertQuery);
    if ($debug) {
        $debug_string .= "\ncategoryInsertQuery= " . $categoryInsertQuery . "\n<br/>";

        if (!$categoryInsertQueryResult){ 
            $queryError = "\n Error description: categoryInsertQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*End if debug*/


    if ($categoryInsertQueryResult) {
        $last_category_ID = $conn->insert_id;
        $debug_string .= 'last_category_ID = ' . $last_category_ID . '<br/><br/>';

/*might not need any of this categorySearchQuery*/
        if ($createTicket) {
            $categorySearchQuery = "SELECT category_name
            FROM category
            WHERE ID = $last_category_ID";


            $categorySearchQueryResult = $conn->query($categorySearchQuery);


            if ($debug) {

                $debug_string .=  'categorySearchQuery = ' . $categorySearchQuery . '<br/><br/>';
                if (!$categorySearchQueryResult){  
                    $queryError = "\n Error description: categorySearchQuery: " . mysqli_error($conn) .
                    "\n<br/>";
                    outputError($queryError);
                }
            }/*end debug*/

            if ($categorySearchQueryResult) {

                $numberOfCategorySearchRows = $categorySearchQueryResult->num_rows;


                for ($j = 0; $j < $numberOfCategorySearchRows; ++$j) {
                    $row = $categorySearchQueryResult->fetch_array(MYSQLI_NUM);


                    $newCategoryName = $row[0];


                }
            }
        }/*end if create ticket*/
    } /*end if ($categoryInsertQueryResult) */

            /*In this case we have created a new category, inserted it and now want to return to Search Category (editTicket.php)
             where it can  */

//going to displayTicket.php to update ticket with new category ID and display ticket

            if ($editTicket) {
                header('Location: displayTicket.php?ticketID=' . $ticketID . '&lastCategoryID=' . $last_category_ID .
                    '&editCategory=true&editTicket=true&brandNewCategory=' . $brandNewCategory);
                exit();
            } else {
                header('Location: createNewTicket.php?lastCategoryID=' . $last_category_ID . '&name=' . $name . '&description=' . $description . '&priority=' . $priority . '&category=' . $last_category_ID . '&status=' . $status);
                exit();
            }/*end else*/


    }/*end if new Category*/







/*When submit button from createNewTicket form is clicked*/
//if newTicketsubmit is true
if($newTicketSubmit ) {

//  validate user information
    $washPostVar = test_input($name);
    $name = strip_before_insert($conn, $washPostVar);

    $washPostVar = test_input($description);
    $description = strip_before_insert($conn, $washPostVar);

    $washPostVar = test_input($category);
    $category = strip_before_insert($conn, $washPostVar);

    $washPostVar = test_input($status);
    $status = strip_before_insert($conn, $washPostVar);

    $washPostVar = test_input($priority);
    $priority = strip_before_insert($conn, $washPostVar);



    /*Insert create new ticket form info into database*/
    /*input query*/

    $ticketInsertQuery = "INSERT INTO ticket (name, description, category_ID, date, ticket_time, status_ID,
        priority_ID, project_ID) VALUES ('$name', '$description', '$category', CURDATE(), CURTIME(), '$status', '$priority', '$currentProjectID')";



    /*Send the query to the database*/
    $ticketInsertQueryResult = $conn->query($ticketInsertQuery);
    if ($debug) {
        $debug_string .= "\nticketInsertQuery= " . $ticketInsertQuery . "\n<br/>";

        if (!$ticketInsertQueryResult) {
            $queryError = "\n Error description: ticketInsertQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*End if debug*/



    if ($ticketInsertQueryResult) {
        $last_id = $conn->insert_id;
        
    }
    if($debug){
        $debug_string .= $last_id;
        }
    
    /*decide how and where to display new inserted data*/
    /*header takes us to displayTicket.php*/

//    echo $debug_string;

 $debug_string .= "last_id = " . $last_id ;
 header('Location: displayTicket.php?ticketID=' . $last_id);
   exit();
}







if(!$addCatSubmit) {



$categoryQuery = "SELECT ID, category_name
FROM category
ORDER BY category_name ASC";

$categoryQueryResult = $conn->query($categoryQuery);


if ($debug) {
    $debug_string .= 'categoryQuery = ' . $categoryQuery . '<br/><br/>';
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
        $selected = "";
        if ($category == $categoryID)
        {$selected = "selected";}

        $categoryOptionRows .= "<option value='$categoryID' $selected >$categoryName</option>";

    }
}
include 'nav.php';


?>
<!--<script>-->
<!--    function changeFormAction(event) {-->
<!--        debugger;-->
<!--        var form = document.getElementById("task-form");-->
<!--        form.action="addNewCategory.php" ;-->
<!--        event.stopPropagation();-->
<!--        form.submit();-->
<!--    }-->
<!--</script>-->

/**/











    <!-- html for Add New Ticket -->
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card" >

                        <div class="card-header">Add Ticket</div>
                        <div class="card-body">
                        <?php echo $prepopText ?>
                        <div class="row">
                            <div class="col">
                                <form action='createNewTicket.php' name="createTicketForm" id="task-form" method='post'>
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control"
                                               id="name" value="<?php echo $name ?>"/>
                                        <label for="name">Ticket Name</label>
                                    </div>
                                    <div class="form-group">
                                        <textarea id="description" class="form-control"
                                                  name="description"><?php echo $description ?> </textarea>
                                        <label for="description">Ticket Description</label>

                                    </div>
                                    <div class="form-group">
                                        <select name="priority" id="priority" class="form-control">
                                            <option value="" disabled selected>Ticket Priority</option>
                                            <option value="1" <?php if ($priority == "1") {echo("selected");} ?>>Low</option>
                                            <option value="2" <?php if ($priority == "2") {echo("selected");} ?>>Medium</option>
                                            <option value="3" <?php if ($priority == "3") {echo("selected");} ?>>High</option>
                                            <option value="4" <?php if ($priority == "4") {echo("selected");} ?>>URGENT</option>
                                        </select>
                                      <label for="priority" style="color: #9e9e9e;">Ticket Priority</label>
                                    </div>



                                    <div class="form-group">
                                        <select name="category" class="form-control id="category" <?php echo $category
                                        ?> ">
                                            <option value="" disabled selected>Ticket Category</option>
                                            <?php echo $categoryOptionRows ?>
                                        </select>
                                       <label for="category">Ticket Category</label>
                                    </div>

                                    <div class="btn-toolbar" role="toolbar" aria-label="Button toolbar" >
                                        <div class="btn-group" role="group" aria-label="button group">
                                            <div>
                                                <input class="btn siteButton mr-2" name="addCatSubmit" type='submit'
                                                       value="Add New Category" />


                                                <input type="hidden" name="createTicket" value="true"/>
                                            </div>
                                            <div>

                                                <input type="submit" name="newTicketSubmit" value="Add Ticket"
                                                       class="btn siteButton mr-2 addTicketbuttons" />

                                                <input type="hidden" name="createTicket" value="true"/>
                                                <input type='hidden' name="status" value='1'/>
                                                <input type='hidden' name="comment" value='Add Comment'/>
                                                <input type='hidden' name='ticketProjectID' value= "<?php echo $currentProjectID ?>" />

                                            </div>

                                            <div>
                                                <button class="btn siteButton addTicketButtons" onclick="goBack()"
                                                        type="button" >Cancel</button>
                                            </div>

                                        </div><!--end button row-->
                                    </div><!--end button container-->
                                </form>

                            </div> <!--end col-->
                        </div><!--end row-->
                    </div><!--end card-content-->
                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->

<?php
}

include 'endingBoilerPlate.php';