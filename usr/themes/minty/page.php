<?php

if(!defined('__TYPECHO_ROOT_DIR__')) exit('Access Denied');

global $isTypechoEX;

$isAjax = isset($_POST['isAjax']);

function OutputArchives($db, $options)
{
		$select = $db->select('cid', 'title', 'slug', 'created', 'allowComment', 'commentsNum')
					->from('table.contents')
					->where('status = ?', 'publish')
					->where('type = ?', 'post');
		$rawposts = $db->fetchAll($select);

		$posts = array();
		// Loop through each post and sort it into a structured array
		foreach( $rawposts as $post ) {
			/** 取出所有分类 */
            $categories = $isTypechoEX ? Cache_Plugin::meta_get($post['cid'], "category") : $db->fetchAll($db
				->select('slug')->from('table.metas')
				->join('table.relationships', 'table.metas.mid = table.relationships.mid')
				->where('table.relationships.cid = ?', $post['cid'])
				->where('table.metas.type = ?', 'category')
				->order('table.metas.order', Typecho_Db::SORT_ASC));

            /** 取出第一个分类作为slug条件 */
            $post['category'] = current(Typecho_Common::arrayFlatten($categories, 'slug'));
		
			$date = new Typecho_Date($post['created']);
			$post['year'] = $date->year;
			$post['month'] = $date->month;
			$post['day'] = $date->day;
			
			$type = 'post';//$p['type'];
            $routeExists = (NULL != Typecho_Router::get($type));
            $permalink = $routeExists ? Typecho_Router::url($type, $post, $options->index) : '#';

			$post['permalink'] = $permalink;
			
			$posts[ $post['year'] . '.' . $post['month'] ][] = $post;
		}
		$rawposts = null; // More memory cleanup

		// Sort the months based on $atts
		krsort( $posts );

		// Sort the posts within each month based on $atts
		foreach( $posts as $key => $month ) {
			$sorter = array();
			foreach ( $month as $post )
				$sorter[] = $post['created'];

			array_multisort( $sorter, SORT_DESC, $month );

			$posts[$key] = $month;
			unset($month);
		}

		// Generate the HTML
		$html = "";
		foreach( $posts as $yearmonth => $posts ) {
      list( $year, $month ) = explode( '.', $yearmonth );
      
      $html .= "<li><b><a href=\"".Typecho_Router::url('archive_month', array('year' => $year, 'month' => $month), $options->index)."\">".$year."年".$month."月</a></b> <span>(".number_format(count($posts))." 篇文章)</span><ul>";
      foreach( $posts as $post )
      	$html .= "<li>".$post['day'].": <a href=\"".$post['permalink']."\">".$post['title']."</a> <span>(".number_format($post['commentsNum']).")</span></li>";
      $html .= "</ul></li>";
		}
		return $html;
}

function readerWall($db, $options)
{
	$html = "";
	$time = Typecho_Date::gmtTime() - 31536000;
  $result = $db->fetchAll($db->select('author, mail, url, count(author) as cnt')->from('table.comments') 
            ->where('status = ?','approved') 
            ->where('created >= ?', $time) 
            ->where('ownerId <> authorId')
            ->group('author')
            ->limit(3) 
            ->order('cnt', Typecho_Db::SORT_DESC));
  if(!empty($result))
  {
  	$html = "<div class=\"dearreaders\"><h3>评论先锋队</h3><div>";
  	if(isset($result[1])) $html .= "<a rel=\"external nofollow\" href=\"".(empty($result[1]['url']) ? "#" : $result[1]['url'])."\" target=\"_blank\"><img alt=\"\" src=\"".getAvatar(60, $result[1]["mail"])."\" class=\"lazy avatar\" height=\"60\" width=\"60\" /><b class=\"name\">".htmlspecialchars($result[1]["author"])."</b><i class=\"count\">2nd</i></a>";
  	$html .= "<a rel=\"external nofollow\" href=\"".(empty($result[0]['url']) ? "#" : $result[0]['url'])."\" target=\"_blank\"><img alt=\"\" src=\"".getAvatar(80, $result[0]["mail"])."\" class=\"lazy avatar\" height=\"80\" width=\"80\" /><b class=\"name\">".htmlspecialchars($result[0]["author"])."</b><i class=\"count\">1st</i></a>";
    if(isset($result[2])) $html .= "<a rel=\"external nofollow\" href=\"".(empty($result[2]['url']) ? "#" : $result[2]['url'])."\" target=\"_blank\"><img alt=\"\" src=\"".getAvatar(60, $result[2]["mail"])."\" class=\"lazy avatar\" height=\"60\" width=\"60\" /><b class=\"name\">".htmlspecialchars($result[2]["author"])."</b><i class=\"count\">3rd</i></a>";
    $html .= "</div></div>";
  }
  return $html;
}

