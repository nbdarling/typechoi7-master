<?php $this->need('header.php'); ?>

<!-- #masthead -->
	<div id="main" class="site-main">
		<a href="#menu" id="menuLink" class="menu-link">
    		<span></span>
		</a>

<div id="main-content" class="main-content">
<!-- The template for displaying index -->

	<div id="primary" class="content-area">
			
		
		<div id="content" class="site-content" role="main">

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

						分类：<?php $this->category(','); ?>			</span>


				<span class="byline">作者：<span class="author vcard"><a href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a></span></span> <span class="entry-date">发布时间：<?php $this->date('F, j Y'); ?></span 				
				</div>

		</div>
	</header><!-- .entry-header -->

		<div class="entry-summary">
		<?php $this->content(''); ?>
	</div><!-- .entry-summary -->
	<p class="tags">标签：<?php $this->tags(' , ', true, ''); ?></p>
            <?php $this->need('comments.php'); ?>
	<!--  -->
</article><!-- #post-## -->
	
		</div><!-- #content -->
	</div><!-- #primary -->
	<!--  -->
</div><!-- #main-content -->

    <?php $this->need('sidebar.php'); ?>
    <?php $this->need('footer.php'); ?>
