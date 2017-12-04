<?php
namespace models;
class Reseau{
	/**
	 * @id
	 * @column("name"=>"id","nullable"=>"","dbType"=>"int(11)")
	*/
	private $id;

	/**
	 * @column("name"=>"ip","nullable"=>1,"dbType"=>"varchar(15)")
	*/
	private $ip;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\\Site","name"=>"idSite","nullable"=>"")
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

	 public function __toString(){
		return $this->id;
	}

}