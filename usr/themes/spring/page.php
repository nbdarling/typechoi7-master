<?php $this->need('header.php'); ?> 
        <section class="content"> 
            <article id="post-<?php $this->cid() ?>" class="clear"> 
                <h2 class="entry-title"><a href="<?php $this->permalink() ?>" title="Permanent Link to <?php $this->title() ?>"  rel="bookmark"><?php $this->title() ?></a></h2>
                <section class="entry-page">
                    <?php $this->content(''); ?>

                </section> 
            </article> 
        </section>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>