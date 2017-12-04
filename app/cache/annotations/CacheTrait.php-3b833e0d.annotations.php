<?php

return array(
  '#namespace' => 'micro\\controllers\\admin\\traits',
  '#uses' => array (
  'JsUtils' => 'Ajax\\JsUtils',
  'CacheManager' => 'micro\\cache\\CacheManager',
  'Startup' => 'micro\\controllers\\Startup',
  'CacheFile' => 'micro\\controllers\\admin\\popo\\CacheFile',
  'RequestUtils' => 'micro\\utils\\RequestUtils',
  'HtmlForm' => 'Ajax\\semantic\\html\\collections\\form\\HtmlForm',
),
  '#traitMethodOverrides' => array (
  'micro\\controllers\\admin\\traits\\CacheTrait' => 
  array (
  ),
),
  'micro\\controllers\\admin\\traits\\CacheTrait' => array(
    array('#name' => 'property', '#type' => 'mindplay\\annotations\\standard\\PropertyAnnotation', 'type' => 'JsUtils', 'name' => 'jquery')
  ),
);

