<?php

return array(
  '#namespace' => 'micro\\controllers\\admin\\traits',
  '#uses' => array (
  'Startup' => 'micro\\controllers\\Startup',
  'DAO' => 'micro\\orm\\DAO',
  'StrUtils' => 'micro\\utils\\StrUtils',
  'CacheManager' => 'micro\\cache\\CacheManager',
  'ClassUtils' => 'micro\\cache\\ClassUtils',
  'InfoMessage' => 'micro\\controllers\\admin\\popo\\InfoMessage',
  'Database' => 'micro\\db\\Database',
  'HtmlSemDoubleElement' => 'Ajax\\semantic\\html\\base\\HtmlSemDoubleElement',
  'JsUtils' => 'Ajax\\JsUtils',
  'FsUtils' => 'micro\\utils\\FsUtils',
  'ModelsCreator' => 'micro\\orm\\creator\\ModelsCreator',
),
  '#traitMethodOverrides' => array (
  'micro\\controllers\\admin\\traits\\CheckTrait' => 
  array (
  ),
),
  'micro\\controllers\\admin\\traits\\CheckTrait' => array(
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'array', 'name' => 'steps'),
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'int', 'name' => 'activeStep'),
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'string', 'name' => 'engineering'),
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'JsUtils', 'name' => 'jquery')
  ),
  'micro\\controllers\\admin\\traits\\CheckTrait::_getAdminFiles' => array(
    array('#name' => 'return', '#type' => 'mindplay\\annotations\\standard\\ReturnAnnotation', 'type' => 'UbiquityMyAdminFiles')
  ),
);

