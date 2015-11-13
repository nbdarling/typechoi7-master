		<footer id="colophon" name="#ft" class="site-footer" role="contentinfo">

			
<div id="supplementary">
	<div style="position: relative; height: 49px;" id="footer-sidebar" class="footer-sidebar widget-area masonry" role="complementary">
		<aside style="position: absolute; left: 0px; top: 28px;" id="tag_cloud-2" class="widget widget_tag_cloud masonry-brick"><h1 class="widget-title">热门标签</h1><div class="tagcloud"><?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=28')->to($tags); ?>
<?php while($tags->next()): ?>
<a href="<?php $tags->permalink(); ?>" class="size-<?php $tags->split(5, 10, 20, 30); ?>"><?php $tags->name(); ?></a>
<?php endwhile; ?></div>
</aside>
		
	</div><!-- #footer-sidebar -->

</div><!-- #supplementary -->

			<div class="site-info">
				Copyright © 2015 <a href="<?php $this->options->siteUrl(); ?>" target="_blank"><?php $this->options->title(); ?></a> 自豪的使用 <a href="http://typecho.org/">typecho</a> Theme By <a href="http://www.htmwind.com/">wind</a> <br> 工业与信息化部备案号：<a href="http://www.miibeian.gov.cn" rel="nofollow"><?php echo $this->options->miibeian; ?></a>
			</div>
			<!-- .site-info -->
		</footer><!-- #colophon -->
	<!-- #page -->
	<script type="text/javascript" src="<?php $this->options->themeUrl(); ?>/js/masonry.js"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl(); ?>/js/functions.js"></script>
<div class="go2top" id="go2top" style="display:none"><a href="#" title="返回顶部"></a>

</div>
<script type="text/javascript">
//var jQuery = $.noConflict();
jQuery(document).ready(function(){
    var ht;   
    jQuery(window).scroll(function(){      
        ht=jQuery("body").scrollTop();      
        if(ht>120){jQuery("#go2top").show()} 
       else {jQuery("#go2top").hide()}
    }); 

    jQuery('[role="search"]').click(function(){
        jQuery(this).addClass('fm_active');
    });
    jQuery('.search-submit').blur(function(){
       jQuery('[role="search"]').removeClass('fm_active');
    });
    jQuery('.search-field').blur(function(){
        jQuery('[role="search"]').removeClass('fm_active');
    });   

      
//分辨率低于480
    jQuery('#menuLink').click(function() {       
        jQuery('#main').toggleClass("active");
        jQuery('#secondary').toggleClass("active");
        jQuery('#menuLink').toggleClass("active");
    }); 
});
 
    
 
</script>

<!-- <script src="http://ossweb-img.qq.com/images/js/comm/showDialog.min.js"></script> -->



<script type="text/javascript" src="<?php $this->options->themeUrl(); ?>/js/stats" charset="UTF-8"></script>



</body></html>