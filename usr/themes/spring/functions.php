<?php

function themeConfig($form) {
    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock', 
    array('ShowRecentPosts' => _t('显示最新文章'),
    'ShowCategory' => _t('显示文章分类'),
    'ShowLink' => _t('显示友情链接')),
    array('ShowRecentPosts', 'ShowCategory', 'ShowLink'), _t('侧边栏显示'));
    
    $form->addInput($sidebarBlock->multiMode());
}
