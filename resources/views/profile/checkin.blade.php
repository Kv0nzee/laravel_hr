<x-layout>
    <x-slot name="title">
        Checkin
    </x-slot>
    <x-slot name="style">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>
  
    <main class="flex flex-col items-startr w-full gap-6 -px-5 mx-auto *:lg:px-16 md:px-10" x-data="app({{ $user->pin_code }})">
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Checkin</h1>
        <h1 class="mb-5 text-xs font-bold text-gray-800 md:text-md lg:text-xl">Please Scan the QR Code or Enter Your PIN</h1>
        <div class="flex items-start justify-between">
            <div class="">
                <h1 class="mb-5 text-xs font-bold text-gray-600 md:text-md lg:text-xl">Scan QR Code</h1>
                {!! QrCode::size(200)->generate('https://google.com') !!}
            </div>
            <div class="">
                <h1 class="mb-5 text-xs font-bold text-gray-600 md:text-md lg:text-xl">Enter your pin number</h1>
                <div class="flex items-center justify-center">
                    <template x-for="(l,i) in pinlength" :key="`codefield_${i}`">
                        <input :autofocus="i == 0" :id="`codefield_${i}`" class="flex items-center w-12 h-16 mx-2 text-3xl font-thin text-center border border-gray-600 rounded-lg" value="" maxlength="1" max="9" min="0" inputmode="decimal" @keyup="stepForward(i)" @keydown.backspace="stepBack(i)" @focus="resetValue(i)"></input>
                    </template>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<script>
    function app(pinCode) {
        return {
            pinlength: 6,
            resetValue(i) {
                for (x = 0; x < this.pinlength; x++) {
                    if (x >= i) document.getElementById(`codefield_${x}`).value = ''
                }
            },
            stepForward(i) {
                if (document.getElementById(`codefield_${i}`).value && i != this.pinlength - 1) {
                    document.getElementById(`codefield_${i+1}`).focus()
                    document.getElementById(`codefield_${i+1}`).value = ''
                }
                this.checkPin()
            },
            stepBack(i) {
                if (document.getElementById(`codefield_${i-1}`).value && i != 0) {
                    document.getElementById(`codefield_${i-1}`).focus()
                    document.getElementById(`codefield_${i-1}`).value = ''
                }
            },
            checkPin() {
                let code = ''
                for (i = 0; i < this.pinlength; i++) {
                    code = code + document.getElementById(`codefield_${i}`).value
                }
                if (code.length == this.pinlength) {
                    this.validatePin(code, pinCode)
                }
            },
            validatePin(code, pinCode) {
                // Check pin on server
                if (code == pinCode) {
                    alert('success');
                } else {
                    alert('Incorrect pin');
                }
            }
        }
    }
</script>
