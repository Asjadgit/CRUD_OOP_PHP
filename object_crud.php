<?php

include 'CRUD_class.php';

$obj = new database();

// $obj->insert('student',['Name' => 'hi','Age'=>'2','City'=>'nowhere']);
// $obj->select('student','SELECT * FROM student');

// $obj->update('student',['Name'=>'user','Age'=>'21','City'=>'New York'], 'id = "74"');

$obj->delete('student', 'id = "74"');

echo "<br>";
echo "<pre>";
print_r($obj->showresult());
echo "</pre>";
?>