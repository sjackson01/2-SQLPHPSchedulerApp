<?php
require 'inc/functions.php';

$page = "reports";
$pageTitle = "Reports | Time Tracker";
//Passed to the get task list function
$filter = 'all';

//Set filter variable = to query string value recieved from drop down menu
if(!empty($_GET['filter'])){
    //Change into an array of values with explode and filter
    $filter =  explode(':',filter_input(INPUT_GET,'filter',FILTER_SANITIZE_STRING));
}


include 'inc/header.php';
?>
<div class="col-container page-container">
    <div class="col col-70-md col-60-lg col-center">
        <div class="col-container">
            <!-- Change H1 based on filter --> 
            <h1 class='actions-header'>Report on 
            <?php if(!is_array($filter)){
                echo "All Tasks by Project";
            }else {
                echo ucwords($filter[0]) . " : ";
                switch ($filter[0]) {
                    case 'project':
                        $project = get_project($filter[1]);
                        echo $project['title'];
                        break;
                    case 'category':
                        echo $filter[1];
                        break;
                    case 'date';
                        echo $filter[1] . " - " . filter[2];  
                        break; 
                }
            }
            ?> </h1>
            <!-- Add form to manage reports --> 
            <form class='form-container form-report' action='reports.php' method='get'>
                <label for='filter'>Filter: </label>
                <select id='filter' name='filter'>
                    <option value=''>Select One</option>
                    <optgroup label="Project">
                    <!-- Use PHP to pull project information with a foreach loop --> 
                    <?php
                        foreach(get_project_list() as $item){
                            echo '<option value="project:' . $item['project_id'] . '">';
                            echo $item['title'] . "</option>\n";
                        }
                    ?>
                    <!-- Add category to filter drop down --> 
                    <optgroup label="Category">
                        <option value="category:billable">Billable</option>
                        <option value="category:Charity">Charity</option>
                        <option value="category:Personal">Personal</option>
                    </optgroup>
                    <!-- Add dates range to filter drop down --> 
                    <optgroup label="Date">
                        <option value="date: <?php
                        //Calculate start date of last week
                        date('m/d/Y',strtotime('-2 Sunday'));
                        echo":";
                        //Calculate end date
                        echo date('m/d/Y',strtotime('-1 Saturday'));
                        ?>"> Last Week </option>

                        <option value="date: <?php
                        //Calculate start date of last week
                        date('m/d/Y',strtotime('-2 Sunday'));
                        echo":";
                        //Calculate end date remove string to time to display today date
                        echo date('m/d/Y');
                        ?>"> This Week </option>

                        <option value="date: <?php
                        //Calculate start date of last month
                        date('m/d/Y',strtotime('first day of last month'));
                        echo":";
                        //Calculate end date last day of last month
                        echo date('m/d/Y',strtotime('last day of last month'));
                        ?>"> Last Month </option>

                         <option value="date: <?php
                        //Calculate start date of this month
                        date('m/d/Y',strtotime('first day of this month'));
                        echo":";
                        //Calculate end date remove strtotime 
                        echo date('m/d/Y');
                        ?>"> This Month </option>
                    </optgroup>    
                </select>
                <input class="button" type="submit" value="Run" />
        </div>
        <div class="section page">
            <div class="wrapper">
                <table>
                <?php 
                //Calculate time grand total and headers with project id 
                $total = $project_id = $project_total = 0;
                $tasks = get_task_list($filter);
                //$filter sorts the tasks by project
                foreach($tasks as $item){
                    if($project_id != $item['project_id']){
                        //If not equal we want to set the project_id and the project information header
                        $project_id = $item['project_id'];
                        //Echo the headers
                        echo "<thead>\n";
                        echo "<tr>\n";
                        echo "<th>" . $item['project'] . "</th>\n";
                        echo "<th>Date</th>\n";
                        echo "<th>Time</th>\n";
                        echo "</tr>\n";
                        echo "</thead>\n";
                        
                    }
                    $total += $item['time'];
                    $project_total += $item['time'];
                    echo "<tr> \n";
                    echo "<td>" . $item['title'] . "</td> \n";
                    echo "<td>" . $item['date'] . "</td> \n";
                    echo "<td>" . $item['time'] . "</td> \n";
                    echo "</tr>\n";

                    //Check if project is not set to the current project
                    if(next($tasks)['project_id'] != $item['project_id']) {
                        echo "<tr>\n";
                        echo "<th class='proejct-total-label' colspan=
                        '2'>Project Total </th>\n";
                        echo "<th class ='project-total-number'>$project_total</th>\n";
                        echo "</tr>\n";
                        $project_total = 0;
                    } 
                }
                ?>
                    <tr>
                        <th class='grand-total-label' colspan='2'>Grand Total</th>
                        <!-- Display time grand total --> 
                        <th class='grand-total-number'><?php echo $total; ?></th>
                    </tr>   
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>

