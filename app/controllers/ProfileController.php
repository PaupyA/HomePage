<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 05/11/2017
 * Time: 21:34
 */

namespace controllers;

use Ajax\service\JArray;
use micro\orm\DAO;
use Ajax\JsUtils;
use micro\utils\RequestUtils;
use models\Site;
use controllers\LinksController;

/**
 * Controller UseController
 * @property JsUtils $jquery
 */

class ProfileController extends ControllerBase
{
    /**
     * Page accueil du profil de l'utilisateur
     */
    public function index() {
        $semantic=$this->jquery->semantic();

        $btHome=$semantic->htmlButton("btHome","");
        $btHome->asIcon("home")->asLink("");

        $btLink=$semantic->htmlButtonGroups("btLink",["Liens perso"]);
        $btLink->setPropertyValues("data-ajax", ["LinksController/indexPerso"]);
        $btLink->getOnClick("",".ui.container",["attr"=>"data-ajax"]);

        $this->_printData();
        $this->jquery->compile($this->view);
        $this->loadview("profil/index.html");
    }

    /**
     * Affiche toutes les données de l'utilisateur sous forme d'input afin qu'ils puissent les modifiées
     */
    private function _printData() {
        $id = $_SESSION['user']->getId();
        $semantic=$this->jquery->semantic();
        $user = DAO::getOne("models\Utilisateur",$id );
        $user->idMoteur=$user->getMoteur()->getId();
        $form=$semantic->dataForm("frmUser", $user);

        $form->setFields(["login","password","elementsMasques","fondEcran","couleur","ordre","idMoteur","submit"]);
        $form->setCaptions(["Identifiant","Mot de passe","Elements Masqués","Fond d'écran","Couleur","Ordre","Moteur","Valider"]);


        $moteur=DAO::getAll("models\Moteur");
        $form->fieldAsDropDown("idMoteur",JArray::modelArray($moteur,"getId","getNom"));

        $form->fieldAsSubmit("submit","blue","ProfileController/updateUser/".$id,"#msgUpdate");
    }
    public function printData(){
        $this->_printData();
        $this->jquery->compile($this->view);
        $this->loadview("profil/index.html");
    }

    /**
     * Mise a jour des données de l'utilisateur
     */
    public function updateUser() {
        $semantic=$this->jquery->semantic();

        $user = DAO::getOne("models\Utilisateur",$_SESSION['user']->getId());
        $moteur = DAO::getOne("models\Moteur", $_POST["idMoteur"]);

        $user->setMoteur($moteur);

        RequestUtils::setValuesToObject($user,$_POST);

        if(DAO::update($user)){
            echo $semantic->htmlMessage("msgUsers","".$user->getLogin()." modifié(e)");
        }
    }
}