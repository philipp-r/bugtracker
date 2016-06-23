<?php

// get keys from projects array
$projectList = array_keys($config['projects']);

$content = '<h1>'.Trad::T_BROWSE_ISSUES.'</h1>';

$title = Trad::T_BROWSE_ISSUES." ALL ISSUES";


foreach( $projectList as $projectItem ){

	$_GET['project'] = $projectItem;
	
	$issues = Issues::getInstance();
		
	$a = $issues->getAll();
	
	$error404 = false;
	$url = new Url(getProject().'/all_issues');
	
	$open = 'open';
	OrderFilter::$filter = array(true);
	$a = array_filter($a, array('OrderFilter', 'filter_open'));
	
	$sort = array(0 => 'id', 1 => 'desc');
	uasort($a, array('OrderFilter', 'order_'.implode('_', $sort)));
	
	$perpage = $config['issues_per_page'];
	if (isset($_GET['perpage'])) {
		$perpage = intval($_GET['perpage']);
		if ($perpage <= 1) { $perpage = $config['issues_per_page']; }
		$url->addParam('perpage', $perpage);
	}
	
	$pager = new Pager();
	$html = $pager->get(
		$a,
		$url,
		array($issues, 'html_list'),
		$perpage
	);
	$nb = count($a);
	
	if ($nb == 0) {
		$html = '<p>&nbsp;</p><p>'.Trad::S_NO_ISSUE.'</p><p>&nbsp;</p>';
	}
	
	if (!canAccess('new_issue')
		&& !$config['loggedin']
		&& canAccess('signup')
		&& in_array(DEFAULT_GROUP, $config['permissions']['post_comment'])
	) {
		$content .= '<p>'.Trad::A_PLEASE_LOGIN_ISSUE.'</p><p>&nbsp;</p>';
	}
	
	$content .= '
		<div class="div-table-issues">
			<div class="div-issues">'.$html.'</div>';
	
	$content .= '</div>';

}