<?php
//application functions

function get_project_list(){
    //Include db connction
    include 'connection.php';

    //Select from the projects table and add exception handling
    try {
    return $db->query('SELECT project_id, title, category FROM projects ');
    } catch (Exception $e){
        echo "Error!: " . $e->getMessage() . "</br>";
        return array();
    }

}

function get_task_list(){
    //Include db connection
    include 'connection.php';

    //Pull task information
    $sql = 'SELECT tasks.*, projects.title as project FROM tasks'
        . ' JOIN projects ON tasks.project_id = projects.project_id';

    
    try {
    return $db->query($sql);
    } catch (Exception $e){
        echo "Error!: " . $e->getMessage() . "</br>";
        return array();
    }

}

function add_project($title, $category){
    include 'connection.php';
    //Insert record into title and cateogry
    //Value placeholders 
    $sql = 'INSERT INTO projects(title, category)  VALUES(?, ?)';

    try {
        //Pass $sql insert into prepared statement
        $results = $db->prepare($sql);
        //Bind $title argument to value placeholder and define parameter
        $results->bindValue(1,$title, PDO::PARAM_STR);
        //Bind $category argument to value placeholder and define parameter
        $results->bindValue(2,$category, PDO::PARAM_STR);
        //Execute the query
        $results->execute();
    }catch (Exception $e){
        echo "Error: " . $e->getMessage() . "<br /> ";
        return false;
    }
    return true;
}