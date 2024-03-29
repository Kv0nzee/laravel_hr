<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use App\Models\CompanySetting;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class PayrollController extends Controller
{
    public function payroll()
    {
        $selectedYear = Carbon::now()->year;
        $selectedMonth = Carbon::now()->month;
        
        return view('payroll', [
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth
        ]);
    }

    public function payrolltable(Request $request)
    {
        $selectedYear = $request->year ?? Carbon::now()->year;
        $selectedMonth = $request->month ?? Carbon::now()->month;
        $employees = User::orderBy('employee_id')->get();
        $companySetting = CompanySetting::findOrFail(1);

        $startDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->endOfMonth();
        $daysInMonth = Carbon::parse($startDate)->daysInMonth;

        $workingDays = Carbon::parse($startDate)->diffInDaysFiltered(fn($date) => $date->isWeekday(), Carbon::parse($endDate));
        $offDays = $daysInMonth - $workingDays;

        $periods = new CarbonPeriod($startDate, $endDate);
        $attendances = CheckinCheckout::whereMonth('date', $selectedMonth)
            ->whereYear('date', $selectedYear)
            ->get();
        return view('components.payrollOverviewtable', [
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'employees' => $employees,
            'companySetting' => $companySetting,
            'periods' => $periods,
            'attendances' => $attendances,
            'daysInMonth' => $daysInMonth,
            'workingDays' => $workingDays,
            'offDays' => $offDays
        ]);
    }

    public function myPayroll(Request $request)
    {
        $selectedYear = $request->year ?? Carbon::now()->year;
        $selectedMonth = $request->month ?? Carbon::now()->month;
        $employees = User::where('id', auth()->user()->id)->get();
        $companySetting = CompanySetting::findOrFail(1);

        $startDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->endOfMonth();
        $daysInMonth = Carbon::parse($startDate)->daysInMonth;

        $workingDays = Carbon::parse($startDate)->diffInDaysFiltered(fn($date) => $date->isWeekday(), Carbon::parse($endDate));
        $offDays = $daysInMonth - $workingDays;

        $periods = new CarbonPeriod($startDate, $endDate);
        $attendances = CheckinCheckout::whereMonth('date', $selectedMonth)
            ->whereYear('date', $selectedYear)
            ->get();
        return view('components.payrollOverviewtable', [
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'employees' => $employees,
            'companySetting' => $companySetting,
            'periods' => $periods,
            'attendances' => $attendances,
            'daysInMonth' => $daysInMonth,
            'workingDays' => $workingDays,
            'offDays' => $offDays
        ]);
    }
}