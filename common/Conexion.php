

	<?php
	//namespace Espacio\De\Nombres;
	class Conexion {

		static private $instance;

		/**
		* @return PDO Return a PDO instance representing a connection to a database
		*/
		public static function getConexion() {

			if(self::$instance == NULL){
				$PDOinstance = new PDO("mysql:host=localhost;dbname=rec_face;charset=utf8", "root", "udevfacial");
				$PDOinstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$instance = $PDOinstance;
			}
			return self::$instance;

		}

	}
