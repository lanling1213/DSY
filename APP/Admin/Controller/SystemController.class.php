<?php
/**
 * 后台系统管理
 * 系统配置，系统功能管理
 * 管理员管理
 */
namespace Admin\Controller;
use Common\Controller\AdminController;
class SystemController extends AdminController
{
/*系统管理列表
*/
	public function userList($n = '15')
	{
		$admin = M('system_user');
		$count = $admin->count();
		$Page = new \Think\Page($count, $n);
		$this->Page = $Page->show();
		$list = $admin->alias('us')->join('LEFT JOIN dsy_auth_group_access as aga on aga.uid = us.user_id')
            ->join('LEFT JOIN dsy_auth_group as ag on aga.group_id = ag.id')
            ->field('us.user_id,us.user_name,us.status,us.remark,us.last_login_time,us.last_login_ip,us.last_location,ag.title')
            ->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->list=$list;

		$this->display();
	}

/*显示帐号登录历史信息
*/
    public function LoginLog($user_id)
    {
        if (I('get.user_id','')) {
            $where['userid'] = $user_id;
            $where['status'] = 1;
            //查询数据
            $model = M('user_log');
            $list = $model->field('userid,username,logintime,loginip')->where($where)->order('logintime desc')->select();
            $this->ajaxReturn($list);
        }
    }

/*后台帐号修改
*/
	public function userEdit($user_id = '0')
	{
        if (IS_POST) {
            $admin = M('system_user');
			$us['user_name']=I('post.username');
			$us['remark']=I('post.remark');
			$aga['group_id']=I('post.groupId');

            if (!$admin->create($_POST,2)){
                $this->error($admin->getError());
            }
            if (false!==$admin->where(array('user_id'=>$user_id))->save($us)) {
                //更新角色
                M('auth_group_access')->where(array('uid'=>$user_id))->save($aga);
                $this->addLog('group_id='.$aga['group_id'].'&remark='.$us['remark'].'&user_name='.$us['user_name'].'&user_id='.$user_id,1);// 记录操作日志
                $this->success('编辑管理帐号成功', U('Admin/System/userList'));
            } else {
                $this->addLog('group_id='.$aga['group_id'].'&remark='.$us['remark'].'&user_name='.$us['user_name'].'&user_id='.$user_id,0);// 记录操作日志
                $this->error('编辑管理帐号出错');
            }
		} else {
			$admin = M('system_user');
			//获取帐号信息
			if ($user_id) {
				$info = $admin->alias('us')->join('LEFT JOIN dsy_auth_group_access as aga on us.user_id = aga.uid')
                    ->field('us.user_id,us.user_name,us.status,us.remark,us.last_login_time,us.last_login_ip,us.last_location,aga.uid,aga.group_id,us.province_id,us.city_id')
                    ->find($user_id);
				$this->info = $info;
			}
            $m=M('auth_group');
            $data=$m->where('status=1')->field('id,title')->select();
            $this->data=$data;

			$this->display();
		}
	}

/*修改后台帐号密码
*/
    public function chanPass($user_id) {
        if (IS_POST) {
            $oldPass = I('post.oldpassword', '', 'trim');
            if (empty($oldPass)) {
                $this->error("请输入旧密码！");
            }
            $newPass = I('post.password', '', 'trim');
            $new_PwdConfirm = I('post.password2', '', 'trim');
            if ($newPass != $new_PwdConfirm) {
                $this->error("两次密码不相同！");
            }
            $admin = D('system_user');
            $map = array();
            $map['user_id'] = $user_id;
            $userInfo = $admin->where($map)->find();
            if (empty($userInfo)) {
                $this->error = '该用户不存在！';
            }
            if (!$admin->create($_POST,2)){
                $this->error($admin->getError());
            }
            if (false!==$admin->where('user_id = ' . $user_id)->save()) {
                $this->addLog('user_id='.$user_id,1);// 记录操作日志
                $this->success("密码更新成功！", U("Admin/System/userList"));
            } else {
                $this->addLog('user_id='.$user_id,0);// 记录操作日志
                $this->error("密码更新失败！", U('Admin/System/userList'));
            }
        } else {
            $admin = M('system_user');
            //获取帐号信息
            if ($user_id) {
                $info = $admin->field('user_id,user_name')->find($user_id);
                $this->info = $info;
            }
            $this->display();
        }
    }

/*验证密码是否正确
 */
    public function verifyPass($user_id) {
        if (IS_POST) {
            $Password= I('post.param');
            $UserID= $user_id;
            $map=array();
            $map['password']=md5($Password);
            $map['user_id']=$UserID;
            $UId = M('system_user')->field('password')->where($map)->find();
            if (md5($Password)!==$UId['password']) {
                $jsonData='{
                "info":"原密码不正确，请重新输入！",
                "status":"n"
                }';
                echo $jsonData;
            } else {
                $jsonData='{
                "info":"原密码输入正确,验证通过！",
                "status":"y"
                }';
                echo $jsonData;
            }
        }
        else{
            $jsonData='{
                "info":"对不起，非法操作！",
                "status":"n"
                }';
            echo $jsonData;
        }
    }

/**
 * 管理帐号删除
 */
	public function userDel($user_id = '0')
	{
		$arr = array_diff(explode(',',$user_id),C('ADMINISTRATOR'));
		if(!$arr){
			$this->error("不允许对超级管理员执行该操作!");
		}else{
			$DU = M('system_user');
			$user_id = implode(',',$arr);
			if ($DU->delete($user_id)) {
				$whereAGA['uid'] = array('in',$arr);
				M('auth_group_access')->where($whereAGA)->delete();
				$this->addLog('user_id='.$user_id,1);// 记录操作日志
				$this->success('删除管理帐号成功', U('Admin/System/userList'));
			} else {
				$this->addLog('user_id='.$user_id,0);// 记录操作日志
				$this->success('删除管理帐号错误', U('Admin/System/userList'));
			}
		}
	}

