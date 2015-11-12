<section id="comments">
<?php $this->comments()->to($comments); ?>
<?php if ($comments->have()): ?>
    <h4><?php $this->commentsNum(_t('当前暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?> &raquo;</h4>
        <?php $comments->listComments(); ?>
        <div class="comments-pages"><?php $comments->pageNav(); ?></div>
    <?php endif; ?>
    <?php if($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="respond">
    <div class="cancel-comment-reply"><?php $comments->cancelReply(); ?></div>
        <h4><?php _e('访客留言'); ?> &raquo;</h4>
            <form method="post" action="<?php $this->commentUrl() ?>" id="comment_form">
            <?php if($this->user->hasLogin()): ?>
                <p>Logged in as <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></p>
            <?php else: ?>
            <div id="author_info">
                <p>
                    <label for="author"><?php _e('昵称'); ?></label> <input type="text" name="author" id="author" class="text" size="15" value="<?php $this->remember('author'); ?>" />
				</p>
				<p>
                    <label for="mail"><?php _e('邮箱'); ?><?php if ($this->options->commentsRequireMail): ?><?php endif; ?></label> <input type="text" name="mail" id="mail" class="text" size="15" value="<?php $this->remember('mail'); ?>" />
				</p>
				<p>
                    <label for="url"><?php _e('网站'); ?><?php if ($this->options->commentsRequireURL): ?><?php endif; ?></label> <input type="text" name="url" id="url" class="text" size="15" value="<?php $this->remember('url'); ?>" />
				</p>
                </div>
            <?php endif; ?>
                <p><textarea rows="5" cols="50" name="text" id="comment" class="textarea"><?php $this->remember('text'); ?></textarea></p>
				<p><input type="submit" value="<?php _e('提交评论'); ?>" id="submit" /></p>
            </form>
    </div>
    <?php else: ?>
        <h4><?php _e('评论已关闭'); ?></h4>
    <?php endif; ?>
</section> 