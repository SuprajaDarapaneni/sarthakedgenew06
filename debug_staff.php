<?php
    require __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    $month = 1;
    $year = 2026;
    
    // Simulate PayrollController show query exactly
    $staffQuery = app(App\Repositories\Staff\StaffInterface::class)->builder()->with([
            'user',
            'staffSalary.payrollSetting',
            'expense.staff_payroll.payroll_setting',
            'leave' => function ($q) use ($month, $year) {
                $q->where('status', 1)->withCount([
                    'leave_detail as full_leave' => function ($q) use ($month, $year) {
                        $q->whereMonth('date', $month)->whereYear('date', $year)->where('type', 'Full');
                    }
                ])->withCount([
                    'leave_detail as half_leave' => function ($q) use ($month, $year) {
                        $q->whereMonth('date', $month)->whereYear('date', $year)->whereNot('type', 'Full');
                    }
                ]);
            }
        ])->whereHas('user', function ($q) {
            $q->whereNull('deleted_at');
        });
        
    $count = $staffQuery->count();
    echo "Total matching staff without Owner scope: " . $count . "\n";
    
    try {
        $staffQueryOwner = app(App\Repositories\Staff\StaffInterface::class)->builder()->whereHas('user', function ($q) {
            $q->whereNull('deleted_at')->Owner();
        });
        $countOwner = $staffQueryOwner->count();
        echo "Total with Owner scope: " . $countOwner . "\n";
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
    