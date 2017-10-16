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
    public function index() {
        $semantic=$this->jquery->semantic();

        echo "</br>";

        $btHome=$semantic->htmlButton("btHome","");
        $btHome->asIcon("home")->asLink("BoardController");

        $bts=$semantic->htmlButtonGroups("buttons",["Liste des sites","Ajouter un site"]);
        $bts->setPropertyValues("data-ajax", ["SitesController/all/","SitesController/addSite/"]);

        $bts->getOnClick("","#formSite",["attr"=>"data-ajax"]);

        $this->all();
        $this->jquery->compile($this->view);
        $this->loadView("sites/index.html");
    }

    public function all(){
        $semantic=$this->jquery->semantic();

        $sites=DAO::getAll("models\Site");
        $table=$semantic->dataTable("tblSites", "models\Site", $sites);

        $table->setIdentifierFunction(function($i,$o){return $o->getId();});

        $table->setFields(["nom","latitude","longitude","id"]);
        $table->setCaptions(["Nom de l'établissement","Latitude","Longitude"]);

        $table->addEditButton(false);
        $table->addDeleteButton(false);
        $table->setUrls(["edit"=>"SitesController/editSite","delete"=>"SitesController/deleteSite"]);
        $table->setTargetSelector("#formSite");
        $table->fieldAsHidden("id");
    }

    public function addSite() {
        $semantic=$this->jquery->semantic();

        $site=new Site();

        $form=$semantic->dataForm("frmSiteAdd", $site);
        $form->setFields(["nom\n","latitude","longitude","ecart\n","fondEcran","couleur\n","ordre","options","submit"]);
        $form->setCaptions(["Nom de l'établissement","Latitude","Longitude","Ecart","Fond d'écran","Couleur","Ordre","Options","Valider"]);
        $form->fieldAsSubmit("submit","blue","SitesController/newSite/","#formSite");
        $form->fieldAsImage("fondEcran");
    }
    public function newSite() {
        $site=new Site();

        RequestUtils::setValuesToObject($site,$_POST);

        if(DAO::insert($site)){
            $this->loadView("sites/index.html");
            echo $site->getNom()." ajouté";
        }
    }



    public function editSite($id) {
        $semantic=$this->jquery->semantic();

        $site = DAO::getOne("models\Site",$id  );

        $form=$semantic->dataForm("frmSiteEdit", $site);

        $form->setFields(["nom\n","latitude","longitude","ecart\n","fondEcran","couleur\n","ordre","options","submit"]);
        $form->setCaptions(["Nom de l'établissement","Latitude","Longitude","Ecart","Fond d'écran","Couleur","Ordre","Options","Valider"]);
        $form->fieldAsSubmit("submit","blue","SitesController/updateSite/".$id,"#formSite");
        $form->fieldAsImage("fondEcran");

        $this->jquery->compile($this->view);
        $this->loadView("sites/index.html");
    }
    public function updateSite($id) {
        $site = DAO::getOne("models\Site",$id );

        RequestUtils::setValuesToObject($site,$_POST);

        if(DAO::update($site)){
            $this->loadView("sites/index.html");
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