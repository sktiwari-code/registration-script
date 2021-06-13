<?php 
  header('Content-Type: application/json');
  include_once 'config/Db.php';
  include_once 'autoload.php';
  $userObj=User::getinstance();
  $json = array();


/*************************** get ajax form request **********************************/

if(isset($_POST['rs_email']) && !empty($_POST['rs_email']) && isset($_POST['rs_password']) && !empty($_POST['rs_password']))
{
   $json['status'] = true;
   $errormessage = $userObj->register_validate($_POST);
   if(empty($errormessage))
   {
       $email = filter_var($_POST["rs_email"], FILTER_SANITIZE_EMAIL);
       if(empty($_POST["hid"]))
       {
           $checkEmailExists = $userObj->UserEmailExistsOrNot($email);
           if($checkEmailExists)
           {
             $json['status'] = false;
             $json['errors']['rs_email_error'] = "* Email is already regsitered.";
           }
       }
        if(!empty($_POST["hid"]))
       {
            $usercode=filter_var($_POST["hid"], FILTER_SANITIZE_STRING);
           $checkEmailExists = $userObj->UserEmailExistsOrNotByUsercode($email,$usercode);
           if($checkEmailExists)
           {
             $json['status'] = false;
             $json['errors']['rs_email_error'] = "* Email is already regsitered.";
           }
       }   

       /************ insert code start ***********/

       if($json['status'] == true)
       {
          $doRegsiter = $userObj->registerUser($_POST);
          if($doRegsiter)
          {
             $json['status'] = true;
             $json['success'] = "Regsiter successfully.";
          }
          else
          {
            $json['status'] = false;
            $json['error'] = "Some problem occurred. Please try again!";
          }
       }
   }
   else
   {
      $json['status'] = false;
      $json['errors'] =$errormessage;
   }
   echo json_encode($json);
}
else
{
  $json['status'] = false;
  $json['error'] = 'Please try again!';
  echo json_encode($json);
}

?>