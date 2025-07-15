<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <title>YangKhor Attendance System - Dashboard</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom CSS for Canvas and Spotlight Effect -->
    <style>
        /* This is from your original file's css/style.css for the canvas */
        .network-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none; /* Prevents canvas from blocking mouse events */
            z-index: -1;          /* Places the canvas behind the content */
        }
        
        /* This creates the radial gradient spotlight that follows the mouse */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* The gradient's center is controlled by JS via --x and --y variables */
            background: radial-gradient(circle at var(--x)px var(--y)px, rgba(0, 100, 255, 0.2), transparent 70%);
            opacity: 0; /* Initially hidden */
            transition: opacity 0.4s ease-out;
            pointer-events: none; /* Also prevent this from blocking events */
            z-index: -2; /* Place it behind the canvas */
        }

        /* This class will be added by JS to make the spotlight visible */
        body.mouse-inside::before {
            opacity: 1;
        }
        
        /* Makes anchor link scrolling smooth */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-white text-gray-800">

    <!-- Navigation Bar -->
    <nav class="bg-white shadow-md fixed w-full top-0 z-10">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
                <!-- Make sure 'images/logo.png' is in your public/images directory -->
                <img src="{{ asset('images/logo1.png') }}" alt="Company Logo" class="h-10 w-10 rounded-full object-cover">
                <span class="text-xl font-bold text-blue-700">YangKhor Private Limited</span>
            </a>

            <!-- Navigation Links -->
            @if (Route::has('login'))
                <ul class="hidden md:flex space-x-6 text-sm font-medium items-center">
                    <li><a href="{{ url('/') }}" class="text-blue-700 font-bold transition">Home</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-blue-500 transition">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-blue-500 transition">Contact Us</a></li>
                                    
                    @auth
                        <!-- If user is logged in -->
                        <li>
                            <a href="{{ url('/dashboard') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition">
                                Dashboard
                            </a>
                        </li>
                    @else
                        <!-- If user is a guest -->
                        <li>
                            <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition">
                                Login
                            </a>
                        </li>

                        @if (Route::has('register'))
                            <!-- You can uncomment this if you have a registration page -->
                            <!--
                            <li>
                                <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded transition">
                                    Register
                                </a>
                            </li>
                            -->
                        @endif
                    @endauth
                </ul>
            @endif
        </div>
    </nav>

    <!-- Canvas Background -->
    <canvas class="network-canvas" id="networkCanvas"></canvas>

    <!-- Hero Section -->
    <main class="relative z-0 h-screen flex flex-col justify-center items-center text-center px-4">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-blue-800 mb-4 leading-tight">
            YangKhor Attendance System
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 max-w-2xl">
            Your Technology Partner for Software Innovation and Value-adding Solutions
        </p>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 py-6 text-center text-sm text-gray-500 relative z-0">
        <p>© {{ date('Y') }} YangKhor Private Limited. All rights reserved.</p>
    </footer>

    <!-- All JavaScript is embedded here -->
    <script>
        // --- Canvas Network Animation ---
        const canvas = document.getElementById("networkCanvas");
        if (canvas) {
            const ctx = canvas.getContext("2d");
            let width, height;
            let circles = [];

            function resizeCanvas() {
                width = canvas.width = window.innerWidth;
                height = canvas.height = window.innerHeight;
                circles = [];
                for (let i = 0; i < 100; i++) {
                    circles.push({
                        x: Math.random() * width,
                        y: Math.random() * height,
                        radius: Math.random() * 2 + 1,
                        vx: (Math.random() - 0.5) * 0.5,
                        vy: (Math.random() - 0.5) * 0.5
                    });
                }
            }

            function draw() {
                ctx.clearRect(0, 0, width, height);
                ctx.fillStyle = "rgba(0, 100, 255, 0.5)";
                for (let circle of circles) {
                    ctx.beginPath();
                    ctx.arc(circle.x, circle.y, circle.radius, 0, Math.PI * 2);
                    ctx.fill();
                    circle.x += circle.vx;
                    circle.y += circle.vy;
                    if (circle.x < 0 || circle.x > width) circle.vx *= -1;
                    if (circle.y < 0 || circle.y > height) circle.vy *= -1;
                }
                for (let i = 0; i < circles.length; i++) {
                    for (let j = i + 1; j < circles.length; j++) {
                        let dx = circles[i].x - circles[j].x;
                        let dy = circles[i].y - circles[j].y;
                        let dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < 100) {
                            // Fixed: Used template literal for dynamic RGBA string
                            ctx.strokeStyle = `rgba(0, 100, 255, ${1 - dist / 100})`;
                            ctx.lineWidth = 0.5;
                            ctx.beginPath();
                            ctx.moveTo(circles[i].x, circles[i].y);
                            ctx.lineTo(circles[j].x, circles[j].y);
                            ctx.stroke();
                        }
                    }
                }
                requestAnimationFrame(draw);
            }
            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();
            draw();
        }

        // --- Spotlight Mouse Effect ---
        const body = document.body;
        // 1. Update the CSS variables (--x, --y) whenever the mouse moves
        document.addEventListener('mousemove', (e) => {
            body.style.setProperty('--x', e.clientX);
            body.style.setProperty('--y', e.clientY);
        });
        // 2. Add 'mouse-inside' class when the cursor enters the page
        document.documentElement.addEventListener('mouseenter', () => {
            body.classList.add('mouse-inside');
        });
        // 3. Remove the class when the cursor leaves the page
        document.documentElement.addEventListener('mouseleave', () => {
            body.classList.remove('mouse-inside');
        });
    </script>
</body>
</html>