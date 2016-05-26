<?php
/**
 * 封装PDO类
 * @copyright 2016
 * @author 0x584A <xjiek2010@icloud.com>
 * @link jgeek.cn
 */
class Model
{
    // 数据库类型
    public $type;
    // 主机地址
    public $host;
    // 端口号
    public $port;
    // 数据库帐号
    public $user;
    // 数据库密码
    public $pass;
    // 数据库名称
    public $dbname;
    // 数据库编码
    public $charset;
    // 用于保存PDO对象，用于跨方法使用
    public $pdo;
    // 表前缀
    public $prefix;

    // 增加常量
    const ERRMODE_SILENT = 0;

    const ERRMODE_WARNING = 1;

    const ERRMODE_EXCEPTION = 2;

    /**
     * 构造函数 初始化属性及值
     *
     * @param 保存类属性的数组 $dbinfo
     */
    public function __construct($dbinfo = array())
    {

        // 初始化属性值
        $this->type    = isset($dbinfo['type']) ? $dbinfo['type'] : 'mysql';
        $this->host    = isset($dbinfo['host']) ? $dbinfo['host'] : $GLOBALS['config']['mysql']['host'];
        $this->port    = isset($dbinfo['port']) ? $dbinfo['post'] : $GLOBALS['config']['mysql']['port'];
        $this->user    = isset($dbinfo['user']) ? $dbinfo['user'] : $GLOBALS['config']['mysql']['user'];
        $this->pass    = isset($dbinfo['pass']) ? $dbinfo['pass'] : $GLOBALS['config']['mysql']['pass'];
        $this->dbname  = isset($dbinfo['dbname']) ? $dbinfo['dbname'] : $GLOBALS['config']['mysql']['dbname'];
        $this->charset = isset($dbinfo['charset']) ? $dbinfo['charset'] : $GLOBALS['config']['mysql']['charset'];
        $this->prefix  = isset($dbinfo['prefix']) ? $dbinfo['prefix'] : $GLOBALS['config']['mysql']['prefix'];
        // 连接数据库
        $this->db_conn();
        // 选择抛出异常模式
        $this->db_setMode();
    }

    /**
     * 连接数据库
     */
    private function db_conn()
    {
        try {
            $dsn       = "{$this->type}:host={$this->host};port={$this->port};dbname={$this->dbname};";
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
        } catch (PDOException $e) {
            $this->db_error($e);
        }
    }

    // 选择错误处理模式
    // @param1 int $mode = 0,选择的模式,默认是静默模式
    private function db_setMode($mode = 2)
    {
        // 通过常量来判断到底设定什么模式
        switch ($mode) {
            case 1:

                // 警告模式
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_WARNING);
                break;
            case 2:

                // 异常模式
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION);
            default:

                // 静默模式
                break;
        }
    }

    /**
     * 抛出错误信息
     *
     * @param PDOException $e
     */
    private function db_error(PDOException $e)
    {
        echo '出错了！！！<br />';
        echo '错误文件：', $e->getFile(), '<br />';
        echo '错误行号：', $e->getLine(), '<br />';
        echo '错误编码：', $e->getCode(), '<br />';
        echo '错误详情：', $e->getMessage(), '<br />';
        exit('END...');
    }

    /**
     * 执行SQL查询并返回一条记录
     *
     * @param SQL语句 $sql
     * @return array 返回结果数组、无记录返回Fales
     */
    public function db_getOne($sql)
    {
        try {
            $temp = $this->pdo->query($sql);
            $temp = $temp->fetch(PDO::FETCH_ASSOC);

            // //当查询无结果时主动抛出异常
            // if(!$temp){
            //     echo '<pre>';
            //     exit(new PDOException());
            // }

            return $temp;
        } catch (PDOException $e) {
            $this->db_error($e);
        }
    }

    /**
     * 执行SQL查询返回所有结果
     *
     * @param String $sql
     * @return array 返回数组结果集、无记录返回Fales
     */
    public function db_getAll($sql)
    {
        try {
            $rows = $this->pdo->query($sql);
            $rows = $rows->fetchAll(PDO::FETCH_ASSOC);

            //当查询无结果时主动抛出异常
            // if(!$rows){
            //     echo '<pre>';
            //     exit(new PDOException());
            // }

            return $rows;
        } catch (PDOException $e) {
            $this->db_error($e);
        }
    }

    /**
     * 执行SQL语句返回自增长ID或受影响行数
     *
     * @param Stirng $sql
     */
    public function db_insert($sql)
    {
        try {
            $res = $this->pdo->exec($sql);

            $id = $this->pdo->lastInsertId();

            return $id ? $id : $res;
        } catch (PDOException $e) {
            $this->db_error($e);
        }
    }

    /**
     * [构造表全名]
     * @param string $table 要构造的表全名，默认空，表示使用属性
     * @return string 表全名
     */
    public function getTableNmae($table = '')
    {
        // 将表名和表前缀进行链接
        if ($table == '') {
            return $this->prefix . $this->table;
        } else {
            return $this->prefix . $table;
        }

    }
}
