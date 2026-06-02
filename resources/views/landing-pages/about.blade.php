@extends('layouts.home_page.master')

@section('title', 'About Us - SarthakEdge IT Solutions')

@section('content')
    <!-- Banner-Section-Start -->
    <section class="banner_section inner_banner" style="padding-top: 150px; padding-bottom: 80px; background: #182ba9; text-align: center;">
        <div class="container">
            <h1 style="color: #fff; font-weight: 700; text-transform: uppercase;">About SarthakEdge</h1>
            <p style="color: rgba(255,255,255,0.8); font-size: 18px; max-width: 700px; margin: 20px auto 0;">Your partner in educational digital transformation.</p>
        </div>
    </section>
    <!-- Banner-Section-End -->

    <!-- About-Content-Start -->
    <section class="about_content_section" style="padding: 80px 0; background: #fff;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <div class="about_img_wrapper">
                        <img src="{{ asset('assets/web-site-images/about_us.png') }}" alt="About SarthakEdge" class="img-fluid rounded shadow-lg">
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="about_text_box" style="padding-left: 20px;">
                        <h2 style="color: #182ba9; font-weight: 700; margin-bottom: 25px;">Helping Schools Thrive in the <span style="color: #189ba9">Digital Era</span></h2>
                        <p style="font-size: 16px; color: #555; line-height: 1.8; margin-bottom: 20px;">
                            SarthakEdge IT Solutions Pvt. Ltd. is dedicated to helping schools and educational institutions transition into the digital era with ease. Our core mission is to digitally transform small and medium-level schools by providing them with powerful yet simple-to-use management tools and complete digital infrastructure.
                        </p>
                        <p style="font-size: 16px; color: #555; line-height: 1.8;">
                            We don’t just provide a platform — we help institutions become fully digital. From streamlining daily school operations like admissions, attendance, fees, communication, and reports to building a strong online presence, SarthakEdge ensures schools are future-ready.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row mt-5 pt-lg-5 align-items-center">
                <div class="col-lg-6 order-2 order-lg-1" data-aos="fade-up">
                    <h3 style="color: #182ba9; font-weight: 600; margin-bottom: 20px;">Enablement & Visibility</h3>
                    <p style="font-size: 16px; color: #555; line-height: 1.8; margin-bottom: 20px;">
                        Alongside our management solutions, we also support institutions with complete digital marketing enablement — including creating, optimizing, and managing their digital presence across platforms. This helps schools improve visibility, build trust, and attract more admissions.
                    </p>
                    <p style="font-size: 16px; color: #555; line-height: 1.8;">
                        At SarthakEdge, we aim to empower growing schools with technology, automation, and digital marketing support — giving them the tools they need to operate efficiently, compete effectively, and scale confidently in today’s digital world.
                    </p>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 mb-4 mb-lg-0 text-center" data-aos="zoom-in">
                   <div style="background: #f8f9fa; padding: 50px; border-radius: 20px;">
                        <i class="icofont-rocket-alt-2" style="font-size: 80px; color: #182ba9;"></i>
                        <h4 style="margin-top: 20px; font-weight: 700;">Future-Ready <br>Education</h4>
                   </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission-Vision-Start -->
    <section class="vision_mission_section" style="padding: 80px 0; background: #f6f4fe;">
        <div class="container">
            <div class="row">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="vision_box text-center" style="background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        <i class="icofont-bulb-alt" style="font-size: 40px; color: #182ba9;"></i>
                        <h4 style="margin: 20px 0; font-weight: 700;">Innovate</h4>
                        <p style="color: #666; font-size: 15px;">Constantly evolving our tools to incorporate the latest in AI and automation.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="vision_box text-center" style="background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        <i class="icofont-users-alt-2" style="font-size: 40px; color: #182ba9;"></i>
                        <h4 style="margin: 20px 0; font-weight: 700;">Empower</h4>
                        <p style="color: #666; font-size: 15px;">Providing administrators and teachers the freedom to focus on what matters: Education.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="vision_box text-center" style="background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        <i class="icofont-globe" style="font-size: 40px; color: #182ba9;"></i>
                        <h4 style="margin: 20px 0; font-weight: 700;">Scale</h4>
                        <p style="color: #666; font-size: 15px;">Helping small and medium schools compete effectively in a digital-first world.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final-CTA-Start -->
    <section class="cta_section" style="padding: 100px 0; background: #fff; text-align: center;">
        <div class="container" data-aos="zoom-in">
            <h2 style="font-weight: 800; margin-bottom: 30px;">Ready to start your <span style="color: #182ba9">digital journey?</span></h2>
            <p style="font-size: 18px; color: #555; margin-bottom: 40px; max-width: 600px; margin-left: auto; margin-right: auto;">Join hundreds of schools already using SarthakEdge to streamline their operations.</p>
            <a href="{{ url('/login') }}" class="btn btn-primary" style="background: #182ba9; border: none; padding: 15px 40px; font-weight: 600; border-radius: 30px; transition: 0.3s;">GET STARTED NOW</a>
        </div>
    </section>
@endsection
