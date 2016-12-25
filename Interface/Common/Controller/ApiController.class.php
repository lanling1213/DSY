<?php
/**
 * Api公共类
 */
namespace Common\Controller;
use Think\Controller;

class ApiController extends Controller
{
    protected $userStuID = null;
    protected $userTeaID = null;

    public function _initialize()
    {
        //验证token
        $token = I('request.token');
        $stu_user = I('request.stu_user');
        $tea_user = I('request.tea_user');
        if($stu_user)
        {
            $vToken = myDes_decode($token,$stu_user);
            $arrStr = explode('|',$vToken);
            if($stu_user && $arrStr[0] === $stu_user) $this->userStuID = $arrStr[1];
            else $this->myApiPrint('user name error !');
        }
        else if($tea_user)
        {
            $tToken = myDes_decode($token,$tea_user);
            $teaStr = explode('|',$tToken);
            if($tea_user && $teaStr[0] === $tea_user) $this->userTeaID = $teaStr[1];
            else $this->myApiPrint('user name error!');
        }
        else
            $this->myApiPrint('user name error!');
    }

/*
 *检查用户账号
 *@return 混合模型
 * */
    public function checkUserAccount($user,$t=0){
//        if(!preg_match("/1[3578]{1}\d{9}$/",$user)){
//            $this->myApiPrint('手机号码格式不对');
//        }
        $where['stu_user'] = $user;
        $owner = M('student');
        $resn = $owner->where($where)->find();
        if($t==1&&!$resn){
            $this->myApiPrint('非法请求，账号不存在');
        }
        return $resn;
    }

/**
 * 公共错误返回
 * @param $msg 需要打印的错误信息
 * @param $code 默认打印300信息
 */
    public function myApiPrint($msg='',$code=300,$data=''){
        $result = array(
            'code' => $code,
            'msg' => $msg,
            'result' => $data
        );
        $this->ajaxReturn($result);exit;
    }

/*
 * 检查数组是否为空
 * */
    public function arrIsEmpty($arr)
    {
        foreach($arr as $v)
        {
            if(empty($v)) return true;
        }
    }
	
/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 * @param $para 需要拼接的数组
 * return 拼接完成以后的字符串
 */
    function myParaLinkstring($para) {
        $arg  = "";
        while (list ($key, $val) = each ($para)) {
            $arg.=$key."=".$val."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);

        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}

        return $arg;
    }

/**
 * 对数组排序
 * @param $para 排序前的数组
 * return 排序后的数组
 */
    function myArgSort($para) {
        ksort($para);
        reset($para);
        return $para;
    }
}