@extends('layouts.home_page.master')

@section('title')
    Cookies Policy
@endsection

@section('content')
    <style>
        .policy-container {
            max-width: 1100px;
            margin: auto;
            background: #fff;
            padding: 40px;
            margin-top: 50px;
            /* Adjusted */
            margin-bottom: 50px;
        }

        .policy-container h1,
        .policy-container h2 {
            color: var(--primary-color);
        }

        .policy-container ul {
            margin-left: 20px;
        }
    </style>

    <section class="banner_section inner_banner"
        style="padding-top: 150px; padding-bottom: 80px; background: #182ba9; text-align: center;">
        <div class="container">
            <h1 style="color: #fff; font-weight: 700;">COOKIES POLICY</h1>
        </div>
    </section>

    <div class="container policy-container">
        <!-- h1 removed -->
        <p><strong>Last Updated:</strong> Dec 2025</p>

        <h2>1. What Are Cookies</h2>
        <p>
            Cookies are small text files stored on your device (computer, tablet, or mobile) when you
            visit a website. They help ensure proper functioning of the website, improve user
            experience, and provide analytics insights.
        </p>

        <h2>2. Cookies We Use</h2>
        <ul>
            <li><strong>Essential Cookies:</strong> Required for login, authentication, session management, and platform
                security.</li>
            <li><strong>Performance Cookies:</strong> Help us understand how users interact with the platform to improve
                performance.</li>
            <li><strong>Internal Analytics Cookies:</strong> Used to analyze usage patterns and improve features.</li>
            <li><strong>Marketing Cookies:</strong> May be used in the future for outreach or promotions (only with user
                consent).</li>
        </ul>

        <h2>3. Cookie Control</h2>
        <p>
            Users may accept or reject non-essential cookies through browser settings.
            Disabling cookies may affect certain features or functionality of the platform.
        </p>

        <h2>4. Data Usage & Privacy</h2>
        <p>
            Cookies do not collect sensitive personal data such as passwords or payment details.
            All cookie data is processed in accordance with applicable data protection laws.
        </p>

        <h2>5. Updates to This Policy</h2>
        <p>
            This Cookies Policy may be updated periodically to reflect changes in technology,
            legal requirements, or operational practices. Updated versions will be published on
            this page.
        </p>

        <h2>6. Contact Information</h2>
        <p>
            For questions regarding cookies or privacy, please contact:<br>
            <strong>Email:</strong> info@sarthakedge.com<br>
            <strong>Location:</strong> Hyderabad, India
        </p>
    </div>
@endsection