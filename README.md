google  firebase fcm PHP  
h5 notification 可由php进行消息推送 



安装
```sql
composer require morriszhao/firebase-fcm
```

使用

客户端获取token：
````
需要翻墙!!!

1、首先到firebase 控制台创建自己的 fireabase项目：A

2、转到项目设置->常规  将项目A firebaseConfig 参数 填写到 html/index.html  html/firebase-messaging-sw.js 相应位置

3、转到项目设置->云消息传递  在下方的网络配置  点击生成私钥  然后将公钥 填写到 html/index.html的usePublicVapidKey()

4、 运行 index.html  生成注册令牌(由于google的限制  必须是https  或者localhost   测试时将localhost 指向html/index.html)

````

服务端推送：
```sql
具体查看  test/index.php
```



