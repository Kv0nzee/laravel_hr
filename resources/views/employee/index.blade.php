<x-layout>
    <x-slot name="title">
        Employees
    </x-slot>
    <div class="w-full mt-5">
        <form action="employee/create" method="GET">
            @csrf
            <button type="submit" class="flex items-center px-4 py-2 text-sm text-left transition-all bg-gray-600 rounded-lg text-neutral-100 hover:bg-gray-900 ">
                <p>Create</p>  
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
            </button>
        </form> 
        <div class="w-full overflow-hidden table-responsive">
            <table id="myTable"  class="table w-full display table-bordered">
                <thead>
                    <tr>
                        <th class="hidden no-sort no-search"></th>
                        <th>Employee Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Department Name</th>
                        <th>Is Present</th>
                        <th class="hidden no-sort no-search" hidden>Updated At</th>
                        <th class="no-sort no-search">Action</th> 
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</x-layout>

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("employee.index") }}', 
            responsive: true,
            columns: [
                { data: 'plus-icon', name: 'plus-icon' }, 
                { data: 'employee_id', name: 'employee_id' }, 
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'department_name', name: 'department_name' },
                { data: 'is_present', name: 'is_present' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: true } // Action column
            ],
            order: [[7, "desc"]],
            columnDefs:[
                {
                    "targets": "hidden",
                    "visible": false
                },
                {
                    "targets": [0],
                    "class": "control",
                },
                {
                    "targets": 'no-sort',
                    "orderable": false
                },
                {
                    "targets": 'no-search',
                    "searchable": false
                }
            ]
        });

        $('#myTable').on('click', '.delete', function(e) {
            e.preventDefault(); // Prevent default link behavior

            // Get the post ID from the data-id attribute of the delete button
            var id = $(this).data('id');

            // Show toastr confirmation dialog
            toastr.warning('Are you sure you want to delete this employee? Click to confirm, else it will cancel', 'Confirmation', {
                closeButton: true,
                positionClass: 'toast-top-right',
                onclick: function (toast) {
                    deletePost(id);
                    toastr.remove(toast.toastId);
                },
                onclose: function () {
                    toastr.clear();
                }
            });
        });

        function deletePost(id) {
            $.ajax({
                url: '/employee/' + id + '/delete', // Adjust the URL as per your route
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success(response.message, 'Success');
                },
                error: function(xhr, status, error) {
                    toastr.success(response.message, 'Success');
                    // toastr.error(xhr.responseJSON.message, 'Error');
                }
            });
        }
    });
</script>