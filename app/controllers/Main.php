<?php
namespace controllers;
 /**
 * Controller Main
 **/
use Ajax\service\JArray;
use micro\orm\DAO;
use Ajax\JsUtils;
use micro\utils\RequestUtils;
use models\Utilisateur;

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

        $bts=$semantic->htmlButtonGroups("buttons",["Se connecter"]);
        $bts->setPropertyValues("data-ajax", ["Main/connexion"]);

        $bts->getOnClick("","#accueil",["attr"=>"data-ajax"]);

        echo $bts;
        echo $this->jquery->compile($this->view);
        echo "<div id='accueil'></div>";
    }

    public function connexion() {

    }
}