<?php 

if(!defined('__TYPECHO_ROOT_DIR__')) exit('Access Denied'); 

function get_color_by_scale($scale_color, $min_color, $max_color) {
		$minr = hexdec(substr($min_color, 1, 2));
		$ming = hexdec(substr($min_color, 3, 2));
		$minb = hexdec(substr($min_color, 5, 2));
		
		$maxr = hexdec(substr($max_color, 1, 2));
		$maxg = hexdec(substr($max_color, 3, 2));
		$maxb = hexdec(substr($max_color, 5, 2));
		
		$r = dechex(intval((($maxr - $minr) * $scale_color) + $minr));
		$g = dechex(intval((($maxg - $ming) * $scale_color) + $ming));
		$b = dechex(intval((($maxb - $minb) * $scale_color) + $minb));
		
		if (strlen($r) == 1) $r = '0'.$r;
		if (strlen($g) == 1) $g = '0'.$g;
		if (strlen($b) == 1) $b = '0'.$b;
		
		return '#'.$r.$g.$b;
}

function SB_recentpost($param)
{
	$text = '<aside class="widget widget_recent_entries clearfix"><h3 class="widget-title"><span>最新文章</span></h3><ul>';
	$widget = Typecho_Widget::widget('Widget_Contents_Post_Recent', 'pageSize='.(intval($param['max']) ? intval($param['max']) : 5));

	while($widget->next()) $text .= "<li><a href=\"" . $widget->permalink . "\">".$widget->title."</a></li>";
	return $text . '</ul></aside>';
}

function SB_popularpost($param)
{
	return '<aside class="widget widget_minty_popularposts clearfix"><h3 class="widget-title"><span>热门文章</span></h3><ul>'.MyTypechoTheme_Plugin::getMostViewed(intval($param['max']) ? intval($param['max']) : 5).'</ul></aside>';
}

function SB_tagcloud($param)
{
	$db = Typecho_Db::get();
	$text = '<aside class="widget widget-simpletags clearfix"><h3 class="widget-title"><span>标签云</span></h3><div class="st-tag-cloud">';
	$sql = $db->fetchAll($db->select()->from("table.metas")->where('type = ?', 'tag')->order('count', Typecho_Db::SORT_DESC)->limit(intval($param['max']) ? intval($param['max']) : 30));
	if(!empty($sql))
	{
		$largest = 22;
		$smallest = 8;
		$scale_min = 1;
		$scale_max = 10;
		
		$minout = max($scale_min, 0);
		$maxout = max($scale_max, $minout);
  	
		$maxval = 0;
		$minval = $sql[0]['count'];
		foreach($sql as $tag)
		{
			if($tag['count'] > $maxval) $maxval = $tag['count'];
			if($minval > $tag['count']) $minval = $tag['count'];
		}
		$scale = ($maxval > $minval) ? (($maxout - $minout) / ($maxval - $minval)) : 0;
	  
		$obj = Typecho_Widget::widget("Widget_Abstract_Metas");
		foreach($sql as $tag) 
		{
			$tag = $obj->filter($tag);
			$scale_result = ceil(($tag['count'] - $minval) * $scale + $minout);
			$text .= "<a href=\"" . $tag['permalink'] . "\" title=\"".$tag['count']." 个主题\" style=\"font-size:".round(($scale_result - $scale_min)*($largest-$smallest)/($scale_max - $scale_min) + $smallest)."px;color:".get_color_by_scale(round(($scale_result - $scale_min)/($scale_max - $scale_min)*100)/100, "#cccccc", "#666666")."\">".$tag['name']."</a>\n";
		}
	}
	return $text . '</div></aside>';
}

function SB_slider($param)
{
	if(empty($param["keyword"])) return "";

	$slider = slider($param["keyword"]);
	if($slider !== false) return '<aside class="widget widget_minty_slideshow clearfix"><h3 class="widget-title"><span>文章推荐</span></h3><div class="textwidget"><div class="slideshow-wrap"><script type="text/javascript">'.$slider.'</script></div></div></aside>';
}

function SB_comment($param)
{
	$comments = Typecho_Widget::widget('Widget_Comments_Recent', 'ignoreAuthor=true&pageSize='.(empty($param["max"]) ? "5" : $param["max"]));
	if(!$comments->have()) return '';
	
	$text = '<aside class="widget widget_minty_recentcomments clearfix"><h3 class="widget-title"><span>近期评论</span></h3><ul id="minty_recentcomments">';
	while($comments->next()) 
	{
	  $url = !empty($comments->url) ? $comments->url : "#";
	  $text .= "<li><a href=\"".$url."\" target=\"_blank\" rel=\"external nofollow\" class=\"avatar\"><img alt=\"\" src=\"".getAvatar(32, $comments->mail)."\" class=\"avatar\" height=\"32\" width=\"32\" /></a><div class=\"bd\"><a href=\"".$url."\" rel=\"external nofollow\" class=\"url\">".$comments->author."</a><a href=\"".$comments->permalink."\" class=\"desc\" title=\"发表在 ".timesince($comments->created)."\">".Typecho_Common::subStr(strip_tags($comments->text), 0, 25, '...')."</a></div></li>"; 
	}
	return $text . '</ul></aside>';
}
?><div id="sidebar" role="complementary"><?php

MyTypechoTheme_Plugin::sidebar(array(
  'recentpost' => 'SB_recentpost',
  'popularpost' => 'SB_popularpost',
  'tagcloud' => 'SB_tagcloud',
  'slider' => 'SB_slider',
  'comment' => 'SB_comment',
)); 

?></div>