function getPY($asc)
{
  if ($asc >= -20319 && $asc <= -20284) return "A";
  if ($asc >= -20283 && $asc <= -19776) return "B";
  if ($asc >= -19775 && $asc <= -19219) return "C";
  if ($asc >= -19218 && $asc <= -18711) return "D";
  if ($asc >= -18710 && $asc <= -18527) return "E";
  if ($asc >= -18526 && $asc <= -18240) return "F";
  if ($asc >= -18239 && $asc <= -17923) return "G";
  if ($asc >= -17922 && $asc <= -17418) return "H";
  if ($asc >= -17417 && $asc <= -16475) return "J";
  if ($asc >= -16474 && $asc <= -16213) return "K";
  if ($asc >= -16212 && $asc <= -15641) return "L";
  if ($asc >= -15640 && $asc <= -15166) return "M";
  if ($asc >= -15165 && $asc <= -14923) return "N";
  if ($asc >= -14922 && $asc <= -14915) return "O";
  if ($asc >= -14914 && $asc <= -14631) return "P";
  if ($asc >= -14630 && $asc <= -14150) return "Q";
  if ($asc >= -14149 && $asc <= -14091) return "R";
  if ($asc >= -14090 && $asc <= -13319) return "S";
  if ($asc >= -13318 && $asc <= -12839) return "T";
  if ($asc >= -12838 && $asc <= -12557) return "W";
  if ($asc >= -12556 && $asc <= -11848) return "X";
  if ($asc >= -11847 && $asc <= -11056) return "Y";
  if ($asc >= -11055 && $asc <= -10247) return "Z";
  return null;
}

function TagArchive($db)
{
	$object = Typecho_Widget::widget("Widget_Abstract_Metas");
	$query = $db->fetchAll($db->select()->from('table.metas')->where('type = ?', 'tag')->order('name', Typecho_Db::SORT_ASC));
	$tags = array();
	
	for($i = 48; $i < 58; $i++) $tags[chr($i)] = array();
	for($i = 65; $i < 91; $i++) $tags[chr($i)] = array();
	foreach($query as $t)
	{
		$c = ord(strtoupper(substr($t["name"], 0, 1)));
		if($c < 48) $key = "0";
		elseif(($c >= 48 && $c <= 59)||($c >= 65 && $c <= 90)) $key = chr($c);
		else {
			if(strlen($t["name"]) > 1)
			{
			  $c = iconv("UTF-8", "gb2312", $t["name"]);
		    $key = getPY(ord($c{0}) * 256 + ord($c{1}) - 65536);
		  }
		  else $key = "0";
		}
		if(isset($tags[$key])) 
		{
			$t = $object->filter($t);
		  $tags[$key][] = array($t["name"], $t["permalink"], $t["count"]);
		}
	}
	$nav = "<div id=\"tag-nav\"><ul>";
	$div = "";
	foreach($tags as $key => $tagarray)
	{
		if(empty($tagarray)) $nav .= "<li><a href=\"#\" class=\"noclick\">".$key."</a></li>";
		else
		{
			$nav .= "<li><a href=\"#t-".$key."\">".$key."</a></li>";
			$div .= "<dl><dt id=\"t-".$key."\">".$key."</dt><dd><ul class=\"inline\">";
			foreach($tagarray as $tag) $div .= "<li><a target=\"_blank\" href=\"".$tag[1]."\">".$tag[0]."</a> <span class=\"set-tags f12\">(".number_format($tag[2]).")</span></li>";
		  $div .= "</ul></dd></dl>";
		}
	}
	if($div) $div = "<div class=\"tags-all-list\">".$div."</div>";
	return $nav."</ul></div>".$div;
}

