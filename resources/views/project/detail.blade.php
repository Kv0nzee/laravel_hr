<x-layout>
    <x-slot name="title">
        Project Details
    </x-slot>
    <x-slot name="style">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>      
    <div class="flex flex-col items-start justify-center w-full gap-1 px-5 mx-auto lg:px-16 md:px-10">
        <a class="flex items-center px-4 py-2 mb-2 text-sm text-left transition-all bg-gray-600 rounded-lg text-neutral-100 hover:bg-gray-900 " href="{{ URL::previous() }}">Go Back</a>
        <div class="flex items-start w-full">
            <div class="w-4/6">
                <div class="w-full">
                    <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Project:&nbsp; {{$project->title}}</h1>
                    <div class="flex w-full md:gap-x-3">
                        <p class="text-sm text-gray-400 ">Start Date: {{$project->start_date}}</p>
                        @if(strtotime($project->deadline) < strtotime('today'))
                            <p class="text-sm text-red-400">Deadline: {{$project->deadline}}</p>
                        @else
                            <p class="text-sm text-gray-400">Deadline: {{$project->deadline}}</p>
                        @endif
                    </div>
                </div>
                <div class="flex mt-5 gap-x-5"> 
                    <p class=" bg-neutral-100 px-4 py-2 rounded-lg font-bold text-{{ $project->status === 'Complete' ? 'green' : ($project->status === 'In Progress' ? 'yellow' : 'red') }}-600 text-md">{{ $project->status }}</p>
                    <p class=" bg-neutral-100 px-4 py-2 rounded-lg  font-bold text-{{ $project->priority === 'High' ? 'emerald' : ($project->priority === 'Middle' ? 'yellow' : 'red') }}-600 text-md">{{ $project->priority }}</p>
                </div>
                <p class="mt-5 font-bold text-neutral-800 text-md">Description</p>
                <p class="text-neutral-800 text-md">{{$project->description}}</p>
            </div>
            <div class="flex flex-col w-2/6 px-2 border-l-2 gap-y-1">
                @if ($project->leaders) 
                    <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Leaders</h1>
                        <div class="flex justify-start w-full gap-4">
                        @foreach ($project->leaders as $leader) 
                            <div class="overflow-hidden ">
                                <img src="{{$leader->profile_img ? asset('storage/' . $leader->profile_img) : asset('/storage/images/avatarlogo.jpg')}}" alt="profile image" class="object-cover w-12 h-12 rounded-lg">
                                <p class="text-sm text-gray-600 ">{{$leader->name}}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if ($project->members) 
                    <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Members</h1>
                        <div class="flex justify-start w-full gap-4">
                        @foreach ($project->members as $member) 
                            <div class="overflow-hidden ">
                                <img src="{{$member->profile_img ? asset('storage/' . $member->profile_img) : asset('/storage/images/avatarlogo.jpg')}}" alt="profile image" class="object-cover w-12 h-12 rounded-lg">
                                <p class="text-sm text-gray-600 ">{{$member->name}}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
                <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Images</h1>
                <div class="flex justify-start w-full gap-4" id="imagePreviews"></div>
                <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Pdfs</h1>
                <div class="flex justify-start w-full gap-4 " id="pdfPreviews"></div>
            </div>
        </div>
        <p class="my-2 font-bold text-neutral-800 text-md">Task</p>
        <a data-id={{$project->id}} class="flex items-center px-4 py-2 mb-2 text-sm text-left transition-all bg-gray-600 rounded-lg create_task text-neutral-100 hover:bg-gray-900 " href="">Create Task</a>
        <div class="flex flex-col w-full gap-y-5">
            <div class="flex flex-col md:flex-row gap-y-5 gap-x-5">
                <div class="w-full md:w-1/3">
                    <p class="mb-3 font-bold text-neutral-800 text-md">Pending</p>
                    @foreach($project->tasks->where('status', 'Pending') as $task)
                    <div class="flex flex-col w-full p-4 mx-auto my-auto mt-5 text-white h-52 gap rounded-xl bg-gradient-to-r from-red-500 via-red-600 to-red-700">
                        <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-200 text-md">Priority: {{$task->priority}}</span>
                                <a href="" class="text-white editTask" data-id={{$task->id}}>
                                    <i class="bi bi-pen-fill"></i>
                                </a>
                               
                        </div>
                        <div>
                            <div class="flex justify-between w-full my-3 item-start">
                                <p class="text-xl font-bold">{{ Str::limit($task->title, 20) }}</p>
                                 <div class="flex flex-col items-end ">
                                    <p class="text-[10px]  text-gray-200">Start Date: {{$task->start_date}}</p>
                                    <p class="text-[10px]  text-gray-200">Deadline: {{$task->deadline}}</p>
                                </div>
                            </div>   
                                <p class="mb-5 font-bold text-md">{{ Str::limit($task->description, 30) }}</p>
                        </div>
            
                        <div class="relative mb-10">
                            @foreach($task->members as $index => $member)    
                            <img src="{{$member->profile_img ? asset('storage/' . $member->profile_img) : asset('/storage/images/avatarlogo.jpg')}}" class="absolute float-left w-8 border-2 rounded-full left-{{ $index * 5 }}">
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="w-full md:w-1/3">
                    <p class="mb-3 font-bold text-neutral-800 text-md">In Progress</p>
                    @foreach($project->tasks->where('status', 'In Progress') as $task)
                    <div class="flex flex-col w-full p-4 mx-auto my-auto mt-5 text-white h-52 gap rounded-xl bg-gradient-to-r from-yellow-500 via-yellow-600 to-yellow-700">
                        <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-200 text-md">Priority: {{$task->priority}}</span>
                               <a href="" class="text-white editTask" data-id={{$task->id}}>
                                    <i class="bi bi-pen-fill"></i>
                               </a>
                               
                        </div>
                        <div>
                            <div class="flex justify-between w-full my-3 item-start">
                                <p class="text-xl font-bold ">{{ Str::limit($task->title, 20) }}</p>
                                 <div class="flex flex-col items-end ">
                                    <p class="text-[10px]  text-gray-200">Start Date: {{$task->start_date}}</p>
                                    <p class="text-[10px]  text-gray-200">Deadline: {{$task->deadline}}</p>
                                </div>
                            </div>   
                                <p class="mb-5 font-bold text-md">{{ Str::limit($task->description, 30) }}</p>
                        </div>
            
                        <div class="relative mb-10">
                            @foreach($task->members as $index => $member)    
                            <img src="{{$member->profile_img ? asset('storage/' . $member->profile_img) : asset('/storage/images/avatarlogo.jpg')}}" class="absolute float-left w-8 border-2 rounded-full left-{{ $index * 5 }}">
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="w-full md:w-1/3">
                    <p class="mb-3 font-bold text-neutral-800 text-md">Complete</p>
                    @foreach($project->tasks->where('status', 'Complete') as $task)
                    <div class="flex flex-col w-full p-4 mx-auto my-auto mt-5 text-white h-52 gap rounded-xl bg-gradient-to-r from-green-500 via-green-600 to-green-700">
                        <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-200 text-md">Priority: {{$task->priority}}</span>
                               <a href="" class="text-white editTask" data-id={{$task->id}}>
                                    <i class="bi bi-pen-fill"></i>
                               </a>
                               
                        </div>
                        <div>
                            <div class="flex justify-between w-full my-3 item-start">
                                <p class="text-xl font-bold">{{ Str::limit($task->title, 20) }}</p>
                                 <div class="flex flex-col items-end ">
                                    <p class="text-[10px]  text-gray-200">Start Date: {{$task->start_date}}</p>
                                    <p class="text-[10px]  text-gray-200">Deadline: {{$task->deadline}}</p>
                                </div>
                            </div>   
                                <p class="mb-5 font-bold text-md">{{ Str::limit($task->description, 30) }}</p>
                        </div>
            
                        <div class="relative mb-10">
                            @foreach($task->members as $index => $member)    
                            <img src="{{$member->profile_img ? asset('storage/' . $member->profile_img) : asset('/storage/images/avatarlogo.jpg')}}" class="absolute float-left w-8 border-2 rounded-full left-{{ $index * 5 }}">
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
    </div>
