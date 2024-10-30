<?php
session_start();

// Загружаем вопросы для второй страницы, если они еще не установлены
if (!isset($_SESSION['questions_page2'])) {
    $_SESSION['questions_page2'] = [
        [
            'text' => 'Какие виды комментарий в PHP?',
            'options' => ['//', '!!', '/**/'],
            'correct_count' => [0, 2]
        ],
        [
            'text' => 'Варианты вывода строки в PHP',
            'options' => ['echo "..."', 'echo <<<p...p', "echo '...'"],
            'correct_count' => [0, 1, 2]
        ],
        [
            'text' => 'Какие из перечисленных тегов пригодны для открытия и закрытия PHP блока?',
            'options' => ['<?php ?>', '<! !>', '<?= ?>'],
            'correct_count' => [0, 2]
        ],
        [
            'text' => 'Как можно подключить файл?',
            'options' => ['Connect()', 'require()', 'include()'],
            'correct_count' => [1, 2]
        ],
        [
            'text' => 'Как отобразить текст с помощью PHP-скрипта?',
            'options' => ['echo "Method 1"', 'print "Method 2"', 'text: Hello'],
            'correct_count' => [0, 1]
        ],
        [
            'text' => 'Какие глобальные переменные существуют в языке PHP?',
            'options' => ['$_POST["var"]', '$_PAR["var"]', '$_VAR["VAR"]'],
            'correct_count' => [0]
        ],
        [
            'text' => 'Как можно приводить типы в PHP?',
            'options' => ['(int), (integer)', '(float), (double), (real)', '(str)'],
            'correct_count' => [0, 1]
        ],
        [
            'text' => 'Сколько в PHP типов данных?',
            'options' => ['8', '10', '6'],
            'correct_count' => [0]
        ],
        [
            'text' => 'Какие циклы есть в PHP?',
            'options' => ['for', 'foreach', 'while'],
            'correct_count' => [0, 1, 2]
        ],
        [
            'text' => 'Какие модификаторы доступа существуют PHP?',
            'options' => ['public', 'internal', 'private'],
            'correct_count' => [0, 2]
        ],
    ];
}

$questions = $_SESSION['questions_page2'];
$_SESSION['current_page'] = 2;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тест - Страница 2</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Стили контейнера и анимация вопросов */
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

        .next-button {
            display: none; /* Скрываем кнопку по умолчанию */
            background-color: #1a2a6c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .next-button.visible {
            display: inline-block; /* Отображаем кнопку, когда она становится видимой */
        }

        .next-button:hover {
            background-color: #245dbd;
        }

        .alert {
            color: #ffcc00;
            margin-top: 10px;
            font-size: 1em;
            display: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Тест по PHP - Страница 2</h2>
    <p class="hint">Выберите все правильные ответы перед переключением к следующему вопросу.</p>
    <form method="post" action="process_page2.php">
        <?php foreach ($questions as $index => $question): ?>
            <div class="question" data-correct-count="<?php echo count($question['correct_count']); ?>">
                <p><?php echo ($index + 1) . '. ' . htmlspecialchars($question['text']); ?></p>
                <?php foreach ($question['options'] as $optionIndex => $option): ?>
                    <label>
                        <input type="checkbox" name="answer<?php echo $index; ?>[]" value="<?php echo $optionIndex; ?>">
                        <?php echo htmlspecialchars($option); ?>
                    </label><br>
                <?php endforeach; ?>
                <p class="alert">Выберите все правильные ответы!</p>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="next-button" id="nextButton">Next</button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const questions = document.querySelectorAll('.question');
        const nextButton = document.getElementById('nextButton');
        let currentQuestionIndex = 0;

        // Отображаем первый вопрос
        questions[currentQuestionIndex].classList.add('visible');

        document.querySelector('form').addEventListener('change', function() {
            const currentQuestion = questions[currentQuestionIndex];
            const selectedAnswers = currentQuestion.querySelectorAll('input[type="checkbox"]:checked');
            const correctCount = parseInt(currentQuestion.getAttribute('data-correct-count'), 10);
            const alertMessage = currentQuestion.querySelector('.alert');

            // Проверяем, выбраны ли все нужные ответы
            if (selectedAnswers.length === correctCount) {
                alertMessage.style.display = 'none'; // Скрываем предупреждение
                currentQuestion.classList.remove('visible');
                currentQuestionIndex++;

                if (currentQuestionIndex < questions.length) {
                    setTimeout(() => {
                        questions[currentQuestionIndex].classList.add('visible');
                    }, 300);
                } else {
                    nextButton.classList.add('visible'); // Показываем кнопку "Next" в конце
                }
            } else {
                alertMessage.style.display = 'block'; // Показываем предупреждение, если ответы не полные
            }
        });
    });
</script>
</body>
</html>