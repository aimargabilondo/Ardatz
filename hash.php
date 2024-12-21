<?php

	class Password {
		const SALT = 'EstoEsUnSalt';
		public static function hash($pass) {
			return hash('sha512', self::SALT . $pass);
		}
		public static function verify($pass, $hash) {
			return ($hash == self::hash($pass));
		}
	}
	
?>