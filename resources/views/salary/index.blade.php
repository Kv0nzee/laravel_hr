<x-layout>
    <x-slot name="title">
        Salarys
    </x-slot>
    <x-slot name="style">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>
    <div class="w-full mt-5">
        <form action="/salary/create" method="GET">
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
                    <tr class="bg-gray-800 text-neutral-50">
                        <th class="hidden no-sort no-search"></th>
                        <th>Employee Name</th>
                        <th>Month</th>
                        <th>Amount</th>
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
            layout: {
                dom: {
                    button: {
                        tag: 'button',
                        className: 'btn'
                    },
                    top: {
                        className: 'top-buttons'
                    }
                },
                topStart: {
                    buttons: [
                                {
                                    extend: 'pdfHtml5',
                                    text: '<span class="font-bold text-md"><i class="mr-2 bi bi-filetype-pdf"></i>PDF</span>',
                                    orientation: 'potrait',
                                    pageSize: 'A4',
                                    title:"Salaries",
                                    exportOptions:{
                                        columns:[1,2,3]
                                    },
                                    customize: function (doc) {
                                                    //Remove the title created by datatTables
                                                    doc.content.splice(0,1);
                                                    var now = new Date();
                                                    var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
                                                    doc.pageMargins = [20,60,20,30];
                                                    doc.defaultStyle.fontSize = 8;
                                                    doc.styles.tableHeader.fontSize = 8;
                                                    doc.styles.tableHeader.fillColor = '#343a40'; // Set background color for table header
                                                    doc.styles.tableHeader.color = '#fff'; // Set text color for table header
                                                    doc.content[0].table.widths = '*';
                                                    doc['header']=(function() {
                                                        return {
                                                            columns: [
                            
                                                                {
                                                                    alignment: 'left',
                                                                    italics: true,
                                                                    text: 'Salary Table ' + now,
                                                                    fontSize: 18,
                                                                    margin: [10,0],
                                                                    bold: true
                                                                },
                                                                {
                                                                    alignment: 'right',
                                                                    fontSize: 14,
                                                                    text: 'BRNYR HR',
                                                                    bold: 900,
                                                                }
                                                            ],
                                                            margin: 20
                                                        }
                                                    });
                            
                                                    doc['footer']=(function(page, pages) {
                                                        return {
                                                            columns: [
                                                                {
                                                                    alignment: 'left',
                                                                    text: ['Created on: ', { text: jsDate.toString() }]
                                                                },
                                                                {
                                                                    alignment: 'right',
                                                                    text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                                                                }
                                                            ],
                                                            margin: 20
                                                        }
                                                    });
                            
                                                    var objLayout = {};
                                                    objLayout['hLineWidth'] = function(i) { return .5; };
                                                    objLayout['vLineWidth'] = function(i) { return .5; };
                                                    objLayout['hLineColor'] = function(i) { return '#aaa'; };
                                                    objLayout['vLineColor'] = function(i) { return '#aaa'; };
                                                    objLayout['paddingLeft'] = function(i) { return 4; };
                                                    objLayout['paddingRight'] = function(i) { return 4; };
                                                    doc.content[0].layout = objLayout;
                                                    }
                                },
                                {
                                    extend: 'pageLength'
                                },
                                {
                                    text: "<i class='bi bi-arrow-repeat'></i> Refresh",
                                    action: function(e, dt, node, config){
                                        dt.ajax.reload(null, false);
                                    }
                                }
                            ]
                        }
            },
            lengthMenu: [[10,25,50,100,500], ['10 rows', '25 rows', '50 rows', '100 rows', '500 rows']],
            processing: true,
            serverSide: true,
            ajax: '{{ route("salary.index") }}', 
            responsive: true,
            columns: [
                { data: 'plus-icon', name: 'plus-icon' }, 
                { data: 'employee_name', name: 'employee_name' }, 
                { data: 'month', name: 'month' }, 
                { data: 'amount', name: 'amount' }, 
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: true } // Action column
            ],
            columnDefs: [
                {
                    "targets": "hidden",
                    "visible": false
                },
                {
                    "targets": [0],
                    "className": "control",
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

            // Get the salary ID from the data-id attribute of the delete button
            var id = $(this).data('id');
            // Show confirmation dialog
            toastr.warning('Are you sure you want to delete this Salary? Click to confirm, else it will cancel', 'Confirmation', {
                closeButton: true,
                positionClass: 'toast-top-right',
                onclick: function (toast) {
                    deleteSalary(id);
                    toastr.remove(toast.toastId);
                },
                onclose: function () {
                    toastr.clear();
                }
            });
        });

        function deleteSalary(id) {
            $.ajax({
                url: '/salary/' + id + '/delete/',
                data: {"id": id , _method: 'delete'},
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success('Salary deleted successfully');
                    table.ajax.reload(); 
                },
                error: function(xhr, status, error) {
                    toastr.error('Failed to delete salary');
                }
            });
        }
    });
</script>

