<x-layout>
    <x-slot name="title">
        Edit Employee
    </x-slot>
    <form method="POST" action="/employee/<?php echo $user->id ?>/update" class="flex flex-col items-start justify-center w-full gap-6 px-5 mx-auto lg:px-16 md:px-10">
        @csrf
        @method('PATCH')
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Edit Employee</h1>
        <div class="w-full md:flex md:gap-x-5">
            <div class="w-full md:w-1/2">
                <x-form.input label="Employee Id" name="employee_id" type="number" :value="$user->employee_id" />
                <x-form.input label="Name" name="name" :value="$user->name" />
                <x-form.input label="Email" name="email" type="email" :value="$user->email" />
                <x-form.input label="Password" name="password" type="password" :required="false"/>
                <x-form.input label="Phone Number" name="phone" type="number" :value="$user->phone" />
                <x-form.input label="NRC Number" name="nrc_number" :value="$user->nrc_number" />
            </div>
            <div class="w-full md:w-1/2">
                <x-form.inputSelect label="Gender" name="gender" :options="['Male', 'Female']" :value="$user->gender" />
                <x-form.input label="Birth Date" name="birthday" :value="$user->birthday" />
                <x-form.inputSelect label="Department Name" name="department_id" :options="$departments" :value="$user->department_id" />
                <x-form.inputSelect label="Employment Status" name="is_present" :options="['Yes', 'No']" :value="$user->is_present" />
                <x-form.inputTextArea label="Address" name="address" :value="$user->address" />
                <x-form.input label="Date Of Join" name="date_of_join" :value="$user->date_of_join" />
            </div>
        </div>
        <div class="flex justify-end w-full">
            <button type="submit" class="flex flex-row items-center justify-center w-1/4 p-1 text-xs font-semibold transition duration-500 bg-gray-800 border-4 rounded-lg text-zinc-50 hover:text-neutral-800 md:p-2 lg:text-lg hover:bg-white border-neutral-800">Update</button>
        </div>
    </form>
</x-layout>

{{-- {!! JsValidator::formRequest('App\Http\Requests\StoreEmployee', '#employeeCreate');!!} --}}
<script type="text/javascript">
  $(function() {
    $('input[name="birthday"]').daterangepicker({
        "singleDatePicker": true,
        "autoApply": true,
        "maxDate": moment(),
        "showDropdowns": true,
        "locale": {
        "format": "MM/DD/YYYY"
        }
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
     });
     $('input[name="date_of_join"]').daterangepicker({
        "singleDatePicker": true,
        "autoApply": true,
        "maxDate": moment(),
        "showDropdowns": true,
        "locale": {
        "format": "MM/DD/YYYY"
        }
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
     });
  });
  
</script>
