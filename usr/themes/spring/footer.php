    </div><!-- end #container -->
    <footer> 
        <section> 
            &copy; 2006 - 2010 <a href="<?php $this->options->siteurl(); ?>"><?php $this->options->title(); ?></a> | <?php _e(' Powered by'); ?> <a href="http://www.typecho.org" target="_blank">Typecho</a> | <?php _e(' Themed by'); ?> <a href="http://www.viold.com" target="_blank">JET</a> | <a title="Valid HTML5" href="http://html5.validator.nu/?doc=<?php $this->options->siteurl(); ?>" target="_blank">Valid HTML5</a>
        </section> 
    </footer><!-- end #footer --> 
    <?php $this->footer(); ?>
    <div id="top"> 
        <div id="top-p"> 
            <a class="top" href="#" title="<?php _e('返回顶部'); ?>"></a> 
            <a class="rss" href="<?php $this->options->feedUrl(); ?>" target="_blank" title="<?php _e('订阅'); ?>"></a>
        </div>
    </div>
</div><!-- end #wrapper -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl('js/themes.js'); ?>?v=101019"></script>
</body>
</html>