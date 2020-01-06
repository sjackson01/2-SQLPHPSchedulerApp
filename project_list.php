<?php
require 'inc/functions.php';

$page = "projects";
$pageTitle = "Project List | Time Tracker";

//Accept delete form data
if(isset($_POST['delete'])){
    if(delete_project(filter_input(INPUT_POST,'delete', FILTER_SANITIZE_NUMBER_INT))){
        //If the item is deleted re-direct and send message
        header('location: project_list.php?msg=Project+Deleted');
        exit;
    }else{
       header('location: project_list.php?msg=Unable+to+Delete+Project'); 
       exit;
    }    
}

//Accept message and display query string message on the screen
if(isset($_GET['msg'])){
    $error_message = trim(filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING));
}

include 'inc/header.php';
?>
<div class="section catalog random">

    <div class="col-container page-container">
        <div class="col col-70-md col-60-lg col-center">
            <h1 class="actions-header">Project List</h1>
            <div class="actions-item">
                <a class="actions-link" href="project.php">
                <span class="actions-icon">
                  <svg viewbox="0 0 64 64"><use xlink:href="#project_icon"></use></svg>
                </span>
                Add Project
                </a>
            </div>
            <!-- Display error message if input field empty -->
            <?php
            if(isset($error_message)){
                echo "<p class='message'>$error_message</p>";
            }
            ?>
            <div class="form-container">
                <ul class="items">
                    <!-- Pull project_id, title, category from projects table -->
                    <!-- Add links to project.php projects -->
                        <?php 
                        foreach(get_project_list() as $item){
                                echo "<li><a href='project.php?id=" 
                                . $item['project_id'] . "'>"
                                . $item['title'] 
                                . "</a>";
                                //Create form for deleting records from the db 
                                //Confirm delete after form submission 
                                echo "<form method='post' action='project_list.php' onsubmit=\"
                                return confirm('Are you sure you want to delete this project?');\"> \n";
                                //Add hidden field for the task id
                                echo "<input type='hidden' value='" . $item['project_id'] . "' name='delete' /> \n";
                                echo "<input type='submit' class='button--delete' value='delete' /> \n";
                                echo "</form>";
                                echo "</li>";
                        }
                        ?>
                </ul>
            </div>
        </div>
    </div>

</div>

<?php include("inc/footer.php"); ?>
