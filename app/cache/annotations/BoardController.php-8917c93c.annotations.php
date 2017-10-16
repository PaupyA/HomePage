<?php

return array(
  '#namespace' => 'controllers',
  '#uses' => array (
  'DAO' => 'micro\\orm\\DAO',
  'JsUtils' => 'Ajax\\JsUtils',
  'RequestUtils' => 'micro\\utils\\RequestUtils',
),
  '#traitMethodOverrides' => array (
  'controllers\\BoardController' => 
  array (
  ),
),
  'controllers\\BoardController' => array(
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'JsUtils', 'name' => 'jquery')
  ),
);

