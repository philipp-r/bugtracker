<?php

// get keys from projects array
$projectList = array_keys($config['projects']);

$content = '<h1>'.Trad::T_BROWSE_ALL_ISSUES.'</h1>';
$content .= '<p>'.Trad::T_ALL_ISSUES_DESCRIPTION.'</p>';

$title = Trad::T_BROWSE_ALL_ISSUES;


foreach( $projectList as $projectItem ){
	
	// set project
	$_GET['project'] = $projectItem;
	
	$issues = Issues::getInstance();
		
	$a = $issues->getAll();
	
	$error404 = false;
	$url = new Url(getProject().'/issues');
	
	// subtitle for each project with link
	$content .= '<h2><a href="'.$url->get().'">'.$projectItem.'</a></h2>';
	
	$open = 'open';
	OrderFilter::$filter = array(true);
	$a = array_filter($a, array('OrderFilter', 'filter_open'));
	
	$sort = array(0 => 'id', 1 => 'desc');
	uasort($a, array('OrderFilter', 'order_'.implode('_', $sort)));
	
	$pager = new Pager();
	$html = $pager->get(
		$a,
		$url,
		array($issues, 'html_list'),
		false // display "more" link instead of pagination, see Pager.class line 8
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

// reset project, so we dont have it in title or navigation
$_GET['project'] = "";
