<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "sakila";

$conn = new mysqli($server, $user, $password, $db);

if($conn -> connect_error){
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT customer.customer_id from customer
inner join rental on rental.customer_id = customer.customer_id
inner join inventory on rental.inventory_id = inventory.inventory_id
inner join film on inventory.film_id = film.film_id
order by customer.last_name"
$results = mysqli_query($conn, $sql);
$titleDict = [];
while($row = mysqli_fetch_assoc($results)){
  if(array_has_key($titleDict, $row['customer_id']){
    $titleDict['customer_id'] = $titleDict['customer_id'] . ", " . $row['title'];
  }
  else{
    $titleDict[$results['customer_id'] => $results['title']];
  }
}
$sql = "SELECT customer.customer_id, customer.first_name, customer.last_name, `address`.address, city.city, address.district, address.postal_code from customer
inner join `address` on address.address_id = customer.address_id
inner join city on address.city_id = city.city_id
inner join rental on rental.customer_id = customer.customer_id
inner join inventory on rental.inventory_id = inventory.inventory_id
inner join film on inventory.film_id = film.film_id
order by customer.last_name";
$results = mysqli_query($conn, $sql);
if (mysqli_num_rows($results) > 0) {
    echo '<br>';
        echo '<table border="1" style="width:100%">';
        echo '<th>First Name </th>';
        echo '<th>Last Name </th>';
        echo '<th>Address </th>';
        echo '<th>City </th>';
        echo '<th>District </th>';
        echo '<th>Postal Code </th>';
        echo '<th>Rented films </th>';
    while($row = mysqli_fetch_assoc($results)) {
      echo'<tr>';
      echo'<td> ' . $row['first_name'] . '</td>';
      echo'<td> ' . $row['last_name'] . '</td>';
      echo'<td> ' . $row['address'] . '</td>';
      echo'<td> ' . $row['city'] . '</td>';
      echo'<td> ' . $row['district'] . '</td>';
      echo'<td> ' . $row['postal_code'] . '</td>';
      echo'<td> ' . $titleDict[$row['customer_id']] . '</td>';
      echo'</tr>';
  }
 } else {
    echo "0 results";
  }

  echo'<form action="manager.html">';
    echo'<input type="submit" value="Return" />';
    echo'</form>';
?>
