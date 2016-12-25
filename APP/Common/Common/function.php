<?php
/**
 * 权限验证
 * @param rule string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
 * @param uid  int           认证用户的id
 * @param string mode        执行check的模式
 * @param relation string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
 * @return boolean           通过验证返回true;失败返回false
 */
	function authCheck($rule,$uid,$mode='url', $relation='or'){
		//超级管理员跳过验证
		if(in_array($uid, C('ADMINISTRATOR'))){
			return true;
		}else{
			$auth=new \Think\Auth();
			//设置的是一个用户对应一个角色组,所以直接取值.如果是对应多个角色组的话,需另外处理
			return $auth->check($rule,$uid,1,$mode,$relation)?true:false;
		}
	}
/**
 * 邮件发送函数
 * @param to string   		发送对方邮件的地址
 * @param title string   		邮件主题
 * @param content string   		邮件内容 
 */
    function sendMail($to, $title, $content) {
       
       	// Vendor('PHPMailer.class#PHPMailer');
       	import("phpmail.PHPMailer");
        $mail = new PHPMailer(); //实例化
        // $mail = new \Vendor\PHPMailer\PHPMailer();
        $mail->IsSMTP(); // 启用SMTP
        $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
        $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
        $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
        $mail->Password = C('MAIL_PASSWORD') ; //邮箱密码
        $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
        $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
        $mail->AddAddress($to);
        $mail->WordWrap = 50; //设置每行字符长度
        $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
        $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
        $mail->Subject =$title; //邮件主题
        $mail->Body = $content; //邮件内容
        $mail->AltBody = ""; //邮件正文不支持HTML的备用显示
        return($mail->Send());
    }
/** 

?>