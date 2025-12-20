<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'HotelGo')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- Navbar -->
<nav style="background-color:#0a1f44; color:white; padding:15px 20px; display:flex; justify-content:space-between; align-items:center;">
    {{-- Hotel Name --}}
    <div style="font-size:22px; font-weight:bold;">HotelGo</div>

    {{-- Hamburger Icon --}}
    <div onclick="openMenu()" style="font-size:24px; cursor:pointer;">☰</div>
</nav>

<!-- Side Menu (Right) -->
<div id="sideMenu" style="
    height: 100%;
    width: 0;
    position: fixed;
    top: 0;
    right: 0; /* slide from the right */
    background-color: #142850;
    overflow-x: hidden;
    transition: 0.3s;
    padding-top: 60px;
    z-index: 1000;
">
    <a href="javascript:void(0)" onclick="closeMenu()" style="
        position: absolute;
        top: 20px;
        left: 20px; /* close button on left inside the menu */
        font-size: 30px;
        color: white;
        text-decoration: none;
    ">&times;</a>

    <ul style="list-style:none; padding:0; margin:0; color:white;">
        <li><a href="/" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Home</a></li>
        <li><a href="/profile" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Profile</a></li>
        <li><a href="/reservations" style="display:block; padding:12px 20px; color:white; text-decoration:none;">Past Reservations</a></li>
    </ul>
</div>




    {{-- Page Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer style="background-color:#0a1f44; color:white; padding:40px 20px; text-align:center;">
    <div style="max-width: 1200px; margin: auto; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 20px;">
        
        {{-- About Section --}}
        <div style="flex: 1; min-width: 200px;">
            <h3 style="margin-bottom: 10px;">About HotelGo</h3>
            <p style="font-size: 14px;">
                HotelGo helps guests book rooms easily and securely while helping hotels manage reservations efficiently.
            </p>
        </div>

        {{-- Quick Links --}}
        <div style="flex: 1; min-width: 150px;">
            <h4 style="margin-bottom: 10px;">Quick Links</h4>
            <ul style="list-style: none; padding: 0; font-size: 14px;">
                <li><a href="/" style="color: white; text-decoration: none;">Home</a></li>
                <li><a href="/rooms" style="color: white; text-decoration: none;">Rooms</a></li>
                <li><a href="/contact" style="color: white; text-decoration: none;">Contact</a></li>
            </ul>
        </div>

        {{-- Social Media --}}
        <div style="flex: 1; min-width: 150px;">
            <h4 style="margin-bottom: 10px;">Follow Us</h4>
            <p style="font-size: 14px;">
                <a href="#" style="color:white; margin-right:10px;">Facebook</a>
                <a href="#" style="color:white; margin-right:10px;">Twitter</a>
                <a href="#" style="color:white;">Instagram</a>
            </p>
        </div>

    </div>

    {{-- Bottom Copyright --}}
    <div style="margin-top: 30px; border-top: 1px solid #07152f; padding-top: 15px; font-size: 13px;">
        © {{ date('Y') }} HotelGo. All rights reserved.
    </div>
</footer>


</body>
</html>
<script>
function openMenu() {
    document.getElementById("sideMenu").style.width = "250px"; // width of the menu
}

function closeMenu() {
    document.getElementById("sideMenu").style.width = "0";
}
</script>