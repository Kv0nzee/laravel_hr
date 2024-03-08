<x-whlayout>
    <x-slot name="title">
        Register
    </x-slot>
    <form enctype="multipart/form-data" method="POST" class="flex flex-col items-start justify-center w-full gap-6 px-5 mx-auto md:w-3/5 lg:px-16 md:px-10">
        @csrf
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Register</h1>
        <div class="w-full md:flex md:gap-x-5">
            <div class="w-full md:w-1/2">
                <x-form.input name="name" label="Name"  />
                <x-form.input name="email" label="Email" type="email" />
                <x-form.input name="phone" label="Phone Number" type="number" />
                <x-form.input name="password" label="Password" type="password" />
                <x-form.input name="confirm_password" label="Confirm Password" type="password" />
                <x-form.input :required="false" label="Profile Picture(PNG, JPEG only)Optional*" name="profile_img" type="file" accept="image/png, image/jpeg"/>
                <img id="previewImage" src="#" alt="Preview" class="hidden object-cover w-full h-20 ">
            </div>
            <div class="w-full md:w-1/2">
                <x-form.input name="employee_id" label="Employee ID" type="number" />
                <x-form.input name="nrc_number" label="NRC Number" />
                <x-form.inputSelect name="gender" label="Gender" :options="['Male', 'Female']" />
                <x-form.input name="birthday" label="Birth Date" />
                <x-form.inputSelect name="department_id" label="Department Name" :options="$departments" />
                <x-form.inputSelect name="is_present" label="Employment Status" :options="['Yes', 'No']" />
                <x-form.input name="address" label="Address" />
                <x-form.input name="date_of_join" label="Date Of Join" />
            </div>
        </div>
        <div class="flex justify-end w-full">
            <button type="submit" class="flex flex-row items-center justify-center w-1/4 p-1 text-xs font-semibold transition duration-500 bg-gray-800 border-4 rounded-lg text-zinc-50 hover:text-neutral-800 md:p-2 lg:text-lg hover:bg-white border-neutral-800">Register</button>
        </div>
        <p class="text-md text-zinc-500">Already have an account? Click <a href="/login" class="text-zinc-900">Login</a>!</p>
    </form>
</x-whlayout>


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