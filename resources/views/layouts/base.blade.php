<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Victory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/png" href="/images/icon/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="/css/magnific-popup.css" />
    <link rel="stylesheet" href="/css/slicknav.min.css" />
    <link rel="stylesheet" href="/css/typography.css" />
    <link rel="stylesheet" href="/css/default-css.css" />
    <link rel="stylesheet" href="/css/styles.css" />
    <link rel="stylesheet" href="/css/responsive.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="/js/vendor/modernizr-2.8.3.min.js"></script>
    <style>
        .wide-swal-popup {
            max-width: 40%;
            /* Adjust the width as needed */
            width: 30%;
            /* Optional: Set a percentage width for responsiveness */
        }
    </style>
</head>


<body>
    <!-- This is for the browser if it is an old version -->
    <!-- [if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif] -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    {{-- {% for m in messages %}
  {{ m }}
  {% endfor %} --}}
    <header id="header">
        <div class="header-top">
            <div class="container">
                <div class="row d-flex flex-center">
                    <div class="col-sm-8">
                        <div class="ht-address">
                            <ul>
                                <li>
                                    <i class="fa fa-phone"></i>Phone number
                                </li>
                                <li>
                                    <i class="fa fa-envelope"></i>info@Victory.com
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="ht-social">
                            <ul class="social">
                                <li>
                                    <a href="#"><i class="fa fa-telegram"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-bottom">
            <div class="container">
                <div class="header-bottom-inner">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-sm-9">
                            <div class="logo">
                                <a href="index2.html">
                                    <img src="/images/icon/logo.png" alt="logo" />
                                    <span class="logo-text">Victory</span>
                                </a>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 d-none d-lg-block">
                            <div class="main-menu">
                                <nav>
                                    <ul id="m_menu_active">
                                        <li class="active">
                                            <a href="/">Home</a>
                                        </li>
                                        <li>
                                            <a href="">About</a>
                                        </li>
                                        <li>
                                            <a href=""">Exams</a>
                                            <ul class="submenu">
                                                <li>
                                                    <a href="">Exam details</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="">Schools</a>
                                            <ul class="submenu">
                                                <li>
                                                    <a href="">Schools details</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="/blog">blog</a>
                                            <ul class="submenu">
                                                <li>
                                                    <a href="">blog details</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="">Contact</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-1 col-lg-2 col-sm-3">
                            <div class="hb-left">
                                <ul>
                                    <li class="search_btn">
                                        <i class="fa fa-search"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-2 col-sm-5">
                            <div class="header-bottom-right-style-2">
                                <ul class="d-grid row">
                                    <li class="col-6">
                                        @if (auth()->user())
                                            <a href="{{ route('logout') }}" class="btn btn-light btn-round">Logout</a>
                                        @else
                                            <a id="login" type="button" class="btn btn-light btn-round"
                                                href="#">Log
                                                in</a>
                                        @endif
                                    </li>

                                    <li class="col-6">

                                        <!-- Example single danger button -->
                                        @if (auth()->user())
                                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-round active">
                                                Dashboard </a>
                                        @else
                                            <a type="button" class="btn btn-primary btn-round active"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Sign Up
                                            </a>
                                        @endif

                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#"
                                                    id="teacherSignUp">Teacher</a></li>
                                            <li><a class="dropdown-item" href="#"
                                                    id="studentSignUp">Student</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>


                        </div>
                        <div class="col-12 d-block d-lg-none">
                            <div id="mobile_menu"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    @yield('content')


    <footer>
        <div class="footer-top has-color pt--120 pb--30">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="logo widget widget-company">
                            <a href="/"><img src="/images/icon/logo.png" alt="image" /></a>
                            <span class="logo-text">Victory</span>
                            <div class="address">
                                <h6>About Us</h6>
                                <p>office office office office officeofficeoffice office office officeofficeofficeoffice
                                    officeofficeoffice</p>
                            </div>

                            <ul class="social">
                                <li>
                                    <a href="#"><i class="fa fa-telegram"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="widget footer-link">
                            <h4 class="fwidget-title mb-5 pb-3 primary-color">Menu</h4>
                            <ul>
                                <li>
                                    <a href="#"><i class="fa fa-arrow-right"></i>Home</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-arrow-right"></i>About Us</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-arrow-right"></i>Exams</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-arrow-right"></i>Schools</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-arrow-right"></i>Blog</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="widget widget-opening">
                            <h4 class="fwidget-title mb-5 pb-3 primary-color">Contact</h4>
                            <div class="logo widget widget-company">
                                <div class="address">
                                    <h6>OFFICE ADDRESS</h6>
                                    <p>office address</p>
                                </div>
                                <div class="address">
                                    <h6>BUSINESS PHONE</h6>
                                    <p>+25121139577</p>
                                </div>
                                <div class="address">
                                    <h6>BUSINESS EMAIL</h6>
                                    <p>info@Victory.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>
                        Copyright © 2024 <span><a class="primary-color" href="/"
                                target="_blank">Victory</a></span> - All Rights
                        Reserved. Made by <span><a class="primary-color" href="/"
                                target="_blank">Yoraki</a></span>
                    </p>
                </div>
            </div>
        </div>

        
       
        
    </footer>

    <script src="/js/vendor/jquery-2.2.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/jquery.magnific-popup.min.js"></script>
    <script src="/js/jquery.slicknav.min.js"></script>
    <script src="/js/plugins.js"></script>
    <script src="/js/scripts.js"></script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var input = document.querySelector('#phone')
            window.intlTelInput(input, {
                initialCountry: 'et',
                onlyCountries: ['et'],
                utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js'
            })
        })
    </script>

    <script>
        function selectBox(box) {
            var selectElement = box.querySelector('select')
            selectElement.click()
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('studentSignUp').addEventListener('click', function() {
            const studForm = document.getElementById('studentForm').outerHTML;
            Swal.fire({
                title: 'Student Sign-Up',
                html: `<div class="container mt-5">
            <h2 class="text-center">Student Sign-Up</h2>

            <form id="studentForm" method="POST" action="/newstud">
                @csrf
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control"
                            placeholder="Enter your first name" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control"
                            placeholder="Enter your last name" required>
                    </div>
                </div>
                <input type="hidden" name="is_student" value="true">
                <div class="row">

                    <div class="mb-3 col-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control"
                            placeholder="09..." required>
                    </div>

                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="school" class="form-label">School</label>
                        <select name="school" id="school" class="form-control" required>
                            <option value="">Select School</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="grade" class="form-label">Grade</label>
                        <input type="number" id="grade" name="grade" class="form-control" placeholder="">
                    </div>

                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Enter password" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" placeholder="Confirm password" required>
                    </div>

                </div>

                <div class="d-flex justify-content-between">
                    <button class="btn btn-success" type="submit">Submit</button>
                    <button type="reset" id="studentSignUp" class="btn btn-danger">clear</button>
                </div>
            </form>
        </div>`,
                showConfirmButton: false,
                focusConfirm: false,
                customClass: {
                    popup: 'wide-swal-popup',
                },
                preConfirm: () => {
                    const form = Swal.getPopup().querySelector('form');
                    return fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                            },
                            body: new FormData(form),
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Submission failed');
                            }
                            return response.json();
                        })
                        .catch(error => {
                            Swal.showValidationMessage(error.message);
                        });
                },
            });
        });

        document.getElementById('teacherSignUp').addEventListener('click', function() {
            const studForm = document.getElementById('teacherForm').outerHTML;
            Swal.fire({
                title: 'Teacher Sign-Up',
                html: ` <div class="container mt-5">
            <h2 class="text-center">Student Sign-Up</h2>

            <form id="teacherForm" method="POST" action="/newteacher">
                @csrf
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control"
                            placeholder="Enter your first name" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control"
                            placeholder="Enter your last name" required>
                    </div>
                </div>
                <input type="hidden" name="is_student" value="true">
                <div class="row">

                    <div class="mb-3 col-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control"
                            placeholder="09..." required>
                    </div>

                </div>
                <div class="row">
                    <div class="mb-3 col-12">
                        <label for="school" class="form-label">School</label>
                        <select name="school" id="school" class="form-control" required>
                            <option value="">Select School</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>


                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Enter password" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" placeholder="Confirm password" required>
                    </div>

                </div>

                <div class="d-flex justify-content-between">
                    <button class="btn btn-success" type="submit">Submit</button>
                    <button type="reset" id="studentSignUp" class="btn btn-danger">clear</button>
                </div>
            </form>
        </div>`,
                showConfirmButton: false,
                focusConfirm: false,
                customClass: {
                    popup: 'wide-swal-popup',
                },
                preConfirm: () => {
                    const form = Swal.getPopup().querySelector('form');
                    return fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                            },
                            body: new FormData(form),
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Submission failed');
                            }
                            return response.json();
                        })
                        .catch(error => {
                            Swal.showValidationMessage(error.message);
                        });
                },
            });
        });
        document.getElementById('login').addEventListener('click', function() {
            const loginForm = document.getElementById('loginForm').outerHTML;
            Swal.fire({
                title: 'Login',
                html: `<div class="container mt-5">
            <h2 class="text-center">Login</h2>

            <form id="loginForm" method="POST" action="/login">
                @csrf

                <div class="row">

                    <div class="mb-3 col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Enter your email" required>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Enter password" required>
                    </div>
                </div>


                <div class="d-flex justify-content-between">
                    <button class="btn btn-success" type="submit">Submit</button>
                    <button type="reset" id="studentSignUp" class="btn btn-danger">clear</button>
                </div>
            </form>
        </div>`,
                showConfirmButton: false,
                focusConfirm: false,
                customClass: {
                    popup: 'wide-swal-popup',
                },
                preConfirm: () => {
                    const form = Swal.getPopup().querySelector('form');
                    return fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                            },
                            body: new FormData(form),
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Submission failed');
                            }
                            return response.json();
                        })
                        .catch(error => {
                            Swal.showValidationMessage(error.message);
                        });
                },
            });

        });
    </script>
    @yield('js')

</body>

</html>
