<?php
/**
 * 这是 Martin 为 Typecho 转换的一套皮肤，转换自WP主题oulipo
 * 
 * @package oulipo Theme 
 * @author Martin
 * @version 1.0.0
 * @link http://sonics.co.tv
 */
 
 include('header.php');
 ?>

<DIV id=content>
<DIV id=entry_content>
<?php while($this->next()): ?>
<DIV class="post hentry category-article">
<H2><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></H2>
<P class=date><?php $this->date('Y年m月d日'); ?> <a href="<?php $this->permalink() ?>#comments">§ <SPAN 
class=commentcount><?php $this->commentsNum('0', '1', '%d'); ?></SPAN></a></P>
<DIV class=entry><?php $this->content('阅读全文...'); ?></DIV>
</DIV>
<?php endwhile; ?>
<!-- close post_class -->
<DIV class=navigation>
<ol class="pages">
<?php $this->pageNav(); ?>
</ol>
</DIV>
</DIV><!-- close entry_content -->
<?php include('sidebar.php'); ?>
<!-- close supplementary --></DIV>
<?php include('footer.php'); ?>
