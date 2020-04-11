<?php
	
	namespace App\Models;

	use Ekolo\Framework\Bootstrap\Model;

	/**
	 * PagesModel
	 */
	class PagesModel extends Model
	{
		
		public function __construct()
		{
			parent::__construct();
			$this->setTable('pages');
		}
	}