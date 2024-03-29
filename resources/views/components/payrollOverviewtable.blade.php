<!-- Table to display attendance overview -->
    <table id="myTable" class="table w-full">
        <thead class="overflow-x-scroll">
            <tr>
                <!-- Table header for employee names -->
                <th class="text-nowrap">Employee Name</th>
                <th class="text-nowrap">Role</th>
                <th class="text-nowrap">Days of Month</th>
                <th class="text-nowrap">Working Days</th>
                <th class="text-nowrap">Off Day</th>
                <th class="text-nowrap">Attendance Day</th>
                <th class="text-nowrap">Leave Day</th>
                <th class="text-nowrap">Per Day(MMK)</th>
                <th class="text-nowrap">Total (MMK)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    @php
                        $attendanceCount = 0;
                        $salary = collect($employee->salaries)->where('month', "{$selectedYear}-{$selectedMonth}")->first();
                        $perday = $salary ? $salary->amount / $daysInMonth : 0;
                        
                        foreach ($periods as $period) {
                            $attendance = collect($attendances)->where('user_id', $employee->id)->where('date', $period->format('Y-m-d'))->first();
                            
                            // Determine checkin and checkout times based on attendance data
                            if ($attendance) {
                                $checkinTime = $attendance->checkin_time;
                                $checkoutTime = $attendance->checkout_time;
                                
                                // Calculate attendance count only for days before the current date
                                if ($period->lte(now()->startOfDay())) {
                                    // Check if both checkin and checkout times are set
                                    if ($checkinTime && $checkoutTime) {
                                        // Check if checkin is before office start time and checkout is after office end time
                                        if ($checkinTime < $companySetting->office_start_time && $checkoutTime > $companySetting->office_end_time) {
                                            $attendanceCount += 1;
                                        } else {
                                            // Check if checkin is before office start time and checkout is before office end time
                                            if ($checkinTime < $companySetting->office_start_time && $checkoutTime <= $companySetting->office_end_time) {
                                                $attendanceCount += 0.5;
                                            }
                                            // Check if checkin is after office start time and before break start time and checkout is after break end time and after office end time
                                            elseif ($checkinTime > $companySetting->office_start_time && $checkinTime < $companySetting->break_start_time && $checkoutTime > $companySetting->break_end_time && $checkoutTime > $companySetting->office_end_time) {
                                                $attendanceCount += 0.5;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $leaveDays = $workingDays - $attendanceCount;
                        $total = $perday ? round($perday * $attendanceCount) : 0;
                    @endphp
                    
                    <!-- Display employee name in the first column -->
                    <td>{{$employee->name}}</td>
                    <td>
                        @foreach ($employee->roles as $role)
                        {{ $role->name }}
                        @endforeach
                    </td>
                    <td>{{$daysInMonth}}</td>
                    <td>{{$workingDays}}</td>
                    <td>{{$offDays}}</td>
                    <td>
                        @php
                            $attendanceDisplay = '';
                            if ($attendanceCount == 0.5) {
                                $attendanceDisplay = 'Half';
                            } elseif (($attendanceCount * 10) % floor($attendanceCount) != 0) {
                                $attendanceDisplay = floor($attendanceCount) . 'days and half';
                            } else {
                                $attendanceDisplay = $attendanceCount;
                            }
                        @endphp
                        {{ $attendanceDisplay }}
                    </td>
                    <td>
                        @php
                            $leaveDisplay = '';
                            if ($leaveDays == 0.5) {
                                $leaveDisplay = 'Half';
                            } elseif (($leaveDays * 10) % floor($leaveDays) != 0) {
                                $leaveDisplay = floor($leaveDays) . 'days and half';
                            } else {
                                $leaveDisplay = $leaveDays;
                            }
                        @endphp
                        {{ $leaveDisplay }}
                    </td>                   
                    <td>{{number_format($perday)}}</td> 
                    <td>{{number_format($total)}}</td> 
                </tr>
            @endforeach
        </tbody>
    </table>

    
<script>
    

    table = $('#myTable').DataTable({
        scrollX: true,
        fixedHeader: true,
        columnDefs: [
            {
                "targets": "hidden",
                "visible": false
            },
            {
                "targets": 'no-sort',
                "orderable": false
            },
            {
                "targets": 'no-search',
                "searchable": false
            }
        ]
    });
</script>
