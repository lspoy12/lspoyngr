<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="style.css">
</head>
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3>Menu</h3>
        <button class="close-btn" onclick="toggleSidebar()">×</button>
    </div>
    <div class="sidebar-content">
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </div>
</div>

<button class="toggle-btn" onclick="toggleSidebar()">☰</button>

<style>
.sidebar {
    height: 100%;
    width: 250px;
    position: fixed;
    top: 0;
    left: -250px;
    background-color: #f4f4f4;
    transition: 0.3s;
    z-index: 1000;
    box-shadow: 2px 0 5px rgba(0,0,0,0.2);
}

.sidebar.active {
    left: 0;
}

.sidebar-header {
    padding: 20px;
    background: #333;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.close-btn {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
}

.sidebar-content ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-content ul li {
    padding: 15px 20px;
    border-bottom: 1px solid #ddd;
}

.sidebar-content ul li a {
    color: #333;
    text-decoration: none;
    display: block;
}

.toggle-btn {
    position: fixed;
    left: 20px;
    top: 20px;
    background: #333;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    z-index: 999;
}

@media screen and (max-width: 768px) {
    .sidebar {
        width: 100%;
        left: -100%;
    }
}
</style>

<script>
function toogleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
}

function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
}

// Close sidebar when clicking outside
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.querySelector('.toggle-btn');
    
    if (!sidebar.contains(event.target) && event.target !== toggleBtn) {
        sidebar.classList.remove('active');
    }
});

// Close sidebar on window resize if in mobile view
window.addEventListener('resize', function() {
    if (window.innerWidth > 768) {
        document.getElementById("sidebar").classList.remove("active");
    }
});
</script>
