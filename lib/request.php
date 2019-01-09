<?php

/**
 * Helper functions
 * v1.2 - with mqtt enhancements
*/


function is_base64_encoded($data) {
//    if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data)) 
      if (preg_match('/^([A-Za-z0-9]|\+|\/|\-|\=|\s)+$/', $data))
       return TRUE;
      
    return FALSE;
};

function is_fqdn($str) {
    $CI =& get_instance();
    $CI->form_validation->set_message('fqdn','The %s is not a valid domain name.');
    $tld_list = array(
            'arp', 'com', 'edu', 'gov', 'int', 'mil', 'net', 'org',
            'aero', 'biz', 'coop', 'info', 'museum', 'name', 'pro', 'ws',
            'ac', 'ad', 'ae', 'af', 'ag', 'ai', 'al', 'am', 'an', 'ao', 'aq', 'ar', 'as',
            'at', 'au', 'aw', 'az', 'ba', 'bb', 'bd', 'be', 'bf', 'bg', 'bh', 'bi', 'bj',
            'bm', 'bn', 'bo', 'br', 'bs', 'bt', 'bv', 'bw', 'by', 'bz', 'ca', 'cc', 'cd',
            'cf', 'cg', 'ch', 'ci', 'ck', 'cl', 'cm', 'cn', 'co', 'cr', 'cu', 'cv', 'cx',
            'cy', 'cz', 'de', 'dj', 'dk', 'dm', 'do', 'dz', 'ec', 'ee', 'eg', 'eh', 'er',
            'es', 'et', 'fi', 'fj', 'fk', 'fm', 'fo', 'fr', 'ga', 'gd', 'ge', 'gf', 'gg',
            'gh', 'gi', 'gl', 'gm', 'gn', 'gp', 'gq', 'gr', 'gs', 'gt', 'gu', 'gw', 'gy',
            'hk', 'hm', 'hn', 'hr', 'ht', 'hu', 'id', 'ie', 'il', 'im', 'in', 'io', 'iq',
            'ir', 'is', 'it', 'je', 'jm', 'jo', 'jp', 'ke', 'kg', 'kh', 'ki', 'km', 'kn',
            'kp', 'kr', 'kw', 'ky', 'kz', 'la', 'lb', 'lc', 'li', 'lk', 'lr', 'ls', 'lt',
            'lu', 'lv', 'ly', 'ma', 'mc', 'md', 'mg', 'mh', 'mk', 'ml', 'mm', 'mn', 'mo',
            'mp', 'mq', 'mr', 'ms', 'mt', 'mu', 'mv', 'mw', 'mx', 'my', 'mz', 'na', 'nc',
            'ne', 'nf', 'ng', 'ni', 'nl', 'no', 'np', 'nr', 'nu', 'nz', 'om', 'pa', 'pe',
            'pf', 'pg', 'ph', 'pk', 'pl', 'pm', 'pn', 'pr', 'ps', 'pt', 'pw', 'py', 'qa',
            're', 'ro', 'ru', 'rw', 'sa', 'sb', 'sc', 'sd', 'se', 'sg', 'sh', 'si', 'sj',
            'sk', 'sl', 'sm', 'sn', 'so', 'sr', 'st', 'sv', 'sy', 'sz', 'tc', 'td', 'tf',
            'tg', 'th', 'tj', 'tk', 'tm', 'tn', 'to', 'tp', 'tr', 'tt', 'tv', 'tw', 'tz',
            'ua', 'ug', 'uk', 'um', 'us', 'uy', 'uz', 'va', 'vc', 've', 'vg', 'vi', 'vn',
            'vu', 'wf', 'ws', 'ye', 'yt', 'yu', 'za', 'zm', 'zw' );

    $label = '[\\w][\\w\\.\\-]{0,61}[\\w]';
    $tld = '[\\w]+';

    if ($c=preg_match( "/^($label)\\.($tld)$/", $str, $match ) && in_array( $match[2], $tld_list )) 
        return TRUE;
    else
        return FALSE;       
}

class Val {
	public static function boolean($value) {
		$value = filter_var($value,FILTER_SANITIZE_STRING);

		if (isset($value[0]) && $value[0] == '1')
			return true;
		if (isset($value[0]) && $value[0] == '0')
			return false;
		if (substr($value,0,4) == 'true')
			return true;
		if (substr($value,0,5) == 'false')
			return false;
		if (!empty($value))
			return true;
		return false;
	}

	public static function date($value) {
		return strftime(filter_var($value,FILTER_SANITIZE_STRING));
	}

