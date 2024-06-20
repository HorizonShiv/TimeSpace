@include('Layout.header')

<div class="flex relative" data-astro-cid-sckkx6r4>
    <div class="z-20">
        <!-- hamburger  -->
        <span class="absolute text-white text-4xl top-2 left-4 cursor-pointer md:hidden" onclick="openSidebar()">
            <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                viewBox="0 0 24 24" fill="#ffffff">
                <path d="M20 7L4 7" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                <path d="M20 12L4 12" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                <path d="M20 17L4 17" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
            </svg>
        </span>
        <!-- sidebar  -->
        <div
            class="sidebar fixed top-4 bottom-0 lg:left-0 w-[300px] overflow-y-auto text-center bg-white shadow-2xl hidden md:block">
            <!-- logo  -->
            <div class="py-10">
                <a href="{{ route('index') }}">
                    <img src="/assets/sidebar/logo.png" class="w-52 h-auto mx-auto" />
                </a>
                <!-- close icon  -->
                <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 -0.5 25 25" fill="none" width="40" height="40" onclick="openSidebar()"
                    class="md:hidden">
                    <path
                        d="M6.96967 16.4697C6.67678 16.7626 6.67678 17.2374 6.96967 17.5303C7.26256 17.8232 7.73744 17.8232 8.03033 17.5303L6.96967 16.4697ZM13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697L13.0303 12.5303ZM11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303L11.9697 11.4697ZM18.0303 7.53033C18.3232 7.23744 18.3232 6.76256 18.0303 6.46967C17.7374 6.17678 17.2626 6.17678 16.9697 6.46967L18.0303 7.53033ZM13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303L13.0303 11.4697ZM16.9697 17.5303C17.2626 17.8232 17.7374 17.8232 18.0303 17.5303C18.3232 17.2374 18.3232 16.7626 18.0303 16.4697L16.9697 17.5303ZM11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697L11.9697 12.5303ZM8.03033 6.46967C7.73744 6.17678 7.26256 6.17678 6.96967 6.46967C6.67678 6.76256 6.67678 7.23744 6.96967 7.53033L8.03033 6.46967ZM8.03033 17.5303L13.0303 12.5303L11.9697 11.4697L6.96967 16.4697L8.03033 17.5303ZM13.0303 12.5303L18.0303 7.53033L16.9697 6.46967L11.9697 11.4697L13.0303 12.5303ZM11.9697 12.5303L16.9697 17.5303L18.0303 16.4697L13.0303 11.4697L11.9697 12.5303ZM13.0303 11.4697L8.03033 6.46967L6.96967 7.53033L11.9697 12.5303L13.0303 11.4697Z"
                        fill="#000000"></path>
                </svg>
            </div>
            <div class="bg-[#EA33C0] h-[1.5px]"></div>
            <div class="pt-4 px-3 py-3">
                <div class="flex gap-3">
                    <div
                        class="flex justify-center items-center w-[52px] h-[52px] rounded-full bg-[#C72BA4] border border-[#EA33C0]">
                        <p class="text-3xl font-medium text-[#ffffff]">B</p>
                    </div>
                    <div class="flex flex-col items-start">
                        <p class="text-base font-semibold">Brad Wilton</p>
                        <p class="text-base font-semibold">Project Manager</p>
                    </div>
                </div>
                <div class="flex items-start gap-1 mt-3 ml-11">
                    <p class="font-medium text-base text-left">My Notifications</p>
                    <div
                        class="bg-[#FF4848] w-[21px] h-[21px] flex justify-center items-center rounded-full text-white text-xs">
                        3
                    </div>
                </div>
            </div>
            <div class="bg-[#EA33C0] h-[1.5px]"></div>
            <!-- <div id="campaigns" onclick="dropdown()"></div> -->
            <div id="Campaigns" class="px-6 py-5">
                <div class="flex gap-6 items-center">
                    <img src="/assets/sidebar/campaign.png" class="w-[15px] h-[15px]" />
                    <p class="text-xl font-medium">Campaigns</p>
                </div>
                <div class="flex flex-col justify-start mt-4 ml-11">
                    <a href="{{ route('Campaign.index') }}" class="mb-2">
                        <p class="text-[#000000] font-medium text-base text-left">
                            Dashboard
                        </p>
                    </a>
                    <a href="{{ route('CampaignList') }}" class="mb-2">
                        <p class="text-[#000000] font-medium text-base text-left">
                            Campaign List
                        </p>
                    </a>
                    <a href="{{ route('customer') }}" class="mb-2">
                        <p class="text-[#000000] font-medium text-base text-left">
                            Client
                        </p>
                    </a>
                </div>
            </div>
            <div class="bg-[#EA33C0] h-[1.5px]"></div>
            <div id="Settings" class="px-6 py-5">
                <div class="flex gap-6 items-center">
                    <img src="{{ route('index') }}" class="w-[15px] h-[15px]" />
                    <p class="text-xl font-medium">Settings</p>
                </div>
                <div class="flex flex-col justify-start mt-4 ml-11">
                    @if (Auth::user()->role == 'Admin')
                        <a href="{{ route('Company.index') }}" class="mb-2">
                            <p class="text-[#000000] font-medium text-base text-left">
                                Admin Settings
                            </p>
                        </a>
                    @endif
                    <a href="{{ route('manage-people') }}" class="mb-2">
                        <p class="text-[#000000] font-medium text-base text-left">
                            Manage People
                        </p>
                    </a>
                    <a href="{{ route('Team.index') }}" class="mb-2">
                        <p class="text-[#000000] font-medium text-base text-left">
                            Manage Teams
                        </p>
                    </a>
                    <a href="{{ route('Category.index') }}" class="mb-2">
                        <p class="text-[#000000] font-medium text-base text-left">
                            Manage Category
                        </p>
                    </a>
                </div>
            </div>
        </div>


    </div>

    @yield('main-container')

</div>

@include('Layout.footer')
