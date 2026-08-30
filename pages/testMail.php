<?php

require_once __DIR__ . "/../backend/config/mail.php";

$code = '583214';

if (sendVerificationEmail(
    'rjibi.rayen01@gmail.com',
    $code
)) {
    echo "Email envoyé avec succès !";
} else {
    echo "Erreur lors de l'envoi de l'email.";
}