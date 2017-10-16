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

class UsersController extends ControllerBase
{
    public function index() {
        $semantic=$this->jquery->semantic();

        echo "</br>";
        $btHome=$semantic->htmlButton("btHome","");
        $btHome->asIcon("home")->asLink("BoardController");

        $bts=$semantic->htmlButtonGroups("buttons",["Liste des utilisateurs","Ajouter un utilisateur"]);
        $bts->setPropertyValues("data-ajax", ["UsersController/all/","UsersController/addUser/"]);

        $bts->getOnClick("","#user",["attr"=>"data-ajax"]);

        echo $btHome;
        echo $bts;
        echo "</br><h1>Gestion utilisateurs</h1>";
        $this->all();
    }

    public function all(){
        $semantic=$this->jquery->semantic();

        $users=DAO::getAll("models\Utilisateur");
        $table=$semantic->dataTable("user", "models\Utilisateur", $users);
        $table->setIdentifierFunction(function($i,$o){return $o->getId();});
        $table->setFields(["login","password","statut","site","id"]);
        $table->setCaptions(["Login","Password","Statut","Site"]);
        $table->addEditButton(false);
        $table->setUrls(["edit"=>"UsersController/editUser","delete"=>"UsersController/deleteUser"]);
        $table->setTargetSelector("#user");
        $table->addDeleteButton(false);
        $table->fieldAsHidden("id");

        echo $table->compile($this->jquery);
        echo $this->jquery->compile($this->view);
    }

    public function addUser() {
        $semantic=$this->jquery->semantic();
        $user=new Utilisateur();
        $form=$semantic->dataForm("frmUser", $user);
        $form->setFields(["login","password","elementsMasques","fondEcran","couleur","ordre","statut","site","submit"]);
        $form->setCaptions(["Login","Password","Elements Masqués","Fond d'écran","Couleur","Ordre","Statut","Site","Valider"]);
        $form->fieldAsSubmit("submit","green","UsersController/newUser/","#divUser");
        $sites=DAO::getAll("models\Site");
        $form->fieldAsDropDown("site",JArray::modelArray($sites,"getId","getNom"));
        $status=DAO::getAll("models\Statut");
        $form->fieldAsDropDown("statut",JArray::modelArray($status,"getId","getLibelle"));
        echo $form->compile($this->jquery);
        echo $this->jquery->compile();
        echo "<div id='divUser'></div>";

    }
    public function newUser() {
        $user=new Utilisateur();
        RequestUtils::setValuesToObject($user,$_POST);
        $site=DAO::getOne("models\Site",$_POST["site"]);
        $user->setSite($site);
        $statut=DAO::getOne("models\Statut",$_POST["statut"]);
        $user->setStatut($statut);
        if(DAO::insert($user)){
            echo "</br>". $user->getLogin()." ajouté";
        }
    }

    public function editUser($id) {
        $semantic=$this->jquery->semantic();
        $user = DAO::getOne("models\Utilisateur",$id  );
        $form=$semantic->dataForm("frmUser", $user);
        $form->setFields(["login","password","elementsMasques","fondEcran","couleur","ordre","statut","site","submit"]);
        $form->setCaptions(["Login","Password","Elements Masqués","Fond d'écran","Couleur","Ordre","Statut","Site","Valider"]);
        $form->fieldAsSubmit("submit","green","UsersController/updateUser/".$id,"#divUser");
        $sites=DAO::getAll("models\Site");
        $form->fieldAsDropDown("site",JArray::modelArray($sites,"getId","getNom"));
        $status=DAO::getAll("models\Statut");
        $form->fieldAsDropDown("statut",JArray::modelArray($status,"getId","getLibelle"));

        echo $form->compile($this->jquery);
        echo $this->jquery->compile();
        echo "<div id='divUser'></div>";
    }
    public function updateUser($id) {
        $user = DAO::getOne("models\Utilisateur",$id );
        RequestUtils::setValuesToObject($user,$_POST);
        if(DAO::update($user)){
            echo $user->getLogin()." modifié";
        }

    }

    public function deleteUser($id) {
        $user = DAO::getOne("models\Utilisateur",$id );
        if(DAO::remove($user)) {
            echo $user->getLogin()." supprimé";
        }
    }
}