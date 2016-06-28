<?php

	function connect(){ 
		$conf = include_once('config.php');
		try 
        {
			$db = new PDO(($conf["database"].":host=".$conf["host"].";dbname=".$conf["db_name"]), $conf["user"], $conf["password"]);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) 
        {
            echo $e->getMessage();

        }
		return $db;
	}
?>