<?php
    /**
     * Ce fichier est une partie du Framework Ekolo
     * (c) Don de Dieu BOLENGE <dondedieubolenge@gmail.com>
     */
    namespace Ekolo\Framework\Http;

    use Ekolo\Component\Http\Response as HTTPResponse;

    /**
     * Gère les réponses HTTP
     */
    class Response extends HTTPResponse {

        public function __construct()
        {
            $this->setTemplate(\config('app.APP_DEFAULT_LAYOUT_PAGE'));
            parent::__construct();
        }

        /**
         * La vue à afficher
         * @var string
         */
        protected $view;

        /**
         * Le template à éttendre la vue
         * @var string
         */
        protected $template;

        /**
         * Modifie la vue à afficher
         * @param string $view La vue à affecter
         * @return void
         */
        public function setView(string $view)
        {
            $view = preg_replace('#\/|\.#', DIRECTORY_SEPARATOR, $view);
            $view = '.'.DIRECTORY_SEPARATOR.config('path.views').DIRECTORY_SEPARATOR.$view.'.php';

            // debug($view);

            if (!file_exists($view)) {
				throw new \Exception('Le fichier spécifié pour la vue n\'existe pas');
            }

            $this->view = $view;
        }

        /**
         * Modifie le template
         * @param string $template
         * @return void
         */
        public function setTemplate(string $template)
        {
            $template = preg_replace('#\/|\.#', DIRECTORY_SEPARATOR, $template);
            $template = '.'.DIRECTORY_SEPARATOR.config('path.views').DIRECTORY_SEPARATOR.$template.'.php';

            if (!file_exists($template)) {
				throw new \Exception('Le fichier spécifié pour le layout n\'existe pas');
            }
            
            $this->template = $template;
        }

        /**
         * Permet de retourner une vue
         * @param string $view La vue à retourner
         * @param array $vars Les variables à passer dans la vue
         * @param int $status Le status à renvoyer
         * @param array $headers Les headers à envoyer
         */
        public function render(string $view, array $vars = [], int $status = 200, array $headers = [])
        {
            $vars += $this->vars;

			if (!empty($vars)) {
				extract($vars);
			}

			$this->setView($view);
			
			ob_start();
			require $this->view;
			$content = ob_get_clean();

            require $this->template;
            

            $this->setStatus($status);
            $this->addHeaders($headers);
        }
    }