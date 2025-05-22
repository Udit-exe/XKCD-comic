<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // This loads the Composer autoloader


/**
 * Generate a 6-digit numeric verification code.
 */
function generateVerificationCode(): string {
    return str_pad(strval(rand(0, 999999)), 6, '0', STR_PAD_LEFT);
}

/**
 * Send a verification code to an email.
 */
function sendVerificationEmail(string $email, string $code): bool {
  $mail = new PHPMailer(true);  // Initialize PHPMailer

  try {
      // Server settings (Use SMTP)
      $mail->isSMTP();  
      $mail->Host = 'smtp.gmail.com';  // Gmail SMTP server
      $mail->SMTPAuth = true;  // Enable SMTP authentication
      $mail->Username = 'agrawaludit31@gmail.com';  // Your Gmail address
      $mail->Password = 'imod qmqb jrpo vssr';  // Your Gmail app password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
      $mail->Port = 587;  // SMTP port

      // Recipients
      $mail->setFrom('agrawaludit31@gmail.com', 'Udit Agrawal');
      $mail->addAddress($email);

      // Content
      $mail->isHTML(true);  // Set email format to HTML
      $mail->Subject = 'Your Verification Code';
      $mail->Body    = "<p>Your verification code is: <strong>$code</strong></p>";

      // Send the email
      $mail->send();
      return true;
  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      return false;
  }
}

/**
 * Register an email by storing it in a file.
 */
function registerEmail(string $email): bool {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];

    if (!in_array($email, $emails)) {
        $emails[] = $email;
        return file_put_contents($file, implode("\n", $emails) . "\n") !== false;
    }
    return false;
}

/**
 * Unsubscribe an email by removing it from the list.
 */
function unsubscribeEmail(string $email): bool {
    $file = __DIR__ . '/registered_emails.txt';
    if (!file_exists($file)) return false;

    $emails = file($file, FILE_IGNORE_NEW_LINES);
    $emails = array_filter($emails, fn($e) => trim($e) !== trim($email));

    return file_put_contents($file, implode("\n", $emails) . "\n") !== false;
}

/**
 * Fetch random XKCD comic and format data as HTML.
 */
function fetchAndFormatXKCDData(): string {
    $latestData = json_decode(file_get_contents('https://xkcd.com/info.0.json'), true);
    $maxComicId = $latestData['num'];
    $randomId = rand(1, $maxComicId);

    $comicUrl = "https://xkcd.com/{$randomId}/info.0.json";
    $comicData = json_decode(file_get_contents($comicUrl), true);

    $img = htmlspecialchars($comicData['img']);
    return "<h2>XKCD Comic</h2>
            <img src=\"{$img}\" alt=\"XKCD Comic\">
            <p><a href=\"#\" id=\"unsubscribe-button\">Unsubscribe</a></p>";
}

/**
 * Send the formatted XKCD updates to registered emails.
 */
function sendXKCDUpdatesToSubscribers(): void {
    $file = __DIR__ . '/registered_emails.txt';
    if (!file_exists($file)) return;

    $emails = file($file, FILE_IGNORE_NEW_LINES);
    $body = fetchAndFormatXKCDData();
    $subject = 'Your XKCD Comic';

    foreach ($emails as $email) {
        $unsubscribeLink = "https://psychic-zebra-pjp6wp5qp9pfjj4-8000.app.github.dev/unsubscribe.php?email=" . urlencode(trim($email));
        $emailBody = str_replace(
            'href="#"',
            'href="' . $unsubscribeLink . '"',
            $body
        );

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();  // using SMTP
            $mail->Host = 'smtp.gmail.com';  // Gmail SMTP server
            $mail->SMTPAuth = true;  // SMTP authentication
            $mail->Username = 'agrawaludit31@gmail.com';  // Gmail address
            $mail->Password = 'imod qmqb jrpo vssr';  // Gmail app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
            $mail->Port = 587;  // SMTP port

            // Recipients
            $mail->setFrom('agrawaludit31@gmail.com', 'Udit Agrawal');
            $mail->addAddress(trim($email));  // Add the recipient

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $emailBody;  // The body with the formatted XKCD comic and unsubscribe link

            // Send the email
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent to {$email}. Mailer Error: {$mail->ErrorInfo}\n";
        }
    }
}