<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Trust Gadai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        .sidebar {
            width: 250px;
            transition: all 0.3s ease;
        }
        
        .main-content {
            transition: all 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 50;
                height: 100vh;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }
            
            .overlay.active {
                display: block;
            }
        }
        
        .chat-container {
            height: 400px;
            overflow-y: auto;
        }
        
        .chat-message {
            max-width: 80%;
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        
        .slide-up {
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body class="font-sans bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-white-500 to-cyan-500 rounded-lg flex items-center justify-center shadow-lg">
                        <img src="assets/img/logo_fix.png" alt="Trust Gadai Logo" class="w-20 h-15">
                    </div>
                    <span class="text-2xl font-bold text-gray-800">Trust Gadai - Admin</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="flex items-center space-x-2 text-gray-700">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i data-lucide="user" class="w-5 h-5 text-blue-600"></i>
                            </div>
                            <span>Admin</span>
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <button class="md:hidden text-gray-600" id="mobile-menu-btn">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="sidebar bg-gray-800 text-white">
            <div class="p-4">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 bg-white-500 rounded-lg flex items-center justify-center">
                        <img src="assets/img/logo_fix.png" alt="Trust Gadai Logo" class="w-20 h-15">
                    </div>
                    <span class="text-xl font-bold">Trust Gadai</span>
                </div>
                
                <nav class="space-y-2">
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg bg-gray-700">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors" onclick="showSection('admin-verifikasi'); return false;">
                        <i data-lucide="package" class="w-5 h-5"></i>
                        <span>Verifikasi Barang</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors" onclick="showSection('admin-chat'); return false;">
                        <i data-lucide="message-square" class="w-5 h-5"></i>
                        <span>Chat User</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors">
                        <i data-lucide="users" class="w-5 h-5"></i>
                        <span>Kelola User</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors" onclick="logout(); return false;">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span>Keluar</span>
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content flex-1 p-6">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
                    <button class="md:hidden text-gray-600" id="sidebar-toggle">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
                
                <!-- Dashboard Content -->
                <div id="dashboard-content">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <div class="bg-blue-50 p-5 rounded-xl fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-600">Total Barang</p>
                                    <h3 class="text-2xl font-bold mt-1">128</h3>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i data-lucide="package" class="w-6 h-6 text-blue-600"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 p-5 rounded-xl fade-in" style="animation-delay: 0.2s;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-600">Barang Baru</p>
                                    <h3 class="text-2xl font-bold mt-1">12</h3>
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i data-lucide="package-plus" class="w-6 h-6 text-green-600"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-purple-50 p-5 rounded-xl fade-in" style="animation-delay: 0.4s;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-600">User Aktif</p>
                                    <h3 class="text-2xl font-bold mt-1">86</h3>
                                </div>
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i data-lucide="users" class="w-6 h-6 text-purple-600"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-orange-50 p-5 rounded-xl fade-in" style="animation-delay: 0.6s;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-orange-600">Perlu Verifikasi</p>
                                    <h3 class="text-2xl font-bold mt-1">7</h3>
                                </div>
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <i data-lucide="alert-circle" class="w-6 h-6 text-orange-600"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-xl shadow-md slide-up" style="animation-delay: 0.8s;">
                            <h2 class="text-xl font-bold mb-4">Barang Perlu Verifikasi</h2>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                    <div>
                                        <h3 class="font-semibold">iPhone 13 Pro</h3>
                                        <p class="text-sm text-gray-600">Oleh: Ahmad Rizki</p>
                                    </div>
                                    <button class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                        Verifikasi
                                    </button>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                    <div>
                                        <h3 class="font-semibold">Laptop ASUS ROG</h3>
                                        <p class="text-sm text-gray-600">Oleh: Siti Rahayu</p>
                                    </div>
                                    <button class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                        Verifikasi
                                    </button>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                    <div>
                                        <h3 class="font-semibold">Ring Emas 5gr</h3>
                                        <p class="text-sm text-gray-600">Oleh: Budi Santoso</p>
                                    </div>
                                    <button class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                        Verifikasi
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white p-6 rounded-xl shadow-md slide-up" style="animation-delay: 1s;">
                            <h2 class="text-xl font-bold mb-4">Aktivitas Terbaru</h2>
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Barang telah diverifikasi</p>
                                        <p class="text-sm text-gray-600">Samsung Galaxy S23 - 10 menit lalu</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mt-1">
                                        <i data-lucide="message-square" class="w-4 h-4 text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Pesan baru dari user</p>
                                        <p class="text-sm text-gray-600">Diana Putri - 25 menit lalu</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mt-1">
                                        <i data-lucide="dollar-sign" class="w-4 h-4 text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Pencairan dana baru</p>
                                        <p class="text-sm text-gray-600">Rp 5.000.000 - 1 jam lalu</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Verifikasi Barang Section (Initially Hidden) -->
                <div id="admin-verifikasi" class="hidden">
                    <h2 class="text-2xl font-bold mb-6">Verifikasi Barang</h2>
                    
                    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 slide-up">
                        <div class="border-b">
                            <div class="flex overflow-x-auto">
                                <button class="px-6 py-3 border-b-2 border-blue-600 text-blue-600 font-medium">Semua</button>
                                <button class="px-6 py-3 border-b-2 border-transparent text-gray-600 hover:text-blue-600 font-medium">Menunggu</button>
                                <button class="px-6 py-3 border-b-2 border-transparent text-gray-600 hover:text-blue-600 font-medium">Terverifikasi</button>
                                <button class="px-6 py-3 border-b-2 border-transparent text-gray-600 hover:text-blue-600 font-medium">Ditolak</button>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6 p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i data-lucide="smartphone" class="w-8 h-8 text-gray-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">iPhone 13 Pro</h3>
                                        <p class="text-gray-600">Oleh: Ahmad Rizki • 12 Jun 2023</p>
                                        <p class="text-sm text-gray-600">Nilai yang diajukan: Rp 7.500.000</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                        Terima
                                    </button>
                                    <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                        Tolak
                                    </button>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mb-6 p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i data-lucide="laptop" class="w-8 h-8 text-gray-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Laptop ASUS ROG</h3>
                                        <p class="text-gray-600">Oleh: Siti Rahayu • 10 Jun 2023</p>
                                        <p class="text-sm text-gray-600">Nilai yang diajukan: Rp 10.000.000</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                        Terima
                                    </button>
                                    <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                        Tolak
                                    </button>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i data-lucide="gem" class="w-8 h-8 text-gray-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Ring Emas 5gr</h3>
                                        <p class="text-gray-600">Oleh: Budi Santoso • 5 Jun 2023</p>
                                        <p class="text-sm text-gray-600">Nilai yang diajukan: Rp 5.200.000</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                        Terima
                                    </button>
                                    <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                        Tolak
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Chat Admin Section (Initially Hidden) -->
                <div id="admin-chat" class="hidden">
                    <h2 class="text-2xl font-bold mb-6">Chat dengan User</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="border-b p-4 bg-gray-50">
                                <h3 class="font-semibold">Daftar User</h3>
                            </div>
                            <div class="divide-y">
                                <div class="p-4 hover:bg-gray-50 cursor-pointer">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i data-lucide="user" class="w-5 h-5 text-blue-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium">Ahmad Rizki</h4>
                                            <p class="text-sm text-gray-600">3 pesan baru</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 hover:bg-gray-50 cursor-pointer">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <i data-lucide="user" class="w-5 h-5 text-green-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium">Siti Rahayu</h4>
                                            <p class="text-sm text-gray-600">Online</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 hover:bg-gray-50 cursor-pointer">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                            <i data-lucide="user" class="w-5 h-5 text-purple-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium">Budi Santoso</h4>
                                            <p class="text-sm text-gray-600">2 pesan baru</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2 bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="border-b p-4 bg-gray-50">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="user" class="w-5 h-5 text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Ahmad Rizki</h3>
                                        <p class="text-sm text-gray-600">Online</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="chat-container p-4 bg-gray-50 h-96">
                                <div class="space-y-4">
                                    <div class="flex justify-start">
                                        <div class="chat-message bg-white p-4 rounded-xl rounded-tl-none shadow-sm">
                                            <p>Halo, ada yang bisa saya bantu?</p>
                                            <span class="text-xs text-gray-500 mt-1 block">10:30</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-end">
                                        <div class="chat-message bg-blue-100 p-4 rounded-xl rounded-tr-none shadow-sm">
                                            <p>Halo admin, saya ingin menanyakan tentang proses pencairan dana</p>
                                            <span class="text-xs text-gray-500 mt-1 block">10:32</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-start">
                                        <div class="chat-message bg-white p-4 rounded-xl rounded-tl-none shadow-sm">
                                            <p>Untuk proses pencairan dana membutuhkan waktu 1x24 jam setelah barang kami terima dan verifikasi.</p>
                                            <span class="text-xs text-gray-500 mt-1 block">10:33</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-end">
                                        <div class="chat-message bg-blue-100 p-4 rounded-xl rounded-tr-none shadow-sm">
                                            <p>Baik, terima kasih informasinya</p>
                                            <span class="text-xs text-gray-500 mt-1 block">10:35</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t p-4 bg-white">
                                <div class="flex space-x-3">
                                    <input type="text" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Ketik pesan...">
                                    <button class="bg-blue-600 text-white px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                        <i data-lucide="send" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Overlay -->
    <div class="overlay" id="overlay"></div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Toggle sidebar on mobile
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('overlay');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });
        
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
        
        // Show different sections
        function showSection(sectionId) {
            // Hide all sections
            document.getElementById('dashboard-content').classList.add('hidden');
            document.getElementById('admin-verifikasi').classList.add('hidden');
            document.getElementById('admin-chat').classList.add('hidden');
            
            // Show selected section
            document.getElementById(sectionId).classList.remove('hidden');
            
            // Close sidebar on mobile after selection
            if (window.innerWidth < 768) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        }
        
        // Logout function
        function logout() {
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                window.location.href = 'index.html';
            }
        }
    </script>
</body>
</html>