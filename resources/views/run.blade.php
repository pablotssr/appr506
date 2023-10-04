<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Running Game</title>
    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        canvas {
            width: 300px; /* Set square dimensions */
            height: 300px; /* Set square dimensions */
            display: block; /* Remove any extra spacing */
        }
    </style>
</head>
<body>
    <canvas id="gameCanvas"></canvas> <!-- Removed width and height attributes -->
    <div id="score">Score: 0</div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('gameCanvas');
            const ctx = canvas.getContext('2d');
            let score = 0;  
            let obstacleWidth = 20; 
            let obstacleHeight = 20; 
            let jumpHeight = 0;
            let jumpSpeed = 2; // Adjusted jump speed

            function updateScore() {
                score+=2;
                document.getElementById('score').textContent = 'Score: ' + score;
            }
            
            let isJumping = false;
            let dinoY = canvas.height - 30;
            let dinoX = 50;
            let obstacleX = canvas.width;
            let gameInterval;
            let groundY = dinoY + 20;

            function drawGround() {
                ctx.fillStyle = '#000';
                ctx.fillRect(0, groundY, canvas.width, 2);
            }

            function drawDino() {
    ctx.fillStyle = '#000';
    ctx.fillRect(dinoX, dinoY - jumpHeight, 30, 20); // Set the dimensions to 20x20
}

function drawObstacle() {
    ctx.fillStyle = '#000';
    ctx.fillRect(obstacleX, groundY - obstacleHeight, obstacleWidth, obstacleHeight); // Adjusted obstacle height
}

function jump() {
    if (!isJumping) {
        isJumping = true;
        jumpHeight = 0;
        let jumpInterval = setInterval(function() {
            jumpHeight += jumpSpeed;

            // Adjust jump height based on jump key press duration
            if (jumpHeight >= 60 || !isJumping) {
                clearInterval(jumpInterval);
                let fallInterval = setInterval(function() {
                    jumpHeight -= 2;
                    if (jumpHeight <= 0) {
                        clearInterval(fallInterval);
                        isJumping = false;
                    }
                }, 16);
            }
        }, 16);
    }
}

            function updateGameArea() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                drawGround();
                drawDino();
                drawObstacle();
                obstacleX -= (3 + Math.floor(score / 100)); 

                if (obstacleX < -20) {
                    obstacleX = canvas.width + Math.random() * 200;

                    if (Math.random() < 0.5) {
                        obstacleWidth = 40;
                    } else {
                        obstacleWidth = 20;
                    }
                    if (Math.random() < 0.5) {
                        obstacleHeight = 30;
                    } else {
                        obstacleHeight = 20;
                    }

                    updateScore();
                }

                if (dinoX < obstacleX + obstacleWidth &&
                    dinoX + 20 > obstacleX &&
                    dinoY - jumpHeight < groundY &&
                    dinoY - jumpHeight + 20 > groundY - obstacleHeight) {
                    clearInterval(gameInterval);
                    alert("Game Over!");
                }
            }
            gameInterval = setInterval(updateGameArea, 16);

            document.addEventListener('keydown', function(event) {
    if (event.keyCode === 32 || event.keyCode === 38) {
        jump();
    }
});

document.addEventListener('keyup', function(event) {
    if (event.keyCode === 32 || event.keyCode === 38) {
        isJumping = false;
    }
});
        });
    </script>
</body>
</html>
