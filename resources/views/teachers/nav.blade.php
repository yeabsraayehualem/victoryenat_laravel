<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3 mt-5 mb-2" href="/"><img src="/assets/img/logo1.png" alt="" srcset=""
            class="img-fluid w-25"></a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>
    <!-- Navbar Search-->/
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <!-- <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." -->
                <!-- aria-describedby="btnNavbarSearch" /> -->
            <!-- <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button> -->
        </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">Settings</a></li>
                <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark  scrollbar-hidden" id="sidenavAccordion">
            <div class="sb-sidenav-menu ">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Teacher</div>
                    <a class="nav-link" href="{{ route('manager.dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">Menu</div>
                    <a class="nav-link collapsed" href="{{ route('teacher.subjects')}}" ><i class="fas fa-chalkboard-teacher"></i>
                        Subjects
                    </a>

                    
                    <a class="nav-link collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapseExamListMenu" aria-expanded="false" aria-controls="collapsePages">
                                    <div class="sb-nav-link-icon"><i class="fas fa-graduation-cap"></i></div>

                                    Exam
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseExamListMenu" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ route('teacher.upcomingExams') }}" >Upcoming Exams</a>
                                        <a class="nav-link" href="{{ route('teacher.pastExams') }}" >Past Exams</a>
                                    </nav>
                                </div>
                    
                       
                       

                                <a class="nav-link collapsed" href="{{ route('teacher.questions') }}" >
                                  <i class="fa fa-book"></i>  Questions
                                </a>
                            
                        <div class="sb-sidenav-menu-heading">Profile</div>
                        <a class="nav-link " href="layout-sidenav-light.html"><i class="fa fa-user-circle"></i>
                            Profile</a>


                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small"></div>
                {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
            </div>
        </nav>
    </div>
