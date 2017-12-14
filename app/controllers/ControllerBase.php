<?php
namespace controllers;
use micro\utils\RequestUtils;
use micro\controllers\Controller;
use micro\orm\DAO;
use Ajax\JsUtils;
use models\Site;

/**
 * Controller UseController
 * @property JsUtils $jquery
 */

 /**
 * ControllerBase
 **/
abstract class ControllerBase extends Controller{

	public function initialize()
    {
        if (!RequestUtils::isAjax()) {
            if (!isset($_SESSION['user'])) {
                $this->loadView("main/vHeader.html");
            } elseif (isset($_SESSION['user'])) {
                $this->loadView("main/vHeader.html");
            }
        }
        if(!isset($_SESSION['user'])){
            $fondEcran = "https://wallpaperscraft.com/image/forest_lake_reflection_island_mist_97668_1920x1080.jpg";
        } elseif (isset($_SESSION['user'])) {
            $fondEcran = $_SESSION['user']->getFondEcran();
        }

        /*
         * Applique le fond d'écran
         */
        $this->jquery->exec("$('body').attr('style','background: url(".$fondEcran.") no-repeat fixed; background-size: cover;');",true);
    }

	public function finalize(){
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vFooter.html");
		}
	}
}
