<?php

/**
 * 倚窗听雨的第一个typecho模版
 * 0.2版更新记录 2015.10.01
 * 1.修复首页作者头像手机端显示错位。
 * 2.修复文章页作者头像显示与代码>溢出。
 * 3.主题源代码规整。
 * 4.主题BUG反馈请前往：http://www.htmwind.com/aurora-theme.html
 *
 * @package Aurora Theme
 * @author 倚窗听雨
 * @version 0.2 Beta
 * @link http://www.htmwind.com
 */

$this->need('header.php');
?>
<!-- #masthead -->
	<div id="main" class="site-main">
		<a href="#menu" id="menuLink" class="menu-link">
    		<span></span>
		</a>

<div id="main-content" class="main-content">
<!-- The template for displaying index -->

	<div id="primary" class="content-area">
			
		
		<div id="content" class="site-content" role="main">

		 <?php while($this->next()): ?>		
<article>
	

	<header class="entry-header">
				<!-- <div class="entry-meta">
			
		</div> -->
		<!-- .entry-meta -->
		<span class="author-image">
			<?php $this->author->gravatar('42') ?></span>
		<div class="article_title_infos">	
			<h1 class="entry-title"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h1>
			<div class="entry-meta">

				<span class="post-format">

						<?php $this->category(','); ?>			</span>


				<span class="byline"><span class="author vcard"><a href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a></span></span> <span class="entry-date"><?php $this->date('Y, F j'); ?></span 				
				</div>

		</div>
	</header><!-- .entry-header -->

		<div class="entry-summary">
		<?php $this->content(''); ?>
		<div class="entry_tools">
			<span class="entry_p_datas">
				<a class="read_p_num" href="#"><i>阅读</i> <span id="wppvp_tv_2602"><?php Views_Plugin::theViews(); ?></span></a> 
				<span class="comment_p_num">
					<a href="<?php $this->permalink() ?>#comments"><i>评论</i> <?php $this->commentsNum('%d评论'); ?></a></span>								
			</span>
			<a class="entry-readmore" href="<?php $this->permalink() ?>">阅读全文 <i class="itrangle2"></i></a></div>
	</div><!-- .entry-summary -->
</article><!-- #post-## -->
            <?php endwhile; ?>
<nav>
		<?php $this->pageNav('<< 上一页', '下一页 >>'); ?>
	</nav><!-- .分页导航 -->
	
		</div><!-- #content -->
	</div><!-- #primary -->
	<!--  -->
</div><!-- #main-content -->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>