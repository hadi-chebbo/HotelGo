<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'HotelGo')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- Navbar -->
<nav style="background-color:#1a2a5b; color:white; padding:15px 20px; display:flex; justify-content:space-between; align-items:center;">
    {{-- Hotel Name --}}
    <div style="font-size:22px; font-weight:bold;"><span >Hotel</span><span class="text-blue-500">Go</span></div>
    <div style="display:flex; align-items:center; gap:15px;">
        {{-- Login/Register --}}
        @guest
        <a href="/login" style="color:white; text-decoration:none; padding:8px 12px; border:1px solid white; border-radius:4px;">Login</a>
        <a href="/register" style="color:#1a2a5b; background:white; text-decoration:none; padding:8px 12px; border-radius:4px;">Register</a>
        @endguest
        {{-- Hamburger Icon --}}
        <div onclick="openMenu()" style="font-size:24px; cursor:pointer;">☰</div>
    </div>
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
<footer style="background-color:#0a1f44; color:white; padding:50px 20px; text-align:left;">
    <div style="max-width: 1200px; margin: auto; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 40px;">

        {{-- About Section --}}
        <div style="flex: 1; min-width: 220px;">
            <h3 style="margin-bottom: 15px; font-size:22px; font-weight:bold;">About HotelGo</h3>
            <p style="font-size: 15px; line-height:1.8;">
                HotelGo helps guests book rooms easily and securely while assisting hotels in managing reservations efficiently. Experience comfort, convenience, and exceptional service with us.
            </p>
        </div>

        {{-- Location & Contact --}}
        <div style="flex: 1; min-width: 200px;">
            <h4 style="margin-bottom: 15px; font-size:20px; font-weight:bold;">Our Location</h4>
            <p style="font-size: 15px; line-height:1.8;">
                📍 Lebanon, Beirut<br>
                📞 +961 70 123 456<br>
                ✉️ <a href="mailto:info@hotelgo.com" style="color:white; text-decoration:underline;">info@hotelgo.com</a>
            </p>
        </div>

        {{-- Social Media --}}
        <div style="flex: 1; min-width: 180px;">
            <h4 style="margin-bottom: 15px; font-size:20px; font-weight:bold;">Follow Us</h4>
            <p style="font-size: 15px; line-height:1.8;">
                <a href="#" style="color:white; margin-right:15px; text-decoration:none;">Facebook</a>
                <a href="#" style="color:white; margin-right:15px; text-decoration:none;">Twitter</a>
                <a href="#" style="color:white; text-decoration:none;">Instagram</a>
            </p>
        </div>

    </div>

    {{-- Bottom Copyright --}}
    <div style="margin-top: 50px; border-top: 1px solid #07152f; padding-top: 20px; font-size: 14px; text-align:center;">
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