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

    public function index() {
        $this->jquery->compile($this->view);
        $this->loadView("Connect/index.html");
    }

}
