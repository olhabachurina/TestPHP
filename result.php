<?php
session_start();

// Убедимся, что все данные теста сохранены
if (!isset($_SESSION['scorePage1'], $_SESSION['scorePage2'], $_SESSION['scorePage3'])) {
    echo "Ошибка: Не все данные теста были переданы. Пожалуйста, пройдите тест сначала.";
    exit();
}

// Подсчет общего балла
$totalScore = $_SESSION['scorePage1'] + $_SESSION['scorePage2'] + $_SESSION['scorePage3'];

// Сообщение о результате
$isPassed = $totalScore >= 15;
$message = $isPassed ? "Поздравляем! Тест пройден. Вы набрали $totalScore баллов." : "Не огорчайтесь! Пройдите тест еще раз.";

// Очистка данных сессии при повторном прохождении теста
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_unset(); // Очистка всех данных сессии
    header("Location: page1.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат теста</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: radial-gradient(circle, #1a2a6c, #245dbd);
            color: white;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            text-align: center;
            color: #333;
        }
        .container h2 {
            color: #1a2a6c;
        }
        button {
            background-color: #1a2a6c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            z-index: 10; /* Установим высокий z-index */
            position: relative; /* Убедимся, что z-index применяется */
        }
        button:hover {
            background-color: #245dbd;
        }
        /* Стили для холста конфетти */
        #confettiCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Результат теста</h2>
    <p><?php echo $message; ?></p>
    <p>Ваш итоговый балл: <strong><?php echo $totalScore; ?></strong></p>

    <!-- Кнопка "Пройти еще раз" -->
    <form method="post">
        <button type="submit">Пройти еще раз</button>
    </form>
</div>

<?php if ($isPassed): ?>
    <!-- Холст для конфетти -->
    <canvas id="confettiCanvas"></canvas>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('confettiCanvas');
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            const confetti = [];
            function randomColor() {
                const colors = ['#FF5E5B', '#FFED66', '#66D7D1', '#6A0572', '#F2A30F'];
                return colors[Math.floor(Math.random() * colors.length)];
            }

            function createConfettiPiece() {
                return {
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height - canvas.height,
                    color: randomColor(),
                    size: Math.random() * 5 + 5,
                    speedX: Math.random() * 2 - 1,
                    speedY: Math.random() * 3 + 2,
                    rotation: Math.random() * 360,
                    rotationSpeed: Math.random() * 10 - 5
                };
            }

            function updateConfetti() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (let i = 0; i < confetti.length; i++) {
                    const piece = confetti[i];
                    piece.x += piece.speedX;
                    piece.y += piece.speedY;
                    piece.rotation += piece.rotationSpeed;

                    if (piece.y > canvas.height) {
                        confetti[i] = createConfettiPiece();
                        confetti[i].y = -10;
                    }

                    ctx.save();
                    ctx.translate(piece.x, piece.y);
                    ctx.rotate(piece.rotation * Math.PI / 180);
                    ctx.fillStyle = piece.color;
                    ctx.fillRect(-piece.size / 2, -piece.size / 2, piece.size, piece.size);
                    ctx.restore();
                }
                requestAnimationFrame(updateConfetti);
            }

            // Создаем 150 частиц конфетти, если тест пройден
            for (let i = 0; i < 150; i++) {
                confetti.push(createConfettiPiece());
            }

            updateConfetti();
        });
    </script>
<?php endif; ?>
</body>
</html>