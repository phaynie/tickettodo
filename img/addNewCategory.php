<?php



include 'boilerPlate.php';

if($debug) {
    $debug_string .=  "addNewCategory.php";
}

//include 'nav.php';

$submit="";
$name="";
$description="";
$priority="";
$status="";

$createTicket="";
$editTicket="";
$addCategory="";
$categoryPath="";


if(isset($_REQUEST['submit'])) {
    $submit = $_REQUEST['submit'];

}

if(isset($_REQUEST['name'])) {
    $name = $_REQUEST['name'];
    $sendName = "<input type='hidden' name='name' value='$name' ";
}

if(isset($_REQUEST['description'])) {
    $description = $_REQUEST['description'];
    $sendDescription = "<input type='hidden' name='description' value='$description' ";
}

if(isset($_REQUEST['priority'])) {
    $priority = $_REQUEST['priority'];
    $sendPriority = "<input type='hidden' name='priority' value='$priority' ";
}

if(isset($_REQUEST['status'])) {
    $status = $_REQUEST['status'];
    $sendStatus = "<input type='hidden' name='status' value='$status' ";
}

if(isset($_REQUEST['createTicket'])) {
    $createTicket = $_REQUEST['createTicket'];
}

if(isset($_REQUEST['editTicket'])) {
    $editTicket = $_REQUEST['editTicket'];
}

if(isset($_REQUEST['addCategory'])) {
    $addCategory = $_REQUEST['addCategory'];
}

if(isset($_REQUEST['categoryPath'])) {
    $categoryPath = $_REQUEST['categoryPath'];
}


/*logic for variables*/
if($editTicket !=="") {
    $sendEditTicket = "<input type='hidden' name='editTicket' value='true';/>";
}elseif($createTicket !=="") {
    $sendCreateTicket = "<input type='hidden' name='createTicket' value='true';/>";
}


if($submit) {

    /*Validate info from user. */

    $washPostVar = test_input($addCategory);
    $addCategory = strip_before_insert($conn, $washPostVar);



    /*if validation Then insert new category into the database*/


    $categoryInsertQuery = "INSERT INTO category (category_name)
VALUES ('$addCategory')";

        /*Send the query to the database*/
    $categoryInsertQueryResult = $conn->query($categoryInsertQuery);
    if ($debug) {
        $debug_string .= "\ncategoryInsertQuery= " . $categoryInsertQuery . "\n<br/>";

        if (!$categoryInsertQueryResult){ 
            $queryError .= "\n Error description: categoryInsertQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*End if debug*/


    if ($categoryInsertQueryResult) {
        $last_id = $conn->insert_id;
        $debug_string .= "last_id =" . $last_id;


    /*This then goes to */
        if($createTicket !==""){
            header('Location: createNewTicket.php?createTicket=' . $createTicket . '&name=' . $name . '&description=' .
                $description . '&priority=' . $priority );
            exit();
        }elseif($editTicket !=="") {
            header('Location: editTicket.php?ticketID=' . $last_id );
            exit();
        }
    }
}

echo <<<_END



<div class="container-fluid main">
    <div class="row">
        <div class="col s12 ">
            <div id="main" class="card" >
                <div class="card-content">
                    <div class="card-title">Add New Category</div>
                    <div class="row">
                        <div class="col">
                            <form action='addNewCategory.php' id="task-form" method='post'>
                                <div class="input-field col s12">
                                    <input type="text" class="form-control"  name="addCategory" 
                                    id="addCategoryInputBox"
                                           placeholder="New Category Name"/>
                                </div>
                                <div class="col s3">
                                   <input type="submit"  value="ADD" class="btn searchIdNum"/>
                                   <input type="hidden"  name="submit" value="true"/>
                                   <input type="hidden" name="categoryPath" value="true";/>
                                   <input type="hidden" name="ticketID" value="$ticketID";
                                   $sendEditTicket
                                   $sendCreateTicket
                                   $sendName
                                   $sendDescription
                                   $sendPriority
                                   $sendStatus
                                </div>
                            </form>
                        </div> <!--end col-->
                    </div><!--end row-->
                </div><!--end card-content-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
</div><!--end container-->



_END;




include 'endingBoilerPlate.php';