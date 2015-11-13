<?php

function themeConfig($form) {
    $abouturl = new Typecho_Widget_Helper_Form_Element_Text('abouturl', NULL, NULL, _t('导航栏关于我们连接'), _t('在这里填写右侧导航栏关于我们自定义页面'));
    $form->addInput($abouturl);

	$youlian = new Typecho_Widget_Helper_Form_Element_Text('youlian', NULL, NULL, _t('导航栏友情连接'), _t('在这里填写右侧导航栏友情连接自定义页面'));
    $form->addInput($youlian);
	
    $siteIcon = new Typecho_Widget_Helper_Form_Element_Text('siteIcon', NULL, NULL, _t('标题栏和书签栏Icon'), _t('在这里填入一个图片URL地址, 作为标题栏和书签栏Icon, 默认不显示'));
    $form->addInput($siteIcon);

    $miibeian = new Typecho_Widget_Helper_Form_Element_Text('miibeian', NULL, _t('ICP合备74110号'), _t('备案号'), _t('在这里填入天朝备案号，不显示则留空'));
    $form->addInput($miibeian);


    $misc = new Typecho_Widget_Helper_Form_Element_Checkbox('misc', array(
        'ShowLogin' => _t('前台显示登录入口'),
        'ShowLoadTime' => _t('页脚显示加载耗时')
        ),
    array('ShowLogin'), _t('杂项'));
    $form->addInput($misc->multiMode());
}

function timer_start() {
    global $timestart;
    $mtime = explode( ' ', microtime() );
    $timestart = $mtime[1] + $mtime[0];
    return true;
}
timer_start();
 
function timer_stop( $display = 0, $precision = 3 ) {
    global $timestart, $timeend;
    $mtime = explode( ' ', microtime() );
    $timeend = $mtime[1] + $mtime[0];
    $timetotal = $timeend - $timestart;
    $r = number_format( $timetotal, $precision );
    if ( $display )
    echo $r;
    return $r;
}

function cTime($seconds){ 
        if($seconds<60){ 
        $msg=$seconds."秒"; 
        }elseif($seconds<3600){ 
        $msg=(int)($seconds/60)."分"; 
        }elseif($seconds<86400){ 
        $msg=(int)($seconds/60/60)."小时"; 
        }else{ 
        $msg=(int)($seconds/60/60/24)."天"; 
        } 
    return $msg; 
    }  
