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
$stmt = $mysqli -> prepare("SELECT title, description, rental_duration, rental_rate, length, special_features, name FROM film f, category c, film_category fc WHERE f.film_id = fc.film_id AND c.category_id = fc.category_id");
$stmt -> execute();

$result = $stmt -> get_result();

//TODO: Print the results to a table
print("<h1>Table of Movies</h1>");
print("<table border='1'>");
print("<tr> <th>Title</th> <th>Description</th> <th>Rental Duration</th> <th>Rental Rate</th> <th>Length</th> <th>Special Features</th> <th>Category</th> <th>Value</th> </tr>");

$i = 0;
while($row = $result -> fetch_assoc()) {
    $film[$i][] = $row['title'];
    $film[$i][] = $row['description'];
    $film[$i][] = $row['rental_duration'];
    $film[$i][] = $row['rental_rate'];
    $film[$i][] = $row['length'];
    $film[$i][] = $row['special_features'];
    $film[$i][] = $row['name'];


    print ("<tr> <td>".$row['title']."</td> <td>".$row['description']."</td> <td>".$row['rental_duration']."</td> <td>".$row['rental_rate']."</td> <td>".$row['length']."</td> <td>".$row['special_features']."</td> <td>".$row['name']."</td> </tr>");
    $i++;
}

print("<form action='tasks.html'><input type='submit' value='Back To Home Page' /></form>");

//Close the database
$mysqli -> close();
?>
</body>
</html>