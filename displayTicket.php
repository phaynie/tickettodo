<?php



include 'boilerPlate.php';
include 'nav.php';

if($debug) {
    $debug_string .= "displayTicket.php<br/><br/>";
}


$debug_string = "";
$ticketID = "";
$ticketName = "";
$ticketDesc = "";
$ticketComm = "";
$ticketCat = "";
$ticketDate = "";
$ticketTime = "";
$status = "";
$commentDate = "";
$commentBody = "";
$commentLinkText = "";
$commentString = "";
$priority = "";
$editStatus = "";
$editCategory = "";
$editTicket = "";
$dbTicketID = "";
$last_category_ID = "";
$category = "";
$editTicket = "";


/*value comes from editTicket.php and createNewTicket.php*/


if(isset($_REQUEST['ticketID'])) {
    $ticketID = $_REQUEST['ticketID'];
}
/*value comes from editTicket.php */
if(isset($_REQUEST['status'])) {
    $status = $_REQUEST['status'];
}

if (isset($_REQUEST['comment'])) {
    $comment = $_REQUEST['comment'];
}

if (isset($_SESSION['name'])) {
    $userName = $_SESSION['name'];
}



/*value comes from editTicket.php */
if (isset($_REQUEST['priority'])) {
    $priority = $_REQUEST['priority'];
}
/*value comes from editTicket.php */
if (isset($_REQUEST['category'])) {
    $category = $_REQUEST['category'];
}

if (isset($_REQUEST['lastCategoryID'])) {
    $last_category_ID = $_REQUEST['lastCategoryID'];
}

if (isset($_REQUEST['editTicket'])) {
    $editTicket = $_REQUEST['editTicket'];
}

if (isset($_REQUEST['brandNewCategory'])) {
    $category = $last_category_ID;
}

if(isset($_REQUEST['addCommentSubmit'])) {
    $commentLinkText = "Add to Comment";
}else  {
    $commentLinkText = "Add Comment";
}







/*This section updates the ticket when user changes the status (displayTicket.php)*/
/*STATUS*/


