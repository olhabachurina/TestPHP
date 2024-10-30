document.getElementById('testForm').addEventListener('submit', function(event) {
    const questions = document.querySelectorAll('.question');
    for (let i = 0; i < questions.length; i++) {
        const options = questions[i].querySelectorAll('input[type="radio"]');
        const isAnswered = Array.from(options).some(option => option.checked);
        if (!isAnswered) {
            alert('Пожалуйста, ответьте на все вопросы!');
            event.preventDefault();
            return;
        }
    }
});