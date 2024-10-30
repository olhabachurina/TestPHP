<?php
session_start();

// Установка времени начала теста
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

// Загружаем и перемешиваем вопросы для первой страницы
function getQuestions($filename) {
    $questions = [];
    $file = fopen($filename, 'r');
    while (($line = fgets($file)) !== false) {
        $parts = explode(';', trim($line));
        if (count($parts) >= 6) {
            $question = [
                'id' => $parts[0],
                'text' => $parts[1],
                'options' => array_slice($parts, 2, 3),
                'correct' => $parts[5]
            ];
            $questions[] = $question;
        }
    }
    fclose($file);
    return $questions;
}

$questions = getQuestions('test1.txt');
shuffle($questions);

$_SESSION['questions_page1'] = $questions;
$_SESSION['current_page'] = 1;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тест - Страница 1</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Основные стили */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            color: white;
            background: radial-gradient(circle, #1a2a6c, #1a2a6c 20%, #245dbd 50%, #1a2a6c 80%);
            border-radius: 10px;
        }

        .question {
            display: none;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .question.visible {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .question p {
            font-size: 1.2em;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Тест по PHP - Страница 1</h2>
    <form id="testForm" method="post" action="process_page1.php">
        <?php foreach ($questions as $index => $question): ?>
            <div class="question" id="question-<?php echo $index; ?>">
                <p><?php echo ($index + 1) . '. ' . htmlspecialchars($question['text']); ?></p>
                <?php foreach ($question['options'] as $optionIndex => $option): ?>
                    <label>
                        <input type="radio" name="answer<?php echo $index; ?>" value="<?php echo $optionIndex + 1; ?>" data-question="<?php echo $index; ?>" required>
                        <?php echo htmlspecialchars($option); ?>
                    </label><br>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const questions = document.querySelectorAll('.question');
        let currentQuestionIndex = 0;

        questions[currentQuestionIndex].classList.add('visible');

        document.getElementById('testForm').addEventListener('change', function(event) {
            const selectedQuestion = event.target.getAttribute('data-question');
            if (parseInt(selectedQuestion, 10) === currentQuestionIndex) {
                questions[currentQuestionIndex].classList.remove('visible');
                currentQuestionIndex++;

                if (currentQuestionIndex < questions.length) {
                    setTimeout(() => {
                        questions[currentQuestionIndex].classList.add('visible');
                    }, 300);
                } else {

                    console.log('Submitting form');
                    document.getElementById('testForm').submit();
                }
            }
        });
    });
</script>
</body>
</html>