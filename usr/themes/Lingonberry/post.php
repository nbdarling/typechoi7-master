<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>


<div class="content section-inner">
                                                    
        
        <div class="posts">
    
            <div class="post type-post status-publish">

                

<div class="content-inner">

<div class="post-header">
<h2 class="post-title"><a href="<?php $this->permalink() ?>" rel="bookmark" title="To Infinity and Beyond: About Pixar"><?php $this->title() ?></a></h2>
<div class="post-meta">
<span class="post-date"><a href="<?php $this->permalink() ?>" title="<?php $this->date('F j, Y'); ?>"><?php $this->date('F j, Y'); ?></a></span>
<span class="date-sep"> / </span>
<span class="post-author"><a href="<?php $this->author->permalink(); ?>" title="Posts by <?php $this->author(); ?>" rel="author"><?php $this->author(); ?></a></span>
<span class="date-sep"> / </span>
<a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('Comments', '1 Comment', '%d Comments'); ?></a> 
</div> <!-- /post-meta -->
</div> <!-- /post-header -->
<div class="post-content">
<?php $this->content(); ?>
</div> <!-- /post-content -->
<div class="clear"></div>
<div class="post-cat-tags">
<p class="post-categories">分类：<?php $this->category(' , '); ?></p>
<p class="post-tags">标签：<?php $this->tags(' , ', true, '无'); ?></p>
</div>
</div> <!-- /post content-inner -->
<div class="clear"></div>                           
<div class="post-nav">
<?php thePrev($this); ?>
<?php theNext($this); ?>
<div class="clear"></div>
</div> <!-- /post-nav -->
<div id="respond" class="comment-respond">
<!-- 第三方评论代码 -->
</div><!-- #respond -->
</div> <!-- /post -->
</div> <!-- /posts -->
</div>


<?php $this->need('footer.php'); ?>
