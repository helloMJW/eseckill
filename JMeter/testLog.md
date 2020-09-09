### 测试环境 vbox+docker

#### 服务器环境
main server                   SWOOLE_WEB
listen address                0.0.0.0
listen port                   9501
ip@eth0                       172.20.0.6
worker_num                    12
reload_async                  true
max_wait_time                 3
log_level                     0
pid_file                      /var/www/eseckill/Temp/pid.pid
log_file                      /var/www/eseckill/Log/swoole.log
user                          nobody
daemonize                     false
swoole version                4.4.12
php version                   7.2.15
easy swoole                   3.3.7





### 1核1G 2078.61 [#/sec]

ab -c 500 -n 1000 http://192.168.3.67:9501/api/seckill/order/testHttp



Server Software:        EasySwoole
Server Hostname:        192.168.3.67
Server Port:            9501

Document Path:          /api/seckill/order/testHttp
Document Length:        44 bytes

Concurrency Level:      500
Time taken for tests:   0.481 seconds
Complete requests:      1000
Failed requests:        0
Total transferred:      205000 bytes
HTML transferred:       44000 bytes
Requests per second:    2078.61 [#/sec] (mean)
Time per request:       240.545 [ms] (mean)
Time per request:       0.481 [ms] (mean, across all concurrent requests)
Transfer rate:          416.13 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    4   4.6      2      15
Processing:    20  117  77.6     96     356
Waiting:       20  117  77.6     96     355
Total:         28  121  78.1     99     364

Percentage of the requests served within a certain time (ms)
  50%     99
  66%    112
  75%    135
  80%    142
  90%    299
  95%    316
  98%    354
  99%    358
 100%    364 (longest request)



### 2核1G 4054.02 [#/sec]

Server Software:        EasySwoole
Server Hostname:        192.168.3.67
Server Port:            9501

Document Path:          /api/seckill/order/testHttp
Document Length:        44 bytes

Concurrency Level:      500
Time taken for tests:   0.247 seconds
Complete requests:      1000
Failed requests:        0
Total transferred:      205000 bytes
HTML transferred:       44000 bytes
Requests per second:    4054.02 [#/sec] (mean)
Time per request:       123.335 [ms] (mean)
Time per request:       0.247 [ms] (mean, across all concurrent requests)
Transfer rate:          811.59 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    8   4.5      9      19
Processing:     6   88  52.7     65     206
Waiting:        6   87  52.7     65     206
Total:         21   96  53.0     73     224

Percentage of the requests served within a certain time (ms)
  50%     73
  66%    106
  75%    120
  80%    157
  90%    191
  95%    198
  98%    206
  99%    215
 100%    224 (longest request)

### 3核1G 5082.49 [#/sec]

Server Software:        EasySwoole
Server Hostname:        192.168.3.67
Server Port:            9501

Document Path:          /api/seckill/order/testHttp
Document Length:        44 bytes

Concurrency Level:      500
Time taken for tests:   0.197 seconds
Complete requests:      1000
Failed requests:        0
Total transferred:      205000 bytes
HTML transferred:       44000 bytes
Requests per second:    5082.49 [#/sec] (mean)
Time per request:       98.377 [ms] (mean)
Time per request:       0.197 [ms] (mean, across all concurrent requests)
Transfer rate:          1017.49 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        1   11   4.4     12      18
Processing:     9   64  31.6     63     153
Waiting:        9   63  31.6     63     153
Total:         12   74  31.4     75     164

Percentage of the requests served within a certain time (ms)
  50%     75
  66%     87
  75%     95
  80%    101
  90%    117
  95%    124
  98%    149
  99%    158
 100%    164 (longest request)



### 4核1G 7504.24 [#/sec]   10089.09 [#/sec]

Server Software:        EasySwoole
Server Hostname:        192.168.3.67
Server Port:            9501

Document Path:          /api/seckill/order/testHttp
Document Length:        44 bytes

Concurrency Level:      500
Time taken for tests:   0.133 seconds
Complete requests:      1000
Failed requests:        0
Keep-Alive requests:    1000
Total transferred:      210000 bytes
HTML transferred:       44000 bytes
Requests per second:    7504.24 [#/sec] (mean)
Time per request:       66.629 [ms] (mean)
Time per request:       0.133 [ms] (mean, across all concurrent requests)
Transfer rate:          1538.96 [Kbytes/sec] received



### 测试工具&测试参数

### ab

Concurrency Level:      500
Time taken for tests:   0.593 seconds
Complete requests:      1000
Failed requests:        0
Total transferred:      205000 bytes
HTML transferred:       44000 bytes
Requests per second:    1685.99 [#/sec] (mean)
Time per request:       296.561 [ms] (mean)
Time per request:       0.593 [ms] (mean, across all concurrent requests)
Transfer rate:          337.53 [Kbytes/sec] received

JMeter

| 测试工具 | 并发数 | 次数 | 持续时间 | 样本数量 | 平均值 | 最低值 | 最大值 | 错误率 | 


### webbench

1264.833333333333

127732   2128.866666666667

#### 硬件环境2
- 2核1G

#### 硬件环境3
- 3核1G

#### 硬件环境4
- 4核1G

测试 hello world 输出

easyswoole 

Connection timed out: connect  0.03%异常出现


测试读取数据


测试写入数据


测试更新数据


测试读取写入数据







## 被测试服务器

>  vbox虚拟机中的docker中的easyswoole

- cpu 2核
- 内存 2G
- 接口地址: /api/seckill/order



| 测试时间              | 线程数 | Ramp-up/s | 延迟创建直到需要 | 调度器 | 持续时间 | 启动延迟 | 常量吞吐量定时器 | 平均值 | 吞吐量     |
| --------------------- | ------ | --------- | ---------------- | ------ | -------- | -------- | ---------------- | ------ | ---------- |
| 2020年8月14日10:10:31 | 100    | 1         | Y                | Y      | 60       |          |                  | 73     | 1348.5/sec |
| 2020年8月14日10:24:27 | 100    | 1         | Y                | Y      | 60       |          |                  | 71     | 1373.5/sec |
| 2020年8月14日10:57:17 | 200    | 1         | Y                | Y      | 60       |          |                  | 168    | 1167.2/sec |
| 2020年8月14日10:59:34 | 200    | 1         | Y                | Y      | 60       |          |                  | 203    | 969.9/sec  |
| 2020年8月14日11:22:44 | 200    | 1         | Y                | Y      | 60       |          |                  | 140    | 1399.4/sec |
| 2020年8月14日11:29:59 | 200    | 1         | Y                | Y      | 120      |          |                  | 144    | 1372.6/sec |
| 2020年8月14日13:48:35 | 200    | 1         | Y                | Y      | 60       |          |                  | 144    | 1362.1/sec |


- 接口地址: /api/seckill/order/testHttp

| 测试时间              | 线程数 | Ramp-up/s | 延迟创建直到需要 | 调度器 | 持续时间 | 启动延迟 | 常量吞吐量定时器 | 平均值 | 吞吐量     |
| --------------------- | ------ | --------- | ---------------- | ------ | -------- | -------- | ---------------- | ------ | ---------- |
| 2020年8月14日10:10:31 | 100    | 1         | Y                | Y      | 60       |          |                  | 18     | 5418.8/sec |
| 2020年8月14日12:22:00 | 200    | 1         | Y                | Y      | 60       |          |                  | 34     | 5700.6/sec |
| 2020年8月14日12:24:03 | 300    | 1         | Y                | Y      | 60       |          |                  | 51     | 5799.1/sec |
| 2020年8月14日12:39:53 | 400    | 1         | Y                | Y      | 60       |          |                  | 67     | 5851.0/sec |
| 2020年8月14日13:38:00 | 500    | 1         | Y                | Y      | 60       |          |                  | 82     | 6037.1/sec |
| 2020年8月14日13:43:13 | 600    | 1         | Y                | Y      | 60       |          |                  | 121    | 4888.3/sec |
| 2020年8月14日13:45:28 | 500    | 1         | Y                | Y      | 60       |          |                  | 83     | 5944.4/sec |



## 被测试服务器2

>  vbox虚拟机中的docker中的easyswoole

- cpu 4核
- 内存 2G
- 接口地址: /api/seckill/order



| 测试时间              | 线程数 | Ramp-up/s | 延迟创建直到需要 | 调度器 | 持续时间 | 启动延迟 | 常量吞吐量定时器 | 平均值 | 吞吐量     |
| --------------------- | ------ | --------- | ---------------- | ------ | -------- | -------- | ---------------- | ------ | ---------- |
| 2020年8月14日13:58:45 | 200    | 1         | Y                | Y      | 60       |          |                  | 92     | 2142.5/sec |


>  vbox虚拟机中的docker中的easyswoole

- cpu 4核
- 内存 2G
- worker_num 8
- 接口地址: /api/seckill/order

- 接口地址: /api/seckill/order/testHttp

| 测试时间              | 线程数 | Ramp-up/s | 延迟创建直到需要 | 调度器 | 持续时间 | 启动延迟 | 常量吞吐量定时器 | 平均值 | 吞吐量     |
| --------------------- | ------ | --------- | ---------------- | ------ | -------- | -------- | ---------------- | ------ | ---------- |
| 2020年8月14日14:03:00 | 500    | 1         | Y                | Y      | 60       |          |                  | 63     | 7465.5/sec |


>  vbox虚拟机中的docker中的easyswoole

- cpu 4核
- 内存 2G
- worker_num 4
- 接口地址: /api/seckill/order/testHttp

| 测试时间              | 线程数 | Ramp-up/s | 延迟创建直到需要 | 调度器 | 持续时间 | 启动延迟 | 常量吞吐量定时器 | 平均值 | 吞吐量      |
| --------------------- | ------ | --------- | ---------------- | ------ | -------- | -------- | ---------------- | ------ | ----------- |
| 2020年8月14日14:03:00 | 500    | 1         | Y                | Y      | 60       |          |                  | 63     | 7465.45/sec |

>  vbox虚拟机中的docker中的easyswoole

- cpu 4核
- 内存 2G
- worker_num 2
- 接口地址: /api/seckill/order/testHttp

| 测试时间              | 线程数 | Ramp-up/s | 延迟创建直到需要 | 调度器 | 持续时间 | 启动延迟 | 常量吞吐量定时器 | 异常  | 平均值 | 吞吐量     |
| --------------------- | ------ | --------- | ---------------- | ------ | -------- | -------- | ---------------- | ----- | ------ | ---------- |
| 2020年8月14日14:49:37 | 500    | 1         | Y                | Y      | 60       |          |                  | 0.51% | 197    | 2471.4/sec |
| 2020年8月14日15:03:32 | 500    | 1         | Y                | Y      | 60       |          |                  | 0.04% | 97     | 4842.1/sec |
| 2020年8月14日15:05:58 | 500    | 1         | Y                | Y      | 60       |          |                  | 0.01% | 79     | 5376.9/sec |
| 2020年8月14日15:24:18 | 500    | 1         | Y                | Y      | 60       |          |                  |       | 83     | 5261.9/sec |
| 2020年8月14日15:26:20 | 500    | 1         | Y                | Y      | 60       |          |                  | 0.05% | 79     | 5768.4/sec |
| 2020年8月14日15:29:12 | 500    | 1         | Y                | Y      | 60       |          |                  |       | 79     | 5770.2/sec |

>  vbox虚拟机中的docker中的easyswoole

- cpu 4核
- 内存 2G
- worker_num 1
- 接口地址: /api/seckill/order/testHttp

| 测试时间              | 线程数 | Ramp-up/s | 延迟创建直到需要 | 调度器 | 持续时间 | 启动延迟 | 常量吞吐量定时器 | 异常 | 平均值 | 吞吐量     |
| --------------------- | ------ | --------- | ---------------- | ------ | -------- | -------- | ---------------- | ---- | ------ | ---------- |
| 2020年8月14日15:20:04 | 500    | 1         | Y                | Y      | 60       |          |                  |      | 111    | 4298.6/sec |
| 2020年8月14日15:22:11 | 500    | 1         | Y                | Y      | 60       |          |                  |      | 107    | 4590.2/sec |
| 2020年8月14日15:32:50 | 500    | 1         | Y                | Y      | 60       |          |                  |      | 102    | 4832.4/sec |

>  vbox虚拟机中的docker中的easyswoole

- cpu 4核
- 内存 2G
- worker_num 12
- 接口地址: /api/seckill/order/testHttp

| 测试时间              | 线程数 | Ramp-up/s | 延迟创建直到需要 | 调度器 | 持续时间 | 启动延迟 | 常量吞吐量定时器 | 异常 | 平均值 | 吞吐量     |
| --------------------- | ------ | --------- | ---------------- | ------ | -------- | -------- | ---------------- | ---- | ------ | ---------- |
| 2020年8月14日15:44:35 | 500    | 1         | Y                | Y      | 60       |          |                  |      | 61     | 7583.3/sec |
| 2020年8月14日15:51:59 | 500    | 1         | Y                | Y      | 60       |          |                  |      | 62     | 7231.2/sec |

### tp6

500 60秒  出现错误有 502 Bad Gateway   、  504 Gateway Time-out



