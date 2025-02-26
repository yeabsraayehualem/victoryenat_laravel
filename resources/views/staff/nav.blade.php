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
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
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
                    <div class="sb-sidenav-menu-heading">Staff</div>
                    <a class="nav-link" href="{{ route('staff.dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">Menu</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseSchools" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                        Schools
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse" id="collapseSchools" aria-labelledby="headingOne"
                        data-bs-parent="#collapseLayouts">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('staff.schools') }}">All Schools</a>
                            <a class="nav-link" href="{{ route('staff.schools.active') }}">Active School</a>
                        </nav>
                    </div>

                     <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                        <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                        Users
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseUsers" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('staff.allusers') }}">All Users</a>
                                <a class="nav-link" href="{{ route('staff.staffs') }}">Staff</a>
                                <a class="nav-link" href="{{ route('staff.students') }}">Students</a>
                                <a class="nav-link" href="{{ route('staff.managers') }}">School Managers</a>
                                <a class="nav-link" href="{{ route('staff.teachers') }}">Teachers</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapsLessons" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Lessons
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsLessons" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link " href="{{ route('staff.lessons.all')}}" >
                                    Lessons
                                </a>

                                <a class="nav-link " href="{{ route('staff.subjects.all')}}" >
                                    Subjects
                                </a>

                            </nav>

                        </div>
                       
                        <div class="collapse" id="collapsExam" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#collapseExams" aria-expanded="false"
                                    aria-controls="collapseExams">
                                    Exams
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseExams" aria-labelledby="headingOne"
                                    data-bs-parent="#collapsExam">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ route('staff.exams.all')}}">All Exams</a>
                                        <a class="nav-link" href="{{route('staff.exams.new')}}">Add Exam</a>
                                    </nav>
                                </div>

                              
                               

                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#collapseQuestions" aria-expanded="false"
                                    aria-controls="collapseQuestions">
                                    Questions
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseQuestions" aria-labelledby="headingOne"
                                    data-bs-parent="#collapsExam">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{route('staff.questions.all')}}">All Questions</a>
                                        <a class="nav-link" href="{{ route('staff.questions.new')}}">Add Question</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>      
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseExamManagement" aria-expanded="false" aria-controls="collapseExamManagement">
                            <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                            Exam Management
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseExamManagement" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('staff.exams') }}">
                                    <i class="fas fa-calendar-alt me-2"></i>Exams
                                </a>
                                <a class="nav-link" href="{{ route('staff.exam.create') }}">
                                    <i class="fas fa-plus me-2"></i>Create Exam
                                </a>
                                <a class="nav-link" href="{{ route('staff.exam.questions') }}">
                                    <i class="fas fa-list me-2"></i>All Questions
                                </a>
                                <a class="nav-link" href="{{ route('staff.exam.create-question') }}">
                                    <i class="fas fa-plus me-2"></i>Create Question
                                </a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="{{ route('staff.reports.index')}}">Reports</a>
                        <div class="sb-sidenav-menu-heading">Profile</div>
                        <a class="nav-link " href="{{ route('staff.profile')}}"><i class="fa fa-user-circle"></i>
                            Profile</a>


                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small"></div>
                {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
            </div>
        </nav>
    </div>
