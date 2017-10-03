<?php

return array(
  '#namespace' => 'controllers',
  '#uses' => array (
  'DAO' => 'micro\\orm\\DAO',
  'JsUtils' => 'Ajax\\JsUtils',
  'RequestUtils' => 'micro\\utils\\RequestUtils',
  'Site' => 'models\\Site',
),
  '#traitMethodOverrides' => array (
  'controllers\\SitesController' => 
  array (
  ),
),
  'controllers\\SitesController' => array(
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'JsUtils', 'name' => 'jquery')
  ),
  'controllers\\SitesController::index' => array(
    array('#name' => 'route', '#type' => 'micro\\annotations\\router\\RouteAnnotation', "/home")
  ),
  'controllers\\SitesController::all' => array(
    array('#name' => 'route', '#type' => 'micro\\annotations\\router\\RouteAnnotation', "/listeSites")
  ),
  'controllers\\SitesController::addSite' => array(
    array('#name' => 'route', '#type' => 'micro\\annotations\\router\\RouteAnnotation', "addSite/.*?")
  ),
  'controllers\\SitesController::newSite' => array(
    array('#name' => 'route', '#type' => 'micro\\annotations\\router\\RouteAnnotation', "newSite/.*?")
  ),
  'controllers\\SitesController::editSite' => array(
    array('#name' => 'route', '#type' => 'micro\\annotations\\router\\RouteAnnotation', "editSite/.*?")
  ),
);

