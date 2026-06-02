@extends('layouts.home_page.master')

@section('title')
    Pricing Plans
@endsection

@section('css')
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
            margin: 50px 0 20px;
        }

        .toggle-btn {
            padding: 10px 15px;
            margin: 0 5px;
            cursor: pointer;
            border: 1px solid #182ba9;
            border-radius: 5px;
            color: #182ba9;
            display: inline-block;
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
@endsection

@section('content')
    <section class="banner_section inner_banner"
        style="padding-top: 150px; padding-bottom: 80px; background: #182ba9; text-align: center;">
        <div class="container">
            <h1 style="color: #fff; font-weight: 700;">PRICING PLANS</h1>
        </div>
    </section>

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
                    Website Content (About, Contact, Gallery, FAQs)<br><br>

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

                    ❌ No AI Chat | ❌ No Fees | ❌ Transport | ❌ Payroll
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
@endsection

@section('script')
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

        if (monthlyBtn) {
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
@endsection