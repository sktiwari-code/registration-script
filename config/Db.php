<?php
include_once('config.php');
class Db 
{
	private $host=HOST;
	private $user=USER;
	private $pass=PASS;
	private $db=DB;
	protected $conn=null;

	public function __construct()
	{
		return $this->connection();
	}

/*********************************************
	Conncetion define
/**********************************************/

	private function connection()
	{
		$this->conn= new Mysqli($this->host,$this->user,$this->pass,$this->db);
		
		if ($this->conn) {
			
			return $this->conn;
		}
		else
		{
			echo "Not connected";
		}
	}
	public function Close()
	{  
            mysql_close();  
    }
	
/*********************************************
	Error msg define
/**********************************************/

	public static function showMessage($msg)
	{  
           
		   switch($msg){
			case 'ins':
			
			return '<div class="alert alert-success alert-dismissible fade show"><strong>Success!</strong> Data has been inserted successfully.<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
			break;
			
			
			case 'inf':
			
			return '<div class="alert alert-warning alert-dismissible fade show"><strong>Warning!</strong> Data not inserted successfully.<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
			break;

			case 'ups':
			
			return '<div class="alert alert-success alert-dismissible fade show"><strong>Success!</strong> Data  update successfully.<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
			break;

			case 'upf':
			
			return '<div class="alert alert-warning alert-dismissible fade show"><strong>Warning!</strong> Data not updated.<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
			break;
			case 'pwf':
			
			return '<div class="alert alert-warning alert-dismissible fade show"><strong>Warning!</strong> Enter wrong credentials.<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
			break;
			case 'exists':
			
			return '<div class="alert alert-warning alert-dismissible fade show"><strong>Warning!</strong> Field Already Exists.<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
			break;  
		   }
		   
		   
		   
    }
	
	
	
}
