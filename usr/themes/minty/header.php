<?php 

/* Options:
  header: [rss, weibo, mail];
  headerweibo: URL
  headermail: URL
*/

if(!defined('__TYPECHO_ROOT_DIR__')) exit('Access Denied'); 

global $isTypechoEX;

$othercon = "";
$isweibo = false;
if(@in_array("rss", $this->options->header))
{
	$othercon .= "<a target=\"_blank\" href=\"".$this->options->feedUrl."\" class=\"rss\" title=\"RSS\"><span>RSS</span></a>";
}
if(@in_array("weibo", $this->options->header)) 
{
	$isweibo = true;
	$othercon .= "<a target=\"_blank\" href=\"".$this->options->weibo."\" class=\"weibo\" title=\"微博\"><span>微博</span></a>";
}
if(@in_array("mail", $this->options->header))
{
	$othercon .= "<a target=\"_blank\" href=\"".$this->options->mail."\" class=\"mail\" title=\"邮件订阅\"><span>邮件订阅</span></a>";
}

?><!DOCTYPE html>
<!--[if lt IE 7]><html lang="zh-CN" class="lt-ie9 lt-ie8 lt-ie7 ie6"><![endif]-->
<!--[if IE 7]><html lang="zh-CN" class="lt-ie9 lt-ie8 ie7"><![endif]-->
<!--[if IE 8]><html lang="zh-CN" class="lt-ie9 ie8"><![endif]-->
<!--[if gt IE 8]><!--><html lang="zh-CN"><!--<![endif]-->
<head>
<meta charset="UTF-8" />
<title><?php if($this->is('index')) { $this->options->title(); echo ' | '; $this->options->description(); } else { $this->archiveTitle(array('category' => _t('分类: %s'), 'search' => _t('搜索: %s'), 'tag' => _t('标签: %s'), 'author'    =>  _t('作者: %s'), 'year' => _t('%s 年'), 'month' => _t('%s 月')), '', ''); echo ' | '; $this->options->title(); } ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
<link rel="stylesheet" href="<?php $this->options->themeUrl('style.min.css'); ?>" />
<!--[if lt IE 9]><script src="<?php $this->options->themeUrl('js/html5.js'); ?>"></script><![endif]-->
<?php $this->header("generator=&template=&commentReply=".($isTypechoEX ? "&antiSpam=" : "")); ?>
</head>
<body<?php if($this->is('single')): ?> class="single"<?php elseif($this->is('index')): ?> class="home"<?php endif; ?>>
<header id="header" role="banner">
	<a id="hgroup" href="<?php $this->options->siteUrl(); ?>" rel="home">
		<h1 id="logo"><?php $this->options->title(); ?></h1>
		<i class="slogan" title="返回首页"><?php if(empty($this->options->headertext)) { $this->options->description(); } else { $this->options->headertext(); } ?></i>
	</a>
	<div class="userinfo"><?php $Logined = $this->user->hasLogin(); if($Logined): ?>
	  <img src="<?php echo getAvatar(32, $this->user->mail); ?>" height="32" width="32" /><span class="username"><?php if($this->user->pass("contributor", true)) { echo '<a target="_blank" title="进入后台" href="'.Typecho_Common::url('index.php', $this->options->adminUrl).'">'.$this->user->screenName.'</a>'; } else echo $this->user->screenName; ?></span><?php else: ?>
	  <a href="<?php $loginUrl = Typecho_Common::url('login.php?referer=http:////' . Typecho_Common::url($_SERVER['REQUEST_URI'], $_SERVER['HTTP_HOST']), $this->options->adminUrl); echo $loginUrl; ?>" class="login-link"><img src="<?php $this->options->themeUrl('img/default-avatar.png'); ?>" height="32" width="32" /></a><span class="login-link"><a href="<?php echo $loginUrl; ?>">登录</a></span><?php endif; ?>
  </div>
  <div class="connect">
  	<?php echo $othercon; ?>
    <form role="search" method="get" id="searchform" action="<?php $this->options->siteUrl(); ?>">
    	<input type="search" placeholder="搜索&hellip;" value="" name="s" id="s" title="搜索" required x-moz-errormessage="请输入搜索关键字" />
	    <input type="submit" id="searchsubmit" value="搜索" />
    </form>
  </div>
  <nav id="nav" role="navigation"><ul id="menu-nav" class="nav-menu"><?php

  $count = 0;
  $widths = @explode(',', $this->options->respmenu);
  $default = empty($widths) ? "auto" : $widths[count($widths)-1];
  
  $menu = '<li class="menu-item-responsive-'.(isset($widths[$count]) ? $widths[$count] : $default).'"><a href="'.Typecho_Common::url("random", $this->options->index).'">随览</a></li>';
	$count++;

	$menu .= '<li class="menu-item-has-children menu-vertical menu-item-responsive-'.(isset($widths[$count]) ? $widths[$count] : $default).'"><a>分类</a><ul class="sub-menu">';
	$count++;
	
	$category = $this->widget('Widget_Metas_Category_List')->stack;
	foreach($category as $cat)
	{
		$class = '';
		if($this->is('category', $cat['slug']) || ($this->is('post') && $this->category == $cat['slug'])) $class = ' class="current-menu-item"';
		$menu .= '<li'.$class.'><a href="'.$cat['permalink'].'">'.$cat['name'].'</a></li>';
	}
	$menu .= '</ul></li>';
  
  $pages = $this->widget('Widget_Contents_Page_List')->stack; 
  foreach($pages as $page)
  {
    $menu .= '<li class="menu-item-responsive-'.(isset($widths[$count]) ? $widths[$count] : $default);
    $count++;
    
    if($this->is('page', $page['slug'])) $menu .= ' current-menu-item';
    $menu .= '"><a href="'.$page['permalink'].'">'.$page['title'].'</a></li>';
  }
  
  echo '<li class="menu-item-responsive-'.(isset($widths[$count]) ? $widths[$count] : $default).' menu-item-home'.($this->is('index') ? ' current-menu-item' : '').'"><a href="'.$this->options->siteUrl.'">首页</a></li>';
  echo $menu;

?></ul></nav>
  <div id="m-btns">
  	<?php if($isweibo): ?><a class="weibo" title="微博" target="_blank" href="<?php $this->options->headerweibo(); ?>"></a><?php endif; ?>
  	<span class="search" title="搜索"></span>
  	<div class="menu" title="菜单">
      <select id="m-menu" onChange="location.href=this.value">
      	<option disabled selected>导航菜单</option>
        <option value="<?php $this->options->siteUrl(); ?>">首页</option>
        <option value="<?php $this->options->index("random"); ?>">随览</option>
        <optgroup label="分类">
        <?php foreach($category as $cat){ ?>
        <option value="<?php echo $cat['permalink']; ?>"><?php echo $cat['name']; ?></option>
        <?php } ?>
        </optgroup>
        <?php foreach($pages as $page){ ?>
        <option value="<?php echo $page['permalink']; ?>"><?php echo $page['title']; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
</header><!--[if lt IE 8]><div id="browsehappy">你正在使用的浏览器版本过低，请<a href="http://browsehappy.com" target="_blank" rel="external nofollow"><strong>升级你的浏览器</strong></a>，获得最佳的浏览体验！</div><![endif]-->