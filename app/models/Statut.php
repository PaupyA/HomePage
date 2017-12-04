<?php
namespace models;
class Statut{
	/**
	 * @id
	 * @column("name"=>"id","nullable"=>"","dbType"=>"int(11)")
	*/
	private $id;

	/**
	 * @column("name"=>"libelle","nullable"=>"","dbType"=>"varchar(75)")
	*/
	private $libelle;

	/**
	 * @oneToMany("mappedBy"=>"statut","className"=>"models\\Utilisateur")
	*/
	private $utilisateurs;

	 public function getId(){
		return $this->id;
	}

	 public function setId($id){
		$this->id=$id;
	}

	 public function getLibelle(){
		return $this->libelle;
	}

	 public function setLibelle($libelle){
		$this->libelle=$libelle;
	}

	 public function getUtilisateurs(){
		return $this->utilisateurs;
	}

	 public function setUtilisateurs($utilisateurs){
		$this->utilisateurs=$utilisateurs;
	}

	 public function __toString(){
		return $this->libelle;
	}

}