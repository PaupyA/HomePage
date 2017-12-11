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
     * Page accueil gestion des sites
     */
    public function index() {

        $semantic=$this->jquery->semantic();

        $btHome=$semantic->htmlButton("btHome","");
        $btHome->asIcon("chevron left")->asLink("BoardController");

        $bts=$semantic->htmlButtonGroups("buttons",["Liste des sites","Ajouter un site"]);
        $bts->setPropertyValues("data-ajax", ["all/","addSite/"]);
        $bts->getOnClick("SitesController/","#divSites",["attr"=>"data-ajax"]);

        $this->_all();
        $this->jquery->compile($this->view);
        $this->loadView("sites/index.html");
}
    /**
     * Creation d'une table regroupant tout les sites inscrit dans la base de données
     */
    private function _all(){
        $sites=DAO::getAll("models\Site");

        $semantic=$this->jquery->semantic();

        $table=$semantic->dataTable("tblSites", "models\Site", $sites);

        $table->setIdentifierFunction(function($i,$o){return $o->getId();});
        $table->setFields(["nom","latitude","longitude","id"]);
        $table->setCaptions(["Nom de l'établissement","Latitude","Longitude"]);

        $table->addEditButton(false);
        $table->addDeleteButton(false);
        $table->setUrls(["edit"=>"SitesController/editSite","delete"=>"SitesController/deleteSite"]);
        $table->setTargetSelector("#divSites");
        $table->fieldAsHidden("id");
    }
    public function all(){
        $this->_all();
        $this->jquery->compile($this->view);
        $this->loadView("sites/all.html");
    }

    /**
     * Creation d'un formulaire d'ajout de site
     */
    private function _addSite() {
        $semantic=$this->jquery->semantic();

        $site=new Site();

        $form=$semantic->dataForm("frmSiteAdd", $site);
        $form->setFields(["nom\n","latitude","longitude","ecart\n","fondEcran","couleur\n","ordre","options\n","submit"]);
        $form->setCaptions(["Nom de l'établissement","Latitude","Longitude","Ecart","Fond d'écran","Couleur","Ordre","Options","Valider"]);
        $form->fieldAsSubmit("submit","blue","SitesController/newSite/","#divSites");
    }
    public function addSite() {
        $this->_addSite();
        $this->jquery->compile($this->view);
        $this->loadView("sites/add.html");
    }

    /**
     * Creation d'un nouveau objet site et enregistrement dans la base de données grace aux données recuperer dans le formulaire
     */
    public function newSite() {
        $semantic=$this->jquery->semantic();
        $site=new Site();

        RequestUtils::setValuesToObject($site,$_POST);

        if(DAO::insert($site)){
            echo $semantic->htmlMessage("#divSites","".$site->getNom()." ajouté");
            $this->all();
        }
    }

    /**
     * @param $id
     * Creation d'un formulaire d'edition de l'objet site
     */
    private function _editSite($id) {
        $semantic=$this->jquery->semantic();

        $site = DAO::getOne("models\Site",$id  );

        $form=$semantic->dataForm("frmSiteEdit", $site);

        $form->setFields(["nom\n","latitude","longitude","ecart\n","fondEcran","couleur\n","ordre","options\n","submit"]);
        $form->setCaptions(["Nom de l'établissement","Latitude","Longitude","Ecart","Fond d'écran","Couleur","Ordre","Options","Valider"]);
        $form->fieldAsSubmit("submit","blue","SitesController/updateSite/".$id,"#divSites");
    }
    public function editSite($id) {
        $this->_editSite($id);
        $this->jquery->compile($this->view);
        $this->loadView("sites/edit.html");
    }

    /**
     * @param $id
     * Mise a jour de l'objet site selectionné avec les données du formulaire
     */
    public function updateSite($id) {
        $semantic=$this->jquery->semantic();
        $site = DAO::getOne("models\Site",$id );

        RequestUtils::setValuesToObject($site,$_POST);

        if(DAO::update($site)){
            echo $semantic->htmlMessage("#divSites","".$site->getNom()." modifié");
            $this->all();
        }

    }

    /**
     * @param $id
     * Supprime l'objet site selectionné
     */
    public function deleteSite($id) {
        $semantic=$this->jquery->semantic();
        $site = DAO::getOne("models\Site",$id );

        if(DAO::remove($site)) {
            echo $semantic->htmlMessage("#divSites","".$site->getNom()." supprimé");
            $this->all();
        }
    }


}