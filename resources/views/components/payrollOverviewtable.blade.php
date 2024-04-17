<!-- Table to display attendance overview -->
    <table id="myTable" class="table w-full">
        <thead class="overflow-x-scroll">
            <tr class="bg-gray-800 text-neutral-50">
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
                            $attendanceDisplay = 0;
                            if($attendanceCount){
                                if ($attendanceCount == 0.5) {
                                    $attendanceDisplay = 'Half';
                                } elseif (($attendanceCount * 10) % floor($attendanceCount) != 0) {
                                    $attendanceDisplay = floor($attendanceCount) . 'days and half';
                                } else {
                                    $attendanceDisplay = $attendanceCount;
                                }
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
                    <td>{{number_format($total )}}</td> 
                </tr>
            @endforeach
        </tbody>
    </table>

    
<script>
    

    table = $('#myTable').DataTable({
        layout: {
                dom: {
                    button: {
                        tag: 'button',
                        className: 'btn'
                    },
                    top: {
                        className: 'top-buttons'
                    }
                },
                topStart: {
                    buttons: [
                                {
                                    extend: 'pdfHtml5',
                                    text: '<span class="font-bold text-md"><i class="mr-2 bi bi-filetype-pdf"></i>PDF</span>',
                                    orientation: 'potrait',
                                    pageSize: 'A4',
                                    title:"Payroll",
                                    customize: function (doc) {
                                                    //Remove the title created by datatTables
                                                    doc.content.splice(0,1);
                                                    var now = new Date();
                                                    var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
                                                    doc.pageMargins = [20,60,20,30];
                                                    doc.defaultStyle.fontSize = 8;
                                                    doc.styles.tableHeader.fontSize = 8;
                                                    doc.styles.tableHeader.fillColor = '#343a40'; // Set background color for table header
                                                    doc.styles.tableHeader.color = '#fff'; // Set text color for table header
                                                    doc.content[0].table.widths = '*';
                                                    doc['header']=(function() {
                                                        return {
                                                            columns: [
                            
                                                                {
                                                                    alignment: 'left',
                                                                    italics: true,
                                                                    text: 'Payroll Table ' + now,
                                                                    fontSize: 18,
                                                                    margin: [10,0],
                                                                    bold: true
                                                                },
                                                                {
                                                                    alignment: 'right',
                                                                    fontSize: 14,
                                                                    text: 'BRNYR HR',
                                                                    bold: 900,
                                                                }
                                                            ],
                                                            margin: 20
                                                        }
                                                    });
                            
                                                    doc['footer']=(function(page, pages) {
                                                        return {
                                                            columns: [
                                                                {
                                                                    alignment: 'left',
                                                                    text: ['Created on: ', { text: jsDate.toString() }]
                                                                },
                                                                {
                                                                    alignment: 'right',
                                                                    text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                                                                }
                                                            ],
                                                            margin: 20
                                                        }
                                                    });
                            
                                                    var objLayout = {};
                                                    objLayout['hLineWidth'] = function(i) { return .5; };
                                                    objLayout['vLineWidth'] = function(i) { return .5; };
                                                    objLayout['hLineColor'] = function(i) { return '#aaa'; };
                                                    objLayout['vLineColor'] = function(i) { return '#aaa'; };
                                                    objLayout['paddingLeft'] = function(i) { return 4; };
                                                    objLayout['paddingRight'] = function(i) { return 4; };
                                                    doc.content[0].layout = objLayout;
                                                    }
                                },
                                {
                                    extend: 'pageLength'
                                },
                                {
                                    text: "<i class='bi bi-arrow-repeat'></i> Refresh",
                                    action: function(e, dt, node, config){
                                        dt.ajax.reload(null, false);
                                    }
                                }
                            ]
                        }
        },
        lengthMenu: [[10,25,50,100,500], ['10 rows', '25 rows', '50 rows', '100 rows', '500 rows']],
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
