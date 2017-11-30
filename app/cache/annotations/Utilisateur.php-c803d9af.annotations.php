<?php

return array(
  '#namespace' => 'models',
  '#uses' => array (
),
  '#traitMethodOverrides' => array (
  'models\\Utilisateur' => 
  array (
  ),
),
  'models\\Utilisateur::$id' => array(
    array('#name' => 'id', '#type' => 'micro\\annotations\\IdAnnotation')
  ),
  'models\\Utilisateur::$site' => array(
    array('#name' => 'manyToOne', '#type' => 'micro\\annotations\\ManyToOneAnnotation'),
    array('#name' => 'joinColumn', '#type' => 'micro\\annotations\\JoinColumnAnnotation', "className"=>"models\Site","name"=>"idSite","nullable"=>false)
  ),
  'models\\Utilisateur::$statut' => array(
    array('#name' => 'manyToOne', '#type' => 'micro\\annotations\\ManyToOneAnnotation'),
    array('#name' => 'joinColumn', '#type' => 'micro\\annotations\\JoinColumnAnnotation', "className"=>"models\Statut","name"=>"idStatut","nullable"=>false)
  ),
  'models\\Utilisateur::$lienwebs' => array(
    array('#name' => 'oneToMany', '#type' => 'micro\\annotations\\OneToManyAnnotation', "mappedBy"=>"utilisateur","className"=>"models\Lienweb")
  ),
  'models\\Utilisateur::$moteurs' => array(
    array('#name' => 'oneToMany', '#type' => 'micro\\annotations\\OneToManyAnnotation', "mappedBy"=>"utilisateur","className"=>"models\Moteur")
  ),
);

