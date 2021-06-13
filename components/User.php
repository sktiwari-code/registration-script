<?php

class User extends CommonFunction
{
	public $conn;
	public static $instance;
	public function __construct()
	{
		$this->conn=parent::__construct();
		self::$instance=$this;
	}

	public static function getinstance()
	{
		if(self::$instance===NULL)
		{
			self::$instance=new self();
		}
		return self::$instance;
	}

	/*******************************************
	 Insert User and edit code
	*****************************************/

	/****************************************************
		Insert User form code
	****************************************************/
	public function register_validate($post)
	{
		$errorMessage=array();
		$rs_fullname = filter_var($post["rs_fullname"], FILTER_SANITIZE_STRING);
		$rs_email = filter_var($post["rs_email"], FILTER_SANITIZE_EMAIL);
		$rs_password = filter_var($post["rs_password"], FILTER_SANITIZE_STRING);
		$rs_country = filter_var($post["rs_country"], FILTER_SANITIZE_NUMBER_INT);
		$rs_state = filter_var($post["rs_state"], FILTER_SANITIZE_NUMBER_INT);
		$rs_city = filter_var($post["rs_city"], FILTER_SANITIZE_NUMBER_INT);
		$rs_termcondition = filter_var($post["rs_termcondition"], FILTER_SANITIZE_NUMBER_INT);
    	$valid=true;
		   if(empty($rs_fullname))
    		{
    			$errorMessage['rs_fullname_error'] = "FullName is required.";
	        	$valid = false;
    		}

    		if(empty($rs_email))
    		{
    			$errorMessage['rs_email_error'] = "Email is required.";
	        	$valid = false;
    		}

    		if(empty($rs_password))
    		{
    			$errorMessage['rs_password_error'] = "*Password is required.";
	        	$valid = false;
    		}

    		if(empty($rs_country))
    		{
    			$errorMessage['rs_country_error'] = "*Country is required.";
	        	$valid = false;
    		}

    		if(empty($rs_state))
    		{
    			$errorMessage['rs_state_error'] = "*State is required.";
	        	$valid = false;
    		}

    		if(empty($rs_city))
    		{
    			$errorMessage['rs_city_error'] = "*City is required.";
	        	$valid = false;
    		}

    		if($valid)
    		{
    			
    			if(isset($rs_email) && !empty($rs_email) && !filter_var($rs_email, FILTER_VALIDATE_EMAIL))
    			{
    				$errorMessage['rs_email']= "* Please Enter Valid Email Address.";
	        		$valid = false;
    			}
    		}

    		if ($valid == false) {
	            return $errorMessage;
	        }

	        return $errorMessage;
	}

