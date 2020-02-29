<?php
    require_once __DIR__.'./../vendor/autoload.php';

    use Ekolo\Framework\Bootstrap\Application;
    use Ekolo\Framework\Bootstrap\Config;
    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Bootstrap\Middleware;

    // function test(?string $arg) {
    //     debug($arg);
    // }

    // test(null);

    // di('ddd');

    $router = new Router;
    // $router->get('/', function ($request, $response) {
    //     echo "Salut à tous";
    // });

    $router->get('/', 'PagesController@index');

    $router->get('/liste', function ($request, $response) {
        echo "Bonjour";
    });

    $app = new Application;

    // debug($_ENV);

    

    $app->middleware('errors', function (Middleware $middleware) {
        // $middleware->error404();
        // debug($middleware);
        $middleware->getError();
        // debug("dddd");
    });

    
    
    $app->use('/', $router);

    // debug((new Config)->basePath());

    // debug(config('app.APP_NAME'));

    // $reponse = new Response;
    // // $reponse->setTemplate('layout');
    // $reponse->render('users/liste', [
    //     'title' => 'Salut ici'
    // ]);