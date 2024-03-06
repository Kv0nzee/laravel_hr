<x-layout>
    <x-slot name="title">
        Employees
    </x-slot>
    <div class="container mt-5">
        <form action="employee/create" method="GET">
            @csrf
            <button type="submit" class="flex items-center px-4 py-2 mb-5 text-sm text-left transition-all bg-gray-600 rounded-lg text-neutral-100 hover:bg-gray-900 ">
                <p>Create</p>  
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                  </svg>
            </button>
          </form> 
        <table id="myTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department Name</th>
                    <th>Is Present</th>
                    <th>Action</th> <!-- Add an action column -->
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</x-layout>

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("employee.index") }}', 
            columns: [
                { data: 'id', name: 'id' }, 
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'department_name', name: 'department_name' },
                { data: 'is_present', name: 'is_present' },
                { data: 'action', name: 'action', orderable: false, searchable: false } // Action column
            ]
        });
    });
</script>
