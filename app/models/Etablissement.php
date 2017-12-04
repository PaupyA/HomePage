<?php
namespace models;
class Etablissement{
	/**
	 * @id
	 * @column("name"=>"id","nullable"=>"","dbType"=>"int(11)")
	*/
	private $id;

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
	 * @oneToMany("mappedBy"=>"etablissement","className"=>"models\\Lienweb")
	*/
	private $lienwebs;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\\Moteur","name"=>"idMoteur","nullable"=>"")
	*/
	private $moteur;

	 public function getId(){
		return $this->id;
	}

	 public function setId($id){
		$this->id=$id;
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

	 public function getMoteur(){
		return $this->moteur;
	}

	 public function setMoteur($moteur){
		$this->moteur=$moteur;
	}

	 public function __toString(){
		return $this->id;
	}

}