<?php

    /**
     * Here, we are connecting '/' (base path) to controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, /app/View/Pages/home.ctp)...
     */
    Router::connect('/', ['controller' => 'pages', 'action' => 'display']);
    Router::connect('/loadlocations', ['controller' => 'pages', 'action' => 'loadlocations']);
/*
 * ...and connect the rest of 'Pages' controller's URLs.
 */
    Router::connect('/pages/*', ['controller' => 'pages', 'action' => 'display']);
    Router::connect('/licences', ['controller' => 'licences', 'action' => 'contact']);
/*
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
Router::connect(
    '/ApiCommandes/ApiOrderUpdateMethod/:storeId/orders/:orderId/replace_products', // E.g. /blog/3-CakePHP_Rocks
    ['controller' => 'ApiCommandes', 'action' => 'ApiOrderUpdateMethod'],
    [
        // order matters since this will simply map ":id" to
        // $articleId in your action
        'pass' => ['storeId', 'orderId'],
         ]);
    CakePlugin::routes();

    /**
     * Load the CakePHP default routes. Only remove this if you do not want to use
     * the built-in default routes.
     */
    require CAKE.'Config'.DS.'routes.php';
