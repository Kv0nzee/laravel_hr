<x-layout>
    <x-slot name="title">
        Create Employees
    </x-slot>
    <form method="POST" id="employeeCreate" class="flex flex-col items-start justify-center w-full gap-6 px-5 mx-auto *:lg:px-16 md:px-10">
        @csrf
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Create Employee</h1>
        <div class="flex w-full gap-x-5">
            <div class="w-1/2">
                <x-form.input label="Employee Id" name="employee_id" type="number"  />
                <x-form.input label="Name" name="name"  />
                <x-form.input label="Email" name="email" type="email" />
                <x-form.input label="Password" name="password" type="password" />
                <x-form.input label="Phone Number" name="phone" type="number" />
                <x-form.input label="NRC Number" name="nrc_number" />
            </div>
            <div class="w-1/2">
                <x-form.inputSelect label="Gender" name="gender" :options="['Male', 'Female']"/>
                <x-form.input label="Birth Date" name="birthday" />
                <x-form.inputSelect label="Department Name" name="department_id" :options=$departments/>
                <x-form.inputSelect label="Employment Status" name="is_present" :options="['Yes', 'No']"/>
                <x-form.inputTextArea label="Address" name="address"  />
                <x-form.input label="Date Of Join" name="date_of_join" />
            </div>
        </div>
        <div class="flex justify-end w-full">
            <button type="submit" class="flex flex-row items-center justify-center w-1/4 p-1 text-xs font-semibold transition duration-500 bg-gray-800 border-4 rounded-lg text-zinc-50 hover:text-neutral-800 md:p-2 lg:text-lg hover:bg-white border-neutral-800">Register</button>
        </div>
        <p class="text-md text-zinc-500">Already have an account? Click <a href="/login" class="text-zinc-900">Login</a>!</p>
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
