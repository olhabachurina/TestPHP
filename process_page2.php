<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $questions = $_SESSION['questions_page2'];
    $scorePage2 = 0;

    // Подсчет баллов за правильные ответы на второй странице
    foreach ($questions as $index => $question) {
        $userAnswers = $_POST['answer' . $index] ?? [];
        if (!is_array($userAnswers)) {
            $userAnswers = [$userAnswers];
        }
        sort($userAnswers);

        // Получаем правильные ответы как массив индексов
        $correctAnswers = $question['correct_count'];
        sort($correctAnswers);

        // Проверка совпадения выбранных ответов с правильными
        if ($userAnswers == $correctAnswers) {
            $scorePage2 += 3; // Добавляем 3 балла за каждый правильно отвеченный вопрос
        }
    }

    // Сохраняем результат второй страницы
    $_SESSION['scorePage2'] = $scorePage2;

    // Выводим текущий балл
    echo "<script>alert('Score for Page 1: ' + $scorePage2);</script>";

    // Переход на третью страницу теста
    header("Location: page3.php");
    exit();
}