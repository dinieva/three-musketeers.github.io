<?php
/* файл не работает */
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

$title = "Тема письма";

$c = true;
// Формирование самого письма
$title = "сообщение с сайта Мушкетеров";
foreach ( $_POST as $key => $value ) {
  if ( $value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject" ) {
    $body .= "
    " . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
      <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
      <td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
    </tr>
    ";
  }
}

$body = "<table style='width: 100%;'>$body</table>";

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();

try {
  $mail->isSMTP();
  $mail->CharSet = "UTF-8";
  $mail->SMTPAuth   = true;

  // Настройки вашей почты
  $mail->Host       = 'smtp.mail.ru'; // SMTP сервера вашей почты
  $mail->Username   = 'dinievamail@mail.ru'; // Логин на почте
  $mail->Password   = 'f4Vg3G3xs5YB0ph9xDJh'; // Пароль на почте
  $mail->SMTPSecure = 'ssl';
  $mail->Port       = 465;

  $mail->setFrom('dinievamail@mail.ru', 'Заявка с вашего сайта'); // Адрес самой почты и имя отправителя

  // Получатель письма
  $mail->addAddress('dinievamail@mail.ru');

  // Отправка сообщения
  $mail->isHTML(true);
  $mail->Subject = $title;
  $mail->Body = $body;

  $mail->send();
  $message = 'Сообщение отправлено успешно';
  $response= ['message' => $message];
  echo json_encode($response);
} catch (Exception $e) {
  $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}
?>