<?php
namespace models;
class Reseau{
	/**
	 * @id
	*/
	private $id;

	private $ip;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\Site","name"=>"idSite","nullable"=>false)
	*/
	private $site;

	 public function getId(){
		return $this->id;
	}

	 public function setId($id){
		$this->id=$id;
	}

	 public function getIp(){
		return $this->ip;
	}

	 public function setIp($ip){
		$this->ip=$ip;
	}

	 public function getSite(){
		return $this->site;
	}

	 public function setSite($site){
		$this->site=$site;
	}

}