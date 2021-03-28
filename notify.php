<?php

require_once 'vendor/autoload.php';
include("helpers.php");
include("sql.php");

// Create the Transport
$transport = (new Swift_SmtpTransport('phpdemo.ru', 25))
    ->setUsername('keks@phpdemo.ru')
    ->setPassword('htmlacademy');

const HOUR = 60 * 60;
const DAY = 60 * 60 * 24;

$sql = "SELECT t.name AS task_name, t.deadline AS deadline, u.email AS user_email FROM tasks t LEFT JOIN users u on u.id = t.user_id WHERE deadline IS NOT NULL AND status = 0 GROUP BY t.user_id ";
$tasks = getAllRows($sql);

// Формированиеее сообщения
$message = (new Swift_Message('Задания которые нужно выполнить сегодня'))
    ->setFrom('keks@phpdemo.ru', 'keks');

// Отправка сообщения
$mailer = new Swift_Mailer($transport);

$setTo = [];
$messageBody = '';
//$tmpEmail = '';
$now = strtotime("now");
//$first = true;
foreach ($tasks as $task) {
    $diff = $now - strtotime($task['deadline']);
    if ($diff <= DAY) {
        /*if ($tmpEmail !== $task['user_email'] && !$first) {
            sendMessage("Здравствуйте, у вас не выполнены следующие задания: <br>", $messageBody,  [$tmpEmail]);
            $messageBody = '';
        }*/
        //$tmpEmail = $task['user_email'];
        var_dump($task['user_email']);
        array_push($setTo, $task['user_email']);
        $messageBody = $messageBody.$task['task_name'].'<br>';
        // $first = false;
    }
}
$messageBody = "Здравствуйте, у вас не выполнены следующие задания: <br>".$messageBody;
$message->setTo($setTo);
$message->setBody($messageBody, 'text/html');

$result = $mailer->send($message);

function sendMessage($messageStart, $messageEnd, $whereToSend)
{
    global $message, $mailer;
    $messageBody = $messageStart.$messageEnd;
    $message->setTo($whereToSend);
    $message->setBody($messageBody, 'text/html');
    $result = $mailer->send($message);
    var_dump($result);
    var_dump($whereToSend);
}