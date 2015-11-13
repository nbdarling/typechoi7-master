<?php


if (!defined("__TYPECHO_ROOT_DIR__")) exit;
/**
 * 主题展示
 * 
 * @package ThemeShow
 * @author mytypecho
 * @version 1.1.2
 * @link http://my-typecho.tk
 */
class ThemeShow_Plugin implements Typecho_Plugin_Interface
{
	public static function activate()
    {
        Typecho_Plugin::factory('index.php')->begin = array(__CLASS__, 'switchTheme');
		Typecho_Plugin::factory('Widget_Archive')->error404Handle = array(__CLASS__, 'error404Handle');

		Helper::addPanel(4, 'ThemeShow/config.php', _t('主题展示配置'), _t('主题展示配置'), 'administrator');
    }
	
	public static function deactivate()
	{
		Helper::removePanel(4, 'ThemeShow/config.php');
	}
	
	public static function config(Typecho_Widget_Helper_Form $form){}
	public static function personalConfig(Typecho_Widget_Helper_Form $form){}
	
	public static function switchTheme()
	{
		if(isset($_COOKIE["theme"]))
		{
			$theme = $_COOKIE["theme"];
			
			Typecho_Widget::widget("Widget_Options")->to($options);
			$themeDir = rtrim($options->themeFile($theme), '/') . '/';
			if(@is_dir($themeDir))
			{
				$options->theme = $theme;
				$file = dirname(__FILE__). "/themecfg.json";
				if(file_exists($file))
				{
					$opt = @Json::decode(@file_get_contents($file), true);

					if(!empty($opt) && isset($opt[$theme]))
					{
						foreach($opt[$theme] as $key => $value)
							$options->{$key} = $value;
					}
				}
			}
		}
	}
	
	public static function error404Handle($widget, $hasPushed)
	{
		$pi = $widget->request->getPathinfo();
		if(substr($pi, 0, 1) == "/") $pi = substr($pi, 1);
		if(substr($pi, -1, 1) == "/") $pi = substr($pi, 0, -1);
		if(stripos($pi, "theme/") === 0)
		{
			$theme = substr($pi, 6);
			Typecho_Widget::widget("Widget_Options")->to($options);
			$themeDir = rtrim($options->themeFile($theme), '/') . '/';
			if(!@is_dir($themeDir)) throw new Typecho_Plugin_Exception("主题不存在！");
			setcookie("theme", $theme, 0, "/");
			
			$widget->response->redirect($options->siteUrl);
		}
	}
}