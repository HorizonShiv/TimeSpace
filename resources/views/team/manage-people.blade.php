@extends('Layout.sidebar')

@section('main-container')
    <div class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full" id="content" data-astro-cid-sckkx6r4>

        @if (isset($_GET['success']))
            <div class="mt-5" style="color: green; font-size:30px">
                {{ $_GET['success'] }}
            </div>
        @endif
        @if (isset($_GET['error']))
            <div class="mt-5" style="color: rgb(128, 0, 0); font-size:30px">
                {{ $_GET['error'] }}
            </div>
        @endif

        <div class="flex justify-between" data-astro-cid-rwhxyfax>
            <h1 class="text-4xl font-semibold">Manage People</h1>
        </div>

        {{-- <div class="row">
            <div class="w-100 flex justify-between items-center">
                <div class="mt-10 w-48">
                    <label
                        class="input input-bordered input-primary flex items-center gap-2 rounded-full bg-white px-3 py-2 w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="#c72ba4"
                            class="w-4 h-4 opacity-70">
                            <path fill-rule="evenodd"
                                d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <input type="text" class="text-xs text-[#555555] min-w-48" placeholder="Search by team">
                    </label>
                </div>
                <div data-astro-cid-rwhxyfax>
                    <button role="button" type="button" class="btn rounded-full bg-accent text-white no-animation mt-10"
                        onclick="create_modal.showModal()" id="create_modal_button" data-astro-cid-rwhxyfax>
                        Invite Someone New
                        <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481" viewBox="0 0 15.481 15.481"
                            data-astro-cid-rwhxyfax>
                            <path id="add_FILL0_wght400_GRAD0_opsz24"
                                d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z"
                                transform="translate(-200 760)" fill="#f5f5f5" data-astro-cid-rwhxyfax></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="w-100 flex justify-between items-center">
                <div class="mt-10 w-48">
                    <label
                        class="input input-bordered input-primary flex items-center gap-2 rounded-full bg-white px-3 py-2 w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="#c72ba4"
                            class="w-4 h-4 opacity-70">
                            <path fill-rule="evenodd"
                                d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <input type="text" class="text-xs text-[#555555] min-w-48" placeholder="Search by team">
                    </label>
                </div>
                <div data-astro-cid-rwhxyfax>
                    <button role="button" type="button" class="btn rounded-full bg-accent text-white no-animation mt-10"
                        onclick="create_modal.showModal()" id="create_modal_button" data-astro-cid-rwhxyfax>
                        Invite Someone New
                        <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481" viewBox="0 0 15.481 15.481"
                            data-astro-cid-rwhxyfax>
                            <path id="add_FILL0_wght400_GRAD0_opsz24"
                                d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z"
                                transform="translate(-200 760)" fill="#f5f5f5" data-astro-cid-rwhxyfax></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- {{ dd($Teams->toArray()) }} --}}

        @foreach ($Teams as $Team)
            @if ($Team->team_type == 'Client')
                <div class="justify-between mt-10" data-astro-cid-rwhxyfax>
                    <h3>{{ $Team->team_type }}</h3>
                    <h4 class="text-4xl font-semibold">{{ $Team->name }}</h4>
                </div>


                <div class=" mt-5 max-w-lg mx-auto">
                    @foreach ($Team->TeamMember as $TeamMember)
                        <!-- First list item -->
                        <div class="flex items-center mb-6"> <!-- Adjust margin bottom for spacing -->
                            <!-- Logo in circular fashion -->
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-full bg-pink-500 text-white mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px">
                                    <path fill="#2980b9" d="M28 17H43V40H28z" />
                                    <path fill="#2980b9" d="M5 8H43V21H5z" />
                                    <path fill="#2980b9" d="M5 17H20V40H5z" />
                                </svg>
                            </div>
                            <!-- Agency name -->
                            <div class="flex-grow">
                                <p class="text-lg font-semibold">{{ $TeamMember->User->name }}</p>
                            </div>
                            <!-- Three dots -->
                            <div class="relative">
                                <button class="focus:outline-none" id="optionsMenu5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 3a2 2 0 00-2 2 2 2 0 104 0 2 2 0 00-2-2zm0 6a2 2 0 00-2 2 2 2 0 104 0 2 2 0 00-2-2zm0 6a2 2 0 00-2 2 2 2 0 104 0 2 2 0 00-2-2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <!-- Popup menu -->
                                <div class="absolute right-0 mt-2 w-64 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden"
                                    id="optionsMenuItems5">
                                    <div class="py-1" role="menu" aria-orientation="vertical"
                                        aria-labelledby="optionsMenu5">
                                        <div class="flex px-6 py-2 gap-3">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                                <g id="SVG  Repo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <g id="SVGRepo_iconCarrier">
                                                    <rect width="24" height="24" fill="white" />
                                                    <path
                                                        d="M13.5 2L13.9961 1.93798C13.9649 1.68777 13.7522 1.5 13.5 1.5V2ZM10.5 2V1.5C10.2478 1.5 10.0351 1.68777 10.0039 1.93798L10.5 2ZM13.7747 4.19754L13.2786 4.25955C13.3047 4.46849 13.4589 4.63867 13.6642 4.68519L13.7747 4.19754ZM16.2617 5.22838L15.995 5.6513C16.1731 5.76362 16.4024 5.75233 16.5687 5.62306L16.2617 5.22838ZM18.0104 3.86826L18.364 3.51471C18.1857 3.3364 17.9025 3.31877 17.7034 3.47359L18.0104 3.86826ZM20.1317 5.98958L20.5264 6.29655C20.6812 6.09751 20.6636 5.81434 20.4853 5.63603L20.1317 5.98958ZM18.7716 7.73831L18.3769 7.43134C18.2477 7.59754 18.2364 7.82693 18.3487 8.00503L18.7716 7.73831ZM19.8025 10.2253L19.3148 10.3358C19.3613 10.5411 19.5315 10.6953 19.7404 10.7214L19.8025 10.2253ZM22 10.5H22.5C22.5 10.2478 22.3122 10.0351 22.062 10.0039L22 10.5ZM22 13.5L22.062 13.9961C22.3122 13.9649 22.5 13.7522 22.5 13.5H22ZM19.8025 13.7747L19.7404 13.2786C19.5315 13.3047 19.3613 13.4589 19.3148 13.6642L19.8025 13.7747ZM18.7716 16.2617L18.3487 15.995C18.2364 16.1731 18.2477 16.4025 18.3769 16.5687L18.7716 16.2617ZM20.1317 18.0104L20.4853 18.364C20.6636 18.1857 20.6812 17.9025 20.5264 17.7034L20.1317 18.0104ZM18.0104 20.1317L17.7034 20.5264C17.9025 20.6812 18.1857 20.6636 18.364 20.4853L18.0104 20.1317ZM16.2617 18.7716L16.5687 18.3769C16.4024 18.2477 16.1731 18.2364 15.995 18.3487L16.2617 18.7716ZM13.7747 19.8025L13.6642 19.3148C13.4589 19.3613 13.3047 19.5315 13.2786 19.7404L13.7747 19.8025ZM13.5 22V22.5C13.7522 22.5 13.9649 22.3122 13.9961 22.062L13.5 22ZM10.5 22L10.0039 22.062C10.0351 22.3122 10.2478 22.5 10.5 22.5V22ZM10.2253 19.8025L10.7214 19.7404C10.6953 19.5315 10.5411 19.3613 10.3358 19.3148L10.2253 19.8025ZM7.73832 18.7716L8.00504 18.3487C7.82694 18.2364 7.59756 18.2477 7.43135 18.3769L7.73832 18.7716ZM5.98959 20.1317L5.63604 20.4853C5.81435 20.6636 6.09752 20.6812 6.29656 20.5264L5.98959 20.1317ZM3.86827 18.0104L3.4736 17.7034C3.31878 17.9025 3.33641 18.1857 3.51472 18.364L3.86827 18.0104ZM5.22839 16.2617L5.62307 16.5687C5.75234 16.4025 5.76363 16.1731 5.65131 15.995L5.22839 16.2617ZM4.19754 13.7747L4.68519 13.6642C4.63867 13.4589 4.46849 13.3047 4.25955 13.2786L4.19754 13.7747ZM2 13.5H1.5C1.5 13.7522 1.68777 13.9649 1.93798 13.9961L2 13.5ZM2 10.5L1.93798 10.0039C1.68777 10.0351 1.5 10.2478 1.5 10.5H2ZM4.19754 10.2253L4.25955 10.7214C4.46849 10.6953 4.63867 10.5411 4.68519 10.3358L4.19754 10.2253ZM5.22839 7.73831L5.65131 8.00503C5.76363 7.82693 5.75234 7.59755 5.62307 7.43134L5.22839 7.73831ZM3.86827 5.98959L3.51472 5.63603C3.33641 5.81434 3.31878 6.09751 3.47359 6.29656L3.86827 5.98959ZM5.98959 3.86827L6.29656 3.47359C6.09752 3.31878 5.81434 3.33641 5.63604 3.51471L5.98959 3.86827ZM7.73832 5.22839L7.43135 5.62306C7.59755 5.75233 7.82694 5.76363 8.00504 5.6513L7.73832 5.22839ZM10.2253 4.19754L10.3358 4.68519C10.5411 4.63867 10.6953 4.46849 10.7214 4.25955L10.2253 4.19754ZM13.5 1.5H10.5V2.5H13.5V1.5ZM14.2708 4.13552L13.9961 1.93798L13.0039 2.06202L13.2786 4.25955L14.2708 4.13552ZM16.5284 4.80547C15.7279 4.30059 14.8369 3.92545 13.8851 3.70989L13.6642 4.68519C14.503 4.87517 15.2886 5.20583 15.995 5.6513L16.5284 4.80547ZM16.5687 5.62306L18.3174 4.26294L17.7034 3.47359L15.9547 4.83371L16.5687 5.62306ZM17.6569 4.22182L19.7782 6.34314L20.4853 5.63603L18.364 3.51471L17.6569 4.22182ZM19.7371 5.68261L18.3769 7.43134L19.1663 8.04528L20.5264 6.29655L19.7371 5.68261ZM20.2901 10.1149C20.0746 9.16313 19.6994 8.27213 19.1945 7.47158L18.3487 8.00503C18.7942 8.71138 19.1248 9.49695 19.3148 10.3358L20.2901 10.1149ZM22.062 10.0039L19.8645 9.72917L19.7404 10.7214L21.938 10.9961L22.062 10.0039ZM22.5 13.5V10.5H21.5V13.5H22.5ZM19.8645 14.2708L22.062 13.9961L21.938 13.0039L19.7404 13.2786L19.8645 14.2708ZM19.1945 16.5284C19.6994 15.7279 20.0746 14.8369 20.2901 13.8851L19.3148 13.6642C19.1248 14.503 18.7942 15.2886 18.3487 15.995L19.1945 16.5284ZM20.5264 17.7034L19.1663 15.9547L18.3769 16.5687L19.7371 18.3174L20.5264 17.7034ZM18.364 20.4853L20.4853 18.364L19.7782 17.6569L17.6569 19.7782L18.364 20.4853ZM15.9547 19.1663L17.7034 20.5264L18.3174 19.7371L16.5687 18.3769L15.9547 19.1663ZM13.8851 20.2901C14.8369 20.0746 15.7279 19.6994 16.5284 19.1945L15.995 18.3487C15.2886 18.7942 14.503 19.1248 13.6642 19.3148L13.8851 20.2901ZM13.9961 22.062L14.2708 19.8645L13.2786 19.7404L13.0039 21.938L13.9961 22.062ZM10.5 22.5H13.5V21.5H10.5V22.5ZM9.72917 19.8645L10.0039 22.062L10.9961 21.938L10.7214 19.7404L9.72917 19.8645ZM7.4716 19.1945C8.27214 19.6994 9.16314 20.0746 10.1149 20.2901L10.3358 19.3148C9.49696 19.1248 8.71139 18.7942 8.00504 18.3487L7.4716 19.1945ZM6.29656 20.5264L8.04529 19.1663L7.43135 18.3769L5.68262 19.7371L6.29656 20.5264ZM3.51472 18.364L5.63604 20.4853L6.34315 19.7782L4.22183 17.6569L3.51472 18.364ZM4.83372 15.9547L3.4736 17.7034L4.26295 18.3174L5.62307 16.5687L4.83372 15.9547ZM3.70989 13.8851C3.92545 14.8369 4.30059 15.7279 4.80547 16.5284L5.65131 15.995C5.20584 15.2886 4.87517 14.503 4.68519 13.6642L3.70989 13.8851ZM1.93798 13.9961L4.13552 14.2708L4.25955 13.2786L2.06202 13.0039L1.93798 13.9961ZM1.5 10.5V13.5H2.5V10.5H1.5ZM4.13552 9.72917L1.93798 10.0039L2.06202 10.9961L4.25955 10.7214L4.13552 9.72917ZM4.80547 7.47159C4.30059 8.27213 3.92545 9.16313 3.70989 10.1149L4.68519 10.3358C4.87517 9.49696 5.20583 8.71138 5.65131 8.00503L4.80547 7.47159ZM3.47359 6.29656L4.83371 8.04528L5.62307 7.43134L4.26295 5.68262L3.47359 6.29656ZM5.63604 3.51471L3.51472 5.63603L4.22182 6.34314L6.34314 4.22182L5.63604 3.51471ZM8.04529 4.83371L6.29656 3.47359L5.68262 4.26294L7.43135 5.62306L8.04529 4.83371ZM10.1149 3.70989C9.16313 3.92545 8.27214 4.30059 7.4716 4.80547L8.00504 5.6513C8.71139 5.20583 9.49696 4.87517 10.3358 4.68519L10.1149 3.70989ZM10.0039 1.93798L9.72917 4.13552L10.7214 4.25955L10.9961 2.06202L10.0039 1.93798Z"
                                                        fill="#ea33c0" />
                                                    <circle cx="12" cy="12" r="4" stroke="#ea33c0"
                                                        stroke-linejoin="round" />
                                                </g>
                                            </svg>
                                            <a href="#"
                                                class="block text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                role="menuitem">Edit Info</a>
                                        </div>
                                        <hr class="border-b border-solid" style="border-color:#ea33c0" />
                                        <div class="flex px-6 py-2 gap-3">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M12.7917 15.7991L14.2223 14.3676C16.5926 11.9959 16.5926 8.15054 14.2223 5.7788C11.8521 3.40707 8.0091 3.40707 5.63885 5.7788L2.77769 8.64174C0.407436 11.0135 0.407436 14.8588 2.77769 17.2306C3.87688 18.3304 5.29279 18.9202 6.73165 19"
                                                        stroke="#ea33c0" stroke-width="1.5" stroke-linecap="round" />
                                                    <path
                                                        d="M11.2083 8.20092L9.77769 9.63239C7.40744 12.0041 7.40744 15.8495 9.77769 18.2212C12.1479 20.5929 15.9909 20.5929 18.3612 18.2212L21.2223 15.3583C23.5926 12.9865 23.5926 9.14118 21.2223 6.76945C20.1231 5.66957 18.7072 5.07976 17.2683 5"
                                                        stroke="#ea33c0" stroke-width="1.5" stroke-linecap="round" />
                                                </g>
                                            </svg>
                                            <a href="#"
                                                class="block text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                role="menuitem">Send a link to Login</a>
                                        </div>
                                        @if (Auth::user()->role == 'Admin')
                                            <hr class="border-b border-solid" style="border-color:#ea33c0" />
                                            <div class="flex px-6 py-2 gap-3">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path d="M19 5L5 19M5.00001 5L19 19" stroke="#ea33c0"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </g>
                                                </svg>
                                                <a href="#"
                                                    class="block text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                    role="menuitem">Delete User</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="divider" data-astro-cid-rwhxyfax></div>
                    @endforeach
                </div>
            @endif
        @endforeach

        @foreach ($Teams as $Team)
            @if ($Team->team_type == 'Creative')
                <div class="justify-between mt-10" data-astro-cid-rwhxyfax>
                    <h3>{{ $Team->team_type }}</h3>
                    <h4 class="text-4xl font-semibold">{{ $Team->name }}</h4>
                </div>


                <div class=" mt-5 max-w-lg mx-auto">
                    @foreach ($Team->TeamMember as $TeamMember)
                        <!-- First list item -->
                        <div class="flex items-center mb-6"> <!-- Adjust margin bottom for spacing -->
                            <!-- Logo in circular fashion -->
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-full bg-pink-500 text-white mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px"
                                    height="48px">
                                    <path fill="#2980b9" d="M28 17H43V40H28z" />
                                    <path fill="#2980b9" d="M5 8H43V21H5z" />
                                    <path fill="#2980b9" d="M5 17H20V40H5z" />
                                </svg>
                            </div>
                            <!-- Agency name -->
                            <div class="flex-grow">
                                <p class="text-lg font-semibold">{{ $TeamMember->User->name }}</p>
                            </div>
                            <!-- Three dots -->
                            <div class="relative">
                                <button class="focus:outline-none" id="optionsMenu5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 3a2 2 0 00-2 2 2 2 0 104 0 2 2 0 00-2-2zm0 6a2 2 0 00-2 2 2 2 0 104 0 2 2 0 00-2-2zm0 6a2 2 0 00-2 2 2 2 0 104 0 2 2 0 00-2-2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <!-- Popup menu -->
                                <div class="absolute right-0 mt-2 w-64 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden"
                                    id="optionsMenuItems5">
                                    <div class="py-1" role="menu" aria-orientation="vertical"
                                        aria-labelledby="optionsMenu5">
                                        <div class="flex px-6 py-2 gap-3">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                                <g id="SVG  Repo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <g id="SVGRepo_iconCarrier">
                                                    <rect width="24" height="24" fill="white" />
                                                    <path
                                                        d="M13.5 2L13.9961 1.93798C13.9649 1.68777 13.7522 1.5 13.5 1.5V2ZM10.5 2V1.5C10.2478 1.5 10.0351 1.68777 10.0039 1.93798L10.5 2ZM13.7747 4.19754L13.2786 4.25955C13.3047 4.46849 13.4589 4.63867 13.6642 4.68519L13.7747 4.19754ZM16.2617 5.22838L15.995 5.6513C16.1731 5.76362 16.4024 5.75233 16.5687 5.62306L16.2617 5.22838ZM18.0104 3.86826L18.364 3.51471C18.1857 3.3364 17.9025 3.31877 17.7034 3.47359L18.0104 3.86826ZM20.1317 5.98958L20.5264 6.29655C20.6812 6.09751 20.6636 5.81434 20.4853 5.63603L20.1317 5.98958ZM18.7716 7.73831L18.3769 7.43134C18.2477 7.59754 18.2364 7.82693 18.3487 8.00503L18.7716 7.73831ZM19.8025 10.2253L19.3148 10.3358C19.3613 10.5411 19.5315 10.6953 19.7404 10.7214L19.8025 10.2253ZM22 10.5H22.5C22.5 10.2478 22.3122 10.0351 22.062 10.0039L22 10.5ZM22 13.5L22.062 13.9961C22.3122 13.9649 22.5 13.7522 22.5 13.5H22ZM19.8025 13.7747L19.7404 13.2786C19.5315 13.3047 19.3613 13.4589 19.3148 13.6642L19.8025 13.7747ZM18.7716 16.2617L18.3487 15.995C18.2364 16.1731 18.2477 16.4025 18.3769 16.5687L18.7716 16.2617ZM20.1317 18.0104L20.4853 18.364C20.6636 18.1857 20.6812 17.9025 20.5264 17.7034L20.1317 18.0104ZM18.0104 20.1317L17.7034 20.5264C17.9025 20.6812 18.1857 20.6636 18.364 20.4853L18.0104 20.1317ZM16.2617 18.7716L16.5687 18.3769C16.4024 18.2477 16.1731 18.2364 15.995 18.3487L16.2617 18.7716ZM13.7747 19.8025L13.6642 19.3148C13.4589 19.3613 13.3047 19.5315 13.2786 19.7404L13.7747 19.8025ZM13.5 22V22.5C13.7522 22.5 13.9649 22.3122 13.9961 22.062L13.5 22ZM10.5 22L10.0039 22.062C10.0351 22.3122 10.2478 22.5 10.5 22.5V22ZM10.2253 19.8025L10.7214 19.7404C10.6953 19.5315 10.5411 19.3613 10.3358 19.3148L10.2253 19.8025ZM7.73832 18.7716L8.00504 18.3487C7.82694 18.2364 7.59756 18.2477 7.43135 18.3769L7.73832 18.7716ZM5.98959 20.1317L5.63604 20.4853C5.81435 20.6636 6.09752 20.6812 6.29656 20.5264L5.98959 20.1317ZM3.86827 18.0104L3.4736 17.7034C3.31878 17.9025 3.33641 18.1857 3.51472 18.364L3.86827 18.0104ZM5.22839 16.2617L5.62307 16.5687C5.75234 16.4025 5.76363 16.1731 5.65131 15.995L5.22839 16.2617ZM4.19754 13.7747L4.68519 13.6642C4.63867 13.4589 4.46849 13.3047 4.25955 13.2786L4.19754 13.7747ZM2 13.5H1.5C1.5 13.7522 1.68777 13.9649 1.93798 13.9961L2 13.5ZM2 10.5L1.93798 10.0039C1.68777 10.0351 1.5 10.2478 1.5 10.5H2ZM4.19754 10.2253L4.25955 10.7214C4.46849 10.6953 4.63867 10.5411 4.68519 10.3358L4.19754 10.2253ZM5.22839 7.73831L5.65131 8.00503C5.76363 7.82693 5.75234 7.59755 5.62307 7.43134L5.22839 7.73831ZM3.86827 5.98959L3.51472 5.63603C3.33641 5.81434 3.31878 6.09751 3.47359 6.29656L3.86827 5.98959ZM5.98959 3.86827L6.29656 3.47359C6.09752 3.31878 5.81434 3.33641 5.63604 3.51471L5.98959 3.86827ZM7.73832 5.22839L7.43135 5.62306C7.59755 5.75233 7.82694 5.76363 8.00504 5.6513L7.73832 5.22839ZM10.2253 4.19754L10.3358 4.68519C10.5411 4.63867 10.6953 4.46849 10.7214 4.25955L10.2253 4.19754ZM13.5 1.5H10.5V2.5H13.5V1.5ZM14.2708 4.13552L13.9961 1.93798L13.0039 2.06202L13.2786 4.25955L14.2708 4.13552ZM16.5284 4.80547C15.7279 4.30059 14.8369 3.92545 13.8851 3.70989L13.6642 4.68519C14.503 4.87517 15.2886 5.20583 15.995 5.6513L16.5284 4.80547ZM16.5687 5.62306L18.3174 4.26294L17.7034 3.47359L15.9547 4.83371L16.5687 5.62306ZM17.6569 4.22182L19.7782 6.34314L20.4853 5.63603L18.364 3.51471L17.6569 4.22182ZM19.7371 5.68261L18.3769 7.43134L19.1663 8.04528L20.5264 6.29655L19.7371 5.68261ZM20.2901 10.1149C20.0746 9.16313 19.6994 8.27213 19.1945 7.47158L18.3487 8.00503C18.7942 8.71138 19.1248 9.49695 19.3148 10.3358L20.2901 10.1149ZM22.062 10.0039L19.8645 9.72917L19.7404 10.7214L21.938 10.9961L22.062 10.0039ZM22.5 13.5V10.5H21.5V13.5H22.5ZM19.8645 14.2708L22.062 13.9961L21.938 13.0039L19.7404 13.2786L19.8645 14.2708ZM19.1945 16.5284C19.6994 15.7279 20.0746 14.8369 20.2901 13.8851L19.3148 13.6642C19.1248 14.503 18.7942 15.2886 18.3487 15.995L19.1945 16.5284ZM20.5264 17.7034L19.1663 15.9547L18.3769 16.5687L19.7371 18.3174L20.5264 17.7034ZM18.364 20.4853L20.4853 18.364L19.7782 17.6569L17.6569 19.7782L18.364 20.4853ZM15.9547 19.1663L17.7034 20.5264L18.3174 19.7371L16.5687 18.3769L15.9547 19.1663ZM13.8851 20.2901C14.8369 20.0746 15.7279 19.6994 16.5284 19.1945L15.995 18.3487C15.2886 18.7942 14.503 19.1248 13.6642 19.3148L13.8851 20.2901ZM13.9961 22.062L14.2708 19.8645L13.2786 19.7404L13.0039 21.938L13.9961 22.062ZM10.5 22.5H13.5V21.5H10.5V22.5ZM9.72917 19.8645L10.0039 22.062L10.9961 21.938L10.7214 19.7404L9.72917 19.8645ZM7.4716 19.1945C8.27214 19.6994 9.16314 20.0746 10.1149 20.2901L10.3358 19.3148C9.49696 19.1248 8.71139 18.7942 8.00504 18.3487L7.4716 19.1945ZM6.29656 20.5264L8.04529 19.1663L7.43135 18.3769L5.68262 19.7371L6.29656 20.5264ZM3.51472 18.364L5.63604 20.4853L6.34315 19.7782L4.22183 17.6569L3.51472 18.364ZM4.83372 15.9547L3.4736 17.7034L4.26295 18.3174L5.62307 16.5687L4.83372 15.9547ZM3.70989 13.8851C3.92545 14.8369 4.30059 15.7279 4.80547 16.5284L5.65131 15.995C5.20584 15.2886 4.87517 14.503 4.68519 13.6642L3.70989 13.8851ZM1.93798 13.9961L4.13552 14.2708L4.25955 13.2786L2.06202 13.0039L1.93798 13.9961ZM1.5 10.5V13.5H2.5V10.5H1.5ZM4.13552 9.72917L1.93798 10.0039L2.06202 10.9961L4.25955 10.7214L4.13552 9.72917ZM4.80547 7.47159C4.30059 8.27213 3.92545 9.16313 3.70989 10.1149L4.68519 10.3358C4.87517 9.49696 5.20583 8.71138 5.65131 8.00503L4.80547 7.47159ZM3.47359 6.29656L4.83371 8.04528L5.62307 7.43134L4.26295 5.68262L3.47359 6.29656ZM5.63604 3.51471L3.51472 5.63603L4.22182 6.34314L6.34314 4.22182L5.63604 3.51471ZM8.04529 4.83371L6.29656 3.47359L5.68262 4.26294L7.43135 5.62306L8.04529 4.83371ZM10.1149 3.70989C9.16313 3.92545 8.27214 4.30059 7.4716 4.80547L8.00504 5.6513C8.71139 5.20583 9.49696 4.87517 10.3358 4.68519L10.1149 3.70989ZM10.0039 1.93798L9.72917 4.13552L10.7214 4.25955L10.9961 2.06202L10.0039 1.93798Z"
                                                        fill="#ea33c0" />
                                                    <circle cx="12" cy="12" r="4" stroke="#ea33c0"
                                                        stroke-linejoin="round" />
                                                </g>
                                            </svg>
                                            <a href="#"
                                                class="block text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                role="menuitem">Edit Info</a>
                                        </div>
                                        <hr class="border-b border-solid" style="border-color:#ea33c0" />
                                        <div class="flex px-6 py-2 gap-3">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M12.7917 15.7991L14.2223 14.3676C16.5926 11.9959 16.5926 8.15054 14.2223 5.7788C11.8521 3.40707 8.0091 3.40707 5.63885 5.7788L2.77769 8.64174C0.407436 11.0135 0.407436 14.8588 2.77769 17.2306C3.87688 18.3304 5.29279 18.9202 6.73165 19"
                                                        stroke="#ea33c0" stroke-width="1.5" stroke-linecap="round" />
                                                    <path
                                                        d="M11.2083 8.20092L9.77769 9.63239C7.40744 12.0041 7.40744 15.8495 9.77769 18.2212C12.1479 20.5929 15.9909 20.5929 18.3612 18.2212L21.2223 15.3583C23.5926 12.9865 23.5926 9.14118 21.2223 6.76945C20.1231 5.66957 18.7072 5.07976 17.2683 5"
                                                        stroke="#ea33c0" stroke-width="1.5" stroke-linecap="round" />
                                                </g>
                                            </svg>
                                            <a href="#"
                                                class="block text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                role="menuitem">Send a link to Login</a>
                                        </div>
                                        <hr class="border-b border-solid" style="border-color:#ea33c0" />
                                        @if (Auth::user()->role == 'Admin')
                                            <div class="flex px-6 py-2 gap-3">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path d="M19 5L5 19M5.00001 5L19 19" stroke="#ea33c0"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </g>
                                                </svg>
                                                <a href="#"
                                                    class="block text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                    role="menuitem">Delete User</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="divider" data-astro-cid-rwhxyfax></div>
                    @endforeach
                </div>
            @endif
        @endforeach

        {{--        Dialog pop up appeare for add new team mamber add --}}
        <div data-astro-cid-rwhxyfax>
            <dialog id="create_modal" class="modal w-50%" data-astro-cid-rwhxyfax>
                <div class="modal-box w-5/12 max-w-5xl py-10 p-10 " data-astro-cid-rwhxyfax>
                    <div class="grid justify-items-end">
                        <button id="close_button" onclick="closemodal()">
                            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M19 5L5 19M5.00001 5L19 19" stroke="#ea33c0" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                            </svg>
                        </button>

                    </div>
                    <h3 class="font-semibold text-3xl text-center" data-astro-cid-rwhxyfax>Invite a New Team Member</h3>

                    <!-- First Block Section: Coworker -->
                    <div class="flex w-full justify-between py-8 gap-5" data-astro-cid-rwhxyfax>
                        <div class="start_icon flex flex-col gap-2 w-full h-[200px] justify-center items-center border border-[#DDDDDD] rounded-xl"
                            id="add-cateory" onclick="showAddCategoryModal()" data-astro-cid-rwhxyfax>
                            <!-- Icon for Coworker -->
                            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                            <svg width="48px" height="48px" viewBox="0 0 1024 1024"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="512" cy="512" r="512" fill="#D80D8D" />
                                <path
                                    d="M512 661.3c-117.6 0-213.3-95.7-213.3-213.3S394.4 234.7 512 234.7 725.3 330.4 725.3 448 629.6 661.3 512 661.3z m0-341.3c-70.6 0-128 57.4-128 128s57.4 128 128 128 128-57.4 128-128-57.4-128-128-128z"
                                    fill="#FFFFFF" />
                                <path
                                    d="M837 862.9c-15.7 0-30.8-8.7-38.2-23.7C744.3 729.5 634.4 661.3 512 661.3s-232.3 68.1-286.8 177.9c-10.5 21.1-36.1 29.7-57.2 19.2s-29.7-36.1-19.2-57.2C217.8 662.3 357 576 512 576s294.2 86.3 363.2 225.2c10.5 21.1 1.9 46.7-19.2 57.2-6.1 3-12.6 4.5-19 4.5z"
                                    fill="#FFFFFF" />
                                <path
                                    d="M512 1002.7c-270.6 0-490.7-220.1-490.7-490.7S241.4 21.3 512 21.3s490.7 220.1 490.7 490.7-220.1 490.7-490.7 490.7z m0-896c-223.5 0-405.3 181.8-405.3 405.3S288.5 917.3 512 917.3 917.3 735.5 917.3 512 735.5 106.7 512 106.7z"
                                    fill="#FFFFFF" />
                                <path d="M512 512m-41.6 0a41.6 41.6 0 1 0 83.2 0 41.6 41.6 0 1 0-83.2 0Z" fill="#FFFFFF" />
                                <path
                                    d="M666.4 512h-56v-56a16 16 0 1 0-32 0v56h-56a16 16 0 1 0 0 32h56v56a16 16 0 1 0 32 0v-56h56a16 16 0 1 0 0-32Z"
                                    fill="#FFFFFF" />
                            </svg>
                            <p data-astro-cid-rwhxyfax>A Coworker</p>
                            <p data-astro-cid-rwhxyfax>Your Team Members can create projects and users to projects.</p>
                        </div>

                    </div>

                    <!-- Second Block Section: Client -->
                    <div class="flex w-full justify-between py-8 gap-5" data-astro-cid-rwhxyfax>
                        <div class="start_icon flex flex-col gap-2 w-full h-[200px] justify-center items-center border border-[#DDDDDD] rounded-xl"
                            id="add-publisher" onclick="showAddPublisherModal()" data-astro-cid-rwhxyfax>
                            <!-- Icon for Client -->
                            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                            <svg width="48px" height="48px" viewBox="0 0 1024 1024"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="512" cy="512" r="512" fill="#FFD700" />
                                <path
                                    d="M512 661.3c-117.6 0-213.3-95.7-213.3-213.3S394.4 234.7 512 234.7 725.3 330.4 725.3 448 629.6 661.3 512 661.3z m0-341.3c-70.6 0-128 57.4-128 128s57.4 128 128 128 128-57.4 128-128-57.4-128-128-128z"
                                    fill="#FFFFFF" />
                                <path
                                    d="M837 862.9c-15.7 0-30.8-8.7-38.2-23.7C744.3 729.5 634.4 661.3 512 661.3s-232.3 68.1-286.8 177.9c-10.5 21.1-36.1 29.7-57.2 19.2s-29.7-36.1-19.2-57.2C217.8 662.3 357 576 512 576s294.2 86.3 363.2 225.2c10.5 21.1 1.9 46.7-19.2 57.2-6.1 3-12.6 4.5-19 4.5z"
                                    fill="#FFFFFF" />
                                <path
                                    d="M512 1002.7c-270.6 0-490.7-220.1-490.7-490.7S241.4 21.3 512 21.3s490.7 220.1 490.7 490.7-220.1 490.7-490.7 490.7z m0-896c-223.5 0-405.3 181.8-405.3 405.3S288.5 917.3 512 917.3 917.3 735.5 917.3 512 735.5 106.7 512 106.7z"
                                    fill="#FFFFFF" />
                                <path d="M512 512m-41.6 0a41.6 41.6 0 1 0 83.2 0 41.6 41.6 0 1 0-83.2 0Z" fill="#FFFFFF" />
                                <path
                                    d="M666.4 512h-56v-56a16 16 0 1 0-32 0v56h-56a16 16 0 1 0 0 32h56v56a16 16 0 1 0 32 0v-56h56a16 16 0 1 0 0-32Z"
                                    fill="#FFFFFF" />
                            </svg>
                            <p data-astro-cid-rwhxyfax>A Client</p>
                            <p data-astro-cid-rwhxyfax>A Client can see projects they are added to and review and edit
                                assets.</p>
                        </div>

                    </div>

                    <!-- Third Block Section: Creative Partner -->
                    <div class="flex w-full justify-between py-8 gap-5" data-astro-cid-rwhxyfax>
                        <div class="start_icon flex flex-col gap-2 w-full h-[200px] justify-center items-center border border-[#DDDDDD] rounded-xl"
                            id="add-type" onclick="showAddTypeModal()" data-astro-cid-rwhxyfax>
                            <!-- Icon for Creative Partner -->
                            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                            <svg width="48px" height="48px" viewBox="0 0 1024 1024"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="512" cy="512" r="512" fill="#3688FF" />
                                <path
                                    d="M512 661.3c-117.6 0-213.3-95.7-213.3-213.3S394.4 234.7 512 234.7 725.3 330.4 725.3 448 629.6 661.3 512 661.3z m0-341.3c-70.6 0-128 57.4-128 128s57.4 128 128 128 128-57.4 128-128-57.4-128-128-128z"
                                    fill="#FFFFFF" />
                                <path
                                    d="M837 862.9c-15.7 0-30.8-8.7-38.2-23.7C744.3 729.5 634.4 661.3 512 661.3s-232.3 68.1-286.8 177.9c-10.5 21.1-36.1 29.7-57.2 19.2s-29.7-36.1-19.2-57.2C217.8 662.3 357 576 512 576s294.2 86.3 363.2 225.2c10.5 21.1 1.9 46.7-19.2 57.2-6.1 3-12.6 4.5-19 4.5z"
                                    fill="#FFFFFF" />
                                <path
                                    d="M512 1002.7c-270.6 0-490.7-220.1-490.7-490.7S241.4 21.3 512 21.3s490.7 220.1 490.7 490.7-220.1 490.7-490.7 490.7z m0-896c-223.5 0-405.3 181.8-405.3 405.3S288.5 917.3 512 917.3 917.3 735.5 917.3 512 735.5 106.7 512 106.7z"
                                    fill="#FFFFFF" />
                                <path d="M512 512m-41.6 0a41.6 41.6 0 1 0 83.2 0 41.6 41.6 0 1 0-83.2 0Z" fill="#FFFFFF" />
                                <path
                                    d="M666.4 512h-56v-56a16 16 0 1 0-32 0v56h-56a16 16 0 1 0 0 32h56v56a16 16 0 1 0 32 0v-56h56a16 16 0 1 0 0-32Z"
                                    fill="#FFFFFF" />
                            </svg>

                            <p data-astro-cid-rwhxyfax>A Creative Partner</p>
                            <p data-astro-cid-rwhxyfax>Creative Partners can see projects they are added to and edit assets
                            </p>
                        </div>

                    </div>

                </div>
            </dialog>
        </div>
        {{--        end  add/invite team mamber modal --}}


        {{-- start Invite a Coworker Modal --}}
        <div data-astro-cid-rwhxyfax>
            <dialog id="add_category_modal" class="modal" data-astro-cid-rwhxyfax>

                <div class="modal-box w-5/12 max-w-5xl py-10" data-astro-cid-rwhxyfax>
                    <div class="grid justify-items-end">
                        <button id="close_button" onclick="closemodal()">
                            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M19 5L5 19M5.00001 5L19 19" stroke="#ea33c0" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                            </svg>
                        </button>
                    </div>
                    <div class="flex justify-center">
                        <form method="post" action="{{ route('manage-people-store') }}" enctype="multipart/form-data"
                            class="mt-7" data-astro-cid-rwhxyfax>
                            @csrf

                            <div class="flex flex-col gap-4 w-full">
                                <h2 class="text-center font-bold text-2xl mb-4">Invite a Coworker</h2>
                                <div class="flex justify-center mb-4">
                                    <svg width="48px" height="48px" viewBox="0 0 1024 1024"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="512" cy="512" r="512" fill="#D80D8D" />
                                        <path
                                            d="M512 661.3c-117.6 0-213.3-95.7-213.3-213.3S394.4 234.7 512 234.7 725.3 330.4 725.3 448 629.6 661.3 512 661.3z m0-341.3c-70.6 0-128 57.4-128 128s57.4 128 128 128 128-57.4 128-128-57.4-128-128-128z"
                                            fill="#FFFFFF" />
                                        <path
                                            d="M837 862.9c-15.7 0-30.8-8.7-38.2-23.7C744.3 729.5 634.4 661.3 512 661.3s-232.3 68.1-286.8 177.9c-10.5 21.1-36.1 29.7-57.2 19.2s-29.7-36.1-19.2-57.2C217.8 662.3 357 576 512 576s294.2 86.3 363.2 225.2c10.5 21.1 1.9 46.7-19.2 57.2-6.1 3-12.6 4.5-19 4.5z"
                                            fill="#FFFFFF" />
                                        <path
                                            d="M512 1002.7c-270.6 0-490.7-220.1-490.7-490.7S241.4 21.3 512 21.3s490.7 220.1 490.7 490.7-220.1 490.7-490.7 490.7z m0-896c-223.5 0-405.3 181.8-405.3 405.3S288.5 917.3 512 917.3 917.3 735.5 917.3 512 735.5 106.7 512 106.7z"
                                            fill="#FFFFFF" />
                                        <path d="M512 512m-41.6 0a41.6 41.6 0 1 0 83.2 0 41.6 41.6 0 1 0-83.2 0Z"
                                            fill="#FFFFFF" />
                                        <path
                                            d="M666.4 512h-56v-56a16 16 0 1 0-32 0v56h-56a16 16 0 1 0 0 32h56v56a16 16 0 1 0 32 0v-56h56a16 16 0 1 0 0-32Z"
                                            fill="#FFFFFF" />
                                    </svg>
                                </div>
                                <div class="mb-4">
                                    <div class="flex flex-wrap gap-4">
                                        <div class="flex flex-col w-1/2">
                                            <label for="teamName" class="block font-medium">Name</label>
                                            <input id="name" type="text" name="name" placeholder="Full Name"
                                                class="input input-bordered input-primary w-full mt-2"
                                                value="{{ old('name') }}" />
                                        </div>
                                        <div class="flex flex-col w-1/2">
                                            <label for="email" class="block font-medium">Email</label>
                                            <input id="email" type="text" name="email"
                                                placeholder="name@emailaddress.com"
                                                class="input input-bordered input-primary w-full mt-2"
                                                value="{{ old('email') }}" />
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        {{-- <label for="invitation_note" class="block font-medium"></label> --}}
                                        <textarea name="invitation_note" id="invitation_note" cols="30" rows="10" name="invitation_note"
                                            placeholder="Add a note to your invitation!" class="input input-bordered input-primary w-full mt-2"></textarea>
                                    </div>
                                    @error('teamName')
                                        <p class="text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="divider"></div>
                                <div class="flex justify-center">
                                    <button role="button" type="submit"
                                        class="btn rounded-full bg-accent text-white no-animation" id="btnAddTeam">
                                        Send Invitation
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </dialog>
        </div>
        {{--        end Invite a Coworker  model --}}


        {{-- start Invite a Client modal --}}
        <div data-astro-cid-rwhxyfax>
            <dialog id="add_publisher_modal" class="modal" data-astro-cid-rwhxyfax>
                <div class="modal-box w-5/12 max-w-5xl py-10" data-astro-cid-rwhxyfax>
                    <div class="grid justify-items-end">
                        <button id="close_button" onclick="closemodal()">
                            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M19 5L5 19M5.00001 5L19 19" stroke="#ea33c0" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                            </svg>
                        </button>
                    </div>
                    <h3 class="font-semibold text-3xl text-center" data-astro-cid-rwhxyfax>Add Publisher</h3>
                    <div class="flex justify-center">
                        <form method="post" action="{{ route('manage-people-store') }}" enctype="multipart/form-data"
                            class="mt-7" data-astro-cid-rwhxyfax>
                            @csrf

                            <div class="flex flex-col gap-4 w-full">
                                <h2 class="text-center font-bold text-2xl mb-4">Invite a Client</h2>
                                <div class="flex justify-center mb-4">
                                    <svg width="48px" height="48px" viewBox="0 0 1024 1024"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="512" cy="512" r="512" fill="#FFD700" />
                                        <path
                                            d="M512 661.3c-117.6 0-213.3-95.7-213.3-213.3S394.4 234.7 512 234.7 725.3 330.4 725.3 448 629.6 661.3 512 661.3z m0-341.3c-70.6 0-128 57.4-128 128s57.4 128 128 128 128-57.4 128-128-57.4-128-128-128z"
                                            fill="#FFFFFF" />
                                        <path
                                            d="M837 862.9c-15.7 0-30.8-8.7-38.2-23.7C744.3 729.5 634.4 661.3 512 661.3s-232.3 68.1-286.8 177.9c-10.5 21.1-36.1 29.7-57.2 19.2s-29.7-36.1-19.2-57.2C217.8 662.3 357 576 512 576s294.2 86.3 363.2 225.2c10.5 21.1 1.9 46.7-19.2 57.2-6.1 3-12.6 4.5-19 4.5z"
                                            fill="#FFFFFF" />
                                        <path
                                            d="M512 1002.7c-270.6 0-490.7-220.1-490.7-490.7S241.4 21.3 512 21.3s490.7 220.1 490.7 490.7-220.1 490.7-490.7 490.7z m0-896c-223.5 0-405.3 181.8-405.3 405.3S288.5 917.3 512 917.3 917.3 735.5 917.3 512 735.5 106.7 512 106.7z"
                                            fill="#FFFFFF" />
                                        <path d="M512 512m-41.6 0a41.6 41.6 0 1 0 83.2 0 41.6 41.6 0 1 0-83.2 0Z"
                                            fill="#FFFFFF" />
                                        <path
                                            d="M666.4 512h-56v-56a16 16 0 1 0-32 0v56h-56a16 16 0 1 0 0 32h56v56a16 16 0 1 0 32 0v-56h56a16 16 0 1 0 0-32Z"
                                            fill="#FFFFFF" />
                                    </svg>
                                </div>
                                <div class="mb-4">
                                    <div class="flex flex-wrap gap-4">
                                        <div class="flex flex-col w-1/2">
                                            <label for="teamName" class="block font-medium">Name</label>
                                            <input id="name" type="text" name="name" placeholder="Full Name"
                                                class="input input-bordered input-primary w-full mt-2"
                                                value="{{ old('name') }}" />
                                        </div>
                                        <div class="flex flex-col w-1/2">
                                            <label for="email" class="block font-medium">Email</label>
                                            <input id="email" type="text" name="email"
                                                placeholder="name@emailaddress.com"
                                                class="input input-bordered input-primary w-full mt-2"
                                                value="{{ old('email') }}" />
                                        </div>
                                    </div>
                                    {{-- <div class="flex flex-wrap gap-4"> --}}
                                    <div class="flex flex-col w-full">
                                        <label for="teamName" class="block font-medium mt-4">Which Team Do they belong
                                            to?</label>
                                        <select class="select select-primary w-96 text-[#BABABA]" id="team_id"
                                            name="team_id" data-astro-cid-rwhxyfax>
                                            <option disabled selected data-astro-cid-rwhxyfax>
                                                Please Select....
                                            </option>
                                            @foreach ($Teams as $team)
                                                <option value="{{ $team->id }}-{{ $team->team_type }}">{{ $team->team_type }} -
                                                    {{ $team->name }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <select name="team_id_team_type" id="team_id_team_type">
                                            @foreach($Teams as $team)

                                                <option value="{{ $team_id }}-{{ $team_type }}">{{ $team_type }} - {{ $team->name }}</option>
                                            @endforeach
                                        </select> --}}
                                        
                                    </div>
                                    {{-- </div> --}}
                                    <div class="mt-4">
                                        {{-- <label for="invitation_note" class="block font-medium"></label> --}}
                                        <textarea name="invitation_note" id="invitation_note" cols="30" rows="10" name="invitation_note"
                                            placeholder="Add a note to your invitation!" class="input input-bordered input-primary w-full mt-2"></textarea>
                                    </div>
                                    @error('teamName')
                                        <p class="text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="divider"></div>
                                <div class="flex justify-center">
                                    <button role="button" type="submit"
                                        class="btn rounded-full bg-accent text-white no-animation" id="btnAddTeam">
                                        Send Invitation
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </dialog>
        </div>
        {{--        end Invite a Client modal --}}


        {{--  start Invite a Creative Partner model  --}}
        <div data-astro-cid-rwhxyfax>
            <dialog id="add_addtype_modal" class="modal" data-astro-cid-rwhxyfax>
                <div class="modal-box w-5/12 max-w-5xl py-10" data-astro-cid-rwhxyfax>
                    <div class="grid justify-items-end">
                        <button id="close_button" onclick="closemodal()">
                            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M19 5L5 19M5.00001 5L19 19" stroke="#ea33c0" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                            </svg>
                        </button>
                    </div>
                    <h3 class="font-semibold text-3xl text-center" data-astro-cid-rwhxyfax>Add Type</h3>
                    <div class="flex justify-center">
                        <form method="post" action="{{ route('manage-people-store') }}" enctype="multipart/form-data"
                            class="mt-7" data-astro-cid-rwhxyfax>
                            @csrf

                            <div class="flex flex-col gap-4 w-full">
                                <h2 class="text-center font-bold text-2xl mb-4">Invite a Creative Partner</h2>
                                <div class="flex justify-center mb-4">
                                    <svg width="48px" height="48px" viewBox="0 0 1024 1024"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="512" cy="512" r="512" fill="#3688FF" />
                                <path
                                    d="M512 661.3c-117.6 0-213.3-95.7-213.3-213.3S394.4 234.7 512 234.7 725.3 330.4 725.3 448 629.6 661.3 512 661.3z m0-341.3c-70.6 0-128 57.4-128 128s57.4 128 128 128 128-57.4 128-128-57.4-128-128-128z"
                                    fill="#FFFFFF" />
                                <path
                                    d="M837 862.9c-15.7 0-30.8-8.7-38.2-23.7C744.3 729.5 634.4 661.3 512 661.3s-232.3 68.1-286.8 177.9c-10.5 21.1-36.1 29.7-57.2 19.2s-29.7-36.1-19.2-57.2C217.8 662.3 357 576 512 576s294.2 86.3 363.2 225.2c10.5 21.1 1.9 46.7-19.2 57.2-6.1 3-12.6 4.5-19 4.5z"
                                    fill="#FFFFFF" />
                                <path
                                    d="M512 1002.7c-270.6 0-490.7-220.1-490.7-490.7S241.4 21.3 512 21.3s490.7 220.1 490.7 490.7-220.1 490.7-490.7 490.7z m0-896c-223.5 0-405.3 181.8-405.3 405.3S288.5 917.3 512 917.3 917.3 735.5 917.3 512 735.5 106.7 512 106.7z"
                                    fill="#FFFFFF" />
                                <path d="M512 512m-41.6 0a41.6 41.6 0 1 0 83.2 0 41.6 41.6 0 1 0-83.2 0Z" fill="#FFFFFF" />
                                <path
                                    d="M666.4 512h-56v-56a16 16 0 1 0-32 0v56h-56a16 16 0 1 0 0 32h56v56a16 16 0 1 0 32 0v-56h56a16 16 0 1 0 0-32Z"
                                    fill="#FFFFFF" />
                            </svg>

                                </div>
                                <div class="mb-4">
                                    <div class="flex flex-wrap gap-4">
                                        <div class="flex flex-col w-1/2">
                                            <label for="teamName" class="block font-medium">Name</label>
                                            <input id="name" type="text" name="name" placeholder="Full Name"
                                                class="input input-bordered input-primary w-full mt-2"
                                                value="{{ old('name') }}" />
                                        </div>
                                        <div class="flex flex-col w-1/2">
                                            <label for="email" class="block font-medium">Email</label>
                                            <input id="email" type="text" name="email"
                                                placeholder="name@emailaddress.com"
                                                class="input input-bordered input-primary w-full mt-2"
                                                value="{{ old('email') }}" />
                                        </div>
                                    </div>
                                    {{-- <div class="flex flex-wrap gap-4"> --}}
                                    <div class="flex flex-col w-full">
                                        <label for="teamName" class="block font-medium mt-4">Which Team Do they belong
                                            to?</label>
                                        <select class="select select-primary w-96 text-[#BABABA]" id="team_id"
                                            name="team_id" data-astro-cid-rwhxyfax>
                                            <option disabled selected data-astro-cid-rwhxyfax>
                                                Please Select....
                                            </option>
                                            @foreach ($Teams as $team)
                                                {{-- {{ dd($Client) }} --}}
                                                {{-- <option value="{{ $Client->name }}">{{ $Client->name }}</option> --}}
                                                <option value="{{ $team->id }}">{{ $team->team_type }} -
                                                    {{ $team->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- </div> --}}
                                    <div class="mt-4">
                                        {{-- <label for="invitation_note" class="block font-medium"></label> --}}
                                        <textarea name="invitation_note" id="invitation_note" cols="30" rows="10"
                                            placeholder="Add a note to your invitation!" class="input input-bordered input-primary w-full mt-2"></textarea>
                                    </div>
                                    @error('teamName')
                                        <p class="text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="divider"></div>
                                <div class="flex justify-center">
                                    <button role="button" type="submit"
                                        class="btn rounded-full bg-accent text-white no-animation" id="btnAddTeam">
                                        Send Invitation
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </dialog>
        </div>
        {{-- end Invite a Creative Partner model --}}

        <script>
            function createTeamRedirect() {
                window.location.href = './create-team'
            }

            // Function to show the coworker dialog box
            function showAddCategoryModal() {
                const addCategory = document.getElementById('add_category_modal');
                addCategory.showModal();
                create_modal.close();
            }

            // Adding event listener to the coworker button
            document.getElementById('create_coworker_button').addEventListener('click', showAddCategoryModal);

            // Function to show the coworker dialog box
            function showAddPublisherModal() {
                const addPublisher = document.getElementById('add_publisher_modal');
                addPublisher.showModal();
                create_modal.close();
            }

            // Adding event listener to the coworker button
            document.getElementById('create_client_button').addEventListener('click', showAddPublisherModal);

            // Function to show the coworker dialog box
            function showAddTypeModal() {
                const addType = document.getElementById('add_addtype_modal');
                addType.showModal();
                create_modal.close();
            }

            // Adding event listener to the coworker button
            document.getElementById('create_partner_button').addEventListener('click', showPartnerModal);

            // Function to show the coworker dialog box
            function showInviteCoworkerModal() {

                const inviteCoworkerModal = document.getElementById('invitation_coworker_modal');
                inviteCoworkerModal.showModal();
                add_category_modal.close();
                create_addtype_modal.close();
                create_publisher_modal.close();
            }

            function closemodal() {
                create_modal.close();
                add_category_modal.close();
                add_publisher_modal.close();
                add_addtype_modal.close();


            }
        </script>
    @endsection
