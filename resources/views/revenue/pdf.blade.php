<!DOCTYPE html>
<html>
<head>
    <title>Revenue Report - {{ $year }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #1a237e; margin: 0; }
        .header p { color: #666; margin: 5px 0; }
        .summary { margin-bottom: 30px; padding: 15px; background: #f8f9fa; border-radius: 8px; }
        .summary-item { display: inline-block; width: 45%; margin-bottom: 10px; }
        .summary-label { font-weight: bold; color: #1a237e; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #1a237e; color: #fff; text-align: left; padding: 10px; font-size: 12px; }
        td { border-bottom: 1px solid #ddd; padding: 10px; font-size: 11px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Revenue Report</h1>
        <p>Year: {{ $year }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span class="summary-label">Total Revenue:</span> 
            {{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($totalRevenue, 2) }}
        </div>
        <div class="summary-item">
            <span class="summary-label">Total Transactions:</span> 
            {{ $bills->count() }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Bill ID</th>
                <th>School Name</th>
                <th>Package</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Gateway</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bills as $bill)
            <tr>
                <td>#{{ $bill->id }}</td>
                <td>{{ $bill->school->name ?? 'N/A' }}</td>
                <td>{{ $bill->subscription->name ?? 'N/A' }}</td>
                <td>{{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($bill->amount, 2) }}</td>
                <td>{{ date('d-m-Y', strtotime($bill->transaction->created_at)) }}</td>
                <td>{{ $bill->transaction->payment_gateway }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generated on {{ now()->format('d-m-Y H:i:s') }}
    </div>
</body>
</html>
