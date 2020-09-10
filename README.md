# eseckill

> 基于easyswoole秒杀系统

### 环境说明

[docker部署](https://github.com/helloMJW/docker)

### 项目功能

- [x] 用户登录接口
- [x] 用户注册接口
- [x] 获取个人信息接口
- [ ] 添加地址接口
- [ ] 删除地址接口
- [ ] 秒杀订单
- [ ] 发送邮件

---------------------

- [ ] nginx代理负载均衡
- [ ] MySQL主从同步
- [ ] MySQL-mycat 集群
- [ ] redis集群
- [ ] kafka消息队列

### 秒杀版本

- [x] MySQL版本 mysql
- [x] 事务锁版本 transaction
- [ ] 文件锁版本 file
- [ ] redis版本 redis 
- [ ] 限流版本 limit
- [ ] 消息队列版本 queue
- [ ] 分布式版本 dispersed
- [ ] 分布式集群版本 colony

### 文档说明

[mysql](./Docs/mysql)


### 测试

`./vendor/bin/co-phpunit Test`


### 参考资料



