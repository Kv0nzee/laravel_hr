@props(['project'])

<div class="flex flex-col w-full gap-y-5">
    <div class="flex flex-col md:flex-row gap-y-5 gap-x-5">
        <div class="w-full md:w-1/3">
            <p class="mb-3 font-bold text-neutral-800 text-md">Pending</p>
            <ul class="min-h-96" id="pending">
                @foreach($project->tasks->where('status', 'Pending') as $task)
                <li data-id={{$task->id}} class="flex flex-col w-full p-4 mx-auto my-auto mt-5 text-white h-52 gap rounded-xl bg-gradient-to-r from-red-500 via-red-600 to-red-700">
                    <div class="flex items-center justify-between w-full">
                            <span class="font-bold text-gray-200 text-md">Priority: {{$task->priority}}</span>
                            <div class="flex gap-3">
                                <a href="" class="transition-all text-neutral-300 hover:text-yellow-300 editTask" data-id={{$task->id}}>
                                    <i class="bi bi-pen-fill"></i>
                                </a>
                                <a href="" data-id={{$task->id}} class="transition-all text-neutral-300 hover:text-red-400 deleteTask">
                                        <i class="bi bi-trash-fill"></i>
                                </a>
                            </div>
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
                                        <img src="{{$member->profile_img ? asset('storage/' . $member->profile_img) : asset('/storage/images/avatarlogo.jpg')}}" class="absolute float-left w-8 border-2 rounded-full" style="left: {{ $index *15 }}px;">
                        @endforeach
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="w-full md:w-1/3">
            <p class="mb-3 font-bold text-neutral-800 text-md">In Progress</p>
            @foreach($project->tasks->where('status', 'In Progress') as $task)
            <ul class="min-h-96" id="inprogress">
                <li data-id={{$task->id}} class="flex flex-col w-full p-4 mx-auto my-auto mt-5 text-white h-52 gap rounded-xl bg-gradient-to-r from-yellow-500 via-yellow-600 to-yellow-700">
                    <div class="flex items-center justify-between w-full">
                        <span class="font-bold text-gray-200 text-md">Priority: {{$task->priority}}</span>
                        <div class="flex gap-3">
                            <a href="" class="transition-all text-neutral-300 hover:text-yellow-300 editTask" data-id={{$task->id}}>
                                <i class="bi bi-pen-fill"></i>
                            </a>
                            <a href="" data-id={{$task->id}} class="transition-all text-neutral-300 hover:text-red-400 deleteTask">
                                    <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
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
                                        <img src="{{$member->profile_img ? asset('storage/' . $member->profile_img) : asset('/storage/images/avatarlogo.jpg')}}" class="absolute float-left w-8 border-2 rounded-full" style="left: {{ $index *15 }}px;">
                        @endforeach
                    </div>
                </li>
                @endforeach
            </ul>

        </div>
        <div class="w-full md:w-1/3">
            <p class="mb-3 font-bold text-neutral-800 text-md">Complete</p>
            <ul class="min-h-96" id="complete">
            @foreach($project->tasks->where('status', 'Complete') as $task)
            <li data-id={{$task->id}} class="flex flex-col w-full p-4 mx-auto my-auto mt-5 text-white h-52 gap rounded-xl bg-gradient-to-r from-green-500 via-green-600 to-green-700">
                <div class="flex items-center justify-between w-full">
                    <span class="font-bold text-gray-200 text-md">Priority: {{$task->priority}}</span>
                    <div class="flex gap-3">
                        <a href="" class="transition-all text-neutral-300 hover:text-yellow-300 editTask" data-id={{$task->id}}>
                            <i class="bi bi-pen-fill"></i>
                        </a>
                        <a href="" data-id={{$task->id}} class="transition-all text-neutral-300 hover:text-red-400 deleteTask">
                                <i class="bi bi-trash-fill"></i>
                        </a>
                    </div>
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
                                    <img src="{{$member->profile_img ? asset('storage/' . $member->profile_img) : asset('/storage/images/avatarlogo.jpg')}}" class="absolute float-left w-8 border-2 rounded-full" style="left: {{ $index *15 }}px;">
                    @endforeach
                </div>
            </li>
            @endforeach
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
     document.addEventListener("DOMContentLoaded", function() {
        const pendinggp = document.getElementById('pending');
        const inprogressgp = document.getElementById('inprogress');
        const completegp = document.getElementById('complete');
        new Sortable(pendinggp, {
            group: 'shared', // set both lists to same group
            animation: 150,
            ghostClass: "sortable-ghost",
            onAdd: function(evt) {
                    updateTaskOrder(evt.item, "Pending");
            }
        });

        new Sortable(inprogressgp, {
            group: 'shared',
            animation: 150,
            ghostClass: "sortable-ghost",
            onAdd: function(evt) {
                    updateTaskOrder(evt.item, "In Progress");
            }
        });

        new Sortable(completegp, {
            group: 'shared',
            animation: 150,
            ghostClass: "sortable-ghost",
            onAdd: function(evt) {
                    updateTaskOrder(evt.item, "Complete");
            }
        });

        // Function to update task order in the backend
        function updateTaskOrder(taskElement, status) {      
            const taskId = taskElement.dataset.id;
            const formData = {
                status: status
            };
            fetch('/task/' + taskId + '/status', {
                method: "PATCH",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to change status');
                }
                return response.json(); // Parse response JSON
            })
            .then(data => {
                toastr.success(data.message); // Display success message from response
                setTimeout(function(){
                    window.location.reload();
                }, 1000);
            })
            .catch(error => {
                toastr.error('Error changing status:', error.message);
            });
        }
    }); 
</script>