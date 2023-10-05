<!DOCTYPE html>
<html>
<head>
    <title>Simple Snake Game</title>
    <style>
        canvas {
            border: 2px solid black;
        }
    </style>
</head>
<body>
    <canvas id="gameCanvas" width="400" height="400"></canvas>
    <div id="score"></div>

    <script>
        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d');

        let snake = [{x: 40, y: 180},{x: 60, y: 180}];
        let food = {x: Math.floor(Math.random() * 20) * 20, y: Math.floor(Math.random() * 20) * 20};
        let dx = 20;
        let dy = 0;
        let score = 0;

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            snake.forEach(segment => {
                ctx.fillStyle = 'black';
                ctx.fillRect(segment.x, segment.y, 20, 20);
            });

            ctx.fillStyle = 'red';
            ctx.fillRect(food.x, food.y, 20, 20);
            document.getElementById('score').textContent = 'Score: ' + score;
        }

        function move() {
            const head = {x: snake[0].x + dx, y: snake[0].y + dy};
            snake.unshift(head);
            if (head.x === food.x && head.y === food.y) {
                food = {x: Math.floor(Math.random() * 20) * 20, y: Math.floor(Math.random() * 20) * 20};
                score += 1; 
            } else {
                snake.pop();
            }

            if (head.x < 0 || head.y < 0 || head.x >= canvas.width || head.y >= canvas.height) {
                alert('Game over!');
                snake = [{x: 40, y: 180},{x: 60, y: 180}];
                dx = 20;
                dy = 0;
                score = 0; 
            }

            for (let i = 1; i < snake.length; i++) {
                if (head.x === snake[i].x && head.y === snake[i].y) {
                    alert('Game over!');
                    snake = [{x: 40, y: 180},{x: 60, y: 180}];
                    dx = 20;
                    dy = 0;
                    score = 0;
                }
            }

            moving = false;
        }

        function keyDownHandler(e) {
            if (!moving) { 
                if (e.key === 'Right' || e.key === 'ArrowRight') {
                    if (dx !== -20) {
                        dx = 20;
                        dy = 0;
                        moving = true;
                    }
                } else if (e.key === 'Left' || e.key === 'ArrowLeft') {
                    if (dx !== 20) {
                        dx = -20;
                        dy = 0;
                        moving = true;
                    }
                } else if (e.key === 'Up' || e.key === 'ArrowUp') {
                    if (dy !== 20) { 
                        dx = 0;
                        dy = -20;
                        moving = true;
                    }
                } else if (e.key === 'Down' || e.key === 'ArrowDown') {
                    if (dy !== -20) { 
                        dx = 0;
                        dy = 20;
                        moving = true;
                    }
                }
            }
        }

        document.addEventListener('keydown', keyDownHandler);

        setInterval(() => {
            move();
            draw();
        }, 100);
    </script>
</body>
</html>