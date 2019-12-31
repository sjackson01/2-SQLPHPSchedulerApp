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

function get_task_list($filter = null){
    //Include db connection
    include 'connection.php';

    //Pull task information
    $sql = 'SELECT tasks.*, projects.title as project FROM tasks'
        . ' JOIN projects ON tasks.project_id = projects.project_id';
    
    //Add where clause to work with dropdown menu in reports
    $where ='';
    //Only use where clause if filter paramter is array 
    if(is_array($filter)){
        if($filter[0] == 'project'){
            $where = ' WHERE projects.project_id = ?';
        }
        
    }

    //Order tasks by date    
    $orderBy = ' ORDER BY date DESC';

    //If filter parameter is not null change orderBy 
    if($filter){
        $orderBy = ' ORDER BY projects.title ASC, date DESC';
    }
    try {
    //Concantenate SQL statments together and prepare    
    $results = $db->prepare($sql . $where . $orderBy);
    if(is_array($filter)){
    $results->bindValue(1, $filter[1], PDO::PARAM_INT);
    }
    $results->execute();
    } catch (Exception $e){
        echo "Error!: " . $e->getMessage() . "</br>";
        return array();
    }
    
    //Feth as associative array 
    return $results->fetchAll(PDO::FETCH_ASSOC);

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

function add_task($project_id, $title, $date, $time){
    include 'connection.php';
    //Insert record into project_id title date and time
    //Value placeholders 
    $sql = 'INSERT INTO tasks(project_id, title, date, time)  
            VALUES(?, ?, ?, ?)';

    try {
        //Pass $sql insert into prepared statement
        $results = $db->prepare($sql);
        //Bind argument to value placeholder and define parameter
        $results->bindValue(1,$project_id, PDO::PARAM_INT);
        $results->bindValue(2,$title, PDO::PARAM_STR);
        $results->bindValue(3,$date, PDO::PARAM_STR);
        $results->bindValue(4,$time, PDO::PARAM_STR);
        //Execute the query
        $results->execute();
    }catch (Exception $e){
        echo "Error: " . $e->getMessage() . "<br /> ";
        return false;
    }
    return true;
}