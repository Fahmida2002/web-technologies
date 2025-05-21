 <?php
$bgColor = isset($_COOKIE['bgcolor']) ? htmlspecialchars($_COOKIE['bgcolor']) : '#f4f4f4';
// DB connection
$con = mysqli_connect("localhost", "root", "", "AQI");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start(); 
if (isset($_SESSION['selected_cities']) && is_array($_SESSION['selected_cities']) && count($_SESSION['selected_cities']) > 0) {
    $cities = $_SESSION['selected_cities'];
} else {
    echo "No cities selected.";
    exit();
}
$escaped_cities = array_map(function($city) use ($con) {
    return "'" . mysqli_real_escape_string($con, $city) . "'";
}, $cities);
$city_list = implode(',', $escaped_cities);

$sql = "SELECT City, Country, AQI FROM Info WHERE City IN ($city_list)";
$result = mysqli_query($con, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Selected City AQI</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: <?= $bgColor ?>;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 40%;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 18px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: black;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
    </style>
</head>
<body>

<h2>Air Quality Index (AQI) of Selected Cities</h2>

<table>
    <thead>
        <tr>
            <th>City</th>
            <th>Country</th>
            <th>AQI</th>
        </tr>
    </thead>
   <tbody>
        <?php
        $displayed = 0;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['City']) . "</td>
                        <td>" . htmlspecialchars($row['Country']) . "</td>
                        <td>" . htmlspecialchars($row['AQI']) . "</td>
                      </tr>";
                $displayed++;
            }
        }

        // Add empty rows to make 10 total
        for ($i = $displayed; $i < 10; $i++) {
            echo "<tr><td>&nbsp;</td><td></td><td></td></tr>";
        }

        mysqli_close($con);
        ?>
    </tbody>
</table>

</body>
</html>
