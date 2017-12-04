<?php

return array(
  '#namespace' => 'models',
  '#uses' => array (
),
  '#traitMethodOverrides' => array (
  'models\\Site' => 
  array (
  ),
),
  'models\\Site::$id' => array(
    array('#name' => 'id', '#type' => 'micro\\annotations\\IdAnnotation'),
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"id","nullable"=>"","dbType"=>"int(11)")
  ),
  'models\\Site::$nom' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"nom","nullable"=>1,"dbType"=>"varchar(45)")
  ),
  'models\\Site::$latitude' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"latitude","nullable"=>1,"dbType"=>"double")
  ),
  'models\\Site::$longitude' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"longitude","nullable"=>1,"dbType"=>"double")
  ),
  'models\\Site::$ecart' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"ecart","nullable"=>1,"dbType"=>"double")
  ),
  'models\\Site::$fondEcran' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"fondEcran","nullable"=>1,"dbType"=>"varchar(255)")
  ),
  'models\\Site::$couleur' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"couleur","nullable"=>1,"dbType"=>"varchar(10)")
  ),
  'models\\Site::$ordre' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"ordre","nullable"=>1,"dbType"=>"varchar(255)")
  ),
  'models\\Site::$options' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"options","nullable"=>1,"dbType"=>"varchar(255)")
  ),
  'models\\Site::$moteur' => array(
    array('#name' => 'manyToOne', '#type' => 'micro\\annotations\\ManyToOneAnnotation'),
    array('#name' => 'joinColumn', '#type' => 'micro\\annotations\\JoinColumnAnnotation', "className"=>"models\\Moteur","name"=>"idMoteur","nullable"=>"")
  ),
  'models\\Site::$lienwebs' => array(
    array('#name' => 'oneToMany', '#type' => 'micro\\annotations\\OneToManyAnnotation', "mappedBy"=>"site","className"=>"models\\Lienweb")
  ),
  'models\\Site::$reseaus' => array(
    array('#name' => 'oneToMany', '#type' => 'micro\\annotations\\OneToManyAnnotation', "mappedBy"=>"site","className"=>"models\\Reseau")
  ),
  'models\\Site::$utilisateurs' => array(
    array('#name' => 'oneToMany', '#type' => 'micro\\annotations\\OneToManyAnnotation', "mappedBy"=>"site","className"=>"models\\Utilisateur")
  ),
);

