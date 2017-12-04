<?php

return array(
  '#namespace' => 'micro\\controllers',
  '#uses' => array (
  'View' => 'micro\\views\\View',
),
  '#traitMethodOverrides' => array (
  'micro\\controllers\\Controller' => 
  array (
  ),
),
  'micro\\controllers\\Controller::$view' => array(
    array('#name' => 'var', '#type' => 'mindplay\\annotations\\standard\\VarAnnotation', 'type' => 'View')
  ),
  'micro\\controllers\\Controller::loadView' => array(
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'string', 'name' => 'viewName'),
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'mixed', 'name' => 'pData'),
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'boolean', 'name' => 'asString'),
    array('#name' => 'return', '#type' => 'mindplay\\annotations\\standard\\ReturnAnnotation', 'type' => 'string')
  ),
  'micro\\controllers\\Controller::isValid' => array(
    array('#name' => 'return', '#type' => 'mindplay\\annotations\\standard\\ReturnAnnotation', 'type' => 'boolean')
  ),
  'micro\\controllers\\Controller::forward' => array(
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'string', 'name' => 'controller'),
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'string', 'name' => 'action'),
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'mixed', 'name' => 'params'),
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'boolean', 'name' => 'initialize'),
    array('#name' => 'param', '#type' => 'mindplay\\annotations\\standard\\ParamAnnotation', 'type' => 'boolean', 'name' => 'finalize')
  ),
);

