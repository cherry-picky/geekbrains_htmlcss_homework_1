<?php

  include ('../lib/db_actions.php');

  $fields_errors = [];
  $success_message = "";

  processing_contacts_form();

  function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    
    return $value;
  }

  function check_length($value = "", $min, $max) {
    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
    
    return !$result;
  }

  function processing_contacts_form() {
    global $fields_errors;
    global $success_message;

    global $username;
    global $email;
    global $subject;
    global $message;

    if ($_SERVER['REQUEST_METHOD'] != 'POST') return;

    ob_start();
      
    $username = $_POST['username'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $username = clean($username);
    $email = clean($email);
    $subjet = clean($subject);
    $message = clean($message);

    if (empty($username)) {
      $fields_errors["username"] = "Это поле обязательно для заполнения!";
    } else {
      if (!check_length($username, 2, 25)) {
        $fields_errors["username"] = "Ошибка в имени!";
      } else {
        $fields_errors["username"] = "";
      }
    }

    if (empty($email)) {
      $fields_errors["email"] = "Это поле обязательно для заполнения!";
    } else {
      $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL); 
      if (!$email_validate) {
        $fields_errors["email"] = "Ошибка в e-mail!";
      } else {
        $fields_errors["email"] = "";
      }
    }

    if (empty($subject)) {
      $fields_errors["subject"] = "Это поле обязательно для заполнения!";
    } else {
      if (!check_length($subject, 2, 50)) {
        $fields_errors["subject"] = "Ошибка в теме сообщения!";
      } else {
        $fields_errors["subject"] = "";
      }
    }

    if (empty($message)) {
      $fields_errors["message"] = "Это поле обязательно для заполнения!";
    } else {
      if (!check_length($message, 2, 1000)) {
        $$fields_errors["message"] = "Ошибка в сообщении!";
      } else {
        $fields_errors["message"] = "";
      }
    }

    $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL); 
    
    if (check_length($username, 2, 25) 
      && check_length($subject, 2, 50) 
      && check_length($message, 2, 1000) 
      && $email_validate) {
      
      saveRequest ($username, $email, $subject, $message);
      $username = $email = $subject = $message = "";
      $success_message = "Форма успешно отправлена";

      return;
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <title>ПОДОКОННИК - Контакты</title>
  <meta charset="utf-8">
  <link rel='stylesheet' type='text/css' href='../styles/style.css'>
</head>
<body>

  <div class='container'>

    <div class='header'>
      <img class='logo' src='../images/logo.png' alt='logo'>
      <div class='store-name'>ПОДОКОННИК</div>
      <ul class='main-menu'>
        <li><a href='../index.html'>Главная</a></li>
        <li><a href='../catalog.html'>Каталог</a></li>
        <li><a href='contacts.php'>Контакты</a></li>
      </ul>
    </div>

    <hr>

    <h1>Контакты</h1>

    <fieldset class='contacts-form'>
      <legend>Напишите нам</legend>
        <form action = 'contacts.php' method='post'>
        <br>

        <input type='text' name='username' placeholder='Введите ваше имя' value="<?=$username ?>">
        <p class="<?=(empty($fields_errors["username"]) ? "" : "form_error")?>"><?=$fields_errors["username"]?></p>

        <input type='text' name='email' placeholder='Введите ваш электронный адрес' value="<?=$email?>">
        <p class="<?=(empty($fields_errors["email"]) ? "" : "form_error")?>"><?=$fields_errors["email"]?></p>

        <input type='text' name='subject' placeholder='Тема сообщения' value="<?=$subject ?>">
        <p class="<?=(empty($fields_errors["subject"]) ? "" : "form_error")?>"><?=$fields_errors["subject"]?></p>
        <br>

        <label for='letter-body'>Суть вашего письма:</label><br>
        <textarea name='message' id='letter-bodye'><?=$message ?></textarea>
        <p class="<?=(empty($fields_errors["message"]) ? "" : "form_error")?>"><?=$fields_errors["message"]?></p>
        <br> 

        <input type='submit' value="Отправить">
        <p> <?=$success_message ?> </p>

      </form>
    </fieldset>

    <h2>Адрес</h2>
    <p>
      <strong>Телефон:</strong> +7 999 99 99 99
      <br>
      <strong>Адрес:</strong> г. Москва, ул. Большая Садовая, д. 1
      <br>
      <strong>E-mail:</strong> info@podokonnik.ru
    </p>

    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A6f0d5c9189d5da0190102a3f2bb5f6e8df9f3446770da4fd1e1e3057eda00748&amp;width=100%25&amp;height=500&amp;lang=ru_RU&amp;scroll=true"></script>
    <br>

    <hr>

    <div class='footer'>
      <p>&copy; "Все права защищены"</p>
    </div>
  </div>

</body>
</html>
