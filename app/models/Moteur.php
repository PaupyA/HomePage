<?php
namespace models;
class Moteur{
	/**
	 * @id
	 * @column("name"=>"id","nullable"=>"","dbType"=>"int(11)")
	*/
	private $id;

	/**
	 * @column("name"=>"nom","nullable"=>1,"dbType"=>"varchar(45)")
	*/
	private $nom;

	/**
	 * @column("name"=>"code","nullable"=>1,"dbType"=>"text")
	*/
	private $code;

	/**
	 * @oneToMany("mappedBy"=>"moteur","className"=>"models\\Etablissement")
	*/
	private $etablissements;

	/**
	 * @oneToMany("mappedBy"=>"moteur","className"=>"models\\Site")
	*/
	private $sites;

	/**
	 * @oneToMany("mappedBy"=>"moteur","className"=>"models\\Utilisateur")
	*/
	private $utilisateurs;

	 public function getId(){
		return $this->id;
	}

	 public function setId($id){
		$this->id=$id;
	}

	 public function getNom(){
		return $this->nom;
	}

	 public function setNom($nom){
		$this->nom=$nom;
	}

	 public function getCode(){
		return $this->code;
	}

	 public function setCode($code){
		$this->code=$code;
	}

	 public function getEtablissements(){
		return $this->etablissements;
	}

	 public function setEtablissements($etablissements){
		$this->etablissements=$etablissements;
	}

	 public function getSites(){
		return $this->sites;
	}

	 public function setSites($sites){
		$this->sites=$sites;
	}

	 public function getUtilisateurs(){
		return $this->utilisateurs;
	}

	 public function setUtilisateurs($utilisateurs){
		$this->utilisateurs=$utilisateurs;
	}

	 public function __toString(){
		return $this->id;
	}

}