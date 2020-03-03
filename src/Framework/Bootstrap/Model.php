<?php

    /**
     * Ce fichier est une partie du Framework Ekolo
     * (c) Don de Dieu BOLENGE <dondedieubolenge@gmail.com>
     */
    namespace Ekolo\Framework\Bootstrap;

	/**
	 * Le model principal
	 */
	class Model
	{
        static $connections = [];
        
		protected $req = [];
		protected $table;
		protected $db;
		protected $primaryKey = 'id';
		protected $conf = 'default';

		/**
		 * Charge l'instance de l'objet Conf et l'objet PDO de la BDD
		 * @return void
		 */
		public function __construct()
		{
			$this->dbConnexion();
		}

        /**
         * Permet de se faire connecter à la base de données
         * @return void
         */
		public function dbConnexion()
		{
			// Connexion à la base de données
			$conf = \config('database');

			try {
				$pdo = new \PDO('mysql:host='.$conf['DB_HOST'].';dbname='.$conf['DB_DATABASE'], 
					$conf['DB_USERNAME'], 
					$conf['DB_PASSWORD'],
					[\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
				);
				$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
				self::$connections[$this->conf] = $pdo;
				$this->db = $pdo;
				
			} catch (\PDOException $e) {
				if (DB::$debug >= 1) {
					die($e->getMessage());
				}else{
					die('Impossible de se connecter à la base de données.');
				}
			}
		}

		/**
		 * 
		 */
		public function wherePredicate($where)
		{
			if (!empty($where)) {
				$sql .= ' WHERE ';
				$i = 1;
				$valuesExecute = [];
		
				if (!empty($where['and'])) {
					$sql .= '(';
		
					foreach ($where['and'] as $field => $value) {
						$i++;
						$valuesExecute[$field] = $value;
						$addAnd = ($i <= count($where['and'])) ? ' AND ' : '';
						$sql .= $field.' = :'.$field.$addAnd;
					}
		
					$sql .= ')';
				}
		
				if (!empty($where['or'])) {
					$i = 1;
					$sql .= !empty($where['and']) && ($i <= 2) ? ' OR ' : '';
					$sql .= '(';
		
					foreach ($where['or'] as $field => $value) {
						$i++;
						$addOr = $i <= count($where['or']) ? ' OR ' : '';
						$fieldExecute = key_exists($field, $valuesExecute) ? $field.$i : $field;
						$sql .= $field.' = :'.$fieldExecute.$addOr;
						$valuesExecute[$fieldExecute] = $value;
					}
		
					$sql .= ')';
				}
		
				debug($sql);
		
				$and = !empty($where['and']) ? implode('AND', $where['and']) : '';
			}
		}

		/**
		 * Permet de supprimer une entrée dans une table
         * @param array $predicate La condition à valider pour supprimer
		 * @param string $table La table à supprimer les données
		 * @return void
		 */
		public function delete(array $predicate = [], string $table = null)
		{
			if ($table) {
				$this->table = $table;
			}

			if (!empty($predicate)) {
				$sql = 'DELETE FROM '.$table;

				if ($req['cond']) {
					$sql .= ' WHERE '.$req['cond'];
				}

				$req = $this->db->prepare($sql);
				$req->execute();
			}
        }
        
        /**
         * Permet de créer un nouvel enregistrement dans une table
         * @param array $donnees Le tableau contenant les données qu'il faut ajouter
         * @param string $table
		 * @return bool
         */
        public function create(array $datas, string $table)
        {
            $this->add($datas, $table);
        }

		/**
		 * Permet d'ajouter un enregistrement dans une table
		 * @param array $donnees Le tableau contenant les données qu'il faut ajouter
         * @param string $table
		 * @return bool
		 */
		public function add(array $donnees, string $table = null)
		{
			if ($table) {
				$this->table = $table;
			}

			if (!is_array($donnees)) {
				throw new Exception('La variable $donnees dans la methode Model::add() doit être un tableau associatif');
			}else{
				$fields = $values = $q = [];
				foreach ($donnees as $key => $value) {
					$fields[] = $key;
					$values[":$key"] = $value;
				}

				for ($i=0; $i < count($fields); $i++) { 
					$q[] = str_replace($fields[$i], ':'.$fields[$i], $fields[$i]);
				}

				$str_fields = implode(',', $fields);
				$str_q		= implode(',', $q);

				$sql = 'INSERT INTO '.$this->table.'('.$str_fields.') VALUES('.$str_q.')';
				// debug($sql);

				$req = $this->db->prepare($sql);
				$req->execute($values);

				return $this->lastInsert();
			}
		}

		/**
		 * Modifie un ou plusieurs enregistrements
		 * @param array $data Les données à modifier
		 * @return bool
		 */
		public function update(array $data, string $table = null)
		{
			if ($table) {
				$this->table = $table;
			}

			$key = $this->primaryKey;
			$fields = $d = [];
			foreach ($data as $k => $v) {
				if ($k !== $this->primaryKey) {
					$fields[] = "$k=:$k";
				}
				
				$d[":$k"] = $v; 
			}

			$sql = 'UPDATE '.$this->table.' SET '.implode(',', $fields).' WHERE '.$key.'=:'.$key;

			$req = $this->db->prepare($sql);
			$req->execute($d);

			return true;
		}

		/**
		 * Permet de récuperer des infos dans la table
		 * @param array $req Les req pour récuperer
		 * @return array $data Les données trouvées
		 */
		public function find(array $req = [], string $table = null)
		{
			if ($table) {
				$this->table = $table;
			}

			$sql = 'SELECT ';

			$sql .= isset($req['champs']) ? $req['champs'].' ' : '* ';
			$sql .= 'FROM ' . $this->table .' ';
			$sql .= isset($req['cond']) ? 'WHERE '.$req['cond'] : '';
			$sql .= isset($req['limit']) ? ' LIMIT '.$req['limit'] : '';

			$req = $this->db->prepare($sql);
			$req->execute();
			
			if ($req) {
				return $req->fetchAll(\PDO::FETCH_OBJ);
			}

			return false;
		}

		/**
		 * Recherche tous les enregistrements
         * @param array $req
         * @param string $table
         * @return array
		 */
		public function findAll(array $req = [], string $table = null)
		{
			return $this->find($req, $table);
		}

		/**
		 * Permet de récuperer seulement un enregistrement
		 * @param array $req Les req qu'il faut
         * @param string $table La table à rechercher les données
		 * @return object $data les données trouvées
		 */
		public function findOne(array $req, string $table = null)
		{
			return $this->find($req, $table) 
				   ? current($this->find($req, $table)) 
				   : false;
		}

		/**
		 * Recherche par rapport à l'id de cet enregistrement
		 * @param int $id L'id de cet enregistrement
		 * @param string $table La table où on fait cette recherche
         * @return array
		 */
		public function findById(int $id, string $table = null)
		{
			return $this->find(['cond' => 'id='.$id], $table);
		}
		
		/**
		 * Permet de compter le nombre des enregistremetns
		 * @param array $req Les contraintes de la recherche des enregistrements
		 * @param string $table La table à compter les enregistrements
		 */
		public function count($req = [], $table = null)
		{
			return count($this->find($req, $table));
		}

        /**
         * Modifie la table liée au Model
         * @param string $table La table à manipuler
         * @return void
         */
		public function setTable(string $table)
		{
			$this->table = $table;
		}

        /**
         * Renvoi le nom de la table dont le model est lié
         * @return string $table
         */
		public function table()
		{
			return $this->table;
		}

        /**
         * Modifie le champ de la clé primaire
         * @param string $key Le nouveau champ de la PK
         * @return void
         */
		public function setPrimaryKey(string $key)
		{
			$this->primaryKey = $key;
		}

        /**
         * Renvoi la champ de la clé primaire
         * @return string $primaryKey
         */
		public function primaryKey()
		{
			return $this->primaryKey;
		}

		/**
		 * Renvoi la dernière entrée dans la base de données
         * @return object
		 */
		public function lastInsert()
		{
			return $this->findOne(['cond' => 'id='.$this->db->lastInsertId()]);
		}
	}