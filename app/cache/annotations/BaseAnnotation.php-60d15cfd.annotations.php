<?php

return array(
  '#namespace' => 'micro\\annotations',
  '#uses' => array (
  'Annotations' => 'mindplay\\annotations\\Annotations',
  'JArray' => 'micro\\utils\\JArray',
  'Annotation' => 'mindplay\\annotations\\Annotation',
  'ClassUtils' => 'micro\\cache\\ClassUtils',
),
  '#traitMethodOverrides' => array (
  'micro\\annotations\\BaseAnnotation' => 
  array (
  ),
),
  'micro\\annotations\\BaseAnnotation' => array(
    array('#name' => 'usage', '#type' => 'mindplay\\annotations\\UsageAnnotation', 'property'=>true, 'inherited'=>true)
  ),
);

