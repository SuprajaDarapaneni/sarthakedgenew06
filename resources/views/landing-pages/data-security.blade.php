@extends('layouts.home_page.master')

@section('title')
    Data Security & Protection Policy
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
            <h1 style="color: #fff; font-weight: 700;">DATA SECURITY & PROTECTION POLICY</h1>
        </div>
    </section>

    <div class="container policy-container">
        <!-- h1 removed -->
        <p><strong>Last Updated:</strong> Dec 2025</p>

        <h2>Our Security Commitment</h2>
        <p>Data protection is foundational at SarthakEdge. We implement enterprise-grade security controls to protect all
            school data.</p>

        <h2>Security Measures Include</h2>
        <ul>
            <li>Secure cloud infrastructure with restricted physical access</li>
            <li>End-to-end encryption (data in transit & at rest)</li>
            <li>Role-based access controls</li>
            <li>Strong authentication & optional 2FA</li>
            <li>Activity logs & audit trails</li>
            <li>Daily automated backups & disaster recovery</li>
            <li>Regular security updates</li>
        </ul>

        <h2>Compliance & Trust</h2>
        <ul>
            <li>Aligned with India’s DPDP Act</li>
            <li>Data Processing Agreement (DPA) available on request</li>
            <li>Zero tolerance for data misuse</li>
        </ul>

        <h2>Data Ownership</h2>
        <ul>
            <li>Schools retain full ownership of their data</li>
            <li>SarthakEdge acts only as a secure data processor</li>
        </ul>

        <h2>Security Contact</h2>
        <p>
            Email: info@sarthakedge.com<br>
            Location: Hyderabad, India
        </p>
    </div>
@endsection