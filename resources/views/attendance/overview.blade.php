<x-layout>
    <!-- Title for the page -->
    <x-slot name="title">
        Attendance Overview
    </x-slot>
    <!-- External stylesheets -->
    <x-slot name="style">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>
    <div class="mt-5">
        <!-- Page heading -->
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Attendance Overview</h1>
        <div class="flex flex-col items-start w-full">
            <!-- Label for month and year selection -->
            <label class="pb-1 font-bold duration-150 text-end text-md text-zinc-800 text-nowrap">Month and Year</label>
            <!-- Input for selecting month and year -->
            <input type="month" id="filter" name="filter" class="block px-6 pt-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md focus:outline-none focus:ring-0 peer" value="{{ $selectedYear }}-{{ str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) }}" />
        </div>
        <div id="overview" class="w-full overflow-hidden table-responsive"></div>
    </div>
</x-layout>

<script>
    $(document).ready(function () {
        $('#filter').change(function () {
            updateTable();
        });

        function updateTable() {
            var selectedDate = $('#filter').val();
            var selectedYear = selectedDate ? selectedDate.split('-')[0] : 0;
            var selectedMonth = selectedDate ? selectedDate.split('-')[1] : 0;

            $.ajax({
                url: "/attendanceOverviewtable" + "?month=" + selectedMonth + "&year=" + selectedYear,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    $('#overview').html(data);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
        updateTable();

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