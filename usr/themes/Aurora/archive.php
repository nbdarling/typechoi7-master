<?php $this->need('header.php'); ?>
<!-- #masthead -->
	<div id="main" class="site-main">
		<a href="#menu" id="menuLink" class="menu-link">
    		<span></span>
		</a>
	
<div id="main-content" class="main-content">
	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<div class="search_link">
				<a href="<?php $this->options->siteUrl(); ?>">首页</a>
				<em>|</em>
				<span>搜索</span>
			</div>
							<div class="search_result_tt">为您找到的<span class="comm_a_color">“<?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
			), '', ''); ?>”</span>的搜索结果</div>
		<!-- <div class="navigation">
			<div class="alignleft"></div>
			<div class="alignright"></div>
		</div> -->
         <?php while($this->next()): ?>	
		<div id="post">
				<!-- <h3 id="post-2602">
				
				</h3>
 -->
	
	
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
				<!-- <a class="share_to_layer" href="#"><i>分享</i> 分享</a> -->
				
				
			</span>
			<a class="entry-readmore" href="<?php $this->permalink() ?>">阅读全文 <i class="itrangle2"></i></a></div>
	</div><!-- .entry-summary -->
	
	<!--  -->
</article><!-- #post-## -->
            <?php endwhile; ?>
<nav>
		<?php $this->pageNav('<< 上一页', '下一页 >>'); ?>
	</nav><!-- .navigation -->
	
		</div><!-- #content -->
	</div><!-- #primary -->
	<!--  -->
</div><!-- #main-content -->
        <?php $this->need('sidebar.php'); ?>
        <?php $this->need('footer.php'); ?>
