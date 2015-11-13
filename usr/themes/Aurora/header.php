<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" lang="zh-CN">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="zh-CN">
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html lang="zh-CN"><!--<![endif]--><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<meta property="qc:admins" content="45261612477615617363757">
	<title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
		<?php if ($this->options->siteIcon): ?>
        <link rel="Shortcut Icon" href="<?php $this->options->siteIcon() ?>" />
        <link rel="Bootmark" href="<?php $this->options->siteIcon() ?>" />
        <?php endif; ?>
        <?php $this->header(); ?>
	<!--[if lt IE 9]>
	<script src="<?php $this->options->themeUrl(); ?>js/html5.js"></script>
	<![endif]-->
<link rel="stylesheet" id="genericons-css" href="<?php $this->options->themeUrl(); ?>css/genericons.css" type="text/css" media="all">
<link rel="stylesheet" id="twentyfourteen-style-css" href="<?php $this->options->themeUrl(); ?>css/style.css" type="text/css" media="all">
<!--[if lt IE 9]>
<link rel='stylesheet' id='twentyfourteen-ie-css'  href='<?php $this->options->themeUrl(); ?>/css/ie.css?ver=20131205' type='text/css' media='all' />
<![endif]-->
<script type="text/javascript" src="<?php $this->options->themeUrl(); ?>/js/jquery_002.js"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl(); ?>/js/jquery-migrate.js"></script>
<meta name="generator" content="<?php $this->options->generator(); ?>">
	<!--this code is used to support HTML5 in IE8-->
<!--[if IE]><script type="text/javascript">(function(){if(!/*@cc_on!@*/0)return;var e = "abbr,article,aside,audio,bb,canvas,datagrid,datalist,details,dialog,eventsource,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,time,video".split(',');for(var i=0;i<e.length;i++){document.createElement(e[i])}})()</script><![endif]-->
<!--[if lt IE 9]>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->


<body class="home blog custom-background group-blog list-view full-width footer-widgets grid">
<div id="page" class="hfeed site">
	
	<header style="" id="masthead" class="site-header" role="banner">
		<div class="header-main">
			<h1 class="site-title"><a href="<?php $this->options->siteUrl(); ?>" rel="home"><?php $this->options->title(); ?></a></h1>

			<div class="search-toggle">
				<a href="#search-container" class="screen-reader-text">搜索</a>
			</div>

			<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
				<h1 class="menu-toggle">主菜单</h1>
				<a class="screen-reader-text skip-link" href="#content">跳至内容</a>
				<div class="nav-menu"><ul><li class="page_item page-item-4"><a href="<?php $this->options->abouturl() ?>">关于我们</a></li><li class="page_item page-item-144"><a href="<?php $this->options->adminUrl(); ?>">管理</a></li></ul></div>
			</nav>
		</div>

		<div id="search-container" class="search-box-wrapper hide">
			<div class="search-box">
				<form role="search" method="get" class="search-form" action="<?php $this->options->siteUrl(); ?>">
				<label>
					<span class="screen-reader-text">搜索：</span>
					<input class="search-field" placeholder="搜索…" name="s" title="搜索：" type="search">
				</label>
				<input class="search-submit" value="搜索" type="submit">
			</form>			</div>
		</div>
	</header>