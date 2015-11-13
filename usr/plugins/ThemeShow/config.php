<?php
include_once 'common.php';
include 'header.php';
include 'menu.php';

function getThemeForm($theme)
{
	global $options;

	$configFile = $options->themeFile($theme, 'functions.php');
	$haveCfg = false;
	if(file_exists($configFile))
	{
		require_once $configFile;
            
        if (function_exists('themeConfig')) {
            $haveCfg = true;
        }
	}
	if(!$haveCfg) throw new Typecho_Widget_Exception(_t('外观配置功能不存在'), 404);
	
	$form = new Typecho_Widget_Helper_Form(Helper::url('ThemeShow/config.php') . "&cfgtheme=" . $theme, Typecho_Widget_Helper_Form::POST_METHOD);
	themeConfig($form);
	
	return $form;
}

if(isset($_GET["cfgtheme"]))
{
	$file = dirname(__FILE__). "/themecfg.json";
	$opt = array();
	if(file_exists($file))
	{
		$opt = @Json::decode(@file_get_contents($file), true);
		if(!is_array($opt)) $opt = array();
	}
	
	$form = getThemeForm($_GET["cfgtheme"]);
	$opt[$_GET["cfgtheme"]] = $form->getAllRequest();
	@file_put_contents($file, @Json::encode($opt));
	
	Typecho_Widget::widget('Widget_Notice')->set(_t('主题配置保存成功'), 'success');
	Typecho_Response::redirect(Helper::url('ThemeShow/config.php') . "&theme=" . $_GET["cfgtheme"]);
}

if(isset($_POST["theme"])) Typecho_Response::redirect(Helper::url('ThemeShow/config.php') . "&theme=" . $_POST["theme"]);

$currTheme = empty($_GET["theme"]) ? false : $_GET["theme"];

?>

<div class="main">
    <div class="body container">
        <?php include 'page-title.php'; ?>
        <div class="row typecho-page-main" role="main">
            <div class="col-mb-12">
                <ul class="typecho-option-tabs fix-tabs clearfix"><?php if($currTheme){ ?>
                    <li><a href="<?php echo Helper::url('ThemeShow/config.php'); ?>"><?php _e('可以使用的外观'); ?></a></li>
                    <li class="current"><a href="<?php echo Helper::url('ThemeShow/config.php?theme='.$currTheme); ?>"><?php _e('设置外观 - ' . $currTheme); ?></a></li>
                <?php }else{ ?><li class="current"><a href="<?php echo Helper::url('ThemeShow/config.php'); ?>"><?php _e('可以使用的外观'); ?></a></li>
				<?php } ?></ul>
            </div>
            <div class="col-mb-12 col-tb-8 col-tb-offset-2" role="form"><?php if($currTheme): ?>
				<p style="margin-bottom:14px;font-size:13px;text-align:center;">当前主题展示地址：<a href="<?php $themeSetUrl = Typecho_Common::url("/theme/" . $currTheme, $options->index); echo $themeSetUrl; ?>"><?php echo $themeSetUrl; ?></a></p>
                <?php 
	$form = getThemeForm($currTheme);

	$inputs = $form->getInputs();
	
	if (!empty($inputs)) {
		$file = dirname(__FILE__). "/themecfg.json";
		if(file_exists($file))
		{
			$opt = @Json::decode(@file_get_contents($file), true);
			if(!empty($opt) && isset($opt[$currTheme]))
			{
				foreach ($inputs as $key => $val)
				{
					if(isset($opt[$currTheme][$key])) $form->getInput($key)->value($opt[$currTheme][$key]);
				}
			}
		}
	}

	$submit = new Typecho_Widget_Helper_Form_Element_Submit(NULL, NULL, _t('保存设置'));
	$submit->input->setAttribute('class', 'btn primary');
	$form->addItem($submit);
	$form->render();
	else:
	$form = new Typecho_Widget_Helper_Form(Helper::url('ThemeShow/config.php'), Typecho_Widget_Helper_Form::POST_METHOD);
	
	Typecho_Widget::widget('Widget_Themes_List')->to($themes);
    $availableThemes = array();
    while($themes->next()){
        $availableThemes[$themes->name]=$themes->title;
    }

	$themeSel =  new Typecho_Widget_Helper_Form_Element_Select(
          'theme', $availableThemes, $options->theme,
          '主题名称');
    $form->addInput($themeSel);
	
	$submit = new Typecho_Widget_Helper_Form_Element_Submit(NULL, NULL, _t('配置此主题'));
	$submit->input->setAttribute('class', 'btn primary');
	$form->addItem($submit);
	$form->render();
	endif;
				?>
            </div>
        </div>
    </div>
</div>

<?php
include 'copyright.php';
include 'common-js.php';
include 'form-js.php';
include 'footer.php';
?>
