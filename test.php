<?php

require __DIR__ . '/vendor/autoload.php';

$test = new Monolog\Logger('test');
$test->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__. '/test.log', Monolog\Logger::DEBUG));
$ari = new Ari\Ari([
    'base_uri' => 'http://153.120.168.153:8088/ari',
    'username' => 'asterisk',
    'password' => 'asterisk',
], $test);

$ari->connect('test');
exit;

$ari->onOpen(function () {
    echo "開く";
});

$ari->onClose(function () {
    echo "閉じる";
});

$ari->onStasisStart(function ($event) {

});

//
//$ari->on(Ari\Events\Event::STASIS_START, function ($event, $conn) {
////    echo get_class($conn);
////    var_dump($event->getChannel());
//});
$ari->run();
//$val = $ari->asterisk()->getInfo([]);
//var_dump($val);
//foreach ($val as $v) {
//    var_dump($v);
//}