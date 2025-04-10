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
    @if(!empty($message))
    <div id="success-modal" class="modal">
        <svg width="50" height="50" viewBox="0 0 100 100" fill="none">
            <circle cx="50" cy="50" r="40" fill="#4CAF50" />
            <path d="M30 50L45 65L70 35" stroke="white" stroke-width="5" />
        </svg>
        <h2>Success!</h2>
        <p> {{ $message }} </p>
        <button id="close-modal-button">Ok</button>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('success-modal');
            const closeButton = document.getElementById('close-modal-button');

            // Close modal on button click
            closeButton.addEventListener('click', () => {
                modal.style.display = 'none'; // Hide the modal
            });

            // Close modal after 3 seconds
            setTimeout(() => {
                if (modal) {
                    modal.style.display = 'none'; // Hide the modal
                }
            }, 3000);
        });
    </script>

    <div class="topbar">
        <div class="container">
            <h3>(MON - FRI 8:00 AM to 5:00 PM) Aguinaldo Street, Iligan City</h3>
        </div>
    </div>
    <!--topbar-->

    <header>
        <div class="container">
            <a href="/" class="logo"><img src="{{ asset('images/logo.png') }}" alt="" /></a>

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
                    <li><a href="{{ route('login') }}">Sign In</a></li>
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
                    <h4>
                        <a href="{{ route('ReservationForm') }}"
                           style="
                              display: inline-block;
                              padding: 12px 24px;
                              font-size: 16px;
                              font-weight: bold;
                              text-decoration: none;
                              color: rgb(0, 0, 0);
                              background: linear-gradient(to right, #ffffff, #ffffff);
                              border-radius: 50px;
                              box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                              transition: all 0.3s ease;
                              text-align: center;
                           "
                           onmouseover="this.style.background='linear-gradient(to right, #ff4d4d, #e60000)'; this.style.color='white'; this.style.transform='scale(1.05)'; this.style.boxShadow='0 6px 8px rgba(0, 0, 0, 0.2)';"
                           onmouseout="this.style.background='linear-gradient(to right, #ffffff, #ffffff)'; this.style.color='rgb(0, 0, 0)'; this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)';"
                        >
                            Book an Appointment
                        </a>
                    </h4>
                      </div>
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

    <div class="about" id="about">
		<div class="container">

			<div class="imagearea">
				<img src="images/doctor2.jpg" alt="" />
			</div>
			<div class="text">
				<h4>Meet</h4>
				<h3>Dr. Dializa Remedios</h3>
				<h5>Licensed Optometrist and Vision Care Expert</h5>
				<p>
					Experience the perfect blend of style and vision at Hollywood Spectacle Optical. From expert eye care to trendy eyewear, we bring clarity and sophistication together, putting the spotlight on your eyes.	</p>
				<p>
					Our clinic features cutting-edge vision care, offering tailored eye exams, high-quality lenses, and an extensive selection of stylish, designer frames to match every personality. We are dedicated to combining health, fashion, and innovation, ensuring you leave with both exceptional vision and a standout look.	</p>
					<!--https://wa.me/11234567890-->
				<a href="#" class="whatsapp">
					<span class="fa-brands fa-whatsapp"></span> +639 127 7747 297
				</a>
			</div>

		</div>
	</div>

	<div class="stats">
		<div class="container">

		</div>
	</div>

    <div class="reviews" id="employees">
        <div class="container">
            <h2>Employees</h2>
            <h3>Dedicated to Protecting and Improving Your Vision</h3>
            <div class="reviewslider_wrap">
                <div class="owl-carousel owl-theme reviewslider">
                    <div class="employee-card">
                        <img src="images/op.png" alt="Person 1" class="employee-image" />
                        <h4 class="employee-name">James Ramayan</h4>
                        <p class="employee-position">Assistant</p>
                    </div>
                    <div class="employee-card">
                        <img src="images/to.png" alt="Person 2" class="employee-image" />
                        <h4 class="employee-name">Cybelle Saavedra</h4>
                        <p class="employee-position">Assistant</p>
                    </div>
                    <div class="employee-card">
                        <img src="images/me.png" alt="Person 3" class="employee-image" />
                        <h4 class="employee-name">Miko Asequia</h4>
                        <p class="employee-position">Optician</p>
                    </div>
                </div>
            </div>
            <div class="contact" id="contact">
                <div class="container">
                    <div class="contactinfo">
                        <h2>Get in Touch</h2>
                        <h3>We’re here to help with your eye health and vision needs.</h3>
                        <div class="infowrap">
                            <!-- Phone Info -->
                            <div class="info">
                                <div class="icon-circle">
                                    <i class="fa-solid fa-phone-volume"></i>
                                </div>
                                <h4>Call Us:</h4>
                                <p>
                                    <a href="tel:+639 127 7747 297">(+63) 9127 774 7297</a>
                                </p>
                            </div>
                            <!-- Email Info -->
                            <div class="info">
                                <div class="icon-circle">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <h4>Email Us:</h4>
                                <p>
                                    <a>bbremediosod@gmail.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  The Map Below -->
    <div class="map-container">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d313.38373303456416!2d124.2395338!3d8.2279423!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x325575e04c584ccf%3A0xffe9511ef29ba946!2sHOLLYWOOD%20SPECTACLES%20OPTICAL!5e0!3m2!1sen!2sph!4v1698292956521!5m2!1sen!2sph"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>


    <footer>
        <div class="row align-items-center justify-content-center">
            <div class="col-auto d-flex align-items-center justify-content-center">
                <div class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Company Logo" />
                    <p>All Rights Reserved. Hollywood Spectacles Optical © 2024</p>
                </div>
            </div>

            <!--   Social MEDIAS
			<div class="socialmedia">
				<a href="#"><span class="fa-brands fa-twitter"></span></a>
				<a href="#"><span class="fa-brands fa-youtube"></span></a>
			</div>
		-->
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
<style>
    .modal {
  background-color: white;
  padding-right: 30px;
  padding-left: 30px;
  padding-top: 10px;
  padding-bottom: 10px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  text-align: center;
  position: fixed; /* Position the modal relative to the viewport */
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%); /* Center the modal */
  z-index: 100; /* Ensure the modal is on top of other elements */
}
.modal-open {
  /* Style for when the modal is open */
  opacity: 0.5;
}
    .modal h2 {
        color: #333;
        margin-bottom: 0px;
    }

    .modal p {
        color: #666;
    }

    .modal button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    .modal button:hover {
        background-color: #45a049;
    }
</style>
