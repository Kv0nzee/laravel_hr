@props(['users', 'project'])

<div id="createTaskModal" class="fixed inset-0 z-50 hidden overflow-y-auto transition-all duration-300 opacity-0">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div id="bgoverlay" class="fixed inset-0 transition-opacity" aria-hidden="true">
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