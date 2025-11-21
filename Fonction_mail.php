<?php
header('Content-Type: text/html; charset=utf-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
function envoyerMail($destEmail, $destName, $type) {


    $mails = [
        1 => [
            'sujet' => "Invitation à jouer",
            'message' => "<p>Salut $destName, viens jouer à StratFat, on t’attend !</p>"
        ],
        2 => [
            'sujet' => "Rappel important",
            'message' => "<p>$destName, n’oublie pas notre rendez-vous aujourd’hui !</p>"
        ],
        3 => [
            'sujet' => "Nouvelle intéressante",
            'message' => "<p>Hey $destName, j’ai une info cool à te partager !</p>"
        ],
        4 => [
            'sujet' => "Message urgent",
            'message' => "<p>$destName, contacte-moi dès que possible STP.</p>"
        ],
        5 => [
            'sujet' => "Petit message sympa",
            'message' => "<p>Bonjour $destName 😊 juste un petit coucou !</p>"
        ]
    ];

    if (!isset($mails[$type])) {
        return false;
    }

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    try {

        $mail->isSMTP();
        $mail->Host       = 'pro.turbo-smtp.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'baillonarthus7@gmail.com';
        $mail->Password   = 'SAE301progsmtp';
        $mail->Port       = 2525;
        $mail->setFrom('baillonarthus7@gmail.com', 'arthus');
        $mail->addAddress($destEmail, $destName);

        $mail->isHTML(true);
        $mail->Subject = $mails[$type]['sujet'];
        $mail->Body    = $mails[$type]['message'];
        $mail->AltBody = strip_tags($mails[$type]['message']);

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Erreur email : " . $mail->ErrorInfo);
        return false;
    }

}
if (envoyerMail("baillonarthus7@gmail.com", "Arthus", 3)) {
    echo "Email envoyé !";
} else {
    echo "Erreur lors de l'envoi...";
}

