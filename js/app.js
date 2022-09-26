// Define user interface variables

var xxx = 1;


function openForm() {
    document.getElementById("main").style.display = "block";

}

function closeForm() {
    document.getElementById("main").style.display = "none";

}



function goBack() {
    window.history.back();
}




/*Searching by a specific topic in the advanced search: Here we want to show an alert when a user clicks
* on the submit button without selecting an option from the drop down. */
let el = document.getElementById('searchByStatus');
if (el) {
    el.addEventListener('click', chooseStatusAlert);
}

 el = document.getElementById('searchByPriority');
if (el) {
    el.addEventListener('click', choosePriorityAlert);
}

 el = document.getElementById('searchByCategory');
if (el) {
    el.addEventListener('click', chooseCategoryAlert);
}

 el = document.getElementById('searchByIDNumber');
if (el) {
    el.addEventListener('click', chooseIDNumberAlert);
}

 el = document.getElementById('searchByDate');
if (el) {
    el.addEventListener('click', chooseDateAlert);
}




function chooseStatusAlert(e) {
    if( document.getElementById('status').value == "") {
        alert ("Please Choose a Status option to search by.")
        e.preventDefault();
    }
}

function choosePriorityAlert(e) {
    if( document.getElementById('priority').value == "") {
        alert ("Please Choose a Priority option to search by.")
        e.preventDefault();
    }
}

function chooseCategoryAlert(e) {
    if( document.getElementById('category').value == "") {
        alert ("Please Choose a Category option to search by.")
        e.preventDefault();
    }
}

function chooseIDNumberAlert(e) {
    if( document.getElementById('IDNumberInputBox').value == "") {
        alert ("Please Enter an ID Number to search by.")
        e.preventDefault();
    }
}

function chooseDateAlert(e) {
    if( document.getElementById('dateInputBox').value == "") {
        alert ("Please Enter a date range to search by.")
        e.preventDefault();
    }
}


















/*Allowing user to add their own category to the database*/
/*Piece of Javascript that changes the action for a form under specific conditions. */

 el = document.getElementById('brandNewCategory');
if (el) {
    el.addEventListener('click', function (e) {
        var categoryForm = document.getElementById('task-form-category');
        categoryForm.action = 'createNewTicket.php';
        /*create hidden value node */
        var elInput = document.createElement('input');
        elInput.setAttribute('type', 'hidden');
        elInput.id = 'addCatSubmit';
        elInput.setAttribute('name', 'addCatSubmit');
        elInput.setAttribute('value', 'true');
        /*add hidden node to form*/
        categoryForm.appendChild(elInput);

    });
}




// function setActionCategory() {
//     document.createTicketForm.action = "addNewCategory.php";
//     alert(document.createTicketForm.action);
//     return false;
// }
//
// function setActionTicket() {
//     document.createTicketForm.action = "displayTicket.php";
//     alert(document.createTicketForm.action);
//     return false;
// }