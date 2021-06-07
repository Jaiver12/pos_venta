<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Panel Administrador</title>
        <link href="<?=BASE_URL?>Assets/css/datatable-style.css" rel="stylesheet" />
        <link href="<?=BASE_URL?>Assets/css/datatables.min.css" rel="stylesheet" />
        <link href="<?=BASE_URL?>Assets/css/styles.css" rel="stylesheet" />
        <script src="<?=BASE_URL?>Assets/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Pos Ventas</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->

            <!-- Navbar-->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Perfil</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="<?=BASE_URL?>Users/logout">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Panel Principal
                            </a>

                            <div class="sb-sidenav-menu-heading">Interfaces</div>


                            <a class="nav-link" href="<?=BASE_URL?>Clients">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Clientes
                            </a>

                            <a class="nav-link" href="<?=BASE_URL?>Categories">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Cateorias
                            </a>

                            <a class="nav-link" href="<?=BASE_URL?>Medidas">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Medidas
                            </a>

                            <div class="sb-sidenav-menu-heading">Opciones</div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseConfig" aria-expanded="false" aria-controls="collapseConfig">
                                <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                                Configuraciones
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseConfig" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?=BASE_URL?>Users"><i class="fas fa-user mr-3"></i>  Usuarios</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Cajas</a>
                                </nav>
                            </div>

                           <!-- <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            </a> -->

                        </div>
                    </div>

                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4 mt-2">

