<?php

/* 
	Minty Theme
	
	!Needs MyTypechoTheme_Plugin
	Author: http://my-typecho.tk
	
	[AD] 推荐安装修改过的缓存版TypechoEX http://my-typecho.tk
*/

/* 检查 */
if(!defined('__TYPECHO_ROOT_DIR__')) exit('Access Denied');

define("Minty_Version", "1.1.3");

if(!class_exists("MyTypechoTheme_Plugin")) throw new Typecho_Plugin_Exception("未安装 MyTypechoTheme 插件！");

//Globals
global $isTypechoEX, $siteUrl, $orgThemeUrl, $timezone;

//Init
if(isset($this))
{
	MyTypechoTheme_Plugin::init(array(
	));
	$timezone = MyTypechoTheme_Plugin::$_options->timezone;
	$isTypechoEX = class_exists('Cache_Main');
	
	define('thumbQuality', $this->options->thumbQuality);
	define('imageUrl', $this->options->themeImage);
	define('thumbScaling', $this->options->thumbScaling);

	$orgThemeUrl = $this->options->themeUrl;
	$siteUrl = $this->options->siteUrl;
	if(substr($siteUrl, -1 , 1) == "/") $siteUrl = substr($siteUrl, 0, -1);
	if(imageUrl)
	{
		$this->options->themeUrl = str_replace($siteUrl, imageUrl, $this->options->themeUrl);
		MyTypechoTheme_Plugin::$_options->themeUrl = $this->options->themeUrl;
	}
}
///////Cfg///////////////

function themeConfig($form)
{
	$index = Typecho_Widget::widget('Widget_Options')->index;

	echo '<p style="margin-bottom:14px;font-size:13px;text-align:center;">感谢您使用Minty主题 '.Minty_Version.'！点击我进行<a href="#" onclick="location.href=\''.Typecho_Common::url('cache', $index).'\';return false;"> (清除缓存) </a>';
	echo '<a href="#" onclick="location.href=\''.Typecho_Common::url('apc', $index).'\';return false;"> (清除PHP代码缓存) </a>！</p>';

	MyTypechoTheme_Plugin::checkUpdate(Minty_Version);
	
	/*** Image ***/
	$edit = new Typecho_Widget_Helper_Form_Element_Text('themeImage', NULL, '', _t('云存储主题镜像URL'), _t('填写使用主题文件镜像，注意结尾不带/'));
	$form->addInput($edit);

	$edit = new Typecho_Widget_Helper_Form_Element_Text('thumbQuality', NULL, '80', _t('缩略图压缩质量'), _t('1-100之间'));
	$form->addInput($edit);

	$edit = new Typecho_Widget_Helper_Form_Element_Radio('thumbScaling',
		array(
				'qiniu' => _t('七牛图片处理'),
				'timthumb' => _t('本地timthumb')
				),
		'timthumb',
		_t('缩略图获取方式'));

	$form->addInput($edit);
	
	/** Color **/
	$edit = new Typecho_Widget_Helper_Form_Element_Text('mainColor', NULL, '', _t('主色'), _t('CSS格式，自定义颜色时填写 (正常颜色)'));
	$form->addInput($edit);
	
	$edit = new Typecho_Widget_Helper_Form_Element_Text('subColor', NULL, '', _t('配色'), _t('CSS格式，自定义颜色时填写 (:hover 颜色)'));
	$form->addInput($edit);

	/** Plugin **/
	MyTypechoTheme_Plugin::themeConfig($form, "recentpost max=5\npopularpost max=5\ntagcloud max=30\nslider keyword=typecho\ncomment max=5");

	/** User **/

	$edit = new Typecho_Widget_Helper_Form_Element_Textarea('css', NULL, '', _t('自定义CSS'), NULL);
	$form->addInput($edit);

	$edit = new Typecho_Widget_Helper_Form_Element_Checkbox('header',
			array(
				'rss' => _t('显示RSS'),
				'weibo' => _t('显示微博'),
				'mail' => _t('显示邮件订阅')),
			array('rss'), _t('头部导航栏显示'));
	$form->addInput($edit);

	$edit = new Typecho_Widget_Helper_Form_Element_Text('weibo', NULL, '#', _t('微博地址'), NULL);
	$form->addInput($edit);

	$edit = new Typecho_Widget_Helper_Form_Element_Text('mail', NULL, '#', _t('邮件订阅地址'), NULL);
	$form->addInput($edit);

	$edit = new Typecho_Widget_Helper_Form_Element_Textarea('links', NULL, '', _t('底部链接(一行一个，格式：名称:链接)'), NULL);
	$form->addInput($edit);

	$edit = new Typecho_Widget_Helper_Form_Element_Radio('stickysidebar', array('none' => _t('无'), 'top' => '顶部', 'bottom' => '底部'), 'top', _t('粘性侧边栏'), NULL);
	$form->addInput($edit);

	$edit = new Typecho_Widget_Helper_Form_Element_Radio('kbnav', array('false' => _t('否'), 'true' => '是'), 'true', _t('键盘导航'), NULL);
	$form->addInput($edit);

	$edit = new Typecho_Widget_Helper_Form_Element_Text('infsc', NULL, '0', _t('无限滚动层数'), _t('0为关闭'));
	$form->addInput($edit);

	$edit = new Typecho_Widget_Helper_Form_Element_Radio('ajaxc', array('false' => _t('否'), 'true' => '是'), 'true', _t('无刷新评论'), NULL);
	$form->addInput($edit);

	$edit = new Typecho_Widget_Helper_Form_Element_Text('sltmo', NULL, '4000', _t('幻灯片延时'), _t('单位: 毫秒'));
	$form->addInput($edit);

	$edit = new Typecho_Widget_Helper_Form_Element_Text('headertext', NULL, '', _t('首页介绍'), _t('留空为网站介绍'));
	$form->addInput($edit);
	
	$edit = new Typecho_Widget_Helper_Form_Element_Textarea('featured', NULL, '', _t('首页幻灯片'), _t('一行一个关键字或cid'));
	$form->addInput($edit);
	
	$edit = new Typecho_Widget_Helper_Form_Element_Text('respmenu', NULL, '620,700,700,800,900,1000,1100,1200,1300', _t('响应式菜单宽度'), _t('请自行调整，支持620,700,800,900,1000,1100,1200,1300px'));
	$form->addInput($edit);
}

