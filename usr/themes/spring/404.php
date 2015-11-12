<?php $this->need('header.php'); ?>
        <section class="content"> 
            <article id="post-<?php $this->cid() ?>" class="clear"> 
                <h2 class="entry-title"><a href="<?php $this->options->siteUrl(); ?>"><?php _e('404 错误页'); ?></a></h2>
                <section class="entry-post">
                    <ul class="error">
                        <form id="search" method="get" action=""> 
                            <fieldset> 
                                <input type="text" maxlength="100" size="14" value="" id="s" class="input" name="s" onfocus="this.value=''"/> 
                                <input type="submit" class="button" value="搜索" />
                            </fieldset> 
                        </form>
                        <li>爱网络，爱自由，</li>
                        <li>爱聊天，爱折腾博客，</li>
                        <li>爱twitter，也爱Facebook，</li>
                        <li>我不是什么名博，不是您要找的页面，</li>
                        <li>我是404错误，我感到很抱歉。</li>
                    </ul>
                </section> 
            </article> 
        </section>

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>