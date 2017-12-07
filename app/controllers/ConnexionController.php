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
class ConnexionController extends ControllerBase {

    // Page de connexion
    public function index() {
        $semantic=$this->jquery->semantic();

        $btHome=$semantic->htmlButton("btHome","");
        $btHome->asIcon("home")->asLink("");

        $form=$semantic->htmlForm("frmLog");
        $form->addInput("login","Login","","","");
        $form->addInput("mdp","Mot de passe","password","","Mot de passe");
        $form->addSubmit("button","Valider","blue","ConnexionController/connexion","#rep");

        $this->jquery->compile($this->view);
        $this->loadView("connexion/index.html");
    }
    
    // Fonction connexion
    public function connexion() {
        $semantic=$this->jquery->semantic();
        if($_SESSION["user"]=DAO::getOne("models\Utilisateur","login='".$_POST['login']."'")
            && $_SESSION["user"]=DAO::getOne("models\Utilisateur","password='".$_POST['mdp']."'")){


            echo $semantic->htmlMessage("msg","Utilisateur ".$_POST['login']." connecté");
        }else{
            echo $semantic->htmlMessage("msg","Identifiant et/ou mot de passe incorrect.");
        }
    }

    public function deconnexion() {

    }
}
