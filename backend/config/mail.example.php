```php
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

function sendVerificationEmail(
    string $recipientEmail,
    string $verificationCode
): bool {

    $mail = new PHPMailer(true);

    try {

        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'rjibi.rayen01@gmail.com';

        // ⚠️ Mets ici ton App Password Google
        $mail->Password = 'TON_APP_PASSWORD';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Expéditeur
        $mail->setFrom(
            'rjibi.rayen01@gmail.com',
            'Librairie'
        );

        // Destinataire
        $mail->addAddress($recipientEmail);

        // Contenu
        $mail->isHTML(true);

        $mail->Subject = 'Code de verification - Librairie';

        $mail->Body = "
            <div style='font-family: Arial, sans-serif;'>
                <h2>Vérification de votre adresse email</h2>

                <p>
                    Bonjour,
                </p>

                <p>
                    Votre code de vérification est :
                </p>

                <h1 style='letter-spacing: 5px;'>
                    {$verificationCode}
                </h1>

                <p>
                    Ce code est valable pendant <strong>10 minutes</strong>.
                </p>

                <p>
                    Si vous n'êtes pas à l'origine de cette inscription,
                    vous pouvez ignorer cet email.
                </p>
            </div>
        ";

        // Version texte
        $mail->AltBody =
            "Votre code de vérification est : {$verificationCode}. " .
            "Ce code est valable pendant 10 minutes.";

        $mail->send();

        return true;

    } catch (Exception $e) {

        // Pour le développement uniquement
        error_log("Erreur PHPMailer : " . $mail->ErrorInfo);

        return false;
    }
}
```
