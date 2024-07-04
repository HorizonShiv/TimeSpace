@extends('Layout.sidebar')

@section('main-container')
    <div class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full" id="content" data-astro-cid-sckkx6r4>
        <div data-astro-cid-jf5gi763>
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
            <div class="flex justify-between" data-astro-cid-jf5gi763>
                <h1 class="text-4xl font-semibold">Account Setting</h1>
            </div>
            <div class="my-7" data-astro-cid-jf5gi763>
                <div class="flex flex-col w-full gap-7 mt-5">
                    <div class="flex gap-7 justify-start">
                        <div class="flex flex-col gap-1 mt-5">
                            <text class="text-3xl">Account preference</text>
                        </div>
                    </div>
                    <div class="bg-[#EA33C0] h-[2px]"></div>
                </div>
            </div>
            <div data-astro-cid-jf5gi763>
                <div class="flex gap-7 justify-start">
                    <div class="flex flex-col gap-1">
                        <a href="{{ route('Company.create') }}">
                            <text class="text-1xl">Company Details</text>
                        </a>
                    </div>
                </div>
                <div class="divider my-3" data-astro-cid-jf5gi763></div>

                <div class="flex gap-7 justify-start">
                    <div class="flex flex-col gap-1">
                        <text class="text-1xl">Sign In Security</text>
                    </div>
                </div>
                <div class="divider my-3" data-astro-cid-jf5gi763></div>
            </div>

            <div class="my-7" data-astro-cid-jf5gi763>
                <div class="flex flex-col w-full gap-7 mt-5">
                    <div class="flex gap-7 justify-start">
                        <div class="flex flex-col gap-1 mt-5">
                            <text class="text-3xl">Billing Information</text>
                        </div>
                    </div>
                    <div class="bg-[#EA33C0] h-[2px]"></div>
                </div>
            </div>
            <div data-astro-cid-jf5gi763>
                <div class="flex gap-7 justify-start">
                    <div class="flex flex-col gap-1">
                        <text class="text-1xl">Manage Subscription</text>
                    </div>
                </div>
                <div class="divider my-3" data-astro-cid-jf5gi763></div>

                <div class="flex gap-7 justify-start">
                    <div class="flex flex-col gap-1">
                        <text class="text-1xl">Statement History</text>
                    </div>
                </div>
                <div class="divider my-3" data-astro-cid-jf5gi763></div>
            </div>
        </div>
    </div>
@endsection
