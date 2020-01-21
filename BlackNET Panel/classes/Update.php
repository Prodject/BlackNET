<?php
class Update extends Database{
	public function create_table($table_name,$arrays,$primary=false){
		$table_syntex = "CREATE TABLE IF NOT EXISTS `$table_name` ( ";
		if(!(empty($arrays))){
			$column = "";
			foreach ($arrays as $array) {
				foreach ($array as $value) {
					$column = $column . $value . " ";
				}
			$column = $column . " " . ",";
			}
		}

		$final = $table_syntex . $column  . ($primary == true ? "PRIMARY KEY (". $arrays[0][0] .")" : "") . " ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci " .(in_array("AUTO_INCREMENT", $arrays[0]) == true ? "AUTO_INCREMENT=1" : "") . ";";
		return $final;
	}

	public function create_column($table_name,$array,$after){
		$column_syntex = "ALTER TABLE  `$table_name` ADD ";
		if(!(empty($array))){
			$column = "";
			foreach ($array as $value) {
				$column = $column . $value . " ";	
			}	
		}
		$final = $column_syntex . $column . " AFTER  `$after`;";
		return $final;
	}

	public function update_value($table_name,$column_name,$value){
		$sql = "UPDATE " . $table_name . " SET " . $column_name . " = '" .  $value . "'";
		return $sql;
	}

	public function insert_value($table_name,$columns_array){
		$sql = sprintf("INSERT INTO %s (%s) values (%s)",$table_name,implode(", ", array_keys($columns_array)) , "'" . implode("', '", array_values($columns_array)) . "'") ;
		return $sql;
	}

	public function table_exist($table_name){
		return "SHOW TABLES LIKE " . "'" . $table_name . "'";
	}

	public function column_exist($table_name,$column_name){
		return "SHOW COLUMNS FROM `$table_name` LIKE '$column_name'";
	}

	public function drop_table($table_name){
		return "DROP TABLE " . $table_name . ";";
	}

	public function execute($sql){
		try {
			$pdo = $this->Connect();
			$stmt = $pdo->prepare($sql);
			$status = $stmt->execute();
			if (strpos($sql, "SHOW") !== false) {
				if ($stmt->rowCount()) {
					return true;
				} else {
					return false;
				}
			} else {
				return $status;
			}
		} catch (Exception $e) {
			
		}
	}

}
?>