@extends('layouts.home_page.master')

@section('title')
    Latest Blogs & Success Stories | SarthakEdge
@endsection

@section('css')
    <style>
        .blog-page {
            padding: 80px 0;
            background: #f9f9f9;
        }
        .blog-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 40px;
            transition: transform 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .blog-card:hover {
            transform: translateY(-10px);
        }
        .blog-img img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .blog-content {
            padding: 30px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .blog-content .date {
            color: #189ba9;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            display: block;
        }
        .blog-content h3 {
            font-size: 22px;
            color: #182ba9;
            margin-bottom: 15px;
            font-weight: 700;
        }
        .blog-content p {
            color: #666;
            line-height: 1.6;
            flex-grow: 1;
        }
        .blog-content .read-more {
            color: #182ba9;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 14px;
            margin-top: 20px;
            display: inline-block;
        }
        .blog-content .read-more i {
            vertical-align: middle;
            margin-left: 5px;
        }
    </style>
@endsection

@section('content')
    <section class="banner_section inner_banner"
        style="padding-top: 150px; padding-bottom: 80px; background: #182ba9; text-align: center;">
        <div class="container">
            <h1 style="color: #fff; font-weight: 700;">LATEST BLOGS</h1>
            <p style="color: #cad1ff; max-width: 600px; margin: 20px auto 0;">Stay updated with the latest trends in edtech, school management, and institutional growth.</p>
        </div>
    </section>

    <div class="blog-page">
        <div class="container">
            <div class="row">
                <!-- Blog 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-img">
                            <img src="{{ asset('assets/web-site-images/story01.png') }}" alt="Blog 1">
                        </div>
                        <div class="blog-content">
                            <span class="date">March 31, 2026</span>
                            <h3>Empowering Rural Education</h3>
                            <p>How we are bringing digital administration tools to underserved schools, narrowing the digital divide through SarthakEdge.</p>
                            <a href="#" class="read-more">Read More <i class="icofont-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Blog 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-img">
                            <img src="{{ asset('assets/web-site-images/story02.png') }}" alt="Blog 2">
                        </div>
                        <div class="blog-content">
                            <span class="date">March 28, 2026</span>
                            <h3>AI in the Modern Classroom</h3>
                            <p>Discover how smart analytics identify student learning gaps and help teachers tailor their instruction for better results.</p>
                            <a href="#" class="read-more">Read More <i class="icofont-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Blog 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-img">
                            <img src="{{ asset('assets/web-site-images/story03.png') }}" alt="Blog 3">
                        </div>
                        <div class="blog-content">
                            <span class="date">March 25, 2026</span>
                            <h3>Seamless Parent Sync</h3>
                            <p>Bridging the gap between school and home with instant mobile notifications and real-time updates for every parent.</p>
                            <a href="#" class="read-more">Read More <i class="icofont-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Blog 4 -->
                <div class="col-lg-4 col-md-6">
                   <div class="blog-card">
                       <div class="blog-img">
                           <img src="https://images.unsplash.com/photo-1546410531-bb4caa1b4227?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Blog 4">
                       </div>
                       <div class="blog-content">
                           <span class="date">March 20, 2026</span>
                           <h3>Choosing the Right ERP</h3>
                           <p>Five critical factors schools must consider before selecting an all-in-one management platform for long-term success.</p>
                           <a href="#" class="read-more">Read More <i class="icofont-arrow-right"></i></a>
                       </div>
                   </div>
                </div>

                <!-- Blog 5 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-img">
                            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Blog 5">
                        </div>
                        <div class="blog-content">
                            <span class="date">March 15, 2026</span>
                            <h3>Digital Fee Collection</h3>
                            <p>Transitioning from cash to cashless: How schools are reducing fraud and improving reconciliation across departments.</p>
                            <a href="#" class="read-more">Read More <i class="icofont-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Blog 6 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-img">
                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Blog 6">
                        </div>
                        <div class="blog-content">
                            <span class="date">March 10, 2026</span>
                            <h3>Student Security Protocols</h3>
                            <p>Ensuring data privacy and physical security for students in a hyper-connected school ecosystem using modern tools.</p>
                            <a href="#" class="read-more">Read More <i class="icofont-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
