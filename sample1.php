<!DOCTYPE html>
<!--	Author: David Schwab
		Date:	10/21/2019
		Purpose:Generate SQL script to populate database with values
-->
<html>
<head>
	<title>Data Generator</title>
	<link rel ="stylesheet" type="text/css" href="sample.css">
</head>

<body>

	<?php
        
       $mysqli = new mysqli("localhost", "root", "", "sakila");
        if($mysqli->connect_error) {
          exit('Error connecting to database'); //Should be a message a typical user could understand in production
        }
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli->set_charset("utf8mb4");
        //The ? below is a placeholder
        $stmt = $mysqli->prepare("select co.country, ci.city from country co join city ci on ci.country_id = co.country_id;");
        
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 0) exit('No rows');
		else print("<h1>We got results: " . $result->num_rows . "</h1>");

        print("<table border='1'>");
		print("<h1>Table of Countries</h1>");
        print("<tr><th>Country</th><th>Count</th><th align='left'>Cities</th></tr>");
        
		$full_data = array();
        while($row = $result->fetch_assoc()) {
          //print ("<tr><td>".$row['country']."</td><td>".$row['city']."</td></tr>");
		  $country = $row['country'];
		  $city = $row['city'];
          print("<pre>");
            print_r($city);
            print("</pre>");
		  //put data into associative array with country name as key.
		  //if !key exists - initalize country / city name and count = 1
		  //if key does exist, concat city name, increment count
		  if(!array_key_exists($country, $full_data)) {
			  //does not exist - so initialize
			  $full_data[$country][0] = $city;
			  $full_data[$country][1] = 1;
		  } else {
			  //already exists - so concat city name, increment count
			  $full_data[$country][0] .= ",".$city;
			  $full_data[$country][1] += 1;
		  }
        }
		//need a new loop to print the data from the array $full_data
		foreach($full_data as $country=>$values) {
			//$values[0] is cities as a string
			//$values[1] is count of number of cities
			$count = $values[1];
			$cities = $values[0];
			print("<tr><td>$country</td><td>$count</td><td>$cities</td></tr>");
			
		}
		
		
        print("</table>");
        print("<pre>");
        print_r($full_data);
        print("</pre>");
        $stmt->close();
        
        $mysqli->close();
        
        
        
        
	?>
</body>
</html>