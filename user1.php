<?php

 $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $name = $request->name;
    $address=$request->address;
    $contact=$request->contact;
    $class=$request->classname;
    $prev_date=$request->dt1;
    $next_date=$request->dt2;

$servername = "localhost";
$username = "root";
$password = "password"; //Your User Password
$dbname = "demo_db"; //Your Database Name


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

	$sql="INSERT INTO `users` ( `name` ,`address`, `contact`, `class`, `prev_date`, `next_date`)
	VALUES ('$name','$address','$contact','$class','$prev_date','$next_date')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
