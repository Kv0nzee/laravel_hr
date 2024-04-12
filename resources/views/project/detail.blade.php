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
        <div class="flex w-full">
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
    </div>
</x-layout>

<script type="text/javascript">
   $(function() {
        // Display existing images
        <?php if (!is_null($project->images)): ?>
            <?php foreach ($project->images as $image): ?>
                var imgSrc = '<?php echo "/storage/" . $image; ?>';
                $('#imagePreviews').append($('<a>').attr('href', imgSrc).attr('target', '_blank').append($('<img>').attr('src', imgSrc).addClass('object-cover w-12 h-12 rounded-xl')));
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
    });

</script>