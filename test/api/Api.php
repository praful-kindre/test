<?php

//Api.php

class API
{
	private $connect = '';

	function __construct()
	{
		$this->database_connection();
	}

	function database_connection()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=school", "root", "");
	}

	function fetch_all()
	{
		$query = "SELECT * FROM student ORDER BY STUDENT_NO ";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	function insert()
	{
		if(isset($_POST["student_name"]))
		{
			$form_data = array(
				':STUDENT_NAME'		=>	$_POST["student_name"],
				':STUDENT_DOB'		=>	$_POST["student_dob"],
				':STUDENT_DOJ'		=>	$_POST["student_doj"]
			);
			$query = "
			INSERT INTO student 
			(STUDENT_NAME, STUDENT_DOB, STUDENT_DOJ) VALUES 
			(:STUDENT_NAME, :STUDENT_DOB, :STUDENT_DOJ)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}

	function fetch_single($id)
	{
		$query = "SELECT * FROM student WHERE STUDENT_NO='".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{
				$data['student_name'] = $row['STUDENT_NAME'];
				$data['student_dob'] = $row['STUDENT_DOB'];
				$data['student_doj'] = $row['STUDENT_DOJ'];
			}
			return $data;
		}
	}

	function update()
	{
		if(isset($_POST["student_name"]))
		{
			// print_r($_POST);
			$form_data = array(
				':STUDENT_NAME'		=>	$_POST["student_name"],
				':STUDENT_DOB'		=>	$_POST["student_dob"],
				':STUDENT_DOJ'		=>	$_POST["student_doj"],
				':STUDENT_NO'		=>	$_POST['id'],
			);
			$query = "UPDATE student 	
			SET STUDENT_NAME = :STUDENT_NAME, STUDENT_DOB = :STUDENT_DOB, STUDENT_DOJ = :STUDENT_DOJ 
			WHERE STUDENT_NO = :STUDENT_NO";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
	function delete($id)
	{
		$query = "DELETE FROM student WHERE STUDENT_NO = '".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			$data[] = array(
				'success'	=>	'1'
			);
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
}

?>