function themeConfigHandle($settings, $isInit)
{
	$db = Typecho_Db::get();
	$widget = Typecho_Widget::widget("Widget_Abstract_Options");

	$theme = dirname(__FILE__);
	$i = max(strrpos($theme, '/'), strrpos($theme, '\\'));
	$theme = substr($theme, $i+1);

	if (MyTypechoTheme_Plugin::$_options->__get('theme:' . $theme)) {
		$widget->update(array('value' => serialize($settings)), $db->sql()->where('name = ?', 'theme:' . $theme));
	} else {
		$widget->insert(array('name'  =>  'theme:' . $theme, 'value' =>  serialize($settings), 'user'  => 0));
	}
	
	$i = @file_get_contents(dirname(__FILE__) . '/style.css');

	//colors
	if(!empty($settings["mainColor"]) && !empty($settings["subColor"]))
	{
		$i .= str_replace(array("%M", "%H"), array($settings["mainColor"], $settings["subColor"]), ".commentlist .byowner>div>div>.fn:after{background-color:%H}.commentlist .bypostauthor{_border-top-color:%H}a:hover,.entry-cover:hover+.entry-header .entry-title a,.entry-title a:hover,.entry-meta a:hover,.more-link,.entry-summary a,.entry-content a,.wumii-text-a:hover,#error404 a,.commentlist .comment-author .fn,.commentlist .comment-author .url,.commentlist .comment-footer a,.must-log-in a{color:%M}#nav a:hover,#nav .current-menu-item a,#nav .sub-menu,#comment-settings{border-color:%M}.entry-footer .copyright,#submit,#submit:hover,#submit:active,#submit:disabled:hover{border-color:%H}#searchsubmit,#nav .sub-menu a:hover,a.entry-cover:before,.pagination a:hover,.page-title,#submit,#submit:hover,#submit:active,#submit:disabled:hover,#nprogress .bar,#featured-content.fccaption-cover a:hover h3{background-color:%M}#nprogress .peg{box-shadow:0 0 10px %M,0 0 5px %M}.widget_tag_cloud a:hover,.widget-simpletags a:hover,#featured-content.fccaption-below a:hover h3{color:%M !important}.home .hentry.sticky{box-shadow:0 2px 3px rgba(0,0,0,.1),0 0 0 3px %M}::-moz-selection{background:%M}::selection{background:%M}.entry-summary a:hover,.entry-content a:hover{border-bottom-color:%H}.entry-summary a:hover,.entry-content a:hover,#error404 a:hover,.commentlist .comment-author .url:hover,.commentlist .comment-footer a:hover,.must-log-in a:hover{color:%H}.tags-links a:hover{color:#fff}.commentlist .bypostauthor>div>div>.fn:after{background-color:%H}#loginform #wp-submit{background:%M}#loginform #wp-submit:hover{background:%H}");
	}

	//combine
	$i .= $settings['css'];
	
	//compress
	$i = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $i);
	$i = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $i);
	
	@file_put_contents(dirname(__FILE__) . '/style.min.css', $i);

	if($isInit)
	{
		$settings = array('commentsOrder' => 'DESC', 'commentsPageDisplay' => 'first', 'commentsPageSize' => '10', 'commentsMarkdown' => '0');
		foreach ($settings as $name => $value) {
			$widget->update(array('value' => $value), $db->sql()->where('name = ?', $name));
		}
	}
	
	//cache
	MyTypechoTheme_Plugin::clearCache(array("featured","sidebar","stat_report","post","field"));
	MyTypechoTheme_Plugin::finalize();
}