<!-- Modal for creating a task -->
    <div id="createTaskModal" class="fixed inset-0 z-50 hidden overflow-y-auto opacity-0 ">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-800 opacity-75"></div>
            </div>

            <!-- Centered modal content -->
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <!-- Header -->
                <div class="flex items-center p-6 rounded-t justify-center relative border-b-[1px]">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-headline">Create Task</h3>
                </div>
                <!-- Body -->
                <div class="w-full px-4 bg-white sm:flex sm:items-start ">
                    <div class="w-full mb-4">
                        <x-form.input label="Title" name="title" />
                        <x-form.inputTextArea label="Description" name="description" />
                        <x-form.input label="Start Date" name="start_date" />
                        <x-form.input label="Deadline" name="deadline" />
                        <x-form.inputMultiSelect label="Set Members" name="members[]" :options="$users" id="id" title="name" class="custom_select" multi="true" />
                        <x-form.inputSelect label="Priority" name="priority" :options="['High', 'Middle', 'Low']"/>
                        <x-form.inputSelect label="Status" name="status" :options="['Pending', 'In Progress', 'Complete']"/>
                    </div>
                </div>
                <!-- Footer -->
                <div class="flex flex-row items-center justify-end w-full gap-4 p-4">
                    <button  type="submit" id="cancelCreateTask" class="flex items-center px-4 py-2 text-sm text-left transition-all bg-gray-600 rounded-lg gap-x-2 text-neutral-100 hover:bg-red-800 ">
                        <i class="bi bi-x-octagon-fill"></i>
                        <p>Cancel</p>  
                    </button>
                    <button type="submit" id="confirmCreateTask" data-id={{$project->id}} class="flex items-center px-4 py-2 text-sm text-left transition-all bg-gray-600 rounded-lg gap-x-2 text-neutral-100 hover:bg-gray-900 ">
                        <i class="bi bi-send-plus-fill"></i>
                        <p>Create</p>  
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layout>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        var editTask = null;

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
            var imgSrc = '<?php echo "/storage/" . $image; ?>';
            var imgElement = $('<img>').attr('src', imgSrc).addClass('object-cover w-12 h-12 rounded-xl');
            $('#imagePreviews').append(imgElement);

            // Initialize Viewer.js on the image link
            new Viewer(imgElement[0]);
            <?php endforeach; ?>
        <?php endif; ?>

        // Display existing PDFs
        <?php if (!is_null($project->files)): ?>
            <?php foreach ($project->files as $pdf): ?>
                var pdfSrc = '<?php echo "/storage/" . $pdf; ?>';
                // $('#pdfPreviews').append($('<a>').attr('href', pdfSrc).append($('<embed>').attr('src', pdfSrc).attr('type', 'application/pdf').addClass('w-full h-20')));
                    $('#pdfPreviews').append($('<a>').attr('href', pdfSrc).attr('target', '_blank').append($('<i>').addClass('bi bi-filetype-pdf text-gray-300 bg-gray-800 rounded-lg px-2 text-4xl font-bold')));
            <?php endforeach; ?>
        <?php endif; ?>

       // Adjust modal for create/edit mode
        function adjustModalForMode(mode, task = null) {
            var modalTitle = document.getElementById('modal-headline');
            var confirmButton = document.getElementById('confirmCreateTask');

            if (mode === 'create') {
                modalTitle.textContent = 'Create Task';
                confirmButton.textContent = 'Create';
                // Clear input fields or set default values for create mode
            } else if (mode === 'edit' && task) {
                modalTitle.textContent = 'Edit Task';
                confirmButton.textContent = 'Save Changes';
                // Populate input fields with existing task details for edit mode
                document.querySelector('input[name="title"]').value = task.title;
                document.querySelector('textarea[name="description"]').value = task.description;
                // Populate other input fields with existing task details...
            }
        }

        // Call this function when opening the modal
        function openTaskModal(mode, task = null) {
            adjustModalForMode(mode, task);
            document.getElementById('createTaskModal').classList.remove('hidden', 'opacity-0');
        }

        // Call this function to open the modal for creating a task
        document.querySelector('.create_task').addEventListener('click', function(e) {
            e.preventDefault();
            openTaskModal('create');
        });

        // Call this function to open the modal for editing a task
        document.querySelector('.editTask').addEventListener('click', function(e) {
                e.preventDefault();
                var taskId = this.dataset.id; // Get the task ID from the dataset
                // Fetch task details based on the taskId (e.g., using AJAX)
                var taskDetails = fetchTaskDetails(taskId); // Implement this function
                openTaskModal('edit', taskDetails);
        });

        function fetchTaskDetails(taskId) {
            return new Promise((resolve, reject) => {
                fetch('/task/' + taskId) 
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch task details');
                        }
                        return response.json();
                    })
                    .then(data => {
                        resolve(data); 
                        console.log(data);
                    })
                    .catch(error => {
                        reject(error); // Reject with the error message
                    });
            });
        }



        // Handle click event on cancel button inside the modal
        document.getElementById('cancelCreateTask').addEventListener('click', function() {
            // Hide the modal
            document.getElementById('createTaskModal').classList.add('hidden', 'opacity-0');
        });

        // Handle click event on create button inside the modal
        document.getElementById('confirmCreateTask').addEventListener('click', function() {
        var id = $(this).data('id');
        var title = document.querySelector('input[name="title"]').value;
        var description = document.querySelector('textarea[name="description"]').value;
        var startDate = document.querySelector('input[name="start_date"]').value;
        var deadline = document.querySelector('input[name="deadline"]').value;
        var members = Array.from(document.querySelectorAll('select[name="members[]"] option:checked')).map(option => option.value);
        var priority = document.querySelector('select[name="priority"]').value;
        var status = document.querySelector('select[name="status"]').value;

        var formData = {
            project_id: id,
            title: title,
            description: description,
            start_date: startDate,
            deadline: deadline,
            members: members,
            priority: priority,
            status: status
        };

        fetch('/task/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to create task');
            }
            return response.json();
        })
        .then(data => {
            toastr.success('Task created successfully');
            setTimeout(function(){
                window.location.reload();
            }, 1000);
        })
        .catch(error => {
            toastr.error('Error creating task:', error.message);
        })
        .finally(() => {
            document.getElementById('createTaskModal').classList.add('hidden', 'opacity-0');
        });
    });
    });
</script>