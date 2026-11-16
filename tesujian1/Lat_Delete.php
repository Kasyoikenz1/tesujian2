<?php
$conn = mysqli_connect("localhost", "root", "", "tesujian1");

$hapus="delete from sijaujian where no='$_GET[pilno]' " ;

if ($dataqu = mysqli_query($conn, $hapus)) {

echo "data sudah dihapus" ;

}

?>

<?! http://localhost/latphp/delete.php?pilno=