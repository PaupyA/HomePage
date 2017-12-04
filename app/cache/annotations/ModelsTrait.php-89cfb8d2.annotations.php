<?php

return array(
  '#namespace' => 'micro\\controllers\\admin\\traits',
  '#uses' => array (
  'JsUtils' => 'Ajax\\JsUtils',
  'OrmUtils' => 'micro\\orm\\OrmUtils',
  'RequestUtils' => 'micro\\utils\\RequestUtils',
  'Reflexion' => 'micro\\orm\\parser\\Reflexion',
  'DAO' => 'micro\\orm\\DAO',
  'JString' => 'Ajax\\service\\JString',
  'HtmlHeader' => 'Ajax\\semantic\\html\\elements\\HtmlHeader',
  'Startup' => 'micro\\controllers\\Startup',
  'HtmlCheckbox' => 'Ajax\\semantic\\html\\modules\\checkbox\\HtmlCheckbox',
),
  '#traitMethodOverrides' => array (
  'micro\\controllers\\admin\\traits\\ModelsTrait' => 
  array (
  ),
),
  'micro\\controllers\\admin\\traits\\ModelsTrait' => array(
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'JsUtils', 'name' => 'jquery')
  ),
);

