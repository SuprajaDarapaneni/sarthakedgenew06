@extends('layouts.home_page.master')

@section('title')
    Privacy Policy
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
            <h1 style="color: #fff; font-weight: 700;">PRIVACY POLICY</h1>
        </div>
    </section>

    <div class="container policy-container">
        <!-- h1 removed -->
        <p><strong>SarthakEdge IT Solutions Pvt. Ltd.</strong></p>
        <p><strong>Last Updated:</strong> Dec 2025</p>

        <h2>1. Introduction</h2>
        <p>SarthakEdge IT Solutions Pvt. Ltd. (“SarthakEdge”, “we”, “our”, “us”) provides an AI-powered School Management
            Software (“Platform”) for schools, teachers, students, and parents. We are committed to protecting personal data
            with the highest standards of security, confidentiality, and compliance, in accordance with the Information
            Technology Act, 2000 and the Digital Personal Data Protection Act, 2023 (DPDP Act).</p>

        <h2>2. Users Covered</h2>
        <ul>
            <li>School administrators</li>
            <li>Teachers</li>
            <li>Students (nursery to 10th class)</li>
            <li>Parents</li>
        </ul>
        <p>Student and parent accounts are created and managed only by schools.</p>

        <h2>3. Information We Collect</h2>
        <ul>
            <li>Name, email address, phone number</li>
            <li>Student roll number, class, section</li>
            <li>Attendance records</li>
            <li>Fee and payment status</li>
            <li>Academic performance and reports</li>
            <li>Uploaded documents (certificates, IDs)</li>
            <li>Internal chats and messages</li>
            <li>Device, browser, and IP address information</li>
        </ul>

        <h2>4. Children’s Data Protection</h2>
        <ul>
            <li>Children cannot independently create accounts</li>
            <li>Access is restricted to authorized school staff and parents</li>
            <li>Data is used strictly for educational and administrative purposes</li>
        </ul>

        <h2>5. Biometric Data</h2>
        <p>Currently, no biometric or facial recognition data is collected. If introduced in the future, it will be enabled
            only with explicit school and parental consent, and this policy will be updated.</p>

        <h2>6. AI & Automated Processing</h2>
        <ul>
            <li>Answer predefined parent queries (fees, attendance, events, student progression reports)</li>
            <li>Generate student-centric reports</li>
            <li>Provide predictive academic insights</li>
        </ul>
        <p>AI does not make final decisions related to grading, promotion, or discipline. Human authority always remains
            with the school.</p>
        <p>AI services may be powered by third-party providers such as OpenAI, using customer or anonymised data solely to
            deliver functionality.</p>

        <h2>7. Data Security & Protection</h2>
        <ul>
            <li>Encrypted data at rest and in transit (HTTPS/TLS)</li>
            <li>Secure cloud infrastructure with certified data centers</li>
            <li>Role-Based Access Control (RBAC)</li>
            <li>Strong authentication and optional 2FA</li>
            <li>Activity logs and audit trails</li>
            <li>Daily automated backups and disaster recovery</li>
            <li>Regular security updates and monitoring</li>
        </ul>

        <h2>8. Data Storage</h2>
        <p>Data is stored on secure global cloud infrastructure protected by industry-standard safeguards.</p>

        <h2>9. Data Sharing</h2>
        <ul>
            <li>Payment gateways (name, phone number, fee details only)</li>
            <li>SMS / WhatsApp notification providers</li>
            <li>Cloud infrastructure providers</li>
        </ul>
        <p>We never sell, rent, or commercially exploit school data.</p>

        <h2>10. Data Retention & Deletion</h2>
        <p>Data is retained only as long as necessary for service delivery or legal compliance. Schools may request deletion
            upon termination, subject to applicable laws.</p>

        <h2>11. User Rights</h2>
        <p>Users may request access, correction, or deletion by contacting: <strong>info@sarthakedge.com</strong></p>

        <h2>12. Contact</h2>
        <p>SarthakEdge IT Solutions Pvt. Ltd.<br>Hyderabad, India<br>Email: info@sarthakedge.com</p>
    </div>
@endsection