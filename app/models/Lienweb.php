<?php
namespace models;
class Lienweb{
	/**
	 * @id
	 * @column("name"=>"id","nullable"=>"","dbType"=>"int(11)")
	*/
	private $id;

	/**
	 * @column("name"=>"libelle","nullable"=>1,"dbType"=>"varchar(150)")
	*/
	private $libelle;

	/**
	 * @column("name"=>"url","nullable"=>1,"dbType"=>"varchar(255)")
	*/
	private $url;

	/**
	 * @column("name"=>"ordre","nullable"=>1,"dbType"=>"int(11)")
	*/
	private $ordre;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\\Etablissement","name"=>"idEtablissement","nullable"=>"")
	*/
	private $etablissement;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\\Site","name"=>"idSite","nullable"=>"")
	*/
	private $site;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\\Utilisateur","name"=>"idUtilisateur","nullable"=>"")
	*/
	private $utilisateur;

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

	 public function getUrl(){
		return $this->url;
	}

	 public function setUrl($url){
		$this->url=$url;
	}

	 public function getOrdre(){
		return $this->ordre;
	}

	 public function setOrdre($ordre){
		$this->ordre=$ordre;
	}

	 public function getEtablissement(){
		return $this->etablissement;
	}

	 public function setEtablissement($etablissement){
		$this->etablissement=$etablissement;
	}

	 public function getSite(){
		return $this->site;
	}

	 public function setSite($site){
		$this->site=$site;
	}

	 public function getUtilisateur(){
		return $this->utilisateur;
	}

	 public function setUtilisateur($utilisateur){
		$this->utilisateur=$utilisateur;
	}

	 public function __toString(){
		return $this->id;
	}

}