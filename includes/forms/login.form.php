<?php
include('../autoloader.inc.php');

if(isset($_POST['login-user']))
{
  $email = $_POST['email'];
  $pass = $_POST['pass'];


  if(!filter_var($email, FILTER_VALIDATE_EMAIL))
  {
    header("Location: ../login.php?error=invalidEmail");
    exit();
  }

  else
  {
    $userObj = new User();
    $user = $userObj->emailChecker($email);

    if($user == null)
    {
      header("Location: ../login.php?error=nosuchemail");
      exit();
    }
    else
    {
      $passcheck = password_verify($pass, $user['pass_word']);

      if($passcheck == false)
      {
        header("Location: ../login.php?error=incorrectPassword&email=".$email);
        exit();
      }
      elseif($passcheck == true)
      {
          session_start();
          $_SESSION['user_id'] = $user['user_id'];
          $_SESSION['user_fname'] = $user['f_name'];
          $_SESSION['user_mname'] = $user['m_name'];
          $_SESSION['user_lname'] = $user['l_name'];
          $_SESSION['user_email'] = $user['email'];
          $_SESSION['user_level'] = $user['level'];
          header("Location: ../dashboard.php?success");
          exit();
      }
      else
      {
        header("Location: ../login.php?error=incorrectPassword&email =".$email);
        exit();
      }
    }
  }



}
else
{
  header("Location: ../login.php");
  exit();
}
