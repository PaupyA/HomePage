<?php

return array(
  '#namespace' => 'micro\\controllers\\admin\\traits',
  '#uses' => array (
  'JsUtils' => 'Ajax\\JsUtils',
  'StrUtils' => 'micro\\utils\\StrUtils',
  'ControllerAction' => 'micro\\controllers\\admin\\popo\\ControllerAction',
  'Router' => 'micro\\controllers\\Router',
  'CacheManager' => 'micro\\cache\\CacheManager',
  'Route' => 'micro\\controllers\\admin\\popo\\Route',
  'Startup' => 'micro\\controllers\\Startup',
),
  '#traitMethodOverrides' => array (
  'micro\\controllers\\admin\\traits\\RoutesTrait' => 
  array (
  ),
),
  'micro\\controllers\\admin\\traits\\RoutesTrait' => array(
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'JsUtils', 'name' => 'jquery')
  ),
);

