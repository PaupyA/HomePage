<?php
namespace models;
class Moteur{
	/**
	 * @id
	*/
	private $id;

	private $nom;

	private $code;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\Etablissement","name"=>"idEtablissement","nullable"=>false)
	*/
	private $etablissement;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\Site","name"=>"idSite","nullable"=>false)
	*/
	private $site;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\Utilisateur","name"=>"idUtilisateur","nullable"=>false)
	*/
	private $utilisateur;

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

}