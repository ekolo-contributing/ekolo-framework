<?php
    /**
     * Ce fichier est une partie du Framework Ekolo, il régorge un bon nombre des fonctions utilisées dans le Framework
     * (c) Don de Dieu BOLENGE <dondedieubolenge@gmail.com>
     */

	use Ekolo\Framework\Bootstrap\Config;
	use Ekolo\Framework\Utils\Flash;
	use Ekolo\Framework\Http\Request;
	use Ekolo\Framework\Http\Response;

	if (!function_exists('initializer')) {
		/**
		 * Permet d'initialiser des fonctions ou autres
		 * @return void
		 */
		function initializer() {
			init_env();
		}
	}

    if (!function_exists('e')) {
		/**
		 * Permet d'échapper les balises html
		 * @param string $string La chaine à échapper
		 * @return string $string La chaine échappée
		 */
		function e($string)
		{
			return htmlspecialchars($string);
		}
    }
    
    if (!function_exists('config')) {
		/**
		 * Permet de renvoyer une configuration ou les tableaux de toutes les configuration
		 * @param string $conf La configuration à trouver
		 * @param string $default
		 * @return mixed
		 * 
		 */
		function config(string $conf, string $default = null) {
            $appConfig = new Config;
            $basePath = $appConfig->basePath();
            
			$config = preg_match('#\.#', $conf) ? explode('.', $conf) : $conf;
			$fileConf = is_array($config) ? $config[0] : $config;
			$filenameConf = $basePath.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.$fileConf.'.php';

			if (!file_exists($filenameConf)) {
				throw new \Exception('Le fichier de la configuration "'.$fileConf.'" n\'existe pas');
				
			}

			$data = require $filenameConf;

			return is_array($config) ? $data[$config[1]] : $data;
		}
	}

	if (!function_exists('array_key_first')) {
		/**
		 * Retourne la première clée du tableau
		 * @param array $array Le tableau en question
		 * @return mixed
		 */
		function array_key_first(array $array) {
			if (empty($array)) {
				throw new \Exception('Le paramètre doit être un tableau non null');
			}

			$array_keys = array_keys($array);
			return $array_keys[0];
		}
	}

	if (!function_exists('array_key_last')) {
		/**
		 * Retourne la dernière clé du tableau
		 * @param array $array
		 * @return mixed
		 */
		function array_key_last(array $array) {
			if (empty($array)) {
				throw new \Exception('Le paramètre doit être un tableau non null');
			}
			
			$array_keys = array_keys($array);
			$count = count($array_keys);
			return $array_keys[$count - 1];
		}
	}

	if (!function_exists('flash')) {
        /**
         * Permet de manipuler l'objet Ekolo\Framework\Utils\Flash
		 * @return Flash
         */
        function flash() {
            return new Flash;
        }
    }

    if (!function_exists('base_path')) {
		/**
		 * Permet de renvoyer le base path de l'application
		 * @return string $base_path
		 */
		function base_path() {
            return (new Config)->basePath();
		}
	}

	if (!function_exists('env')) {
		/**
		 * Permet de renvoyer une env
		 * @param string $key La clé de l'env
		 * @param mixed $default La valeur par défaut au cas où l'env n'existe pas
		 * @return string $env
		 */
		function env(string $key, $default = null) {
			return !empty($_ENV[$key]) ? $_ENV[$key] : $default;
		}
	}

	if (!function_exists('init_env')) {
		/**
		 * Permet d'initialiser les env
		 * @return void
		 */
		function init_env() {
			$envs_filename = base_path().DIRECTORY_SEPARATOR.'.env';
			$envs = $envs_array = [];
			
			if ($ressources = fopen($envs_filename, 'r')) {
				while (!feof($ressources)) {
					$element = fgets($ressources);

					if (!empty(trim($element))) {
						$element_array = explode('=', $element);
						$envs_array[$element_array[0]] = $element_array[1];
					}

					$envs[] = $element;
				}

				fclose($ressources);
			}

			$_ENV = array_merge($envs_array, $_ENV);
		}
	}

	if (!function_exists('request')) {
		/**
		 * Permet de renvoyer l'instance de Ekolo\Framework\Http\Request
		 * @return Request $request
		 */
		function request() {
			return new Request;
		}
	}

	if (!function_exists('response')) {
		/**
		 * Permet de renvoyer l'instance de Ekolo\Framework\Http\Response
		 * @return Response $response
		 */
		function response() {
			return new Response;
		}
	}