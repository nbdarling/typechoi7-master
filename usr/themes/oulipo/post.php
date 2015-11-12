<?php include('header.php'); ?>

<DIV id=content>
<DIV id=entry_content>
<DIV class="post hentry category-article">
<H2><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></H2>
<P class=date><?php $this->date('Y年m月d日'); ?> <a href="<?php $this->permalink() ?>#comments">§ <SPAN 
class=commentcount><?php $this->commentsNum('0', '1', '%d'); ?></SPAN></a></P>
<DIV class=entry><?php $this->content('阅读全文...'); ?><p class="tags"><?php $this->tags(', ', true, 'none'); ?></p></DIV>
</DIV>
<!-- close post_class -->
<?php include('comments.php'); ?>
</DIV><!-- close entry_content -->
<div id="supplementary">
		<div class="meta">
		
					<div class="post_nav">
				<h3>What's this?</h3>
				<p>You are currently reading <strong><?php $this->title() ?></strong> at
				<a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a>.</p>
			
				<h3>meta</h3>
                <ul class="single_post_meta">
                	<li><strong>Author:</strong> <?php $this->author(); ?></li>
					<li><strong>Comments: </strong> <?php $this->commentsNum('No Comment', '1 Comment', '%d Comments'); ?></li> 
					<li><strong>Categories:</strong> <?php $this->category(','); ?></li>
				</ul>
				<p class="edit"></p>
			</div>
				
					
	
	</div> <!-- close meta -->
	</div>
<!-- close supplementary --></DIV>
<?php include('footer.php'); ?>


