<?php

    /**
     * Ce fichier est une partie du Framework Ekolo
     * (c) Don de Dieu BOLENGE <dondedieubolenge@gmail.com>
     */
    namespace Ekolo\Framework\Bootstrap;

    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Bootstrap\Model;

    /**
     * Le controlleur principal
     */
    class Controller
    {
        /**
         * Les méthodes considerées comme des __contruct des traits
         */
        protected $traitsContructs = [];

        public function __construct($action, Request $request, Response $response)
        {
            if (!empty($this->traitsContructs)) {
                foreach ($this->traitsContructs as $contruct) {
                    if (is_callable([$this, $contruct])) {
                        $this->$contruct();
                    }
                }
            }

            if (is_callable([$this, $action])) {
                $this->$action($request, $response);
            }else {
                throw new \Exception('L\'action à appeler n\'existe pas dans le controller '.get_class($this));
            }
        }

    }
    