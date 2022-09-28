<?php


include 'boilerPlate.php';

include 'nav.php';

if($debug) {
    echo "TRYIT.php";
}
?>
<?php
/*Registration Code*/
?>
/*Registration Code*/
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Create New Account</div>
                    <div class="card-body">
                        <form action="register.php" method="post">
                            <label for="firstName">First Name</label>
                            <input type="text" name="firstName" placeholder="First Name" id="firstName"
                                   required><br/><br/>
                            <label for="lastName">Last Name</label>
                            <input type="text" name="lastName" placeholder="Last Name" id="lastName"
                                   required><br/><br/>
                            <label for="username">User Name</label>
                            <input type="text" name="username" placeholder="User Name" id="username" required><br/><br/>
                            <label for="useremail">User Email</label>
                            <input type="email" name="useremail" placeholder="User Email" id="useremail"
                                   required><br/><br/>
                            <label for="password">Password</label>
                            <input type="password" name="password" placeholder="Password" id="password" required><br/><br/>
                            <input type="submit"  class="btn siteButton" value="Create Account">
                        </form>
                    </div> <!--end card-body-->
                </div> <!--end card-->
            </div> <!--end col-->
        </div> <!--end row-->
    </div> <!--end container-->




<?php
/*Styling the table on profile.php*/
?>



    <div class="container ticketTable">
        <div class="row">
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

/*Adding "You searched for on the successful search pages*/
?>

    $ticketTables = "<div class='container'>
    <div class='row'>
        <div class='col-lg-12'>
            <div class='table-responsive-lg'>";...


            ... for

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
                        <td class='col-sm-4' colspan='4'> </td>
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

                }    /*forloop ending*/

                $ticketTables .= "</div>
        </div>
    </div>
</div>  </br></br></br></br>";

    echo $ticketTables;





                <!-- html for Add Comment Form addComment.php -->
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Add Comment</div>
                    <div class="card-body">

                        <form action='addComment.php' name="addCommentForm" id="addCommentForm"
                              method='post'>

                            <div class="form-group">
                                           <textarea id="comment" class="form-control"
                                                     name="comment"><?php echo $commentLinkText ?>
                                           </textarea>
                                <label for="comment">Add Comment Here</label>
                            </div>


                            <div>
                                <input class="btn siteButton" name="addCommentSubmit" type='submit'
                                       value="Submit Comment"/>
                                <input type="hidden" name="ticketID" value=<?php echo $ticketID ?> />
                            </div>
                        </form>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->







    <!-- btn-toolbar and btn-group -->


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











    <div>

        <?php
        echo "<div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='table-responsive-lg'>
                                <h6 class='p-4'>You searched for Tickets with the Status of \"$statusType \". </h6>
                            </div>
                        </div>
                    </div>
                </div></br>";
        echo $ticketTables; ?>
    </div>





<?php






/*The Code I need to style the displayAdvSearch.php tables*/

?>
    $ticketTables = "<div class='container'>
                        <div class='row'>
                            <div class='col-lg-12'>
                                <div class='table-responsive-lg'>";

                for

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
                        <td class='col-sm-2' colspan='2'> PRIORITY: $priorityName </td>
                        <td class='col-sm-2' colspan='2'> STATUS: $statusName </td>
                        <td class='col-sm-4' colspan='4'> </td>
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


                }    /*forloop ending*/

                $ticketTables .= "</div>
        </div>
    </div>
</div>  </br></br></br></br>";

    ?>
    <div>
        <?php
        echo "<div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='table-responsive-lg'>
                                <h6 class='p-4'>You searched for All remaining Tickets. This includes all tickets that have not been closed or archived. </h6>
                            </div>
                        </div>
                    </div>
                </div></br>";
        echo $ticketTables; ?>
    </div>
<?php











    /*Bummer code*/
