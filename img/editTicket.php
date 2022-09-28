<?php

include 'boilerPlate.php';

if($debug) {
    $debug_string .= "editTicket.php<br/><br/>";
}

$ticketID = "";
$categoryLink = "";
$priorityLink = "";
$statusLink = "";
$editTicket = "";



if(isset($_REQUEST['ticketID'])) {
    $ticketID = $_REQUEST['ticketID'];
}

if(isset($_REQUEST['editTicket'])) {
    $editTicket = $_REQUEST['editTicket'];
    $sendEditTicket = "<input type='hidden' name='editTicket' value='true'> ";
}





if(isset($_REQUEST['statusLink'])) {


    echo <<<_END



<div class="container">
    <div class="row">
        <div class="col">
            <div class="card" >
                <div class="card-header">Search Status</div>
                <div class="card-body">
                    
                   
                            <form action='displayTicket.php' id="task-form" method='post'>
                                <div class="form-group">
                                     
                                     <select name="status" id="status" class="form-control">
                                         <option value="" disabled selected>Search for Status</option>
                                         <option value="1" <?php if ($status == "1") {echo("selected");} 
                                         ?>New</option>
                                         <option value="2" <?php if ($status == "2") {echo("selected");} 
                                         ?>Open</option>
                                         <option value="3" <?php if ($status == "3") {echo("selected");} 
                                         ?>Closed</option>
                                         <option value="4" <?php if ($status == "4") {echo("selected");} ?>On 
                                         Hold</option>
                                         <option value="5" <?php if ($status == "5") {echo("selected");} 
                                         ?>Saved</option>
                                     </select>
                                </div>
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button group">
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                       <input type="submit"  value="Submit New Status" class="btn siteButton searchStatus"/>
                                       <input type="hidden" name="editStatus" value="true" />
                                       <input type="hidden" name="ticketID" value="$ticketID" />
                                       
                                    </div>
                                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                                        <button class="btn siteButton addTicketButtons" onclick="goBack()" type="button"
                                        >Cancel</button>
                                    </div>
                                </div>
                            </form>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
</div><!--end container-->



_END;

} elseif(isset($_REQUEST['priorityLink'])) {


    echo <<<_END



<div class="container">
    <div class="row">
        <div class="col">
            <div class="card" >
                <div class="card-header">Search Priority</div>
                <div class="card-body">

                            <form action='displayTicket.php' id="task-form" method='post'>
                                <div class="form-group">
                                     
                                    <select name="priority" id="priority" class="form-control">
                                         <option value="" disabled selected>Ticket Priority</option>
                                         <option value="1" <?php if ($priority == "1") {echo("selected");} 
                                         ?>Low</option>
                                         <option value="2" <?php if ($priority == "2") {echo("selected");} 
                                         ?>Medium</option>
                                         <option value="3" <?php if ($priority == "3") {echo("selected");} 
                                         ?>High</option>
                                         <option value="4" <?php if ($priority == "4") {echo("selected");} 
                                         ?>URGENT</option>
                                     </select>                                    
                                </div>
                                
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button group">
                                   <div class="btn-group mr-2" role="group" aria-label="First group">
                                       <input type="submit"  value="Submit New Priority" class="btn 
                                       siteButton searchPriority"/>
                                       <input type="hidden" name="editPriority" value="true" />
                                       <input type="hidden" name="ticketID" value="$ticketID" />
                                    </div>
                                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                                        <button class="btn siteButton addTicketButtons" onclick="goBack()" type="button"
                                        >Cancel</button>
                                    </div>
                                </div>
                            </form>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
</div><!--end container-->



_END;

} elseif(isset($_REQUEST['categoryLink'])) {

/*searching the db for current categories and looping them into <select> <options>*/

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


            $categoryOptionRows .= "<option value='$categoryID'>$categoryName</option>";
        }
    }



    echo <<<_END



<div class="container">
    <div class="row">
        <div class="col">
            <div class="card" >
                <div class="card-header">Search Category</div>
                <div class="card-body">

                            <form action='displayTicket.php' id="task-form-category" method='post'>
                                <div class="form-group">
                                     <select class="form-control"  name="category" id="category">
                                        <option value=""  disabled selected >Ticket Category</option>
                                       $categoryOptionRows
                                    </select>
                                </div>
                                
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button group">
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                       <input type="submit"  name='existingCategory' value="Submit New Category Choice" 
                                       class="btn siteButton 
                                       searchCategory"/>
                                       <input type="hidden" name="editCategory" value="true" />
                                       <input type="hidden" name="ticketID" value="$ticketID" />
                                       <input type="hidden" name="editTicket" value="true" />
                                       $sendEditTicket 
                                    </div>

                                    <!--Adding some javascript to change the action of this button.  -->
                                     <div class="btn-group mr-2" role="group" aria-label="Second group">
                                       <input type="submit"  name='brandNewCategory' id='brandNewCategory' value="Add New Category" 
                                       class="btn siteButton 
                                       searchCategory"/>  
                                       
                                    </div>
                                    <div>
                                    <button class="btn siteButton addTicketButtons" onclick="goBack()" type="button"
                                    >Cancel</button>
                                </div>
                                </div>
                            </form></br>
                            
                                 <div>
                                    <button class="btn siteButton addTicketButtons" onclick="goBack()" type="button"
                                    >Cancel</button>
                                </div>
                        
                 TODO 
                  <!--I am leaving the second cancel button because at one time I believed it had to be outside of 
                  the form to work properly. And to keep the other buttons working properly this is yet to be 
                  discovered.
                  
                  In addition the addNewCategory button still takes us back to display Ticket since it is inside that
                   form. There is work to be done here for sure.
                   -->
                   
                   
                     
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
</div><!--end container-->



_END;



}



include 'endingBoilerPlate.php';
?>