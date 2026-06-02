@extends('layouts.home_page.master')

@section('title')
    Refund & Cancellation Policy
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
            <h1 style="color: #fff; font-weight: 700;">REFUND & CANCELLATION POLICY</h1>
        </div>
    </section>

    <div class="container policy-container">
        <!-- h1 removed -->
        <p><strong>Last Updated:</strong> Dec 2025</p>

        <h2>1. Refund Eligibility</h2>
        <ul>
            <li>Technical failure preventing service usage</li>
            <li>Duplicate payment</li>
            <li>Service not delivered</li>
            <li>Failed school onboarding</li>
        </ul>

        <h2>2. Refund Reporting Timeline (STRICT)</h2>
        <p>All refund-related issues must be reported within 15 days from the date the issue occurred or came to the
            school’s attention.</p>

        <h2>3. Non-Refundable Items</h2>
        <ul>
            <li>Services already used or partially consumed</li>
            <li>Add-ons once activated</li>
            <li>Complimentary / free services</li>
            <li>Any future setup or onboarding fees</li>
            <li>Delays caused by factors outside SarthakEdge’s control</li>
        </ul>

        <h2>4. Refund Processing</h2>
        <p>Approved refunds are processed within 7–10 working days to the original payment method.</p>

        <h2>5. Free Trial</h2>
        <p>No refunds apply during the 14-day free trial, as no payment is collected.</p>
    </div>
@endsection