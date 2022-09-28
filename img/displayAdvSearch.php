<?php



include 'boilerPlate.php';
include 'nav.php';

if($debug) {
    $debug_string .= "displayAdvSearch.php<br/>";
}

$category = "";
$status = "";
$priority = "";
$project = "";
$ticketDate = "";
$idNum = "";
$remaining = "";
$statusType = "";
$priorityType = "";
$projectType = "";
$categoryType = "";
$currentProjectName = "";
$currentProjectID = "";
    


$statusQuery = "";
$priorityQuery = "";
$projectQuery = "";
$categoryQuery = "";
$idNumQuery = "";
$ticketDateQuery = "";
$remainingQuery = "";
$from_date = "";
$to_date = "";

//sets variable for current project ID to be used in query later
$currentProjectID = $_SESSION['projectID'];



//creating local variables

if(isset($_REQUEST['category'])) {
    $category = $_REQUEST['category'];
}

if(isset($_REQUEST['status'])) {
    $status = $_REQUEST['status'];
}

if(isset($_REQUEST['priority'])) {
    $priority = $_REQUEST['priority'];
}

if(isset($_REQUEST['project'])) {
    $project = $_REQUEST['project'];
}

if(isset($_REQUEST['remaining'])) {
    $remaining = $_REQUEST['remaining'];
}

