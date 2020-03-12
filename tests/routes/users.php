<?php

    use Ekolo\Framework\Bootstrap\Config;
    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;

    $router->get('/', 'PagesController@index');
    $router->get('/liste', function ($request, $response) {
        session('flash', [
            'type' => 'info',
            'message' => "Juste pour un message flash"
        ]);

        debug(flash()->get('type', "Quoi ooooh"));

        echo "Bonjour";
    });

    return $router;