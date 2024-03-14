<x-layout>
    <x-slot name="title">
        Edit Company Setting
    </x-slot>
    <x-slot name="style">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>    
    <form method="POST" id="companyEdit" action="/company_setting/{{$companySetting->id}}/update" class="flex flex-col items-start justify-center w-full gap-6 px-5 mx-auto *:lg:px-16 md:px-10">
        @csrf
        @method('PATCH')
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Edit Company Setting</h1>
        <div class="w-full md:flex md:gap-x-5">
            <div class="w-full md:w-1/2">
                <x-form.input label="Company Name" name="company_name" :value="$companySetting->company_name" />
                <x-form.input label="Email" name="email" :value="$companySetting->email" />
                <x-form.input label="Company Phone" name="company_phone" :value="$companySetting->company_phone" />
                <x-form.input label="Office Start Time" class="timepicker" name="office_start_time" :value="$companySetting->office_start_time" />
                <x-form.input label="Office End Time" class="timepicker"  name="office_end_time" :value="$companySetting->office_end_time" />
            </div>
            <div class="w-full md:w-1/2">
                <x-form.inputTextArea label="Company Address" name="company_address" :value="$companySetting->company_address" />
                <x-form.input label="Break Start Time" class="timepicker"  name="break_start_time" :value="$companySetting->break_start_time" />
                <x-form.input label="Break End Time" class="timepicker"  name="break_end_time" :value="$companySetting->break_end_time" />
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