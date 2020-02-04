<?php 

  function saveRequest ($username, $email, $subject, $message) {
    $link = mysqli_connect('127.0.0.1', 'root');
    mysqli_select_db($link, 'podokonnik');
    $query = "INSERT INTO `userMessages` (`name`, `email`, `subject`, `message`) VALUES ('$username', '$email', '$subject', '$message')";
    $result = mysqli_query($link, $query);
    mysqli_close($link);
  }
?>
