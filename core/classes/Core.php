<?php
class Core{
	// Création de propriétés en "protected"
	protected $db, $result;
	private $rows;
	
	public function __construct(){
		// Connexion à la base de données.
		$this->db = new mysqli('localhost', 'c0pass', 'wtngkHXD_H6', 'c0passionate');	
	}

	public function query($sql){
		$this->result = $this->db->query($sql);		
	}
	
	public function rows(){
		for($x = 1; $x <= $this->db->affected_rows; $x++){
			$this->rows[] = $this->result->fetch_assoc();
		}
		
		return $this->rows;
	}
}	

					
					
				