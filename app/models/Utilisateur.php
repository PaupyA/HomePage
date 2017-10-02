<?php
namespace models;
class Utilisateur{
	/**
	 * @id
	*/
	private $id;

	private $login;

	private $password;

	private $elementsMasques;

	private $fondEcran;

	private $couleur;

	private $ordre;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\Site","name"=>"idSite","nullable"=>false)
	*/
	private $site;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\Statut","name"=>"idStatut","nullable"=>false)
	*/
	private $statut;

	/**
	 * @oneToMany("mappedBy"=>"utilisateur","className"=>"models\Lienweb")
	*/
	private $lienwebs;

	/**
	 * @oneToMany("mappedBy"=>"utilisateur","className"=>"models\Moteur")
	*/
	private $moteurs;

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

	 public function getMoteurs(){
		return $this->moteurs;
	}

	 public function setMoteurs($moteurs){
		$this->moteurs=$moteurs;
	}

}