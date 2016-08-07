<?php

class Url {

	protected $page = '';
	protected $params = array();
	protected $anchor = array();

	protected static $rewriting = array(
		array(
			'rule' => '^$',
			'redirect' => 'index.php?page=home'
		),
		array(
			'rule' => '^([a-zA-Z0-9-]+)/api$',
			'redirect' => 'index.php?project=$1&page=api'
		),
		array(
			'rule' => '^api$',
			'redirect' => 'index.php?page=api'
		),
		array(
			'rule' => '^home$',
			'redirect' => 'index.php?page=home'
		),
		array(
			'rule' => '^all_issues$',
			'redirect' => 'index.php?page=all_issues'
		),
		array(
			'rule' => '^install$',
			'redirect' => 'index.php?page=install'
		),
		array(
			'rule' => '^settings$',
			'redirect' => 'index.php?page=settings'
		),
		array(
			'rule' => '^error/([0-9]{3})$',
			'redirect' => 'index.php?page=error/$1'
		),
		array(
			'rule' => '^signup$',
			'redirect' => 'index.php?page=signup'
		),
		array(
			'rule' => '^login$',
			'redirect' => 'index.php?page=login'
		),
		array(
			'rule' => '^([a-zA-Z0-9-]+)/dashboard$',
			'redirect' => 'index.php?project=$1&page=dashboard'
		),
		array(
			'rule' => '^([a-zA-Z0-9-]+)/issues$',
			'redirect' => 'index.php?project=$1&page=issues'
		),
		array(
			'rule' => '^([a-zA-Z0-9-]+)/labels/([a-z0-9-]+)$',
			'redirect' => 'index.php?project=$1&page=issues&label=$2'
		),
		array(
			'rule' => '^([a-zA-Z0-9-]+)/milestone/([a-z0-9-_\.]+)$',
			'redirect' => 'index.php?project=$1&page=issues&milestone=$2'
		),
		array(
			'rule' => '^([a-zA-Z0-9-]+)/search$',
			'redirect' => 'index.php?project=$1&page=search'
		),
		array(
			'rule' => '^([a-zA-Z0-9-]+)/issues/([0-9]+)$',
			'redirect' => 'index.php?project=$1&page=view_issue&id=$2'
		),
		array(
			'rule' => '^([a-zA-Z0-9-]+)/issues/new$',
			'redirect' => 'index.php?project=$1&page=new_issue'
		),
		array(
			'rule' => '^([a-zA-Z0-9-]+)/rss$',
			'redirect' => 'index.php?project=$1&page=rss'
		),
		array(
			'rule' => '^users/([0-9]+)$',
			'redirect' => 'index.php?page=view_user&id=$1'
		),
		array(
			'rule' => '^public/ajax$',
			'redirect' => 'index.php?page=ajax'
		),
		array(
			'rule' => '^public/uploads/(.*)$',
			'redirect' => 'index.php?page=downloads&file=$1'
		),
		array(
			'rule' => '^public/identicons/([0-9a-z]{32}).png$',
			'redirect' => 'index.php?page=identicons&seed=$1'
		)
	);

	public function __construct($page, $params = array(), $anchor = '') {
		$this->page = $page;
		$this->params = $params;
		$this->anchor = $anchor;
	}

	public function addParam($name, $value) {
		$this->params[$name] = $value;
	}

	public function get() {
		return self::parse($this->page, $this->params, $this->anchor);
	}
	public function getBase() {
		return self::parse($this->page);
	}
	public static function getRules() {
		return self::$rewriting;
	}

	public static function parse($page, $params = array(), $anchor = '', $cdn = false) {
		global $config;
		$project = '';
		$page = self::rewriting($project.$page);
		$parts = explode('?', $page);
		if (isset($parts[1]) && !empty($parts[1])) {
			$query = explode('&', $parts[1]);
			foreach ($query as $v) {
				if (!empty($v)) {
					$v = explode('=', $v);
					if (isset($v[0]) && isset($v[1])) {
						$params[$v[0]] = $v[1];
					}
				}
			}
		}
		// check if a CDN is defined
		if ( !empty($config['cdn_url']) && $cdn == true && !canAccess('settings') ){
			$ret = $config['cdn_url'].$parts[0];
		}
		else{
			$ret = $config['url'].$parts[0];
		}
		if (!empty($params)) {
			$ret .= '?'.http_build_query($params);
		}
		if (!empty($anchor)) { $ret .= '#'.$anchor; }
		return $ret;
	}

	protected static function rewriting($page) {
		global $config;
		if ($config['url_rewriting']) { return $page; }
		foreach (self::$rewriting as $v) {
			$rule = '#'.$v['rule'].'#';
			if (preg_match($rule, $page)) {
				if (isset($v['condition'])
					&& $v['condition'] == 'file_doesnt_exist'
				) {
					if (!file_exists($page)) {
						return preg_replace($rule, $v['redirect'], $page);
					}
				}
				else {
					return preg_replace($rule, $v['redirect'], $page);
				}
			}
		}
		return $page;
	}

}

?>