<?php
$connect = mysqli_connect("localhost", "root", "1234567890", "help_desk");

if (!$connect) {
    die(mysqli_connect_error());
}
