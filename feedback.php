<?php

  ob_start();

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

  if($_SERVER['REQUEST_METHOD'] == 'POST') {  
    $username = $_POST['username'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $username = clean($username);
    $email = clean($email);
    $subjet = clean($subject);
    $message = clean($message);
    
    if(!empty($username) && !empty($email) && !empty($subject) && !empty($message)) {
      $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL); 
      
      if(check_length($username, 2, 25) && check_length($subject, 2, 50) && check_length($message, 2, 1000) && $email_validate) {
          echo "Спасибо за сообщение";
          header("refresh:2;url=http://chrrpck.com/podokonnik/feedback.php");
      } else {
        echo "Введенные данные некорректны";
        header("refresh:2;url=http://chrrpck.com/podokonnik/feedback.php");
      }
    } else {
      echo "Заполните пустые поля";
      header("refresh:2;url=http://chrrpck.com/podokonnik/feedback.php");
    }
  } else {
    header("refresh:3;url=http://chrrpck.com/podokonnik/contacts.html");
    }
?>
