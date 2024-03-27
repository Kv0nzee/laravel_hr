<!-- Table to display attendance overview -->
    <table id="myTable" class="table w-full">
        <thead class="overflow-x-scroll">
            <tr>
                <!-- Table header for employee names -->
                <th class="text-nowrap">Employee Name</th>
                <!-- Table headers for each day of the selected month -->
                @foreach ($periods as $period)
                    <th class="no-sort text-center @if($period->format('D') == 'Sat' || $period->format('D') == 'Sun') alert alert-danger @endif">{{$period->format('d')}} <br/> {{$period->format('D')}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <!-- Display employee name in the first column -->
                    <td>{{$employee->name}}</td>
                    <!-- Loop through each day of the selected month -->
                    @foreach ($periods as $period)
                    @php
                        // Initialize checkin and checkout icons
                        $checkin_icon = "";
                        $checkout_icon = "";
                        // Retrieve attendance data for the current employee and day
                        $attendance = collect($attendances)->where('user_id', $employee->id)->where('date', $period->format('Y-m-d'))->first();
                        // Determine checkin and checkout icons based on attendance data
                        if ($period->format('Y-m-d') <= now()->toDateString()){
                            if(!$attendance){
                                $checkin_icon = '<i class="w-5 h-5 bi bi-dash-circle-fill text-warning"></i>';
                            }
                            else if ($attendance->checkin_time < $companySetting->office_start_time) {
                                $checkin_icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-success"></i>';
                            } else if ($attendance->checkin_time > $companySetting->office_start_time && $attendance->checkin_time < $companySetting->break_start_time) {
                                $checkin_icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-warning"></i>';
                            } else {
                                $checkin_icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-danger"></i>';
                            }

                            if(!$attendance){
                                $checkout_icon = '<i class="w-5 h-5 bi bi-dash-circle-fill text-warning"></i>';
                            }
                            else if ($attendance->checkout_time < $companySetting->break_end_time) {
                                $checkout_icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-danger"></i>';
                            } else if ($attendance->checkout_time < $companySetting->office_end_time) {
                                $checkout_icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-warning"></i>';
                            } else {
                                $checkout_icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-success"></i>';
                            }
                        }
                    @endphp
                    <!-- Display checkin and checkout icons for each day -->
                    <td>
                        {!!$checkin_icon!!}
                        {!!$checkout_icon!!}
                    </td>
                    @endforeach
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
