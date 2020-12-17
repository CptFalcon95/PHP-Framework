<?php

$router->define([
    '' => 'controllers/indexController.php',
    'about' => 'controllers/aboutController.php',
    'about/culture' => 'controllers/about-cultureController',
    'contact' => 'controllers/contactController.php'
]);