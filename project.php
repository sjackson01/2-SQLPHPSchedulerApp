<?php
require 'inc/functions.php';

$pageTitle = "Project | Time Tracker";
$page = "projects";

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
        echo "title = $title <br/>";
        echo "category = $category <br/>";
    }
}
include 'inc/header.php';
?>

<div class="section page">
    <div class="col-container page-container">
        <div class="col col-70-md col-60-lg col-center">
            <h1 class="actions-header">Add Project</h1>

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
