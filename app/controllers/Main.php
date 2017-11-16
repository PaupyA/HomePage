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

        $frm=$semantic->smallLogin("frm2-4");
        $frm->fieldAsSubmit("submit","blue fluid","Main/connexion","#rep");
        echo $frm->asModal();

        $this->bouton();

        $this->recherche();

        $this->jquery->compile($this->view);
        $this->loadView("index.html");
    }

    public function recherche() {
        $semantic = $this->jquery->semantic();
        $frmSearch=$semantic->htmlForm("frmSearch");
        $frmSearch->addInput("search","","","","Rechercher...");
    }

    public function bouton() {
        $semantic = $this->jquery->semantic();
        if(!isset($_SESSION["user"])) {
            $btLog = $semantic->htmlButton("bt1", "S'identifier", "blue", "$('#modal-frm2-4').modal('show');");
            $btLog->addIcon("sign in");
        }else{
            $btDeco=$semantic->htmlButton("bt2","Se déconnecter", "blue");
            $btDeco->addIcon("sign out");
            $btDeco->asLink($this->deconnexion());
            $btProfile=$semantic->htmlButton("bt3","Profil","blue");
            $btProfile->addIcon("user");
            $btProfile->asLink("ProfileController");
        }
    }

    public function connexion() {
        $semantic=$this->jquery->semantic();
        $user=DAO::getOne("models\Utilisateur","login='".$_POST['login']."'");
        if(isset($user)) {
            if ($user->getPassword() == $_POST["password"]) {
                $_SESSION["user"]=$user;
                echo $semantic->htmlMessage("msg", "Utilisateur " . $_POST['login'] . " connecté");
            } else {
                echo $semantic->htmlMessage("msg", "Identifiant et/ou mot de passe incorrect.");
            }
            echo $this->jquery->compile($this->view);
        }
    }

    public function deconnexion() {
        session_unset ();
        session_destroy ();
    }
}
