<?php

$router->get('', 'controllers/indexController.php');
$router->get('about', 'controllers/aboutController.php');
$router->get('contact', 'controllers/contactController.php');
$router->post('add-name', 'controllers/addNameController.php');