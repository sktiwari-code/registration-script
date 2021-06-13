<?php 
  header('Content-Type: application/json');
  include_once 'config/Db.php';
  include_once 'autoload.php';
  $userObj=User::getinstance();
  $json = array();

  if(isset($_POST['userid']) && !empty($_POST['userid']))
    {

      $userArr=$userObj->getUserName(filter_var($_POST['userid'], FILTER_VALIDATE_INT));
      if(!empty($userArr))
      {
        $json["firstname"]=$userArr[0]["first_name"];
        $json["lastname"]=$userArr[0]["last_name"];
        $json["email"]=$userArr[0]["email"];
        $json["usercode"]=$userArr[0]["user_code"];
        $json["country"]=$userArr[0]["country_code"]."_".$userArr[0]["country_id"];
        $json["state"]=$userArr[0]["state"];
        $json["city"]=$userArr[0]["city"];
        $json["termsconditions"]=$userArr[0]["terms_conditions"];
        echo json_encode($json);
      }
      
    }