<?php
namespace controllers;
use micro\utils\RequestUtils;
use micro\controllers\Controller;
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
                $this->loadView("main/vHeader.html", ["fond" => $_SESSION['user']->getFondEcran()]);
            }
        }
    }

	public function finalize(){
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vFooter.html");
		}
	}
}
