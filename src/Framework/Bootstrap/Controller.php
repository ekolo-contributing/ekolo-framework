<?php

    /**
     * Ce fichier est une partie du Framework Ekolo
     * (c) Don de Dieu BOLENGE <dondedieubolenge@gmail.com>
     */
    namespace Ekolo\Framework\Bootstrap;

    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    /**
     * Le controlleur principal
     */
    class Controller
    {
        public function __construct($action, Request $request, Response $response)
        {
            // $this->loadModel();

            if (is_callable([$this, $action])) {
                $this->$action($request, $response);
            }else {
                throw new \Exception('L\'action à appeler n\'existe pas dans le controller '.get_class($this));
            }
        }

    }
    