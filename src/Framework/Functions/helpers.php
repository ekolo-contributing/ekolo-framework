<?php
    /**
     * Ce fichier est une partie du Framework Ekolo, il régorge un bon nombre des fonctions utilisées dans le Framework
     * (c) Don de Dieu BOLENGE <dondedieubolenge@gmail.com>
     */

    use Ekolo\Framework\Bootstrap\Config;

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
		 */
		function config(string $conf) {
            $appConfig = new Config;
            $basePath = $appConfig->basePath();
            
			$config = preg_match('#\.#', $conf) ? explode('.', $conf) : $conf;
			$fileConf = is_array($config) ? $config[0] : $config;
			$filenameConf = $basePath.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.$fileConf.'.php';

			$data = require $filenameConf;

			return is_array($config) ? $data[$config[1]] : $data;
		}
	}
