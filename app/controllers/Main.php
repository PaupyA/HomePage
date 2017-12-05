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
        $frm->fieldAsSubmit("submit", "blue fluid", "Main/connexion", "#rep");
        echo $frm->asModal();

        $this->bouton();

        $this->recherche();

        $this->jquery->compile($this->view);
        $this->loadView("index.html");
    }

    // Barre de recherche
    public function recherche() {

        // Si il n'y a pas d'utilisateur de connecté
        if (!isset($_SESSION["user"])) {
            $semantic = $this->jquery->semantic();
            $frmSearch = $semantic->htmlForm("frmSearch");
            $input = $frmSearch->addInput("q", "", "", "", "Rechercher...");
            $input->addAction("Go");
            // On définis le moteur de recherche de base par Google
            $frmSearch->setProperty("action", "https://www.google.fr/search?q");
            $frmSearch->setProperty("method", "get");
            $frmSearch->setProperty("target", "_blank");
            // Si un utilisateur est connecté
        } else {
            // On recupère son ID
            $IdUser = $_SESSION["user"]->getId();
            // On récupère les informations de l'utilisateur lié à l'ID
            $user = DAO::getOne("models\Utilisateur", $IdUser, true);
            // On récupère l'ID du moteur choisis par l'utilisateur
            $moteur = $user->getMoteur();

            $semantic = $this->jquery->semantic();
            $frmSearch = $semantic->htmlForm("frmSearch");
            $input = $frmSearch->addInput("q", "", "", "", "Rechercher...");
            $input->addAction("Go");
            // On récupère et définis le moteur de recherche selon le moteur choisis par l'utilisateur
            $frmSearch->setProperty("action", $moteur->getCode());
            $frmSearch->setProperty("method", "get");
            $frmSearch->setProperty("target", "_blank");
        }
    }

    // Bouton de connexion
    public function bouton() {
        $semantic = $this->jquery->semantic();
        // Si il n'y a pas d'utilisateur de connecté, affiche le bouton pour s'identifier
        if (!isset($_SESSION["user"])) {
            $btLog = $semantic->htmlButton("btLogin", "S'identifier", "blue", "$('#modal-frm2-4').modal('show');");
            $btLog->addIcon("sign in");
        // Si un utilisateur est connecté, affiche un bouton "Profil" et  "Se déconnecter"
        } else {
            $btDeco = $semantic->htmlButtonGroups("btDeco", ["Se déconnecter"]);
            $btDeco->setPropertyValues("data-ajax", ["Main/deconnexion"]);
            $btDeco->getOnClick("/", "body", ["attr" => "data-ajax"]);
            $btProfile = $semantic->htmlButton("btProfil", "Profil", "blue");
            $btProfile->addIcon("user");
            $btProfile->asLink("ProfileController");
        }
    }
    
    // Fonction pour la Connexion
    public function connexion() {
        $semantic = $this->jquery->semantic();
        $user = DAO::getOne("models\Utilisateur", "login='" . $_POST['login'] . "'");
        if (isset($user)) {
            if ($user->getPassword() == $_POST["password"]) {
                $_SESSION["user"] = $user;
                $this->jquery->get("Main/index", "body");
                echo $semantic->htmlMessage("msg", "Utilisateur " . $_POST['login'] . " connecté");
            } else {
                $this->jquery->get("Main/index", "body");
                echo $semantic->htmlMessage("msg", "Identifiant et/ou mot de passe incorrect.");
            }
        } else {
            $this->jquery->get("Main/index", "body");
        }
        echo $this->jquery->compile($this->view);
    }
    
    // Fonction de déconnexion
    public function deconnexion() {
        // Fermeture et "destruction" de la session utilisateur
        session_unset();
        session_destroy();
        $this->jquery->get("Main/index", "body");
        echo $this->jquery->compile($this->view);
    }

}
