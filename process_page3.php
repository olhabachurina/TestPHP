<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $questions = $_SESSION['questions_page3'];
    $scorePage3 = 0;

    // Подсчет баллов за ответы на третьей странице
    foreach ($questions as $index => $question) {
        $userAnswer = trim(strtolower($_POST['answer' . $index] ?? ''));
        $correctAnswer = strtolower($question['correct']);

        // Сравнение с правильным ответом
        if ($userAnswer === $correctAnswer) {
            $scorePage3 += 5; // Каждый правильный ответ оценивается в 5 баллов
        }
    }

    // Сохраняем результат третьей страницы
    $_SESSION['scorePage3'] = $scorePage3;

    // Выводим текущий балл в консоль (через JavaScript)
    echo "<script>alert('Score for Page 1: ' + $scorePage3);</script>";

    // Переход на страницу с результатами
    header("Location: result.php");
    exit();
}