if(isset($_REQUEST['editStatus'])) {
    /*Sanitize data before querying the db*/

    $washPostVar = test_input($status);
    $status = strip_before_insert($conn, $washPostVar);

    $washPostVar = test_input($ticketID);
    $ticketID = strip_before_insert($conn, $washPostVar);


    $statusUpdate = "UPDATE ticket
                    SET status_ID = '$status'
                    WHERE ID = $ticketID;";


    $statusUpdateResult = $conn->query($statusUpdate);

    if($debug) {
        $debug_string .= "\nstatusUpdate= " . $statusUpdate . "\n<br/>";
        if (!$statusUpdateResult) {
            $queryError = "\n Error description: statusUpdate: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }

    } /*end debug*/

//    failureToExecute ($statusUpdateResult, 'U704', 'Update ' );



}elseif(isset($_REQUEST['editPriority'])) {


    $washPostVar = test_input($priority);
    $priority = strip_before_insert($conn, $washPostVar);

    $washPostVar = test_input($ticketID);
    $ticketID = strip_before_insert($conn, $washPostVar);

    $priorityUpdate = "UPDATE ticket
                    SET priority_ID = '$priority'
                    WHERE ID = $ticketID;";


    $priorityUpdateResult = $conn->query($priorityUpdate);

    if ($debug) {
        $debug_string .= "\npriorityUpdate= " . $priorityUpdate . "\n<br/>";
        if (!$priorityUpdateResult) {
            $queryError = "\n Error description: priorityUpdate: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }

    } /*end debug*/

//    failureToExecute ($priorityUpdateResult, 'U704', 'Update ' );



}elseif(isset($_REQUEST['editCategory'])) {

    if($editTicket) {

    }
    /*Sanitize data before querying the db*/

    $washPostVar = test_input($category);
    $category = strip_before_insert($conn, $washPostVar);

    $washPostVar = test_input($ticketID);
    $ticketID = strip_before_insert($conn, $washPostVar);

    $categoryUpdate = "UPDATE ticket
                    SET category_ID = '$category'
                    WHERE ID = $ticketID;";


    $categoryUpdateResult = $conn->query($categoryUpdate);

    if ($debug) {
        $debug_string .= "\ncategoryUpdate= " . $categoryUpdate . "\n<br/>";
        if (!$categoryUpdateResult) {
            $queryError = "\n Error description categoryUpdate: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    } /*end debug*/

//    failureToExecute ($$categoryUpdateResult, 'U704', 'Update ' );



}elseif(isset($_REQUEST['editComment'])) {

   /*any new comment is inserted into the comment table in addComment.php no update is needed here.*/
}







/*These happen every time*/
/*Sanitize data before querying the db*/

$washPostVar = test_input($ticketID);
$ticketID = strip_before_insert($conn, $washPostVar);


$commentQuery = "SELECT ID, comment_ticket_ID, comment_date, comment_time, comment_body 
    FROM comment 
    WHERE comment_ticket_ID = $ticketID
    ORDER BY comment_date DESC, comment_time DESC";

$commentQueryResult = $conn->query($commentQuery);


if ($debug) {
    $debug_string .= 'commentQuery = ' . $commentQuery . '<br/><br/>';
    if (!$commentQueryResult) {
        $queryError = "\n Error description query commentQuery: " . mysqli_error($conn) . "\n<br/>";
        outputError($queryError);
    }
}/*end debug*/


if ($commentQueryResult) {


    $numberOfCommentRows = $commentQueryResult->num_rows;

    /* this begins the process for comment from the db being displayed in  */
    $commentString = "";

    for ($j = 0; $j < $numberOfCommentRows; ++$j) {
        $row = $commentQueryResult->fetch_array(MYSQLI_NUM);

        $commentID = $row[0];
        $commentTicketID = $row[1];
        $commentDate = date("l, F d, Y", strtotime($row[2]));
        $commentTime = date("g:i a", strtotime($row[3]));
        $commentBody = $row[4];



        $commentString .= "Comment: </br>" . $commentDate . '&nbsp &nbsp &nbsp' .  $commentTime .  '&nbsp &nbsp &nbsp  <em>' .  $userName . '</em></br></br>'  .

            '&nbsp &nbsp &nbsp' . $commentBody
            . '</br></br>';

    }
}

/*Sanitize data before querying the db*/

$washPostVar = test_input($ticketID);
$ticketID = strip_before_insert($conn, $washPostVar);


$ticketQuery = "SELECT  t.ID, t.name, t.description, t.category_ID, t.date, t.ticket_time, t.status_ID, t.priority_ID, t.project_ID, c.category_name, p.priority_name, s.status_name, proj.project_name
                FROM ticket AS t
                LEFT JOIN category AS c ON t.category_ID = c.ID
                LEFT JOIN priority AS p ON p.ID = t.priority_ID
                LEFT JOIN status AS s ON s.ID = t.status_ID
                LEFT JOIN project AS proj ON proj.ID = t.project_ID
                WHERE t.ID = $ticketID";


    $ticketQueryResult = $conn->query($ticketQuery);

    if ($debug) {
        $debug_string .= 'ticketQuery = ' . $ticketQuery . '<br/><br/>';
        if (!$ticketQueryResult) {
            $queryError = "\n Error description query ticketQueryResult: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*end debug*/

    $numberOfTicketRows = $ticketQueryResult->num_rows;



    for ($j = 0; $j < $numberOfTicketRows; ++$j) {
        $row = $ticketQueryResult->fetch_array(MYSQLI_NUM);

        $dbTicketID = $row[0];
        $ticketName = $row[1];
        $ticketDesc = $row[2];
        $ticketCatID = $row[3];
        $ticketDate = date("l, F d, Y", strtotime($row[4]));
        $ticketTime = date("g:i a", strtotime($row[5]));
        $ticketStatus = $row[6];
        $ticketPriority = $row[7];
        $ticketProjectID = $row[8];
        $categoryName = $row[9];
        $priorityName = $row[10];
        $statusName = $row[11];
        $ticketProjectName = $row[12];


    }    /*forloop ending*/

if($debug) {
    echo $debug_string;
}
?>




 <!--Bootstrap Table-->
    <div class="container ticketTable">
        <div class="row">

            <div class="col-lg-3">
                <div class="table-responsive-lg">

                    <table style="width:100%" class="table  table-bordered">

                        <tbody>
                        <tr class="d-flex">
                            <td  style="width:100%; background-color:lightgoldenrodyellow; border-radius:10px 10px 0px 0px;"></td>

                        </tr>
                        <tr class="d-flex" >
                            <td style="width:50%">CATEGORY: </td>
                            <td style="width:50%">
                                <a href="editTicket.php?categoryLink=true&editTicket=true&ticketID=<?php echo $dbTicketID
                                ?> "><?php echo
                                    $categoryName  ?></a>
                            </td>


                        </tr>

                        <tr class="d-flex" >
                            <td style="width:50%">PRIORITY: </td>
                            <td style="width:50%">
                                <a href="editTicket.php?priorityLink=true&editTicket=true&ticketID=<?php echo $dbTicketID ?>"><?php echo $priorityName
                                    ?></a>
                            </td>


                        </tr>
                        <tr class="d-flex" >
                            <td style="width:50%">STATUS: </td>
                            <td style="width:50%">
                                <a href="editTicket.php?statusLink=true&editTicket=true&ticketID=<?php echo $dbTicketID
                                ?>"><?php echo $statusName ?></a>
                            </td>

                        </tr>
                        <tr class="d-flex" >
                            <td style="width:50%">COMMENT: </td>
                            <td style="width:50%">
                                <a href="addComment.php?addComment=true&editTicket=true&ticketID=<?php echo
                                $dbTicketID ?>"><?php echo $commentLinkText ?></a>
                            </td>

                        </tr>
                        <tr class="d-flex" >
                            <td style="width:50%">PROJECT: </td>
                            <td style="width:50%"><?php echo
                                $ticketProjectName ?>
                            </td>

                        </tr>
                        <tr class="d-flex ">
                            <td  class="d-none d-lg-block" style="width:100%; background-color:lightgoldenrodyellow;
                            border-radius:0px 0px 10px
                            10px;
    "</td>
                        </tr>
                        </tbody>
                    </table>
                </div><!--end table-responsive-->
            </div><!--end column-->

            <div class=" col-lg-9">
                <div class="table-responsive-lg">
                    <table class="table table-bordered" style="width=100%">
                        <tbody>
                        <tr class="d-flex">
                            <td  class="d-none d-lg-block" style="width:100%; background-color:lightgoldenrodyellow;
                            border-radius:10px 10px 0px
                            0px;"></td>
                        </tr>
                        <tr class="d-flex">
                            <td style="width:25%"><?php echo $dbTicketID ?></td>
                            <td style="width:50%"><?php echo $ticketName ?></td>
                            <td style="width:25%"><?php echo $ticketDate . '<br/>' . $ticketTime ?></td>
                        </tr>
                        <tr class="d-flex">
                            <td style="width:100%"> <?php echo $ticketDesc ?></td>
                        </tr>
                        <tr class="d-flex">
                            <td style="width:100%"><?php echo $commentString ?></td>
                        </tr>
                        <tr class="d-flex    ">
                            <td   style="width:100%; background-color:lightgoldenrodyellow;
                                 border-radius:0px 0px
                                 10px 10px;
    "</td>
                        </tr>
                        </tbody>
                    </table>
                </div><!--end table-responsive-->
            </div><!--end column-->
        </div><!--end row-->
    </div> <!--end container-->


<?php

include 'endingBoilerPlate.php';