	public function UserEmailExistsOrNot($email)
	{
		$data=array();
		$errorMessage=array();
		$reg_email=filter_var($email, FILTER_SANITIZE_EMAIL);

	   $sql="SELECT COUNT(`id`) AS rowCOUNT FROM `rs_user` WHERE `email`='".$reg_email."' AND `status`='1' AND `view` = 1";
		
		$result=$this->conn->query($sql);
		$data=$result->fetch_assoc();
		if($data["rowCOUNT"] > 0)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public function UserEmailExistsOrNotByUsercode($email,$usercode)
	{
		$data=array();
		$errorMessage=array();
		$reg_email=filter_var($email, FILTER_SANITIZE_EMAIL);

	   $sql="SELECT COUNT(`id`) AS rowCOUNT FROM `rs_user` WHERE `email`='".$reg_email."' AND `status`='1' AND `view` = 1 AND `user_code`!='".$usercode."'";
		
		$result=$this->conn->query($sql);
		$data=$result->fetch_assoc();
		if($data["rowCOUNT"] > 0)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public function registerUser($post)
	{
		$rs_fullname = strtolower(filter_var($post["rs_fullname"], FILTER_SANITIZE_STRING));
		$rs_lastname = strtolower(filter_var($post["rs_lastname"], FILTER_SANITIZE_STRING));
		$rs_email = filter_var($post["rs_email"], FILTER_SANITIZE_EMAIL);
		$rs_password = filter_var($post["rs_password"], FILTER_SANITIZE_STRING);
		$rs_password_update=password_hash($rs_password, PASSWORD_DEFAULT);
		$rs_country = filter_var($post["rs_country"], FILTER_SANITIZE_STRING);
		$rs_country_data=explode("_", $rs_country);
		$rs_state = filter_var($post["rs_state"], FILTER_SANITIZE_NUMBER_INT);
		$rs_city = filter_var($post["rs_city"], FILTER_SANITIZE_NUMBER_INT);
		$rs_termcondition = filter_var($post["rs_termcondition"], FILTER_SANITIZE_NUMBER_INT);
		$pdate=date('Y-m-d');
		$ptime=date('h:i A');
		$ip_address=$_SERVER['REMOTE_ADDR'];
		$usercode="RS".substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',9-2)),0,9-2);
		if(empty($post["hid"]))
		{
			$sql="INSERT INTO `rs_user`(`first_name`, `last_name`, `email`, `password`, `city`, `state`, `country_code`, `country_id`, `terms_conditions`, `user_code`, `pdate`, `ptime`,`ip_address`) VALUES ('$rs_fullname','$rs_lastname','$rs_email','$rs_password_update','$rs_city','$rs_state','".$rs_country_data["0"]."','".$rs_country_data["1"]."','$rs_termcondition','$usercode','$pdate','$ptime','$ip_address')";
			$result=$this->conn->query($sql);
			if($result)
			{
				return true;
			}
			else
			{
				return false;
			}

		}
		else
		{
			$hid = filter_var($post["hid"], FILTER_SANITIZE_STRING);
			$sql="UPDATE `rs_user` SET `first_name`='$rs_fullname',`last_name`='$rs_lastname',`email`='$rs_email',`password`='$rs_password_update',`city`='$rs_city',`state`='$rs_state',`country_code`='".$rs_country_data["0"]."',`country_id`='".$rs_country_data["1"]."',`terms_conditions`='$rs_termcondition',`user_code`='$usercode',`pdate`='$pdate',`ptime`='$ptime',`ip_address`='$ip_address' WHERE `id`='$hid'";
			$result=$this->conn->query($sql);
			if($result)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
	}

	public function getTotalNumberOfRecordUser()
	{

		$data=array();
		$sql="SELECT COUNT(*) AS rowCount FROM `rs_user` WHERE `view`='1'";
		$result=$this->conn->query($sql);
		$data=$result->fetch_assoc();
		return $data;

	}

	public function getAllRecordsUser($limit)
	{

		$data=array();
		$sql="SELECT a.`id`,a.`first_name`,a.`last_name`,a.`email`,a.`status`,a.`country_code`,a.`pdate`,a.`ptime`,b.`name` AS country_name,c.`name` AS state_name,d.`name` as city_name FROM `rs_user` a JOIN `rs_countries` b ON a.`country_id`=b.`id` JOIN `rs_states` c ON a.`state`=c.`id` JOIN `rs_cities` d ON a.`city`=d.`id` WHERE a.`view`='1' ORDER BY a.`id` DESC LIMIT $limit";
		$result=$this->conn->query($sql);
		if($result->num_rows>0)
		{
			while ($row=$result->fetch_assoc()) {
				$data[]=$row;
			}

			return $data;
		}
		else
		{
			return false;
		}
	}

	public function getTotalNumberOfRecordUserAjax($wheresql,$orderbysql)
	{

		$data=array();
		$sql="SELECT COUNT(*) AS rowCount FROM `rs_user` a JOIN `rs_countries` b ON a.`country_id`=b.`id` JOIN `rs_states` c ON a.`state`=c.`id` JOIN `rs_cities` d ON a.`city`=d.`id` $wheresql $orderbysql";
		$result=$this->conn->query($sql);
		$data=$result->fetch_assoc();
		return $data;

	}

	public function getAllRecordsUserAjax($limit,$wheresql,$orderbysql,$offset)
	{

		$data=array();
		$sql="SELECT a.`id`,a.`first_name`,a.`last_name`,a.`email`,a.`status`,a.`country_code`,a.`pdate`,a.`ptime`,b.`name` AS country_name,c.`name` AS state_name,d.`name` as city_name FROM `rs_user` a JOIN `rs_countries` b ON a.`country_id`=b.`id` JOIN `rs_states` c ON a.`state`=c.`id` JOIN `rs_cities` d ON a.`city`=d.`id` $wheresql $orderbysql LIMIT $offset,$limit";
		$result=$this->conn->query($sql);
		if($result->num_rows>0)
		{
			while ($row=$result->fetch_assoc()) {
				$data[]=$row;
			}

			return $data;
		}
		else
		{
			return false;
		}
	}

}/*end class*/

?>