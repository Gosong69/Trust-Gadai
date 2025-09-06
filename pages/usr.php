<?php
include "db.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: ../index.html");
    exit;
}

// ambil pesan chat
$q = $conn->query("SELECT * FROM chat ORDER BY created_at ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - Trust Gadai</title>
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
        
        .upload-area {
            border: 2px dashed #cbd5e1;
            transition: all 0.3s ease;
        }
    
        .upload-area:hover {
            border-color: #3b82f6;
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
        
        .hover-scale {
            transition: transform 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
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
                        <img src="../assets/img/logo_fix.png" alt="Trust Gadai Logo" class="w-20 h-15">
                    </div>
                    <span class="text-2xl font-bold text-gray-800">Trust Gadai</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="flex items-center space-x-2 text-gray-700">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i data-lucide="user" class="w-5 h-5 text-blue-600"></i>
                            </div>
                            <span><?php echo $_SESSION['nama']; ?></span>
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
        <div class="sidebar bg-blue-800 text-white">
            <div class="p-4">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <img src="../assets/img/logo_fix.png" alt="Trust Gadai Logo" class="w-20 h-15">
                    </div>
                    <span class="text-xl font-bold">Trust Gadai</span>
                </div>
                
                <nav class="space-y-2">
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors" 
                    onclick="showSection('dashboard-content', this); return false;">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors" 
                    onclick="showSection('upload-barang', this); return false;">
                        <i data-lucide="upload" class="w-5 h-5"></i>
                        <span>Upload Barang</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors" 
                    onclick="showSection('cek-barang', this); return false;">
                        <i data-lucide="package" class="w-5 h-5"></i>
                        <span>Cek Barang</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors" 
                    onclick="logout(); return false;">
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
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard User</h1>
                    <button class="md:hidden text-gray-600" id="sidebar-toggle">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
                
                <!-- Dashboard Content -->
                <div id="dashboard-content">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-blue-50 p-5 rounded-xl fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-600">Barang Digadaikan</p>
                                    <h3 class="text-2xl font-bold mt-1">5</h3>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i data-lucide="package" class="w-6 h-6 text-blue-600"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 p-5 rounded-xl fade-in" >
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-600">Dana Tersedia</p>
                                    <h3 class="text-2xl font-bold mt-1">Rp 8.250.000</h3>
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i data-lucide="dollar-sign" class="w-6 h-6 text-green-600"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-purple-50 p-5 rounded-xl fade-in" >
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-600">Pesan Baru</p>
                                    <h3 class="text-2xl font-bold mt-1">3</h3>
                                </div>
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i data-lucide="message-square" class="w-6 h-6 text-purple-600"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-xl shadow-md slide-up" >
                        <h2 class="text-xl font-bold mb-4">Barang Terbaru</h2>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="p-3 text-left">Nama Barang</th>
                                        <th class="p-3 text-left">Tanggal</th>
                                        <th class="p-3 text-left">Nilai</th>
                                        <th class="p-3 text-left">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b">
                                        <td class="p-3">iPhone 13 Pro</td>
                                        <td class="p-3">12 Jun 2023</td>
                                        <td class="p-3">Rp 7.500.000</td>
                                        <td class="p-3"><span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Aktif</span></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="p-3">Laptop ASUS ROG</td>
                                        <td class="p-3">10 Jun 2023</td>
                                        <td class="p-3">Rp 10.000.000</td>
                                        <td class="p-3"><span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-sm">Proses</span></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="p-3">Ring Emas 5gr</td>
                                        <td class="p-3">5 Jun 2023</td>
                                        <td class="p-3">Rp 5.200.000</td>
                                        <td class="p-3"><span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Aktif</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Upload Barang Section (Initially Hidden) -->
                <div id="upload-barang" class="hidden">
                    <h2 class="text-2xl font-bold mb-6">Upload Barang Gadai</h2>
                    
                    <div class="bg-gray-50 p-6 rounded-xl mb-6 slide-up">
                        <form class="space-y-6">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Nama Barang</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Masukkan nama barang">
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Kategori Barang</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option>Pilih kategori</option>
                                    <option>Elektronik</option>
                                    <option>Perhiasan</option>
                                    <option>Kendaraan</option>
                                    <option>Lainnya</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Deskripsi Barang</label>
                                <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" rows="3" placeholder="Deskripsikan kondisi dan spesifikasi barang"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Perkiraan Nilai Barang (Rp)</label>
                                <input type="number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Masukkan perkiraan nilai">
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Upload Foto Barang</label>
                                <div class="upload-area border-dashed border-2 border-gray-300 rounded-lg p-8 text-center cursor-pointer">
                                    <i data-lucide="upload-cloud" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                                    <p class="text-gray-600">Klik untuk upload atau drop file di sini</p>
                                    <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG (Maks. 5MB)</p>
                                </div>
                            </div>
                            
                            <button type="button" class="w-full bg-gradient-to-r from-blue-600 to-cyan-600 text-white py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-cyan-700 transition-all transform hover:scale-105">
                                Ajukan Gadai
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Cek Barang Section (Initially Hidden) -->
                <div id="cek-barang" class="hidden">
                    <h2 class="text-2xl font-bold mb-6">Cek Status Barang</h2>
                    
                    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 slide-up">
                        <div class="border-b">
                            <div class="flex overflow-x-auto">
                                <button class="px-6 py-3 border-b-2 border-blue-600 text-blue-600 font-medium">Semua</button>
                                <button class="px-6 py-3 border-b-2 border-transparent text-gray-600 hover:text-blue-600 font-medium">Proses</button>
                                <button class="px-6 py-3 border-b-2 border-transparent text-gray-600 hover:text-blue-600 font-medium">Aktif</button>
                                <button class="px-6 py-3 border-b-2 border-transparent text-gray-600 hover:text-blue-600 font-medium">Selesai</button>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i data-lucide="smartphone" class="w-8 h-8 text-gray-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">iPhone 13 Pro</h3>
                                        <p class="text-gray-600">ID: TG-12345</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-600">Nilai Gadai</p>
                                    <p class="font-semibold text-lg">Rp 7.500.000</p>
                                    <button class="bg-red-100 text-white-800 px-2 py-1 rounded-full text-sm" onclick="showSection('chat-user', this); return false;">Chat Admin</button>
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Aktif</span>
                                </div>
                            </div>
                        <?php
                            session_start();
                            if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
                                header("Location: index.php");
                                exit;
                            }
                            include "db.php";

                            $id = $_GET['id'];
                            $user_id = $_SESSION['user_id'];

                            $q = $conn->query("SELECT * FROM gadai WHERE id=$id AND user_id=$user_id");
                            if ($q->num_rows == 0) {
                                echo "Data tidak ditemukan.";
                                exit;
                            }
                            $d = $q->fetch_assoc();
                            ?>
                            <h1>Detail Barang Gadai</h1>
                            <p><h3 class="font-semibold">Nama Barang:</h3> <?php echo $d['nama_barang']; ?></p>
                            <p><b>Deskripsi:</b> <?php echo $d['deskripsi']; ?></p>
                            <p><b>Kategori:</b> <?php echo $d['kategori']; ?></p>
                            <p><b>Harga:</b> Rp <?php echo number_format($d['harga']); ?></p>
                            <p><b>Lokasi:</b> <?php echo $d['lokasi']; ?></p>
                            <p><b>Status:</b> <?php echo $d['status']; ?></p>

                            <h3>Foto Barang</h3>
                            <?php for ($i=1; $i<=5; $i++): ?>
                                <?php if (!empty($d["foto$i"])): ?>
                                    <img src="uploads/<?php echo $d["foto$i"]; ?>" width="200" style="margin:5px;">
                                <?php endif; ?>
                            <?php endfor; ?>

                        </div>
                    </div>
                </div>
                
                <!-- Chat User Section (Initially Hidden) -->
                <div id="chat-user" class="hidden">
                    <h2 class="text-2xl font-bold mb-6">Chat dengan Admin</h2>
                    
                    <div class="bg-white rounded-xl shadow-md overflow-hidden slide-up">
                        <div class="border-b p-4 bg-gray-50">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="user" class="w-5 h-5 text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold">Admin Trust Gadai</h3>
                                    <p class="text-sm text-gray-600">Online</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="chat-container p-4 bg-gray-50 h-96">
                            <div class="space-y-4">
                                <?php while($c = $q->fetch_assoc()){ ?>
                                    <?php if ($c['sender_role'] === 'user') { ?>
                                        <!-- pesan user -->
                                        <div class="flex justify-end">
                                            <div class="chat-message bg-blue-100 p-4 rounded-xl rounded-tr-none shadow-sm">
                                                <p><?php echo htmlspecialchars($c['message']); ?></p>
                                                <span class="text-xs text-gray-500 mt-1 block"><?php echo $c['created_at']; ?></span>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <!-- pesan admin -->
                                        <div class="flex justify-start">
                                            <div class="chat-message bg-white p-4 rounded-xl rounded-tl-none shadow-sm">
                                                <p><?php echo htmlspecialchars($c['message']); ?></p>
                                                <span class="text-xs text-gray-500 mt-1 block"><?php echo $c['created_at']; ?></span>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div class="border-t p-4 bg-white">
                            <form method="post" action="chat.php" class="flex space-x-3">
                                <input type="text" name="message" required
                                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Ketik pesan...">
                                <button type="submit" class="bg-blue-600 text-white px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                    <i data-lucide="send" class="w-5 h-5"></i>
                                </button>
                            </form>
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
        function showSection(sectionId, el) {
            // Hide all sections
            document.getElementById('dashboard-content').classList.add('hidden');
            document.getElementById('upload-barang').classList.add('hidden');
            document.getElementById('cek-barang').classList.add('hidden');
            document.getElementById('chat-user').classList.add('hidden');

            // Show selected section
            document.getElementById(sectionId).classList.remove('hidden');

            // Remove active state from all nav links
            document.querySelectorAll('.sidebar nav a').forEach(link => {
                link.classList.remove('bg-blue-700');
            });

            // Add active state to current link
            if (el) {
                el.classList.add('bg-blue-700');
            }

            // Close sidebar on mobile after selection
            if (window.innerWidth < 768) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        }

        
        // Logout function
        function logout() {
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                window.location.href = 'logout.php';
            }
        }
    </script>
</body>
</html>