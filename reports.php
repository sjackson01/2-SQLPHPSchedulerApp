<?php
require 'inc/functions.php';

$page = "reports";
$pageTitle = "Reports | Time Tracker";
//Passed to the get task list function
$filter = 'all';

include 'inc/header.php';
?>
<div class="col-container page-container">
    <div class="col col-70-md col-60-lg col-center">
        <div class="col-container">
            <h1 class='actions-header'>Reports</h1>
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

