<!DOCTYPE html>
<html>
<head>
    <title>Jeu de Calcul</title>
    <style>
        .feedback {
            font-size: 20px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <button id="startButton">Start</button>
    <div id="gameArea" style="display: none;">
        <p>Question <span id="questionNumber">1</span>/10</p>
        <p id="question"></p>
        <input type="text" id="answerInput" placeholder="Entrez la réponse (chiffres uniquement)">
        <button id="validateButton">Valider</button>
        <div id="timer" style="width: 15%; height: 5px; background-color: green;"></div>
    </div>
    <div id="result" style="display: none;">
        <p>Nombre de bonnes réponses: <span id="correctAnswers">0</span>/10</p>
        <p>Score: <span id="score">0</span></p>
    </div>

    <script>
        let questionCount = 0;
        let correctAnswers = 0;
        let score = 0;
        let timerWidth = 100;
        const timerMaxWidth = 180; 
        let timerInterval;

        document.getElementById('startButton').addEventListener('click', startGame);

        function startGame() {
            document.getElementById('startButton').style.display = 'none';
            document.getElementById('gameArea').style.display = 'block';
            askQuestion();
            startTimer();
        }

        function askQuestion() {
            questionCount++;
            const questionNumberElement = document.getElementById('questionNumber');
            const questionElement = document.getElementById('question');
            questionNumberElement.textContent = questionCount;
            
            const operator = getRandomOperator();
            let num1, num2;
            switch (operator) {
                case '+':
                    num1 = getRandomNumber(1, 9999);
                    num2 = getRandomNumber(1, 9999);
                    break;
                case '-':
                    num2 = getRandomNumber(1, 9999);
                    num1 = getRandomNumber(num2, 9999);
                    break;
                case '*':
                    num1 = getRandomNumber(1, 99);
                    num2 = getRandomNumber(1, 99);
                    break;
                case '/':
                    num2 = getRandomNumber(1, 9999);
                    num1 = num2 * getRandomNumber(1, 99); 
                    break;
            }
            
            questionElement.textContent = `${num1} ${operator} ${num2} = `;
        }

        function getRandomOperator() {
            const operators = ['+', '-', '*', '/'];
            const randomIndex = Math.floor(Math.random() * operators.length);
            return operators[randomIndex];
        }

        function getRandomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        function startTimer() {
            timerInterval = setInterval(() => {
                if (timerWidth > 0) {
                    timerWidth -= (100 / timerMaxWidth);
                    const timerElement = document.getElementById('timer');
                    const scale = timerWidth / 100; // Calculate the scale factor
                    timerElement.style.transform = `scaleX(${scale})`; // Apply the scale transformation
                } else {
                    endGame();
                }
            }, 1000);
        }

        function endGame() {
            clearInterval(timerInterval);
            const answerInput = document.getElementById('answerInput');
            answerInput.disabled = true;
            const validateButton = document.getElementById('validateButton');
            validateButton.disabled = true;
            const resultElement = document.getElementById('result');
            resultElement.style.display = 'block';
            const correctAnswersElement = document.getElementById('correctAnswers');
            correctAnswersElement.textContent = correctAnswers;

            if (correctAnswers >= 0 && correctAnswers <= 3) {
                score = correctAnswers * 3;
            } else if (correctAnswers >= 4 && correctAnswers <= 6) {
                score = correctAnswers * 4;
            } else if (correctAnswers >= 7 && correctAnswers <= 9) {
                score = correctAnswers * 5;
            } else if (correctAnswers === 10) {
                score = correctAnswers * 6;
            }

            const scoreElement = document.getElementById('score');
            scoreElement.textContent = score;
        }

        document.getElementById('validateButton').addEventListener('click', validateAnswer);

        document.getElementById('answerInput').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                validateAnswer();
            }
        });

        function validateAnswer() {
            const answerInput = document.getElementById('answerInput');
            const userAnswer = parseInt(answerInput.value, 10);
            const questionElement = document.getElementById('question');
            const [num1, operator, num2] = questionElement.textContent.split(' ');
            let correctAnswer;

            switch (operator) {
                case '+':
                    correctAnswer = parseInt(num1) + parseInt(num2);
                    break;
                case '-':
                    correctAnswer = parseInt(num1) - parseInt(num2);
                    break;
                case '*':
                    correctAnswer = parseInt(num1) * parseInt(num2);
                    break;
                case '/':
                    correctAnswer = parseInt(num1) / parseInt(num2);
                    break;
            }

            if (userAnswer === correctAnswer) {
                correctAnswers++;
            }

            if (questionCount === 10) {
                endGame();
            } else {
                answerInput.value = '';
                askQuestion();
            }

            const feedbackElement = document.createElement('span'); // Utilisation d'un <span> au lieu d'un <div>
            feedbackElement.classList.add('feedback');
            if (userAnswer === correctAnswer) {
                feedbackElement.textContent = '✔';
            } else {
                feedbackElement.textContent = '❌';
            }

            const validateButton = document.getElementById('validateButton');
            validateButton.parentNode.insertBefore(feedbackElement, validateButton.nextSibling); // Insère le feedback après le bouton Valider
        }
    </script>
</body>
</html>
