<?php

    /**
     * Ce fichier est une partie du Framework Ekolo
     * (c) Don de Dieu BOLENGE <dondedieubolenge@gmail.com>
     */
    namespace Ekolo\Framework\Utils;

    use Ekolo\Component\EkoSession\Session;

    /**
     * Permet de sauvegarder des messages flash
     */
    class Flash extends Session {

        /**
         * Vérifie si la session existe
         * @return bool
         */
        public function exists()
        {
            return parent::has('flash');
        }

        /**
         * Renvoi le message flash ou bien La clé du flash passé (type ou message)
         * @param string $key
         * @param mixed $default
         */
        public function get($key = null, $default = null)
        {
            if (empty($key) && empty($default)) {
                $flash = parent::get('flash');
                parent::remove('flash');

                return $flash;
            }else {
                if (!empty($key)) {
                    $result = parent::get('flash')[$key];
                    
                    if ($key == "message") {
                        parent::remove('flash');
                        return $result;
                    }
                }

                return !empty($default) ? [
                    'type' => $result,
                    'message' => $default
                ] : $result ;
            }
        }
    }