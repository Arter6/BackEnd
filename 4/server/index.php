<html lang="en">
<meta charset="utf-8">
<head>
<title>Hello world page</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
<a href="create.php">Create</a>
<a href="read.php">Read</a>
<a href="update.php">Update</a>
<a href="delete.php">Delete</a>

<h1>Таблица</h1>
<table>
    <tr><th>Промо</th><th>Проомокод</th><th>Сайт</th><th>URL</th></tr>
<?php
$mysqli = new mysqli("db", "user", "password", "appDB");
$result = $mysqli->query("SELECT 
  Promos.promo_id, Promos.promo_name, Promos.promo_code,
  PromosSites.promo_id, PromosSites.site_id,
  Sites.site_id, Sites.site_name, Sites.site_url
  FROM PromosSites
  INNER JOIN Promos ON PromosSites.promo_id=Promos.promo_id
  INNER JOIN Sites ON PromosSites.site_id=Sites.site_id");
foreach ($result as $row){
    echo "<tr><td>{$row['promo_name']}</td><td>{$row['promo_code']}</td><td>{$row['site_name']}</td><td>{$row['site_url']}</td></tr>";
}
$mysqli->close();
?>
</table>
<?php
// phpinfo();
?>
</body>
</html>