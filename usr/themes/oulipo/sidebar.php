<div id="supplementary">
  <div class="meta">
    <ul>
      <li class="widget widget_recent_entries">
        <h2 class="widgettitle">最新文章</h2>
        <ul>
                <?php $this->widget('Widget_Contents_Post_Recent')
                ->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
        </ul>
      </li>
      <li class="widget widget_recent_comments">
        <h2 class="widgettitle">最新评论</h2>
        <ul id="recentcomments">
            <?php $this->widget('Widget_Comments_Recent')->to($comments); ?>
            <?php while($comments->next()): ?>
                <li class="recentcomments"><a href="<?php $comments->permalink(); ?>"><?php $comments->author(false); ?></a>: <?php $comments->excerpt(50, '...'); ?></li>
            <?php endwhile; ?>
        </ul>
      </li>
      <li class="widget widget_archive">
        <h2 class="widgettitle">归档</h2>
            <ul>
                <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=F Y')
                ->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
            </ul>

      </li>
      <li class="widget widget_meta">
        <h2 class="widgettitle">登陆</h2>
            <ul>
                <?php if($this->user->hasLogin()): ?>
					<li class="last"><a href="<?php $this->options->adminUrl(); ?>"><?php _e('进入后台'); ?> (<?php $this->user->screenName(); ?>)</a></li>
                    <li><a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a></li>
                <?php else: ?>
                    <li class="last"><a href="<?php $this->options->adminUrl('login.php'); ?>"><?php _e('登录'); ?></a></li>
                <?php endif; ?>
                <li><a href="http://validator.w3.org/check/referer">Valid XHTML</a></li>
                <li><a href="http://www.typecho.org">Typecho</a></li>
            </ul>
      </li>
    </ul>
  </div>
  <!-- close meta -->
</div>
