<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 09/11/2017
 * Time: 09:33
 */

namespace controllers;

use Ajax\service\JArray;
use micro\orm\DAO;
use Ajax\JsUtils;
use micro\utils\RequestUtils;
use models\Lienweb;
use models\Site;

/**
 * Controller UseController
 * @property JsUtils $jquery
 */

class LinksController extends ControllerBase
{
    /**
     * Page d'accueil pour la gestion des liens
     */
    public function index() {
        $semantic=$this->jquery->semantic();

        $btHome=$semantic->htmlButton("btHome","");
        $btHome->asIcon("chevron left")->asLink("BoardController");

        $bts=$semantic->htmlButtonGroups("buttons",["Liste des liens","Ajouter un lien"]);
        $bts->setPropertyValues("data-ajax", ["all/","addLink/"]);
        $bts->getOnClick("LinksController/","#divLink",["attr"=>"data-ajax"]);

        $this->_all();
        $this->jquery->compile($this->view);
        $this->loadView("links/index.html");
    }

    /**
     * Affichage d'une table regroupant tout les liens dans la base de données
     */
    private function _all() {
        $links=DAO::getAll("models\Lienweb");

        $semantic=$this->jquery->semantic();
        $table=$semantic->dataTable("tblLinks", "models\Lienweb", $links);

        $table->setIdentifierFunction(function($i,$o){return $o->getId();});
        $table->setFields(["libelle","url","utilisateur"]);
        $table->setCaptions(["Site","URL",'Utilisateur']);
        $table->addEditButton(false);
        $table->addDeleteButton(false);
        $table->setUrls(["edit"=>"LinksController/editLink","delete"=>"LinksController/deleteLink"]);
        $table->setTargetSelector("#divLink");
    }
    public function all() {
        $this->_all();
        $this->jquery->compile($this->view);
        $this->loadView("links/all.html");
    }

    /**
     * Fonction pour créer le formulaire d'ajout de liens
     */
    private function _addLink() {
        $semantic=$this->jquery->semantic();

        $link=new Lienweb();
        $link->idSite="";
        $link->idUtilisateur="";

        $form=$semantic->dataForm("frmLinkAdd", $link);

        $form->setFields(["libelle","url\n","ordre","idSite","idUtilisateur\n","submit"]);
        $form->setCaptions(["Site internet","URL","Ordre","Site","Utilisateur","Valider"]);

        $sites=DAO::getAll("models\Site");
        $form->fieldAsDropDown("idSite",JArray::modelArray($sites,"getId","getNom"));

        $users=DAO::getAll("models\Utilisateur");
        $form->fieldAsDropDown("idUtilisateur\n",JArray::modelArray($users,"getId","getLogin"));

        $form->fieldAsSubmit("submit","blue","LinksController/newLink/","#divLink");
    }
    public function addLink() {
        $this->_addLink();
        $this->jquery->compile($this->view);
        $this->loadView("links/add.html");
    }

    /**
     * Fonction pour créer l'objet et l'enregistrer dans la base données avec les données recuperer depuis le formulaire d'ajout
     */
    public function newLink() {
        $semantic=$this->jquery->semantic();
        $link=new Lienweb();

        RequestUtils::setValuesToObject($link,$_POST);

        $site=DAO::getOne("models\Site",$_POST["idSite"]);
        $user=DAO::getOne("models\Utilisateur",$_POST["idUtilisateur"]);

        $link->setSite($site);
        $link->setUtilisateur($user);

        if(DAO::insert($link)){
            echo $semantic->htmlMessage("#divLink","".$link->getLibelle()." ajouté");
            $this->all();
        }
    }

    /**
     * Création du formulaire d'édition du lien selectionné
     * @param $id
     */
    private function _editLink($id) {
        $semantic=$this->jquery->semantic();

        $link = DAO::getOne("models\Lienweb",$id  );
        $link->idSite=$link->getSite()->getId();
        $link->idUtilisateur=$link->getUtilisateur()->getId();
        $form=$semantic->dataForm("frmLinkEdit", $link);
        $form->setFields(["id","libelle","url\n","ordre","idSite","idUtilisateur","\nsubmit"]);
        $form->setCaptions(["id","Site internet","URL","Ordre","Site","Utilisateur","Valider"]);

        $form->fieldAsHidden("id");

        $sites=DAO::getAll("models\Site");
        $form->fieldAsDropDown("idSite",JArray::modelArray($sites,"getId","getNom"));

        $users=DAO::getAll("models\Utilisateur");
        $form->fieldAsDropDown("idUtilisateur",JArray::modelArray($users,"getId","getLogin"));

        $form->fieldAsSubmit("\nsubmit","blue","LinksController/updateLink/","#divLink");

    }
    public function editLink($id) {
        $this->_editLink($id);
        $this->jquery->compile($this->view);
        $this->loadView("links/edit.html");
    }

    /**
     * Mise a jour du liens dans la base données avec les données recuperer dans le formulaire
     */
    public function updateLink() {
        $semantic=$this->jquery->semantic();

        $link = DAO::getOne("models\Lienweb",$_POST["id"] );

        $site = DAO::getOne("models\Site", $_POST["idSite"]);
        $user = DAO::getOne("models\Utilisateur",$_POST["idUtilisateur"]);

        $link->setSite($site);
        $link->setUtilisateur($user);

        RequestUtils::setValuesToObject($link,$_POST);

        if(DAO::update($link)){
            echo $semantic->htmlMessage("#divLink","".$link->getLibelle()." modifié");
            $this->all();
        }

    }

