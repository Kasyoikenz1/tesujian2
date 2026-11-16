<?php
/* Attempt MySQL server connection */

$host = "localhost";
$user = "root";
$pass = "";
$database = "tesujian1";

$link = mysqli_connect($host, $user, $pass, $database);

// Check connection
if ($link === false) {
    die("Connection failed: " . mysqli_connect_error());
}

// Attempt select query execution
$sql = "SELECT * FROM sijaujian";

if ($result = mysqli_query($link, $sql)) {

    if (mysqli_num_rows($result) > 0) {

        echo "<table border='2'>";
        echo "<tr>";
        echo "<th>No</th>";
        echo "<th>Nama</th>";
        echo "<th>Harga</th>";
        echo "<th>Deskripsi</th>";
        echo "<th>Gambar</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['No'] . "</td>";
            echo "<td>" . $row['Nama'] . "</td>";
            echo "<td>" . $row['Harga'] . "</td>";
            echo "<td>" . $row['Deskripsi'] . "</td>";
            echo "<td><img src='Gambar/" . $row['Gambar'] . "</td>";
            echo "<td><a href='Lat_Delete.php?pilno='>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";

        // Free result set
        mysqli_free_result($result);

    } else {
        echo "No records matching your query were found.";
    }

} else {
    echo "ERROR: Could not execute query. "
        . mysqli_error($link);
}

// Close connection
mysqli_close($link);
?>