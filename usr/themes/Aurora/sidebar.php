<div id="secondary">
<div class="site_siderbar">
		<h2 class="site-description"><a href="<?php $this->options->siteUrl(); ?>" class="os_logo" title="返回<?php $this->options->title(); ?>首页"><?php $this->options->title(); ?></a>
    </h2>
	
	
		<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<div style="top: 0px;" class="move_tips" id="moveBar"><span class="move_bd"></span></div>        
		<aside id="nav_menu-2" class="widget widget_nav_menu"><div class="menu-%e5%b7%a6%e4%be%a7%e5%af%bc%e8%88%aa-container"><ul id="menu-%e5%b7%a6%e4%be%a7%e5%af%bc%e8%88%aa" class="menu"><li id="menu-item-148" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-148"><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
<li id="menu-item-154" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu-item-154"><a href="<?php $this->options->siteUrl(); ?>">目录</a>
<ul class="sub-menu">
	<li id="menu-item-162" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-162"><?php $this->widget('Widget_Metas_Category_List')
                ->parse('<li><a href="{permalink}">{name}</a></li>'); ?></li>
</ul>
</li>
<li id="menu-item-150" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-150"><a href="<?php $this->options->abouturl() ?>">关于我们</a></li>
<li id="menu-item-152" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-152"><a href="<?php $this->options->youlian() ?>">友情链接</a></li>
</ul></div></aside><aside id="search-3" class="widget widget_search"><form role="search" method="get" class="search-form" action="<?php $this->options->siteUrl(); ?>">
				<label>
					<span class="screen-reader-text">搜索：</span>
					<input class="search-field" placeholder="搜索…" name="s" title="搜索：" type="search">
				</label>
				<input class="search-submit" value="搜索" type="submit">
			</form></aside>	</div><!-- #primary-sidebar -->
	</div><!-- #secondary -->
</div>
<script type="text/javascript">
    function setStyles(dom,styles){
    for(var key in styles){
        var v=styles[key];
        key=key.replace(/-(\w)/g,function($0,$1){
            return $1.toUpperCase();
        });
        dom.style[key]=v;
    }
}
 // side_bar动画
 (function($){
    var moveBar = $("#moveBar"),top = moveBar.css("top"),oldtop = top;
    $("#nav_menu-2").mouseover(function(e){ 
        var etarget = e.target,nodename = etarget.nodeName;
        if(nodename.toLowerCase() === 'a'){
            top = $(etarget).position().top;            
            setStyles(moveBar[0],{
                'top':top
            })
            moveBar.animate({top:top}, .2);
        }
    }).mouseleave(function(){
    	setStyles(moveBar[0],{
            'top':oldtop
        })
        moveBar.animate({top:oldtop}, .2);
    });
 })(jQuery)
    
</script>

		</div><!-- #main -->
</div>