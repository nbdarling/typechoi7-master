<?php

if(!defined('__TYPECHO_ROOT_DIR__')) exit('Access Denied');

global $isTypechoEX, $smilies_from, $smilies_to;

function threadedComments($comments, $singleCommentOptions) { 

global $smilies_from, $smilies_to;

?><li class="comment depth-<?php echo $comments->levels+1; if($comments->authorId == $comments->ownerId) echo " bypostauthor"; ?>" id="<?php $comments->theId(); ?>">
	<div id="div-<?php $comments->theId(); ?>" class="comment-body">
		<div class="comment-author vcard"><?php if($comments->levels == 0): ?>
			<img alt="" src="<?php echo getAvatar(50, $comments->mail); ?>" class="avatar" height="50" width="50" /><?php else: ?>
      <img alt="" src="<?php echo getAvatar(30, $comments->mail); ?>" class="avatar" height="30" width="30" /><?php endif; ?>
      <cite class="fn"><?php echo empty($comments->url) ? htmlspecialchars($comments->author) : "<a href=\"" . $comments->url . "\" rel=\"external nofollow\" class=\"url\" target=\"_blank\">".htmlspecialchars($comments->author)."</a>"; ?></cite>
      <time><?php echo timesince($comments->created); ?></time>
    </div>
    <div class="comment-content"><?php
    	 $output = "";
    	 // HTML loop taken from texturize function, could possible be consolidated
       $textarr = preg_split("/(<.*>)/U", Typecho_Common::stripTags($comments->text, "<br><a href=\"\">"), -1, PREG_SPLIT_DELIM_CAPTURE); 
       $stop = count($textarr);
       for ($i = 0; $i < $stop; $i++) {
         $content = $textarr[$i];
         if ((strlen($content) > 0) && ('<' != $content{0})) { 
           $content = str_replace($smilies_from, $smilies_to, $content);
         }
         $output .= $content;
       }
       echo $output;
    ?></div>
    <footer class="comment-footer">
    	<?php $comments->reply("回复"); ?>
    	<a href="#" class="com-at" data-name="@<?php echo htmlspecialchars($comments->author); ?>" data-id="#<?php $comments->theId(); ?>">@TA</a>
    </footer>
  </div>
  <?php if ($comments->children) { ?><ol class="children"><?php $comments->threadedComments($singleCommentOptions); ?></ol><?php } ?>
</li><?php }

/******** begin ***********/

$isAjax = isset($_POST['isAjax']);

if($this->allow('comment')) {
	
$comments = $this->comments();

if(!$isAjax) {

$Logined = $this->user->hasLogin();

$mail = $Logined ? $this->user->mail : $this->remember("mail", true);

?><h3 id="comments-title"><?php $num = $this->commentsNum; if($num > 0) { echo number_format($num) . " 条评论"; } else { echo "发表评论"; } ?></h3>
<div id="<?php $this->respondId(); ?>" class="respond">
  <?php $comments->cancelReply("点击这里取消回复。"); ?>
  <form action="<?php $this->commentUrl() ?>" method="post" id="commentform"<?php echo $isTypechoEX ? " data-key=\"".getAntispamCode()."\"" : ""; ?>>
    <img src="<?php if($mail) { echo getAvatar(50, $mail); } else { $this->options->themeUrl('img/default-avatar.png'); } ?>" class="avatar" height="50" width="50" />
    <div id="comment-settings"<?php if($Logined) echo " class=\"logined\""; ?>><?php if(!$Logined): ?>
	    <div class="comment-fields">
	      <div class="comment-form-author"><label for="author">昵称</label><input id="author" name="author" type="text" value="<?php $this->remember("author"); ?>" size="30" required="" title="必填项" /></div>
	      <div class="comment-form-email"><label for="email">邮箱</label><input id="email" name="mail" type="email" value="<?php $this->remember("mail"); ?>" size="30" required="" title="必填项" /></div>
	      <div class="comment-form-url"><label for="url">网站</label><input id="url" name="url" type="text" value="<?php $this->remember("url"); ?>" size="30" /></div>
	    </div><?php else: ?>欢迎回来，<?php echo $this->user->screenName; ?>，<a href="<?php $this->options->logoutUrl(); ?>">点此退出 &raquo;</a><?php endif; ?>
    </div>
    <p class="comment-form-comment"><label for="comment">我也说一句</label><textarea id="comment" name="text" cols="45" rows="8" onfocus="this.previousSibling.style.display='none'" onblur="this.previousSibling.style.display=this.value==''?'block':'none'" required=""></textarea></p>
    <footer class="comment-form-footer">
	    <div class="comment-smilies"></div>
	    <input name="submit" type="submit" id="submit" value="发表评论" />
	    <div class="comment-settings-toggle<?php if(!$mail) echo " required"; ?>"><span class="name"><?php if($Logined) { echo $this->user->screenName; } else { $author = $this->remember("author", true); if($author) echo $author; else echo "昵称"; } ?></span><i class="arrow">▼</i></div>
    </footer>
  </form>
</div>
<?php }

if($comments->have())
{
$smilies_url = Typecho_Common::url("img/smilies/", $this->options->themeUrl);
$smilies_from = array(
	":?:",
	":razz:",
	":sad:",
	":evil:",
	":!:",
	":smile:",
	":oops:",
	":grin:",
	":eek:",
	":shock:",
	":???:",
	":cool:",
	":lol:",
	":mad:",
	":twisted:",
	":roll:",
	":wink:",
	":idea:",
	":arrow:",
	":neutral:",
	":cry:",
	":mrgreen:",
	"8-)",
	"8-O",
	":-(",
	":-)",
	":-?",
	":-D",
	":-P",
	":-o",
	":-x",
	":-|",
	";-)",
	"8)",
	"8O",
	":(",
	":)",
	":?",
	":D",
	":P",
	":o",
	":x",
	":|",
	";)",
	":zZ",
);

$smilies_to = array(
	"<img src=\"".$smilies_url."icon_question.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_razz.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_sad.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_evil.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_exclaim.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_smile.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_redface.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_biggrin.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_surprised.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_eek.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_confused.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_cool.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_lol.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_mad.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_twisted.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_rolleyes.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_wink.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_idea.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_arrow.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_neutral.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_cry.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_mrgreen.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_cool.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_eek.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_sad.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_smile.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_confused.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_biggrin.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_razz.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_surprised.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_mad.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_neutral.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_wink.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_cool.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_eek.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_sad.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_smile.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_confused.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_biggrin.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_razz.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_surprised.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_mad.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_neutral.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_wink.png\" class=\"smiley\" />",
	"<img src=\"".$smilies_url."icon_sleep.png\" class=\"smiley\" />",
);

   ?><ol class="commentlist"><?php $comments->listComments(array('before' => '', 'after' => '')); ?></ol><?php Comments_Pager($comments); if($isAjax) exit();
}
else echo "<p class=\"no-comments\">沙发空缺中，还不快抢～</p>";

} else { ?><p id="comments-title" class="nocomments">评论已关闭</p><?php } ?>