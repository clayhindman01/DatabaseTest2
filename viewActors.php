<html>
<head>
	<title>Test 2</title>
	<link rel ="stylesheet" type="text/css" href="sample.css">
</head>

<body>

<?php

//Declare where the db is and set the creds
$server = "localhost";
$user = "root";
$pw = "";
$db = "sakila";

//Create a new connection to the database
$mysqli = new mysqli($server, $user, $pw, $db);
if ($mysqli -> connect_error) {
    exit("Error connecting to the $db database");
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
$mysqli -> set_charset("utf8mb4");

//There is no info to get from the $_POST array

//Run the sql script for the actor table
$stmt_actor = $mysqli -> prepare("SELECT last_name, first_name FROM actor order by actor.last_name");
$stmt_actor -> execute();

$result_actor = $stmt_actor -> get_result();

//TODO: Print the results to a table
print("<h1>Table of Actors</h1>");
print("<table border='1'>");
print("<tr> <th>Last Name</th> <th>First Name</th> <th>Movie Count</th> <th>List of Movies</th></tr>");

$i = 0;
while($row = $result_actor -> fetch_assoc()) {
    $actor_names[$i][] = $row['first_name'];
    $actor_names[$i][] = $row['last_name'];
    print ("<tr><td>".$row['last_name']."</td><td>".$row['first_name']."</td></tr>");
    $i++;
}

print("<form action='tasks.html'><input type='submit' value='Back To Home Page' /></form>");

//Close the database
$mysqli -> close();
?>
</body>
</html>