<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo isset($title) ? $title . ' - Admin' : 'Admin Dashboard'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome FIXED (CORS SAFE) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            background: #f5f7fa;
            min-height: 100vh;
        }

        /* Sidebar collapse */
        .sidebar.active {
            width: 60px;
        }

        .sidebar.active .logo img {
            width: 40px;
        }

        .sidebar.active .nav li a span {
            display: none;
        }

        .sidebar.active .nav li a i:last-child {
            display: none;
        }

        .sidebar.active .submenu {
            display: none !important;
        }

        .main-content.active {
            margin-left: 60px;
            width: calc(100% - 60px);
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: #2c3e50;
            color: #fff;
            position: fixed;
            height: 100%;
            overflow-y: auto;
            transition: 0.3s;
        }

        .sidebar .logo {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar .logo img {
            width: 70px;
            border-radius: 50%;
        }

        .sidebar .nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar .nav li {
            width: 100%;
        }

        /* Menu style */
        .sidebar .nav li a {
            padding: 12px 18px;
            display: flex;
            align-items: center;
            color: #fff;
            text-decoration: none;
            gap: 10px;
        }

        .sidebar .nav li a:hover,
        .sidebar .nav li.active>a {
            background: #1abc9c;
        }

        .sidebar .nav li a i:last-child {
            margin-left: 0px;
        }

        /* Submenu */
        .submenu {
            background: #34495e;
        }

        .submenu a {
            padding: 10px 19px !important;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .submenu.collapse.show {
            background: #34495e;
            padding: 0px;
        }
        .submenu li {
    list-style-type: none;
}.submenu {
    padding: 0;
}

        /* Main content */
        .main-content {
            margin-left: 220px;
            width: calc(100% - 220px);
            transition: 0.3s;
        }

        .topbar {
            height: 60px;
            background: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .content-area {
            padding: 20px;
        }
    </style>
</head>

<body>


    

    <div class="sidebar">
        <div class="logo">
            <img src="<?php echo base_url('assets/images/plan_journey.jpg'); ?>" alt="Logo">
        </div>

        <ul class="nav">

            <li class="<?php echo (isset($title) && strpos($title, 'Dashboard') !== false) ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/dashboard'); ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

          
            <li>
                <a data-bs-toggle="collapse"
                    href="#homeMenu"
                    aria-expanded="false"
                    aria-controls="homeMenu">
                    <i class="fas fa-home"></i>
                    <span>Home Page</span>
                    <i class="fas fa-angle-down"></i>
                </a>

                <ul class="collapse submenu" id="homeMenu">
                    <li><a href="<?= base_url('admin/video'); ?>"><i class="far fa-circle"></i> Manage Videos</a></li>
                    <li><a href="<?= base_url('admin/banner'); ?>"><i class="far fa-circle"></i> Manage Banners</a></li>
                    <li><a href="<?= base_url('admin/adverties_banner'); ?>"><i class="far fa-circle"></i> Advertisement Banner</a></li>
                    <li><a href="<?= isset($home->id) ? base_url('admin/home_page/edit/' . $home->id) : base_url('admin/home_page'); ?>">
                            <i class="far fa-circle"></i> Manage Settings</a>
                    </li>
                </ul>
            </li>


            <li class="<?php echo (isset($title) && strpos($title, 'locations') !== false) ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/locations'); ?>">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Manage Locations</span>
                </a>
            </li>

            <li class="<?php echo (isset($title) && strpos($title, 'Package') !== false) ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/package'); ?>">
                    <i class="fas fa-suitcase-rolling"></i>
                    <span>Manage Packages</span>
                </a>
            </li>
            <li class="<?php echo (isset($title) && strpos($title, 'activities') !== false) ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/activities'); ?>">
                    <i class="fas fa-suitcase-rolling"></i>
                    <span>Manage Activities</span>
                </a>
            </li>

            <li class="<?php echo (isset($title) && strpos($title, 'blog') !== false) ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/blog'); ?>">
                    <i class="fas fa-blog"></i>
                    <span>Manage Blogs</span>
                </a>
            </li>
            <li>
                <a data-bs-toggle="collapse"
                    href="#pagesmenu"
                    aria-expanded="false"
                    aria-controls="pagesmenu">
                   <i class="fas fa-file"></i>
                    <span>Pages</span>
                    <i class="fas fa-angle-down"></i>
                </a>

                <ul class="collapse submenu" id="pagesmenu">
                    <li><a href="<?= base_url('admin/about_us'); ?>"><i class="far fa-circle"></i> Manage About</a></li>
                    <li><a href="<?= base_url('admin/contact'); ?>"><i class="far fa-circle"></i> Manage Contact_Us</a></li>
                    <li><a href="<?= base_url('admin/footer'); ?>"><i class="far fa-circle"></i> Manage Footer</a></li>
                    <li><a href="<?= base_url('admin/recent_experience'); ?>"><i class="far fa-circle"></i> Manage Customer Experience</a></li>
                  
                </ul>
            </li>

            <li>
                <a href="<?php echo site_url('admin/change_password'); ?>">
                    <i class="fas fa-key"></i>
                    <span>Change Password</span>
                </a>
            </li>

            <li>
                <a href="<?php echo site_url('admin/logout'); ?>">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>

        </ul>

    </div>

    <div class="main-content">
        <div class="topbar">
            <button class="btn btn-sm btn-outline-secondary toggle"
                onclick="document.querySelector('.sidebar').classList.toggle('active');
                     document.querySelector('.main-content').classList.toggle('active');">
                ☰
            </button>

            <div>
                Welcome, <strong><?php echo $this->session->userdata('admin_name') ?? 'Admin'; ?></strong>
            </div>
        </div>

        <div class="content-area container-fluid">

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>
            <script>
                document.querySelectorAll('.submenu a').forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                });
            </script>