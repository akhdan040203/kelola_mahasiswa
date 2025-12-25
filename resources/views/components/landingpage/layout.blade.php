<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIM-Kampus</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@stack('bodylandingpage')
<x-landingpage.navbar />

{{$slot}}

    <script>
        const btn = document.getElementById('hamburger-button');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Menutup menu mobile saat link diklik
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
            });
        });
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
    // Inisialisasi AOS
    AOS.init({
        // Pengaturan Global:
        duration: 900,     // Durasi animasi (ms), 800ms adalah standar yang nyaman
        once: false,         // Animasi hanya jalan sekali (mencegah kedap-kedip saat scroll balik)
        offset: 50,         // Jarak (px) elemen dari bawah layar sebelum animasi dimulai
        // easing: 'ease-in-out', // Jenis gerakan
        anchorPlacement: 'top-bottom', // Memicu animasi segera setelah bagian atas elemen menyentuh bawah layar
    });

    // PENTING: Refresh AOS setelah semua gambar dan aset selesai dimuat
    // Ini solusi agar elemen Hero & Header yang macet bisa berjalan
    window.addEventListener('load', function() {
        AOS.refresh();
    });
</script>

<script>
  window.addEventListener('scroll', () => {
    const header = document.getElementById('site-header');
    if (window.scrollY > 10) {
      header.classList.add('shadow-md');
    } else {
      header.classList.remove('shadow-md');
    }
  });
</script>

<script>
  const header = document.getElementById('site-header');
  let lastScrollY = window.scrollY;

  window.addEventListener('scroll', () => {
    const currentScrollY = window.scrollY;

    // Shadow saat scroll
    if (currentScrollY > 10) {
      header.classList.add('shadow-md');
    } else {
      header.classList.remove('shadow-md');
    }

    // Auto hide / show
    if (currentScrollY > lastScrollY && currentScrollY > 80) {
      // scroll ke bawah → sembunyikan
      header.classList.add('-translate-y-full');
    } else {
      // scroll ke atas → tampilkan
      header.classList.remove('-translate-y-full');
    }

    lastScrollY = currentScrollY;
  });
</script>
</body>
</html>