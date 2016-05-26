-- 建库等初始SQL语句，请新建 db_jwx 数据库后直接运行如下语句即可建库

-- 创建数据库
-- create database db_jwx;

-- 进入数据库
-- use db_jwx;

-- 设置字符sql录入字符编码
-- set names utf8;

-- 后台用户表
CREATE TABLE IF NOT EXISTS `db_jwx`.`t_admin` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `username` VARCHAR(32) NOT NULL COMMENT '登录帐号',
  `password` CHAR(32) NOT NULL COMMENT '登录密码',
  `name` VARCHAR(24) NOT NULL DEFAULT '匿名' COMMENT '用户名称',
  `createtime` INT UNSIGNED NOT NULL COMMENT '创建时间',
  `logintime` INT UNSIGNED NOT NULL COMMENT '上次登录时间',
  `login_ip` CHAR(10) NOT NULL DEFAULT '0' COMMENT '登录ip',
  `state` TINYINT(1) UNSIGNED NULL DEFAULT 0 COMMENT '帐号状态',
  `sale` CHAR(6) NULL DEFAULT 0 COMMENT '加盐',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin
COMMENT = '用户帐号表';

-- 插入用户数据
INSERT INTO t_admin() VALUES(null,'admin','cb46986eea5cd974305a21af14fadbf9','阿杰',1457954053,1457954053,2130706433,0,'abc123');
