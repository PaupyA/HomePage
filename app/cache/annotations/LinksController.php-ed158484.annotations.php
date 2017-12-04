<?php

return array(
  '#namespace' => 'controllers',
  '#uses' => array (
  'JArray' => 'Ajax\\service\\JArray',
  'DAO' => 'micro\\orm\\DAO',
  'JsUtils' => 'Ajax\\JsUtils',
  'RequestUtils' => 'micro\\utils\\RequestUtils',
  'Lienweb' => 'models\\Lienweb',
  'Site' => 'models\\Site',
),
  '#traitMethodOverrides' => array (
  'controllers\\LinksController' => 
  array (
  ),
),
  'controllers\\LinksController' => array(
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'JsUtils', 'name' => 'jquery')
  ),
);

