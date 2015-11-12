<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>


  <div class="footer section">
    
    <div class="footer-inner section-inner">
    
            
        <div class="footer-a widgets">
      
              <div class="widget widget_recent_entries"><div class="widget-content">    <h3 class="widget-title">Recent Posts</h3>
        <ul>
          <?php $this->widget('Widget_Contents_Post_Recent')
            ->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
        </ul>
    </div><div class="clear"></div></div>         
          <div class="clear"></div>
          
        </div>
        
       <!-- /footer-a -->
        
            
        <div class="footer-b widgets">
      
          <div class="widget widget_categories"><div class="widget-content"><h3 class="widget-title">Category</h3>    <ul>
<?php $this->widget('Widget_Metas_Category_List')->to($category2); ?>
<?php while ($category2->next()): ?>
<li><a href="<?php $category2->permalink(); ?>" title="<?php $category2->name(); ?>"><?php $category2->name(); ?></a></li>
<?php endwhile; ?>
    </ul>
</div><div class="clear"></div></div>         
          <div class="clear"></div>
          
        </div>
              
       <!-- /footer-b -->
                
            
        <div class="footer-c widgets">
      
          <div class="widget widget_text"><div class="widget-content"><h3 class="widget-title">FOR ME</h3>
                <div class="textwidget">但行善事，莫问前程。</div>
    </div><div class="clear"></div></div>         
          <div class="clear"></div>
          
        </div>
        
       <!-- /footer-c -->
      
      <div class="clear"></div>
    
    </div> <!-- /footer-inner -->
  
  </div> <!-- /footer -->

<div class="credits section">

  <div class="credits-inner section-inner">

    <p class="credits-left">
    
      <span>Copyright</span> &copy; 2016 <a href="<?php $this->options->siteUrl(); ?>" title="<?php $this->options->title() ?>"><?php $this->options->title() ?></a>
    
    </p>
    
    <p class="credits-right">
      
      <span>Theme by <a href="http://www.vpsmm.com/">小夜</a> &mdash; </span><a title="To the top" class="tothetop">返回顶部</a>
      <!--如果不能保留作者链接，请在适当位置添加一个友情链接即可，我使用，我尊重。-->
      
    </p>
    
    <div class="clear"></div>
  
  </div> <!-- /credits-inner -->
  
</div> <!-- /credits -->

<script type='text/javascript' src='<?php $this->options->themeUrl(); ?>js/flexslider.min.js?ver=4.3.1'></script>
<script type='text/javascript' src='<?php $this->options->themeUrl(); ?>js/global.js?ver=4.3.1'></script>
<?php $this->footer(); ?>
</body>
</html>
