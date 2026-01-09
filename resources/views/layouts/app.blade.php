<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkpoint Tracker - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 100%);
            color: #fff;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #1a1a1a 0%, #141414 100%);
            border-right: 1px solid rgba(212, 175, 55, 0.1);
            padding: 20px 0;
            z-index: 1000;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 0 20px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 20px;
        }

        .logo-content {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #D4AF37 0%, #F4D03F 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
            transition: transform 0.3s ease;
        }

        .logo-icon:hover {
            transform: scale(1.05);
        }

        .logo-icon svg {
            width: 26px;
            height: 26px;
            fill: #000;
        }

        .logo-text h1 {
            font-size: 17px;
            font-weight: 700;
            color: #fff;
            margin: 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .logo-text p {
            font-size: 11px;
            color: #888;
            margin: 0;
            font-weight: 500;
        }

        .sidebar-menu {
            list-style: none;
            padding: 10px 12px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            color: #999;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: #D4AF37;
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .sidebar-menu a:hover {
            background: rgba(212, 175, 55, 0.08);
            color: #D4AF37;
            transform: translateX(4px);
        }

        .sidebar-menu a:hover::before {
            transform: scaleY(1);
        }

        .sidebar-menu a.active {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.15) 0%, rgba(212, 175, 55, 0.05) 100%);
            color: #D4AF37;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(212, 175, 55, 0.15);
        }

        .sidebar-menu a.active::before {
            transform: scaleY(1);
        }

        .sidebar-menu svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
            transition: transform 0.3s ease;
        }

        .sidebar-menu a:hover svg {
            transform: scale(1.1);
        }

        .logout-btn {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            margin-top: 30px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 10px 12px;
            padding-bottom: 30px;
        }

        .logout-btn a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px;
            background: transparent;
            border: 2px solid rgba(212, 175, 55, 0.5);
            color: #D4AF37;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .logout-btn a:hover {
            background: linear-gradient(135deg, #D4AF37 0%, #F4D03F 100%);
            color: #000;
            border-color: #D4AF37;
            box-shadow: 0 4px 16px rgba(212, 175, 55, 0.4);
            transform: translateY(-2px);
        }

        /* Header */
        .header {
            position: fixed;
            left: 280px;
            top: 0;
            right: 0;
            height: 75px;
            background: rgba(26, 26, 26, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
            padding: 0 35px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 999;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.2);
        }

        .header-title h2 {
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            margin: 0;
            letter-spacing: 0.5px;
            background: linear-gradient(90deg, #fff 0%, #D4AF37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-title p {
            font-size: 13px;
            color: #888;
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-stats {
            display: flex;
            gap: 20px;
        }

        .stat-badge {
            padding: 10px 20px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(212, 175, 55, 0.05) 100%);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 25px;
            font-size: 13px;
            color: #D4AF37;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(212, 175, 55, 0.1);
            transition: all 0.3s ease;
        }

        .stat-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            margin-top: 75px;
            padding: 35px;
            min-height: calc(100vh - 75px);
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: linear-gradient(135deg, #D4AF37 0%, #F4D03F 100%);
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
            transition: all 0.3s ease;
        }

        .mobile-menu-toggle:hover {
            transform: scale(1.05);
        }

        .mobile-menu-toggle span {
            display: block;
            width: 22px;
            height: 2px;
            background: #000;
            margin: 5px auto;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        /* Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 999;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar-overlay.active {
                display: block;
            }
            
            .header,
            .main-content {
                margin-left: 0;
                left: 0;
            }

            .header {
                padding: 0 80px 0 20px;
            }

            .header-title h2 {
                font-size: 20px;
            }

            .main-content {
                padding: 20px;
            }

            .stat-badge {
                font-size: 11px;
                padding: 8px 14px;
            }
        }

        @media (max-width: 480px) {
            .header-stats {
                gap: 10px;
            }

            .header-title h2 {
                font-size: 18px;
            }
        }

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(212, 175, 55, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(212, 175, 55, 0.5);
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleMenu()"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="logo-content">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                    </svg>
                </div>
                <div class="logo-text">
                    <h1>CHECKPOINT</h1>
                    <p>Admin Panel</p>
                </div>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ url('/home') }}" class="{{ Request::is('home') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ url('/admin') }}" class="{{ Request::is('admin*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    Admin
                </a>
            </li>
            <li>
                <a href="{{ url('/checkpoints') }}" class="{{ Request::is('checkpoints*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    Checkpoints
                </a>
            </li>
            <li>
                <a href="{{ url('/unit_trucks') }}" class="{{ Request::is('unit_trucks*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z"/>
                    </svg>
                    Unit Truck
                </a>
            </li>
            <li>
                <a href="{{ url('/drivers') }}" class="{{ Request::is('drivers*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    Akun Driver
                </a>
            </li>
            <li>
                <a href="{{ url('/driver_money') }}" class="{{ Request::is('driver_money*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    Saldo Driver
                </a>
            </li>
            <li>
                <a href="{{ url('/driver_log_activities') }}" class="{{ Request::is('driver_log_activities*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                    Riwayat
                </a>
            </li>
            <li>
                <a href="{{ url('/laporan') }}" class="{{ Request::is('laporan*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                    </svg>
                    Laporan
                </a>
            </li>
        </ul>

        <div class="logout-btn">
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                </svg>
                LOGOUT
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Header -->
    <div class="header">
        <div class="header-title">
            <h2>DASHBOARD</h2>
        </div>
        <div class="header-right">
            <div class="header-stats">
                <div class="stat-badge">👤 {{ Auth::user()->name }}</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Close menu when clicking on a link (mobile)
        if (window.innerWidth <= 768) {
            document.querySelectorAll('.sidebar-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    toggleMenu();
                });
            });
        }
    </script>
</body>
</html>