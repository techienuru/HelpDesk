<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (isset($_SESSION["admin_id"])) {
    session_unset();
    session_destroy();
    redirectToLogin();
} else {
    redirectToLogin();
}
