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

function add_project($title, $category){
    include 'connection.php';
    //Insert record into title and cateogry
    //Value placeholders 
    $sql = 'INSERT INTO projects(title, category)  VALUE(?, ?)';

    try {
        //Pass $sql insert into prepared statement
        $results = $db->prepare($sql);
        //Bind $title argument to value placeholder and define parameter
        $results->bindValue(1,$title, PDO::PARAM_STRING);
        //Bind $category argument to value placeholder and define parameter
        $results->bindValue(2,$category, PDO::PARAM_STRING);
        //Execute the query
        $result->execute();
    }catch (Exception $e){
        echo "Error: " . $e->getMessage() . "<br /> ";
        return false;
    }
    return true;
}