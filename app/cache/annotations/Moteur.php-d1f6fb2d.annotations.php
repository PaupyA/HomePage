<?php

return array(
  '#namespace' => 'models',
  '#uses' => array (
),
  '#traitMethodOverrides' => array (
  'models\\Moteur' => 
  array (
  ),
),
  'models\\Moteur::$id' => array(
    array('#name' => 'id', '#type' => 'micro\\annotations\\IdAnnotation')
  ),
  'models\\Moteur::$etablissement' => array(
    array('#name' => 'manyToOne', '#type' => 'micro\\annotations\\ManyToOneAnnotation'),
    array('#name' => 'joinColumn', '#type' => 'micro\\annotations\\JoinColumnAnnotation', "className"=>"models\Etablissement","name"=>"idEtablissement","nullable"=>false)
  ),
  'models\\Moteur::$site' => array(
    array('#name' => 'manyToOne', '#type' => 'micro\\annotations\\ManyToOneAnnotation'),
    array('#name' => 'joinColumn', '#type' => 'micro\\annotations\\JoinColumnAnnotation', "className"=>"models\Site","name"=>"idSite","nullable"=>false)
  ),
  'models\\Moteur::$utilisateur' => array(
    array('#name' => 'manyToOne', '#type' => 'micro\\annotations\\ManyToOneAnnotation'),
    array('#name' => 'joinColumn', '#type' => 'micro\\annotations\\JoinColumnAnnotation', "className"=>"models\Utilisateur","name"=>"idUtilisateur","nullable"=>false)
  ),
);

