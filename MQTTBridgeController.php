<?php
require_once 'lib/request.php';
require_once 'lib/phpMQTT.php';
require_once 'view/PublishView.php';

use techdada\phpMQTT;

class MQTTBridgeController {
	/**
	 * @var View $view
	 * */
	protected $view = null;
	protected function route() {
		switch (Get::hash('do',12)) {
			case 'subscribe':
				echo 'not implemented';
				break;
			case 'publish':
			default:
				$this->view = new PublishView();
				$this->view->setTitle('Publish');
				if (!$topic = Get::topic('topic')) {
					$this->view->setError('no topic');
				}
				if (!$user = Get::hash('user')) {
					if (!$user = Post::hash('user')) {
						$this->view->setWarning('no user');
					}
				}
				if ($user) {
					if (!$pass = Get::string('pass')) {
						if (!$pass = Post::string('pass')) {
							$this->view->setError('empty password');
						}
					}
				}

				$retain = 0;
				if (Get::boolean('retain')) {
					$retain = 1;
				} 
		
				//do not care for value - could be empty, why not?
				$value = urldecode(Get::string('value'));
				if (!$value) {
                                        if (Get::set('valuets')) $value = gmdate('Y-m-d H:i:s e');
                                        else $value = '';
                                }	
				$this->publish($topic,$value,$retain,$user,$pass);
				$this->view->render();
		}
	}

	public function __construct() {
		$this->route();
	}

	protected function publish($topic,$value,$retain,$user='',$pass='') {
		$broker = Config::get('mqtt_broker');
		$port   = Config::get('mqtt_port');
		$ca     = Config::get('ca');
		if (!file_exists($ca)) $this->view->setError('CA file not found');
		$tls    = Config::get('mqtt_tls');

		if (!$topic) {
			$this->view->setError('No topic to publish to!');
			return ;
		}
		$mqtt = new phpMQTT($broker,$port,'msqto_brdge',$ca,$tls);
		if ($mqtt->connect(true, NULL, $user, $pass)) {
		//      echo 'publish '.$key.' = '.$value."\n";
		        $mqtt->publish($topic, $value, 0,$retain);
			$mqtt->close();
			$this->view->setInfo('published '.$value.' to '.$topic."\n");
		} else {
			$this->view->setError("Time out!\n");
		}

	}

	public function getView() {
		return $this->view;	
	}
}
