<x-layout>
    <x-slot name="title">
        Qr Scanner
    </x-slot>
    <x-slot name="style">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>

    <main class="w-full h-100vh">
        <h2 class="text-xl text-gray-600 md:text-3xl lg:text-5xl text-nowrap">Scan The Attendance QR</h2>
        <section class="relative flex items-center justify-center w-full h-full py-16">
            <button id="scanQrButton" class="flex items-center w-1/2 px-4 py-2 text-sm text-left transition-all bg-gray-600 rounded-lg text-neutral-100 hover:bg-gray-900">
                <h2 class="text-xl md:text-3xl lg:text-5xl text-nowrap">Scan Qr Code</h2>
                <svg viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M384 64H134.144c-51.2 0-89.6 41.472-89.6 89.6v227.328c0 51.2 41.472 89.6 89.6 89.6H384c51.2 0 89.6-41.472 89.6-89.6V153.6c0-48.128-38.4-89.6-89.6-89.6z m45.056 316.928c0 25.6-19.456 44.544-45.056 44.544H134.144c-25.6 0-45.056-19.456-45.056-44.544V153.6c0-25.6 19.456-45.056 45.056-45.056H384c25.6 0 45.056 18.944 45.056 45.056v227.328z" fill="#5FFFBA"></path><path d="M192 192h134.656v134.656H192V192z" fill="#FFA28D"></path><path d="M377.856 544.256H134.656c-48.128 0-86.528 38.4-86.528 89.6v220.672c0 48.128 38.4 89.6 86.528 89.6h243.2c48.128 0 86.528-38.4 86.528-89.6v-220.672c3.072-51.2-38.912-89.6-86.528-89.6z m44.544 307.2c0 25.6-19.456 45.056-45.056 45.056H134.656c-25.6 0-45.056-19.456-45.056-45.056v-220.672c0-25.6 18.944-45.056 45.056-45.056h243.2c25.6 0 45.056 19.456 45.056 45.056v220.672z" fill="#5FFFBA"></path><path d="M192 668.672h131.072v131.072H192v-131.072z" fill="#FFD561"></path><path d="M633.344 470.528h249.344c51.2 0 89.6-41.472 89.6-89.6V153.6c0-51.2-41.472-89.6-89.6-89.6h-249.344c-51.2 0-89.6 41.472-89.6 89.6v227.328c0.512 51.2 41.984 89.6 89.6 89.6zM588.8 153.6c0-25.6 19.456-45.056 44.544-45.056h249.344c25.6 0 45.056 19.456 45.056 45.056v227.328c0 25.6-19.456 44.544-45.056 44.544h-249.344c-25.6 0-44.544-19.456-44.544-44.544V153.6z" fill="#5FFFBA"></path><path d="M700.928 192h134.144v134.656h-134.656l0.512-134.656z" fill="#FFD561"></path><path d="M572.928 716.8h137.728c12.8 0 22.528-9.728 22.528-22.528v-137.728c0-12.8-9.728-22.528-22.528-22.528h-137.728c-12.8 0-22.528 9.728-22.528 22.528v137.728c0 12.8 9.728 22.528 22.528 22.528zM886.272 563.2v38.4c0 12.8 12.8 25.6 25.6 25.6h38.4c12.8 0 25.6-12.8 25.6-25.6V563.2c0-12.8-12.8-25.6-25.6-25.6h-38.4c-12.8 0-25.6 9.728-25.6 25.6zM582.656 944.128h48.128c12.8 0 22.528-9.728 22.528-22.528v-48.128c0-12.8-9.728-22.528-22.528-22.528h-48.128c-12.8 0-22.528 9.728-22.528 22.528v48.128c0 12.8 9.216 22.528 22.528 22.528zM944.128 704H844.8c-15.872 0-28.672 12.8-28.672 28.672v45.056H768c-19.456 0-32.256 12.8-32.256 32.256v99.328c0 15.872 12.8 28.672 28.672 28.672l179.2 3.072c15.872 0 28.672-12.8 28.672-28.672v-179.2c0.512-16.384-12.288-29.184-28.16-29.184z" fill="#5FFFBA"></path></g></svg>
            </button>
            <div id="myModal" class="fixed inset-0 z-50 flex items-center justify-center hidden overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-neutral-800/70">
                <button class="absolute text-gray-400 transition top-4 right-4 hover:text-white" id="closeModal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="relative w-full mx-auto my-6 md:w-4/6 xl:w-3/5 h-3/5 lg:h-auto md:h-auto">
                    <video class="w-full " id="video"></video>
                </div>
            </div>
        </section>
    </main>
</x-layout>
<!-- qr-scanner-->
<script type="module">
    // do something with QrScanner
</script>
<script src="storage/qr-scanner.umd.min.js"></script>
<script>
    $(document).ready(function(){
        var videoElem = document.getElementById('video');
        const qrScanner = new QrScanner(videoElem, function(result){
            console.log(result);
            if(result){
                qrScanner.stop();
            }
        });
        $('#scanQrButton').click(function(){
            $('#myModal').show(); // Show the modal with ID 'myModal'
            qrScanner.start();
        });
        
        $('#closeModal').click(function(){
            // Close the modal
            $('#myModal').hide();
            qrScanner.stop();
        });
    });
</script>
