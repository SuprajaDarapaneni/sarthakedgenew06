<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SarthakEdge - Your Digital Edge in Education</title>

  <!-- icofont-css-link -->
  <link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}">
  <!-- Owl-Carosal-Style-link -->
  <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
  <!-- Bootstrap-Style-link -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <!-- Aos-Style-link -->
  <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
  <!-- Coustome-Style-link -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <!-- Responsive-Style-link -->
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
  <!-- waveanimation-Style-link -->
  <link rel="stylesheet" href="{{ asset('assets/css/wave-animation-style.css') }}">
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('assets/web-site-images/favicon.png') }}" type="image/x-icon">

  <!-- Pricing Section CSS -->
  <style>
    /* Scoped styles for pricing */
    .pricing-page-body {
      font-family: Arial, sans-serif;
      background: #f7f7f7;
      margin: 0;
      padding: 20px;
    }

    .toggle-container {
      text-align: center;
      margin: 40px 0 20px;
      /* Adjusted margin */
    }

    .toggle-btn {
      padding: 10px 15px;
      margin: 0 5px;
      cursor: pointer;
      border: 1px solid var(--primary-color);
      /* Assuming var exists, else hardcode or check style.css */
      border-radius: 5px;
      color: var(--primary-color);
      display: inline-block;
      transition: all 0.3s ease;
    }

    /* Only applying color if variable is defined, otherwise fallback to a default blue if needed, 
         but keeping it simple to match potential existing theme */
    .toggle-btn {
      border-color: #182ba9;
      /* fallback based on other elements */
      color: #182ba9;
    }

    .toggle-btn.active {
      background: #182ba9;
      color: #fff;
    }

    .plans {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      margin-top: 20px;
      max-width: 1200px;
      margin-left: auto;
      margin-right: auto;
    }

    .plan {
      background: white;
      border-radius: 12px;
      box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      overflow-y: auto;
      text-align: left;
      /* Align text left as per pricing page */
    }

    .plan h2 {
      color: #182ba9;
      margin-bottom: 5px;
      margin-top: 0;
    }

    .price {
      font-size: 24px;
      margin: 10px 0;
      font-weight: bold;
    }

    .features {
      margin-top: 15px;
      font-size: 14px;
      line-height: 1.6;
    }

    .features span.title {
      font-weight: bold;
      color: #333;
    }
  </style>
</head>

