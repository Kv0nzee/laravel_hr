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
        <div class="table-responsive">
            <table id="myTable"  class="table w-full display">
                <thead class="overflow-x-scroll">
                    <tr>
                        <th class=" text-nowrap">Employee Name</th>
                        @foreach ($periods as $period)
                            <th>{{$period->format('d')}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee )
                        <tr>
                            <td>{{$employee->name}}</td>
                            @foreach ($periods as $period)
                            @php
                                $icon = "";
                                $attendance = collect($attendances)->where('user_id', $employee->id)->where('date', $period->format('Y-m-d'))->first();
                                echo "<script>console.log(".$attendance.")</script>";
                                if ($attendance) {
                                    if ($attendance->checkin_time < $companySetting->office_start_time) {
                                        $icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-success"></i>';
                                    } else if ($attendance->checkin_time > $companySetting->office_start_time && $attendance->checkin_time < $companySetting->break_start_time) {
                                        $icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-warning"></i>';
                                    } else {
                                        $icon = '<i class="w-5 h-5 bi bi-check-circle-fill text-warning"></i>';
                                    }
                                }
                            @endphp
                                <td>
                                    {!!$icon!!}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>

<script type="text/javascript">
    $(document).ready(function () {
    });
</script>
