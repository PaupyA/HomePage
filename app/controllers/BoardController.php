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

        echo "</br ><h1> Tableau de bord </h1> <h3>Vue d'ensemble</h3> </br>";

        $btSites=$semantic->htmlButton("btSites","Gestion des sites");
        $btSites->asLink("SitesController");

        $btUsers=$semantic->htmlButton("btUsers","Gestion des utilisateurs");
        $btUsers->asLink("UsersController");

        $btLinks=$semantic->htmlButton("btLinks","Gestion des liens");
        $btLinks->asLink("LinksController");

        $bt=$semantic->htmlButton("btUsers","Gestion des utilisateurs");
        $btUsers->asLink("UsersController");

        echo $btSites;
        echo $btUsers;
        echo $btLinks;
    }
}