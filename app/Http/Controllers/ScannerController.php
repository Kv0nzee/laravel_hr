<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use App\Models\CompanySetting;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ScannerController extends Controller
{
    public function checkin(){
        $user = auth()->user();
        $hash_value = Hash::make(date('Y-m-d'));
        return view('profile.checkincheckout', [
            'user'=> $user,
            'hash_value'=> $hash_value
        ]);
    }

    public function checkPinCode(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|min:6|max:6',
        ]);

        if (now()->format('D') == "Sat" || now()->format('D') =="Sun") {
            return response()->json(['success' => false, 'message' => 'Today is off day. ' ], 422);
        }

        $user = auth()->user();
        $userPinCode = $user->pin_code;

        if (Hash::check($validatedData['code'], $userPinCode)) {
            $user_id = $user->id;
            $existingEntry = CheckinCheckout::where('user_id', $user_id)
                ->whereDate('date', now()->format('Y-m-d'))
                ->first();

            if ($existingEntry?->checkin_time && $existingEntry?->checkout_time) {
                return response()->json(['success' => false, 'message' => 'User already checked out at ' . $existingEntry->checkout_time], 422);
            } else {
                $existingCheckIn = CheckinCheckout::where('user_id', $user_id)
                    ->whereDate('date', now()->format('Y-m-d'))
                    ->whereNotNull('checkin_time')
                    ->first();

                if ($existingCheckIn) {
                    $existingCheckIn->update(['checkout_time' => now()->format('H:i:s')]);
                    return response()->json(['success' => true, 'message' => 'Checked out successfully at ' . now()->format('H:i:s')], 200);
                } else {
                    CheckinCheckout::create([
                        'user_id' => $user_id,
                        'checkin_time' => now()->format('H:i:s'),
                        'date' => now()->format('Y-m-d')
                    ]);
                    return response()->json(['success' => true, 'message' => 'Checked in successfully at ' . now()->format('H:i:s')], 200);
                }
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Incorrect PIN'], 422);
        }
    }

    public function qrscanner(){
        $selectedYear = Carbon::now()->year;
        $selectedMonth = Carbon::now()->month;
        
        return view('profile.qrscanner', [
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth
        ]);
    }

    public function qrscannerDetailOverview(Request $request){
        $selectedYear = $request->year ?? Carbon::now()->year;
        $selectedMonth = $request->month ?? Carbon::now()->month;
        $employee = User::where('id', auth()->user()->id)->get();
        $companySetting = CompanySetting::findOrFail(1);

        $startDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->endOfMonth();

        $periods = new CarbonPeriod($startDate, $endDate);
        $attendances = CheckinCheckout::whereMonth('date', $selectedMonth)
        ->whereYear('date', $selectedYear)
        ->get();
        return view('components.attendanceOverviewtable', [
            'employees' => $employee,
            'companySetting' => $companySetting,
            'periods' => $periods,
            'attendances' => $attendances
        ]);
    }

    public function qrStore(Request $request){

        if (now()->format('D') == "Sat" || now()->format('D') =="Sun") {
            return response()->json(['success' => false, 'message' => 'Today is off day. ' ], 422);
        }
        
        if(!Hash::check(date('Y-m-d'), $request->hash_value)){
            return [
                'status' => 'fail',
                'message'=> 'QR code is invalid'
            ];
        }

        $user = auth()->user();
        $user_id = $user->id;
        $existingEntry = CheckinCheckout::where('user_id', $user_id)
            ->whereDate('date', now()->format('Y-m-d'))
            ->first();
        if ($existingEntry?->checkin_time && $existingEntry?->checkout_time) {
            return response()->json(['success' => false, 'message' => 'User already checked out at ' . $existingEntry->checkout_time], 422);
        } else {
            $existingCheckIn = CheckinCheckout::where('user_id', $user_id)
                ->whereDate('date', now()->format('Y-m-d'))
                ->whereNotNull('checkin_time')
                ->first();
            if ($existingCheckIn) {
                $existingCheckIn->update(['checkout_time' => now()->format('H:i:s')]);
                return response()->json(['success' => true, 'message' => 'Checked out successfully at ' . now()->format('H:i:s')], 200);
            } else {
                CheckinCheckout::create([
                    'user_id' => $user_id,
                    'checkin_time' => now()->format('H:i:s'),
                    'date' => now()->format('Y-m-d')
                ]);
                return response()->json(['success' => true, 'message' => 'Checked in successfully at ' . now()->format('H:i:s')], 200);
            }
        }

    }
}
