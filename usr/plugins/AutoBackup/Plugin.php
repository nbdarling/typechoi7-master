<?php
/**
 * Typecho 自动备份插件
 * 
 * @package Typecho AutoBackup 
 * @author zhoumiao
 * @version 1.0.6
 * @link http://zhoumiao.com
 */
class AutoBackup_Plugin implements Typecho_Plugin_Interface
{
	/**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
	public static function activate()
	{
		Typecho_Plugin::factory('Widget_Contents_Post_Edit')->write = array('AutoBackup_Plugin', 'render');
		Typecho_Plugin::factory('Widget_Feedback')->finishComment = array('AutoBackup_Plugin', 'render');
	}

	/**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
	public static function deactivate(){}

	/**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
	public static function config(Typecho_Widget_Helper_Form $form)
	{
		$config_file = dirname(__FILE__).'/config.xml';		//config.xml的绝对地址
		$xml = simplexml_load_file($config_file);
		
		$tables = new Typecho_Widget_Helper_Form_Element_Text('tables', null, (string)$xml->tables, _t('需要备份的表'), _t('键入表名，用“,”隔开'));
		$form->addInput($tables);
		
		$circle = new Typecho_Widget_Helper_Form_Element_Text('circle', null, (string)$xml->circle, _t('更新周期(天)'));
		$form->addInput($circle->addRule('isInteger', _t('更新周期必须是纯数字')));
		
		$ToMail = new Typecho_Widget_Helper_Form_Element_Checkbox('tomail',
				array('tomail' => _t('发送备份文件至邮箱')),
				$xml->tomail?explode(',', (string)$xml->tomail):null, null, _t('<strong>重要：如果选择此项，请认真填写以下表单</strong>'));
		$form->addInput($ToMail);
		
		$subject = new Typecho_Widget_Helper_Form_Element_Text('subject', null, (string)$xml->subject, _t('自定义邮件标题'), _t('格式：20100902-XXX-数据库备份文件（不填则XXX默认为博客标题）'));
		$form->addInput($subject);
		
		$mode= new Typecho_Widget_Helper_Form_Element_Radio('mode',
                array( 'smtp' => 'smtp',
                    'mail' => 'mail()',
                        'sendmail' => 'sendmail()'),
                (string)$xml->mode, '发信方式');
        $form->addInput($mode);

        $host = new Typecho_Widget_Helper_Form_Element_Text('host', NULL, (string)$xml->host,
                _t('SMTP地址'), _t('请填写 SMTP 服务器地址'));
        $form->addInput($host);

        $port = new Typecho_Widget_Helper_Form_Element_Text('port', NULL, (string)$xml->port,
                _t('SMTP端口'), _t('SMTP服务端口,一般为25;gmail和qq的465。'));
        $port->input->setAttribute('class', 'mini');
        $form->addInput($port->addRule('isInteger', _t('端口号必须是纯数字')));

        $user = new Typecho_Widget_Helper_Form_Element_Text('user', NULL, (string)$xml->user,
                _t('SMTP用户'),_t('SMTP服务验证用户名,一般为邮箱名如：youname@domain.com'));
        $form->addInput($user);

        $pass = new Typecho_Widget_Helper_Form_Element_Password('pass', NULL, NULL,
                _t('SMTP密码'));
        $form->addInput($pass);

        $validate=new Typecho_Widget_Helper_Form_Element_Checkbox('validate',
                array('validate'=>'服务器需要验证',
                    'ssl'=>'ssl加密'),
                $xml->validate?explode(',', (string)$xml->validate):null,'SMTP验证');
        $form->addInput($validate);

        $mail = new Typecho_Widget_Helper_Form_Element_Text('mail', NULL, (string)$xml->mail,
                _t('接收邮箱'),_t('接收邮件用的信箱,如为空则使用博客创建者个人设置中的邮箱！'));
        $form->addInput($mail->addRule('email', _t('请填写正确的邮箱！')));
        
        $request = Typecho_Request::getInstance();
        if ($request->isPost()) {
	    	/**
	    	 * 更新配置文件
	    	 */
        	$xml->tables = $request->get('tables');
        	$xml->circle = $request->get('circle');
        	if (is_array($request->get('tomail'))) {
        		$xml->tomail = implode(',', $request->get('tomail'));
        	}        	
        	$xml->subject = $request->get('subject');        	
        	$xml->mode = $request->get('mode');
        	$xml->host = $request->get('host');
        	$xml->port = $request->get('port');
        	$xml->user = $request->get('user');
        	if (is_array($request->get('validate'))) {
        		$xml->validate = implode(',', $request->get('validate'));
        	}        	
        	$xml->mail = $request->get('mail');
        	
        	$xml = $xml->asXML();
        	
