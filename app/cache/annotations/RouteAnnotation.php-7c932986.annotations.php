<?php

return array(
  '#namespace' => 'micro\\annotations\\router',
  '#uses' => array (
  'BaseAnnotation' => 'micro\\annotations\\BaseAnnotation',
),
  '#traitMethodOverrides' => array (
  'micro\\annotations\\router\\RouteAnnotation' => 
  array (
  ),
),
  'micro\\annotations\\router\\RouteAnnotation' => array(
    array('#name' => 'usage', '#type' => 'mindplay\\annotations\\UsageAnnotation', 'method'=>true,'class'=>true,'multiple'=>true, 'inherited'=>true)
  ),
);

