<?php
namespace models;
class Utilisateur{
	/**
	 * @id
	 * @column("name"=>"id","nullable"=>"","dbType"=>"int(11)")
	*/
	private $id;

	/**
	 * @column("name"=>"login","nullable"=>1,"dbType"=>"varchar(45)")
	*/
	private $login;

	/**
	 * @column("name"=>"password","nullable"=>1,"dbType"=>"varchar(45)")
	*/
	private $password;

	/**
	 * @column("name"=>"elementsMasques","nullable"=>1,"dbType"=>"varchar(255)")
	*/
	private $elementsMasques;

	/**
	 * @column("name"=>"fondEcran","nullable"=>1,"dbType"=>"varchar(255)")
	*/
	private $fondEcran;

	/**
	 * @column("name"=>"couleur","nullable"=>1,"dbType"=>"varchar(10)")
	*/
	private $couleur;

	/**
	 * @column("name"=>"ordre","nullable"=>1,"dbType"=>"varchar(255)")
	*/
	private $ordre;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\\Moteur","name"=>"idMoteur","nullable"=>"")
	*/
	private $moteur;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\\Site","name"=>"idSite","nullable"=>"")
	*/
	private $site;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\\Statut","name"=>"idStatut","nullable"=>"")
	*/
	private $statut;

	/**
	 * @oneToMany("mappedBy"=>"utilisateur","className"=>"models\\Lienweb")
	*/
	private $lienwebs;

	 public function getId(){
		return $this->id;
	}

	 public function setId($id){
		$this->id=$id;
	}

	 public function getLogin(){
		return $this->login;
	}

	 public function setLogin($login){
		$this->login=$login;
	}

	 public function getPassword(){
		return $this->password;
	}

	 public function setPassword($password){
		$this->password=$password;
	}

	 public function getElementsMasques(){
		return $this->elementsMasques;
	}

	 public function setElementsMasques($elementsMasques){
		$this->elementsMasques=$elementsMasques;
	}

	 public function getFondEcran(){
		return $this->fondEcran;
	}

	 public function setFondEcran($fondEcran){
		$this->fondEcran=$fondEcran;
	}

	 public function getCouleur(){
		return $this->couleur;
	}

	 public function setCouleur($couleur){
		$this->couleur=$couleur;
	}

	 public function getOrdre(){
		return $this->ordre;
	}

	 public function setOrdre($ordre){
		$this->ordre=$ordre;
	}

	 public function getMoteur(){
		return $this->moteur;
	}

	 public function setMoteur($moteur){
		$this->moteur=$moteur;
	}

	 public function getSite(){
		return $this->site;
	}

	 public function setSite($site){
		$this->site=$site;
	}

	 public function getStatut(){
		return $this->statut;
	}

	 public function setStatut($statut){
		$this->statut=$statut;
	}

	 public function getLienwebs(){
		return $this->lienwebs;
	}

	 public function setLienwebs($lienwebs){
		$this->lienwebs=$lienwebs;
	}

	 public function __toString(){
		return $this->id;
	}

}