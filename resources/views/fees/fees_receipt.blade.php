<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Fee Receipt - {{ $feesPaid->id }}</title>
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
            border: 2px solid #2E447E;
            border-radius: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .school-name {
            font-size: 22px;
            font-weight: bold;
            color: #2E447E;
            text-transform: uppercase;
            margin: 5px 0;
        }
        .school-address {
            font-size: 12px;
            color: #666;
        }
        .receipt-title {
            text-align: center;
            margin: 10px 0;
            font-size: 18px;
            font-weight: bold;
            text-decoration: underline;
            color: #2E447E;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            vertical-align: top;
            padding: 5px;
        }
        .label {
            font-weight: bold;
            color: #555;
            width: 120px;
        }
        .value {
            color: #000;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .details-table th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: left;
            color: #2E447E;
        }
        .details-table td {
            border: 1px solid #dee2e6;
            padding: 10px;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f1f3f5;
        }
        .footer {
            margin-top: 40px;
        }
        .signature-box {
            float: right;
            width: 200px;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 50px;
        }
        .watermark {
            position: absolute;
            top: 40%;
            left: 25%;
            font-size: 80px;
            color: rgba(200, 200, 200, 0.2);
            transform: rotate(-45deg);
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="watermark">PAID</div>
    <div class="container">
        <div class="header">
            @php
                $logo_path = '';
                if (!empty($school['horizontal_logo'])) {
                    $potential_path = public_path('storage/' . $school['horizontal_logo']);
                    if (file_exists($potential_path)) {
                        $logo_path = $potential_path;
                    }
                }
                
                if (empty($logo_path)) {
                    $potential_path = public_path('assets/horizontal-logo2.png'); // Try PNG fallback
                    if (file_exists($potential_path)) {
                        $logo_path = $potential_path;
                    }
                }

                $logo_data = '';
                if (!empty($logo_path) && file_exists($logo_path)) {
                    try {
                        $logo_data = base64_encode(file_get_contents($logo_path));
                    } catch (\Exception $e) {}
                }
            @endphp

            @if ($logo_data)
                <img style="height: 60px;" src="data:image/png;base64,{{ $logo_data }}" alt="Logo">
            @else
                <div style="height: 60px; font-weight: bold; color: #2E447E; font-size: 24px; line-height: 60px;">
                    {{ $school['school_name'] ?? 'SCHOOL' }}
                </div>
            @endif
            <div class="school-name">{{ $school['school_name'] ?? 'SCHOOL NAME' }}</div>
            <div class="school-address">{{ $school['school_address'] ?? '' }}</div>
        </div>

        <div class="receipt-title">FEE RECEIPT</div>

        <table class="info-table">
            <tr>
                <td width="55%">
                    <table>
                        <tr>
                            <td class="label">Student Name:</td>
                            <td class="value">{{ $student->user->full_name }}</td>
                        </tr>
                        <tr>
                            <td class="label">Class:</td>
                            <td class="value">{{ $student->class_section->full_name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Admission No:</td>
                            <td class="value">{{ $student->admission_no ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
                <td width="45%">
                    <table align="right">
                        <tr>
                            <td class="label">Receipt No:</td>
                            <td class="value">#{{ $feesPaid->id }}</td>
                        </tr>
                        <tr>
                            <td class="label">Date:</td>
                            <td class="value">{{ date('d-M-Y', strtotime($feesPaid->created_at)) }}</td>
                        </tr>
                        <tr>
                            <td class="label">Session:</td>
                            <td class="value">{{ $feesPaid->session_year->name ?? '' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="details-table">
            <thead>
                <tr>
                    <th width="10%">Sr.</th>
                    <th>Fee Description</th>
                    <th width="25%" class="text-right">Amount ({{ $school['currency_symbol'] ?? 'Rs.' }})</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                    $total_fees = 0;
                    $total_optional_fees = 0;
                    $due_charges = 0;
                    $compulsoryFeesType = $feesPaid->fees->compulsory_fees->pluck('fees_type_name')->implode(", ");
                @endphp

                {{-- Compulsory Fees --}}
                @if(isset($feesPaid->compulsory_fee) && $feesPaid->compulsory_fee->isNotEmpty())
                    @foreach ($feesPaid->compulsory_fee as $index => $compulsoryFee)
                        @php $total_fees += $compulsoryFee->amount; @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                                <strong>{{ $compulsoryFee->installment_fee->name ?? $compulsoryFee->type }}</strong><br>
                                <small>Mode: {{ $compulsoryFee->mode }} | Date: {{ date('d-m-Y', strtotime($compulsoryFee->date)) }}</small>
                                @if($compulsoryFee->type == "Full Payment")
                                    <br><small>({{ $compulsoryFeesType }})</small>
                                @endif
                            </td>
                            <td class="text-right">{{ number_format($compulsoryFee->amount, 2) }}</td>
                        </tr>
                        @if ($compulsoryFee->due_charges > 0)
                            @php $due_charges += $compulsoryFee->due_charges; @endphp
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>Due Charges</td>
                                <td class="text-right">{{ number_format($compulsoryFee->due_charges, 2) }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif

                {{-- Optional Fees --}}
                @if(isset($feesPaid->optional_fee) && $feesPaid->optional_fee->isNotEmpty())
                    @foreach ($feesPaid->optional_fee as $optionalFee)
                        @php
                            $total_fees += $optionalFee->amount;
                            $total_optional_fees += $optionalFee->amount;
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                                <strong>{{ $optionalFee->fees_class_type->fees_type_name }}</strong> (Optional)<br>
                                <small>Mode: {{ $optionalFee->mode }} | Date: {{ date('d-m-Y', strtotime($optionalFee->date)) }}</small>
                            </td>
                            <td class="text-right">{{ number_format($optionalFee->amount, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="2" class="text-right">GRAND TOTAL</td>
                    <td class="text-right">{{ number_format($total_fees + $due_charges, 2) }} {{ $school['currency_symbol'] ?? 'Rs.' }}</td>
                </tr>
            </tfoot>
        </table>

        {{-- <div style="margin-top: 10px;">
            <strong>Amount in words:</strong> {{ ucwords((new NumberFormatter('en_IN', NumberFormatter::SPELLOUT))->format($total_fees + $due_charges)) }} Only
        </div> --}}

        <div class="footer">
            <div style="float: left; width: 50%;">
                <p><strong>Note:</strong> This is a computer-generated receipt.</p>
            </div>
            <div class="signature-box">
                Authorized Signatory
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>
</body>
</html>
