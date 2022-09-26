
/*from nav.php just in case I do need these. I think they have been replaced in other places and no longer need to be
there but I'm afraid to lose them completely*/



//$categoryQuery = "SELECT ID, category_name
//FROM category";
//
//$categoryQueryResult = $conn->query($categoryQuery);
//
//
//if ($debug) {
//
//
//$debug_string .= 'categoryQuery = ' . $categoryQuery . '<br/><br/>';
//if (!$categoryQueryResult) $debug_string .= "\n Error description query categoryQuery: " . mysqli_error($conn) . "\n<br/>";
//}/*end debug*/
//
//if ($categoryQueryResult) {
//
//
///*This requires the function if we want to use it*/
//
//// failureToExecute ($categoryQueryResult, 'S1', 'Select ');
//
//
//$numberOfCategoryRows = $categoryQueryResult->num_rows;
//
///* this begins the process for categories from the db being displayed in <option> s. */
    //    $categoryOptionRows = "";
    //
    //    for ($j = 0; $j < $numberOfCategoryRows; ++$j) {
    //    $row = $categoryQueryResult->fetch_array(MYSQLI_NUM);
    //
    //    $categoryID = $row[0];
    //    $categoryName = $row[1];
    //
    //
    //    $categoryOptionRows .= "<option value='$categoryID'>$categoryName</option>";
//}
//}
//
//
//
//?>
<!---->
<!---->


<!-- html for Add New Ticket But now we are going to a different page. createNewTicket.php ?because the link takes us
there?Not using this anymore?-->
<!--<div class="container">-->
<!--    <div class="row">-->
<!--        <div class="col s12">-->
<!--            <div id="main" class="card form-popup" >-->
<!--                <!--add task-->-->
<!--                <div class="card-content">-->
<!--                    <span class="card-title">Add Ticket</span>-->
<!--                    <div class="row">-->
<!--                        <div class="col">-->
<!--                            <form action='nav.php' id="task-form" method='post'>-->
<!--                                <div class="input-field col s12">-->
<!--                                    <input type="text" name="name" id="name"/>-->
<!--                                    <label for="name">Ticket Name</label>-->
<!--                                </div>-->
<!--                                <div class="input-field col s12">-->
<!--                                    <textarea id="description" class="materialize-textarea" name="description"></textarea>-->
<!--                                    <label for="description">Ticket Description</label>-->
<!--                                </div>-->
<!--                                <div class="input-field col s12">-->
<!---->
<!---->
<!--                                    <select name="status" id="status" class="form-control">-->
<!--                                        <option value="" disabled selected>Search for Status</option>-->
<!--                                        <option value="1" --><?php //if ($status == "1") {echo("selected");}
//                                        ?><!-->New</option>-->
<!--                                        <option value="2" --><?php //if ($status == "2") {echo("selected");}
//                                        ?><!-->Open</option>-->
<!--                                        <option value="3" --><?php //if ($status == "3") {echo("selected");}
//                                        ?><!-->Closed</option>-->
<!--                                        <option value="4" --><?php //if ($status == "4") {echo("selected");} ?><!-->On-->
<!--                                            Hold</option>-->
<!--                                        <option value="5" --><?php //if ($status == "5") {echo("selected");}
//                                        ?><!-->Saved</option>-->
<!--                                    </select>-->
<!---->
<!--                                    <label for="status">Ticket Status</label>-->
<!---->
<!--                                </div>-->
<!--                                <div class="input-field col s12">-->
<!--                                    <select name="priority" id="priority" class="form-control">-->
<!--                                        <option value="" disabled selected>Ticket Priority</option>-->
<!--                                        <option value="1" --><?php //if ($priority == "1") {echo("selected");}
//                                        ?><!-->Low</option>-->
<!--                                        <option value="2" --><?php //if ($priority == "2") {echo("selected");}
//                                        ?><!-->Medium</option>-->
<!--                                        <option value="3" --><?php //if ($priority == "3") {echo("selected");}
//                                        ?><!-->High</option>-->
<!--                                        <option value="4" --><?php //if ($priority == "4") {echo("selected");}
//                                        ?><!-->URGENT</option>-->
<!--                                    </select>-->
<!--                                        <label for="priority">Ticket Priority</label>-->
<!--                                </div>-->
<!--                                <div class="input-field col s12">-->
<!--                                    <select name="category" id="category">-->
<!--                                        <option value="" disabled selected>Ticket category</option>-->
<!--                                       --><?php //echo $categoryOptionRows;?>
<!--                                    </select>-->
<!--                                        <label for="category">Ticket Category</label>-->
<!--                                </div>-->
<!--                                <input type="submit"  value="Add Ticket" class="btn addTicketbuttons"/>-->
<!--                                <input type='hidden' name="submitTicket" value='true'/>-->
<!---->
<!--                            </form><br><br>-->
<!--                            <form>-->
<!--                                <button class="btn addTicketButtons" type="button" class= "btn" onclick="closeForm()-->
<!--                                ">Close</button>-->
<!--                            </form>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!---->
<!---->
<!---->
<!--            </div><!--end card-->-->
<!--        </div><!--end col-->-->
<!--    </div><!--end row-->-->
<!--</div><!--end container-->-->


<!--<div class="input-field col s6 s12 red-text">-->
<!--     <i class="red-text material-icons prefix">search</i>-->
<!--     <input type="text" name='searchBox' placeholder="search"-->
<!--      id="autocomplete-input" class="autocomplete red-text" >-->
<!-- </div>-->



<!--Try again codepen Navbar with searchBar materialize-->

<!--    <div class="navbar-fixed">-->
<!--        <nav>-->
<!--            <div class="nav-wrapper">-->
<!--                <ul class="left">-->
<!--                    <li>-->
<!--                        <a>-->
<!--                            <i class="hamburger material-icons hide-on-med-and-up">menu</i>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--                <form action="" method="post">-->
<!--                    <div class="input-field">-->
<!--                        <input id="search" type="search" name="search">-->
<!--                        <label class="label-icon" for="search"><i class="material-icons">search</i></label>-->
<!--                        <i class="material-icons">close</i>-->
<!--                    </div>-->
<!--                </form>-->
<!--                <ul class="right">-->
<!--                    <li>-->
<!--                        <a>-->
<!--                            <i class="material-icons">notifications_none</i>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="imgProfil">-->
<!--                        <img src="http://maxpixel.freegreatpicture.com/static/photo/1x/Redhead-Girl-Person-People-Woman-Female-Avatar-995164.png" alt="" class="circle">-->
<!--                    </li>-->
<!--                    <ul id="AccountInfo" class="hidden z-depth-5">-->
<!--                        <li>sdfsdf</li>-->
<!--                        <li>fghfgh</li>-->
<!--                        <li>jkjkljkljkl</li>-->
<!--                        <li>xwcxwcwxcwxc</li>-->
<!--                    </ul>-->
<!--                    <li>-->
<!--                        <a href="">-->
<!--                            <i class="material-icons">exit_to_app</i>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </nav>-->
<!--    </div>-->









<!--    <div class="topnav">-->
<!--  <a class="active" href="#home">Home</a>-->
<!--  <a href="#history">History</a>-->
<!--  <a href="#create">Create</a>-->
<!--  <a href="#about">About</a>-->
<!--</div>-->


