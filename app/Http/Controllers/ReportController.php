<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $dateFrom = $filters['date_from'] ?? null;
        $dateTo = $filters['date_to'] ?? null;

        $applyDateRange = static function (Builder $query) use ($dateFrom, $dateTo): void {
            if ($dateFrom !== null) {
                $query->whereDate('date', '>=', $dateFrom);
            }

            if ($dateTo !== null) {
                $query->whereDate('date', '<=', $dateTo);
            }
        };

        $statusCounts = Attendance::query()
            ->tap($applyDateRange)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $students = Student::query()
            ->withCount([
                'attendances as total_count' => $applyDateRange,
                'attendances as present_count' => static function (Builder $query) use ($applyDateRange): void {
                    $query->where('status', 'present');
                    $applyDateRange($query);
                },
                'attendances as absent_count' => static function (Builder $query) use ($applyDateRange): void {
                    $query->where('status', 'absent');
                    $applyDateRange($query);
                },
                'attendances as late_count' => static function (Builder $query) use ($applyDateRange): void {
                    $query->where('status', 'late');
                    $applyDateRange($query);
                },
                'attendances as excused_count' => static function (Builder $query) use ($applyDateRange): void {
                    $query->where('status', 'excused');
                    $applyDateRange($query);
                },
            ])
            ->orderBy('name')
            ->orderBy('id')
            ->paginate(20)
            ->withQueryString();

        $totalRecords = (int) $statusCounts->sum();
        $presentRecords = (int) ($statusCounts['present'] ?? 0);
        $attendanceRate = $totalRecords === 0 ? 0 : round(($presentRecords / $totalRecords) * 100, 1);

        return view('reports.index', compact(
            'students',
            'statusCounts',
            'totalRecords',
            'attendanceRate',
            'filters',
        ));
    }
}
