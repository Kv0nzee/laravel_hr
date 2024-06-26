<x-layout>
    <x-slot name="title">
        Qr Scanner
    </x-slot>
    <x-slot name="style">        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>

    <main class="w-full h-100vh">
        <h2 class="text-xl text-gray-600 md:text-3xl lg:text-5xl text-nowrap">Scan The Attendance QR</h2>
        <section class="relative flex items-center justify-center w-full h-full py-16">
            <button id="scanQrButton" class="flex items-center w-1/2 px-4 py-2 text-sm text-left transition-all bg-gray-600 rounded-lg text-neutral-100 hover:bg-gray-900">
                <h2 class="text-xl md:text-3xl lg:text-5xl text-nowrap">Scan Qr Code</h2>
                <svg viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M384 64H134.144c-51.2 0-89.6 41.472-89.6 89.6v227.328c0 51.2 41.472 89.6 89.6 89.6H384c51.2 0 89.6-41.472 89.6-89.6V153.6c0-48.128-38.4-89.6-89.6-89.6z m45.056 316.928c0 25.6-19.456 44.544-45.056 44.544H134.144c-25.6 0-45.056-19.456-45.056-44.544V153.6c0-25.6 19.456-45.056 45.056-45.056H384c25.6 0 45.056 18.944 45.056 45.056v227.328z" fill="#5FFFBA"></path><path d="M192 192h134.656v134.656H192V192z" fill="#FFA28D"></path><path d="M377.856 544.256H134.656c-48.128 0-86.528 38.4-86.528 89.6v220.672c0 48.128 38.4 89.6 86.528 89.6h243.2c48.128 0 86.528-38.4 86.528-89.6v-220.672c3.072-51.2-38.912-89.6-86.528-89.6z m44.544 307.2c0 25.6-19.456 45.056-45.056 45.056H134.656c-25.6 0-45.056-19.456-45.056-45.056v-220.672c0-25.6 18.944-45.056 45.056-45.056h243.2c25.6 0 45.056 19.456 45.056 45.056v220.672z" fill="#5FFFBA"></path><path d="M192 668.672h131.072v131.072H192v-131.072z" fill="#FFD561"></path><path d="M633.344 470.528h249.344c51.2 0 89.6-41.472 89.6-89.6V153.6c0-51.2-41.472-89.6-89.6-89.6h-249.344c-51.2 0-89.6 41.472-89.6 89.6v227.328c0.512 51.2 41.984 89.6 89.6 89.6zM588.8 153.6c0-25.6 19.456-45.056 44.544-45.056h249.344c25.6 0 45.056 19.456 45.056 45.056v227.328c0 25.6-19.456 44.544-45.056 44.544h-249.344c-25.6 0-44.544-19.456-44.544-44.544V153.6z" fill="#5FFFBA"></path><path d="M700.928 192h134.144v134.656h-134.656l0.512-134.656z" fill="#FFD561"></path><path d="M572.928 716.8h137.728c12.8 0 22.528-9.728 22.528-22.528v-137.728c0-12.8-9.728-22.528-22.528-22.528h-137.728c-12.8 0-22.528 9.728-22.528 22.528v137.728c0 12.8 9.728 22.528 22.528 22.528zM886.272 563.2v38.4c0 12.8 12.8 25.6 25.6 25.6h38.4c12.8 0 25.6-12.8 25.6-25.6V563.2c0-12.8-12.8-25.6-25.6-25.6h-38.4c-12.8 0-25.6 9.728-25.6 25.6zM582.656 944.128h48.128c12.8 0 22.528-9.728 22.528-22.528v-48.128c0-12.8-9.728-22.528-22.528-22.528h-48.128c-12.8 0-22.528 9.728-22.528 22.528v48.128c0 12.8 9.216 22.528 22.528 22.528zM944.128 704H844.8c-15.872 0-28.672 12.8-28.672 28.672v45.056H768c-19.456 0-32.256 12.8-32.256 32.256v99.328c0 15.872 12.8 28.672 28.672 28.672l179.2 3.072c15.872 0 28.672-12.8 28.672-28.672v-179.2c0.512-16.384-12.288-29.184-28.16-29.184z" fill="#5FFFBA"></path></g></svg>
            </button>
            <div id="myModal" class="fixed inset-0 z-50 flex items-center justify-center hidden overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-neutral-800/70">
                <button class="absolute text-gray-400 transition top-4 right-4 hover:text-white" id="closeModal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="relative w-full mx-auto my-6 md:w-4/6 xl:w-3/5 h-3/5 lg:h-auto md:h-auto">
                    <video class="w-full " id="video"></video>
                </div>
            </div>
        </section>
        <div class="mt-5">
            <div class="flex flex-col items-start w-full">
                <!-- Label for month and year selection -->
                <label class="pb-1 font-bold duration-150 text-end text-md text-zinc-800 text-nowrap">Month and Year</label>
                <!-- Input for selecting month and year -->
                <input type="month" id="filter" name="filter" class="block px-6 pt-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md focus:outline-none focus:ring-0 peer" value="{{ $selectedYear }}-{{ str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) }}" />
            </div>
            <h1 class="mt-5 font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Payroll Overview</h1>
            <div id="payroll" class="w-full overflow-hidden table-responsive"></div>
            <h1 class="mt-5 font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Attendance Overview</h1>
            <div id="attendance" class="w-full overflow-hidden table-responsive"></div>
        </div>
        <div class="w-full overflow-hidden table-responsive">
            <table id="datatable"  class="table w-full display table-bordered">
                <thead>
                    <tr class="bg-gray-800 text-neutral-50">
                        <th class="hidden no-sort no-search"></th>
                        <th>Employee Name</th>
                        <th>Date</th>
                        <th>Check in Time</th>
                        <th>Check out Time</th>
                        <th class="hidden no-sort no-search" hidden>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </main>
