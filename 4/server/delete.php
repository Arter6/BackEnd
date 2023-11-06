<!DOCTYPE html>
<html>
<head>
    <title>Delete</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
<h1>Введите ID:</h1>
<form action="" method="post">
    <input type="number" name="number" required>
    <input type="submit" value="Удалить строку">
</form>
<table>
    <tr><th>Id</th><th>Name</th><th>Surname</th></tr>

<?php
$mysqli = new mysqli("db", "root", "password", "appDB");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number = $_POST["number"];
    $result = $mysqli->query("DELETE FROM users WHERE id=$number");

}

$result = $mysqli->query("SELECT * FROM users");
if ($result->num_rows == 0){
    echo "<tr><td>-</td><td>-</td><td>-</td></tr>";
} else {
    foreach ($result as $row) {
        echo "<tr><td>{$row['ID']}</td><td>{$row['name']}</td><td>{$row['surname']}</td></tr>";
    }
}
$mysqli->close();
?>
</table>
</body>
</html>