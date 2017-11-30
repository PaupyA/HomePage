<?php

return array(
  '#namespace' => 'models',
  '#uses' => array (
),
  '#traitMethodOverrides' => array (
  'models\\Etablissement' => 
  array (
  ),
),
  'models\\Etablissement::$id' => array(
    array('#name' => 'id', '#type' => 'micro\\annotations\\IdAnnotation')
  ),
  'models\\Etablissement::$lienwebs' => array(
    array('#name' => 'oneToMany', '#type' => 'micro\\annotations\\OneToManyAnnotation', "mappedBy"=>"etablissement","className"=>"models\Lienweb")
  ),
  'models\\Etablissement::$moteurs' => array(
    array('#name' => 'oneToMany', '#type' => 'micro\\annotations\\OneToManyAnnotation', "mappedBy"=>"etablissement","className"=>"models\Moteur")
  ),
);

