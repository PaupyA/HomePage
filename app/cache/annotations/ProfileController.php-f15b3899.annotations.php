<?php

return array(
  '#namespace' => 'controllers',
  '#uses' => array (
  'JArray' => 'Ajax\\service\\JArray',
  'DAO' => 'micro\\orm\\DAO',
  'JsUtils' => 'Ajax\\JsUtils',
  'RequestUtils' => 'micro\\utils\\RequestUtils',
  'Site' => 'models\\Site',
  'LinksController' => 'controllers\\LinksController',
),
  '#traitMethodOverrides' => array (
  'controllers\\ProfileController' => 
  array (
  ),
),
  'controllers\\ProfileController' => array(
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'JsUtils', 'name' => 'jquery')
  ),
);

