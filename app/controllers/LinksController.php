<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 09/11/2017
 * Time: 09:33
 */

namespace controllers;

use Ajax\service\JArray;
use micro\orm\DAO;
use Ajax\JsUtils;
use micro\utils\RequestUtils;
use models\Lienweb;
use models\Site;

/**
 * Controller UseController
 * @property JsUtils $jquery
 */

class LinksController extends ControllerBase
{

    public function index() {
        $semantic=$this->jquery->semantic();

        $btHome=$semantic->htmlButton("btHome","");
        $btHome->asIcon("home")->asLink("BoardController");

        $bts=$semantic->htmlButtonGroups("buttons",["Liste des liens","Ajouter un lien"]);
        $bts->setPropertyValues("data-ajax", ["all/","addLink/"]);
        $bts->getOnClick("LinksController/","#divLink",["attr"=>"data-ajax"]);

        $this->_all();
        $this->jquery->compile($this->view);
        $this->loadView("links/index.html");
    }

    private function _all() {
        $links=DAO::getAll("models\Lienweb");

        $semantic=$this->jquery->semantic();

        $table=$semantic->dataTable("tblLinks", "models\Lienweb", $links);

        $table->setIdentifierFunction(function($i,$o){return $o->getId();});
        $table->setFields(["libelle","url"]);
        $table->setCaptions(["Site","URL"]);

        $table->addEditButton(false);
        $table->addDeleteButton(false);
        $table->setUrls(["edit"=>"LinksController/editLink","delete"=>"LinksController/deleteLink"]);
        $table->setTargetSelector("#divLink");
    }

    public function all() {
        $this->_all();
        $this->jquery->compile($this->view);
        $this->loadView("links/all.html");
    }

    private function _perso() {
        $links=DAO::getAll("models\Lienweb");

        $semantic=$this->jquery->semantic();

        $btHome=$semantic->htmlButton("btHome","");
        $btHome->asIcon("home")->asLink("");

        $btBack=$semantic->htmlButton("back","Informations");
        $btBack->asLink("ProfileController");

        $table=$semantic->dataTable("tblLinks", "models\Lienweb", $links);

        $table->setIdentifierFunction(function($i,$o){return $o->getId();});
        $table->setFields(["libelle","url"]);
        $table->setCaptions(["Site","URL"]);

        $table->addEditButton(false);
        $table->addDeleteButton(false);
        $table->setUrls(["edit"=>"LinksController/editLink","delete"=>"LinksController/deleteLink"]);
        $table->setTargetSelector("#divLink");
    }

    public function perso() {
        $this->_perso();
        $this->jquery->compile($this->view);
        $this->loadView("profil/link.html");
    }

    private function _addLink() {
        $semantic=$this->jquery->semantic();

        $link=new Lienweb();
        $link->idSite="";

        $form=$semantic->dataForm("frmLinkAdd", $link);

        $form->setFields(["libelle\n","url","ordre","idSite\n","submit"]);
        $form->setCaptions(["Site internet","URL","Ordre","Site","Valider"]);

        $sites=DAO::getAll("models\Site");
        $form->fieldAsDropDown("idSite\n",JArray::modelArray($sites,"getId","getNom"));

        $form->fieldAsSubmit("submit","blue","LinksController/newLink/","#divLink");
    }

    public function addLink() {
        $this->_addLink();
        $this->jquery->compile($this->view);
        $this->loadView("links/add.html");
    }
    public function newLink() {
        $semantic=$this->jquery->semantic();
        $link=new Lienweb();

        RequestUtils::setValuesToObject($link,$_POST);

        $site=DAO::getOne("models\Site",$_POST["idSite"]);

        $link->setSite($site);

        if(DAO::insert($link)){
            echo $semantic->htmlMessage("#divLink","".$link->getLibelle()." ajouté");
            $this->all();
        }
    }

    private function _editLink($id) {
        $semantic=$this->jquery->semantic();

        $link = DAO::getOne("models\Lienweb",$id  );
        $link->idSite=$link->getSite()->getId();
        $form=$semantic->dataForm("frmLinkEdit", $link);
        $form->setFields(["id","libelle\n","url","ordre","idSite\n","submit"]);
        $form->setCaptions(["id","Site internet","URL","Ordre","Site","Valider"]);
        $form->fieldAsHidden("id");
        $sites=DAO::getAll("models\Site");
        $form->fieldAsDropDown("idSite\n",JArray::modelArray($sites,"getId","getNom"));

        $form->fieldAsSubmit("submit","blue","LinksController/updateLink/","#divLink");

    }

    public function editLink($id) {
        $this->_editLink($id);
        $this->jquery->compile($this->view);
        $this->loadView("links/edit.html");
    }
    public function updateLink() {
        $semantic=$this->jquery->semantic();
        $link = DAO::getOne("models\Lienweb",$_POST["id"] );
        $site = DAO::getOne("models\Site", $_POST["idSite"]);
        $link->setSite($site);

        RequestUtils::setValuesToObject($link,$_POST);

        if(DAO::update($link)){
            echo $semantic->htmlMessage("#divLink","".$link->getLibelle()." modifié");
            $this->all();
        }

    }


    public function deleteLink($id) {
        $semantic=$this->jquery->semantic();
        $link = DAO::getOne("models\Lienweb",$id );

        if(DAO::remove($link)) {
            echo $semantic->htmlMessage("#divLink","".$link->getLibelle()." supprimé");
            $this->all();
        }
    }

}