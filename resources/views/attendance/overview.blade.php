<x-layout>
    <x-slot name="title">
        Attendance Overview
    </x-slot>
    <x-slot name="style">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>
    <div class="mt-5 ">
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Attendance Overview</h1>
        <div class="w-1/2">
            <div class="flex flex-col items-start w-full">
                <label class="pb-1 font-bold duration-150 text-end text-md text-zinc-800 text-nowrap" >Month and Year</label>
                <input type="month" id="filter" name="filter" onchange="updateTable()" class="block w-full px-6 pt-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md focus:outline-none focus:ring-0 peer" value="{{ $selectedYear }}-{{ str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) }}" />
            </div>
        </div>
        <div class="w-full overflow-hidden table-responsive">
            <table id="myTable"  class="table w-full">
                <thead class="overflow-x-scroll">
                    <tr>
                        <th class=" text-nowrap">Employee Name</th>
                        @foreach ($periods as $period)
                            <th class="no-sort">{{$period->format('d')}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee )
                        <tr>
                            <td>{{$employee->name}}</td>
                            @foreach ($periods as $period)
                            @php
                                $checkin_icon = "";
                                $checkout_icon = "";
                                $attendance = collect($attendances)->where('user_id', $employee->id)->where('date', $period->format('Y-m-d'))->first();
                                if ($attendance) {
                                    if ($attendance->checkin_time < $companySetting->office_filter_time) {
                                        $checkin_icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-success"></i>';
                                    } else if ($attendance->checkin_time > $companySetting->office_filter_time && $attendance->checkin_time < $companySetting->break_filter_time) {
                                        $checkin_icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-warning"></i>';
                                    } else {
                                        $checkin_icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-danger"></i>';
                                    }

                                    if ($attendance->checkout_time < $companySetting->break_end_time) {
                                        $checkout_icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-danger"></i>';
                                    } else if ($attendance->checkout_time < $companySetting->office_end_time) {
                                        $checkout_icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-warning"></i>';
                                    } else {
                                        $checkout_icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-success"></i>';
                                    }

                                }
                            @endphp
                                <td>
                                    {!!$checkin_icon!!}
                                    {!!$checkout_icon!!}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>

<script>
    function updateTable() {
        var selectedDate = document.getElementById('filter').value;
        var selectedYear = selectedDate.split('-')[0];
        var selectedMonth = selectedDate.split('-')[1];

        var url = "attendanceOverview" + "?month=" + selectedMonth + "&year=" + selectedYear;
    
    // Redirect to the constructed URL
    window.location.href = url;
    }

    table = $('#myTable').DataTable({
        scrollY: '60vh',
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

    document.addEventListener("DOMContentLoaded", function () {
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();;
        var currentMonth = currentDate.getMonth() + 1;

        // Set min attribute to five years ago
        var fiveYearsAgo = (currentYear - 5) + '-' + (currentMonth < 10 ? '0' + currentMonth : currentMonth);
        document.getElementById('filter').setAttribute('min', fiveYearsAgo);

        // Set max attribute to the current month
        var currentMonthFormatted = currentYear + '-' + (currentMonth < 10 ? '0' + currentMonth : currentMonth);
        document.getElementById('filter').setAttribute('max', currentMonthFormatted);

    });
</script>