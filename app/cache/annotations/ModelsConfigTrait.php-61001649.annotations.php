<?php

return array(
  '#namespace' => 'micro\\controllers\\admin\\traits',
  '#uses' => array (
  'JsUtils' => 'Ajax\\JsUtils',
  'View' => 'micro\\views\\View',
  'Database' => 'micro\\db\\Database',
),
  '#traitMethodOverrides' => array (
  'micro\\controllers\\admin\\traits\\ModelsConfigTrait' => 
  array (
  ),
),
  'micro\\controllers\\admin\\traits\\ModelsConfigTrait' => array(
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'JsUtils', 'name' => 'jquery'),
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'View', 'name' => 'view')
  ),
  'micro\\controllers\\admin\\traits\\ModelsConfigTrait::_getAdminFiles' => array(
    array('#name' => 'return', '#type' => 'mindplay\\annotations\\standard\\ReturnAnnotation', 'type' => 'UbiquityMyAdminFiles')
  ),
);

