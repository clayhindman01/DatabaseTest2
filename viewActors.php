<?php

if(isset($_POST['title'])){
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "sakila";
    $error = "error - please try again.";
    $constr = 'mysql:host=' . $host . ';dbname=' . 'sakila';
    $dbh = new PDO($constr, $user, $password);
    $sql_query = "select * from sakila.film (title, description, year, language, rental, rate, `length`, rating, features)";
    $sth = $dbh->prepare($sql_query);
    $film = $sth->execute($_POST['title'], $_POST['description'], $_POST['year'], $_POST['language'], $_POST['rental'], $_POST['rate'], $_POST['length'], $_POST['rating'], $_POST['features']);
}
print_r($sql_query);

?>