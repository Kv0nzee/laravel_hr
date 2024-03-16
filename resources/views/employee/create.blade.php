<x-layout>
    <x-slot name="title">
        Create Employees
    </x-slot>
    <x-slot name="style">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>    
    <form  enctype="multipart/form-data" method="POST" id="employeeCreate" class="flex flex-col items-start justify-center w-full gap-6 px-5 mx-auto *:lg:px-16 md:px-10">
        @csrf
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Create Employee</h1>
        <div class="w-full md:flex md:gap-x-5">
            <div class="w-full md:w-1/2">
                <x-form.input label="Employee Id" name="employee_id" type="number"  />
                <x-form.input label="Name" name="name"  />
                <x-form.input label="Email" name="email" type="email" />
                <x-form.input label="Password" name="password" type="password" />
                <x-form.input label="Phone Number" name="phone" type="number" />
                <x-form.input label="NRC Number" name="nrc_number" />
                <x-form.input label="Pin Code" name="pin_code" />
                <x-form.input label="Profile Picture(PNG, JPEG only)" :required="false" name="profile_img" type="file" accept="image/png, image/jpeg"/>
                <img id="previewImage" src="#" alt="Preview" class="hidden object-cover w-full h-20 ">
            </div>
            <div class="w-full md:w-1/2">
                <x-form.inputSelect label="Gender" name="gender" :options="['Male', 'Female']"/>
                <x-form.input label="Birth Date" name="birthday" />
                <x-form.inputSelect label="Department Name" class="custom_select" name="department_id" :options=$departments/>
                <x-form.inputMultiSelect label="Set Roles" name="roles[]" :options="$roles" id="name" title="name" class="custom_select" multi="true" />
                <x-form.inputSelect label="Employment Status" name="is_present" :options="['Yes', 'No']"/>
                <x-form.inputTextArea label="Address" name="address"  />
                <x-form.input label="Date Of Join" name="date_of_join" />
            </div>
        </div>
        <div class="flex justify-end w-full">
            <button type="submit" class="flex flex-row items-center justify-center w-1/4 p-1 text-xs font-semibold transition duration-500 bg-gray-800 border-4 rounded-lg text-zinc-50 hover:text-neutral-800 md:p-2 lg:text-lg hover:bg-white border-neutral-800">Register</button>
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

     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result).show();
                }
                
                reader.readAsDataURL(input.files[0]); // Convert image to data URL
            }
    }

     $('input[name="profile_img"]').change(function() {
            readURL(this);
        });
        
        function changeImageColor() {
            $('#previewImage').css('border-color', 'red');
        }
        
        changeImageColor();
  });
  
</script>
