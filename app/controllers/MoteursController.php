<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 04/12/2017
 * Time: 09:52
 */

namespace controllers;

use micro\orm\DAO;
use Ajax\JsUtils;
use micro\utils\RequestUtils;
use models\Moteur;


class MoteursController extends ControllerBase
{
    /**
     * Page accueil gestion des moteurs de recherche
     */
    public function index()
    {
        $semantic=$this->jquery->semantic();

        $btHome=$semantic->htmlButton("btHome","");
        $btHome->asIcon("chevron left")->asLink("BoardController");

        $bts=$semantic->htmlButtonGroups("buttons",["Liste des moteurs","Ajouter un moteur"]);
        $bts->setPropertyValues("data-ajax", ["all/","addMoteur/"]);
        $bts->getOnClick("MoteursController/","#divMoteur",["attr"=>"data-ajax"]);

        $this->_all();

        /*
         * Définis le fond d'écran selon le statut de l'utilisateur
         */
        if(!isset($_SESSION['user'])){
            $fondEcran = "https://wallpaperscraft.com/image/forest_lake_reflection_island_mist_97668_1920x1080.jpg";
        } elseif (isset($_SESSION['user'])) {
            $fondEcran = $_SESSION['user']->getFondEcran();
        }

        /*
         * Applique le fond d'écran
         */
        $this->jquery->exec("$('body').attr('style','background: url(".$fondEcran.") no-repeat fixed; background-size: cover;');",true);

        $this->jquery->compile($this->view);
        $this->loadView("moteurs/index.html");
    }

    /**
     * Creation d'une table regroupant tout les moteurs inscrit dans la base de données
     */
    private function _all(){
        $moteurs=DAO::getAll("models\Moteur");

        $semantic=$this->jquery->semantic();

        $table=$semantic->dataTable("tblMoteurs", "models\Moteur", $moteurs);

        $table->setIdentifierFunction(function($i,$o){return $o->getId();});
        $table->setFields(["nom","code"]);
        $table->setCaptions(["Nom du moteur","Code"]);

        $table->addEditButton(false);
        $table->addDeleteButton(false);
        $table->setUrls(["edit"=>"MoteursController/editMoteur","delete"=>"MoteursController/deleteMoteur"]);
        $table->setTargetSelector("#divMoteur");
    }
    public function all(){
        $this->_all();
        $this->jquery->compile($this->view);
        $this->loadView("moteurs/all.html");
    }

    /**
     * Creation d'un formulaire d'ajout de moteur
     */
    private function _addMoteur() {
        $semantic=$this->jquery->semantic();

        $moteur=new Moteur();

        $form=$semantic->dataForm("frmMoteurAdd", $moteur);
        $form->setFields(["nom\n","code\n","submit"]);
        $form->setCaptions(["Nom du moteur","Code","Valider"]);
        $form->fieldAsSubmit("submit","blue","MoteursController/newMoteur/","#divMoteur");
    }
    public function addMoteur() {
        $this->_addMoteur();
        $this->jquery->compile($this->view);
        $this->loadView("moteurs/add.html");
    }

    /**
     * Creation d'un nouveau objet moteur et enregistrement dans la base de données grace aux données recuperer dans le formulaire
     */
    public function newMoteur() {
        $semantic=$this->jquery->semantic();
        $moteur=new Moteur();

        RequestUtils::setValuesToObject($moteur,$_POST);

        if(DAO::insert($moteur)){
            echo $semantic->htmlMessage("#divMoteur","".$moteur->getNom()." ajouté");
            $this->all();
        }
    }

    /**
     * @param $id
     * Creation d'un formulaire d'edition de l'objet moteur
     */
    private function _editMoteur($id) {
        $semantic=$this->jquery->semantic();

        $moteur = DAO::getOne("models\Moteur",$id  );

        $form=$semantic->dataForm("frmMoteurEdit", $moteur);

        $form->setFields(["nom\n","code\n","submit"]);
        $form->setCaptions(["Nom du moteur","Code","Valider"]);
        $form->fieldAsSubmit("submit","blue","MoteursController/updateMoteur/".$id,"#divMoteur");
    }
    public function editMoteur($id) {
        $this->_editMoteur($id);
        $this->jquery->compile($this->view);
        $this->loadView("moteurs/edit.html");
    }

    /**
     * @param $id
     * Mise a jour de l'objet moteur selectionné avec les données du formulaire
     */
    public function updateMoteur($id) {
        $semantic=$this->jquery->semantic();
        $moteur = DAO::getOne("models\Moteur",$id );

        RequestUtils::setValuesToObject($moteur,$_POST);

        if(DAO::update($moteur)){
            echo $semantic->htmlMessage("#divMoteur","".$moteur->getNom()." modifié");
            $this->all();
        }

    }

    /**
     * @param $id
     * Supprime l'objet moteur selectionné
     */
    public function deleteMoteur($id) {
        $semantic=$this->jquery->semantic();
        $moteur = DAO::getOne("models\Moteur",$id );

        if(DAO::remove($moteur)) {
            echo $semantic->htmlMessage("#divMoteur","".$moteur->getNom()." supprimé");
            $this->all();
        }
    }


}