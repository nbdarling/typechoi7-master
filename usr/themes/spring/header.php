<!DOCTYPE html> 
<html lang="zh-cn" dir="ltr"> 
<head> 
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
<title><?php $this->archiveTitle(' &raquo; ', '', ' - '); ?><?php $this->options->title(); ?></title> 
<meta name="google-site-verification" content="uj9sUa7xs_hyD2-RE3JzgQYrbYDhT2z4c1_yyq5i7Ns" />
<meta name="baidu_union_verify" content="d20d0bf7ce831c724ae62ef0fac29b68">
<?php $this->header(); ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php $this->options->themeUrl('css/style.css'); ?>?v=101017" />
<!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="<?php $this->options->themeUrl('css/ie.css'); ?>" />
<![endif]-->
<link rel="shortcut icon" href="<?php $this->options->siteUrl(); ?>favicon.ico" />
</head> 
<body> 
<div id="wrapper">
    <header class="clearfix">
        <div id="logo"> 
            <h1><a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a></h1> 
            <p class="description"><?php $this->options->description() ?></p> 
        </div> 
        <nav> 
            <ul> 
                <li<?php if($this->is('index')): ?> class="current"<?php endif; ?>><a href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a></li>
<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
<?php while($pages->next()): ?>
                <li<?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?>><a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a></li>
<?php endwhile; ?>
            </ul>
        </nav> 
    </header><!-- end #header --> 
    <div id="container" class="clearfix">
