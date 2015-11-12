<?php $this->need('header.php'); ?>
        <section class="content"> 
            <article id="post-<?php $this->cid() ?>" class="clear"> 
                <h2 class="entry-title"><a href="<?php $this->permalink() ?>" title="Permanent Link to <?php $this->title() ?>"  rel="bookmark"><?php $this->title() ?></a></h2>
                <section class="entry-meta">
                    <?php $this->author(); ?> <?php _e('BY'); ?> <?php $this->date('Y-m-d'); ?> | <?php _e('分类'); ?> <?php $this->category(); ?><span class="postcom"><?php $this->views(); ?> <?php _e('人看过'); ?> | <a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('%d 个评论'); ?></a></span>
                </section>
                <section class="entry-post">
                    <?php $this->content('阅读全文'); ?>

                </section> 
                <section class="entry-meta">
                    <?php _e('标签'); ?>: <?php $this->tags(', ', true, 'none'); ?><span class="share">分享收藏：<script type="text/javascript" src="<?php $this->options->themeUrl('js/share.js'); ?>?v=101017"></script></span>
                </section>
            </article>
            <article> 
                <?php $this->need('comments.php'); ?>
            </article> 
        </section>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>