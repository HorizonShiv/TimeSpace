@extends('Layout.sidebar')

@section('main-container')
    <div class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full" id="content" data-astro-cid-sckkx6r4>
        <div class="flex w-full flex-col gap-5" data-astro-cid-ujfssy6h>
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

            <div class="flex justify-between items-center" data-astro-cid-ujfssy6h>
                <h1 class="text-4xl font-semibold">Campaign Dashboard</h1>

                <div class="flex space-x-4">
                    @if (Auth::user()->role == 'Media' || Auth::user()->role == 'Client')
                        @if (!empty($FlightCount))
                            <a href="{{ route('flight-edit', $Campaigns->id) }}" data-astro-cid-ujfssy6h>
                                <button
                                    class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                                    data-astro-cid-ujfssy6h>
                                    <img src="/assets/sidebar/settings.png" class="w-[20px] h-[20px]"
                                        data-astro-cid-ujfssy6h />
                                    {{-- <font style="color: #ea33c0; font-size: 24px;">+</font> --}}
                                    <p class="text-sm font-medium text-[#555555]" data-astro-cid-ujfssy6h>
                                        @if (Auth::user()->role == 'Client')
                                            View Flights
                                        @else
                                            Edit Flights
                                        @endif
                                    </p>
                                </button>
                            </a>

                            @if (!empty($AssetsCount))
                                <a href="{{ route('assets-edit', $Campaigns->id) }}" data-astro-cid-ujfssy6h>
                                    <button
                                        class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                                        data-astro-cid-ujfssy6h>
                                        <img src="/assets/sidebar/settings.png" class="w-[20px] h-[20px]"
                                            data-astro-cid-ujfssy6h />
                                        {{-- <font style="color: #ea33c0; font-size: 24px;">+</font> --}}
                                        <p class="text-sm font-medium text-[#555555]" data-astro-cid-ujfssy6h>
                                            @if (Auth::user()->role == 'Client')
                                                View Assets
                                            @else
                                                Edit Assets
                                            @endif
                                        </p>
                                    </button>
                                </a>
                            @else
                                @if (Auth::user()->role == 'Media')
                                    <a href="{{ route('assets-create', $Campaigns->id) }}" data-astro-cid-ujfssy6h>
                                        <button
                                            class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                                            data-astro-cid-ujfssy6h>
                                            {{-- <img src="/assets/sidebar/settings.png" class="w-[20px] h-[20px]" data-astro-cid-ujfssy6h /> --}}
                                            <font style="color: #ea33c0; font-size: 24px;">+</font>
                                            <p class="text-sm font-medium text-[#555555]" data-astro-cid-ujfssy6h>
                                                Add Assets
                                            </p>
                                        </button>
                                    </a>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('flight-create', $Campaigns->id) }}" data-astro-cid-ujfssy6h>
                                <button
                                    class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                                    data-astro-cid-ujfssy6h>
                                    <font style="color: #ea33c0; font-size: 24px;">+</font>

                                    <p class="text-sm font-medium text-[#555555]" data-astro -cid-ujfssy6h>
                                        Add Flights
                                    </p>
                                </button>
                            </a>
                        @endif
                    @endif
                </div>
            </div>


            <div class="flex justify-between items-end" id="campagin-head" data-astro-cid-ujfssy6h>
                <div class="flex gap-3" id="65eabceab50bda877e811103" data-astro-cid-ujfssy6h>
                    @if (!empty($Campaigns->image))
                        <img src="/campaignHeaderImage/{{ $Campaigns->id }}/{{ $Campaigns->image ?? '' }}"
                            class="w-[80px] h-[80px] rounded-xl" data-astro-cid-ujfssy6h />
                    @else
                        <img src="/campaignHeaderImage/draft.png" class="w-[80px] h-[80px] rounded-xl"
                            data-astro-cid-ujfssy6h />
                    @endif
                    <div class="flex flex-col gap-1" data-astro-cid-ujfssy6h>
                        <p class="text-xl font-semibold" data-astro-cid-ujfssy6h>
                            {{ $Campaigns->User->name ?? '' }}
                        </p>
                        <h2 class="text-4xl font-medium" data-astro-cid-ujfssy6h>
                            {{ $Campaigns->campaign_name ?? '' }}
                        </h2>
                    </div>
                </div>
                <div class="flex gap-3" data-astro-cid-ujfssy6h>
                    <div class="join" data-astro-cid-ujfssy6h>
                        @if (empty($FlightCount))
                            <input
                                class="join-item btn border-accent bg-white compoenent-btn px-5 hover:bg-white hover:border-accent"
                                type="radio" name="options" aria-label="Visual View" id="component1"
                                onclick="btn1Clicked()" data-astro-cid-ujfssy6h />
                        @endif
                        @if (!empty($FlightCount))
                            <input
                                class="join-item btn rounded-l-full border-accent bg-white compoenent-btn px-5 hover:bg-white hover:border-accent"
                                type="radio" name="options" aria-label="Visual View" id="component1"
                                onclick="btn1Clicked()" data-astro-cid-ujfssy6h />

                            @if (!empty($AssetsCount))
                                <input
                                    class="join-item btn border-accent bg-white compoenent-btn px-5 hover:bg-white hover:border-accent"
                                    type="radio" name="options" aria-label="List View" id="component2" onclick="clicked()"
                                    data-astro-cid-ujfssy6h />

                                <input
                                    class="join-item btn rounded-r-full border-accent bg-white compoenent-btn px-5 hover:bg-white hover:border-accent"
                                    type="radio" name="options" aria-label="Blocking Chart" id="component3"
                                    onclick="clicked()" data-astro-cid-ujfssy6h />
                            @endif
                        @endif
                    </div>
                    <div class="hidden mt-1 cursor-pointer" id="add" onclick="togglehead()" data-astro-cid-ujfssy6h>
                        <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="40"
                            height="40" viewBox="0 0 24 24" fill="none" data-astro-cid-ujfssy6h>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.25 12.75V18H12.75V12.75H18V11.25H12.75V6H11.25V11.25H6V12.75H11.25Z" fill="#ea33c0"
                                data-astro-cid-ujfssy6h></path>
                        </svg>
                    </div>
                    <div class="mt-1 cursor-pointer" id="close" onclick="togglehead()" data-astro-cid-ujfssy6h>
                        <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 -0.5 25 25" fill="none" width="40" height="40" data-astro-cid-ujfssy6h>
                            <path
                                d="M6.96967 16.4697C6.67678 16.7626 6.67678 17.2374 6.96967 17.5303C7.26256 17.8232 7.73744 17.8232 8.03033 17.5303L6.96967 16.4697ZM13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697L13.0303 12.5303ZM11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303L11.9697 11.4697ZM18.0303 7.53033C18.3232 7.23744 18.3232 6.76256 18.0303 6.46967C17.7374 6.17678 17.2626 6.17678 16.9697 6.46967L18.0303 7.53033ZM13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303L13.0303 11.4697ZM16.9697 17.5303C17.2626 17.8232 17.7374 17.8232 18.0303 17.5303C18.3232 17.2374 18.3232 16.7626 18.0303 16.4697L16.9697 17.5303ZM11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697L11.9697 12.5303ZM8.03033 6.46967C7.73744 6.17678 7.26256 6.17678 6.96967 6.46967C6.67678 6.76256 6.67678 7.23744 6.96967 7.53033L8.03033 6.46967ZM8.03033 17.5303L13.0303 12.5303L11.9697 11.4697L6.96967 16.4697L8.03033 17.5303ZM13.0303 12.5303L18.0303 7.53033L16.9697 6.46967L11.9697 11.4697L13.0303 12.5303ZM11.9697 12.5303L16.9697 17.5303L18.0303 16.4697L13.0303 11.4697L11.9697 12.5303ZM13.0303 11.4697L8.03033 6.46967L6.96967 7.53033L11.9697 12.5303L13.0303 11.4697Z"
                                fill="#ea33c0" data-astro-cid-ujfssy6h></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="flex visual-view-head justify-between" id="visual-view-head" data-astro-cid-ih4xnkm6>
                <div class="flex flex-col w-full" data-astro-cid-ih4xnkm6>
                    <div class="flex gap-8" data-astro-cid-ih4xnkm6>
                        <div class="flex flex-col gap-5" data-astro-cid-ih4xnkm6>
                            <div class="flex flex-col gap-1 w-full">
                                <p class="text-sm font-medium">Project Number</p>
                                <p class="text-base font-medium">{{ $Campaigns->project_code }}</p>
                            </div>
                            <div class="flex flex-col gap-1 w-full">
                                <p class="text-sm font-medium">Total Flights</p>
                                <p class="text-base font-medium">{{ $FlightCount }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-5" data-astro-cid-ih4xnkm6>
                            <div class="flex flex-col gap-1 w-full">
                                <p class="text-sm font-medium">Total Budget</p>
                                <p class="text-base font-medium">${{ $Campaigns->budget }}</p>
                            </div>
                            <div class="flex flex-col gap-1 w-full">
                                <p class="text-sm font-medium">Languages</p>
                                <p class="text-base font-medium">
                                    @foreach ($Campaigns->CampaignLanguages as $lang)
                                        {{ $lang->language }}
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-5" data-astro-cid-ih4xnkm6>
                            <div class="flex flex-col gap-1 w-full">
                                <p class="text-sm font-medium">In Market Date</p>
                                <p class="text-base font-medium">Not Set Yet</p>
                            </div>
                            <div class="flex flex-col gap-1 w-full">
                                <p class="text-sm font-medium">Team</p>
                                <div class="flex gap-1" data-astro-cid-ih4xnkm6>
                                    @if (!empty($Campaigns->CampaignMember))
                                        @foreach ($Campaigns->CampaignMember as $member)
                                            <div
                                                class="bg-[#c72ba4] flex justify-center items-center text-white w-8 h-8 rounded-full font-semibold border border-[#ea33c0]">
                                                {{ strtoupper(substr($member->User->name, 0, 2)) }}
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col mt-6 gap-3" data-astro-cid-ih4xnkm6>
                        <p class="text-sm font-medium">Ad Types</p>
                        <div class="flex gap-1" data-astro-cid-ih4xnkm6>
                            @foreach ($Campaigns->Flight as $Flights)
                                @foreach ($Flights->FlightConnection as $Connection)
                                    @foreach ($Connection->Assets as $Asset)
                                        @foreach (\App\Models\AdvertisementType::where('id', $Asset->advertisement_id)->get() as $AdvertisementType)
                                            <span
                                                class="badge badge-outline p-3 border border-[#bababa] text-sm text-[#555555]">
                                                {{ $AdvertisementType->name }}
                                            </span>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="flex flex-col w-full gap-4" data-astro-cid-ih4xnkm6>
                    <div class="flex justify-between" data-astro-cid-ih4xnkm6>
                        <div class="flex flex-col gap-2" data-astro-cid-ih4xnkm6>
                            <p class="text-xl font-medium" data-astro-cid-ih4xnkm6>
                                Status Tracker
                            </p>
                            <div class="flex gap-1" data-astro-cid-ih4xnkm6>
                                <span class="badge bg-[#555555] text-white p-3 text-sm" data-astro-cid-ih4xnkm6>
                                    All Flights
                                </span>
                                @foreach ($Campaigns->Flight as $Flight)
                                    <span class="badge bg-[#dddddd] p-3 text-sm">
                                        Flight {{ $Flight->flight_count }}
                                    </span>
                                @endforeach

                            </div>
                        </div>
                        <div class="flex flex-col items-center" data-astro-cid-ih4xnkm6>
                            <p class="text-4xl font-semibold" data-astro-cid-ih4xnkm6>
                                {{ $AssetsCount }}
                            </p>
                            <p class="text-base font-medium" data-astro-cid-ih4xnkm6>
                                Total Assets
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2" data-astro-cid-ih4xnkm6>
                        <div class="flex gap-2 items-center" data-astro-cid-ih4xnkm6>
                            <p class="text-base font-medium w-32" data-astro-cid-ih4xnkm6>
                                Briefed
                            </p>
                            <div class="w-full bg-gray-200 rounded-full h-6 relative" data-astro-cid-ih4xnkm6>
                                <progress class="w-full h-full rounded-full" value="200" max="200"
                                    id="progress-1" data-astro-cid-ih4xnkm6></progress>
                                <div class="absolute top-0 left-0 h-full w-full rounded-full flex justify-between items-center px-3"
                                    data-astro-cid-ih4xnkm6>
                                    <img src="/assets/icons/task_fill.png" alt="create campaign" class="w-3"
                                        data-astro-cid-ih4xnkm6 />
                                    <img src="/assets/icons/done.png" alt="create campaign" class="w-3"
                                        data-astro-cid-ih4xnkm6 />
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 items-center" data-astro-cid-ih4xnkm6>
                            <p class="text-base font-medium w-32" data-astro-cid-ih4xnkm6>
                                In Progress
                            </p>
                            <div class="w-full bg-gray-200 rounded-full h-6 relative" data-astro-cid-ih4xnkm6>
                                <progress class="w-full h-full rounded-full" value="200" max="200"
                                    id="progress-2" data-astro-cid-ih4xnkm6></progress>
                                <div class="absolute top-0 left-0 h-full w-full rounded-full flex justify-between items-center px-3"
                                    data-astro-cid-ih4xnkm6>
                                    <img src="/assets/icons/emoji_objects.png" alt="create campaign" class="w-3"
                                        data-astro-cid-ih4xnkm6 />
                                    <img src="/assets/icons/done.png" alt="create campaign" class="w-3"
                                        data-astro-cid-ih4xnkm6 />
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 items-center" data-astro-cid-ih4xnkm6>
                            <p class="text-base font-medium w-32" data-astro-cid-ih4xnkm6>
                                In Review
                            </p>
                            <div class="w-full bg-gray-200 rounded-full h-6 relative" data-astro-cid-ih4xnkm6>
                                <progress class="w-full h-full rounded-full" value="100" max="200"
                                    id="progress-3" data-astro-cid-ih4xnkm6></progress>
                                <div class="absolute top-0 left-0 h-full w-full rounded-full flex gap-14 items-center px-3"
                                    data-astro-cid-ih4xnkm6>
                                    <img src="/assets/icons/rate_review.png" alt="create campaign" class="w-3"
                                        data-astro-cid-ih4xnkm6 />
                                    <p data-astro-cid-ih4xnkm6>100</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 items-center" data-astro-cid-ih4xnkm6>
                            <p class="text-base font-medium w-32" data-astro-cid-ih4xnkm6>
                                Approved
                            </p>
                            <div class="w-full bg-gray-200 rounded-full h-6 relative" data-astro-cid-ih4xnkm6>
                                <progress class="w-full h-full rounded-full" value="45" max="200"
                                    id="progress-4" data-astro-cid-ih4xnkm6></progress>
                                <div class="absolute top-0 left-0 h-full w-full rounded-full flex gap-10 items-center px-3"
                                    data-astro-cid-ih4xnkm6>
                                    <img src="/assets/icons/check_circle.png" alt="create campaign" class="w-3"
                                        data-astro-cid-ih4xnkm6 />
                                    <p data-astro-cid-ih4xnkm6>45</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 items-center" data-astro-cid-ih4xnkm6>
                            <p class="text-base font-medium w-32" data-astro-cid-ih4xnkm6>
                                Trafficking
                            </p>
                            <div class="w-full bg-gray-200 rounded-full h-6 relative" data-astro-cid-ih4xnkm6>
                                <progress class="w-full h-full rounded-full" value="15" max="200"
                                    id="progress-5" data-astro-cid-ih4xnkm6></progress>
                                <div class="absolute top-0 left-0 h-full w-full rounded-full flex gap-3 items-center px-3"
                                    data-astro-cid-ih4xnkm6>
                                    <img src="/assets/icons/check_circle.png" alt="create campaign" class="w-3"
                                        data-astro-cid-ih4xnkm6 />
                                    <p data-astro-cid-ih4xnkm6>0</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 items-center" data-astro-cid-ih4xnkm6>
                            <p class="text-base font-medium w-32" data-astro-cid-ih4xnkm6>
                                Live
                            </p>
                            <div class="w-full bg-gray-200 rounded-full h-6 relative" data-astro-cid-ih4xnkm6>
                                <progress class="w-full h-full rounded-full" value="15" max="200"
                                    id="progress-6" data-astro-cid-ih4xnkm6></progress>
                                <div class="absolute top-0 left-0 h-full w-full rounded-full flex gap-3 items-center px-3"
                                    data-astro-cid-ih4xnkm6>
                                    <img src="/assets/icons/check_circle.png" alt="create campaign" class="w-3"
                                        data-astro-cid-ih4xnkm6 />
                                    <p data-astro-cid-ih4xnkm6>0</p>
                                </div>
                            </div>
                        </div>
                        <!-- <ProgressBarWithLabel title="Briefed" value={200} bgColor="#FFE348" /> -->
                        <!-- <ProgressBarWithLabel title="In Progress" value={200} bgColor="#FFAB48" /> -->
                        <!-- <ProgressBarWithLabel title="In Review" value={100} bgColor="#EB6E6E" /> -->
                        <!-- <ProgressBarWithLabel title="Approved" value={45} bgColor="#D4E507" /> -->
                        <!-- <ProgressBarWithLabel title="Trafficking" value={10} bgColor="#84A0FF" /> -->
                        <!-- <ProgressBarWithLabel title="Live" value={10} bgColor="#4ED5E6" /> -->
                    </div>
                </div>
            </div>
            <div class="bg-[#EA33C0] h-[2px]" data-astro-cid-ujfssy6h></div>
        </div>
        <div id="component1" class="component" data-astro-cid-ujfssy6h>
            <div data-astro-cid-iujjydvd>
                <div class="flex justify-between gap-3 my-10 items-center" data-astro-cid-iujjydvd>
                    <div class="flex gap-3" data-astro-cid-iujjydvd>
                        <p class="text-xl font-normal" data-astro-cid-iujjydvd>
                            Filter by:</p>
                        <select id="Flight_id" name="Flight_id" onchange="getFlightData()"
                            class="select select-primary rounded-full bg-white w-48" data-astro-cid-iujjydvd>
                            @php
                                $num = 1;
                            @endphp
                            @foreach ($Campaigns->Flight as $Flight)
                                <option value="{{ $Flight->id }}">Flight {{ $num }}</option>
                                @php
                                    $num++;
                                @endphp
                            @endforeach

                        </select>
                        <select class="select select-primary rounded-full bg-white w-48" data-astro-cid-iujjydvd>
                            <option disabled selected data-astro-cid-iujjydvd>
                                Language
                            </option>
                            <option data-astro-cid-iujjydvd>English</option>
                            <option data-astro-cid-iujjydvd>French</option>
                        </select>
                    </div>

                    <div class="flex gap-3" data-astro-cid-iujjydvd>
                        <label for="imageUpload">Edit Image</label>
                        <input type="file" id="imageUpload" style="display: none" />
                        @if (!empty($Campaigns->image))
                            <img id="previewImage" width="50px" height="30px"
                                src="/campaignHeaderImage/{{ $Campaigns->id }}/{{ $Campaigns->image ?? '' }}"
                                alt="Preview Image" />
                        @else
                            <img id="previewImage" width="50px" height="30px" src="/campaignHeaderImage/draft.png"
                                alt="Preview Image" />
                        @endif
                    </div>
                </div>



                {{-- @if ($enCounts['Awareness'] != 0 || $enCounts['Consideration'] != 0 || $enCounts['Trail'] != 0) --}}
                <div class="flex flex-col w-full gap-10" data-astro-cid-iujjydvd>
                    {{-- English Assest Dashboard --}}
                    <div class="flex flex-col w-full gap-2">
                        <div class="flex flex-col w-full">
                            <h6 class="font-medium text-3xl">English</h6>
                            <div class="divider"></div>
                        </div>
                        <div class="grid grid-cols-3 gap-10">
                            {{-- @if ($enCounts['Awareness'] != 0) --}}
                            <a
                                href="{{ route('assetsManage', ['id' => $Campaigns->id, 'language' => 'EN', 'type' => 'Awareness', 'flight_id' => '19']) }}">
                                <div class="flex flex-col w-full gap-2">
                                    <div class="flex justify-between">
                                        <h5 class="font-medium text-xl">Awareness</h5>
                                        <p class="font-medium text-xl text-[#555555]" id="EnAwereness">
                                            {{ $enCounts['Awareness'] }}
                                        </p>
                                    </div>
                                    <div class="p-0 flex w-full flex-col gap-5 justify-center items-center h-full card-drop rounded-2xl relative"
                                        data-astro-cid-wwa2csjn="">

                                        @php
                                            $Thumbnails = \App\Models\Thumbnails::where('type', 'Awareness')
                                                ->where('campaign_id', $Campaigns->id)
                                                ->where('language', 'EN')
                                                ->first();
                                        @endphp

                                        @if (!empty($Thumbnails->thumbnail))
                                            <img src="/Thumbnails/{{ $Campaigns->id }}/{{ $Thumbnails->thumbnail ?? '' }}"
                                                alt="Awareness" class="flex h-96 rounded-3xl w-full">
                                        @else
                                            <img src="/campaignHeaderImage/draft.png" alt="Awareness"
                                                class="flex h-96 rounded-3xl w-full" onclick="window.location=''" />
                                        @endif
                                    </div>

                                </div>
                            </a>
                            {{-- @endif --}}

                            {{-- @if ($enCounts['Consideration'] != 0) --}}
                            <a
                                href="{{ route('assetsManage', ['id' => $Campaigns->id, 'language' => 'EN', 'type' => 'Consideration', 'flight_id' => '19']) }}">
                                <div class="flex flex-col w-full gap-2">
                                    <div class="flex justify-between">
                                        <h5 class="font-medium text-xl">Consideration</h5>
                                        <p class="font-medium text-xl text-[#555555]" id="EnConsideration">
                                            {{ $enCounts['Consideration'] }}</p>
                                    </div>
                                    <div class="p-0 flex w-full flex-col gap-5 justify-center items-center h-full card-drop rounded-2xl relative"
                                        data-astro-cid-wwa2csjn="">
                                        @php
                                            $Thumbnails = \App\Models\Thumbnails::where('type', 'Consideration')
                                                ->where('campaign_id', $Campaigns->id)
                                                ->where('language', 'EN')
                                                ->first();
                                        @endphp

                                        @if (!empty($Thumbnails->thumbnail))
                                            <img src="/Thumbnails/{{ $Campaigns->id }}/{{ $Thumbnails->thumbnail ?? '' }}"
                                                alt="Awareness" class="flex h-96 rounded-3xl w-full">
                                        @else
                                            <img src="/campaignHeaderImage/draft.png" alt="Awareness"
                                                class="flex h-96 rounded-3xl w-full" onclick="window.location=''" />
                                        @endif
                                    </div>

                                </div>
                            </a>
                            {{-- @endif --}}

                            {{-- @if ($enCounts['Trail'] != 0) --}}
                            <a
                                href="{{ route('assetsManage', ['id' => $Campaigns->id, 'language' => 'EN', 'type' => 'Trail', 'flight_id' => '19']) }}">
                                <div class="flex flex-col w-full gap-2">
                                    <div class="flex justify-between">
                                        <h5 class="font-medium text-xl">Trail</h5>
                                        <p class="font-medium text-xl text-[#555555]" id="EnTrail">
                                            {{ $enCounts['Trail'] }}</p>
                                    </div>
                                    <div class="p-0 flex w-full flex-col gap-5 justify-center items-center h-full card-drop rounded-2xl relative"
                                        data-astro-cid-wwa2csjn="">
                                        @php
                                            $Thumbnails = \App\Models\Thumbnails::where('type', 'Trail')
                                                ->where('campaign_id', $Campaigns->id)
                                                ->where('language', 'EN')
                                                ->first();
                                        @endphp

                                        @if (!empty($Thumbnails->thumbnail))
                                            <img src="/Thumbnails/{{ $Campaigns->id }}/{{ $Thumbnails->thumbnail ?? '' }}"
                                                alt="Awareness" class="flex h-96 rounded-3xl w-full">
                                        @else
                                            <img src="/campaignHeaderImage/draft.png" alt="Awareness"
                                                class="flex h-96 rounded-3xl w-full" onclick="window.location=''" />
                                        @endif
                                    </div>

                                </div>
                            </a>
                            {{-- @endif --}}
                        </div>
                    </div>
                    {{-- @endif --}}

                    {{-- French Assest Dashboard --}}
                    {{-- @if ($frCounts['Awareness'] != 0 || $frCounts['Consideration'] != 0 || $frCounts['Trail'] != 0) --}}
                    <div class="flex flex-col w-full gap-2">
                        <div class="flex flex-col w-full">
                            <h6 class="font-medium text-3xl">French</h6>
                            <div class="divider"></div>
                        </div>
                        <div class="grid grid-cols-3 gap-10">
                            {{-- @if ($enCounts['Awareness'] != 0) --}}
                            <a
                                href="{{ route('assetsManage', ['id' => $Campaigns->id, 'language' => 'FR', 'type' => 'Awareness', 'flight_id' => '19']) }}">
                                <div class="flex flex-col w-full gap-2">
                                    <div class="flex justify-between">
                                        <h5 class="font-medium text-xl">Awareness</h5>
                                        <p class="font-medium text-xl text-[#555555]" id="FrAwareness">
                                            {{ $frCounts['Awareness'] }}</p>
                                    </div>
                                    @php
                                        $Thumbnails = \App\Models\Thumbnails::where('type', 'Awareness')
                                            ->where('campaign_id', $Campaigns->id)
                                            ->where('language', 'FR')
                                            ->first();
                                    @endphp

                                    @if (!empty($Thumbnails->thumbnail))
                                        <img src="/Thumbnails/{{ $Campaigns->id }}/{{ $Thumbnails->thumbnail ?? '' }}"
                                            alt="Awareness" class="flex h-96 rounded-3xl w-full">
                                    @else
                                        <img src="/campaignHeaderImage/draft.png" alt="Awareness"
                                            class="flex h-96 rounded-3xl w-full" onclick="window.location=''" />
                                    @endif
                                </div>
                            </a>
                            {{-- @endif --}}
                            {{-- @if ($enCounts['Consideration'] != 0) --}}
                            <a
                                href="{{ route('assetsManage', ['id' => $Campaigns->id, 'language' => 'FR', 'type' => 'Consideration', 'flight_id' => '19']) }}">
                                <div class="flex flex-col w-full gap-2">
                                    <div class="flex justify-between">
                                        <h5 class="font-medium text-xl">Consideration</h5>
                                        <p class="font-medium text-xl text-[#555555]" id="FrConsideration">
                                            {{ $frCounts['Consideration'] }}
                                        </p>
                                    </div>
                                    @php
                                        $Thumbnails = \App\Models\Thumbnails::where('type', 'Consideration')
                                            ->where('campaign_id', $Campaigns->id)
                                            ->where('language', 'FR')
                                            ->first();
                                    @endphp

                                    @if (!empty($Thumbnails->thumbnail))
                                        <img src="/Thumbnails/{{ $Campaigns->id }}/{{ $Thumbnails->thumbnail ?? '' }}"
                                            alt="Awareness" class="flex h-96 rounded-3xl w-full">
                                    @else
                                        <img src="/campaignHeaderImage/draft.png" alt="Awareness"
                                            class="flex h-96 rounded-3xl w-full" onclick="window.location=''" />
                                    @endif
                                </div>
                            </a>
                            {{-- @endif --}}
                            {{-- @if ($enCounts['Trail'] != 0) --}}
                            <a
                                href="{{ route('assetsManage', ['id' => $Campaigns->id, 'language' => 'FR', 'type' => 'Trail', 'flight_id' => '19']) }}">
                                <div class="flex flex-col w-full gap-2">
                                    <div class="flex justify-between">
                                        <h5 class="font-medium text-xl">Trail</h5>
                                        <p class="font-medium text-xl text-[#555555]" id="FrTrail">
                                            {{ $frCounts['Trail'] }}</p>
                                    </div>
                                    @php
                                        $Thumbnails = \App\Models\Thumbnails::where('type', 'Trail')
                                            ->where('campaign_id', $Campaigns->id)
                                            ->where('language', 'FR')
                                            ->first();
                                    @endphp

                                    @if (!empty($Thumbnails->thumbnail))
                                        <img src="/Thumbnails/{{ $Campaigns->id }}/{{ $Thumbnails->thumbnail ?? '' }}"
                                            alt="Awareness" class="flex h-96 rounded-3xl w-full">
                                    @else
                                        <img src="/campaignHeaderImage/draft.png" alt="Awareness"
                                            class="flex h-96 rounded-3xl w-full" onclick="window.location=''" />
                                    @endif
                                </div>
                            </a>
                            {{-- @endif --}}

                        </div>
                    </div>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
        <div id="component2" class="component" data-astro-cid-5kgwmqn7>
            <div class="flex gap-3 items-center my-8" data-astro-cid-5kgwmqn7>
                <p data-astro-cid-5kgwmqn7>Filter by:</p>
                <select class="select select-primary w-[150px] rounded-full">
                    <option disabled selected>Status</option>
                    <option>Game of Thrones</option>
                    <option>Lost</option>
                    <option>Breaking Bad</option>
                    <option>Walking Dead</option>
                </select>
                <select class="select select-primary w-[150px] rounded-full">
                    <option disabled selected>Language</option>
                    <option>Game of Thrones</option>
                    <option>Lost</option>
                    <option>Breaking Bad</option>
                    <option>Walking Dead</option>
                </select>
                <select class="select select-primary w-[150px] rounded-full">
                    <option disabled selected>Region</option>
                    <option>North</option>
                    <option>South</option>
                    <option>East</option>
                    <option>West</option>
                </select>
                <select class="select select-primary w-[150px] rounded-full">
                    <option disabled selected>Category</option>
                    <option>Game of Thrones</option>
                    <option>Lost</option>
                    <option>Breaking Bad</option>
                    <option>Walking Dead</option>
                </select>
                <select class="select select-primary w-[150px] rounded-full">
                    <option disabled selected>Publisher</option>
                    <option>Game of Thrones</option>
                    <option>Lost</option>
                    <option>Breaking Bad</option>
                    <option>Walking Dead</option>
                </select>
            </div>
            <div class="join join-vertical w-full" data-astro-cid-5kgwmqn7>

                @foreach ($Campaigns->Flight as $Flights)
                    <div class="collapse collapse-arrow join-item" data-astro-cid-5kgwmqn7>
                        <input type="radio" name="my-accordion-4" {{ $Flights->flight_count == 1 ? 'checked' : '' }}
                            data-astro-cid-5kgwmqn7 />
                        <div class="collapse-title text-xl font-medium">
                            <div class="flex justify-between pb-2 border-b border-b-primary">
                                <p class="text-2xl font-medium"> Flight {{ $Flights->flight_count }}</p>
                                <p class="text-xl font-medium" data-astro-cid-5kgwmqn7>
                                    @php
                                        $flightCounter = 0;
                                        foreach ($Flights->FlightConnection as $Campaign) {
                                            foreach ($Campaigns->Assets as $Assets) {
                                                if ($Assets->flight_connection_id == $Campaign->id) {
                                                    $flightCounter++;
                                                }
                                            }
                                        }
                                    @endphp

                                    {{ $flightCounter }}
                                </p>
                            </div>
                        </div>
                        <div class="collapse-content" data-astro-cid-5kgwmqn7>
                            <div class="overflow-x-auto">
                                <table class="table table-xs">
                                    <thead>
                                        <tr class="border-none">
                                            <th class="text-base font-normal text-black"></th>
                                            <th class="text-base font-normal text-black">
                                                Language
                                            </th>
                                            <th class="text-base font-normal text-black">
                                                Targeting
                                            </th>
                                            <th class="text-base font-normal text-black">
                                                Category
                                            </th>
                                            <th class="text-base font-normal text-black">Region</th>
                                            <th class="text-base font-normal text-black">
                                                Publisher
                                            </th>
                                            <th class="text-base font-normal text-black">
                                                Ad Type
                                            </th>
                                            <th class="text-base font-normal text-black">
                                                Due Date
                                            </th>
                                            <th class="text-base font-normal text-black">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Flights->FlightConnection as $Campaign)
                                            @foreach ($Campaigns->Assets as $Assets)
                                                @if ($Assets->flight_connection_id == $Campaign->id)
                                                    <tr class="border-none">
                                                        <td>
                                                            <img src="/campaignHeaderImage/{{ $Campaigns->id }}/{{ $Campaigns->image ?? '' }}"
                                                                class="w-8 h-8 rounded-sm" />
                                                        </td>
                                                        <td class="text-base font-normal text-black">EN</td>
                                                        <td class="text-base font-normal text-black">
                                                            {{ $Campaign->type }}
                                                        </td>
                                                        <td class="text-base font-normal text-black">
                                                            {{-- {{ $Campaign->CategoryMaster->name }} --}}
                                                            {{-- {{ $Assets->AdvertisementType->CategoryMaster->name }} --}}
                                                        </td>
                                                        <td class="text-base font-normal text-black">
                                                            {{ $Campaign->location }}
                                                        </td>
                                                        <td class="text-base font-normal text-black">

                                                            @if (is_numeric($Assets->publisher_id))
                                                                {{ $Assets->AdvertisementType->PublisherMaster->name }}
                                                            @else
                                                                {{ $Assets->publisher_id }}
                                                            @endif


                                                        </td>
                                                        <td class="text-base font-normal text-black">
                                                            {{ $Assets->AdvertisementType->name ?? '' }}</td>
                                                        <td class="text-base font-normal text-black">
                                                            {{ $Assets->due_to_publisher ?? '' }}
                                                        </td>
                                                        <td class="flex">
                                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                                class="w-6 h-6" />
                                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                                class="w-6 h-6" />
                                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                                class="w-6 h-6" />
                                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                                class="w-6 h-6" />
                                                            <img src="/assets/home/card/Icon4.svg" alt="create campaign"
                                                                class="w-6 h-6" />
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div id="component3" class="component" data-astro-cid-d5voxaj5>
            <div class="flex gap-3 items-center my-8" data-astro-cid-d5voxaj5>
                <p data-astro-cid-d5voxaj5>Filter by:</p>
                <select class="select select-primary w-[150px] rounded-full">
                    <option disabled selected>All</option>
                    <option>Game of Thrones</option>
                    <option>Lost</option>
                    <option>Breaking Bad</option>
                    <option>Walking Dead</option>
                </select>
            </div>
            <!-- component -->
            <div class="flex w-full">
                <div class="flex flex-col w-full max-w-[80vw] overflow-x-scroll" id="calendar-view">
                    <div class="flex w-full h-24" id="calendar-head">
                        <div class="flex-initial">
                            <p class="text-lg font-medium w-36">Category</p>
                        </div>
                        <div class="flex-initial">
                            <p class="text-lg font-medium text-center w-24">Assets</p>
                        </div>
                        <div id="dateMapBody" class="flex w-full gap-3 px-3 h-full flex-grow">
                            <!-- Date map will be populated here -->
                        </div>
                    </div>
                    <!-- <div class="bg-gray-300 pl-6 rounded-xl my-3 w-full line">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <p class="text-sm font-medium">English / Flight 1</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div> -->
                    <div class="flex flex-col w-full gap-5">
                        <!-- Awareness -->
                        <div class="flex flex-col w-full">
                            <div class="flex w-full h-12">
                                <div class="flex-initial w-36">
                                    <h6 class="text-lg font-semibold">Awareness</h6>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <h6 class="text-lg font-semibold">65</h6>
                                </div>
                                <div class="flex-grow"></div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Facebook Feed</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">45</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#FFE348] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">
                                        Facebook Collection
                                    </p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">2</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#FFE348] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Instagram Stories</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">2</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-red-200 rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Instagram Feed</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">5</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#FFE348] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Instagram Reels</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">2</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-red-200 rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Pinterest</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">10</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#FFE348] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Youtube Preroll</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">1</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-red-200 rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">:15s TV CTV</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">1</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#FFE348] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">:30s Radio</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">1</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-red-200 rounded-xl"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Consideration -->
                        <div class="flex flex-col w-full">
                            <div class="flex w-full h-12">
                                <div class="flex-initial w-36">
                                    <h6 class="text-lg font-semibold">Consideration</h6>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <h6 class="text-lg font-semibold">25</h6>
                                </div>
                                <div class="flex-grow"></div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Facebook Feed</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">5</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#DDDDDD] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">
                                        Facebook Collection
                                    </p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">10</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#DDDDDD] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Instagram Stories</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">10</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#DDDDDD] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Trial -->
                        <div class="flex flex-col w-full">
                            <div class="flex w-full h-12">
                                <div class="flex-initial w-36">
                                    <h6 class="text-lg font-semibold">Trial</h6>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <h6 class="text-lg font-semibold">35</h6>
                                </div>
                                <div class="flex-grow"></div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Facebook Feed</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">5</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#DDDDDD] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">
                                        Facebook Collection
                                    </p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">10</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#DDDDDD] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Instagram Stories</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">10</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#DDDDDD] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="bg-gray-300 pl-6 rounded-xl my-3 w-full line">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <p class="text-sm font-medium">English / Flight 1</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div> -->
                    <div class="flex flex-col w-full gap-5">
                        <!-- Awareness -->
                        <div class="flex flex-col w-full">
                            <div class="flex w-full h-12">
                                <div class="flex-initial w-36">
                                    <h6 class="text-lg font-semibold">Awareness</h6>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <h6 class="text-lg font-semibold">65</h6>
                                </div>
                                <div class="flex-grow"></div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Facebook Feed</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">45</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#FFE348] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">
                                        Facebook Collection
                                    </p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">2</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#FFE348] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Instagram Stories</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">2</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-red-200 rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Instagram Feed</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">5</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#FFE348] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Instagram Reels</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">2</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-red-200 rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Pinterest</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">10</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#FFE348] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">Youtube Preroll</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">1</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-red-200 rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">:15s TV CTV</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">1</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-[#FFE348] rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                </div>
                            </div>
                            <div class="flex w-full h-8">
                                <div class="flex-initial w-36">
                                    <p class="text-sm font-medium h-12">:30s Radio</p>
                                </div>
                                <div class="flex-initial w-24 mx-auto flex justify-center">
                                    <p class="text-sm font-medium h-12">1</p>
                                </div>
                                <div class="flex-grow flex gap-0">
                                    <div class="calendar-line-data w-full h-5 bg-sky-200 rounded-xl"></div>
                                    <div class="calendar-line-data w-full h-5 bg-red-200 rounded-xl"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <!-- <div class="flex flex-col w-full relative">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="flex flex-col" id="calendar-head">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <div id="lineContainer">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="line w-full h-10 bg-red-700 mb-10"></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="line w-full h-10 bg-red-700 mb-10"></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="line w-full h-10 bg-red-700 mb-10"></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          </div> -->
            </div>
            <script type="text/javascript">
                function createMap() {
                    const today = new Date();
                    const endOfYear = new Date(today.getFullYear(), 11, 31); // December is 11th month
                    const dateMapBody = document.getElementById("dateMapBody");

                    let currentMonth = "";
                    let monthDiv = null;
                    let flexDiv = null;

                    while (today <= endOfYear) {
                        const dayOfWeek = today.getDay();
                        if (dayOfWeek !== 0 && dayOfWeek !== 6) {
                            // Exclude Saturday (6) and Sunday (0)
                            const dayOfMonth = today.getDate();
                            const month = today.toLocaleString("default", {
                                month: "long",
                            });

                            if (month !== currentMonth) {
                                currentMonth = month;
                                if (monthDiv) {
                                    dateMapBody.appendChild(monthDiv);
                                }
                                monthDiv = document.createElement("div");
                                monthDiv.className = "box flex flex-col";
                                monthDiv.innerHTML = `<div class="month text-center">${month}</div>`;
                                flexDiv = document.createElement("div");
                                flexDiv.className = "flex gap-3";
                                monthDiv.appendChild(flexDiv);
                            }

                            const row = document.createElement("div");
                            row.className = "data";

                            const dateCell = document.createElement("div");
                            dateCell.className = "date";
                            dateCell.textContent = dayOfMonth;

                            const dayCell = document.createElement("div");
                            dayCell.className = "day";
                            dayCell.textContent = ["S", "M", "T", "W", "T", "F"][
                                dayOfWeek
                            ];

                            row.appendChild(dateCell);
                            row.appendChild(dayCell);
                            flexDiv.appendChild(row);
                        }
                        today.setDate(today.getDate() + 1);
                    }

                    if (monthDiv) {
                        dateMapBody.appendChild(monthDiv);
                    }

                    const containerWidth =
                        document.querySelector("#calendar-head").scrollWidth;

                    const lines = document.querySelectorAll(".line");
                    lines.forEach(function(line) {
                        line.style.width = containerWidth + "px";
                    });

                    // const data = document.querySelectorAll(".calendar-line-data");

                    // data.forEach(function (data) {
                    //   data.style.width = dateMapBody.scrollWidth + "px";
                    // });
                }

                window.onload = createMap;
            </script>
            <!-- <script type="text/javascript">
                function createMap() {
                    const today = new Date();
                    const endOfYear = new Date(today.getFullYear(), 11, 31); // December is 11th month
                    const dateMapBody = document.getElementById("dateMapBody");

                    while (today <= endOfYear) {
                        const dayOfWeek = today.getDay();
                        if (dayOfWeek !== 0 && dayOfWeek !== 6) {
                            // Exclude Saturday (6) and Sunday (0)
                            const row = document.createElement("div");

                            row.className = "calendar-table-row";

                            const dateCell = document.createElement("p");
                            const dayCell = document.createElement("p");

                            let monthCell = document.createElement("p");

                            const dayOfMonth = today.getDate();

                            if (dayOfMonth === 1) {
                                monthCell = document.createElement("p");
                                monthCell.textContent = today.toLocaleString("default", {
                                    month: "long",
                                });
                                row.appendChild(monthCell);
                            }

                            dateCell.textContent = dayOfMonth;
                            dayCell.textContent = ["S", "M", "T", "W", "T", "F"][dayOfWeek];

                            row.appendChild(dateCell);
                            row.appendChild(dayCell);
                            dateMapBody.appendChild(row);
                        }
                        today.setDate(today.getDate() + 1);
                    }


                }



                window.onload = createMap;
            </script> -->
        </div>
    </div>

    <script>
        window.onload = function() {
            getFlightData();
        };

        function getFlightData() {

            var Flight_id = document.getElementById('Flight_id').value;
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '{{ route('getFlightData') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    flightId: Flight_id,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(result) {
                    // Update English counts
                    $('#EnAwereness').html(result.enCounts.Awareness);
                    $('#EnConsideration').html(result.enCounts.Consideration);
                    $('#EnTrail').html(result.enCounts.Trail);

                    // Update French counts
                    $('#FrAwereness').html(result.frCounts.Awareness);
                    $('#FrConsideration').html(result.frCounts.Consideration);
                    $('#FrTrail').html(result.frCounts.Trail);
                }
            });

        }
    </script>

    <script type="text/javascript">
        const buttons = document.querySelectorAll("input.compoenent-btn");

        document.addEventListener("DOMContentLoaded", function() {
            const componentButtons = document.querySelectorAll(".compoenent-btn");
            const components = document.querySelectorAll(".component");

            // Show component 1 by default
            showComponent("1");

            componentButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    const componentId = this.id.replace("component", "");
                    showComponent(componentId);
                });
            });

            function showComponent(componentId) {
                components.forEach(function(component) {
                    const compId = component.id.replace("component", "");
                    if (compId === componentId) {
                        component.style.display = "block";
                    } else {
                        component.style.display = "none";
                    }
                });
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            const button = document.getElementById("component1"); // Assuming this is the button you want to modify

            // Change background color to white
            button.style.backgroundColor = "#c72ba4";

            // Change text color to white
            button.style.color = "#ffffff";

        });


        // Button toggle color change
        function clicked() {
            const btn1 = document.getElementById('component1');
            // Change background color to white
            btn1.style.backgroundColor = "#ffffff";

            // Change text color to white
            btn1.style.color = "#100101";

        }

        function btn1Clicked() {
            const btn1 = document.getElementById('component1');
            // Change background color to white
            btn1.style.backgroundColor = "#c72ba4";

            // Change text color to white
            btn1.style.color = "#ffffff";

        }

        const toogleComponent = (id) => {
            const components = document.querySelectorAll(".component");
            components.forEach((component) => {
                if (component.id === id) {
                    const tabnumber = component.id.split("component")[1];
                    component.style.display = "block";
                    url.searchParams.set("tab", tabnumber);

                    if (windowPath === url.pathname) {
                        window.history.pushState({}, "", url);
                    } else {
                        window.location.assign(url);
                    }

                    if (tabnumber != "1") {
                        document.querySelector(".visual-view-head").classList.add("hidden");
                        closehead();
                    }
                } else {
                    component.style.display = "none";
                }
            });
        };

        buttons.forEach((button) => {
            button.addEventListener("click", () => {
                toogleComponent(button.id);
            });
        });

        const visualViewHead = document.querySelector(".visual-view-head");

        function togglehead() {
            // hide or show the visual view head
            document.querySelector(".visual-view-head").classList.toggle("hidden");

            // hide and show the add and close button
            if (visualViewHead.classList.contains("hidden")) {
                closehead();
            } else {
                openhead();
            }
        }

        function closehead() {
            document.getElementById("add").classList.remove("hidden");
            document.getElementById("close").classList.add("hidden");
        }

        function openhead() {
            document.getElementById("add").classList.add("hidden");
            document.getElementById("close").classList.remove("hidden");
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#imageUpload').change(function() {
                var CampaignId = <?php echo $Campaigns->id; ?>;
                var imageUpload = $('#imageUpload').prop('files')[0];
                var formData = new FormData();

                if (typeof imageUpload !== 'undefined') {
                    formData.append('imageUpload', imageUpload);
                }
                formData.append('campaignId', CampaignId);
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: "{{ route('imageUpdate') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            location.reload();
                        } else {
                            console.error('Error storing user:', response.error);
                        }
                    }
                });
            });
        });
    </script>

@endsection
