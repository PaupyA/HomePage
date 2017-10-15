<?php
namespace controllers;
 /**
 * Controller Main
 **/

use micro\orm\DAO;
use Ajax\JsUtils;
use micro\utils\RequestUtils;

/**
 * Controller UseController
 * @property JsUtils $jquery
 */

class Main extends ControllerBase
{

    public function index()
    {
        $semantic=$this->jquery->semantic();

        echo "</br ><h1> Accueil </h1> </br>";

        $bts=$semantic->htmlButtonGroups("buttons",["Liste des utilisateurs","Ajouter un utilisateur"]);
        $bts->setPropertyValues("data-ajax", ["Main/connexion/","Main/connexion/"]);

        $bts->getOnClick("","#accueil",["attr"=>"data-ajax"]);

        echo $bts;
    }

    public function connexion() {

        $semantic=$this->jquery->semantic();

        $log = DAO::getAll("models\Utilisateur");
        $form=$semantic->dataForm("frmLogin", $log);
        $form->setFields(["login","password","submit"]);
        $form->setCaptions(["Login","Password","Valider"]);
        $form->fieldAsSubmit("submit","green", "Main/verificationLogin", "#accueil");

        echo "<div id='accueil'></div>";
        echo $form->compile($this->jquery);
        echo $this->jquery->compile();


    }
}