<?php

return array(
  '#namespace' => 'controllers',
  '#uses' => array (
  'RequestUtils' => 'micro\\utils\\RequestUtils',
  'Controller' => 'micro\\controllers\\Controller',
),
  '#traitMethodOverrides' => array (
  'controllers\\ControllerBase' => 
  array (
  ),
),
);

