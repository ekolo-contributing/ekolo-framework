<?php

    /**
     * Ce fichier est une partie du Framework Ekolo
     * (c) Don de Dieu BOLENGE <dondedieubolenge@gmail.com>
     */
    namespace Ekolo\Framework\Bootstrap;

    use Ekolo\Framework\Http\Request;

    /**
     * Classe de configuration de l'application
     * @package Ekolo\Framework\Bootstrap\Config
     */
    class Config {

        /**
         * L'instance de Ekolo\Framework\Http\Request
         * @var Request
         */
        protected $request;

        public function __construct()
        {
            $this->request = new Request;
        }

        /**
         * Renvoi le path de base de l'application
         * @return string
         */
        public function basePath()
        {
            return $this->request->server()->DOCUMENT_ROOT();
        }
    }