<?php 

global $customFooter, $thumb, $isPost;

if(!defined('__TYPECHO_ROOT_DIR__')) exit('Access Denied'); 

?><footer id="footer" role="contentinfo">
	<nav class="links"><?php if(empty($this->options->links)): ?><a href="<?php $this->options->feedUrl(); ?>" target="_blank">文章 RSS</a> // <a href="<?php $this->options->commentsFeedUrl(); ?>" target="_blank">评论 RSS</a> // <a href="<?php $this->options->adminUrl('login.php'); ?>" target="_blank">后台登录</a><?php else: 
    $links = explode("\n", str_replace(array("\r"), "", $this->options->links));
    
    $linktext = "";
    foreach($links as $link) 
    {
    	$link = explode('|', $link);
    	if(count($link) != 2) continue;
      $linktext .= "<a href=\"".$link[1]."\" target=\"_blank\">".$link[0]."</a>";
    }
    echo $linktext;
  endif; ?></nav>
  <div class="copyright">Loading in <?php echo MyTypechoTheme_Plugin::stopTimer(); ?> second(s). Theme By <a href="http://my-typecho.tk">MyTypecho</a>. Powered By Typecho))).</div>
  <a id="rocket" href="#top" title="返回顶部"><i></i></a>
</footer>
<script type="text/javascript">var MINTY = {"url":"<?php $this->options->index("ajax/"); ?>","stickySidebar":"<?php echo $this->options->stickysidebar; ?>","keyboardNavigation":<?php echo $this->options->kbnav ? $this->options->kbnav : "false"; ?>,"infiniteScroll":<?php echo $this->options->infsc ? $this->options->infsc : "0"; ?>,"ajaxComment":<?php echo $this->options->ajaxc ? $this->options->ajaxc : "false"; ?>,"slidesTimeout":<?php echo $this->options->sltmo ? $this->options->sltmo : "4000"; if($this->options->allowRegister) { echo ',"register":"'; $this->options->registerUrl(); echo '"'; } if($this->is('single')) { echo ",respId:\""; $this->respondId(); echo "\",smileyUrl:\"".Typecho_Common::url("img/smilies/", $this->options->themeUrl)."\""; } ?>};<?php if($isPost): ?>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"<?php echo isset($thumb) ? $thumb : ''; ?></>","bdStyle":"1","bdSize":"32"},"share":{"bdCustomStyle":"javascript:;"}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=86835285.js?cdnversion='+~(-new Date()/36e5)];<?php endif; ?></script>
<script type="text/javascript" src="<?php $this->options->themeUrl("js/jquery.js"); ?>"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl("js/one.js"); ?>"></script>
<?php if($isPost): ?>
<script type="text/javascript" src="<?php $this->options->themeUrl("js/slimbox.js"); ?>"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl("js/prism.js"); ?>"></script>
<?php endif; ?>
<?php $this->footer(); if(isset($customFooter)) echo $customFooter; ?>
</body>
</html>