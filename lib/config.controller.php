<?php

class Config {
        protected static $config;
        public static function get($name) {
                return self::$config[$name];
        }
        public static function set($name,$data) {
                if ( $name=='ALL' ) return (self::$config = $data);
                return (self::$config[$name] = $data);
        }
}
?>
