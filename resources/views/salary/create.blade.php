<x-layout>
    <x-slot name="title">
        Create Salary
    </x-slot>
    <x-slot name="style">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>    
    <form method="POST" id="departmentCreate" class="flex flex-col items-start justify-center w-full gap-6 px-5 mx-auto *:lg:px-16 md:px-10">
        @csrf
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Create Salary For Employee</h1>
        <div class="w-full">
            <x-form.inputMultiSelect label="Select Employees" name="employee_names[]" :options="$employees" id="id" title="name" class="custom_select" multi="true" />
            <x-form.input class="" type="month" label="Month" name="month" />
            <x-form.input label="Amount" name="amount" type="number" />
        </div>
        <div class="flex justify-end w-full">
            <button type="submit" class="flex flex-row items-center justify-center w-1/4 p-1 text-xs font-semibold transition duration-500 bg-gray-800 border-4 rounded-lg text-zinc-50 hover:text-neutral-800 md:p-2 lg:text-lg hover:bg-white border-neutral-800">Submit</button>
        </div>
    </form>
 
</x-layout>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        var amountInput = document.querySelector('input[name="amount"]');
        amountInput.setAttribute('min', '100000');
        amountInput.value = '150000';

        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        var currentMonth = currentDate.getMonth() + 1; // Adding 1 because getMonth() returns zero-based index

        // Set month input value to the current month
        var monthInput = document.querySelector('input[name="month"]');
        monthInput.value = `${currentYear}-${currentMonth.toString().padStart(2, '0')}`;

        // Calculate three months ahead
        var threeMonthsAhead = new Date(currentDate);
        threeMonthsAhead.setMonth(currentDate.getMonth() + 3);
        var maxYear = threeMonthsAhead.getFullYear();
        var maxMonth = threeMonthsAhead.getMonth() + 1;

        // Set max attribute for month input
        monthInput.setAttribute('max', `${maxYear}-${maxMonth.toString().padStart(2, '0')}`);
    });
</script>