	public static function float($value) {
		return filter_var($value,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
	}
	
	public static function base64($value) {
             if (is_base64_encoded($value)) 
                  return $value;
             return false;         
	}


        public static function fqdn($value) {
            if (is_fqdn($value))
                 return filter_var($value,FILTER_SANITIZE_STRING);
        }

	public static function hash($value,$max = 128) {
		$value = filter_var($value,FILTER_SANITIZE_STRING);
		$value = preg_replace('/[^A-z0-9]/', '', substr($value,0,$max));
		return $value;
	}

	public static function integer($value) {
		$value = filter_var($value,FILTER_SANITIZE_NUMBER_INT);
		return intval($value);
	}

	public static function password($value) {
		$value = escapeshellarg($value);
		return $value;
	}

	public static function string($value) {
		return filter_var($value,FILTER_SANITIZE_STRING);
	}

	public static function time($value) {
		return strftime(filter_var($value,FILTER_SANITIZE_STRING));
	}

	public static function url($value) {
		//DBG::log('Filter URL: '.$value);
		return filter_var($value,FILTER_SANITIZE_URL);
	}

	public static function filename($value) {
		//TODO: no better filter yet
		return realpath(filter_var($value,FILTER_SANITIZE_URL));
	}
	
	public static function path($value) {
		return realpath(self::string($value));
	}

	public static function topic($value) {
		if (preg_match('/[^A-z0-9, \-_\/\+]/',$value))
			return false;
		return preg_replace('/[^A-z0-9, \-_\/\+]/','',$value);
	}
	
	public static function is_base64_encoded($data) {
		//    if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data))
		if (preg_match('/^([A-Za-z0-9]|\+|\/|\-|\=|\s)+$/', $data))
			return TRUE;
			
		return FALSE;
	}
	
	public static function is_fqdn($str) {
		$CI =& get_instance();
		$CI->form_validation->set_message('fqdn','The %s is not a valid domain name.');
		$tld_list = array(
				'arp', 'com', 'edu', 'gov', 'int', 'mil', 'net', 'org',
				'aero', 'biz', 'coop', 'info', 'museum', 'name', 'pro', 'ws',
				'ac', 'ad', 'ae', 'af', 'ag', 'ai', 'al', 'am', 'an', 'ao', 'aq', 'ar', 'as',
				'at', 'au', 'aw', 'az', 'ba', 'bb', 'bd', 'be', 'bf', 'bg', 'bh', 'bi', 'bj',
				'bm', 'bn', 'bo', 'br', 'bs', 'bt', 'bv', 'bw', 'by', 'bz', 'ca', 'cc', 'cd',
				'cf', 'cg', 'ch', 'ci', 'ck', 'cl', 'cm', 'cn', 'co', 'cr', 'cu', 'cv', 'cx',
				'cy', 'cz', 'de', 'dj', 'dk', 'dm', 'do', 'dz', 'ec', 'ee', 'eg', 'eh', 'er',
				'es', 'et', 'fi', 'fj', 'fk', 'fm', 'fo', 'fr', 'ga', 'gd', 'ge', 'gf', 'gg',
				'gh', 'gi', 'gl', 'gm', 'gn', 'gp', 'gq', 'gr', 'gs', 'gt', 'gu', 'gw', 'gy',
				'hk', 'hm', 'hn', 'hr', 'ht', 'hu', 'id', 'ie', 'il', 'im', 'in', 'io', 'iq',
				'ir', 'is', 'it', 'je', 'jm', 'jo', 'jp', 'ke', 'kg', 'kh', 'ki', 'km', 'kn',
				'kp', 'kr', 'kw', 'ky', 'kz', 'la', 'lb', 'lc', 'li', 'lk', 'lr', 'ls', 'lt',
				'lu', 'lv', 'ly', 'ma', 'mc', 'md', 'mg', 'mh', 'mk', 'ml', 'mm', 'mn', 'mo',
				'mp', 'mq', 'mr', 'ms', 'mt', 'mu', 'mv', 'mw', 'mx', 'my', 'mz', 'na', 'nc',
				'ne', 'nf', 'ng', 'ni', 'nl', 'no', 'np', 'nr', 'nu', 'nz', 'om', 'pa', 'pe',
				'pf', 'pg', 'ph', 'pk', 'pl', 'pm', 'pn', 'pr', 'ps', 'pt', 'pw', 'py', 'qa',
				're', 'ro', 'ru', 'rw', 'sa', 'sb', 'sc', 'sd', 'se', 'sg', 'sh', 'si', 'sj',
				'sk', 'sl', 'sm', 'sn', 'so', 'sr', 'st', 'sv', 'sy', 'sz', 'tc', 'td', 'tf',
				'tg', 'th', 'tj', 'tk', 'tm', 'tn', 'to', 'tp', 'tr', 'tt', 'tv', 'tw', 'tz',
				'ua', 'ug', 'uk', 'um', 'us', 'uy', 'uz', 'va', 'vc', 've', 'vg', 'vi', 'vn',
				'vu', 'wf', 'ws', 'ye', 'yt', 'yu', 'za', 'zm', 'zw' );
		
		$label = '[\\w][\\w\\.\\-]{0,61}[\\w]';
		$tld = '[\\w]+';
		
		if ($c=preg_match( "/^($label)\\.($tld)$/", $str, $match ) && in_array( $match[2], $tld_list ))
			return TRUE;
		else
			return FALSE;
	}
	
}


/**
 * Get query class
 *
 * @author dada
 *
 */
class Get {
	public static function string($name) {
		if (isset($_GET[$name])) {
			return Val::string($_GET[$name]);
		}
	}
	public static function fqdn($name) {
		if (isset($_GET[$name])) {
			return Val::fqdn($_GET[$name]);
		}
	}

