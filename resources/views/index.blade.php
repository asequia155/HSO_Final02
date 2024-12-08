<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hollywood Spectacle Optical</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('owl-slider/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('owl-slider/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/icons-fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/icons-linear.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.css">
    <link href="{{ asset('style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('style-responsive.css') }}" rel="stylesheet" type="text/css">

    <!-- jQuery and jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Other Scripts -->
    <script src="{{ asset('owl-slider/owl.carousel.js') }}"></script>
    <script src="{{ asset('contactform/contactform.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</head>

<body id="home">

    <div class="topbar">
        <div class="container">
            <h3>(MON - FRI 9:00 AM to 6:00 PM) Aguinaldo Street, Iligan City</h3>
        </div>
    </div>
    <!--topbar-->

    <header>
        <div class="container">
            <a href="index.html" class="logo"><img src="{{ asset('images/logo.png') }}" alt="" /></a>

            <div class="menuicons" style="display:none;">
                <a href="javascript:void();" class="shownav">
                    <span class="fa-solid fa-bars"></span>
                </a>
                <a href="javascript:void();" class="hidenav" style="display:none;">
                    <span class="fa-solid fa-times"></span>
                </a>
            </div>
            <nav class="headernav" id="headnav">
                <ul>
                    <li class="active"><a href="#home">Home</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#employees">Employees</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="product.html">Products</a></li>
                    <li><a href="{{ route('log-in') }}">Sign In</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <!--header-->

    <div class="banner">
        <div class="bannercontent">
            <div class="bannertextwrap">
                <div class="container">
                    <div class="bannertext">
                        <h2>Get Your Complete Eye Checkup and Treatment.</h2>
                        <div class="doctorcard">
                            <div class="thumb" style="background: url({{ asset('images/doctor.jpg') }}) no-repeat center center;"></div>
                            <div class="text">
                                <h5>Dentist</h5>
                                <h3>Dr. John Doe</h3>
                                <p>
                                    A+ Graded and Certified Dentist With Over a 500+ Reviews.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--bannertextwrap-->

            <div class="videoouter">
                <video autoplay muted loop>
                    <source src="{{ asset('images/cover1.mp4') }}" type="video/mp4">
                </video>
            </div>
            <!-- video background -->
        </div>
        <!--bannercontent-->

        <div class="formwrap">
            <div class="container">
                <div class="formarea" id="formarea">
                    <h2>Schedule an Appointment</h2>
                    <h4>
                        For inquiries, please complete the form below and share your details with us.
                    </h4>
                    <form id="contactform" method="post" action="{{ asset('contactform/contactform.php') }}">
                        <label>
                            <input type="text" name="name" placeholder="Name*" required>
                        </label>
                        <label class="alignright">
                            <input type="text" name="email" placeholder="Email*" required>
                        </label>
                        <label class="full">
                            <input type="text" name="phone" placeholder="Phone*" required>
                        </label>
                        <label class="full">
                            <input type="date" name="date" placeholder="Select Date" id="datepicker" class="" required>
                        </label>
                        <button type="submit" name="submit" id="contactform_btn">Submit Request</button>
                        <div class="responsetype"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--banner-->

    <div class="dental_services" id="services">
        <div class="container">
            <div class="service_items_wrap">
                <div class="service_items">
                    <div class="item">
                        <div class="itemcontent">
                            <div class="thumb">
                                <img src="{{ asset('images/1.png') }}" alt="" />
                            </div>
                            <div class="text">
                                <h3>Eye Exams</h3>
                                <p>
                                    Comprehensive eye examinations to check vision and overall eye health.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="itemcontent">
                            <div class="thumb">
                                <img src="{{ asset('images/3.png') }}" alt="" />
                            </div>
                            <div class="text">
                                <h3>Prescription Services</h3>
                                <p>
                                    Issuance of prescriptions for eyeglasses or contact lenses based on the results of an eye exam.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="itemcontent">
                            <div class="thumb">
                                <img src="{{ asset('images/2.png') }}" alt="" />
                            </div>
                            <div class="text">
                                <h3>Eyeglasses and Frames</h3>
                                <p>
                                    Wide selection of eyeglass frames for adults and children.
                                    Lens options include single-vision, bifocal, trifocal, and progressive lenses.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="itemcontent">
                            <div class="thumb">
                                <img src="{{ asset('images/4.png') }}" alt="" />
                            </div>
                            <div class="text">
                                <h3>Contact Lenses</h3>
                                <p>
                                    Fitting and prescription for contact lenses, including soft, rigid gas permeable, and toric lenses for astigmatism.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--dental_services-->

    <!-- The rest of the code -->

    <footer>
        <div class="row align-items-center justify-content-center">
            <div class="col-auto d-flex align-items-center justify-content-center">
                <div class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Company Logo" />
                    <p>All Rights Reserved. Hollywood Spectacles Optical © 2024</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        var menuid = '#headnav';
        var gaptop = 135;
        var scrollspeed = 1200;
        var menu_active_class = 'active';
    </script>
    <script src="{{ asset('js/bliss.js') }}"></script>
    <script src="{{ asset('js/waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.counterup.js') }}"></script>
</body>
</html>
