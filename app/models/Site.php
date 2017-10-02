<?php
namespace models;
class Site{
	/**
	 * @id
	*/
	private $id;

	private $nom;

	private $latitude;

	private $longitude;

	private $ecart;

	private $fondEcran;

	private $couleur;

	private $ordre;

	private $options;

	/**
	 * @oneToMany("mappedBy"=>"site","className"=>"models\Lienweb")
	*/
	private $lienwebs;

	/**
	 * @oneToMany("mappedBy"=>"site","className"=>"models\Moteur")
	*/
	private $moteurs;

	/**
	 * @oneToMany("mappedBy"=>"site","className"=>"models\Reseau")
	*/
	private $reseaus;

	/**
	 * @oneToMany("mappedBy"=>"site","className"=>"models\Utilisateur")
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

	 public function getLatitude(){
		return $this->latitude;
	}

	 public function setLatitude($latitude){
		$this->latitude=$latitude;
	}

	 public function getLongitude(){
		return $this->longitude;
	}

	 public function setLongitude($longitude){
		$this->longitude=$longitude;
	}

	 public function getEcart(){
		return $this->ecart;
	}

	 public function setEcart($ecart){
		$this->ecart=$ecart;
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

	 public function getOptions(){
		return $this->options;
	}

	 public function setOptions($options){
		$this->options=$options;
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

	 public function getReseaus(){
		return $this->reseaus;
	}

	 public function setReseaus($reseaus){
		$this->reseaus=$reseaus;
	}

	 public function getUtilisateurs(){
		return $this->utilisateurs;
	}

	 public function setUtilisateurs($utilisateurs){
		$this->utilisateurs=$utilisateurs;
	}

}