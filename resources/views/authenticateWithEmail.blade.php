<!DOCTYPE html>
<html lang="en" data-astro-cid-sckkx6r4>

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Astro description" />
    <meta name="viewport" content="width=device-width" />
    <link rel="icon" type="image/svg+xml" href="/assets/favicon-vp_fBu0c.svg" />
    <meta name="generator" content="Astro v4.4.15" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/tabulator-tables@5.6.1/dist/css/tabulator.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@5.6.1/dist/js/tabulator.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <title>Campagin Dashboard</title>
    <style>
        #draft[data-astro-cid-lhxslpwo] {
            border-color: #000;
            border-width: 1px;
            border-radius: 20px;
            background-color: #0000001f;
        }

        .card-drop[data-astro-cid-lhxslpwo] {
            background: #00000080;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
    <style>
        .component[data-astro-cid-iujjydvd] {
            display: none;
        }

        #component1[data-astro-cid-iujjydvd] {
            display: block;
        }

        #progress-1[data-astro-cid-ih4xnkm6]::-webkit-progress-bar {
            background-color: transparent;
        }

        #progress-1[data-astro-cid-ih4xnkm6]::-webkit-progress-value {
            background-color: gold;
        }

        #progress-2[data-astro-cid-ih4xnkm6]::-webkit-progress-bar {
            background-color: transparent;
        }

        #progress-2[data-astro-cid-ih4xnkm6]::-webkit-progress-value {
            background-color: #ffab48;
        }

        #progress-3[data-astro-cid-ih4xnkm6]::-webkit-progress-bar {
            background-color: transparent;
        }

        #progress-3[data-astro-cid-ih4xnkm6]::-webkit-progress-value {
            background-color: #eb6e6e;
        }

        #progress-4[data-astro-cid-ih4xnkm6]::-webkit-progress-bar {
            background-color: transparent;
        }

        #progress-4[data-astro-cid-ih4xnkm6]::-webkit-progress-value {
            background-color: #d4e507;
        }

        #progress-5[data-astro-cid-ih4xnkm6]::-webkit-progress-bar {
            background-color: transparent;
        }

        #progress-5[data-astro-cid-ih4xnkm6]::-webkit-progress-value {
            background-color: #84a0ff;
        }

        #progress-6[data-astro-cid-ih4xnkm6]::-webkit-progress-bar {
            background-color: transparent;
        }

        #progress-6[data-astro-cid-ih4xnkm6]::-webkit-progress-value {
            background-color: #4ed5e6;
        }

        .component[data-astro-cid-5kgwmqn7] {
            display: none;
        }

        .calendar-table-row {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #calendar-view::-webkit-scrollbar {
            display: none;
        }

        .component[data-astro-cid-d5voxaj5] {
            display: none;
        }

        .btn[data-astro-cid-ujfssy6h]:is(input[type="checkbox"]:checked),
        .btn[data-astro-cid-ujfssy6h]:is(input[type="radio"]:checked) {
            background-color: #ea33c0 !important;
        }

        label {
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }

        #previewImage {
            max-width: 200px;
            max-height: 200px;
        }
    </style>
    <script type="module"></script>
    <script type="module" crossorigin src="/assets/index-QCt-Udj2.js"></script>
    <link rel="stylesheet" crossorigin href="/assets/index-C0_QXAEa.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
</head>

<body class="bg-[#f4f4f4]" data-astro-cid-sckkx6r4>
    <nav class="fixed top-0 left-0 right-0 h-[45px] bg-[#EA33C0] shadow-xl z-10">
        <div class="flex justify-center md:justify-end h-full items-center px-2">
            <h2 class="text-[#FFFFFF] text-[25px] font-bold" style="margin-left: 20px">MediaBridge</h2>
        </div>
    </nav>

    {{-- @section('main-container') --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-4xl flex bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Left Section -->
            <div class="w-1/2 text-white flex flex-col justify-center items-center p-8"
                style="background-color: #ea33c0;">
                <img src="/assets/sidebar/logo.png" alt="Time & Space Image" class="w-96 h-auto mx-auto">
                <h1 class="text-3xl font-bold mb-2">Time & Space</h1>
            </div>
            <!-- Right Section -->
            <div class="w-1/2 p-8">
                <h2 class="text-2xl font-bold">Change Password</h2>
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

                <form id="passwordForm" onsubmit="return validateForm()" method="POST"
                    action="{{ route('ChangePasswordEmail') }}">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Password
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" type="password" name="password" placeholder="********">
                        <span id="passwordError" class="error" style="color: red;"></span>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="cpassword">
                            Confirm Password
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="cpassword" type="password" name="cpassword" placeholder="********">
                        <span id="cpasswordError" class="error" style="color: red;"></span>
                    </div>

                    <div class="flex items-center justify-between mb-2">
                        <button type="submit"
                            class="hover:bg-purple-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            style="background-color: #ea33c0;">
                            Sign In
                        </button>
                    </div>
                </form>

                <a class="text-sm" href="{{ route('register') }}">Do not have an Id? Create yours now.</a>
            </div>
        </div>
    </div>

    @include('Layout.footer')
    <script>
        function validateForm() {
            // Get the values of the password and confirm password fields
            var password = document.getElementById("password").value;
            var cpassword = document.getElementById("cpassword").value;

            // Initialize error messages
            var passwordError = "";
            var cpasswordError = "";

            // Check if the password is at least 8 characters long
            if (password.length < 8) {
                passwordError = "Password must be at least 8 characters long.";
            }

            // Check if the password and confirm password match
            if (password !== cpassword) {
                cpasswordError = "Passwords do not match.";
            }

            // Display error messages
            document.getElementById("passwordError").innerText = passwordError;
            document.getElementById("cpasswordError").innerText = cpasswordError;

            // Prevent form submission if there are errors
            if (passwordError || cpasswordError) {
                return false;
            }

            return true;
        }
    </script>