function getAvatar($size, $mail)
{
	return "http://2.gravatar.com/avatar/".md5(strtolower($mail)) . "?s=".$size."&d=mm&r=G";
}

function scaleThumb($source, $w, $h)
{
	global $siteUrl, $orgThemeUrl;

	$quality = intval(thumbQuality);
	if(empty($quality)) $quality = 80;
	if(thumbScaling == "qiniu") return str_replace($siteUrl, imageUrl, $source) . "?imageView/1/w/".$w."/h/".$h."/q/".$quality;
	return Typecho_Common::url('timthumb.php?w='.$w.'&h='.$h.'&q='.$quality.'&src=', $orgThemeUrl).$source;
}
/**********pager************/
function Index_Pager($obj)
{
	$total = $obj->getTotal();
	if($total > $obj->parameter->pageSize)
	{
		$query = Typecho_Router::url($obj->parameter->type .
								(false === strpos($obj->parameter->type, '_page') ? '_page' : NULL),
								$obj->getPageRow(), MyTypechoTheme_Plugin::$_options->index);
		$current = $obj->getCurrentPage();
		$totalPage = ceil($total / $obj->parameter->pageSize);
		if($totalPage < 1) $totalPage = 1;

		//HTML
		echo "<div class=\"navigation\">";
		if($current < $totalPage) echo "<a class=\"loadmore\" href=\"#\" data=\"" . str_replace("{page}", $current + 1, $query) . "\">查看更多</a>";
		echo "<nav class=\"pagination\" role=\"navigation\">";
		if($current > 1)
		{
			echo "<a href=\"".str_replace("{page}", $current - 1, $query)."\">&laquo; 上一页</a>";
		}
		else
		{
			echo "<span>&laquo; 上一页</span>";
		}
		echo "<span class=\"pagenum\">" . $current."/".$totalPage . "</span>";
		if($current < $totalPage)
		{
			echo "<a href=\"".str_replace("{page}", $current + 1, $query)."\">下一页 &raquo;</a>";
		}
		else
		{
			echo "<span>下一页 &raquo;</span>";
		}
		echo "</nav></div>";
	}
}

function Comments_Pager($obj)
{
	//set total
	$pagesize = MyTypechoTheme_Plugin::$_options->commentsPageSize;
	$total = $obj->getTotal();
	if(MyTypechoTheme_Plugin::$_options->commentsPageBreak && $total > $pagesize)
	{
		$currentPage = $obj->getCurrentPage();
		$totalPage = ceil($total / $pagesize);

		if($currentPage < $totalPage)
		{
			$pageRow = $obj->parameter->parentContent;
			$pageRow['permalink'] = $pageRow['pathinfo'];
			//get url
			$query = Typecho_Router::url('comment_page', $pageRow, MyTypechoTheme_Plugin::$_options->index);
			echo "<div class=\"navigation\"><a class=\"loadmore\" role=\"navigation\" href=\"#\" data=\"". str_replace('{commentPage}', $currentPage + 1, $query) ."\">更多评论</a></div>";
		}
	}
}

/************* slider *****************/
function slider($keywords)
{
	$posts = MyTypechoTheme_Plugin::matchPost(@explode("\n", str_replace("\r", "", $keywords)));
	if(empty($posts)) return false;

	$output = "";
	foreach($posts as $cid => $post)
	{
		//Field
		$thumb = MyTypechoTheme_Plugin::getField($cid, 'slider');
		if(empty($thumb)) $thumb = scaleThumb($post[2], 220, 110);
		if($thumb)
		{
			$output .= "{\"title\": \"".$post[0]."\", \"link\":\"".$post[1]."\", \"image\":\"".$thumb."\"},";
		}
	}
	if($output != "")
		return "var slideList = [".substr($output, 0, -1)."];";
	return false;
}

