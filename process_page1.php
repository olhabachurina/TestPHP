
<?php
session_start();

// Проверка наличия вопросов первой страницы
if (!isset($_SESSION['questions_page1'])) {
    echo "Ошибка: вопросы не найдены. Пожалуйста, начните тест заново.";
    exit();
}

$questions = $_SESSION['questions_page1'];
$scorePage1 = 0;

// Обработка ответов с первой страницы
foreach ($questions as $index => $question) {
    $userAnswer = isset($_POST['answer' . $index]) ? (int)$_POST['answer' . $index] : null;
    if ($userAnswer === (int)$question['correct']) {
        $scorePage1 += 1; // 1 балл за правильный ответ
    }
}

// Сохраняем результат первой страницы
$_SESSION['scorePage1'] = $scorePage1;
$_SESSION['totalCorrect'] = $scorePage1;

// Выводим текущий балл
echo "<script>alert('Score for Page 1: ' + $scorePage1);</script>";
// Переход на вторую страницу
header("Location: page2.php");
exit();