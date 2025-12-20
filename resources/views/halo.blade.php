<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Blog Sederhana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">

<!-- Header -->
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-600">MyBlog</h1>
        <nav class="space-x-4">
            <a href="#" class="hover:text-blue-600 text-xl font-semiboldn text-sky-600">Home</a>
            <a href="#" class="hover:text-blue-600 text-xl font-semiboldn text-sky-600">Artikel</a>
            <a href="#" class="hover:text-blue-600 text-xl font-semiboldn text-sky-600">Tentang</a>
        </nav>
    </div>
</header>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">

    <!-- Artikel -->
    <section class="md:col-span-2 space-y-6">
        <article class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-2">Judul Artikel Pertama</h2>
            <p class="text-sm text-gray-500 mb-4">20 September 2025 · Admin</p>
            <p class="text-gray-700 mb-4">
                Ini adalah contoh artikel blog sederhana menggunakan Tailwind CSS.
                Desain clean dan responsif.
            </p>
            <a href="#" class="text-blue-600 hover:underline">Baca selengkapnya →</a>
        </article>

        <article class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-2">Judul Artikel Kedua</h2>
            <p class="text-sm text-gray-500 mb-4">18 September 2025 · Admin</p>
            <p class="text-gray-700 mb-4">
                Tailwind CSS memudahkan pembuatan UI tanpa harus menulis CSS manual.
            </p>
            <a href="#" class="text-blue-600 hover:underline">Baca selengkapnya →</a>
        </article>
    </section>

    <!-- Sidebar -->
    <aside class="space-y-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-bold text-lg mb-4">Kategori</h3>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-blue-600">Laravel</a></li>
                <li><a href="#" class="hover:text-blue-600">Tailwind CSS</a></li>
                <li><a href="#" class="hover:text-blue-600">Web Dev</a></li>
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-bold text-lg mb-4">Tentang</h3>
            <p class="text-gray-600 text-sm">
                Blog sederhana untuk berbagi tutorial seputar web development.
            </p>
        </div>
    </aside>

</main>

<!-- Footer -->
<footer class="bg-white border-t">
    <div class="max-w-7xl mx-auto px-6 py-4 text-center text-sm text-gray-500">
        © 2025 MyBlog. All rights reserved.
    </div>
</footer>

</body>
</html>