    /**
     * Fonction pour supprimer le lien selectionner
     * @param $id
     */
    public function deleteLink($id) { // suppression objet liens
        $semantic=$this->jquery->semantic();
        $link = DAO::getOne("models\Lienweb",$id );

        if(DAO::remove($link)) {
            echo $semantic->htmlMessage("#divLink","".$link->getLibelle()." supprimé");
            $this->all();
        }
    }

    /******************************************************************************************************************
     *
     *****************************************************************************************************************/

    /**
     * Gestion des liens Perso depuis le profil de l'utilisateur
     */
    public function indexPerso() {
        $semantic=$this->jquery->semantic();

        $btHome=$semantic->htmlButton("btHome","");
        $btHome->asIcon("home")->asLink("");

        $bts=$semantic->htmlButtonGroups("buttons",["Liste liens","Ajouter un lien"]);
        $bts->setPropertyValues("data-ajax", ["allPerso","addLinkPerso/"]);
        $bts->getOnClick("LinksController/","#divLink",["attr"=>"data-ajax"]);

        $this->_allPerso();
        $this->jquery->compile($this->view);
        $this->loadView("links/mesLiens.html");
    }

    /**
     * Creation d'une table avec tout les liens liés a l'utilisateur connecté
     */
    private function _allPerso() {
        $semantic=$this->jquery->semantic();

        $links=DAO::getAll("models\Lienweb","idUtilisateur = ".$_SESSION['user']->getId());

        $table=$semantic->dataTable("tblLinks", "models\Lienweb", $links);

        $table->setIdentifierFunction(function($i,$o){return $o->getId();});
        $table->setFields(["libelle","url"]);
        $table->setCaptions(["Site","URL"]);

        $table->addEditButton(false);
        $table->addDeleteButton(false);
        $table->setUrls(["edit"=>"LinksController/editLinkPerso","delete"=>"LinksController/deleteLinkPerso"]);
        $table->setTargetSelector("#divLink");
    }
    public function allPerso() {
        $this->_allPerso();
        $this->jquery->compile($this->view);
        $this->loadView("links/all.html");
    }

    /**
     * Creation d'un formulaire afin d'ajouter un lien et qu'il soit lié à l'utilisateur connecté
     */
    private function _addLinkPerso() {
        $semantic=$this->jquery->semantic();

        $link=new Lienweb();

        $form=$semantic->dataForm("frmLinkAdd", $link);

        $form->setFields(["libelle","url\n","ordre","idUtilisateur","submit"]);
        $form->setCaptions(["Site internet","URL","Ordre","Utilisateur","Valider"]);

        $form->fieldAsHidden("idUtilisateur");

        $form->fieldAsSubmit("submit","blue","LinksController/newLinkPerso","#divLink");
    }
    public function addLinkPerso() {
        $this->_addLinkPerso();
        $this->jquery->compile($this->view);
        $this->loadView("links/add.html");
    }

    /**
     * Creation de l'objet et l'enregistre dans la base de données avec les données recupérer depuis le formulaire
     */
    public function newLinkPerso() {
        $semantic=$this->jquery->semantic();

        $link=new Lienweb();

        RequestUtils::setValuesToObject($link,$_POST);

        $user=DAO::getOne("models\Utilisateur",$_SESSION['user']->getId());

        $link->setUtilisateur($user);

        if(DAO::insert($link)){
            echo $semantic->htmlMessage("#divLink","".$link->getLibelle()." ajouté");
            $this->allPerso();
        }
    }

    /**
     * @param $id
     * Creation d'un formulaire d'édition du lien perso
     */
    private function _editLinkPerso($id) {
        $semantic=$this->jquery->semantic();

        $link = DAO::getOne("models\Lienweb",$id  );
        $link->idUtilisateur=$link->getUtilisateur()->getId();
        $form=$semantic->dataForm("frmLinkEdit", $link);
        $form->setFields(["id","libelle","url\n","ordre","\nsubmit"]);
        $form->setCaptions(["id","Site internet","URL","Ordre","Valider"]);

        $form->fieldAsHidden("id");

        $form->fieldAsSubmit("\nsubmit","blue","LinksController/updateLinkPerso/","#divLink");

    }
    public function editLinkPerso($id) {
        $this->_editLinkPerso($id);
        $this->jquery->compile($this->view);
        $this->loadView("links/edit.html");
    }

    /**
     * Mise a jour du liens dans la base de données grace aux données recuperer dans le formulaire
     */
    public function updateLinkPerso() {
        $semantic=$this->jquery->semantic();

        $link = DAO::getOne("models\Lienweb",$_POST["id"] );
        $site = DAO::getOne("models\Site",$_SESSION['user']->getSite());

        $link->setSite($site);

        RequestUtils::setValuesToObject($link,$_POST);

        if(DAO::update($link)){
            echo $semantic->htmlMessage("#divLink","".$link->getLibelle()." modifié");
            $this->jquery->get("LinksController/perso",".ui.container");
        }
        echo $this->jquery->compile($this->view);
    }

    /**
     * @param $id
     * Supprime le liens selectionner
     */
    public function deleteLinkPerso($id) {
        $semantic=$this->jquery->semantic();
        $link = DAO::getOne("models\Lienweb",$id );

        if(DAO::remove($link)) {
            echo $semantic->htmlMessage("#divLink","".$link->getLibelle()." supprimé");
            $this->jquery->get("LinksController/indexPerso",".ui.container");
        }
        echo $this->jquery->compile($this->view);
    }

}