<x-layout>
    <x-slot name="title">
        Edit project
    </x-slot>
    <x-slot name="style">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>    
    <form method="POST" id="projectEdit" action="/project/<?php echo $project->id ?>/update" class="flex flex-col items-start justify-center w-full gap-6 px-5 mx-auto *:lg:px-16 md:px-10" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Edit project name</h1>
        <div class="w-full">
            <x-form.input label="Title" name="title" :value="$project->title" />
            <x-form.inputTextArea label="Description" name="description" :value="$project->description" />
            <x-form.input label="Picture(PNG, JPEG only)" :required="false" name="images[]" type="file" accept="image/png, image/jpeg" />
            <div class="flex justify-start w-full gap-4" id="imagePreviews">
            </div>
            <x-form.input label="Attach PDF Document" :required="false" name="pdf_files[]" type="file" accept="application/pdf" multiple />
            <div class="flex justify-start w-full gap-4" id="pdfPreviews"></div>
            <x-form.input label="Start Date" name="start_date" :value="$project->start_date" />
            <x-form.input label="Deadline" name="deadline" :value="$project->deadline" />
            <x-form.inputMultiSelectUser label="Set Leaders" name="leaders[]" :options="$users" id="id" :value="$leaders" title="name" class="custom_select" multi="true" />
            <x-form.inputMultiSelectUser label="Set Members" name="members[]" :options="$users" id="id" :value="$members" title="name" class="custom_select" multi="true" />
            <x-form.inputSelect label="Priority" name="priority" :options="['High', 'Middle', 'Low']" :value="$project->priority" />
            <x-form.inputSelect label="Status" name="status" :options="['Pending', 'In Progress', 'Complete']" :value="$project->status" />
        </div>
        <div class="flex justify-end w-full">
            <button type="submit" class="flex flex-row items-center justify-center w-1/4 p-1 text-xs font-semibold transition duration-500 bg-gray-800 border-4 rounded-lg text-zinc-50 hover:text-neutral-800 md:p-2 lg:text-lg hover:bg-white border-neutral-800">Submit</button>
        </div>
    </form>
</x-layout>

<script type="text/javascript">
    $(function() {
        $('input[name="start_date"]').daterangepicker({
            "singleDatePicker": true,
            "autoApply": true,
            "maxDate": moment(),
            "showDropdowns": true,
            "locale": {
                "format": "YYYY/MM/DD"
            }
        });

        $('input[name="deadline"]').daterangepicker({
            "singleDatePicker": true,
            "autoApply": true,
            "showDropdowns": true,
            "locale": {
                "format": "YYYY/MM/DD"
            }
        });

         // Display existing images
         <?php if (!is_null($project->images)): ?>
            <?php foreach ($project->images as $image): ?>
                $('#imagePreviews').append($('<img>').attr('src', '<?php echo "/storage/" . $image; ?>').addClass('object-cover w-full h-20'));
            <?php endforeach; ?>
        <?php endif; ?>

        // Display existing PDFs
        <?php if (!is_null($project->files)): ?>
            <?php foreach ($project->files as $pdf): ?>
                $('#pdfPreviews').append($('<embed>').attr('src', '<?php echo "/storage/" . $pdf; ?>').attr('type', 'application/pdf').addClass('w-full h-20'));
            <?php endforeach; ?>
        <?php endif; ?>
        

        function readURL(input, containerId) {
            if (input.files && input.files.length > 0) {
                $(containerId).empty(); // Clear existing previews
                
                for (let i = 0; i < input.files.length; i++) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const fileType = input.accept.includes('image') ? 'image' : 'pdf';
                        let preview;
                        if (fileType === 'image') {
                            preview = $('<img>').attr('src', e.target.result).addClass('object-cover w-full h-20');
                        } else {
                            preview = $('<embed>').attr('src', e.target.result).attr('type', 'application/pdf').addClass('w-full h-20');
                        }
                        $(containerId).append(preview); // Append preview
                    }
                    reader.readAsDataURL(input.files[i]); // Convert file to data URL
                }
            }
        }

       
        $('input[name="images[]"]').change(function() {
            readURL(this, '#imagePreviews');
        });

        $('input[name="pdf_files[]"]').change(function() {
            readURL(this, '#pdfPreviews');
        });


        function changeImageColor() {
            $('#imagePreviews img').css('border-color', 'red');
        }
        
        changeImageColor();
    });
</script>