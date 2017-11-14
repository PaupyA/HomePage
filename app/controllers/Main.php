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
        
        $frm = $semantic->smallLogin("frm2-4");
        $frm->fieldAsSubmit("submit", "blue fluid", "sTest/dePost", "#frm2-4-submit");
        $bt = $semantic->htmlButton("bt1", "S'identifier", "blue", "$('#modal-frm2-4').modal('show');");
        $bt->addIcon("sign in");

        echo $frm->asModal();
        echo $bt;
//        $idMoteur = DAO::getOne("models\moteur",$id );
//        $google="https://www.google.fr/search?q";
//        $ecosia="https://www.ecosia.org/search?q=";
//        
//        $moteur="";
//        
//        if ($idMoteur == "1" ){
//            $moteur = $google;
//        }
//        Elseif ($idMoteur == "2") {
//            $moteur = $ecosia;
//        };
        
        $frmSearch = $semantic->htmlForm("frmSearch");
        $frmSearch->addInput("q", "", "", "", "Rechercher...");
        $frmSearch->addButton("submit", "Go");
        $frmSearch->setProperty("action", "https://www.google.fr/search?q");
        $frmSearch->setProperty("method", "get");

        $this->jquery->compile($this->view);
        $this->loadView("index.html");
    }

//    public function recherche() {
//        $recherche = "";
//        $recherche = "https://www.google.fr/search?q=google&oq=" . $_POST["search"];
//        $this->jquery->get($recherche,"#searchResponse");
//        echo $this->jquery->compile($this->view);
//    }

}
