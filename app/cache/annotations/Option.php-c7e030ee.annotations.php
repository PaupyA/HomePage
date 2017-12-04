<?php

return array(
  '#namespace' => 'models',
  '#uses' => array (
),
  '#traitMethodOverrides' => array (
  'models\\Option' => 
  array (
  ),
),
  'models\\Option::$id' => array(
    array('#name' => 'id', '#type' => 'micro\\annotations\\IdAnnotation'),
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"id","nullable"=>"","dbType"=>"int(11)")
  ),
  'models\\Option::$libelle' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"libelle","nullable"=>"","dbType"=>"varchar(45)")
  ),
);

