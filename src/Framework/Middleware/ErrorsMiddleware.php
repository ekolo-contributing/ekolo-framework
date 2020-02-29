<?php

    /**
     * Ce fichier est une partie du Framework Ekolo
     * (c) Don de Dieu BOLENGE <dondedieubolenge@gmail.com>
     */
    namespace Ekolo\Framework\Middleware;

    use Ekolo\Framework\Bootstrap\Middleware;

    /**
     * Middleware gérant les erreurs
     */
    class ErrorsMiddleware extends Middleware {

        /**
         * Permet de renvoyer à la page d'erreur 404
         * @return void
         */
        public function error404()
        {
            if ($this->response->hasError()) {
                $errors_path = \config('path.views_error');

                $this->response->setTemplate($errors_path);
                $this->response->render($errors_path.'.404');
            }
        }

    }