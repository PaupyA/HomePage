<?php
/**
 * Created by PhpStorm.
 * User: roullandq
 * Date: 02/10/2017
 * Time: 10:02
 */

namespace controllers;


use micro\orm\DAO;
use Ajax\JsUtils;
use micro\utils\RequestUtils;
use models\Site;

/**
 * Controller UseController
 * @property JsUtils $jquery
 */


class SitesController extends ControllerBase
{
    /**
     * @route("/home")
     */

    public function index() {
        $this->loadView("sites/index.html");
    }

    /**
     * @route("/listeSites","cache"=>true,"duration"=>15)
     */

    public function all(){
        $sites=DAO::getAll("models\Site");
        $semantic=$this->jquery->semantic();
        $table=$semantic->dataTable("site", "models\Site", $sites);
        $table->setFields(["nom","latitude","longitude"]);
        $table->setCaptions(["Nom de l'établissement","Latitude","Longitude"]);
        $table->addEditButton(false);
        $table->setUrls(["edit"=>"editSite"]);
        $table->setTargetSelector("#site");

        echo $table->compile($this->jquery);
        echo $this->jquery->compile();
    }

    /**
     * @route("addSite/.*?")
     */

    public function addSite() {
        $semantic=$this->jquery->semantic();
        $site=new Site();
        $form=$semantic->dataForm("frmSite", $site);
        $form->setFields(["nom\n","latitude","longitude","ecart\n","fondEcran","couleur\n","ordre","options","submit"]);
        $form->setCaptions(["Nom de l'établissement","Latitude","Longitude","Ecart","Fond d'écran","Couleur","Ordre","Options","Valider"]);
        $form->fieldAsSubmit("submit","green","newSite/","#divSite");
        echo "<div id='divSite'></div>";
        echo $form->compile($this->jquery);
        echo $this->jquery->compile();

    }

    /**
     * @route("newSite/.*?")
     */

    public function newSite() {
        $site=new Site();
        RequestUtils::setValuesToObject($site,$_POST);
        if(DAO::insert($site)){
            echo $site->getNom()." ajouté";
        }
    }

    /**
     * @route("editSite/.*?")
     */

    public function editSite() {
        $semantic=$this->jquery->semantic();
        $site = DAO::getOne("models\Site", 1);
        $form=$semantic->dataForm("frmSite", $site);
        $form->setFields(["nom\n","latitude","longitude","ecart\n","fondEcran","couleur\n","ordre","options","submit"]);
        $form->setCaptions(["Nom de l'établissement","Latitude","Longitude","Ecart","Fond d'écran","Couleur","Ordre","Options","Valider"]);
        $form->fieldAsSubmit("submit","green","updateSite/","#divSite");
        echo "<div id='divSite'></div>";
        echo $form->compile($this->jquery);
        echo $this->jquery->compile();

    }

    public function updateSite() {
        $site=DAO::update();
        RequestUtils::setValuesToObject($site,$_POST);
        if(DAO::insert($site)){
            echo $site->getNom()." ajouté";
        }
    }


}