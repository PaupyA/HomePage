<?php

return array(
  '#namespace' => 'models',
  '#uses' => array (
),
  '#traitMethodOverrides' => array (
  'models\\Statut' => 
  array (
  ),
),
  'models\\Statut::$id' => array(
    array('#name' => 'id', '#type' => 'micro\\annotations\\IdAnnotation')
  ),
  'models\\Statut::$utilisateurs' => array(
    array('#name' => 'oneToMany', '#type' => 'micro\\annotations\\OneToManyAnnotation', "mappedBy"=>"statut","className"=>"models\Utilisateur")
  ),
);

