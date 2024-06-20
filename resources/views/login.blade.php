@include('Layout.header')

{{-- @section('main-container') --}}
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-4xl flex bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Left Section -->
        <div class="w-1/2 text-white flex flex-col justify-center items-center p-8" style="background-color: #ea33c0;">
            <img src="/assets/sidebar/logo.png" alt="Time & Space Image" class="w-96 h-auto mx-auto">
            <h1 class="text-3xl font-bold mb-2">Time & Space</h1>
        </div>
        <!-- Right Section -->
        <div class="w-1/2 p-8">
            <h2 class="text-2xl font-bold">Login</h2>
            @if (isset($_GET['success']))
                <div class="mb-2" style="color: green; font-size:20px">
                    {{ $_GET['success'] }}
                </div>
            @endif
            @if (isset($_GET['error']))
                <div class="mb-2" style="color: rgb(128, 0, 0); font-size:20px">
                    {{ $_GET['error'] }}
                </div>
            @endif
            <form method="post" action="{{ route('authenticate') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Username
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="username" type="text" name="email" placeholder="Username">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="password" type="password" name="password" placeholder="********">
                </div>

                <div class="flex items-center justify-between mb-2">
                    <button type="submit"
                        class=" hover:bg-purple-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        style="background-color: #ea33c0;">
                        Sign In
                    </button>
                </div>

            </form>
            <a class="text-sm" href="{{ route('register') }}">Do not have an Id? Create yours now.</a>
        </div>
    </div>
</div>


{{-- @endsection --}}
@include('Layout.footer')
