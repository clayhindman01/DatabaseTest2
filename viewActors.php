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
$stmt_actor = $mysqli -> prepare("select a.last_name, a.first_name, a.actor_id, f.title from actor a inner join film_actor fa on a.actor_id = fa.actor_id inner join film f on f.film_id = fa.film_id order by last_name, first_name");
$stmt_actor -> execute();

$result_actor = $stmt_actor -> get_result();

//TODO: Print the results to a table
print("<h1>Table of Actors</h1>");
print("<table border='1'>");
print("<tr> <th>Last Name</th> <th>First Name</th> <th>Movie Count</th> <th>List of Movies</th></tr>");

$i = 0;
$full_data = [];
while($row = $result_actor -> fetch_assoc()) {
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $title = $row["title"];
    $actor_id = $row["actor_id"];

    if(!array_key_exists("$last_name"."$first_name", $full_data)) {
        //does not exist - so initialize
        $full_data["$last_name"."$first_name"][0] = $first_name;
        $full_data["$last_name"."$first_name"][1] = $title;
        $full_data["$last_name"."$first_name"][2] = 1;
        $full_data["$last_name"."$first_name"][3] = $last_name;
    } else {
        //already exists - so concat city name, increment count
        $full_data["$last_name"."$first_name"][1] .= ",".$title;
        $full_data["$last_name"."$first_name"][2] += 1;
    }
}

foreach($full_data as $last_name=>$values) {
    //$values[0] is cities as a string
    //$values[1] is count of number of cities
    $first_name = $values[0];
    $count = $values[2];
    $titles = $values[1];
    $last_name = $values[3];
    print("<tr><td>$last_name</td><td>$first_name</td><td>$count</td><td>$titles</td></tr>");
}


print("<form action='tasks.html'><input type='submit' value='Back To Home Page' /></form>");

//Close the database
$mysqli -> close();
?>
</body>
</html>