<?php


include 'boilerPlate.php';


if($debug) {
    $debug_string .= "addComment.php<br/>";
}

$ticketID = "";
$addComment = "";
$commentLinkText = "";
$addCommentSubmit = "";
$ticketID = "";
$comment = "";




if(isset($_REQUEST['addComment'])) {
    $addComment = $_REQUEST['addComment'];
}

if(isset($_REQUEST['ticketID'])) {
    $ticketID = $_REQUEST['ticketID'];
}

if(isset($_REQUEST['addCommentSubmit'])) {
    $addCommentSubmit = $_REQUEST['addCommentSubmit'];
}

if(isset($_REQUEST['comment'])) {
    $comment = $_REQUEST['comment'];
}


if($addCommentSubmit) {
    /*validate user info*/

    $washPostVar = test_input($ticketID);
    $ticketID = strip_before_insert($conn, $washPostVar);

    $washPostVar = test_input($comment);
    $comment = strip_before_insert($conn, $washPostVar);


    $commentInsertQuery = "INSERT INTO comment(comment_ticket_ID, comment_date, comment_time, comment_body)
        VALUES ('$ticketID', CURDATE(), CURTIME(), '$comment')";

    /*Send the query to the database*/
    $commentInsertQueryResult = $conn->query($commentInsertQuery);
    if ($debug) {
        $debugString .= "\ncommentInsertQuery= " . $commentInsertQuery . "\n<br/>";

        if (!$commentInsertQueryResult) {
            $queryError = "\n Error description: commentInsertQuery: " . mysqli_error($conn) . "\n<br/>";
            outputError($queryError);
        }
    }/*End if debug*/
    }

    if ($commentInsertQueryResult) {

        header('Location: displayTicket.php?editComment=true&commentExists=true&ticketID=' . $ticketID );
        exit();
    }

include 'nav.php';

if($addComment) {
       ?>
       <!-- html for Add Comment Form -->
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


       <?php
   }  /*end if($addComment)*/
   

   
include 'endingBoilerPlate.php';