?>
    <div class='container bummer'>
        <div class='row'>
            <div class='col'>
                <h6>You searched for Tickets with the Category of $category</h6>
                <div class='card' >
                    <div class='card-header'>Search Results</div>

                    <div class='card-body'>

                        <h5>Bummer!</h5>
                        <div class='row'>
                            <div class='col'>
                                <h6>There were no Tickets found with the Category of $category.</h6>
                                <h6>Click on a link in the nav bar to continue.</h6>
                            </div> <!--end col-->
                        </div><!--end row-->

                    </div><!--end card-body-->

                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->

    <div class='container bummer'>
        <div class='row'>
            <div class='col'>
                <h6>You searched for All remaining Tickets. This includes all tickets that have not been closed or archived.</h6>
                <div class='card' >
                    <div class='card-header'>Search Results</div>
                    <h5>Bummer!</h5>
                    <div class='row'>
                        <div class='col'>
                            <h6>There were no more Remaining Tickets Found.</h6>
                            <h6>Click on a link in the nav bar to continue.</h6>
                        </div> <!--end col-->
                    </div><!--end row-->
                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->



    echo "
    <div class='container bummer'>
        <div class='row'>
            <div class='col'>
                <h6>You searched for Tickets with the ID Number of $status</h6>
                <div class='card' >
                    <div class='card-header'>Search Results</div>
                    <div class='card-body'>
                        <h5>Bummer!</h5>
                        <div class='row'>
                            <div class='col'>
                                <h6>There were no Tickets found with the status of $statusType.</h6>
                                <h6>Click on a link in the nav bar to continue.</h6>

                            </div> <!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body-->
                </div><!--end card-header-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
    </div><!--end container-->

    ";

    <div class='container bummer'>
        <div class='row'>
            <div class='col'>
                <h6>You searched for Tickets with the Priority of $priority</h6>
                <div class='card' >
                    <div class='card-header'>Search Results</div>
                    <div class='card-body'>
                        <h5>Bummer!</h5>
                        <div class='row'>
                            <div class='col'>
                                <h6>There were no Tickets found with the priority of $priorityType.</h6>
                                <h6>Click on a link in the nav bar to continue.</h6>
                            </div> <!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body-->
                </div> <!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->








<?php
/*advSearch.php the search box for advance searches*/
?>

    <div class="container">
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
/*This table is the result of searching by status*/
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive-lg">
                <table class='table  table-bordered' style="width=100%">
                    <tbody>
                        <tr class="d-flex">
                            <td  style="width:100%; background-color:lightgoldenrodyellow; border-radius:10px 10px
                            0px 0px;"></td>
                        </tr>
                        <tr class="d-flex">
                            <td class='col-sm-2' colspan='2'>  $ticketID   </td>
                            <td class='col-sm-6' colspan='6'>   $ticketName  </td>
                            <td class='col-sm-4' colspan='4'>  $ticketDate </br> $ticketTime  </td>
                        </tr>
                        <tr class="d-flex">
                            <td class='col-sm-12' colspan='12'>  $ticketDescription   </td>
                        </tr>
                        <tr class="d-flex">
                            <td class='col-sm-2' colspan='2'> PRIORITY: $priorityName </td>
                            <td class='col-sm-2' colspan='2'> STATUS: $statusName </td>
                            <td class='col-sm-4' colspan='4'> What is this?  </td>
                            <td class='col-sm-2' colspan='2' >CATEGORY: $categoryName</td>
                            <td class='col-sm-2' colspan='2' >
                                <form action='displayTicket.php' method='post' >
                                    <button type='submit' class='btn siteButton'>View</button>
                                    <input type='hidden' name='ticketID' value=$ticketID />
                                </form>
                            </td>
                            </td>
                        </tr>
                        <tr class="d-flex">
                            <td  class="col-sm-12" colspan='12' style=" background-color:lightgoldenrodyellow;
                            border-radius:0px 0px
                            10px 10px;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</div>
</div>  </br></br></br></br>

<?php



/*Sample table to play around with as I figure out what I want*/
/*advSearch.php status table*/
?>

    <div class="container">
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
                                   class="btn btn-info searchStatus"/>

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
    </br></br></br></br>

<?php

/*displayTicket.php table*/
?>

    <!--Bootstrap Table-->
    <div class="container ticketTable">
        <div class="row">

            <div class="">
                <table style="width:50%" class="table  table-bordered">
                    <caption>Edit Below</caption>
                    <tbody>
                    <tr >
                        <td colspan="2" style="background-color:lightgoldenrodyellow; border-radius:10px 10px 0px 0px;
