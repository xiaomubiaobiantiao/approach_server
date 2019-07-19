<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
    public function login(){
        $password=$this->password;
        $user=$this->where("username='{$this->username}'")->find();
        if($user){
            //把数据库中的密码和表单中的密码比较
            if($this->password==md5($password)){
                //登陆成功
                session('id',$user['id']);
                session('username',$user['username']);
              
                return TRUE;
            }
            else
                return -2;
        }
        else
            return -1;
    }
    //取出权限到session
    public function putPriDataToSession($role_id){
        $roleModel=M('Role');
        $roleModel->find($role_id);
        $priModel=M('Privilege');
        if($roleModel->pri_id=='*'){
            //高校身份
           $priData=$priModel->select();
            session('privilege',$priData);
        }else{
            $priData=$priModel->select($roleModel->pri_id);
            session('privilege',$priData);
        }

    }
    //退出
    public function logout(){
        session(null);
    }
}
?>