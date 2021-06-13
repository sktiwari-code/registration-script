<?php 
  include_once 'config/Db.php';
  include_once 'autoload.php';
  $userObj=User::getinstance();
  echo '<option value="">Choose One</option>';
  if(isset($_POST["stateid"]) && !empty($_POST["stateid"]))
  {
  	 $stateid=filter_var($_POST["stateid"], FILTER_VALIDATE_INT);
  	 $cityArr=$userObj->getCityName('0',$stateid);
  	 if(!empty($cityArr)):
  	 foreach ($cityArr as $cityData) {
 ?>
  	 <option value="<?= $cityData["id"];?>"><?= ucwords($cityData["name"]);?></option>
<?php
}endif;
  }
?>