function FeaturedSlider()
{
	if(isset(MyTypechoTheme_Plugin::$_cache[0]["featured"]))
		return MyTypechoTheme_Plugin::$_cache[0]["featured"];

	if(empty(MyTypechoTheme_Plugin::$_options->featured)) return false;

	$posts = MyTypechoTheme_Plugin::matchPost(@explode("\n", str_replace("\r", "", MyTypechoTheme_Plugin::$_options->featured)));
	if(empty($posts)) return false;

	$output = "";
	$counter = 1;
	foreach($posts as $cid => $post)
	{
		//Field
		$thumb = MyTypechoTheme_Plugin::getField($cid, 'featured');
		if(empty($thumb)) $thumb = scaleThumb($post[2], 960, 290);
		if($thumb)
		{
			$output .=  '<li class="slide-'.$counter.'"><a href="'.$post[1].'"><img src="'.$thumb.'" alt="'.$post[0].'" /></a></li>';
		}
	}
	MyTypechoTheme_Plugin::setcache("featured", $output);
	return $output;
}

function theNext($widget)
{
		$db = Typecho_Db::get();
		$sql = $db->select()->from('table.contents')
							->where('table.contents.created > ?', $widget->created)
							->where('table.contents.status = ?', 'publish')
							->where('table.contents.type = ?', $widget->type)
							->where('table.contents.password IS NULL')
							->order('table.contents.created', Typecho_Db::SORT_ASC)
							->limit(1);
		$content = $db->fetchRow($sql);

		if ($content) {
				$content = $widget->filter($content);
				return $content;
		}
		return false;
}

function thePrev($widget)
{
		$db = Typecho_Db::get();
		$sql = $db->select()->from('table.contents')
							->where('table.contents.created < ?', $widget->created)
							->where('table.contents.status = ?', 'publish')
							->where('table.contents.type = ?', $widget->type)
							->where('table.contents.password IS NULL')
							->order('table.contents.created', Typecho_Db::SORT_DESC)
							->limit(1);
		$content = $db->fetchRow($sql);

		if ($content) {
				$content = $widget->filter($content);
				return $content;
		}
		return false;
}

function timesince($older_date) {
	global $timezone;
	
	$chunks = array(
			array(86400 , '天'),
			array(3600 , '小时'),
			array(60 , '分'),
			array(1 , '秒'),
		);
		
		$since = abs(MyTypechoTheme_Plugin::$_time - $older_date);
		if($since < 2592000){
			for ($i = 0, $j = count($chunks); $i < $j; $i++){
				$seconds = $chunks[$i][0];
				$name = $chunks[$i][1];
				if (($count = floor($since / $seconds)) != 0) break;
			}
			$output = $count.$name.'前';
		}else{
			$output = gmdate('Y-m-j G:i', $older_date + $timezone);
		}
	return $output;
}

/* 以下仅支持 TypechoEX */
/*function urlsafe_b64decode($string)
{
	 $data = str_replace(array('-','_'),array('+','/'),$string);
	 $mod4 = strlen($data) % 4;
	 if ($mod4) {
			 $data .= substr('====', $mod4);
	 }
	 return @base64_decode($data);
}

function mydecode($string)
{
	$key = "Minty_g4h32gw4";
	$str = '';
	for($i = 0; $i < strlen($string); $i++)
	{
		$str .= $string[$i] ^ $key[$i % strlen($key)];
	}
	return $str;
}

function getAntispamCode()
{
	$keymin = 10000000;
	$keymax = 99999999;
	$key = intval(urlsafe_b64decode(empty($_COOKIE['TESESSION']) ? '' : $_COOKIE['TESESSION']));
	if($key < $keymin || $key > $keymax)
	{
		$key = rand($keymin, $keymax);
		setcookie('TESESSION', str_replace(array('+','/','='), array('-','_',''), base64_encode($key)), 0, '/');
	}
	return $key . MyTypechoTheme_Plugin::$_time;
}*/
function getAntispamCode()
{
	return strval(MyTypechoTheme_Plugin::$_time * 100 + rand(0, 99) + 8135);
}

function themeAntiSpam($widget)
{
	if(isset($widget->request->vk))
	{
		$vk = floatval($widget->request->vk);
		$ktime = intval($vk*$vk);
		if(MyTypechoTheme_Plugin::$_time >= $ktime && (MyTypechoTheme_Plugin::$_time - $ktime) < 3600)
		{
			return;
		}
	}
	throw new Typecho_Widget_Exception(_t('页面已过期，请刷新并确认启用Javascript'));
}

//主题标记
function MyTypechoThemeMark(){}
