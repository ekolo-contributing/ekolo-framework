<?php

    /**
     * Ce fichier est une partie du Framework Ekolo
     * (c) Don de Dieu BOLENGE <dondedieubolenge@gmail.com>
     */
    namespace Ekolo\Framework\Bootstrap;

    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Component\Routing\Router;
    use Ekolo\Component\Routing\Route;
    use Ekolo\Framework\Bootstrap\Middleware;

    class Application {

        /**
         * Instance de Ekolo\Component\Http\Request
         * @var Request
         */
        protected $request;

        /**
         * Instance de Ekolo\Component\Http\Response
         * @var Response
         */
        protected $response;

        /**
         * Liste des middlewares
         * @var array
         */
        protected $middlewares = [];

        /**
         * Instance de Ekolo\Component\Routing\Router
         * @var Router
         */
        protected $router;

        public function __construct()
        {
            $this->initializer();
            
            $this->request = new Request;
            $this->response = new Response;
            $this->router = new Router;
        }

        /**
         * Méthode chargée d'appeler les pages ou modules qu'il faut par rapport aux routes
         * @param string $prefixeUri Le prefixe de l'uri en cours
         * @param Router $router L'instance du router
         */
        public function use(string $prefixeUri, Router $router)
        {
            $regex = '#^'.$prefixeUri.'#';

            if ($prefixeUri === '/') {
                if ($route = $router->getRoute($this->request->method(), $this->request->uri())) {
                    $this->getController($route);
                }
            }else {
                if (preg_match($regex, $this->request->uri(), $matches)) {
                    $url = preg_replace($regex, '', $this->request->uri());
                    $url = empty($url) ? '/' : $url;

                    $route = $router->getRoute($this->request->method(), $url);

                    if ($route) {
                        $this->getController($route);
                    }else {
                        $this->trackError(404);
                    }
                }
            }
        }

        /**
         * Permet de lancer le controller par rapport à la route trouvée
         * @param Route $route L'instance de la Core\Route
         */
        public function getController(Route $route)
        {
            if ($route->vars()) {
				if (count($route->vars()) > 0) {
					$_GET = array_merge($_GET, $route->vars());
				}
            }

            $action = $route->action();
            
            if (is_callable($action) && $route->controller() == null) {
                
                $action($this->request, $this->response);
            }else {
                $controllerClass = config('namespace.controller').'\\'.ucfirst($route->controller());
                if (!class_exists($controllerClass)) {
                    throw new \Exception("La classe $controllerClass n'existe pas");
                }

                return new $controllerClass($route->action(), $this->request, $this->response);
            }
        }

        /**
         * Rajoute un middleware dans l'application
         * @param string|null $middleware Le nom du middleware à appeler
         * @param \Closure $callback La fonction callback à appeler
         */
        public function middleware($middleware = null, $callback)
        {
            if (!empty($this->middlewares[$middleware])) {
                throw new \Exception("Le middlware ".$middleware.' déjà ajouté');
            }

            if (!empty($middleware)) {
                $Middleware = config('namespace.middleware').'\\'.ucfirst($middleware).'Middleware';

                if (!class_exists($Middleware)) {
                    throw new \Exception('Le Middleware '.$Middleware.' n\'existe pas');
                }
                
                $this->middlewares[$middleware] = [
                    'middleware' => new $Middleware($this->request, $this->response),
                    'callback' => $callback
                ];

                $callback(new $Middleware($this->request, $this->response));

            }else {
                $this->middlewares[$middleware] = [
                    'middleware' => new $Middleware($this->request, $this->response),
                    'callback' => $callback
                ];

                $callback(new $Middleware($this->request, $this->response));
            }
        }

        /**
         * Permet de traquer les erreurs à partir du middleware erreurs
         * @param mixed $error L'erreur à traquer
         * @return void
         */
        public function trackError($error)
        {
            $middleware = $this->middlewares['errors']['middleware'];
            $middleware->setError($error);
            $this->middlewares['errors']['callback']($middleware);
        }

        /**
         * Permet d'initiliaser des fonctions et autres
         * @return void
         */
        public function initializer()
        {
            // Permet d'initiliaser des fonctions
            initializer();
        }
    }