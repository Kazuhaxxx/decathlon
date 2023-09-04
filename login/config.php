<?php

$conn = mysqli_connect('localhost','root','','pullodb');

if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}

?>