"></td>

                    </tr>
                    <tr class="">
                        <td class="col-sm-2">CATEGORY: </td>
                        <td class="col-sm-2">
                            <a href="editTicket.php?categoryLink=true&editTicket=true&ticketID=<?php echo $dbTicketID
                            ?> "><?php echo
                                $categoryName  ?></a>
                        </td>


                    </tr>

                    <tr class="">
                        <td class="col-sm-2">PRIORITY: </td>
                        <td class="col-sm-2">
                            <a href="editTicket.php?priorityLink=true&editTicket=true&ticketID=<?php echo $dbTicketID ?>"><?php echo $priorityName
                                ?></a>
                        </td>


                    </tr>
                    <tr class="">
                        <td class="col-sm-2">STATUS: </td>
                        <td class="col-sm-2">
                            <a href="editTicket.php?statusLink=true&editTicket=true&ticketID=<?php echo $dbTicketID
                            ?>"><?php echo $statusName ?></a>
                        </td>

                    </tr>
                    <tr class="">
                        <td class="col-sm-2">COMMENT: </td>
                        <td class="col-sm-2">
                            <a href="addComment.php?addComment=true&editTicket=true&ticketID=<?php echo
                            $dbTicketID ?>"><?php echo $commentLinkText ?></a>
                        </td>

                    </tr>
                    </tbody>
                </table>
            </div><!--end column-->

            <div class="col-sm-9">
                <table class="table table-bordered" style="width=100%">
                    <tbody>
                    <tr class="d-flex">
                        <td style="width:25%"><?php echo $dbTicketID ?></td>
                        <td style="width:50%"><?php echo $ticketName ?></td>
                        <td style="width:25%"><?php echo $ticketDate . '<br/>' . $ticketTime ?></td>
                    </tr>
                    <tr class="d-flex">
                        <td class="col-sm-10" colspan="3" > <?php echo $ticketDesc ?></td>
                    </tr>
                    <tr class="d-flex">
                        <td class="col-sm-10" colspan="3"><?php echo $commentString ?></td>
                    </tr>
                    <tr class="d-flex">
                        <td class="col-sm-10"  colspan="3" style="background-color:lightgoldenrodyellow; border-radius:0px 0px 10px 10px;"</td>
                    </tr>
                    </tbody>
                </table>
            </div><!--end column-->
        </div><!--end row-->
    </div> <!--end container-->

<?php
/*Same table COMPARE CHANGES*/
/*displayTicket.php table*/
?>

    <!--Bootstrap Table-->
    <div class="container ticketTable">
        <div class="row">

            <div class="col-sm-3  table-responsive">

                <table style="width:100%" class="table  table-bordered">

                    <tbody>
                    <tr class="d-flex">
                        <td  style="width:100%; background-color:lightgoldenrodyellow; border-radius:10px 10px 0px 0px;
"></td>

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
                    <tr class="d-flex ">
                        <td  class="d-none d-sm-block" style="width:100%; background-color:lightgoldenrodyellow;
                        border-radius:0px 0px 10px
                        10px;
"</td>
                    </tr>
                    </tbody>
                </table>
            </div><!--end column-->

            <div class=" col-sm-9 table-responsive">
                <table class="table table-bordered" style="width=100%">
                    <tbody>
                    <tr class="d-flex">
                        <td  class="d-none d-sm-block" style="width:100%; background-color:lightgoldenrodyellow;
                        border-radius:10px 10px 0px
                        0px;
"</td>
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
            </div><!--end column-->
        </div><!--end row-->
    </div> <!--end container-->

<?php













/*Third Try*/
/*This seems to have fixed the ugly scrolling issue above. I changed everything to md instead of sm*/
?>

    <!--Bootstrap Table-->
    <div class="container ticketTable">
        <div class="row">

            <div class="col-md-3">
                <div class="table-responsive-md">

                    <table style="width:100%" class="table  table-bordered">

                        <tbody>
                        <tr class="d-flex">
                            <td  style="width:100%; background-color:lightgoldenrodyellow; border-radius:10px 10px 0px 0px;
    "></td>

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
                        <tr class="d-flex ">
                            <td  class="d-none d-md-block" style="width:100%; background-color:lightgoldenrodyellow;
                            border-radius:0px 0px 10px
                            10px;
    "</td>
                        </tr>
                        </tbody>
                    </table>
                </div><!--end table-responsive-->
            </div><!--end column-->

            <div class=" col-md-9">
                <div class="table-responsive-md">
                    <table class="table table-bordered" style="width=100%">
                        <tbody>
                        <tr class="d-flex">
                            <td  class="d-none d-md-block" style="width:100%; background-color:lightgoldenrodyellow;
                            border-radius:10px 10px 0px
                            0px;
    "</td>
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