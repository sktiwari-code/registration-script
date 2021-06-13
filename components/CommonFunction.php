<?php

class CommonFunction extends Db
{
	public $conn;
	public static $instance;
	public function __construct()
	{
		$this->conn=parent::__construct();
		return $this->conn;
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

	/********************************************
		Get State name
	***********************************************/

	public function getStateName($id=NULL,$countryid=NULL)
	{
		$whereid="";
		$whereconid="";
		$data=array();
		if(!empty($id))
		{
			$whereid=" AND `id`=".$id;
		}
		if(!empty($countryid))
		{
			$whereconid=" AND `country_id`=".$countryid;
		}
		$sql="SELECT * FROM `rs_states` WHERE `view`='1' $whereid $whereconid ORDER BY `name` ASC";
		$result=$this->conn->query($sql);
		if($result->num_rows>0)
		{
			while ($row=$result->fetch_assoc()) {
				$data[]=$row;
			}
		}
		return $data;

	}

/********************************************
		Get City name
	***********************************************/

	public function getCityName($id=NULL,$stateid=NULL)
	{
		$whereid="";
		$wherestateid="";
		$data=array();
		if(!empty($id))
		{
			$whereid=" AND `id`=".$id;
		}
		if(!empty($stateid))
		{
			$wherestateid=" AND `state_id`=".$stateid;
		}
		$sql="SELECT * FROM `rs_cities` WHERE `view`='1' $whereid $wherestateid ORDER BY `name` ASC";
		$result=$this->conn->query($sql);
		if($result->num_rows>0)
		{
			while ($row=$result->fetch_assoc()) {
				$data[]=$row;
			}
		}
		return $data;

	}


	/********************************************
		Get User name
	***********************************************/

	public function getUserName($id=NULL)
	{
		$where="";
		$data=array();
		if(!empty($id))
		{
			$where="AND `id`=".$id;
		}
		$sql="SELECT * FROM `rs_user` WHERE `view`='1' $where";
		$result=$this->conn->query($sql);
		if($result->num_rows>0)
		{
			while ($row=$result->fetch_assoc()) {
				$data[]=$row;
			}
		}
		return $data;

	}

	/***********************************************
	 Get Table Records For Pagination
	************************************************/

	public function getTotalNumberOfRecordAnyTable($table)
	{

		$data=array();
		$sql="SELECT COUNT(*) AS rowCount FROM $table WHERE `view`='1'";
		$result=$this->conn->query($sql);
		$data=$result->fetch_assoc();
		return $data;

	}

	public function getAllRecordsAnyTable($table,$limit)
	{

		$data=array();
		$sql="SELECT * FROM $table WHERE `view`='1' ORDER BY `id` DESC LIMIT $limit";
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

	public function getTotalNumberOfRecordAnyTableAjax($table,$where,$orderby)
	{

		$data=array();
		$sql="SELECT COUNT(*) AS rowCount FROM $table $where $orderby";
		$result=$this->conn->query($sql);
		$data=$result->fetch_assoc();
		return $data;

	}

	public function getAllRecordsAnyTableAjax($table,$limit=NULL,$where,$orderby,$offset)
	{

		$data=array();
		$sql="SELECT * FROM $table $where $orderby LIMIT $offset,$limit";
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


	/********************************************
		Get country name
	***********************************************/

	public function getCountryName($id=NULL)
	{
		$where="";
		$data=array();
		if(!empty($id))
		{
			$where="AND `id`=".$id;
		}
		$sql="SELECT * FROM `rs_countries` WHERE `status`='1' AND `view`='1' $where ORDER BY `name` ASC";
		$result=$this->conn->query($sql);
		if($result->num_rows>0)
		{
			while ($row=$result->fetch_assoc()) {
				$data[]=$row;
			}
		}
		return $data;

	}

	/********************************************
		Get State name By country id
	***********************************************/

	public function getStateNameByCountryId($id=NULL)
	{
		$where="";
		$data=array();
		if(!empty($id))
		{
			$where="AND `country_id`=".$id;
		}
		$sql="SELECT * FROM `rs_state` WHERE `view`='1' $where ORDER BY `name` ASC";
		$result=$this->conn->query($sql);
		if($result->num_rows>0)
		{
			while ($row=$result->fetch_assoc()) {
				$data[]=$row;
			}
		}
		return $data;

	}


}/*end classs*/

?>