if(isset($_REQUEST['ticketDate'])) {
   $ticketDate = $_REQUEST['ticketDate'];
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



if(isset($_SESSION))




//STATUS CODE

if($status !== "" AND is_numeric($status)) {

    /*Sanitize variable before using in db query*/

    $washPostVar = test_input($status);
    $status = strip_before_insert($conn, $washPostVar);

    /*Query that matches the name of the status type to use later in our "Bummer" code*/
    $statusNameQuery = "SELECT status_name From status WHERE ID = '$status' ";


        $statusNameQueryResult = $conn->query($statusNameQuery);

        if ($debug) {
            $debug_string .= 'statusNameQuery = ' . $statusNameQuery . '<br/><br/>';
            if (!$statusNameQueryResult) {
                $queryError = "\n Error description: statusNameQuery: " . mysqli_error($conn) . "\n<br/>";
                outputError($queryError);
            }
        }/*end debug*/


        if ($statusNameQueryResult) {

            $numberOfStatusNameRows = $statusNameQueryResult->num_rows;


            for ($j = 0; $j < $numberOfStatusNameRows; ++$j) {
                $row = $statusNameQueryResult->fetch_array(MYSQLI_NUM);

                $statusType = $row[0];

            }/*end of loop*/
        }





/*STATUS CODE*/

        /*Query that finds every ticket that has the option from the status drop-down*/
        $statusQuery = " SELECT t.ID, t.name, t.description, t.category_ID, t.date, t.ticket_time, t.status_ID, t.priority_ID, t.project_ID, cat.category_name, p.priority_name, s.status_name, proj.project_name
    FROM ticket AS t
    LEFT JOIN status AS s ON s.ID = t.status_ID
    LEFT JOIN category AS cat ON t.category_ID = cat.ID
    LEFT JOIN priority AS p ON p.ID = t.priority_ID
    LEFT JOIN project AS proj ON proj.ID = t.project_ID
    WHERE t.project_ID = $currentProjectID
    AND t.status_ID = '$status' 
    ORDER BY date DESC, ticket_time DESC
    ";


        $statusQueryResult = $conn->query($statusQuery);


        if ($debug) {
            $debug_string .= 'statusQuery = ' . $statusQuery . '<br/><br/>';
            if (!$statusQueryResult) {
                $queryError = "\n Error description: statusQuery: " . mysqli_error($conn) . "\n<br/>";
                outputError($queryError);
            }
        }/*end debug*/

        if ($statusQueryResult) {


            /*This requires the function if we want to use it*/

            // failureToExecute ($statusQueryResult, 'S1', 'Select ');

                echo "<div class='container'>
                    <div class='row'>
                        <div class='col'>                                                    
                            <h6 class='p-4'>You searched for Tickets with the Status of \"$statusType\" in the $activeProject project. </h6>       
                        </div>
                    </div>
                </div></br>";





            $numberOfStatusRows = $statusQueryResult->num_rows;

            if ($numberOfStatusRows == 0) {


                echo "
            <div class='container '>
                <div class='row'>
                    <div class='col'>                               
                        <div class='card' >
                            <div class='card-header'>Search Results</div>
                            <div class='card-body'>
                                <h5 class='card-title'>Bummer!</h5>
                                <div class='row'>
                                    <div class='col'>                                   
                                        <h6>There were no Tickets found with the status of $statusType in the $activeProject project.</h6>
                                        <h6>Click on a link in the nav bar to continue.</h6> 
                                    </div> <!--end col-->
                                </div><!--end row-->
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

            for ($j = 0; $j < $numberOfStatusRows; ++$j) {
                $row = $statusQueryResult->fetch_array(MYSQLI_NUM);

                $ticketID = $row[0];
                $ticketName = $row[1];
                $ticketDescription = $row[2];
                $ticketCategory = $row[3];
                $ticketDate = date("l, F d, Y", strtotime($row[4]));
                $ticketTime = date("g:i a", strtotime($row[5]));
                $ticketStatus = $row[6];
                $ticketPriority = $row[7];
                $ticketProjectID = $row[8];
                $categoryName = $row[9];
                $priorityName = $row[10];
                $statusName = $row[11];
                $ticketProjectName = $row[12];


                $ticketTables .= "
            
               <table class='table  table-bordered' style='width=100%'>
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
                            <td class='col-sm-2' colspan='2'> PRIORITY: &nbsp&nbsp $priorityName </td>
                            <td class='col-sm-2' colspan='2'> STATUS: &nbsp&nbsp $statusName </td>
                            <td class='col-sm-4' colspan='4'> PROJECT: &nbsp&nbsp $ticketProjectName </td>
                            <td class='col-sm-2' colspan='2' >CATEGORY: &nbsp&nbsp $categoryName</td>
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


            }    /*forloop ending*/



            $ticketTables .= "</div>
        </div>
</div>
</div>  </br></br></br></br>";

echo $ticketTables;

        }/*end if($statusQueryResult)*/










/*PRIORITY CODE*/



}else if($priority !== "" AND is_numeric($priority)) {
    /*Sanitize variable before using in db query*/

    $washPostVar = test_input($priority);
    $priority = strip_before_insert($conn, $washPostVar);

    /*Query that matches the name of the priority type to use later in our "Bummer" code*/
    $priorityNameQuery = "SELECT priority_name From priority WHERE ID = '$priority' ";


    $priorityNameQueryResult = $conn->query($priorityNameQuery);

    if ($debug) {
        $debug_string .= 'priorityNameQuery = ' . $priorityNameQuery . '<br/><br/>';
        if (!$priorityNameQueryResult) {
            $queryError = "\n Error description: priorityNameQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*end debug*/


    if ($priorityNameQueryResult) {



        $numberOfPriorityNameRows = $priorityNameQueryResult->num_rows;


        for ($j = 0; $j < $numberOfPriorityNameRows; ++$j) {
            $row = $priorityNameQueryResult->fetch_array(MYSQLI_NUM);

            $priorityType = $row[0];

        }/*end of loop*/
    }


    /*Query that finds every ticket that has the option from the priority drop-down*/
    $priorityQuery = " SELECT t.ID, t.name, t.description, t.category_ID, t.date, t.ticket_time, t.status_ID, t.priority_ID, t.project_ID, c.category_name, p.priority_name, s.status_name, proj.project_name
    FROM ticket AS t
    LEFT JOIN status AS s ON s.ID = t.status_ID
    LEFT JOIN category AS c ON t.category_ID = c.ID
    LEFT JOIN priority AS p ON p.ID = t.priority_ID
    LEFT JOIN project AS proj ON proj.ID = t.project_ID
    WHERE t.project_ID = $currentProjectID
    AND priority_ID = '$priority' 
    ORDER BY date DESC, ticket_time DESC
    ";


    $priorityQueryResult = $conn->query($priorityQuery);


    if ($debug) {
        $debug_string .= 'priorityQuery = ' . $priorityQuery . '<br/><br/>';
        if (!$priorityQueryResult) {
            $queryError = "\n Error description: priorityQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*end debug*/

    if ($priorityQueryResult) {
        echo "<div class='container'>
                    <div class='row'>
                        <div class='col'>                                                    
                            <h6 class='p-4'>You searched for Tickets with the Priority of \"$priorityType\" in the $activeProject project. </h6>       
                        </div>
                    </div>
                </div></br>";

        /*This requires the function if we want to use it*/

        // failureToExecute ($priorityQueryResult, 'S1', 'Select ');


        $numberOfPriorityRows = $priorityQueryResult->num_rows;


        if ($numberOfPriorityRows == 0) {


            echo "
            <div class='container '>
                <div class='row'>
                    <div class='col'>                        
                        <div class='card' >
                            <div class='card-header'>Search Results</div>
                                <div class='card-body'>
                                <h5>Bummer!</h5>
                                <div class='row'>
                                    <div class='col'>
                                        <h6>There were no Tickets found with the priority of $priorityType in the $activeProject project.</h6>
                                        <h6>Click on a link in the nav bar to continue.</h6>   
                                    </div> <!--end col-->
                                </div><!--end row-->
                            </div><!--end card-body-->
                        </div> <!--end card-->
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

        for ($j = 0; $j < $numberOfPriorityRows; ++$j) {
            $row = $priorityQueryResult->fetch_array(MYSQLI_NUM);

            $ticketID = $row[0];
            $ticketName = $row[1];
            $ticketDescription = $row[2];
            $ticketCategory = $row[3];
            $ticketDate = date("l, F d, Y", strtotime($row[4]));
            $ticketTime = date("g:i a", strtotime($row[5]));
            $ticketStatus = $row[6];
            $ticketPriority = $row[7];
            $ticketProjectID = $row[8];
            $categoryName = $row[9];
            $priorityName = $row[10];
            $statusName = $row[11];
            $ticketProjectName = $row[12];


            $ticketTables .= "<table class='table  table-bordered' style='width=100%'>
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
                        <td class='col-sm-2' colspan='2'> PRIORITY: &nbsp&nbsp $priorityName </td>
                        <td class='col-sm-2' colspan='2'> STATUS: &nbsp&nbsp $statusName </td>
                        <td class='col-sm-4' colspan='4'> PROJECT: &nbsp&nbsp $ticketProjectName </td>
                        <td class='col-sm-2' colspan='2' >CATEGORY: &nbsp&nbsp $categoryName</td>
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

        }    /*forloop ending*/

        $ticketTables .= "</div>
        </div>
    </div>
</div>  </br></br></br></br>";



            echo $ticketTables;

    }/*end if ($priorityQueryResult)*/



/*PROJECT CODE*/
//Might not be using this anymore. Seems that it didn't make sense to search for all tickets in a project. //Might re-visit. Doesn't currently have a link on the nav under advanced search.

}else if($project !== "" AND is_numeric($project)) {
    /*Sanitize variable before using in db query*/

    $washPostVar = test_input($project);
    $project = strip_before_insert($conn, $washPostVar);

    /*Query that matches the name of the project type to use later in our "Bummer" code*/
    $projectNameQuery = "SELECT project_name From project WHERE ID = '$project' ";


    $projectNameQueryResult = $conn->query($projectNameQuery);

    if ($debug) {
        $debug_string .= 'projectNameQuery = ' . $projectNameQuery . '<br/><br/>';
        if (!$projectNameQueryResult) {
            $queryError = "\n Error description: projectNameQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*end debug*/


    if ($projectNameQueryResult) {



        $numberOfProjectNameRows = $projectNameQueryResult->num_rows;


        for ($j = 0; $j < $numberOfProjectNameRows; ++$j) {
            $row = $projectNameQueryResult->fetch_array(MYSQLI_NUM);

            $projectType = $row[0];

        }/*end of loop*/
    }


    /*Query that finds every ticket that has the option from the project drop-down*/
    $projectQuery = " SELECT t.ID, t.name, t.description, t.category_ID, t.date, t.ticket_time, t.status_ID, t.priority_ID, t.project_ID, c.category_name, p.priority_name, proj.project_name, s.status_name, proj.project_name
    FROM ticket AS t
    LEFT JOIN status AS s ON s.ID = t.status_ID
    LEFT JOIN category AS c ON t.category_ID = c.ID
    LEFT JOIN priority AS p ON p.ID = t.priority_ID
    LEFT JOIN project AS proj ON proj.ID = t.project_ID
    WHERE project_ID = '$project' 
    ORDER BY date DESC, ticket_time DESC
    ";


    $projectQueryResult = $conn->query($projectQuery);


    if ($debug) {
        $debug_string .= 'projectQuery = ' . $projectQuery . '<br/><br/>';
        if (!$projectQueryResult) {
            $queryError = "\n Error description: projectQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*end debug*/

    if ($projectQueryResult) {
        echo "<div class='container'>
                    <div class='row'>
                        <div class='col'>                                                    
                            <h6 class='p-4'>You searched for Tickets with the Project Name of \"$projectType\" in the $activeProject project. </h6>       
                        </div>
                    </div>
                </div></br>";

        /*This requires the function if we want to use it*/

        // failureToExecute ($projectQueryResult, 'S1', 'Select ');


        $numberOfProjectRows = $projectQueryResult->num_rows;


        if ($numberOfProjectRows == 0) {


            echo "
            <div class='container '>
                <div class='row'>
                    <div class='col'>                        
                        <div class='card' >
                            <div class='card-header'>Search Results</div>
                                <div class='card-body'>
                                <h5>Bummer!</h5>
                                <div class='row'>
                                    <div class='col'>
                                        <h6>There were no Tickets found with the Project Name of $projectType in the $activeProject project.</h6>
                                        <h6>Click on a link in the nav bar to continue.</h6>   
                                    </div> <!--end col-->
                                </div><!--end row-->
                            </div><!--end card-body-->
                        </div> <!--end card-->
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

        for ($j = 0; $j < $numberOfProjectRows; ++$j) {
            $row = $projectQueryResult->fetch_array(MYSQLI_NUM);

            $ticketID = $row[0];
            $ticketName = $row[1];
            $ticketDescription = $row[2];
            $ticketCategory = $row[3];
            $ticketDate = date("l, F d, Y", strtotime($row[4]));
            $ticketTime = date("g:i a", strtotime($row[5]));
            $ticketStatus = $row[6];
            $ticketPriority = $row[7];
            $ticketProject = $row[8];
            $categoryName = $row[9];
            $priorityName = $row[10];
            $statusName = $row[11];
            $ticketProjectName = $row[12];


            $ticketTables .= "<table class='table  table-bordered' style='width=100%'>
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
                        <td class='col-sm-2' colspan='2'> PRIORITY: &nbsp&nbsp $priorityName </td>
                        <td class='col-sm-2' colspan='2'> STATUS: &nbsp&nbsp $statusName </td>
                        <td class='col-sm-4' colspan='4'> PROJECT: &nbsp&nbsp $ticketProjectName </td>
                        <td class='col-sm-2' colspan='2' >CATEGORY: &nbsp&nbsp $categoryName</td>
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

        }    /*forloop ending*/

        $ticketTables .= "</div>
        </div>
    </div>
</div>  </br></br></br></br>";


if($debug){
    $debug_string .= $ticketTables;
}

    }/*end if ($projectQueryResult)*/










//REMAINING CODE
}elseif($remaining == 'true' ) {

        /*Sanitize variable before using in db query*/

        $washPostVar = test_input($remaining);
        $remaining = strip_before_insert($conn, $washPostVar);

        /*Query that matches the name of the status type to use later in our "Bummer" code*/
        $remainingQuery = "SELECT t.ID, t.name, t.description, t.date, t.status_ID, t.ticket_time, t.project_ID, p.priority_name, s.status_name, cat.category_name, proj.project_name 
FROM ticket AS t
LEFT JOIN priority AS p ON t.priority_ID = p.ID
LEFT JOIN status AS s ON t.status_ID = s.ID
LEFT JOIN category AS cat ON t.category_ID = cat.ID
LEFT JOIN project AS proj ON proj.ID = t.project_ID
WHERE t.project_ID = $currentProjectID
AND t.status_ID != 3
 ORDER BY t.date ASC";


        $remainingQueryResult = $conn->query($remainingQuery);

        if ($debug) {
            $debug_string .= 'remainingQuery = ' . $remainingQuery . '<br/><br/>';
            if (!$remainingQueryResult) {
                $queryError = "\n Error description remainingQuery: " . mysqli_error($conn) . "\n<br/>";
                outputError($queryError);
            }
        }/*end debug*/




        if ($remainingQueryResult) {
            echo "<div class='container'>
                    <div class='row'>
                        <div class='col'>                                                    
                            <h6 class='p-4'>You searched for All remaining Tickets. This includes all tickets that have not been closed or archived that belong to the $activeProject project. </h6>       
                        </div>
                    </div>
                </div></br>";

            /*This requires the function if we want to use it*/

            // failureToExecute ($statusQueryResult, 'S1', 'Select ');


            $numberOfRemainingRows = $remainingQueryResult->num_rows;

            if ($numberOfRemainingRows == 0) {


                echo "
            <div class='container 
            '>
                <div class='row'>
                    <div class='col'>
                       
                        <div class='card' >
                            <div class='card-header'>Search Results</div>
                            <div class='card-body'>
                                <h5>Bummer!</h5>
                                <div class='row'>
                                    <div class='col'>
                                        <h6>There were no more Remaining Tickets Found in the $activeProject project.</h6>
                                        <h6>Click on a link in the nav bar to continue.</h6>   
                                    </div> <!--end col-->
                                </div><!--end row-->
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

            for ($j = 0; $j < $numberOfRemainingRows; ++$j) {
                $row = $remainingQueryResult->fetch_array(MYSQLI_NUM);

                $ticketID = $row[0];
                $ticketName = $row[1];
                $ticketDescription = $row[2];
                $ticketDate = date("l, F d, Y", strtotime($row[3]));
                $ticketStatusID = $row[4];
                $ticketTime = date("g:i a", strtotime($row[5]));
                $ticketProjectID = $row[6];
                $priorityName = $row[7];
                $statusName = $row[8];
                $categoryName = $row[9];
                $ticketProjectName = $row[10];
           ;


                $ticketTables .= "
            
               <table class='table  table-bordered' style='width=100%'>
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
                        <td class='col-sm-2' colspan='2'> PRIORITY: &nbsp&nbsp $priorityName </td>
                        <td class='col-sm-2' colspan='2'> STATUS: &nbsp&nbsp $statusName </td>
                        <td class='col-sm-4' colspan='4'> PROJECT: &nbsp&nbsp $ticketProjectName</td>
                        <td class='col-sm-2' colspan='2' >CATEGORY: &nbsp&nbsp $categoryName</td>
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


            }    /*forloop ending*/



            $ticketTables .= "</div>
        </div>
    </div>
</div>  </br></br></br></br>";

            echo $ticketTables;



    }/*end remainingQueryResult*/











/*id Number code*/

}elseif($idNum !== "") {
/*validate that $idNum is a number then wash that number before it is used to query the db*/
    if(is_numeric($idNum)) {

        /*wash variable before using in DB query*/
        $washPostVar = test_input($idNum);
        $idNum = strip_before_insert($conn, $washPostVar);


       

        /*Query that finds every ticket that has the option from the priority drop-down*/
        $idNumQuery = "  SELECT t.ID, t.name, t.description, t.category_ID, t.date, t.ticket_time, t.status_ID, t.priority_ID, t.project_ID, c.category_name, p.priority_name, s.status_name, proj.project_name
    FROM ticket AS t
    LEFT JOIN status AS s ON s.ID = t.status_ID
    LEFT JOIN category AS c ON t.category_ID = c.ID
    LEFT JOIN priority AS p ON p.ID = t.priority_ID
    LEFT JOIN project AS proj ON proj.ID = t.project_ID
    WHERE t.project_ID = $currentProjectID
    AND t.ID = '$idNum' 
    ORDER BY date DESC, ticket_time DESC
    ";


        $idNumQueryResult = $conn->query($idNumQuery);


        if($debug) {
            $debug_string .= 'idNumQuery = ' . $idNumQuery . '<br/><br/>';
            if (!$idNumQueryResult) {
                $queryError = "\n Error description: idNumQuery: " . mysqli_error($conn) . "\n<br/>";
                outputError($queryError);
            }
        }/*end debug*/

       if ($idNumQueryResult) {
           echo "<div class='container'>
                    <div class='row'>
                        <div class='col'>                                                    
                            <h6 class='p-4'>You searched for Tickets with the ID NUMBER of \"$idNum\" in the $activeProject project.</h6>       
                        </div>
                    </div>
                </div></br>";

            /*This requires the function if we want to use it*/

            // failureToExecute ($idNumQueryResult, 'S1', 'Select ');


            $numberOfIdNumRows = $idNumQueryResult->num_rows;

           if ($numberOfIdNumRows == 0) {
               echo "
            <div class='container '>
                <div class='row'>
                    <div class='col'>
                        
                        <div class='card' >                           
                            <div class='card-header'>Search Results</div>
                            <div class='card-body'>
                                <h5>Bummer!</h5>
                                <div class='row'>
                                    <div class='col'>
                                        <h6>There were no Tickets found with the ID Number of \"$idNum\"  in the $activeProject project.</h6>
                                        <h6>Click on a link in the nav bar to continue.</h6>
                                    </div> <!--end col-->
                                </div><!--end row-->
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container--> ";
           }

               /* this begins the process for tickets being displayed in a table. */
           $ticketTables = "<div class='container'>
                        <div class='row'>
                            <div class='col-lg-12'>
                                <div class='table-responsive-lg'>";

            for ($j = 0; $j < $numberOfIdNumRows; ++$j) {
                $row = $idNumQueryResult->fetch_array(MYSQLI_NUM);

                $ticketID = $row[0];
                $ticketName = $row[1];
                $ticketDescription = $row[2];
                $ticketCategory = $row[3];
                $ticketDate = date("l, F d, Y", strtotime($row[4]));
                $ticketTime = date("g:i a", strtotime($row[5]));
                $ticketStatus = $row[6];
                $ticketPriority = $row[7];
                $ticketProjectID = $row[8];
                $categoryName = $row[9];
                $priorityName = $row[10];
                $statusName = $row[11];
                $ticketProjectName = $row[12];


                $ticketTables .= "<table class='table  table-bordered' style='width=100%'>
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
                        <td class='col-sm-2' colspan='2'> PRIORITY: &nbsp&nbsp $priorityName </td>
                        <td class='col-sm-2' colspan='2'> STATUS: &nbsp&nbsp $statusName </td>
                        <td class='col-sm-4' colspan='4'> PROJECT: &nbsp&nbsp $ticketProjectName </td>
                        <td class='col-sm-2' colspan='2' >CATEGORY: &nbsp&nbsp $categoryName</td>
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

            }    /*forloop ending*/

            $ticketTables .= "</div>
        </div>
    </div>
</div>  </br></br></br></br>";

if($debug){
     $debug_string .= $ticketTables;
}
              


        }/*end if ($idNumQueryResult)*/
    }/*End if(is_numeric($idNum))*/












    /*DATE code*/

}elseif($ticketDate !== "") {
/*validate fromdate and todate*/

    if (validateDate($from_date) && validateDate($to_date)) {



        /*Don't need to sanitize because validateDate() made sure these variables were dates.*/

        /*Query that finds every ticket that has the option from the priority drop-down*/
        $ticketDateQuery = "  SELECT t.ID, t.name, t.description, t.category_ID, t.date, t.ticket_time, t.status_ID, t.priority_ID, t.project_ID, c.category_name, p.priority_name, s.status_name, proj.project_name
    FROM ticket AS t
    LEFT JOIN status AS s ON s.ID = t.status_ID
    LEFT JOIN category AS c ON t.category_ID = c.ID
    LEFT JOIN priority AS p ON p.ID = t.priority_ID
    LEFT JOIN project AS proj ON proj.ID = t.project_ID
    WHERE t.project_ID = $currentProjectID
    AND t.date BETWEEN '$from_date' AND '$to_date' 
    ORDER BY t.ID DESC
    ";

        /*Probably want to order by date instead of id*/
        /*This seems to be the problem. I am getting zero rows back*/

        $ticketDateQueryResult = $conn->query($ticketDateQuery);


        if ($debug) {
            $debug_string .= 'ticketDateQuery = ' . $ticketDateQuery . '<br/><br/>';
            if (!$ticketDateQueryResult) {
                $queryError = "\n Error description: ticketDateQuery: " . mysqli_error($conn) . "\n<br/>";
                outputError($queryError);
            }
        }/*end debug*/




        if ($ticketDateQueryResult) {

            echo "<div class='container'>
                    <div class='row'>
                        <div class='col'>                                                    
                            <h6>You searched for Tickets from</h6>
                        <h6>" . date('l, F d, Y', strtotime($from_date)) . " &nbsp;&nbsp;  to &nbsp;&nbsp;   " . date
                ('l, F d, Y', strtotime
                ($to_date)) .  "in the $activeProject project.
                        </h6>     
                        </div>
                    </div>
                </div></br>";



            /*This requires the function if we want to use it*/

            // failureToExecute ($ticketDateQueryResult, 'S1', 'Select ');


            $numberOfDateRows = $ticketDateQueryResult->num_rows;

            if($numberOfDateRows == 0) {


                echo "
            <div class='container '>
                <div class='row'>
                    <div class='col'>
                        
                        <div class='card' >  
                            <div class='card-header'>Search Results</div>
                            <div class='card-body'>
                                <h5>Bummer!</h5>
                                <div class='row'>
                                    <div class='col'>
                                        <h6>There were no Tickets found for this date range  in the $activeProject project.</h6>
                                        <h6>Click on a link in the nav bar to continue.</h6>
                                           
                                    </div> <!--end col-->
                                </div><!--end row-->
                            </div><!--end card-body-->                            
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->";
            }

            /* this begins the process for tickets being displayed in a table. */
            $ticketTables = "<div class='container'>
                        <div class='row'>
                            <div class='col-lg-12'>
                                <div class='table-responsive-lg'>";

            for ($j = 0; $j < $numberOfDateRows; ++$j) {
                $row = $ticketDateQueryResult->fetch_array(MYSQLI_NUM);

                $ticketID = $row[0];
                $ticketName = $row[1];
                $ticketDescription = $row[2];
                $ticketCategory = $row[3];
                $ticketDate = date("l, F d, Y", strtotime($row[4]));
                $ticketTime = date("g:i a", strtotime($row[5]));
                $ticketStatus = $row[6];
                $ticketPriority = $row[7];
                $ticketProjectID = $row[8];
                $categoryName = $row[9];
                $priorityName = $row[10];
                $statusName = $row[11];
                $ticketProjectName = $row[12];


                $ticketTables .= "
        <table class='table  table-bordered' style='width=100%'>
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
                        <td class='col-sm-2' colspan='2'> PRIORITY: &nbsp&nbsp $priorityName </td>
                        <td class='col-sm-2' colspan='2'> STATUS: &nbsp&nbsp $statusName </td>
                        <td class='col-sm-4' colspan='4'> PROJECT: &nbsp&nbsp $ticketProjectName</td>
                        <td class='col-sm-2' colspan='2' >CATEGORY: &nbsp&nbsp $categoryName</td>
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


            }    /*forloop ending*/


            $ticketTables .= "</div>
        </div>
    </div>
</div>  </br></br></br></br>";

            if($debug){
                   $debug_string .= $ticketTables;
            }


        }/*end if ticket data query result*/
    }



     



 /*CATEGORY CODE*/


}else if($category !== "" AND is_numeric($category)) {

    /*Sanitize data before querying the db*/

    $washPostVar = test_input($category);
    $category = strip_before_insert($conn, $washPostVar);



    /*Query that matches the name of the category type to use later in our "Bummer" code*/
    $categoryNameQuery = "SELECT category_name From category WHERE ID = '$category' ";


    $categoryNameQueryResult = $conn->query($categoryNameQuery);

    if ($debug) {
        $debug_string .= 'categoryNameQuery = ' . $categoryNameQuery . '<br/><br/>';
        if (!$categoryNameQueryResult) {
            $queryError = "\n Error description: categoryNameQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*end debug*/


    if ($categoryNameQueryResult) {

        $numberOfCategoryNameRows = $categoryNameQueryResult->num_rows;


        for ($j = 0; $j < $numberOfCategoryNameRows; ++$j) {
            $row = $categoryNameQueryResult->fetch_array(MYSQLI_NUM);

            $categoryType = $row[0];

        }/*end of loop*/
    }
    

    /*Query that finds every ticket that has the option from the category drop-down AND belongs to the current project (based on the session projectID)*/
    $categoryQuery = " SELECT t.ID, t.name, t.description, t.category_ID, t.date, t.ticket_time, t.status_ID, t.priority_ID, t.project_ID, c.category_name, p.priority_name, s.status_name, proj.project_name
    FROM ticket AS t
    LEFT JOIN status AS s ON s.ID = t.status_ID
    LEFT JOIN category AS c ON t.category_ID = c.ID
    LEFT JOIN priority AS p ON p.ID = t.priority_ID
    LEFT JOIN project AS proj ON proj.ID = t.project_ID
    WHERE category_ID = '$category'
    AND t.project_ID = $currentProjectID 
    ORDER BY date DESC, ticket_time DESC
    ";


    $categoryQueryResult = $conn->query($categoryQuery);


    if ($debug) {
        $debug_string .= 'categoryQuery = ' . $categoryQuery . '<br/><br/>';
        if (!$categoryQueryResult) {
            $queryError = "\n Error description: categoryQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*end debug*/

    if ($categoryQueryResult) {
        echo "<div class='container'>
                    <div class='row'>
                        <div class='col'>                                                    
                            <h6 class='p-4'>You searched for Tickets with the Category of  \"$categoryType\" in the $activeProject project.</h6>       
                        </div>
                    </div>
                </div></br>";

        /*This requires the function if we want to use it*/

        // failureToExecute ($categoryQueryResult, 'S1', 'Select ');


        $numberOfCategoryRows = $categoryQueryResult->num_rows;

        if($numberOfCategoryRows == 0) {

/*Will there be a time where there is a category that has no connected tickets? Only possible if user is permitted to
 delete a ticket and the category is not deleted. We are currently archiving the tickets not deleting them. */
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
                                        <h6>There were no Tickets found with the Category of \"$categoryType\" in the $activeProject project.</h6>
                                        <h6>Click on a link in the nav bar to continue.</h6>
                                    </div> <!--end col-->
                                </div><!--end row-->
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


        for ($j = 0; $j < $numberOfCategoryRows; ++$j) {
            $row = $categoryQueryResult->fetch_array(MYSQLI_NUM);

            $ticketID = $row[0];
            $ticketName = $row[1];
            $ticketDescription = $row[2];
            $ticketCategory = $row[3];
            $ticketDate = date("l, F d, Y", strtotime($row[4]));
            $ticketTime = date("g:i a", strtotime($row[5]));
            $ticketStatus = $row[6];
            $ticketPriority = $row[7];
            $ticketProjectID = $row[8];
            $categoryName = $row[9];
            $priorityName = $row[10];
            $statusName = $row[11];
            $ticketProjectName = $row[12];


            $ticketTables .= "<table class='table  table-bordered' style='width=100%'>
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
                        <td class='col-sm-2' colspan='2'> PRIORITY: &nbsp&nbsp $priorityName </td>
                        <td class='col-sm-2' colspan='2'> STATUS: &nbsp&nbsp $statusName </td>
                        <td class='col-sm-4' colspan='4'> PROJECT: &nbsp&nbsp $ticketProjectName </td>
                        <td class='col-sm-2' colspan='2' >CATEGORY: &nbsp&nbsp $categoryName</td>
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

        }    /*forloop ending*/

        $ticketTables .= "</div>
        </div>
    </div>
</div>  </br></br></br></br>";

        echo $ticketTables;

    }/*end if category result*/
}/*end if($category !== "") */


include 'endingBoilerPlate.php';