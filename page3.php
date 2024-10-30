<?php
session_start();

// Загружаем вопросы для третьей страницы, если они еще не установлены
if (!isset($_SESSION['questions_page3'])) {
    $_SESSION['questions_page3'] = [
        [
            'text' => 'Какую функцию нужно использовать, чтобы объявить константу?',
            'correct' => 'define'
        ],
        [
            'text' => 'Какую функцию нужно использовать, чтобы установить cookie?',
            'correct' => 'setcookie'
        ],
        [
            'text' => 'В какой глобальной переменной находятся session данные?',
            'correct' => '$_SESSION'
        ],
        [
            'text' => 'Какую функцию нужно использовать чтобы проверить наличие ключа в массиве PHP?',
            'correct' => 'array_key_exists'
        ],
        [
            'text' => 'Какую функцию нужно использовать для перехода на другую страницу из PHP скрипта?',
            'correct' => 'header'
        ],
        [
            'text' => 'С помощью какой функции можно разбить строку на массив по разделителю?',
            'correct' => 'explode'
        ],
        [
            'text' => 'Как найти позицию первого вхождения подстроки в строку?',
            'correct' => 'strpos'
        ],
        [
            'text' => 'Какую функцию использовать чтобы перевернуть строку?',
            'correct' => 'strrev'
        ],
        [
            'text' => 'Какую функцию можно использовать, чтобы перемешать элементы массива?',
            'correct' => 'shuffle'
        ],
        [
            'text' => 'Как уничтожить все глобальные переменные сессии?',
            'correct' => 'session_unset'
        ],
    ];
}

$questions = $_SESSION['questions_page3'];
$_SESSION['current_page'] = 3;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тест - Страница 3</title>
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

        .finish-button {
            display: none;
            background-color: #1a2a6c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .finish-button.visible {
            display: inline-block;
        }

        .finish-button:hover {
            background-color: #245dbd;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Тест по PHP - Страница 3</h2>
    <form method="post" action="process_page3.php">
        <?php foreach ($questions as $index => $question): ?>
            <div class="question">
                <p><?php echo ($index + 1) . '. ' . htmlspecialchars($question['text']); ?></p>
                <input type="text" name="answer<?php echo $index; ?>" required>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="finish-button" id="finishButton">Finish</button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const questions = document.querySelectorAll('.question');
        const finishButton = document.getElementById('finishButton');
        let currentQuestionIndex = 0;

        // Отображаем первый вопрос
        questions[currentQuestionIndex].classList.add('visible');

        document.querySelector('form').addEventListener('input', function(event) {
            const currentQuestion = questions[currentQuestionIndex];
            const answerField = currentQuestion.querySelector('input[type="text"]');

            if (answerField.value.trim() !== '') {
                currentQuestion.classList.remove('visible');
                currentQuestionIndex++;

                if (currentQuestionIndex < questions.length) {
                    setTimeout(() => {
                        questions[currentQuestionIndex].classList.add('visible');
                    }, 300);
                } else {
                    finishButton.classList.add('visible'); // Показать кнопку "Finish" в конце
                }
            }
        });
    });
</script>
</body>
</html>