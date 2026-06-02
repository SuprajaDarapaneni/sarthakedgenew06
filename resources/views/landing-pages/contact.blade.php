@extends('layouts.home_page.master')

@section('title', 'Contact Us - SarthakEdge IT Solutions')

@section('content')
    <!-- Banner-Section-Start -->
    <section class="banner_section inner_banner" style="padding-top: 150px; padding-bottom: 80px; background: #182ba9; text-align: center;">
        <div class="container">
            <h1 style="color: #fff; font-weight: 700; text-transform: uppercase;">Contact Us</h1>
            <p style="color: rgba(255,255,255,0.8); font-size: 18px; max-width: 700px; margin: 20px auto 0;">Get in touch with us for any inquiries or support.</p>
        </div>
    </section>
    <!-- Banner-Section-End -->

    <!-- Contact-Content-Start -->
    <section class="contact_content_section" style="padding: 80px 0; background: #fff;">
        <div class="container">
            <div class="row">
                <!-- Contact Information -->
                <div class="col-lg-5 mb-5 mb-lg-0" data-aos="fade-right">
                    <div style="background: #f8f9fa; padding: 40px; border-radius: 15px; height: 100%;">
                        <h3 style="color: #182ba9; font-weight: 700; margin-bottom: 30px;">Get In Touch</h3>
                        
                        <div class="d-flex align-items-center mb-4">
                            <div style="width: 50px; height: 50px; background: #e8ebf9; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #182ba9; font-size: 24px; margin-right: 20px;">
                                <i class="icofont-location-pin"></i>
                            </div>
                            <div>
                                <h5 style="margin: 0; font-weight: 600;">Office Address</h5>
                                <p style="margin: 0; color: #555;">Survey No. 27, Akash Nagar, Thokatta Village, New Bowenpally, Hyderabad, Telangana 500011</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-4">
                            <div style="width: 50px; height: 50px; background: #e8ebf9; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #182ba9; font-size: 24px; margin-right: 20px;">
                                <i class="icofont-ui-call"></i>
                            </div>
                            <div>
                                <h5 style="margin: 0; font-weight: 600;">Phone Number</h5>
                                <p style="margin: 0; color: #555;"><a href="tel:+917842078844" style="color: #555; text-decoration: none;">+91 78420 78844</a></p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div style="width: 50px; height: 50px; background: #e8ebf9; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #182ba9; font-size: 24px; margin-right: 20px;">
                                <i class="icofont-envelope"></i>
                            </div>
                            <div>
                                <h5 style="margin: 0; font-weight: 600;">Email Address</h5>
                                <p style="margin: 0; color: #555;"><a href="mailto:info@sarthakedge.com" style="color: #555; text-decoration: none;">info@sarthakedge.com</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-7" data-aos="fade-left">
                    <div style="padding: 20px;">
                        <h3 style="color: #222; font-weight: 700; margin-bottom: 20px;">Send Us a Message</h3>
                        <p style="color: #666; margin-bottom: 30px;">Have questions about our school management system? Send us a message and our team will get back to you shortly.</p>
                        
                        <form action="{{ url('/contact') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" required style="height: 50px; border-radius: 8px;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Your Email" required style="height: 50px; border-radius: 8px;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required style="border-radius: 8px; padding: 15px;"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" style="background: #182ba9; border: none; height: 50px; font-weight: 600; border-radius: 8px;">SEND MESSAGE</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section style="background: #eee;">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15222.016016335967!2d78.46115993092576!3d17.483485749216098!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb9069d2f2df3b%3A0xe54e616f7347fc91!2sNew%20Bowenpally%2C%20Secunderabad%2C%20Telangana!5e0!3m2!1sen!2sin!4v1714652494576!5m2!1sen!2sin" width="100%" height="400" style="border:0; margin-bottom: -7px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
@endsection
