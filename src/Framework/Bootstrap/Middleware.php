<?php

    /**
     * Ce fichier est une partie du Framework Ekolo
     * (c) Don de Dieu BOLENGE <dondedieubolenge@gmail.com>
     */
    namespace Ekolo\Framework\Bootstrap;

    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    /**
     * Classe Middleware principal
     */
    class Middleware
    {   
        /**
         * Instance de Ekolo\Framework\Http\Request
         * @var Request
         */
        protected $request;

        /**
         * Instance de Ekolo\Framework\Http\Response
         * @var Response
         */
        protected $response;

        public function __construct(Request $request, Response $response)
        {
            $this->request = new Request;
            $this->response = new Response;
        }

        /**
         * Renvoi l'instance de Ekolo\Framework\Http\Request
         * @return Request
         */
        public function request() : Request
        {
            return $this->request;
        }

        /**
         * Renvoi l'instance de Ekolo\Framework\Http\Response
         * @return Response
         */
        public function response() : Response
        {
            return $this->response;
        }

        /**
         * Signale s'y a erreur ou pas
         * @param bool $has
         */
        public function setHasError($has = true)
        {
            return $this->response->setHasError($has);
        }
    }
    