<?php
/**
* 用户表Model
*/
class AdminModel extends Model
{

    /**
     * 验证登陆用户是否存在
     */
    public function loginis($username)
    {
        $sql = "select * from t_admin where username = '{$username}'";
        $info = $this->db_getOne($sql);
        return $info;
    }

}