$allowComment = true;

if(!$isAjax) {

$this->need('header.php');

?><div id="container" class="clearfix">
	<main id="main" role="main">
		<article class="hentry page">
		  <header class="entry-header"><h1 class="entry-title"><?php $this->title(); ?></h1></header>
		  <?php
		    $fields = MyTypechoTheme_Plugin::getField($this->cid);
		  	$type = isset($fields['type']) ? $fields['type'] : NULL; 
		  	if($type == "archive")
		  	{ 
		  		$allowComment = false;
		  		$page = MyTypechoTheme_Plugin::$_cache[0]["p_archive"];
		  		if(!$page) 
		  		{ 
		  			$page = OutputArchives($this->db, $this->options); 
		  			MyTypechoTheme_Plugin::setcache("p_archive", $page);
		  		} 
		  		echo "<div class=\"entry-content\">";
		  		echo "<ul class=\"archives-list\">"; 
		  		echo $page; echo "</ul>";
		  		echo "</div>";
		  	}
		  	elseif($type == "readers")
		  	{
		  		$page = MyTypechoTheme_Plugin::$_cache[0]["p_readers"];
		  		if(!$page) 
		  		{
		  			$page = readerWall($this->db, $this->options); 
		  			MyTypechoTheme_Plugin::setcache("p_readers", $page);
		  		}
		  		echo "<div class=\"entry-content\">";
		  		$this->content();
		  		echo $page;
		  		echo "</div>";
		  	}
		  	elseif($type == "tags")
		  	{
		  		$page = MyTypechoTheme_Plugin::$_cache[0]["p_tags"];
		  		if(!$page) 
		  		{
		  			$page = TagArchive($this->db); 
		  			MyTypechoTheme_Plugin::setcache("p_tags", $page);
		  		}
		  		echo "<style type=\"text/css\">#tag-nav ul li{display:inline-block;margin:10px}#tag-nav ul li a{border:1px solid #ddd;color:#3b5998;padding:5px 6px;text-align:center;width:20px;display:inline-block}#tag-nav ul li .noclick{background-color:#fafafa;border:1px solid #eee;color:#eee}.tags-all-list{margin:10px 20px}.tags-all-list dl{border-bottom:1px dashed #ccc;margin:20px 0;padding:10px 0}.tags-all-list dt{float:left;font-size:28px;line-height:23px;text-align:center;width:70px;font-style:oblique;margin-left:38px}.tags-all-list dd{margin-left:70px}ul.inline,ol.inline{list-style:none outside none;margin-left:0}.tags-all-list dd li a{color:#e74c3c}ul.inline>li,ol.inline>li{display:inline-block;padding-left:5px;padding-right:5px}.tags-all-list .set-tags{margin-left:5px;position:relative;top:-6px}</style>";
		  		echo $page;
		  	}
		  	else 
		  	{
		  		echo "<div class=\"entry-content\">";
		  		$this->content(); 
		  		echo "</div>";
		  	} 
		  	?>
		</article>
		<?php } if($allowComment && $this->allow("comment")): if(!$isAjax) { ?><div id="comments"><?php } $this->need('comments.php'); if($isAjax) exit(); ?></div><?php endif; ?>
	</main><?php $this->need('sidebar.php'); ?>
</div><?php $this->need('footer.php'); ?>