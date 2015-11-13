<?php

if(!defined('__TYPECHO_ROOT_DIR__')) exit('Access Denied'); 

if(!class_exists("CacheManager")) $this->need('functions.php');

$status = NULL;

$pi = strtolower($this->request->getPathinfo());
if(substr($pi, 0, 1) == "/") $pi = substr($pi, 1);
if(substr($pi, -1, 1) == "/") $pi = substr($pi, 0, -1);

if($this->user->pass("administrator", true))
{
	if($pi == "apc")
	{
		$this->response->setStatus(200);
		$status_code = "success";
		if(function_exists("apc_clear_cache"))
		{
			if(apc_clear_cache() && apc_clear_cache("user") && apc_clear_cache("opcode"))
				$status = "APC缓存清除成功";
			else
			{
				$status_code = "failed";
				$status = "APC缓存清除失败";
			}
		}
		else
		{
			$status_code = "notice";
			$status = "APC缓存未安装";
		}
		$this->widget('Widget_Notice')->set(_t($status), $status_code);
		$this->response->goBack(NULL, $this->options->adminUrl);
	}
	elseif($pi == "cache")
	{
		$this->response->setStatus(200);

		MyTypechoTheme_Plugin::clearCache(array("featured","sidebar","post","field"));
		MyTypechoTheme_Plugin::finalize();
		
		$this->widget('Widget_Notice')->set(_t("缓存清除成功！"), 'success');
		$this->response->goBack(NULL, $this->options->adminUrl);
	}
}

if($pi == "ajax")
{
	$this->response->setStatus(200);
	if(empty($_POST['u']) || empty($_POST['p'])) exit('请填写用户名及密码');
	if($this->user->login($_POST['u'], $_POST['p'], false, empty($_POST['rem']) ? 0 : 7*86400)) exit('success');

	@sleep(3);
	exit('用户名或密码错误');
}
elseif($pi == "random")
{
	$result = $this->db->fetchRow($this->db->query($this->db->select()->from('table.contents')->where('status = ?','publish')->where('type = ?', 'post')->order('RAND()')->limit(1)));
	if(is_array($result) && !empty($result))
	{
		$filter = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($result);
		$this->response->redirect($filter['permalink']);
	}
	else throw new Typecho_Exception('暂无文章');
	exit();
}

$this->need('header.php');

?><div id="container" class="clearfix">
	<main id="error404" role="main">
		<img src="<?php $this->options->themeUrl('img/rocher.gif'); ?>" alt="404" />
		<article class="content">
			<h1><?php if($status): echo $status; else: ?>您访问的页面不存在<?php endif; ?></h1>
			<h3>404 - Not Found</h3>
			<a href="<?php $this->options->siteUrl(); ?>">返回首页</a>
		</article>
	</main>
</div><?php $this->need('footer.php'); ?>