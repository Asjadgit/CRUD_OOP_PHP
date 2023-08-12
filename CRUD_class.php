<?php

class database{
	private $server = "localhost";
	private $user   = "root";
	private $pass   = "";
	private $dbname = "crud";

	private $con = ""; //database connection variable
	private $result = array(); //any error will store in this array
	// private $con = ""; // con_connection variable

	
	//Database Connection using constructor
	public function __construct()
	{
		if ($this->con == "") 
		{
			$this->con = new mysqli($this->server,$this->user,$this->pass,$this->dbname);
			
			if ($this->con->connect_error) {
				array_push($this->result, $this->con->connect_error);
				// return false;
			}
		}
		else{
			return true;
		}
	}

	//inserting records into database
	public function insert($table,$para = array())//table means table table_name and param means values inserted
	{
		if ($this->tablechk($table)) {
			// print_r($para);

			//implode function used to convert array values into string

			$arr_coloumns = implode(', ', array_keys($para));//seperate the array coloumns by ',' and return the keys i.e Name,Age

			$arr_values = implode("', '", $para);//seperate the array values by ',' and return the values i.e User,12

			//now insert query
			echo $insert = "INSERT INTO student ($arr_coloumns) VALUES ('$arr_values')";

			$chk = $this->con->query($insert);
			if ($chk) {
				array_push($this->result,$this->con->insert_id);
				return true;
			}else{
				array_push($this->result,$this->con->connect_error);
				return false;
			}

		}else{
			return false;
		}
		
	}

	//Second method to fecth records

	public function sql($table,$rows='*',$where=null,$join=null,$limit=null)
	{
		if ($this->tablechk($table)) {
			$sql = "SELECT $rows FROM $table";
		if ($join != null) {
			$sql .= " JOIN $join";
		}
		if ($where != null) {
			$sql .= " WHERE $where";
		}
		if ($limit != null) {
			$sql .= " LIMIT 0,$limit";
		}
		echo $sql;
		$query = $this->con->query($sql);
			if ($query) {
				$this->result = $query->fetch_all(MYSQLI_ASSOC);
				return true;
			}
			else{
				array_push($this->result,$this->con->connect_error);
				return false;
			}
		}
	}

	//Fecthing record from database
	public function select($table,$sql)
	{
		if ($this->tablechk($table)) {
			$select = $this->con->query($sql);
			if ($select) {
				$this->result = $select->fetch_all(MYSQLI_ASSOC);
				return true;
			}
			else{
				array_push($this->result,$this->con->connect_error);
				return false;
			}

		}else{
			return false;
		}
	}

	//updating records in database
	public function update($table,$para = array(),$where = null)
	{
		if ($this->tablechk($table)) {
			

			$arg = array();// array to store para values

			foreach ($para as $key => $value) {
				$arg[] = "$key = '$value'";//array values stored in keys 
			}

			$update = "UPDATE $table SET ".implode(', ', $arg);//seperating array values by ', ' and converting into string

			if ($where != null) {
				$update .= " WHERE $where"; //adding where clause
			}
			echo $update;
			
			$chkupd = $this->con->query($update);
			if ($chkupd) {
				array_push($this->result,$this->con->affected_rows);//how many records are updated
				return true;
			}else{
				array_push($this->result,$this->con->connect_error);
				return false;
			}
			
		}
		else{
			return false;
		}
	} 

	//deleting record from database
	public function delete($table,$where = null)
	{
		if ($this->tablechk($table)) {
			$dlt = "DELETE FROM $table";

			if ($where != null) {
				$dlt .= " WHERE $where";
			}

			$chkdlt = $this->con->query($dlt);
			if ($chkdlt) {
				array_push($this->result, $this->con->affected_rows);
				return true;
			}
			else{
				array_push($this->result,$this->con->connect_error);
				return false;
			}

		}else{
			return false;
		}
	}

	//function to check whether table existed in database or not
	 private function tablechk($table)
	 {
	 	$sql = "SHOW TABLES FROM $this->dbname LIKE '$table'";//SQL Query to check table if exists
	 	$query = $this->con->query($sql);

	 	if ($query) {
	 		//if exists then return true
	 		if ($query->num_rows == 1) {
	 			return true;
	 		}else
	 		{
	 			array_push($this->result, $table." does not exist.");
	 			return false;
	 		}

	 	}else{
	 		return false;
	 	}
	 } 

	 //show results
	 public function showresult()
	 {
	 	$val = $this->result;
	 	$result = array();
	 	print_r($val) ;
	 }

	//Connection close using destructor function
	public function __destruct()
	{
		if ($this->con) {
			if($this->con->close()){
			$this->con = "";
			return true;
			}
		}
		else{
			return false;
		}
	}
}


?>