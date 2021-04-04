<?php

require_once 'vendor/autoload.php';
include("helpers.php");
include("sql.php");

const HOUR = 60 * 60;
const DAY = 60 * 60 * 24;

$sql = "SELECT u.id, t.name AS task_name, t.deadline AS deadline, u.email AS user_email FROM tasks t 
        LEFT JOIN users u on u.id = t.user_id 
        WHERE deadline IS NOT NULL AND status = 0
        ORDER BY u.id";
$tasks = getAllRows($sql);

if ($tasks !== false) {
    // Create the Transport
    $transport = (new Swift_SmtpTransport('phpdemo.ru', 25))
        ->setUsername('keks@phpdemo.ru')
        ->setPassword('htmlacademy');
    // Отправка сообщения
    $mailer = new Swift_Mailer($transport);

    $setTo = [];
    $messageBody = '';
    $now = strtotime("now");
    $tmpUser = null;
    $messages = [];
    foreach ($tasks as $task) {
        $diff = $now - strtotime($task['deadline']);
        if ($diff <= DAY) {
            $messageBody = isset($messages[$task['user_email']]) ? $messages[$task['user_email']] : '';
            $messages[$task['user_email']] = $messageBody . $task['task_name']. '<br>';
            $messageBody = $messageBody.$task['task_name'].'<br>';
        }
    }

    sendMessage("Здравствуйте, у вас не выполнены следующие задания: <br>", $messages);
}

function sendMessage($messageStart, $whereToSend)
{
    global $message, $mailer;
    // Формирование сообщения
    var_dump($whereToSend);
    foreach ($whereToSend as $user => $messageBody) {
        $message = (new Swift_Message('Задания которые нужно выполнить сегодня'))
            ->setFrom('keks@phpdemo.ru', 'keks')
            ->setTo($user)
            ->setBody($messageStart.$messageBody, 'text/html');
        $result = $mailer->send($message);
        var_dump($result);
        var_dump($whereToSend);
    }
}