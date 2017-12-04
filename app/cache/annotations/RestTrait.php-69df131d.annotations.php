<?php

return array(
  '#namespace' => 'micro\\controllers\\admin\\traits',
  '#uses' => array (
  'JString' => 'Ajax\\service\\JString',
  'HtmlForm' => 'Ajax\\semantic\\html\\collections\\form\\HtmlForm',
  'HtmlLabel' => 'Ajax\\semantic\\html\\elements\\HtmlLabel',
  'StrUtils' => 'micro\\utils\\StrUtils',
  'JsUtils' => 'Ajax\\JsUtils',
  'CacheManager' => 'micro\\cache\\CacheManager',
  'Startup' => 'micro\\controllers\\Startup',
  'HtmlIconGroups' => 'Ajax\\semantic\\html\\elements\\HtmlIconGroups',
  'RequestUtils' => 'micro\\utils\\RequestUtils',
  'FsUtils' => 'micro\\utils\\FsUtils',
  'RestServer' => 'micro\\controllers\\rest\\RestServer',
  'View' => 'micro\\views\\View',
  'DocParser' => 'micro\\annotations\\parser\\DocParser',
  'HtmlMessage' => 'Ajax\\semantic\\html\\collections\\HtmlMessage',
  'UbiquityException' => 'micro\\exceptions\\UbiquityException',
),
  '#traitMethodOverrides' => array (
  'micro\\controllers\\admin\\traits\\RestTrait' => 
  array (
  ),
),
  'micro\\controllers\\admin\\traits\\RestTrait' => array(
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'View', 'name' => 'view'),
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'JsUtils', 'name' => 'jquery')
  ),
  'micro\\controllers\\admin\\traits\\RestTrait::showSimpleMessage' => array(
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'string', 'name' => 'content'),
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'string', 'name' => 'type'),
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'string', 'name' => 'icon'),
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'int', 'name' => 'timeout'),
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'string', 'name' => 'staticName'),
    array('#name' => 'return', '#type' => 'mindplay\\annotations\\standard\\ReturnAnnotation', 'type' => 'HtmlMessage')
  ),
);

