<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 05/11/2017
 * Time: 21:34
 */

namespace controllers;

use Ajax\service\JArray;
use micro\orm\DAO;
use Ajax\JsUtils;
use micro\utils\RequestUtils;
use models\Site;

/**
 * Controller UseController
 * @property JsUtils $jquery
 */

class ProfilController
{
    public function index() {
        $id = 1;
        $semantic=$this->jquery->semantic();

        $btHome=$semantic->htmlButton("btHome","");
        $btHome->asIcon("home")->asLink("Main");

        $user = DAO::getOne("models\Utilisateur",$id );

        $form=$semantic->dataForm("frmUserEdit", $user);

        $form->setFields(["login","password","elementsMasques","fondEcran","couleur","ordre","statut","site"]);
        $form->setCaptions(["Login","Password","Elements Masqués","Fond d'écran","Couleur","Ordre","Statut","Site"]);

        $sites=DAO::getAll("models\Site");
        $form->fieldAsDropDown("site",JArray::modelArray($sites,"getId","getNom"));

        $status=DAO::getAll("models\Statut");
        $form->fieldAsDropDown("statut",JArray::modelArray($status,"getId","getLibelle"));

        $this->jquery->compile($this->view);
        $this->loadview("profil/index.html");
    }
}