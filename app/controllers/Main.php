<?php

namespace controllers;

/**
 * Controller Main
 * */
use Ajax\service\JArray;
use micro\orm\DAO;
use Ajax\JsUtils;
use micro\utils\RequestUtils;
use models\Utilisateur;

/**
 * Controller UseController
 * @property JsUtils $jquery
 */
class Main extends ControllerBase {

    public function index() {
        $semantic = $this->jquery->semantic();

        $btConnexion = $semantic->htmlButton("btConnexion", "Connexion");
        $btConnexion->asLink("ConnexionController");

        $search = $semantic->htmlSearch("search", "Recherche...","search");



        $this->jquery->compile($this->view);
        $this->loadView("index.html");
    }
}
