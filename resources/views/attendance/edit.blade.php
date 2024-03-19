<x-layout>
    <x-slot name="title">
        Edit Attendance
    </x-slot>
    <x-slot name="style">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>    
    <form method="POST" id="attendanceEdit" action="/attendance/{{ $attendance->id }}/update" class="flex flex-col items-start justify-center w-full gap-6 px-5 mx-auto lg:px-16 md:px-10">
        @csrf
        @method('PATCH')
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Edit Attendance</h1>
        <div class="w-full gap-y-5">
            <div class="relative w-full">
                <label class="absolute text-md text-zinc-800 duration-150 transform -translate-y-5 scale-75 top-0 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3" >Employee Name:</label>
                <p class="block w-full px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $attendance->employee->name }}</p>
            </div>
            <x-form.input label="Checkin Time" class="timepicker" name="checkin_time" :value="$attendance->checkin_time"  />
            <x-form.input label="Checkout Time" class="timepicker"  name="checkout_time" :value="$attendance->checkout_time"/>
        </div>
        </div>
        <div class="flex justify-end w-full">
            <button type="submit" class="flex flex-row items-center justify-center w-1/4 p-1 text-xs font-semibold transition duration-500 bg-gray-800 border-4 rounded-lg text-zinc-50 hover:text-neutral-800 md:p-2 lg:text-lg hover:bg-white border-neutral-800">Submit</button>
        </div>
    </form>
 
</x-layout>

<script>
    $(document).ready(function(){
        $('.timepicker').daterangepicker({
        "singleDatePicker": true,
        "timePicker": true,
        "timePicker24Hour": true,
        "timePickerSeconds": true,
        "autoApply": true,
        "locale": {
            "format": "HH:mm:ss",
        }
        }).on('show.daterangepicker', function(ev,picker){
            $('.calendar-table').hide();
        })
    })
</script>