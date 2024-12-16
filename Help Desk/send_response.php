<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

if (isset($_SESSION["help_desk_id"])) {
    $user_id = $_SESSION["help_desk_id"];

    $selecting_user_details = mysqli_query($connect, "SELECT * FROM `help_desk` WHERE help_desk_id = $user_id");
    $fetching_user_details = mysqli_fetch_assoc($selecting_user_details);

    $name = $fetching_user_details["name"];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $responseMessage = $_POST['response_message'];
        $help_desk_id = $_POST['help_desk_id'];
        $ticketId = $_POST['ticket_id'];
        $studentEmail = $_POST['student_email'];

        date_default_timezone_set("AFRICA/LAGOS");
        $response_date = date("Y-m-d H:i:s");

        $query = "UPDATE `my_ticket` SET status='Resolved', response_message='$responseMessage',help_desk_id='$help_desk_id',response_date='$response_date' WHERE my_ticket_id='$ticketId'";
        $result = mysqli_query($connect, $query);

        if ($result) {
            // Send email to the student
            $mail = new PHPMailer(true);
            $mailError = null;

            if (sendEmail($mail, $studentEmail, $ticketId, $responseMessage, $mailError)) {
                // Redirect back to pending tickets page with a success message
                echo "
                    <script>
                        alert('Response sent successfully!');
                        window.location.href='pending-tickets.php';
                    </script>
                ";
                die();
            } else {
                // Redirect back to pending tickets page with an error message
                echo "
                    $mailError
                    <script>
                        alert('Error while sending response to email!');
                        // window.location.href='pending-tickets.php';
                    </script>
                ";
                die();
            }
        } else {
            // Redirect back to pending tickets page with an error message
            echo "
                <script>
                    alert('Error while sending response!');
                    window.location.href='pending-tickets.php';
                </script>
            ";
            die();
        }
        header("Location: pending-tickets.php");
        exit();
    }
} else {
    redirectToLogin();
}
