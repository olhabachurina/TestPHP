<?php
session_start();

// Убедимся, что загружаем вопросы только для первой страницы
$file = 'test1.txt';
$data = [];

// Проверяем, что файл существует
if (!file_exists($file)) {
    echo json_encode(['error' => 'Файл с вопросами не найден']);
    exit;
}

// Загружаем вопросы из файла
$fileContents = file($file);
foreach ($fileContents as $line) {
    $parts = explode(';', trim($line));
    $question = $parts[1];
    $answers = array_slice($parts, 2);
    $correctAnswer = (int)$parts[0];

    $data[] = [
        'text' => $question,
        'answers' => $answers,
        'correctAnswer' => $correctAnswer
    ];
}

// Отправляем вопросы в формате JSON
echo json_encode(['questions' => $data]);