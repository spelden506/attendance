<!-- contact.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us - YangKhor Private Limited</title>
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
        <li><a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition">Login</a></li>
      </ul>
    </div>
  </nav>

  <!-- Canvas Background -->
  <canvas class="network-canvas" id="networkCanvas"></canvas>

  <!-- Contact Section -->
  <main class="relative z-0">
    <section id="contact" class="py-20 pt-32 bg-white">
      <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Get in Touch</h2>
        <p class="text-lg text-gray-700 mb-10 text-center max-w-3xl mx-auto">
          We would love to hear from you! Whether you have questions about our products, need assistance, or just want to say hello, our team is ready to assist you.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
          <div class="bg-gray-50 p-8 rounded-lg shadow-sm">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Our Location</h3>
            <p class="text-gray-600 mb-4">2nd Floor, KMT Building, Changangkha<br>Thimphu - 11001, Bhutan</p>
            <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-2">Phone Number</h3>
            <p class="text-blue-600 hover:underline"><a href="tel:+975-2-335378">+975-2-335378</a></p>
            <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-2">Email Address</h3>
            <p class="text-blue-600 hover:underline"><a href="mailto:info@yangkhor.com">info@yangkhor.com</a></p>
          </div>
          <form class="space-y-6" onsubmit="event.preventDefault(); alert('Message sent (not really)!');">
            <div>
              <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
              <input type="text" id="name" placeholder="Your Name" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
              <label for="email-contact" class="block text-gray-700 font-medium mb-2">Email</label>
              <input type="email" id="email-contact" placeholder="you@example.com" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
              <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
              <textarea id="message" rows="5" placeholder="Your message..." class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded transition">Send Message</button>
          </form>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-100 py-6 text-center text-sm text-gray-500 relative z-0">
    <p>© 2025 YangKhor Private Limited. All rights reserved.</p>
    <!-- <p class="mt-2">Some Pictures are from <a href="https://www.freepik.com" target="_blank" class="text-blue-500 underline">Freepik</a></p> -->
  </footer>

  <script src="js/main.js"></script>
</body>
</html>