        	$fp = fopen($config_file, 'wb');
        	fwrite($fp, $xml);
        	fclose($fp);
        }
	}

	/**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
	public static function personalConfig(Typecho_Widget_Helper_Form $form){}
	
	/**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
	public static function render($contents, $inst)
	{
		$db = Typecho_Db::get();
		$options = Typecho_Widget::widget('Widget_Options');
		$configs = Helper::options()->plugin('AutoBackup');
		
		$current = Typecho_Date::gmtTime();		//当前时间
		
		$config_file = dirname(__FILE__).'/config.xml';
		$xml = simplexml_load_file($config_file);
		$lasttime = intval($xml->lasttime);
		
		$file_path = dirname(__FILE__)."/backupfiles/TypechoAutoBackup".date("Ymd", $current).".sql";
		if (file_exists($file_path) || $lasttime < 0 || ($current - $lasttime) < $configs->circle * 24 * 60 * 60) {		//如果已经存在当日的备份文件，则直接返回
			return $contents;
		}else {
			$tables = $configs->tables;
			$tables = explode(",", $tables);
			
			$sql = self::creat_sql($tables);	//获取备份语句
			
			file_put_contents($file_path, $sql);
			
			$xml->lasttime = $current;
			$xml = $xml->asXML();			
	    	$fp = fopen($config_file, 'wb');
	    	fwrite($fp, $xml);
	    	fclose($fp);
			
			//将备份文件发送至设置的邮箱
			if ($configs->tomail[0]) {
				$smtp = array();
				$smtp['site'] = $options->title;
				$smtp['attach'] = $file_path;
				$smtp['attach_name'] = "TypechoAutoBackup".date("Ymd", $current).".sql";
				$smtp['mode'] = $configs->mode;
	
				//获取SMTP设置
				$smtp['user'] = $configs->user;
				$smtp['pass'] = $configs->pass;
				$smtp['host'] = $configs->host;
				$smtp['port'] = $configs->port;
	
				//获取验证信息
				if (is_array($configs->validate)) {
					if(in_array('validate', $configs->validate)){
						$smtp['validate']=true;
					}
					if(in_array('ssl', $configs->validate)){
						$smtp['ssl']=true;
					}
				}
	
				$format = "format";
	
				$smtp['AltBody'] = "这是从".$smtp['site']."由Typecho AutoBackup插件自动发送的数据库备份文件";
				$smtp['body'] = "该邮件由您的Typecho博客<a href=\"{$options->siteUrl}\">".$smtp['site']."</a>使用的插件AutoBackup发出<br />
								如果你没有做相关设置，请联系邮件来源地址".$smtp['user']."<br />
								发现插件bug请联系i@zhoumiao.com或访问插件<a href=\"http://www.zhoumiao.com/archives/automatic-database-backup-plug-in-for-typecho-0-8\">更新地址</a>";
				if ($configs->subject != "") {
					$smtp['subject'] = date("Ymd").'-'.$configs->subject.'-数据库备份文件';
				}else {
					$smtp['subject'] = date("Ymd").'-'.$options->title.'-数据库备份文件';
				}			
	
				if($configs->mail != "") {
					$email_to=$configs->mail;
				}else {
					$select = Typecho_Widget::widget('Widget_Abstract_Users')->select()->where('uid',1);
					$result = $db->query($select);
					$row = $db->fetchRow($result);
					$email_to = $row['mail'];
				}
	
				$smtp['to']=$email_to;
				$smtp['from']=$email_to;
	
				$issend = self::SendMail($smtp);
				if($issend){
					unlink($file_path);
				}
				
				return $contents;
			}else {
				return $contents;
			}
		}
	}
	
	/**
	 * 生成备份sql语句
	 *
	 * @param string $tables
	 */
	public static function creat_sql($tables){
		$db = Typecho_Db::get();
		$prefix = $db->getPrefix();
		$sql = "-- Typecho AutoBackup\r\n-- version 1.0.6\r\n-- http://zhoumiao.com\r\n-- 生成日期: ".date("Y年m月d日 H:i:s")."\r\n-- 使用说明：创建一个数据库，然后导入文件\r\n\r\n";

		foreach ($tables as $table) {		//循环获取数据库中数据
			$sql .= "\r\nDROP TABLE IF EXISTS ".$prefix.$table.";\r\n";
			$create_sql = $db->fetchRow($db->query("SHOW CREATE TABLE `".$prefix.$table."`"));
			$sql .= $create_sql['Create Table'].";\r\n";
			$result = $db->query($db->select()->from('table.'.$table));
			while ($row = $db->fetchRow($result)) {
				foreach ($row as $key=>$value) {	//每次取一行数据
					$keys[] = "`".$key."`";		//字段存入数组
					$values[] = "'".addslashes($value)."'";		//值存入数组
				}
				$sql .= "insert into `".$prefix.$table."` (".implode(",", $keys).") values (".implode(",", $values).");\r\n";	//生成插入语句

				//清空字段和值数组
				unset($keys);
				unset($values);
			}
		}
		return $sql;
	}
	
	 /**
     * 发送邮件
     *
     * @access public
     * @param array $smtp 邮件信息
     * @return void
     */
    public static function SendMail($smtp) {
        require_once('class.phpmailer.php');
        $mail  = new PHPMailer(); // defaults to using php "mail()"
        $mail->CharSet = "UTF-8";
        $mail->Encoding = 'base64';
        switch ($smtp['mode'])
        {
            case 'mail':
                break;
            case 'sendmail':
                $mail->IsSendmail();
                break;
            case 'smtp':
                $mail->IsSMTP();
                if($smtp['validate']){
                	$mail->SMTPAuth   = true;
                }
                if($smtp['ssl']){
                	$mail->SMTPSecure = "ssl";
                }
                $mail->Host = $smtp['host'];
                $mail->Port = $smtp['port'];
                $mail->Username = $smtp['user'];
                $mail->Password = $smtp['pass'];
                $smtp['from'] = $smtp['user'];
                break;
        }

        $mail->SetFrom($smtp['from'], $smtp['site']);
        $mail->Subject = $smtp['subject'];
        $mail->AltBody = $smtp['AltBody'];
        $mail->MsgHTML($smtp['body']);
        $address = $smtp['to'];
        $mail->AddAddress($address,'');
        $mail->AddAttachment($smtp['attach'], $smtp['attach_name']);

        if(!$mail->Send()) {
          return false;
        }else{
        	return true;
        }
    }
}
