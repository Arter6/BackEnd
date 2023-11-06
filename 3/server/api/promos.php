<?php
$mysqli = new mysqli("db", "user", "password", "appDB");

function extracted(mysqli $mysqli, $name, $code, $site)
{
    $result = $mysqli->query("SELECT promo_name, promo_code FROM Promos WHERE promo_name='$name' AND promo_code='$code'")->fetch_row();
    if ($result == null OR $result[0] == 0) {
        $mysqli->query("INSERT INTO Promos(promo_name,promo_code) VALUES ('$name', '$code')");

        $amount = $mysqli->query("SELECT promo_id FROM Promos WHERE promo_name='$name' AND promo_code='$code'");
        foreach ($amount as $row) {
            $amount = $row['promo_id'];
            break;
        }
        $result = $mysqli->query("SELECT site_id FROM Sites WHERE site_name='site'");
        foreach ($result as $row) {
            $result = $row['site_id'];
            break;
        }
        $mysqli->query("INSERT INTO PromosSites(promo_id,site_id) VALUES ($amount, $result)");
    } else{
        echo 'Already in db';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $result = $mysqli->query("SELECT 
    Promos.promo_id, Promos.promo_name, Promos.promo_code,
    PromosSites.promo_id, PromosSites.site_id,
    Sites.site_id, Sites.site_name, Sites.site_url
    FROM PromosSites
    INNER JOIN Promos ON PromosSites.promo_id=Promos.promo_id
    INNER JOIN Sites ON PromosSites.site_id=Sites.site_id");
    $data = array();
    foreach ($result as $row){
        $data[$row['promo_name']]['promo_code'] = $row['promo_code'];
        $data[$row['promo_name']]['site_name'] = $row['site_name'];
        $data[$row['promo_name']]['site_url'] = $row['site_url'];
    }
    if (isset($_GET['name'])) {
        $id = $_GET['name'];
        $json = json_encode($data[$id]);
    } else {
        $json = json_encode($data);
    }
    echo $json;
}

else if  ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (
        isset($_POST['name']) AND
        isset($_POST['code']) AND
        isset($_POST['site'])
    ){
        $site=$_POST['site'];
        $code=$_POST['code'];
        $name=$_POST['name'];

        $result = $mysqli->query("SELECT site_id, site_name FROM Sites  WHERE site_name='$site'")->fetch_row();
        if ($result[0] != 0){
            extracted($mysqli, $name, $code, $site);
        } else if (isset($_POST['URL'])){
            $url=$_POST['URL'];
            $mysqli->query("INSERT INTO Sites(site_name, site_url) VALUES ('$site', '$url')");
            extracted($mysqli, $name, $code, $site);
        } else {
            echo "Not enough data";
        }
    }
}
else if  ($_SERVER["REQUEST_METHOD"] == "PUT"){
    $input_data = file_get_contents("php://input");
    parse_str($input_data, $formData);
    $name=$formData['name'];
    $code=$formData['code'];
    $mysqli->query("UPDATE Promos SET promo_code='$code' WHERE promo_name = '$name'");
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE"){
    $name = $_GET['name'];
    $id= $mysqli->query("SELECT promo_id FROM Promos WHERE promo_name='$name'")->fetch_row()[0];
    $mysqli->query("DELETE FROM PromosSites WHERE promo_id=$id");
    $mysqli->query("DELETE FROM Promos WHERE promo_name='$name'");
}
$mysqli->close();