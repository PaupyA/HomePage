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
        $frm->fieldAsSubmit("submit","blue fluid","sTest/dePost","#frm2-4-submit");
        $bt=$semantic->htmlButton("bt1","S'identifier","blue","$('#modal-frm2-4').modal('show');");
        $bt->addIcon("sign in");

        echo $frm->asModal();
        echo $bt;

        $frmSearch=$semantic->htmlForm("frmSearch");
        $frmSearch->addInput("search","","","","Rechercher...");

        $this->jquery->compile($this->view);
        $this->loadView("index.html");
    }
}