<body>

  <!-- Page-wrapper-Start -->
  <div class="page_wrapper">

    <!-- Preloader -->
    <div id="preloader">
      <div id="loader"></div>
    </div>

    <!-- Header Start -->
    <header>
      <div class="top_bar" style="background: rgba(0,0,0,0.2); padding: 2px 0;">
        <div class="container">
          <ul class="top_links" style="display: flex; gap: 20px; list-style: none; padding: 0; margin: 0;">
            <li><a href="{{ url('/login') }}" style="color: #fff; font-size: 13px; font-weight: 500;">Admin login</a></li>
            <li><a href="{{ url('/login') }}" style="color: #fff; font-size: 13px; font-weight: 500;">Teacher login</a></li>
            <li><a href="{{ url('/login') }}" style="color: #fff; font-size: 13px; font-weight: 500;">School login</a></li>
          </ul>
        </div>
      </div>
      <!-- container start -->
      <div class="container">
        <!-- navigation bar -->
        <nav class="navbar navbar-expand-lg" style="padding-top: 5px;">
          <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('assets/web-site-images/logo.png') }}" alt="image" style="width: 200px;">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
              <!-- <i class="icofont-navigation-menu ico_menu"></i> -->
              <div class="toggle-wrap">
                <span class="toggle-bar"></span>
              </div>
            </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <!-- secondery menu start -->

              <li class="nav-item has_dropdown">
                <a class="nav-link" href="{{ url('/') }}">Home</a>
              </li>
              <!-- secondery menu end -->
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/#features') }}">Features</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('about-us') }}">About Us</a>
              </li>
              <!-- secondery menu start -->

              <!-- secondery menu end -->

              <li class="nav-item">
                <a class="nav-link" href="{{ route('pricing') }}">Pricing</a>
              </li>

              <!-- secondery menu start -->

              <!-- secondery menu end -->

              <li class="nav-item">
                <a class="nav-link" href="{{ route('contact-us') }}">Contact</a>
              </li>
              <li class="nav-item">
                <a class="nav-link dark_btn" href="{{ route('onboarding') }}">GET STARTED</a>
              </li>
            </ul>
          </div>
        </nav>
        <!-- navigation end -->
      </div>
      <!-- container end -->
    </header>

    <!-- Banner-Section-Start -->
    <section class="banner_section">
      <!-- container start -->
      <div class="container">
        <!-- row start -->
        <div class="row">
          <!-- shape animation  -->
          <span class="banner_shape1"> <img src="{{ asset('assets/web-site-images/banner-shape1.png') }}" alt="image">
          </span>
          <span class="banner_shape2"> <img src="{{ asset('assets/web-site-images/banner-shape2.png') }}" alt="image">
          </span>
          <span class="banner_shape3"> <img src="{{ asset('assets/web-site-images/banner-shape3.png') }}" alt="image">
          </span>
          <div class="col-lg-6 col-md-12" data-aos="fade-right" data-aos-duration="1500">
            <!-- banner text -->
            <div class="banner_text">
              <!-- h1 -->
              <h1>Reinventing school management with AI</h1>
              <!-- p -->
              <p>A unified system for smarter administration, informed decisions, and seamless communication.
              </p>
            </div>
            <!-- app buttons -->
            <!-- app buttons -->
            <ul class="app_btn">
              <!-- Links removed as per request -->
            </ul>


          </div>

          <!-- banner slides start -->
          <div class="col-lg-6 col-md-12" data-aos="fade-in" data-aos-duration="1500">
            <div class="banner_image">
              <img class="moving_animation" src="{{ asset('assets/web-site-images/banner-image.png') }}" alt="image">
            </div>
          </div>
          <!-- banner slides end -->

        </div>
        <!-- row end -->
      </div>
      <!-- container end -->

      <!-- wave animation start -->
      <div>
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
          viewbox="0 24 150 28" preserveaspectratio="none" shape-rendering="auto">
          <defs>
            <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
          </defs>
          <g class="parallax">
            <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7"></use>
            <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)"></use>
            <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)"></use>
            <use xlink:href="#gentle-wave" x="48" y="7" fill="#f6f4fe"></use>
          </g>
        </svg>
      </div>
      <!-- wave animation end -->

    </section>
    <!-- Banner-Section-end -->




    <section class="row_am why_we_section" id="features" data-aos="fade-in">
      <div class="why_inner">
        <div class="container">

          <!-- Section Title -->
          <div class="section_title" data-aos="fade-up" data-aos-duration="1500">
            <h2>Explore Our Core <span>Features</span></h2>
            <p>Simplifying school operations through smart, integrated modules.</p>
          </div>

          <!-- ===== ROW 1 ===== -->
          <div class="row">
            <div class="col-md-6 col-lg-3">
              <div class="why_box">
                <div class="icon"><img src="{{ asset('assets/web-site-images/feat_student_v2.png') }}" alt=""></div>
                <div class="text">
                  <h3>Student Management</h3>
                  <p>Manage admissions, profiles, attendance, and student records efficiently.</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3">
              <div class="why_box">
                <div class="icon"><img src="{{ asset('assets/web-site-images/feat_academics_v2.png') }}" alt=""></div>
                <div class="text">
                  <h3>Academics Management</h3>
                  <p>Handle classes, subjects, syllabus, exams, and results seamlessly.</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3">
              <div class="why_box">
                <div class="icon"><img src="{{ asset('assets/web-site-images/feat_teacher_v2.png') }}" alt=""></div>
                <div class="text">
                  <h3>Teacher Management</h3>
                  <p>Track staff details, attendance, workload, and performance easily.</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3">
              <div class="why_box">
                <div class="icon"><img src="{{ asset('assets/web-site-images/feat_session_v2.png') }}" alt=""></div>
                <div class="text">
                  <h3>Session Year Management</h3>
                  <p>Organize academic years, promotions, and class transitions smoothly.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- ===== ROW 2 ===== -->
          <div class="row">
            <div class="col-md-6 col-lg-3">
              <div class="why_box">
                <div class="icon"><img src="{{ asset('assets/web-site-images/feat_attendance_v2.png') }}" alt=""></div>
                <div class="text">
                  <h3>Attendance Tracking</h3>
                  <p>Daily attendance with instant parent notifications.</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3">
              <div class="why_box">
                <div class="icon"><img src="{{ asset('assets/web-site-images/feat_fee_v2.png') }}" alt=""></div>
                <div class="text">
                  <h3>Fee Management</h3>
                  <p>Online payments, receipts, dues, and installment tracking.</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3">
              <div class="why_box">
                <div class="icon"><img src="{{ asset('assets/web-site-images/feat_communication_v2.png') }}" alt="">
                </div>
                <div class="text">
                  <h3>Parent Communication</h3>
                  <p>Instant alerts via app, SMS, and WhatsApp.</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3">
              <div class="why_box">
                <div class="icon"><img src="{{ asset('assets/web-site-images/feat_exam_v2.png') }}" alt=""></div>
                <div class="text">
                  <h3>Exam Management</h3>
                  <p>Create exams, publish results, and generate report cards.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- ===== ROW 3 (HIDDEN INITIALLY) ===== -->
          <div class="row extra-features">
            <div class="col-md-6 col-lg-3">
              <div class="why_box">
                <div class="icon"><img src="{{ asset('assets/web-site-images/feat_homework_v2.png') }}" alt=""></div>
                <div class="text">
                  <h3>Homework & Assignments</h3>
                  <p>Share and track homework digitally.</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3">
              <div class="why_box">
                <div class="icon"><img src="{{ asset('assets/web-site-images/feat_transport_v2.png') }}" alt=""></div>
                <div class="text">
                  <h3>Transport Management</h3>
                  <p>Bus routes, drivers, and student transport tracking.</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3">
              <div class="why_box">
                <div class="icon"><img src="{{ asset('assets/web-site-images/feat_reports_v2.png') }}" alt=""></div>
                <div class="text">
                  <h3>Reports & Analytics</h3>
                  <p>Smart reports for data-driven decisions.</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3">
              <div class="why_box">
                <div class="icon"><img src="{{ asset('assets/web-site-images/feat_access_v2.png') }}" alt=""></div>
                <div class="text">
                  <h3>Role Based Access</h3>
                  <p>Secure access for admins, teachers, parents & students.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- SHOW MORE BUTTON -->
          <div class="show-more-btn">
            <button id="toggleFeatures">Show More</button>
          </div>

        </div>
      </div>
    </section>



    <!-- About-App-Section-Start -->

    <!-- About-App-Section-end -->

    <!-- ModernUI-Section-Start -->
    <section class="modern_ui_section">
      <div class="container">
        <div class="row align-items-center">

          <!-- LEFT TEXT -->
          <div class="col-lg-6">
            <h2>Parents & Students <span style="color:#189ba9">App</span></h2>
            <p>
              Stay connected with your child’s education through real-time updates and communication.
            </p>

            <ul class="design_block scrollable-features">
              <li class="feature-item active" data-target="img1">
                <h4>Attractive Home</h4>
                <p>Latest announcements and subject updates.</p>
              </li>

              <li class="feature-item" data-target="img2">
                <h4>Lessons & Assignments</h4>
                <p>Homework and assignment tracking.</p>
              </li>

              <li class="feature-item" data-target="img3">
                <h4>Centralized Operations</h4>
                <p>All school features in one menu.</p>
              </li>

              <li class="feature-item" data-target="img4">
                <h4>Elective Subjects</h4>
                <p>Easy elective subject selection.</p>
              </li>
            </ul>
          </div>

          <!-- RIGHT IMAGE -->
          <div class="col-lg-6 text-center">
            <div class="ui_images">
              <img id="img1" class="ui_img active" src="{{ asset('assets/web-site-images/app_dashboard.jpg') }}">
              <img id="img2" class="ui_img" src="{{ asset('assets/web-site-images/app_academics.jpg') }}">
              <img id="img3" class="ui_img" src="{{ asset('assets/web-site-images/app_chat.jpg') }}">
              <img id="img4" class="ui_img" src="{{ asset('assets/web-site-images/app_profile.jpg') }}">
            </div>
          </div>

        </div>
      </div>
    </section>



    <section class="teacher_app_section">
      <div class="container">
        <div class="row align-items-center">

          <!-- LEFT : IMAGES -->
          <div class="col-lg-6 text-center">
            <div class="teacher_app_images">
              <img id="teacherImg1" class="teacher_img active"
                src="{{ asset('assets/web-site-images/app_dashboard.jpg') }}" alt="">
              <img id="teacherImg2" class="teacher_img" src="{{ asset("assets/web-site-images/app_academics.jpg") }}"
                alt="">
              <img id="teacherImg3" class="teacher_img" src="{{ asset("assets/web-site-images/app_chat.jpg") }}" alt="">
              <img id="teacherImg4" class="teacher_img" src="{{ asset('assets/web-site-images/app_login.jpg') }}"
                alt="">
            </div>
          </div>

          <!-- RIGHT : TEXT -->
          <div class="col-lg-6">
            <h2>Teacher <span class="teacher_highlight">App</span></h2>
            <p class="teacher_desc">
              Empower teachers with smart tools to manage classes, students, and academics efficiently.
            </p>

            <!-- IMPORTANT WRAPPER -->
            <div class="teacher_feature_wrapper">
              <ul class="teacher_feature_list teacher_scroll">

                <li class="teacher_feature active" data-target="teacherImg1">
                  <h4>Class Management</h4>
                  <p>Manage classes, sections, and student lists effortlessly.</p>
                </li>

                <li class="teacher_feature" data-target="teacherImg2">
                  <h4>Attendance Tracking</h4>
                  <p>Mark attendance quickly with real-time updates.</p>
                </li>

                <li class="teacher_feature" data-target="teacherImg3">
                  <h4>Homework & Assignments</h4>
                  <p>Create, assign, and track homework digitally.</p>
                </li>

                <li class="teacher_feature" data-target="teacherImg4">
                  <h4>Exam & Marks Entry</h4>
                  <p>Enter marks and generate reports easily.</p>
                </li>

                <li class="teacher_feature" data-target="teacherImg1">
                  <h4>Teacher Dashboard</h4>
                  <p>Quick access to daily teaching activities.</p>
                </li>

              </ul>
            </div>
          </div>

        </div>
      </div>
    </section>



    <!-- ModernUI-Section-end -->

    <!-- How-It-Workes-Section Removed -->

    <!-- Testimonial-Section start -->
    {{-- Testimonial-Section Removed --}}
    {{--
    <section class="row_am testimonial_section">
      <!-- container start -->
      <div class="container">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
          <!-- h2 -->
          <h2>What our <span>customer say</span></h2>
          <!-- p -->
          <p>Lorem Ipsum is simply dummy text of the printing and typese tting <br> indus orem Ipsum has beenthe
            standard dummy.</p>
        </div>
        <div class="testimonial_block" data-aos="fade-in" data-aos-duration="1500">
          <div id="testimonial_slider" class="owl-carousel owl-theme">
            <!-- user 1 -->
            <div class="item">
              <div class="testimonial_slide_box">
                <div class="rating">
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                </div>
                <p class="review">
                  “ Lorem Ipsum is simply dummy text of the printing and typese tting us orem Ipsum has been lorem
                  beenthe standar dummy. ”
                </p>
                <div class="testimonial_img">
                  <img src="{{ asset('assets/web-site-images/testimonial_user1.png') }}" alt="image">
                </div>
                <h3>Shayna John</h3>
                <span class="designation">Careative inc</span>
              </div>
            </div>

            <!-- user 2 -->
            <div class="item">
              <div class="testimonial_slide_box">
                <div class="rating">
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                </div>
                <p class="review">
                  “ Lorem Ipsum is simply dummy text of the printing and typese tting us orem Ipsum has been lorem
                  beenthe standar dummy. ”
                </p>
                <div class="testimonial_img">
                  <img src="{{ asset('assets/web-site-images/testimonial_user2.png') }}" alt="image">
                </div>
                <h3>Willium Den</h3>
                <span class="designation">Careative inc</span>
              </div>
            </div>

            <!-- user 3 -->
            <div class="item">
              <div class="testimonial_slide_box">
                <div class="rating">
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                </div>
                <p class="review">
                  “ Lorem Ipsum is simply dummy text of the printing and typese tting us orem Ipsum has been lorem
                  beenthe standar dummy. ”
                </p>
                <div class="testimonial_img">
                  <img src="{{ asset('assets/web-site-images/testimonial_user3.png') }}" alt="image">
                </div>
                <h3>Cyrus Stephen</h3>
                <span class="designation">Careative inc</span>
              </div>

            </div>
          </div>

          <!-- total review -->
          <div class="total_review">
            <div class="rating">
              <span><i class="icofont-star"></i></span>
              <span><i class="icofont-star"></i></span>
              <span><i class="icofont-star"></i></span>
              <span><i class="icofont-star"></i></span>
              <span><i class="icofont-star"></i></span>
              <p>5.0 / 5.0</p>
            </div>
            <h3>2578</h3>
            <a href="#">TOTAL USER REVIEWS <i class="icofont-arrow-right"></i></a>
          </div>

          <!-- avtar faces -->
          <div class="avtar_faces">
            <img src="{{ asset('assets/web-site-images/avtar_testimonial.png') }}" alt="image">
          </div>
        </div>
      </div>
      <!-- container end -->
    </section>
    --}}

    <!-- Testimonial-Section end -->

    <!-- Pricing-Section -->
    <!-- Pricing-Section -->
    <section class="row_am pricing_section" id="pricing">
      <!-- container start -->
      <div class="container">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
          <!-- h2 -->
          <h2>Best & simple <span>pricing</span></h2>
          <!-- p -->
          <p>Choose the plan that fits your school's needs.</p>
        </div>

        <div class="pricing-page-body">
          <div class="toggle-container">
            <span class="toggle-btn active" id="monthlyBtn">Monthly</span>
            <span class="toggle-btn" id="quarterBtn">Quarterly</span>
            <span class="toggle-btn" id="halfBtn">Half-Yearly</span>
            <span class="toggle-btn" id="annualBtn">Annually</span>
          </div>

          <div class="plans">
            <!-- STARTUP -->
            <div class="plan">
              <h2>STARTUP PLAN</h2>
              <div class="price" id="startupPrice">₹1,999 / month</div>
              <div class="features">
                <span class="title">Purpose:</span> Digital setup + basic school management<br><br>

                <span class="title">Includes:</span><br>
                Digital Setup, School Registration & Profile<br>
                Branding (Logo, Details)<br>
                Website Content (About, Contact, Gallery, FAQs)<br>


                System Config:<br>
                Timezone, Date & Time, School Code Prefix<br><br>

                Basic School Management:<br>
                Admission & Profile, Guardian Linking<br>
                Teacher & Staff Basic, Class & Section Setup<br>
                Manual Attendance & Basic Timetable<br><br>

                Announcements, Holiday List, Diary<br><br>

                Basic Reports (Student List, Attendance, Offline Results)<br><br>

                Guardian App — Basic Access<br>
                Attendance View, Timetable, Notices, Results, Gallery<br><br>

                No AI Chat | No Fees | No Transport | Payroll
              </div>
            </div>

            <!-- GROWTH -->
            <div class="plan">
              <h2>GROWTH PLAN</h2>
              <div class="price" id="growthPrice">₹4,999 / month</div>
              <div class="features">
                <span class="title">Purpose:</span> Academic operations + finance<br><br>

                Includes all Startup features, plus:<br><br>

                Academic Management:<br>
                Homework, Assignment Upload & Tracking<br>
                Lessons & Study Materials<br>
                Semester & Stream Setup<br><br>

                Exam (Offline): Scheduling, Marks, Grades<br>
                Performance Reports<br><br>

                Fees & Expense Management:<br>
                Fee Types, Installments, Penalties<br>
                Fee Tracking & Payments<br>
                Expense Categories & Reports<br><br>

                Communication:<br>
                Push + Email Notifications<br>
                Email Templates + Announcement Attachments<br><br>

                Guardian App — Enhanced:<br>
                AI Chat Bot for parents<br>
                Fee Info, Schedules, Reports
              </div>
            </div>

            <!-- PRO -->
            <div class="plan">
              <h2>PRO PLAN</h2>
              <div class="price" id="proPrice">₹9,999 / month</div>
              <div class="features">
                <span class="title">Purpose:</span> Scale, governance & full control<br><br>

                Includes all Growth features, plus:<br><br>

                Transport & Logistics:<br>
                Vehicles, Routes, Pickup Points<br>
                Driver & Helper Management<br>
                Transportation Fee & Expense Tracking<br>
                Bus Tracking (Guardian App)<br><br>

                Advanced Admin:<br>
                Role & Permissions, Staff Payroll<br>
                Allowances & Deductions, Leave Management<br><br>

                ID Cards & Certificates:<br>
                Student & Staff IDs<br>
                Certificates with Custom Templates<br><br>

                Reports & Controls:<br>
                Exam, Fee, Expense, Payroll Reports<br>
                Subscription & Billing History<br>
                Add-on Controls & Database Backup<br><br>

                Full Guardian App Access<br>
                Bus Tracking, Alerts, Complete Student Overview
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- container start end -->
    </section>
    <!-- Pricing-Section end -->

    <!-- FAQ-Section start -->
    <section class="row_am faq_section">
      <!-- container start -->
      <div class="container">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
          <!-- h2 -->
          <h2><span>FAQ</span> - Frequently Asked Questions</h2>
          <!-- p -->
          <p>Find answers to common questions about SarthakEdge school management system.</p>
        </div>
        <!-- faq data -->
        <div class="faq_panel">
          <div class="accordion" id="accordionExample">
            <div class="card" data-aos="fade-up" data-aos-duration="1500">
              <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                  <button type="button" class="btn btn-link active" data-toggle="collapse" data-target="#collapseOne">
                    <i class="icon_faq icofont-plus"></i> What is SarthakEdge?</button>
                </h2>
              </div>
              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                  <p>SarthakEdge is an AI-powered school management system designed to streamline administration,
                    academics, fees, and communication. It provides a unified platform for admins, teachers, parents,
                    and students to manage school operations efficiently.</p>
                </div>
              </div>
            </div>
            <div class="card" data-aos="fade-up" data-aos-duration="1500">
              <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                  <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                    data-target="#collapseTwo"><i class="icon_faq icofont-plus"></i> How can SarthakEdge help my
                    school?</button>
                </h2>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                  <p>It automates daily tasks like attendance, fee collection, and exam scheduling. With real-time
                    notifications via WhatsApp and SMS, it improves parent-teacher communication and helps in
                    data-driven decision making through advanced analytics.</p>
                </div>
              </div>
            </div>
            <div class="card" data-aos="fade-up" data-aos-duration="1500">
              <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                  <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                    data-target="#collapseThree"><i class="icon_faq icofont-plus"></i> Is there a mobile app
                    available?</button>
                </h2>
              </div>
              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                  <p>Yes, we provide dedicated mobile applications for Parents, Students, and Teachers. These apps
                    ensure that everyone stays updated with marks, attendance, home work, and school announcements on
                    the go.</p>
                </div>
              </div>
            </div>
            <div class="card" data-aos="fade-up" data-aos-duration="1500">
              <div class="card-header" id="headingFour">
                <h2 class="mb-0">
                  <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                    data-target="#collapseFour"><i class="icon_faq icofont-plus"></i> How secure is our school's
                    data?</button>
                </h2>
              </div>
              <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                <div class="card-body">
                  <p>We prioritize data security with industry-standard encryption, secure cloud hosting, and daily
                    backups. Role-based access control ensures that sensitive information is only accessible to
                    authorized personnel.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- container end -->
    </section>
    <!-- FAQ-Section end -->

    <!-- Beautifull-interface-Section start -->
    <section class="row_am interface_section">
      <!-- container start -->
      <div class="container-fluid">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
          <!-- h2 -->
          <h2>Beautiful <span>interface</span></h2>
          <!-- p -->
          <p>
            Experience a clean, intuitive, and modern UI designed for efficiency across all devices, making school
            management simpler than ever.
          </p>
        </div>

        <!-- screen slider start -->
        <div class="screen_slider">
          <div id="screen_slider" class="owl-carousel owl-theme">
            <div class="item">
              <div class="screen_frame_img">
                <img src="{{ asset('assets/web-site-images/app_dashboard.jpg') }}" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="screen_frame_img">
                <img src="{{ asset('assets/web-site-images/app_academics.jpg') }}" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="screen_frame_img">
                <img src="{{ asset('assets/web-site-images/app_chat.jpg') }}" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="screen_frame_img">
                <img src="{{ asset('assets/web-site-images/app_profile.jpg') }}" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="screen_frame_img">
                <img src="{{ asset('assets/web-site-images/app_login.jpg') }}" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="screen_frame_img">
                <img src="{{ asset('assets/web-site-images/app_dashboard.jpg') }}" alt="image">
              </div>
            </div>
          </div>
        </div>
        <!-- screen slider end -->
      </div>
      <!-- container end -->
    </section>
    <!-- Beautifull-interface-Section end -->

  </div>
  </div>
  <!-- row end -->
  </div>
  </div>
  <!-- container end -->
  </section>
  <!-- Download-Free-App-section-end  -->


  <!-- News-Letter-Section-Start -->
  <section class="newsletter_section">
    <!-- container start -->
    <div class="container">
      <div class="newsletter_box">
        <div class="section_title" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="100">
          <!-- h2 -->
          <h2>Subscribe newsletter</h2>
          <!-- p -->
          <p>Be the first to recieve all latest post in your inbox</p>
        </div>
        <form action="" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="100">
          <div class="form-group">
            <input type="email" class="form-control" placeholder="Enter your email">
          </div>
          <div class="form-group">
            <button class="btn">SUBMIT</button>
          </div>
        </form>
      </div>
    </div>
    <!-- container end -->
  </section>
  <!-- News-Letter-Section-end -->

  <!-- Footer-Section start -->
  <footer>
    <div class="top_footer" id="contact">
      <!-- container start -->
      <div class="container">
        <!-- row start -->
        <div class="row">
          <span class="banner_shape1"> <img src="{{ asset('assets/web-site-images/banner-shape1.png') }}" alt="image">
          </span>
          <span class="banner_shape2"> <img src="{{ asset('assets/web-site-images/banner-shape2.png') }}" alt="image">
          </span>
          <span class="banner_shape3"> <img src="{{ asset('assets/web-site-images/banner-shape3.png') }}" alt="image">
          </span>
          <!-- footer link 1 -->
          <div class="col-lg-4 col-md-6 col-12">
            <div class="abt_side">
              <div class="logo">
                <a href="{{ url('/') }}">
                  <img src="{{ asset('assets/web-site-images/logo.png') }}" alt="image">
                </a>
              </div>
              <ul>
                <li><a href="#">info@sarthakedge.com</a></li>
                <li><a href="#">+91 78420 78844</a></li>
              </ul>
              <ul class="social_media">
                <li><a href="https://www.facebook.com/share/1E6QWpfUSe/?mibextid=wwXIfr"><i class="icofont-facebook"></i></a></li>
                <li><a href="https://x.com/sarthakedge?s=11"><i class="icofont-twitter"></i></a></li>
                <li><a href="https://www.instagram.com/sarthakedge?igsh=NndkMnVvbnd2Y29i&utm_source=qr"><i class="icofont-instagram"></i></a></li>
                <li><a href="https://in.pinterest.com/sarthakedge/"><i class="icofont-pinterest"></i></a></li>
              </ul>
            </div>
          </div>

          <!-- footer link 2 -->
          <div class="col-lg-3 col-md-6 col-12">
            <div class="links">
              <h3>Useful Links</h3>
              <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/#features') }}">Features</a></li>
                <li><a href="{{ route('about-us') }}">About Us</a></li>
                <li><a href="{{ route('pricing') }}">Pricing</a></li>
                <li><a href="{{ route('contact-us') }}">Contact us</a></li>
              </ul>
            </div>
          </div>

          <!-- footer link 3 -->
          <div class="col-lg-3 col-md-6 col-12">
            <div class="links">
              <h3>Help & Suport</h3>
              <ul>

                <li><a href="{{ route('contact-us') }}">Support</a></li>
                <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                <li><a href="{{ route('terms-conditions') }}">Terms & conditions</a></li>
                <li><a href="{{ route('refund-policy') }}">Refund Policy</a></li>
                <li><a href="{{ route('data-security') }}">Data Security Policy</a></li>
                <li><a href="{{ route('cookies-policy') }}">Cookies Policy</a></li>

              </ul>
            </div>
          </div>


        </div>
        <!-- row end -->
      </div>
      <!-- container end -->
    </div>

    <!-- last footer -->
    <div class="bottom_footer">
      <!-- container start -->
      <div class="container">
        <!-- row start -->
        <div class="row">
          <div class="col-md-6">
            <p>© 2026 SARTHAKEDGE IT SOLUTIONS PRIVATE LIMITED. All Rights Reserved.</p>
          </div>

        </div>
        <!-- row end -->
      </div>
      <!-- container end -->
    </div>

    <!-- go top button -->
    <div class="go_top">
      <span><img src="{{ asset('assets/web-site-images/go_top.png') }}" alt="image"></span>
    </div>
  </footer>
  <!-- Footer-Section end -->

  <!-- VIDEO MODAL -->
  <div class="modal fade youtube-video" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <button id="close-video" type="button" class="button btn btn-default text-right" data-dismiss="modal">
          <i class="icofont-close-line-circled"></i>
        </button>
        <div class="modal-body">
          <div id="video-container" class="video-container">
            <iframe id="youtubevideo" src="" width="640" height="360" frameborder="0" allowfullscreen=""></iframe>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

  <div class="purple_backdrop"></div>

  </div>
  <!-- Page-wrapper-End -->

  <!-- Jquery-js-Link -->
  <script src="{{ asset('assets/js/jquery.js') }}"></script>
  <!-- owl-js-Link -->
  <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
  <!-- bootstrap-js-Link -->
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <!-- aos-js-Link -->
  <script src="{{ asset('assets/js/aos.js') }}"></script>
  <script src="{{ asset('assets/js/image.js') }}"></script>
  <!-- Pricing Toggle Script -->
  <script>
    const monthlyBtn = document.getElementById("monthlyBtn");
    const quarterBtn = document.getElementById("quarterBtn");
    const halfBtn = document.getElementById("halfBtn");
    const annualBtn = document.getElementById("annualBtn");

    const startupPrice = document.getElementById("startupPrice");
    const growthPrice = document.getElementById("growthPrice");
    const proPrice = document.getElementById("proPrice");

    function setActive(el) {
      [monthlyBtn, quarterBtn, halfBtn, annualBtn].forEach(b => b.classList.remove("active"));
      el.classList.add("active");
    }

    if (monthlyBtn) { // Check if elements exist to avoid errors
      monthlyBtn.onclick = () => {
        setActive(monthlyBtn);
        startupPrice.innerText = "₹1,999 / month";
        growthPrice.innerText = "₹4,999 / month";
        proPrice.innerText = "₹9,999 / month";
      };
    }

    if (quarterBtn) {
      quarterBtn.onclick = () => {
        setActive(quarterBtn);
        startupPrice.innerText = "₹5,697 / quarter";
        growthPrice.innerText = "₹14,997 / quarter";
        proPrice.innerText = "₹29,997 / quarter";
      };
    }

    if (halfBtn) {
      halfBtn.onclick = () => {
        setActive(halfBtn);
        startupPrice.innerText = "₹10,994 / half-year";
        growthPrice.innerText = "₹29,994 / half-year";
        proPrice.innerText = "₹59,994 / half-year";
      };
    }

    if (annualBtn) {
      annualBtn.onclick = () => {
        setActive(annualBtn);
        startupPrice.innerText = "₹23,988 / year";
        growthPrice.innerText = "₹59,988 / year";
        proPrice.innerText = "₹119,988 / year";
      };
    }
  </script>
  <!-- main-js-Link -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <script>
    const toggleBtn = document.getElementById("toggleFeatures");
    const extraRows = document.querySelectorAll(".extra-features");

    let expanded = false;

    toggleBtn.addEventListener("click", () => {
      extraRows.forEach(row => {
        row.style.display = expanded ? "none" : "flex";
      });

      toggleBtn.innerText = expanded ? "Show More" : "Show Less";
      expanded = !expanded;
    });
  </script>

</body>

</html>