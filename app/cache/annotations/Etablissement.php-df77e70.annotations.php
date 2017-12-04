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
    array('#name' => 'id', '#type' => 'micro\\annotations\\IdAnnotation'),
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"id","nullable"=>"","dbType"=>"int(11)")
  ),
  'models\\Etablissement::$fondEcran' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"fondEcran","nullable"=>1,"dbType"=>"varchar(255)")
  ),
  'models\\Etablissement::$couleur' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"couleur","nullable"=>1,"dbType"=>"varchar(10)")
  ),
  'models\\Etablissement::$ordre' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"ordre","nullable"=>1,"dbType"=>"varchar(255)")
  ),
  'models\\Etablissement::$options' => array(
    array('#name' => 'column', '#type' => 'micro\\annotations\\ColumnAnnotation', "name"=>"options","nullable"=>1,"dbType"=>"varchar(255)")
  ),
  'models\\Etablissement::$lienwebs' => array(
    array('#name' => 'oneToMany', '#type' => 'micro\\annotations\\OneToManyAnnotation', "mappedBy"=>"etablissement","className"=>"models\\Lienweb")
  ),
  'models\\Etablissement::$moteur' => array(
    array('#name' => 'manyToOne', '#type' => 'micro\\annotations\\ManyToOneAnnotation'),
    array('#name' => 'joinColumn', '#type' => 'micro\\annotations\\JoinColumnAnnotation', "className"=>"models\\Moteur","name"=>"idMoteur","nullable"=>"")
  ),
);

