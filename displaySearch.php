<?php



include 'boilerPlate.php';
include 'nav.php';

if($debug) {
    $debug_string .= "DISPLAYSEARCH.php<br/>";
}

$searchBox = "";
$submitSearch = "";
$ticketID = "";
$ticketName = "";
$ticketStatus = "";
$ticketPriority = "";
$ticketDescription = "";
$ticketComment = "";
$ticketCategory = "";
$ticketDate = "";
$ticketTables = "";

$name = "";
$description = "";
$comment = "";
$category = "";
$status = "";
$priority = "";
$date = "";


if(isset($_REQUEST['searchBox'])) {
    $searchBox = $_REQUEST['searchBox'];
}

if(isset($_REQUEST['submitSearch'])) {
    $submitSearch = $_REQUEST['submitSearch'];
}

if(isset($_REQUEST['name'])) {
    $name = $_REQUEST['name'];
}

if(isset($_REQUEST['status'])) {
    $status = $_REQUEST['status'];
}

if(isset($_REQUEST['priority'])) {
    $priority = $_REQUEST['priority'];
}

if(isset($_REQUEST['description'])) {
    $description = $_REQUEST['description'];
}

if(isset($_REQUEST['comment'])) {
    $comment = $_REQUEST['comment'];
}

if(isset($_REQUEST['category'])) {
    $category = $_REQUEST['category'];
}

//sets variable for current project ID to be used in query later
$currentProjectID = $_SESSION['projectID'];




/*select every ticket that has "usertext" in it and display those tickets in order of date (small version, or large?)*/
if($searchBox !== "") {

    /*Sanitize data before querying the db*/

    $washPostVar = test_input($searchBox);
    $searchBox = strip_before_insert($conn, $washPostVar);

    /*Query that finds every ticket from the current project that has the word from the search box*/
    $searchBoxQuery = " SELECT DISTINCT t.ID, t.name, t.description, t.category_ID, t.date, t.ticket_time, t.status_ID, t.priority_ID, t.project_ID, s.status_name, p.priority_name, cat.category_name, proj.project_name
 FROM ticket As t
    LEFT JOIN comment AS c ON c.comment_ticket_ID = t.ID
    LEFT JOIN status AS s ON s.ID = t.status_ID
    LEFT JOIN priority AS p ON p.ID = t.priority_ID
    LEFT JOIN category AS cat ON cat.ID = t.category_ID
    LEFT JOIN project AS proj ON proj.ID = t.project_ID
    WHERE (t.ID LIKE '%$searchBox%' OR
    t.name LIKE '%$searchBox%' OR
    s.status_name LIKE '%$searchBox%' OR
    p.priority_name LIKE '%$searchBox%' OR
    t.description LIKE '%$searchBox%' OR
    c.comment_body LIKE '%$searchBox%' OR
    cat.category_name LIKE '%$searchBox%' OR
    t.date LIKE '%$searchBox%'OR
    t.ticket_time LIKE '%$searchBox%')
    AND t.project_ID = $currentProjectID ";
    
}


$searchBoxQueryResult = $conn->query($searchBoxQuery);


if ($debug) {
    $debug_string .= 'searchBoxQuery = ' . $searchBoxQuery . '<br/><br/>';
    if (!$searchBoxQueryResult) {
        $queryError = "\n Error description: searchBoxQuery: " . mysqli_error($conn) . "\n<br/>";
        outputError($queryError);
    }
}/*end debug*/


