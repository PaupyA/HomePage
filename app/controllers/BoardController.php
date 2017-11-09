<?php
/**
 * Created by PhpStorm.
 * User: roullandq
 * Date: 12/10/2017
 * Time: 09:21
 */

namespace controllers;

use micro\orm\DAO;
use Ajax\JsUtils;
use micro\utils\RequestUtils;

/**
 * Controller UseController
 * @property JsUtils $jquery
 */

class BoardController extends ControllerBase
{
    public function index() {
        $semantic=$this->jquery->semantic();

        $btHome=$semantic->htmlButton("btHome","");
        $btHome->asIcon("home")->asLink("");

        $btSites=$semantic->htmlButton("btSites","Gestion des sites");
        $btSites->asLink("SitesController");

        $btUsers=$semantic->htmlButton("btUsers","Gestion des utilisateurs");
        $btUsers->asLink("UsersController");

        $btLinks=$semantic->htmlButton("btLinks","Gestion des liens");
        $btLinks->asLink("LinksController");

        $this->jquery->compile($this->view);
        $this->loadView("board/index.html");
    }
}