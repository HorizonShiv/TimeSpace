@include('Layout.header')

{{-- @section('main-container') --}}
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="antialiased">
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-4xl flex bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Left Section -->
            <div class="w-1/2  text-white flex flex-col justify-center items-center p-8"
                style="background-color: #ea33c0;">
                <img src="/assets/sidebar/logo.png" alt="Time & Space Image" class="w-96 h-auto mx-auto">
                <h1 class="text-3xl font-bold mb-2">Time & Space</h1>
            </div>
            <!-- Right Section -->
            <div class="w-1/2 p-8">

                <h2 class="text-2xl font-bold mb-6">Register</h2>
                <form method="post" action="{{ route('store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Name
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="name" name="name" value="{{ old('name') }}" type="text" placeholder="Name">

                        <p style="color: red"> @error('name')
                                {{ $message }}
                            @enderror
                        </p>

                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            Email
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="email" name="email" value="{{ old('email') }}" type="email"
                            placeholder="Email">
                        <p style="color: red"> @error('email')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="role">
                            Role
                        </label>
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            name="role" id="role" placeholder="Email">
                            <option value="Media">Media Agency</option>
                            <option value="Creative">Creative Agency</option>
                            <option selected value="Client">Client</option>

                        </select>

                        <p style="color: red"> @error('role')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Password
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="password" type="password" placeholder="********">

                        <p style="color: red"> @error('password')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                            Confirm Password
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password_confirmation" name="password_confirmation" type="password"
                            placeholder="********">

                        <p style="color: red"> @error('password_confirmation')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <button
                            class="hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            style="background-color: #ea33c0" type="submit">
                            Register
                        </button>
                    </div>
                </form>
                <a class="text-sm" href="{{ route('login') }}">Do have an Id? Log In now.</a>
            </div>
        </div>
    </div>
</div>


{{-- @endsection --}}
@include('Layout.footer')
