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
$stmt = $mysqli -> prepare("select title, description, rental_duration, rental_rate, length, special_features, name, amount FROM film f 
inner join film_category fc on fc.film_id = f.film_id 
inner join category c on fc.category_id = c.category_id
inner join inventory i ON f.film_id = i.film_id 
inner join rental r on r.inventory_id = i.inventory_id 
inner join payment p on p.rental_id = r.rental_id 
order by title;");


$stmt -> execute();

$result = $stmt -> get_result();

//TODO: Print the results to a table
print("<h1>Table of Movies</h1>");
print("<table border='1'>");
print("<tr> <th>Title</th> <th>Description</th> <th>Rental Duration</th> <th>Rental Rate</th> <th>Length</th> <th>Special Features</th> <th>Category</th> <th>Value</th> </tr>");

$i = 0;
$full_data = array();
$sum = 0;
while($row = $result -> fetch_assoc()) {
    $title = $row['title'];
    $description = $row['description'];
    $rental_duration = $row['rental_duration'];
    $rental_rate = $row['rental_rate'];
    $length = $row['length'];
    $special_features = $row['special_features'];
    $name = $row['name'];
    $amount = $row['amount'];

    if(!array_key_exists($title, $full_data)) {
        //does not exist - so initialize
        $full_data[$title][0] = $title;
        $full_data[$title][1] = $description;
        $full_data[$title][2] = $rental_duration;
        $full_data[$title][3] = $rental_rate;
        $full_data[$title][4] = $length;
        $full_data[$title][5] = $special_features;
        $full_data[$title][6] = $name;
        $full_data[$title][7] = $amount;
        $sum = $amount;
    } else {
        $full_data[$title][7] = $sum + $amount;
        $sum = $sum + $amount;

    }
    $i++;
}

foreach($full_data as $title=>$values) {
    $title = $values[0];
    $description = $values[1];
    $rental_duration = $values[2];
    $rental_rate = $values[3];
    $length = $values[4];
    $special_features = $values[5];
    $name = $values[6];
    $amount = $values[7];
    
    print ("<tr> <td>$title</td><td>$description</td> <td>$rental_duration</td> <td>$rental_rate</td> <td>$length</td> <td>$special_features</td> <td>$name</td> <td>$amount</td> </tr>");
}

print("<form action='tasks.html'><input type='submit' value='Back To Home Page' /></form>");

//Close the database
$mysqli -> close();
?>
</body>
</html>