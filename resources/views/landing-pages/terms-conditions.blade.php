@extends('layouts.home_page.master')

@section('title')
    Terms & Conditions
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
        .policy-container h2,
        .policy-container h3 {
            color: var(--primary-color);
        }

        .policy-container ul {
            margin-left: 20px;
        }
    </style>

    <section class="banner_section inner_banner"
        style="padding-top: 150px; padding-bottom: 80px; background: #182ba9; text-align: center;">
        <div class="container">
            <h1 style="color: #fff; font-weight: 700;">TERMS & CONDITIONS</h1>
        </div>
    </section>

    <div class="container policy-container">
        <!-- h1 removed -->
        <p><strong>Last Updated:</strong> Dec 2025</p>

        <h2>1. Acceptance</h2>
        <p>By accessing or using the Platform, you agree to these Terms & Conditions.</p>

        <h2>2. Services</h2>
        <p>SarthakEdge provides AI-powered school management services including attendance, fees, communication, reporting,
            and optional add-ons such as SMS notifications and bus tracking.</p>

        <h2>3. Subscription & Pricing</h2>
        <ul>
            <li>Subscriptions are charged per school</li>
            <li>Billing cycles: monthly, quarterly, or annually</li>
            <li>Add-ons are billed separately</li>
            <li>A 14-day free trial is offered with limited access</li>
        </ul>

        <h2>4. Cancellation</h2>
        <p>Subscriptions may be cancelled only at the end of the billing cycle.</p>

        <h2>5. Account Suspension</h2>
        <ul>
            <li>Non-payment</li>
            <li>Misuse or abuse</li>
            <li>Illegal or unauthorized activity</li>
        </ul>

        <h2>6. Complimentary Digital Presence Services</h2>
        <ul>
            <li>Free basic website</li>
            <li>Free domain and hosting (where applicable)</li>
            <li>Google My Business (GMB) setup</li>
            <li>Social media page creation</li>
            <li>Basic optimisation for online presence</li>
        </ul>

        <p><strong>No Guarantee Clause</strong></p>
        <ul>
            <li>No guarantee of leads or enquiries</li>
            <li>No guarantee of student admissions</li>
            <li>No guarantee of revenue growth</li>
            <li>No guarantee of search engine rankings or visibility</li>
        </ul>

        <h2>7. Intellectual Property</h2>
        <p>All software, AI logic, branding, and content belong to SarthakEdge IT Solutions Pvt. Ltd. Unauthorized use is
            prohibited.</p>

        <h2>8. Limitation of Liability</h2>
        <p>SarthakEdge shall not be liable for indirect, incidental, or consequential damages. Complimentary services are
            provided on an “as-is” basis without performance guarantees.</p>

        <h2>9. Governing Law</h2>
        <p>These terms are governed by the laws of India, with jurisdiction in Hyderabad, Telangana.</p>
    </div>
@endsection