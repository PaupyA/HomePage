<?php

return array(
  '#namespace' => 'models',
  '#uses' => array (
),
  '#traitMethodOverrides' => array (
  'models\\Lienweb' => 
  array (
  ),
),
  'models\\Lienweb::$id' => array(
    array('#name' => 'id', '#type' => 'micro\\annotations\\IdAnnotation'),
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"id","nullable"=>"","dbType"=>"int(11)")
  ),
  'models\\Lienweb::$libelle' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"libelle","nullable"=>1,"dbType"=>"varchar(150)")
  ),
  'models\\Lienweb::$url' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"url","nullable"=>1,"dbType"=>"varchar(255)")
  ),
  'models\\Lienweb::$ordre' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"ordre","nullable"=>1,"dbType"=>"int(11)")
  ),
  'models\\Lienweb::$etablissement' => array(
    array('#name' => 'manyToOne', '#type' => 'micro\\annotations\\ManyToOneAnnotation'),
    array('#name' => 'joinColumn', '#type' => 'micro\\annotations\\JoinColumnAnnotation', "className"=>"models\\Etablissement","name"=>"idEtablissement","nullable"=>"")
  ),
  'models\\Lienweb::$site' => array(
    array('#name' => 'manyToOne', '#type' => 'micro\\annotations\\ManyToOneAnnotation'),
    array('#name' => 'joinColumn', '#type' => 'micro\\annotations\\JoinColumnAnnotation', "className"=>"models\\Site","name"=>"idSite","nullable"=>"")
  ),
  'models\\Lienweb::$utilisateur' => array(
    array('#name' => 'manyToOne', '#type' => 'micro\\annotations\\ManyToOneAnnotation'),
    array('#name' => 'joinColumn', '#type' => 'micro\\annotations\\JoinColumnAnnotation', "className"=>"models\\Utilisateur","name"=>"idUtilisateur","nullable"=>"")
  ),
);

