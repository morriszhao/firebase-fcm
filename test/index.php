<?php

use zhaolm\phpfcm\Client;
use zhaolm\phpfcm\Message;
use zhaolm\phpfcm\Notification;
use zhaolm\phpfcm\Recipient\Device;
use zhaolm\phpfcm\Recipient\Topic;
use zhaolm\phpfcm\TopicOption;

require_once 'vendor/autoload.php';


echo '<pre>';
//由于调用firebase服务 需要进行翻墙、  此处请改成你的翻墙代理
putenv('HTTPS_PROXY=http://127.0.0.1:8580');




//项目设置->云消息传递->服务器秘钥
$apiKey = '';
//浏览器注册token
$device = '';

$client = new Client();
$client->setApiKey($apiKey);
$client->injectHttpClient(new \GuzzleHttp\Client(['verify'=>false]));


/**
 * 单个 发送
 */
$note = new Notification('nihao', 'zhangsan');
$note->setColor('#ffffff')
    ->setBadge(1);
$message = new Message();
$message->addRecipient(new Device($device));

/**
 * tag  点击跳转页面
 */
$message
    ->setData(array(
        'title' => 'zhangsan',
        'content' => 'helo  shopping!!!',
        'tag' => 'https://www.baidu.com',
        'icon' => 'https://us01.imgcdn.ymcart.com/24456/2018/03/16/d/0/d029b4ca1110e509.ico',
        'image' => 'https://24073_kuajingcrm.cn01-apps.ymcart.com/res/manage/default/tpl/kuajingcrm/template/newsletter/newsletter_078/thumb.jpg'

    ));
$reponse = $client->send($message);


/**
 * topic 发送
 */
$note = new Notification('test title', 'testing body');
$note->setColor('#ffffff')
    ->setBadge(1);
$message = new Message();
$message->addRecipient(new Topic('news'));
$message->setNotification($note)
    ->setData(array(
        'title' => 'zhangsan',
        'content' => 'zhangsan  nighaoma ?'
    ));
//$reponse = $client->send($message);


/**
 * 将注册令牌添加到主题
 */
$topic = new TopicOption('news');
$topic->addDevice([
    $device,
    $device,
    $device
]);
$client->setProxyApiUrl($topic->getSubscribeUrl());
//$reponse = $client->send($topic);


/**
 * 从topic删除 注册令牌
 */

$topic = new TopicOption('news');
$topic->addDevice([
    $device,
    $device
]);
$client->setProxyApiUrl($topic->getUnSubscribeUrl());
//$reponse = $client->send($topic);


var_dump($reponse->getBody()->getContents());