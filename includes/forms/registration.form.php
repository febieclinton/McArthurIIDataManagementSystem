<?php
include('../autoloader.inc.php');

if(isset($_POST['submit-next']))
{
  $fname =  $_POST['fname'];
  $mname = $_POST['mname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $level = $_POST['level'];
  $confpass = $_POST['confpass'];

  if($_POST['level'] === null)
  {
    header("Location: ../register.php?error=nullposition&fname=".$fname."&mname=".$mname."&lname=".$lname."&email=".$email);
    exit();
  }

  if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z]*$/", $fname) && !preg_match("/^[a-zA-Z]*$/", $mname) && !preg_match("/^[a-zA-Z]*$/", $lname))
  {
    header("Location: ../register.php?error=invalidemailfirstnamemiddlenamelastname");
    exit();
  }
  else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
  {
    header("Location: ../register.php?error=invalidemail&fname=".$fname."&mname=".$mname."&lname".$lname."&level=".$level);
    exit();
  }
  else if(!preg_match("/^[a-zA-Z\s]*$/", $fname))
  {
    header("Location: ../register.php?error=invalidfirstname&lname=".$lname."&mname=".$mname."&email=".$email."&level=".$level);
    exit();
  }
  else if(!preg_match("/^[a-zA-Z]*$/",$lname))
  {
    header("Location: ../register.php?error=invalidlastname&fname=".$fname."&mname=".$mname."&email=".$email."&level=".$level);
    exit();
  }
  else if(!preg_match("/^[a-zA-Z]*$/",$mname))
  {
    header("Location: ../register.php?error=invalidmiddlename&fname=".$fname."&lname=".$lname."&email=".$email."&level=".$level);
    exit();
  }
  else if($pass !== $confpass)
  {
    header("Location: ../register.php?error=passwordmissmatch&fname=".$fname."&mname=".$mname."&lname=".$lname."&email=".$email."&level=".$level);
    exit();
  }
  else
  {
    $obj = new User();
    $same =$obj->emailChecker($email);

    if($same != null)
    {
      header("Location: ../register.php?error=emailtaken&fname=".$fname."&mname=".$mname."&lname=".$lname."&level=".$level);
      exit();
    }
  }

  $hashedpass = password_hash($pass, PASSWORD_DEFAULT);
  $obj = new User();
  $obj->setUserInfo($hashedpass, $lname,$mname, $fname, $level, $email);

  $id =$obj->emailChecker($email);
  session_start();
  $_SESSION['user_id'] = $id['user_id'];
  $_SESSION['user_level'] = $id['level'];



  header("Location: ../register2.php?fullyoperational");
  exit();


}
else
{
  header("Location: ../login.php");
  exit();
}
