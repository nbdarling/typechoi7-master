<?php
/**
 * 薄荷小清新主题Minty 1.1
 * 高级配置面板 响应式设计 HTML5
 *
 * @package Minty
 * @author MyTypecho
 * @link http://my-typecho.tk
 * @version 1.1.3
 */

/* 检查 */
if(!defined('__TYPECHO_ROOT_DIR__')) exit('Access Denied');

global $thumb, $isPost;

$isAjax = isset($_POST['isAjax']);

$isPost = $this->is('post');

$formats = array('aside', 'image', 'gallery', 'audio', 'video', 'status', 'quote', 'link', 'chat');

if(!$isAjax) {

$this->need('header.php');

?>
<div id="container" class="clearfix"><?php if($this->options->featured && $this->is('index') && $this->getCurrentPage() == 1): ?>
	<div id="featured-content" class="swipe"><ul class="swipe-wrap"><?php echo FeaturedSlider(); ?></ul><span class="swipe-arrow swipe-prev"></span><span class="swipe-arrow swipe-next"></span></div>
<?php endif; ?>
	<main id="main" role="main">
<?php if($this->is('archive')): ?>		<header class="page-header"><h1 class="page-title"><?php
			$this->archiveTitle(array('search' => '搜索结果：%s',
																'category' => '分类归档：%s',
																'tag' => '标签归档：%s',
																'date' => '日期归档：%s',
																'author' => '作者归档：%s'), '', '');
		?></h1></header><?php endif; ?><?php } elseif($isPost) { $this->need('comments.php'); exit; } /* AJAX Start */ ?><?php if($this->have()){ ?>
		<?php while($this->next()): $fields = MyTypechoTheme_Plugin::getField($this->cid); $thumb = NULL; if(isset($fields['type'])) { $type = $fields['type']; if(!in_array($type, $formats)) $type = NULL; } else $type = NULL; ?>
		<article id="post-<?php $this->cid(); ?>" class="ispost hentry<?php if($type) echo " format-".$type; if($isAjax) echo " fadein"; ?>">
			<?php
			  $usual = $type != "status" && $type != "quote";
			  if(empty($fields['nothumb']) && $usual)
			  {
				  $thumb = isset($fields['thumb']) ? $fields['thumb'] : MyTypechoTheme_Plugin::getThumb($this->cid);
				  if($thumb !== false)
				  {
				  	$thumb = scaleThumb($thumb, 700, 220);
				    echo $isPost ? '<div class="entry-cover">' : '<a class="entry-cover" href="'.$this->permalink.'">';
				    echo '<img width="700" height="220" src="'.$thumb.'" alt="'.$this->title.'" class="lazy" onerror="this.onerror=null;this.src=\''.Typecho_Common::url('img/blank.gif', $this->options->themeUrl).'\'" />';
				    echo $isPost ? '</div>' : '</a>';
				  }
			  }
			  if($type) echo "<i class=\"entry-icon\"></i>"; 
			  
			  if(!$usual):
			  	?><a href="<?php $this->permalink(); ?>"><div class="entry-content"><?php echo $isPost ? $this->content : $this->excerpt; ?></div></a>
			<footer class="entry-meta"><span class="time entry-date"><?php $this->dateWord(); ?></span> &bull; <a href="<?php $this->permalink(); ?>#comments" class="comments-link"  title="《<?php $this->title(); ?>》上的评论"><?php $this->commentsNum('0', '1', '%d'); ?> 条评论</a> &bull; <span class="entry-views"><?php echo number_format(MyTypechoTheme_Plugin::postViews($this->cid, $isPost)); ?>&nbsp;Views</span></footer><?php else:
			?><header class="entry-header">
				<?php if($isPost): ?><h1 class="entry-title"><?php $this->title(); ?></h1><?php else: ?><h2 class="entry-title"><a href="<?php $this->permalink(); ?>" rel="bookmark"><?php $this->title(); ?></a></h2><?php endif; if($type != "status"): ?>
				<div class="entry-meta"><span class="time entry-date"><?php $this->dateWord(); ?></span> &bull; <span class="categories-links"><?php if($this->categories) { $this->category('、'); } else { echo "未分类"; } ?></span> &bull; <a href="<?php $this->permalink(); ?>#comments" class="comments-link"  title="《<?php $this->title(); ?>》上的评论"><?php $this->commentsNum('0', '1', '%d'); ?> 条评论</a> &bull; <span class="entry-views"><?php echo number_format(MyTypechoTheme_Plugin::postViews($this->cid, $isPost)); ?>&nbsp;Views</span></div><?php endif; ?>
			</header><?php if($type != "gallery" && $type != "image"): ?>
			<div class="entry-<?php echo $isPost ? "content" : "summary"; ?>"><?php if($isPost) { echo $this->content; } else { $word_excerpt = $this->excerpt; echo $thumb ? "<p>".strip_tags($word_excerpt)."</p>" : $word_excerpt; } ?></div><?php if($usual): if($isPost): ?>
			<footer class="entry-footer">
			  <span class="tags-links"><?php $this->tags(''); ?></span>
			  <div class="copyright">本站文章除注明转载外，均为原创文章。转载请注明：文章转载自：<?php $this->options->title(); ?>（<a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->siteUrl(); ?></a>）</div><?php 
			  	/* Related */
		      $rel = $this->related(5);
		      if($rel->have()){
		        echo "<div class=\"post-related\"><div class=\"related-title\">您可能也喜欢</div><ul>";
		        while($rel->next()) echo "<li><a href=\"".$rel->permalink."\">".$rel->title."</a></li>";
		        echo "</ul></div>";
		      }
		  ?></footer>
		  <?php else: ?><footer class="entry-footer"><a href="<?php $this->permalink(); ?>" rel="nofollow" class="more-link">继续阅读 &raquo;</a><span class="tags-links"><?php $this->tags(''); ?></span></footer><?php endif; endif; endif; endif; ?>
		</article><?php endwhile; if($isPost): ?>
		<div id="explorer" class="clearfix">
			<div class="bdsharebuttonbox">
				<i>分享到：</i>
				<a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
				<a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
				<a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
				<a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a>
				<a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a>
				<a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
				<a href="#" class="bds_more" data-cmd="more"></a>
			</div><?php $nextPost = theNext($this); $prevPost = thePrev($this); ?>
			<nav id="postination"<?php if(!$prevPost || !$nextPost) echo " class=\"one\""; ?> role="navigation">
				<?php if($prevPost): ?><span class="previous-post"><a href="<?php echo $prevPost['permalink']; ?>" title="<?php echo $prevPost['title']; ?>" rel="prev"><span class="arrow">&lsaquo;</span> 上一篇</a></span><?php endif; ?>
				<?php if($prevPost && $nextPost): ?><span class="dot"> &bull; </span><?php endif; ?>
				<?php if($nextPost): ?><span class="next-post"><a href="<?php echo $nextPost['permalink']; ?>" title="<?php echo $nextPost['title']; ?>" rel="next">下一篇 <span class="arrow">&rsaquo;</span></a></span><?php endif; ?>
			</nav>
		</div>
		<div id="comments"><?php $this->need('comments.php'); ?></div><?php else: Index_Pager($this); endif; } else { ?><div class="hentry">
			<header class="entry-header">
				<h2 class="entry-title">未找到</h2>
			</header>
			<div class="entry-summary">
				<p><?php if($this->is('index')) { ?>抱歉，暂时没有文章，请过一段再来访问<?php } else { ?>抱歉，<?php $this->archiveTitle(array(
					'search' => '没有符合您搜索条件的结果。请换其它关键词再试',
					'category' => '没有符合您所选分类的结果。请换其它标签再试',
					'tag' => '没有符合您所选标签的结果。请换其它标签再试',
					'date' => '没有符合您所选日期的结果'), '', ''); } ?>。</p>
			</div>
		<?php } if($isAjax) exit(); /* AJAX End */ ?></main><?php $this->need('sidebar.php'); if($isPost): ?>
	<div class="breadcrumb"><a href="<?php $this->options->siteUrl(); ?>">首页</a><?php if($this->categories): echo ' &rsaquo; '; $this->category(' &rsaquo; '); endif; ?> &rsaquo; <span><?php $this->title(); ?></span></div><?php endif; ?>
</div>
<?php $this->need('footer.php'); ?>