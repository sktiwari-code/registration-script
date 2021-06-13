<?php 
  include_once 'config/Db.php';
  include_once 'autoload.php';
  $userObj=User::getinstance();
  echo '<option value="">Choose One</option>';
  if(isset($_POST["countryid"]) && !empty($_POST["countryid"]))
  {
  	 $countryid=filter_var($_POST["countryid"], FILTER_VALIDATE_INT);
  	 $stateArr=$userObj->getStateName('0',$countryid);
  	 if(!empty($stateArr)):
  	 foreach ($stateArr as $stateData) {
 ?>
  	 <option value="<?= $stateData["id"];?>"><?= ucwords($stateData["name"]);?></option>
<?php
}endif;
  }
?>