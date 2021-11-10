<?php

if(isset($_POST['title'])){
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "sakila";
    $error = "error - please try again.";
    $constr = 'mysql:host=' . $host . ';dbname=' . 'sakila';
    $dbh = new PDO($constr, $user, $password);
    $sql_query = "insert into sakila.film (title, description, year, language, rental, rate, `length`, rating, features) 
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $sth = $dbh->prepare($sql_query);
    $film = $sth->execute($_POST['title'], $_POST['description'], $_POST['year'], $_POST['language'], $_POST['rental'], $_POST['rate'], $_POST['length'], $_POST['rating'], $_POST['features']);
}
if($film){
    echo"Added " . $_POST['title'] . " to database!";
    echo'<form action="manager.html">';
    echo'<input type="submit" value="Return to manager page" />';
    echo'</form>';
}
else{
    echo"Error uploading film.";
    echo'<form action="manager.html">';
    echo'<input type="submit" value="Return to manager page" />';
    echo'</form>';
}

?>