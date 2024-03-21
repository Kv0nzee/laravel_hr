<x-layout>
    <x-slot name="title">
        Check-in
    </x-slot>
    <x-slot name="style">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>
  
    <main class="flex flex-col items-start w-full gap-6 px-5 mx-auto lg:px-16 md:px-10" x-data="app()">
        <h1 class="text-2xl font-bold text-neutral-800 lg:text-3xl">
            @if ($user->checkin_checkout()->whereDate('date', now()->format('Y-m-d'))->exists())
                Check Out
            @else
                Check In
            @endif
        </h1>        
        <h2 class="mb-5 text-sm font-bold text-gray-800 md:text-lg lg:text-xl">Please Scan the QR Code or Enter Your PIN</h2>
        <div class="flex items-start justify-between w-full">
            <div>
                <h2 class="mb-5 text-sm font-bold text-gray-600 md:text-lg lg:text-xl">Scan QR Code</h2>
                {!! QrCode::size(200)->generate($hash_value) !!}
            </div>
            <div class="flex flex-col justify-between h-full">
                <h2 class="mb-5 text-sm font-bold text-gray-600 md:text-lg lg:text-xl">Enter your PIN number</h2>
                <div class="flex items-center justify-center">
                    <template x-for="(l,i) in pinlength" :key="`codefield_${i}`">
                        <input type="password" :autofocus="i == 0" :id="`codefield_${i}`" class="flex items-center w-12 h-16 mx-2 text-3xl font-thin text-center border border-gray-600 rounded-lg" value="" maxlength="1" max="9" min="0" inputmode="decimal" @keyup="stepForward(i)" @keydown.backspace="stepBack(i)" @focus="resetValue(i)"></input>
                    </template>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<script>
   function app() {
    return {
        pinlength: 6,
        resetAllValues() {
            for (let x = 0; x < this.pinlength; x++) {
                document.getElementById(`codefield_${x}`).value = '';
            }
            document.getElementById(`codefield_${0}`).focus();
        },
        resetValue(i) {
            for (let x = 0; x < this.pinlength; x++) {
                if (x >= i) document.getElementById(`codefield_${x}`).value = '';
            }
        },
        stepForward(i) {
            if (document.getElementById(`codefield_${i}`).value && i != this.pinlength - 1) {
                document.getElementById(`codefield_${i+1}`).focus();
                document.getElementById(`codefield_${i+1}`).value = '';
            }
            this.checkPin();
        },
        stepBack(i) {
            if (document.getElementById(`codefield_${i-1}`).value && i != 0) {
                document.getElementById(`codefield_${i-1}`).focus();
                document.getElementById(`codefield_${i-1}`).value = '';
            }
        },
        checkPin() {
            let code = '';
            for (let i = 0; i < this.pinlength; i++) {
                code += document.getElementById(`codefield_${i}`).value;
            }
            if (code.length == this.pinlength) {
                this.validatePin(code);
            }
        },
        validatePin(code) {
            let self = this; // Store a reference to 'this'
            $.ajax({
                url: '/checkincheckout',
                data: {"code": code}, // Send both code and pinCode to the server
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success(response.message);
                    self.resetAllValues();
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText).message;
                    toastr.error(errorMessage);
                    self.resetAllValues();
                }
            });
        }
    };
}
</script>
