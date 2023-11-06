<!DOCTYPE html>
<html>
<head>
    <title>Update</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
<h1>Введите ID и новые имя и фамилию:</h1>
<form action="" method="post">
    <input type="number" name="number" required>
    <input type="string" name="name" required>
    <input type="string" name="surname" required>
    <input type="submit" value="Обновить строку">
</form>
<table>
    <tr><th>Id</th><th>Name</th><th>Surname</th></tr>

<?php
$mysqli = new mysqli("db", "user", "password", "appDB");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number = $_POST["number"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $result = $mysqli->query("UPDATE users SET name='$name',surname='$surname' WHERE id=$number");
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