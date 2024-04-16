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
        {{-- Task --}}
        <p class="my-2 font-bold text-neutral-800 text-md">Task</p>
        <a data-id={{$project->id}} class="flex items-center px-4 py-2 mb-2 text-sm text-left transition-all bg-gray-600 rounded-lg create_task text-neutral-100 hover:bg-gray-900 " href="">Create Task</a>
        {{-- task boxes --}}
        <x-taskBoxes :project="$project"/>
    </div>
    <!-- Modal for creating a task -->
    <x-taskCreateModal :users="$users" :project="$project"/>
</x-layout>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<!-- jsDelivr :: Sortable :: Latest (https://www.jsdelivr.com/package/npm/sortablejs) -->
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        let taskId = null;

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
                document.querySelector('input[name="start_date"]').value = task.start_date; 
                document.querySelector('input[name="deadline"]').value = task.deadline; 

                // Assign task members to select input valuet
                const memberSelect = document.querySelector('select[name="members[]"]');
                Array.from(memberSelect.options).forEach(option => {
                    if (task.members.some(member => member.id == option.value)) {
                        option.selected = true;
                    }
                });

                document.querySelector('select[name="priority"]').value = task.priority; // Assign task priority to select input value
                document.querySelector('select[name="status"]').value = task.status; // Assign task status to select input value
            }
        }

        // Call this function when opening the modal
        function openTaskModal(mode, task = null) {
            adjustModalForMode(mode, task);
            document.getElementById('createTaskModal').classList.remove('hidden');
            setTimeout(function(){
                document.getElementById('createTaskModal').classList.remove('opacity-0');
            }, 100);
        }

        // Call this function to open the modal for creating a task
        document.querySelector('.create_task').addEventListener('click', function(e) {
            e.preventDefault();
            openTaskModal('create');
        });

        // Call this function to open the modal for editing a task
        document.querySelectorAll('.editTask').forEach(function(element) {
            element.addEventListener('click', async function(e) {
                e.preventDefault();
                taskId = this.dataset.id; 
                var taskDetails = await fetchTaskDetails(taskId); 
                openTaskModal('edit', taskDetails);
            });
        });

        document.querySelectorAll('.deleteTask').forEach(function(element) {
            element.addEventListener('click', async function(e) {
                e.preventDefault();
                taskId = this.dataset.id;
                 // Show toastr confirmation dialog
                toastr.warning('Are you sure you want to delete this task? Click to confirm, else it will cancel', 'Confirmation', {
                    closeButton: true,
                    positionClass: 'toast-top-right',
                    onclick: function (toast) {
                        deletePost(taskId);
                        toastr.remove(toast.toastId);
                    },
                    onclose: function () {
                        toastr.clear();
                    }
                }); 
            });
        });

        function deletePost(taskId){
            let message = 'delete'; 
            fetch('/task/' + taskId + '/delete', {
                method: "DELETE",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to ' + message + ' task'); // Update error message based on message
                }
                toastr.success('Task ' + message + 'd successfully'); // Update success message based on message
                setTimeout(function(){
                    window.location.reload();
                }, 1000);
            })
            .catch(error => {
                toastr.error('Error ' + message + 'ing task:', error.message); // Update error message based on message
            })
        }

        function fetchTaskDetails(taskId) {
            return fetch('/task/' + taskId + '/edit')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch task details');
                    }
                    return response.json();
                })
                .then(data => {
                    return data; 
                })
                .catch(error => {
                    throw error; // Throw the error to be caught by the caller
                });
        }

        document.getElementById('bgoverlay').addEventListener('click', function() {
            // Hide the modal
            document.getElementById('createTaskModal').classList.add('opacity-0');
            setTimeout(function(){
                document.getElementById('createTaskModal').classList.add('hidden');
            }, 500);
        });

        // Handle click event on cancel button inside the modal
        document.getElementById('cancelCreateTask').addEventListener('click', function() {
            // Hide the modal
            document.getElementById('createTaskModal').classList.add('opacity-0');
            setTimeout(function(){
                document.getElementById('createTaskModal').classList.add('hidden');
            }, 500);
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

            let url = '/task/create';
            let message = 'create';
            let md= "POST";

            if(this.textContent != "Create"){
                url = '/task/' + taskId + '/update';
                message = 'edit';
                md = "PATCH"
            }

            fetch(url, {
                method: md,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to ' + message + ' task'); // Update error message based on message
                }
                return response.json();
            })
            .then(data => {
                toastr.success('Task ' + message + 'd successfully'); // Update success message based on message
                setTimeout(function(){
                    window.location.reload();
                }, 1000);
            })
            .catch(error => {
                toastr.error('Error ' + message + 'ing task:', error.message); // Update error message based on message
            })
            .finally(() => {
                document.getElementById('createTaskModal').classList.add('opacity-0');
                setTimeout(function(){
                document.getElementById('createTaskModal').classList.add('hidden');
                }, 500);
            });
        });
    });
</script>