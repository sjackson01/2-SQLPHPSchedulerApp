<?php
require 'inc/functions.php';

$pageTitle = "Project | Time Tracker";
$page = "projects";

//Get id from query string link in project_list.php 
//Use id to pull project details using get project funtion
//Get project function will return an array 
if(isset($_GET['id'])){
    //Use list funtion to add those array values into individual variables
    list($project_id, $title, $category) = 
    get_project(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
}

//Receive input through title text box and category dropdown 
//Verify request method is POST 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Filter input and remove white space from beginning and end of our feilds 
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $category = trim(filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING));

    //Fields are manditory make sure fields are not empty
    if(empty($title) || empty($category)){
        $error_message = 'Please fill in the required fields: Title, Category';
    }else{
        
       //Insert $title and $category records into projects table
       if(add_project($title, $category)){
            //Successful insert (true returned) re-direct to project list page
            header('Location: project_list.php');
            exit;
       }else{
            //Unsuccessful insert (false returned) display error message
            $error_message = 'Could not add project';
       }

    }
}
include 'inc/header.php';
?>

<div class="section page">
    <div class="col-container page-container">
        <div class="col col-70-md col-60-lg col-center">
            <h1 class="actions-header">
            <!-- Change header based on project_id $_GET --> 
            <?php
            if(!empty($project_id)){
                echo 'Update';
            }else{
                echo 'Add';
            }
            Add ?>Project</h1>
            <!-- TEST display error message --> 
            <?php
            if(isset($error_message)){
                echo "<p class='message'>$error_message</p>";
            }
            ?>
            <form class="form-container form-add" method="post" action="project.php">
                <table>
                    <tr>
                        <th><label for="title">Title<span class="required">*</span></label></th>
                        <td><input type="text" id="title" name="title" value="" /></td>
                    </tr>
                    <tr>
                        <th><label for="category">Category<span class="required">*</span></label></th>
                        <td><select id="category" name="category">
                                <option value="">Select One</option>
                                <option value="Billable">Billable</option>
                                <option value="Charity">Charity</option>
                                <option value="Personal">Personal</option>
                        </select></td>
                    </tr>
                </table>
                <input class="button button--primary button--topic-php" type="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>
