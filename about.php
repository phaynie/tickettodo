<?php



include 'boilerPlate.php';
include 'nav.php';

if($debug) {
    $debug_string .= "About.php<br/><br/>";
}

?>

<div class="container">
    <div class="row">
        <div class="col">
    <div class="projIntro">
    <p><h2><strong>TicketToDo</strong><img src="img/ticketlogogreen.png" alt="logo" width="50" height="50"></h2> ...is a ticketing system that helps you organize your programming projects.</p>
    <p>Need a place to organize what still needs to be done? </p>
    <p><strong>WRITE IT DOWN</strong></p>
    <p>TicketToDo allows you to create a project and add "Tickets" for each new list item in your project.</p>
    <p>Each ticket contains an ID#, a ticket name, date, time, user name, description and continuous dated and
        time-indexed comments. </p>
    <p><strong>UPDATE IT</strong></p>
    <p>Each Ticket can also be given update-able Status, Priority, and Category designations.</p>
    <p><strong>SEARCH IT</strong></p>
    <p>Your project can be searched in many ways. Are you looking for a general term contained within a ticket
        somewhere, or a specific Status  or Category, a date or an ID number, or just want to see any Tickets that
        have not yet been completed?  </p>
        <p><strong>CONTAIN IT</strong></p>
    <p>The Admin feature allows an Admin to give a user access to a project. The User can only see and work on projects they have permissions for.   </p>
   
    <p><strong>DO IT AGAIN</strong></p>
    <p>AND TicketToDo allows you to add numerous projects or delete outdated projects.</p>
    <p>No need to try to keep track of your project on slips of paper or in notebooks. Keep track of it all with TicketToDo!</p>
    </div>
</div>
</div>
</div>

<?php
include 'endingBoilerPlate.php';