<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if($this->_currentPage>1) echo '第'.$this->_currentPage.'页 | '; ?><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' | '); ?><?php $this->options->title(); ?></title>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('style.css'); ?>">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">    <?php if ($this->is('post')): ?>
    <link rel="canonical" href="<?php $this->permalink() ?>" />
    <?php endif; ?>
    <?php if ($this->is('index')): ?>
    <link rel="canonical" href="<?php $this->options->siteUrl(); ?>" />
    <?php endif; ?>
    <?php $this->header("generator=&template="); ?>
  </head>
<body>
		<div class="container">
			<header class="clearfix">
<a href="<?php $this->options->siteUrl(); ?>" title="<?php $this->options->title(); ?>">
				<span><?php $this->options->description(); ?></span>
				<h1><?php $this->options->title(); ?></h1></a>
				<nav class="menu">
				    <a href="/index.php/msg.html" class="tmicon fa-comments" data-info="留言">留言板</a>
					<a href="/index.php/about.html" class="fa-user" data-info="关于">关于梦想岛的个人网站</a>
					<a href="index.php/search/梦想岛/" class="tmicon fa-search" data-info="搜索">搜索梦想岛</a>
					<a href="/index.php/links.html" class="tmicon fa-send" data-info="友情链接">友情链接</a>
				</nav>
			</header>