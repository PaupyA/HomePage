<?php
namespace models;
class Site{
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
	 * @column("name"=>"latitude","nullable"=>1,"dbType"=>"double")
	*/
	private $latitude;

	/**
	 * @column("name"=>"longitude","nullable"=>1,"dbType"=>"double")
	*/
	private $longitude;

	/**
	 * @column("name"=>"ecart","nullable"=>1,"dbType"=>"double")
	*/
	private $ecart;

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
	 * @column("name"=>"options","nullable"=>1,"dbType"=>"varchar(255)")
	*/
	private $options;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\\Moteur","name"=>"idMoteur","nullable"=>"")
	*/
	private $moteur;

	/**
	 * @oneToMany("mappedBy"=>"site","className"=>"models\\Lienweb")
	*/
	private $lienwebs;

	/**
	 * @oneToMany("mappedBy"=>"site","className"=>"models\\Reseau")
	*/
	private $reseaus;

	/**
	 * @oneToMany("mappedBy"=>"site","className"=>"models\\Utilisateur")
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

	 public function getMoteur(){
		return $this->moteur;
	}

	 public function setMoteur($moteur){
		$this->moteur=$moteur;
	}

	 public function getLienwebs(){
		return $this->lienwebs;
	}

	 public function setLienwebs($lienwebs){
		$this->lienwebs=$lienwebs;
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

	 public function __toString(){
		return $this->id;
	}

}