	public static function date($name) {
		if (isset($_GET[$name])) {
			return Val::date($_GET[$name]);
		}
	}

	public static function time($name) {
		if (isset($_GET[$name])) {
			return Val::time($_GET[$name]);
		}
	}

	public static function hash($name,$max=128) {
		if (isset($_GET[$name])) {
			return Val::hash($_GET[$name],$max);
		}
	}

	public static function integer($name) {
		if (isset($_GET[$name])) {
			return Val::integer($_GET[$name]);
		}
	}

	public static function float($name) {
		if (isset($_GET[$name])) {
			return Val::float($_GET[$name]);
		}
	}

	public static function password($name) {
		if (isset($_GET[$name])) {
			return Val::password($_GET[$name]);
		}
	}

	public static function set($name) {
		return isset($_GET[$name]);
	}

	public static function url($name) {
		if (isset($_GET[$name])) {
			return Val::url($_GET[$name]);
		}
	}

	public static function boolean($name) {
		if (isset($_GET[$name])) {
			return Val::boolean($_GET[$name]);
		}
	}
	
	public static function path($name) {
		if (isset($_GET[$name])) {
			return Val::path($_GET[$name]);
		}
	}

	public static function topic($name) {
		if (isset($_GET[$name])) {
			return Val::topic($_GET[$name]);
		}
	}
}

/**
 * POST query clas
 * @author dada
 *
 */
class Post {
	 public static function base64($name) {
	if (isset($_POST[$name])) 
            return Val::base64($_POST[$name]);
    }
	
	public static function string($name) {
		if (isset($_POST[$name])) {
			return Val::string($_POST[$name]);
		}
	}
	public static function fqdn($name) {
		if (isset($_POST[$name])) {
			return Val::fqdn($_POST[$name]);
		}
	}

	public static function date($name) {
		if (isset($_POST[$name])) {
			return Val::date($_POST[$name]);
		}
	}

	public static function hash($name,$max=128) {
		if (isset($_POST[$name])) {
			return Val::hash($_POST[$name],$max);
		}
	}

	public static function time($name) {
		if (isset($_POST[$name])) {
			return Val::time($_POST[$name]);
		}
	}

	public static function integer($name) {
		if (isset($_POST[$name])) {
			return Val::integer($_POST[$name]);
		}
	}
	
	
	public static function intArray($name) {
		if (isset($_POST[$name]) && is_array($_POST[$name])) {
			$return = array();
			foreach ($_POST[$name] as $key => $pval) {
				$key = Val::hash($key,32);
				$return[$key] = Val::integer($pval);
			}
			return $return;
		}
	}
	
	public static function floatArray($name) {
		if (isset($_POST[$name]) && is_array($_POST[$name])) {
			$return = array();
			foreach ($_POST[$name] as $key => $pval) {
				$key = Val::hash($key,32);
				$return[$key] = Val::float($pval);
			}
			return $return;
		}
	}
	
	public static function float($name) {
		if (isset($_POST[$name])) {
			return Val::float($_POST[$name]);
		}
	}

	public static function password($name) {
		if (isset($_POST[$name])) {
			return Val::password($_GET[$name]);
		}
	}
	
	public static function url($name) {
		if (isset($_POST[$name])) {
			return Val::url($_POST[$name]);
		}
	}

	public static function set($name) {
		return isset($_POST[$name]);
	}

	public static function userId($name) {
		if (isset($_POST[$name])) {
			$uname = Val::string($_POST[$name]);
			return preg_replace('/[^0-9A-z_\-\@]/','',$uname);
		}
	}

	public static function boolean($name) {
		if (isset($_POST[$name])) {
			return Val::boolean($_POST[$name]);
		}
		return false;
	}
	public static function path($name) {
		if (isset($_POST[$name])) {
			return Val::path($_POST[$name]);
		}
	}
}


/**
 * TODO: FILE query class
 */

?>

