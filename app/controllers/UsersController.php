<?php
/**
 * Created by PhpStorm.
 * User: roullandq
 * Date: 12/10/2017
 * Time: 10:58
 */

namespace controllers;

use Ajax\service\JArray;
use micro\orm\DAO;
use Ajax\JsUtils;
use micro\utils\RequestUtils;
use models\Utilisateur;

/**
 * Controller UseController
 * @property JsUtils $jquery
 */

class UsersController extends ControllerBase
{

    /**
     * Page accueil gestion des utilisateurs
     */
    public function index(){
        $semantic = $this->jquery->semantic();

        $btHome = $semantic->htmlButton("btHome", "");
        $btHome->asIcon("chevron left")->asLink("BoardController");

        $bts = $semantic->htmlButtonGroups("buttons", ["Liste des utilisateurs", "Ajouter un utilisateur"]);
        $bts->setPropertyValues("data-ajax", ["all/", "addUser/"]);

        $bts->getOnClick("UsersController", "#divUsers", ["attr" => "data-ajax"]);

        $this->_all();
        $this->jquery->compile($this->view);
        $this->loadView("users/index.html");
    }

    /**
     * Creation d'une table regroupant tout les utilisateur inscrit dans la base de données
     */
    private function _all(){
        $semantic=$this->jquery->semantic();

        $users=DAO::getAll("models\Utilisateur");

        $table=$semantic->dataTable("tblUsers", "models\Utilisateur", $users);

        $table->setIdentifierFunction(function($i,$o){return $o->getId();});
        $table->setFields(["login","password","statut","site","id"]);
        $table->setCaptions(["Login","Password","Statut","Site"]);

        $table->addEditButton(false);
        $table->addDeleteButton(false);

        $table->setUrls(["edit"=>"UsersController/editUser","delete"=>"UsersController/deleteUser"]);
        $table->setTargetSelector("#divUsers");
        $table->fieldAsHidden("id");
    }
    public function all(){
        $this->_all();
        $this->jquery->compile($this->view);
        $this->loadView("users/all.html");
    }

    /**
     * Creation d'un formulaire d'ajout de moteur
     */
    private function _addUser(){
        $semantic=$this->jquery->semantic();

        $user=new Utilisateur();
        $user->idSite="";
        $user->idStatut="";

        $form=$semantic->dataForm("frmUserAdd", $user);

        $form->setFields(["login","password","elementsMasques","fondEcran","couleur","ordre","idStatut","idSite","submit"]);
        $form->setCaptions(["Login","Password","Elements Masqués","Fond d'écran","Couleur","Ordre","Statut","Site","Valider"]);

        $sites=DAO::getAll("models\Site");
        $form->fieldAsDropDown("idSite",JArray::modelArray($sites,"getId","getNom"));

        $status=DAO::getAll("models\Statut");
        $form->fieldAsDropDown("idStatut",JArray::modelArray($status,"getId","getLibelle"));

        $form->fieldAsSubmit("submit","blue","UsersController/newUser/","#divUsers");
    }

    public function addUser() {
        $this->_addUser();
        $this->jquery->compile($this->view);
        $this->loadView("users/add.html");
    }

    /**
     * Creation d'un nouveau objet utilisateur et enregistrement dans la base de données grace aux données recuperer dans le formulaire
     */
    public function newUser() {
        $semantic=$this->jquery->semantic();
        $user=new Utilisateur();

        RequestUtils::setValuesToObject($user,$_POST);

        $site=DAO::getOne("models\Site",$_POST["idSite"]);

        $user->setSite($site);

        $statut=DAO::getOne("models\Statut",$_POST["idStatut"]);

        $user->setStatut($statut);

        if(DAO::insert($user)){
            echo $semantic->htmlMessage("#divUsers","".$user->getLogin()." ajouté(e)");
            $this->all();
        }
    }

    /**
     * @param $id
     * Creation d'un formulaire d'edition de l'objet utilisateur
     */
    private function _editUser($id){
        $semantic=$this->jquery->semantic();

        $user = DAO::getOne("models\Utilisateur",$id  );
        $user->idSite=$user->getSite()->getId();
        $user->idStatut=$user->getStatut()->getId();
        $form=$semantic->dataForm("frmUserEdit", $user);

        $form->setFields(["login","password","elementsMasques","fondEcran","couleur","ordre","idStatut","idSite","submit"]);
        $form->setCaptions(["Login","Password","Elements Masqués","Fond d'écran","Couleur","Ordre","Statut","Site","Valider"]);

        $form->fieldAsSubmit("submit","blue","UsersController/updateUser/".$id,"#divUsers");

        $sites=DAO::getAll("models\Site");
        $form->fieldAsDropDown("idSite",JArray::modelArray($sites,"getId","getNom"));

        $status=DAO::getAll("models\Statut");
        $form->fieldAsDropDown("idStatut",JArray::modelArray($status,"getId","getLibelle"));
    }

    public function editUser($id){
        $this->_editUser($id);
        $this->jquery->compile($this->view);
        $this->loadView("users/edit.html");
    }

    /**
     * @param $id
     * Mise a jour de l'objet utilisateur selectionné avec les données du formulaire
     */
    public function updateUser($id) {
        $semantic=$this->jquery->semantic();
        $user = DAO::getOne("models\Utilisateur",$id );
        $site = DAO::getOne("models\Site", $_POST["idSite"]);
        $statut = DAO::getOne("models\Statut", $_POST["idStatut"]);
        $user->setSite($site);
        $user->setStatut($statut);

        RequestUtils::setValuesToObject($user,$_POST);

        if(DAO::update($user)){
            echo $semantic->htmlMessage("#divUsers","".$user->getLogin()." modifié(e)");
            $this->all();
        }

    }

    /**
     * @param $id
     * Supprime l'objet utilisateur selectionné
     */
    public function deleteUser($id) {
        $semantic=$this->jquery->semantic();
        $user = DAO::getOne("models\Utilisateur",$id );

        if(DAO::remove($user)) {
            echo $semantic->htmlMessage("#divUsers","".$user->getLogin()." supprimé(e)");
            $this->all();
        }
    }
}