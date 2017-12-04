<?php

return array(
  '#namespace' => 'micro\\controllers\\admin',
  '#uses' => array (
  'JString' => 'Ajax\\service\\JString',
  'HtmlHeader' => 'Ajax\\semantic\\html\\elements\\HtmlHeader',
  'HtmlButton' => 'Ajax\\semantic\\html\\elements\\HtmlButton',
  'DAO' => 'micro\\orm\\DAO',
  'OrmUtils' => 'micro\\orm\\OrmUtils',
  'Startup' => 'micro\\controllers\\Startup',
  'Autoloader' => 'micro\\controllers\\Autoloader',
  'UbiquityMyAdminData' => 'micro\\controllers\\admin\\UbiquityMyAdminData',
  'ControllerBase' => 'controllers\\ControllerBase',
  'RequestUtils' => 'micro\\utils\\RequestUtils',
  'HtmlItem' => 'Ajax\\semantic\\html\\content\\view\\HtmlItem',
  'CacheManager' => 'micro\\cache\\CacheManager',
  'Route' => 'micro\\controllers\\admin\\popo\\Route',
  'Router' => 'micro\\controllers\\Router',
  'CacheFile' => 'micro\\controllers\\admin\\popo\\CacheFile',
  'HtmlFormFields' => 'Ajax\\semantic\\html\\collections\\form\\HtmlFormFields',
  'ControllerAction' => 'micro\\controllers\\admin\\popo\\ControllerAction',
  'HtmlForm' => 'Ajax\\semantic\\html\\collections\\form\\HtmlForm',
  'ModelsConfigTrait' => 'micro\\controllers\\admin\\traits\\ModelsConfigTrait',
  'FsUtils' => 'micro\\utils\\FsUtils',
  'ClassToYuml' => 'micro\\utils\\yuml\\ClassToYuml',
  'Yuml' => 'micro\\utils\\yuml\\Yuml',
  'ClassesToYuml' => 'micro\\utils\\yuml\\ClassesToYuml',
  'HtmlList' => 'Ajax\\semantic\\html\\elements\\HtmlList',
  'HtmlDropdown' => 'Ajax\\semantic\\html\\modules\\HtmlDropdown',
  'HtmlMenu' => 'Ajax\\semantic\\html\\collections\\menus\\HtmlMenu',
  'JsUtils' => 'Ajax\\JsUtils',
  'Direction' => 'Ajax\\semantic\\html\\base\\constants\\Direction',
  'RestTrait' => 'micro\\controllers\\admin\\traits\\RestTrait',
  'CacheTrait' => 'micro\\controllers\\admin\\traits\\CacheTrait',
  'ControllersTrait' => 'micro\\controllers\\admin\\traits\\ControllersTrait',
  'ModelsTrait' => 'micro\\controllers\\admin\\traits\\ModelsTrait',
  'RoutesTrait' => 'micro\\controllers\\admin\\traits\\RoutesTrait',
  'StrUtils' => 'micro\\utils\\StrUtils',
  'ClassUtils' => 'micro\\cache\\ClassUtils',
  'UbiquityUtils' => 'micro\\utils\\UbiquityUtils',
  'RestException' => 'micro\\exceptions\\RestException',
),
  '#traitMethodOverrides' => array (
  'micro\\controllers\\admin\\UbiquityMyAdminBaseController' => 
  array (
  ),
),
  'micro\\controllers\\admin\\UbiquityMyAdminBaseController::$adminData' => array(
    array('#name' => 'var', '#type' => 'mindplay\\annotations\\standard\\VarAnnotation', 'type' => 'UbiquityMyAdminData')
  ),
  'micro\\controllers\\admin\\UbiquityMyAdminBaseController::$adminViewer' => array(
    array('#name' => 'var', '#type' => 'mindplay\\annotations\\standard\\VarAnnotation', 'type' => 'UbiquityMyAdminViewer')
  ),
  'micro\\controllers\\admin\\UbiquityMyAdminBaseController::$adminFiles' => array(
    array('#name' => 'var', '#type' => 'mindplay\\annotations\\standard\\VarAnnotation', 'type' => 'UbiquityMyAdminFiles')
  ),
  'micro\\controllers\\admin\\UbiquityMyAdminBaseController::_diagramMenu' => array(
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'string', 'name' => 'url'),
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'string', 'name' => 'params'),
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'string', 'name' => 'responseElement'),
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'string', 'name' => 'type'),
    array('#name' => 'return', '#type' => 'mindplay\\annotations\\standard\\ReturnAnnotation', 'type' => 'HtmlMenu')
  ),
  'micro\\controllers\\admin\\UbiquityMyAdminBaseController::_getAdminData' => array(
    array('#name' => 'return', '#type' => 'mindplay\\annotations\\standard\\ReturnAnnotation', 'type' => 'UbiquityMyAdminData')
  ),
  'micro\\controllers\\admin\\UbiquityMyAdminBaseController::_getAdminViewer' => array(
    array('#name' => 'return', '#type' => 'mindplay\\annotations\\standard\\ReturnAnnotation', 'type' => 'UbiquityMyAdminViewer')
  ),
  'micro\\controllers\\admin\\UbiquityMyAdminBaseController::_getAdminFiles' => array(
    array('#name' => 'return', '#type' => 'mindplay\\annotations\\standard\\ReturnAnnotation', 'type' => 'UbiquityMyAdminFiles')
  ),
);