/**
 * 管理帐号新增
 */
	public function userAdd()
	{
		if (IS_POST) {
            //所属角色id
            $groupId=I("post.groupId");
			$admin = D('system_user');
			if (!$admin->create(I('post.'),1)){
				// 如果创建失败 表示验证没有通过 输出错误提示信息
				$this->error($admin->getError());
			}
			if($admin->where(array('user_name'=>I('post.user_name')))->find())$this->error('帐号已存在');
            $uid=$admin->add();
			if ($uid) {
                //用户$uid
                $where['uid']=$uid;
                $where['group_id']=$groupId;
                $g=M("auth_group_access");//角色
                if($g->add($where)) {
                    $this->addLog('user_name='.I('user_name').'&group_id='.$groupId.'&id='.$uid,1);// 记录操作日志
                    $this->success('添加管理帐号成功', U('Admin/System/userList'));
                }
                else
                {
                    $this->addLog('user_name='.I('user_name').'&group_id='.$groupId.'&id='.$uid,0);// 记录操作日志
                    $this->error('添加管理帐号时，权限分配出错');
                }
			} else {
                $this->addLog('user_name='.I('user_name').'&group_id='.$groupId.'&id='.$uid,0);//记录操作日志
				$this->error('添加管理帐号出错');
			}

		} else {
            $m=M('auth_group');
            $data=$m->where('status=1')->field('id,title')->select();
            $this->data=$data;

			$this->display();
		}
	}


/**
 * 帐号状态修改
 */
	public function changeStatus($method=null){
		$user_id = I('get.id',0);
		$arr = array_diff(explode(',',$user_id),C('ADMINISTRATOR'));
		if(!$arr){
			$this->error("不允许对超级管理员执行该操作!");
		}
		$where['user_id'] = $user_id;
		switch ( strtolower($method) ){
			case 'forbiduser'://禁用
				$data['status']    =  0;
				$msg = '已禁用';
				break;
			case 'resumeuser'://启用
				$data['status']   =  1;
				$msg = '已启用';
				break;
			default:
				$this->error('参数非法');
		}

		if(M('system_user')->where($where)->save($data)!==false ) {
			$this->success($msg);
		}else{
			$this->error('操作失败');
		}
	}

	//权限菜单列表
	public function privilegesList($type='5')
	{
		$P = M('privileges');
		$this->type = $type;
		if($type == 3 or $type == 4){
			if($type == 3){
				$privilege_id = explode(',',C('MAINSHOPPRIVILEGES'));
			}elseif ($type == 4) {
				$privilege_id = explode(',',C('SUBSHOPPRIVILEGES'));
			}
			foreach ($privilege_id as $key => $value) {
				if($key){
					$where .=' or privilege_id = '.$value;
				}else{
					$where =' privilege_id = '.$value;
				}
			}
		}
		$list = $P->where($where)->order('sort')->select();
		$this->list = $this->TreeArray($list,'privilege_id');
		$this->display();
	}

	//添加编辑权限菜单
	public function privilegesInfo($privilege_id='0')
	{
		$P = M('privileges');
		if(IS_POST){
			if(!$_POST['is_show']){
				$_POST['is_show'] = '0';
			}
			if($privilege_id){
				unset($_POST['pid']);
				if($P->create() and $P->where('privilege_id = '.$privilege_id)->save()){
					$this->success('修改权限信息成功', U('System/privilegesList'));
				}else{
					$this->error('修改权限信息失败');
				}
			}else{
				if($P->create() and $P->add()){
					$this->success('添加权限信息成功', U('System/privilegesList'));
				}else{
					$this->error('添加权限信息失败');
				}
			}
		}else{
			$this->info = $P->field(true)->find($privilege_id);
			//获取顶级菜单
			$this->PList = $P->where('pid=0')->field(true)->select();
			$this->display();
		}
	}

	//删除权限菜单
	public function delPrivileges($privilege_id)
	{
		$P = M('privileges');
		$count = $P->where('pid = '.$privilege_id)->count();
		if($count){
			$this->error('当前菜单下面还有'.$count.'个权限。不可以删除！');
		}else{
			//这里暂时不放实际删除功能
			$this->success('删除权限菜单成功', U('System/privilegesList'));
		}
	}

	//系统设置，默认公共类型
	public function system($type='1')
	{
		$C = M('config');
		if(IS_POST){
            $this->addLog('type='.$type,0);// 记录操作日志
			$this->error('暂时只允许修改版本号！');
		}else{
			$this->type = $type;
			$this->list = $C->where('config_type = '.$this->type)->select();
			$this->display();
		}
	}
	//系统设置，默认公共类型
	public function upVersion()
	{
		$ver = I('ver');
		if(!I('num')) $this->error('参数错误');
		switch($ver)
		{
			case 1:
				$where['config_field']='APP_IOS_VERSION_FINAL';
				$data['config_value'] = I('num');
				M('config')->where($where)->data($data)->save();
				break;
			case 2:
				$where['config_field']='APP_IOS_VERSION_TEST';
				$data['config_value'] = I('num');
				M('config')->where($where)->data($data)->save();
				break;
			case 3:
				$where['config_field']='APP_ANDROID_VERSION';
				$data['config_value'] = I('num');
				M('config')->where($where)->data($data)->save();
				break;
			default;
				$this->error('参数错误');
				break;
		}
        $this->addLog('config_value='.I('num').'&ver='.$ver,1);// 记录操作日志
		$this->success('版本号更新完毕');
	}


}