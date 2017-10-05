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


    public function all(){
        $semantic=$this->jquery->semantic();
        $bt=$semantic->htmlButton("btAddSite","Ajouter un site");
        $bt->onClick("addSite");
        $sites=DAO::getAll("models\Site");
        $semantic=$this->jquery->semantic();
        $table=$semantic->dataTable("site", "models\Site", $sites);
        $table->setIdentifierFunction(function($i,$o){return $o->getId();});
        $table->setFields(["nom","latitude","longitude","id"]);
        $table->setCaptions(["Nom de l'établissement","Latitude","Longitude"]);
        $table->addEditButton(false);
        $table->setUrls(["edit"=>"SitesController/editSite","delete"=>"SitesController/deleteSite"]);
        $table->setTargetSelector("#site");
        $table->addDeleteButton(false);
        $table->fieldAsHidden("id");
        echo "</br>". $bt;
        echo $table->compile($this->jquery);
        echo $this->jquery->compile();
    }



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
    public function newSite() {
        $site=new Site();
        RequestUtils::setValuesToObject($site,$_POST);
        if(DAO::insert($site)){
            echo $site->getNom()." ajouté";
        }
    }



    public function editSite($id) {
        $semantic=$this->jquery->semantic();
        $site = DAO::getOne("models\Site",$id  );
        $form=$semantic->dataForm("frmSite", $site);
        $form->setFields(["nom\n","latitude","longitude","ecart\n","fondEcran","couleur\n","ordre","options","submit"]);
        $form->setCaptions(["Nom de l'établissement","Latitude","Longitude","Ecart","Fond d'écran","Couleur","Ordre","Options","Valider"]);
        $form->fieldAsSubmit("submit","green","SitesController/updateSite/".$id,"#divSite");
        echo "<div id='divSite'></div>";
        echo $form->compile($this->jquery);
        echo $this->jquery->compile();

    }
    public function updateSite($id) {
        $site = DAO::getOne("models\Site",$id );
        RequestUtils::setValuesToObject($site,$_POST);
        if(DAO::update($site)){
            echo $site->getNom()." modifié";
        }

    }


    public function deleteSite($id) {

        $site = DAO::getOne("models\Site",$id );
        if(DAO::remove($site)) {
            echo $site->getNom()." supprimé";
        }
    }


}