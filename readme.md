# 学习自测网站Learning

基于Laravel5.5的管理系统

## 服务器要求
本系统基于Laravel 5.5开发完成，Laravel 框架会有一些系统上的要求。当然，这些要求在 Laravel Homestead 虚拟机上都已经完全配置好了。所以，非常推荐你使用 Homestead 作为你的本地 Laravel 开发环境。
如果你没有使用 Homestead ，你需要确保你的服务器上安装了下面的几个拓展：
```
PHP >= 7.1.0
OpenSSL PHP Extension
PDO PHP Extension
Mbstring PHP Extension
Tokenizer PHP Extension
XML PHP Extension
FileInfo PHP Extension
composer
node
npm
mysql >= 5.7
```   
## 安装前准备
### 1.composer
本系统需要使用composer包管理系统，
#### 下载[composer](https://getcomposer.org/download/)

### 2.npm包管理工具
#### 推荐[链接在此](http://www.runoob.com/nodejs/nodejs-npm.html)

## 下载
不是composer包,所以不能使用composer require
需要打包下载所有程序
```shell
git clone https://github.com/niuran/learning.git
```

## 安装
#### 1.修改配置文件
##### 1.1 拷贝
```shell
copy .env.example .env
```
##### 1.2 修改配置
```shell
1. 应用URL地址
APP_URL
2. 修改数据库配置 
DB_CONNECTION
DB_HOST
DB_PORT
DB_DATABASE
DB_USERNAME
DB_PASSWORD
DB_PREFIX
```

#### 2.程序依赖安装
执行
```shell
composer install
```


#### 3.数据迁移
```shell
php artisan migrate
```


#### 4.前台资源 (选)
```shell
npm install
```

#### 4.1.前台资源编译
##### ① 生产环境
```shell
npm run production
```
##### ② 开发环境
```shell
npm run dev
```
**监听**
```
npm run watch
```
可用参数
```shell
watch-poll
hot
```

