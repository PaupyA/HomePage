<?php
/**
 * Created by PhpStorm.
 * User: roullandq
 * Date: 12/10/2017
 * Time: 09:21
 */

namespace controllers;

use micro\orm\DAO;
use Ajax\JsUtils;
use micro\utils\RequestUtils;

/**
 * Controller UseController
 * @property JsUtils $jquery
 */

class BoardController extends ControllerBase
{
    /**
     * Vérifie le statut de l'utilisateur et @return bool
     * @return true si on accepte l'accès a la page selon le statut de l'utilisateur
     * @return false si on refuse l'accès
     * Si @return false la fonction OnInvalidcControl() sera appellé automatiquement
     */
    public function isValid()
    {
        if(!isset($_SESSION["user"])){
            return false;
        }elseif ($_SESSION["user"]->getStatut() == "Super administrateur"){
            return true;
        }elseif ($_SESSION["user"]->getStatut() != "Super administrateur"){
            return false;
        }
    }

    /**
     * Redirige vers la page d'accueil lorsque isValid() @return false
     */
    public function onInvalidControl()
    {
        header("location:/homepage");
    }

    /**
     * Création des boutons néccessaire pour la redirection vers les controllers d'administration
     */
    public function index() {

        $semantic=$this->jquery->semantic();

        $btHome=$semantic->htmlButton("btHome","");
        $btHome->asIcon("home")->asLink("");

        $btSites=$semantic->htmlButton("btSites","Gestion des sites");
        $btSites->asLink("SitesController");

        $btUsers=$semantic->htmlButton("btUsers","Gestion des utilisateurs");
        $btUsers->asLink("UsersController");

        $btLinks=$semantic->htmlButton("btLinks","Gestion des liens");
        $btLinks->asLink("LinksController");

        $btMoteur=$semantic->htmlButton("btMoteur","Gestion des moteurs");
        $btMoteur->asLink("MoteursController");

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
        $this->loadView("board/index.html");
    }

}