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
 * Controller de départ (page accueil)
 * @property JsUtils $jquery
 */

class Main extends ControllerBase {

    public function index() {
        $semantic = $this->jquery->semantic();

        $frm = $semantic->smallLogin("frm2-4");
        $frm->fieldAsSubmit("submit", "blue fluid", "Main/connexion", "#rep");
        echo $frm->asModal();

        $this->bouton();

        $this->recherche();

        $this->liens();

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
        $this->loadView("index.html");
    }

    /**
     * Fonction pour afficher et parametrer la barre de recherche en fonction du status de l'utilisateur
     */
    public function recherche() {
        if (!isset($_SESSION["user"])) {
            $semantic = $this->jquery->semantic();
            $frmSearch = $semantic->htmlForm("frmSearch");
            $input=$frmSearch->addInput("q", "", "", "", "Rechercher...");
            $input->addAction( "Go");
            $frmSearch->setProperty("action", "https://www.google.fr/search?q");
            $frmSearch->setProperty("method", "get");
            $frmSearch->setProperty("target", "_blank");
        } else {
            $IdUser = $_SESSION["user"]->getId();
            $user = DAO::getOne("models\Utilisateur", $IdUser,true);
            $moteur = $user->getMoteur();

            $semantic = $this->jquery->semantic();
            $frmSearch = $semantic->htmlForm("frmSearch");
            $input=$frmSearch->addInput("q", "", "", "", "Rechercher...");
            $input->addAction("Go");
            $frmSearch->setProperty("action", $moteur->getCode());
            $frmSearch->setProperty("method", "get");
            $frmSearch->setProperty("target", "_blank");
        }
    }

    /**
     * Fonction pour afficher et parametrer les boutons en fonction du status de l'utilisateur
     */
    public function bouton() {
        $semantic = $this->jquery->semantic();
        if (!isset($_SESSION["user"])) {
            $btLog = $semantic->htmlButton("btLogin", "S'identifier", "blue", "$('#modal-frm2-4').modal('show');");
            $btLog->addIcon("sign in");
        } elseif ($_SESSION["user"]->getStatut() == "Super administrateur"){
            $btDeco = $semantic->htmlButton("btDeco", "Se déconnecter");
            $btDeco->addIcon("sign out");
            $btDeco->asLink("Main/deconnexion");
            $btProfile = $semantic->htmlButton("btProfil", "Profil", "blue");
            $btProfile->addIcon("user");
            $btProfile->asLink("ProfileController");
            $btBoard = $semantic->htmlButton("btBoard","Board","yellow");
            $btBoard->addIcon("settings");
            $btBoard->asLink("BoardController");
        } elseif(isset($_SESSION["user"])) {
            $btDeco = $semantic->htmlButton("btDeco", "Se déconnecter");
            $btDeco->addIcon("sign out");
            $btDeco->asLink("Main/deconnexion");
            $btProfile = $semantic->htmlButton("btProfil", "Profil", "blue");
            $btProfile->addIcon("user");
            $btProfile->asLink("ProfileController");
        }
    }

    /**
     * Fonction pour créer la session d'un utlisateur lorsqu'il se connecte avec les bons identifiant et mot de passe
     */
    public function connexion() {
        $semantic = $this->jquery->semantic();
        $user = DAO::getOne("models\Utilisateur", "login='" . $_POST['login'] . "'");
        if (isset($user)) {
            if ($user->getPassword() == $_POST["password"]) {
                $_SESSION["user"]=$user;
                $this->jquery->get("Main/index","body");
                echo $semantic->htmlMessage("msg", "Utilisateur " . $_POST['login'] . " connecté");
            } else {
                $this->jquery->get("Main/index","body");
                echo $semantic->htmlMessage("msg", "Identifiant et/ou mot de passe incorrect.");
            }
        } else {
            $this->jquery->get("Main/index","body");
        }
        echo $this->jquery->compile($this->view);
    }

    public function liens() {
        if (isset($_SESSION["user"])){

        }
    }

    /**
     * Fonction pour détruire la session et redirige vers l'accueil directement
     */
    public function deconnexion() {
        session_unset();
        session_destroy();
        header("location:/homepage");
        $this->jquery->get("", "body");
        echo $this->jquery->compile($this->view);

    }

}