if ($searchBoxQueryResult) {
    echo "<div class='container'>
                    <div class='row'>
                        <div class='col'>                                                    
                            <h6 class='p-4'>You searched for Tickets that contain \"$searchBox\". </h6>       
                        </div>
                    </div>
                </div>";


    /*This requires the function if we want to use it*/

// failureToExecute ($searchBoxQueryResult, 'S1', 'Select ');


    $numberOfSearchBoxRows = $searchBoxQueryResult->num_rows;

    if($numberOfSearchBoxRows == 0) {


        echo "
            <div class='container'>
                <div class='row'>
                    <div class='col'>
                        <div class='card' >
                        <div class='card-header'>Search Results</div>
                            <div class='card-body'>
                                
                                <h5>Bummer!</h5>
                                <div class='row'>
                                    <div class='col'>
                                        <h6>There were no Tickets found that matched your search: <strong>\" $searchBox \" </strong> .
                                         </h6>
                                        <h6>Click on a link in the nav bar to continue.</h6>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->

            ";
    }

    /* this begins the process for tickets being displayed in a table. */
    $ticketTables = "<div class='container'>
    <div class='row'>
        <div class='col-lg-12'>
            <div class='table-responsive-lg'>";

    for ($j = 0; $j < $numberOfSearchBoxRows; ++$j) {
        $row = $searchBoxQueryResult->fetch_array(MYSQLI_NUM);

        $ticketID = $row[0];
        $ticketName = $row[1];
        $ticketDescription = $row[2];
        $ticketCategoryID = $row[3];
        $ticketDate = date("l, F d, Y", strtotime($row[4]));
        $ticketTime = date("g:i a", strtotime($row[5]));
        $ticketStatusID = $row[6];
        $ticketPriorityID = $row[7];
        $ticketProjectID = $row[8];
        $statusName = $row[9];
        $priorityName = $row[10];
        $categoryName = $row[11];
        $ticketProjectName = $row[12];


        $ticketTables .= "<table class='table  table-bordered' style='width=100%;'>
                    <tbody>
                    <tr class='d-flex'>
                        <td  style='width:100%; background-color:lightgoldenrodyellow; border-radius:10px 10px
                            0px 0px;'></td>
                    </tr>
                    <tr class='d-flex'>
                        <td class='col-sm-2' colspan='2'>  $ticketID   </td>
                        <td class='col-sm-6' colspan='6'>   $ticketName  </td>
                        <td class='col-sm-4' colspan='4'>  $ticketDate </br> $ticketTime  </td>
                    </tr>
                    <tr class='d-flex'>
                        <td class='col-sm-12' colspan='12'>  $ticketDescription   </td>
                    </tr>
                    <tr class='d-flex'>
                        <td class='col-sm-2' colspan='2'> PRIORITY: $priorityName </td>
                        <td class='col-sm-2' colspan='2'> STATUS: $statusName </td>
                        <td class='col-sm-4' colspan='4'> PROJECT: $ticketProjectName </td>
                        <td class='col-sm-2' colspan='2' >CATEGORY: $categoryName</td>
                        <td class='col-sm-2' colspan='2' >
                            <form action='displayTicket.php' method='post' >
                                <button type='submit' class='btn siteButton'>View</button>
                                <input type='hidden' name='ticketID' value=$ticketID />
                            </form>
                        </td>
                        </td>
                    </tr>
                    <tr class='d-flex'>
                        <td  class='col-sm-12' colspan='12' style='background-color:lightgoldenrodyellow;
                            border-radius:0px 0px
                            10px 10px;'></td>
                    </tr>
                    </tbody>
                </table>";







/*Looks like my changes are working. Holding on to this for a bit.*/
//        $ticketTables .= "<table class='table table-bordered style='width:100%;'>
//        <tbody>
//            <tr class='d-flex'>
//                <td  style='width:100%; background-color:lightgoldenrodyellow; border-radius:10px 10px
//                            0px 0px;'></td>
//            </tr>
//            <tr class='d-flex'>
//                <td class='row-A'>  $ticketID  </td>
//                <td colspan='4'>  $ticketName  </td>
//                <td>  $ticketDate </br> $ticketTime  </td>
//            </tr>
//            <tr class='d-flex'>
//                <td colspan='6'>  $ticketDescription   </td>
//            </tr>
//            <tr class='d-flex'>
//                <td> PRIORITY: $priorityName </td>
//                    <td> STATUS: $statusName </td>
//                    <td colspan='2'> What is this?  </td>
//                    <td>CATEGORY: $categoryName</td>
//                <td>
//                    <form action='displayTicket.php' method='post' >
//                                    <input type='submit' class='btn' value='View' />
//                                    <input type='hidden' name='ticketID' value=$ticketID />
//                    </form>
//                </td>
//            </tr>
//        </tbody>
//    </table><br/><br/>";







    }    /*forloop ending*/

    $ticketTables .= "</div>";


    ?>
    <div>
        <?php echo $ticketTables; ?>
    </div>


    <?php
}else{
    /*Thinking this in no longer needed*/
    echo "No tickets were found using " . "\"" . $searchBox . "\""  ;
}


include 'endingBoilerPlate.php';

