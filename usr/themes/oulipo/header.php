<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<meta http-equiv="content-type" content="text/html; charset=<?php $this->options->charset(); ?>" />
<title><?php $this->options->title(); ?><?php $this->archiveTitle(); ?></title>
<link rel="stylesheet" type="text/css" media="all" href="<?php $this->options->themeUrl('style.css'); ?>" />
	<!--[if lte IE 7]>
	<link href="<?php $this->options->themeUrl(); ?>ie.css" type="text/css" rel="stylesheet" media="screen" />
	<![endif]-->
	
	<!--[if lte IE 6]>
	<link href="<?php $this->options->themeUrl(); ?>ie6.css" type="text/css" rel="stylesheet" media="screen" />
	<![endif]-->
<?php $this->header(); ?>
</head>

<body>
<div id=wrapper>
<div id=search><span class=twitter><!-- if you want to integrate twitter, use http://rick.jinlabs.com/code/twitter/ and put the code snippet here.  --></span>
<form id=searchform action="" method=post>
<div><span class=search>search:</span><input id=s size=15 name=s> <input id=searchsubmit type=submit value=go></div></form></div>
<div id=main_nav>
<h1 class=masthead><a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a></h1>
<p class=description><?php $this->options->description() ?></p>
<ul>
  		<li class="page_item"><a href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a></li>
	    <?php $this->widget('Widget_Contents_Page_List')->parse('<li class="page_item"><a href="{permalink}">{title}</a></li>'); ?>

</ul>
</div>