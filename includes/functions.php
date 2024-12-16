<?php
function redirectWithoutMsg(string $location)
{
    echo "
        <script>
            window.location.href='$location';
        </script>
    ";
    die();
}

function showErrorMsg($message)
{
    echo "
        <div class='alert alert-danger'>
            $message
            <button class='close' data-dismiss='alert'>&times;</button>
        </div>
    ";
}

function redirectToLogin()
{
    header("location:../login.php");
    die();
}

function sendEmail($mail, $studentEmail, $ticketId, $responseMessage, $mailError)
{
    try {
        // Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        // $mail->SMTPDebug = 2; // Enable verbose debug output
        // $mail->Debugoutput = 'html'; // Output errors in HTML format
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'ibrahimnurudeenshehu1447@gmail.com'; // SMTP username
        $mail->Password = 'emprljzbhpupwpjl';              // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        // Recipients
        $mail->setFrom('ibrahimnurudeenshehu1447@gmail.com', 'Campus Help Desk');
        $mail->addAddress($studentEmail);                     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Response to Your Ticket #' . $ticketId;
        $mail->Body    = '<p>Dear Student,</p><p>Thank you for reaching out to the Campus Help Desk. Below is our response to your ticket:</p><p><strong>' . nl2br($responseMessage) . '</strong></p><p>If you have any further questions, please feel free to reply to this email.</p><p>Best regards,<br>Campus Help Desk Team</p>';
        $mail->AltBody = "Dear Student,\n\nThank you for reaching out to the Campus Help Desk. Below is our response to your ticket:\n\n" . $responseMessage . "\n\nIf you have any further questions, please feel free to reply to this email.\n\nBest regards,\nCampus Help Desk Team";

        if ($mail->send()) {
            return true;
        } else {
            $mailError = $mail->ErrorInfo;
            return false;
        }
    } catch (Exception $e) {
        $mailError = $mail->ErrorInfo;
        return false;
    }
}
