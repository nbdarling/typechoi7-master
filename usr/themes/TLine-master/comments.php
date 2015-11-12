<li class="line">
<div class="tmicon fa-comments"></div>
<div class="box">
<div id="comments">
            <?php $this->comments()->to($comments); ?>
            <?php if ($comments->have()): ?>
            <h4 id="comments"><?php $this->commentsNum(_t('快抢沙发'), _t('沙发被抢'), _t('已有 %d 条评论')); ?></h4>   

            <?php $comments->listComments(); ?>

            <?php $comments->pageNav(); ?>

            <?php endif; ?>
         
            <?php if($this->allow('comment')): ?>

            <div id="<?php $this->respondId(); ?>" class="respond">
            
            <div class="cancel-comment-reply">
            <?php $comments->cancelReply(); ?>
            </div>
            <h4><?php _e('添加新评论'); ?> &raquo;</h4>
            <form method="post" action="<?php $this->commentUrl() ?>" id="comment_form" class="form">
                <?php if($this->user->hasLogin()): ?>
                <p>登录为 <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></p>
                <?php else: ?>
                  <input type="text" name="author" id="author" placeholder="昵称 *" value="<?php $this->remember('author'); ?>" />
                  <input type="text" name="mail" id="mail" placeholder="邮箱 *" value="<?php $this->remember('mail'); ?>" />
                  <input type="text" name="url" id="url" placeholder="网址"  value="<?php $this->remember('url'); ?>" />
                <?php endif; ?>
                <p><textarea rows="5" name="text" id="comment" placeholder="在这里输入你的评论..." style="resize:none;"><?php $this->remember('text'); ?></textarea></p>
            <p><input type="submit" value="<?php _e('提交评论'); ?>" class="button" id="submit"></p>
            </form>
            </div>
</div>
            <?php else: ?>
                        <div class="tmlabel no-margin">
        <h4 class="text-center">
            该文章的评论已关闭
        </h4>
</div>
            <?php endif; ?>
</div>
</li>