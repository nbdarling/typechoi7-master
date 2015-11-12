        <aside class="sidebar">
            <section>
                <h3>全站搜索</h3>
                <form id="search" method="get" action=""> 
                    <fieldset> 
                        <input type="text" maxlength="100" size="14" value="" id="s" class="input" name="s" onfocus="this.value=''"/> 
                        <input type="submit" class="button" value="搜索" />
                    </fieldset> 
                </form>
                <script type="text/javascript" src="http://www.google.com/cse/brand?form=cse-search-box&lang=zh-Hans"></script>
            </section>
 <?php if (empty($this->options->sidebarBlock) || in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
            <section id="tabs" class="sidelink"> 
                <div>
                    <dl id="tab1">
                        <h3>最新回复</h3>
                        <ul>
<?php $this->widget('Widget_Comments_Recent')->to($comments); ?>
<?php while($comments->next()): ?>
                            <li>&raquo; <a href="<?php $comments->permalink(); ?>" title="<?php $comments->author(false); ?>：<?php $comments->excerpt(44, '...'); ?>"><?php $comments->excerpt(16, '...'); ?></a></li>
<?php endwhile; ?>
                        </ul>
                    </dl>
                    <dl id="tab2">
                        <h3>最新文章</h3>
                        <ul> 
                            <?php $this->widget('Widget_Contents_Post_Recent')->parse('<li>&raquo; <a href="{permalink}" title="{title}">{title}</a></li>'); ?>
                        </ul> 
                    </dl>
                    <dl id="tab3">
                        <h3>随机文章</h3>
                        <ul> 
                            <?php RandomArticleList::parse('<li>&raquo; <a href="{permalink}">{title}</a></li>'); ?>
                        </ul>
                    </dl>
                </div>
            </section>
<?php endif; ?>

<?php if (empty($this->options->sidebarBlock) || in_array('ShowCategory', $this->options->sidebarBlock)): ?>
            <section class="sidelink"> 
                <h3><?php _e('文章分类'); ?></h3>
                <ul class="sidepan clear">
                    <?php $this->widget('Widget_Metas_Category_List')
                    ->parse('<li><a href="{permalink}">{name}</a> ({count})</li>'); ?>
                </ul>
            </section>
<?php endif; ?>
<?php if (empty($this->options->sidebarBlock) || in_array('ShowLink', $this->options->sidebarBlock)): ?>
<?php if($this->is('index')): ?>
            <section class="sidelink"> 
                <h3><?php _e('友情链接'); ?></h3>
                <ul class="sidepan clear">
                    <?php Links_Plugin::output("SHOW_TEXT", 0, "Index"); ?>
                </ul>
            </section>
<?php endif; ?>
<?php endif; ?>
        </aside>
