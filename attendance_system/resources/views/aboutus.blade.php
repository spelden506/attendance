<!-- about.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us - YangKhor Private Limited</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/style.css">
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
      <ul class="hidden md:flex space-x-6 text-sm font-medium items-center">
        <li><a href="{{ url('/') }}" class="hover:text-blue-500 transition">Home</a></li>
        <li><a href="{{ route('about') }}" class="hover:text-blue-500 transition">About Us</a></li>
        <li><a href="{{ route('contact') }}" class="hover:text-blue-500 transition">Contact Us</a></li>
        <li>
            <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition">
                Login
            </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Canvas Background -->
  <canvas class="network-canvas" id="networkCanvas"></canvas>

  <!-- About Section -->
  <main class="relative z-0">
    <section id="about" class="py-20 pt-32 bg-gray-50">
      <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">About Us</h2>
        <p class="text-gray-600 max-w-3xl mx-auto">
          Yang Khor Pvt. Ltd is a leading In-country Technology Solutions Provider supplying solution in terms of hardware, software, support, and services as a complete package. Yang Khor Pvt. Ltd has been serving its purpose since 2005, it has now emerged to be unprecedented leader as a Solution Integrator with a differentiated vertical approach providing innovative solutions. Yang Khor Pvt. Ltd uses its solution integration capabilities to integrate best of breed products through its key technology alliance partners to provide “End to End” solutions. Provide customized business solutions that help organizations accelerate revenue growth, increase market penetration, optimize operating costs, and improve employee productivity, by embedding communication in their business processes.
        </p>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-100 py-6 text-center text-sm text-gray-500 relative z-0">
    <p>© 2025 YangKhor Private Limited. All rights reserved.</p>
    <p class="mt-2">Some Pictures are from <a href="https://www.freepik.com" target="_blank" class="text-blue-500 underline">Freepik</a></p>
  </footer>

  <script src="js/main.js"></script>
</body>
</html>