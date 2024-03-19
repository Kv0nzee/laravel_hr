<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ScannerController extends Controller
{
    public function checkin(){
        $user = auth()->user();
        return view('profile.checkincheckout', [
            'user'=> $user
        ]);
    }

    public function checkPinCode(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|min:6|max:6',
        ]);

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
        return view('profile.qrscanner');
    }
}
