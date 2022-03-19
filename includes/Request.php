<?php
class Request {
 
    private $connection;
 
    function __construct() {
        require_once 'DbConnection.php';
        $db = new DbConnection();
        $this->connection = $db->connect();
    }

    //["GET"]
	function getcontacts(){
	    $sql=$this->connection->prepare("SELECT * FROM contacts");
        $sql->execute();
        $res = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $res; 
        $sql->close();
        $connection->close();
	}

    //["GET"?id]
	function getcontact($id){
	    $sql=$this->connection->prepare("SELECT * FROM contacts WHERE ID = :ID");
	    $sql->bindParam(':ID', $id);
        $sql->execute();
        $res = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $res; 
        $sql->close();
        $connection->close();
	}
    //["POST"]
    function addcontact($param){
	    $sql=$this->connection->prepare("INSERT INTO contacts(NAME,LASTNAME,EMAIL,CELLPHONE) VALUES(:name,:lastname,:email,:cellphone);");
	    $sql->bindParam(':name', $param["name"]);
	    $sql->bindParam(':lastname', $param["lastname"]);
	    $sql->bindParam(':email', $param["email"]);
	    $sql->bindParam(':cellphone', $param["cellphone"]);
        $sql->execute();
        $res = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return "Done."; 
        $sql->close();
        $connection->close();
	}
     //["DELETE"]
     function deletecontact($id){
	    $sql=$this->connection->prepare("DELETE FROM contacts WHERE ID = :ID");
        $sql->bindParam(':ID', $id);
        $sql->execute();
        $res = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return "Done."; 
        $sql->close();
        $connection->close();
	}

}
?>