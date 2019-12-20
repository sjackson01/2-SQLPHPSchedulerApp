<?php
require 'inc/functions.php';

$pageTitle = "Task | Time Tracker";
$page = "tasks";

//Receive input through inputs 
//Verify request method is POST 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Filter input and remove white space from beginning and end of our feilds 
    $project_id= trim(filter_input(INPUT_POST, 'project_id', FILTER_SANITIZE_NUMBER_INT));
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $time = trim(filter_input(INPUT_POST, 'time', FILTER_SANITIZE_NUMBER_INT));

    //Fields are manditory make sure fields are not empty
    if(empty($project_id) || empty($title) || empty($date) || empty($time)){
        $error_message = 'Please fill in the required fields: Title, Category, 
        Date, and Time';
    }else{
        
       //Insert $title and $category records into projects table
       if(add_task($project_id, $title, $date, $time)){
            //Successful insert (true returned) re-direct to task list page
            header('Location: task_list.php');
            exit;
       }else{
            //Unsuccessful insert (false returned) display error message
            $error_message = 'Could not add task';
       }

    }
}
include 'inc/header.php';
?>

<div class="section page">
    <div class="col-container page-container">
        <div class="col col-70-md col-60-lg col-center">
            <h1 class="actions-header">Add Task</h1>
            <!-- Display error message if input field empty -->
            <?php
            if(isset($error_message)){
                echo "<p class='message'>$error_message</p>";
            }
            ?>
            <form class="form-container form-add" method="post" action="task.php">
                <table>
                    <tr>
                        <th>
                            <label for="project_id">Project</label>
                        </th>
                        <td>
                            <select name="project_id" id="project_id">
                                <option value="">Select One</option>
                                <!-- Pull project_id, title, from projects table -->
                                <?php 
                                foreach(get_project_list() as $item){
                                        echo "<option value='"
                                        . $item['project_id']. "'>" 
                                        . $item['title'] . "</option>"; 
                                        
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="title">Title<span class="required">*</span></label></th>
                        <td><input type="text" id="title" name="title" value="" /></td>
                    </tr>
                    <tr>
                        <th><label for="date">Date<span class="required">*</span></label></th>
                        <td><input type="text" id="date" name="date" value="" placeholder="mm/dd/yyyy" /></td>
                    </tr>
                    <tr>
                        <th><label for="time">Time<span class="required">*</span></label></th>
                        <td><input type="text" id="time" name="time" value="" /> minutes</td>
                    </tr>
                </table>
                <input class="button button--primary button--topic-php" type="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>