</x-layout>
<script type="module">
    // do something with QrScanner
</script>
<script src="/storage/qr-scanner.umd.min.js"></script>
<script>
    $(document).ready(function(){
        var videoElem = document.getElementById('video');
        const qrScanner = new QrScanner(videoElem, function(result){
            console.log(result);
            if(result){
                qrScanner.stop();
                $.ajax({
                url: '/qrscannerValid/',
                data: {"hash_value": result},
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#myModal').hide();
                    toastr.success( response.message);
                    console.log(response);
                    setTimeout(function(){
                        window.location.href = '/';
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText).message;
                    toastr.error(errorMessage);
                    $('#myModal').hide();

                }
            });
            }
        });
        $('#scanQrButton').click(function(){
            $('#myModal').show(); // Show the modal with ID 'myModal'
            qrScanner.start();
        });
        
        $('#closeModal').click(function(){
            // Close the modal
            $('#myModal').hide();
            qrScanner.stop();
        });

        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/attendanceDetail',
                data: function (d) {
                    d.year = $('#filter').val().split('-')[0];
                    d.month = $('#filter').val().split('-')[1];
                }
            },
            responsive: true,
            columns: [
                { data: 'plus-icon', name: 'plus-icon' }, 
                { data: 'employee_name', name: 'employee_name' }, 
                { data: 'date', name: 'date' }, 
                { data: 'checkin_time', name: 'checkin_time' }, 
                { data: 'checkout_time', name: 'checkout_time' }, 
                { data: 'updated_at', name: 'updated_at' },
            ],
            order: [[7, "desc"]],
            columnDefs:[
                {
                    "targets": "hidden",
                    "visible": false
                },
                {
                    "targets": [0],
                    "class": "control",
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

        $('#filter').change(function () {
            updateTable();
            table.ajax.reload();
        });
        function updateTable() {
            var selectedDate = $('#filter').val();
            var selectedYear = selectedDate ? selectedDate.split('-')[0] : 0;
            var selectedMonth = selectedDate ? selectedDate.split('-')[1] : 0;

            $.ajax({
                url: "/employeeattendanceOverviewtable" + "?month=" + selectedMonth + "&year=" + selectedYear,
                method: 'GET',
                success: function (data) {
                    $('#attendance').html(data);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });

            $.ajax({
                url: "/mypayroll" + "?month=" + selectedMonth + "&year=" + selectedYear,
                method: 'GET',
                success: function (data) {
                    $('#payroll').html(data);
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
