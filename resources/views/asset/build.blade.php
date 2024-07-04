@extends('Layout.sidebar')
@section('addStyleScript')
    <style>
        .custum-file-upload {
            height: 200px;
            width: 300px;
            display: flex;
            flex-direction: column;
            align-items: space-between;
            gap: 20px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            border: 2px dashed #cacaca;
            background-color: rgba(255, 255, 255, 1);
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0px 48px 35px -48px rgba(0, 0, 0, 0.1);
        }

        .custum-file-upload .icon {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custum-file-upload .icon svg {
            height: 80px;
            fill: rgba(75, 85, 99, 1);
        }

        .custum-file-upload .text {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custum-file-upload .text span {
            font-weight: 400;
            color: rgba(75, 85, 99, 1);
        }

        .custum-file-upload input {
            display: none;
        }

        #CodeArea {
            width: 100%;
            height: 350px;
        }

        .uploader-container {
            position: relative;
            width: 200px;
            height: 200px;
            border: 2px dashed #ccc;
            border-radius: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;

        }

        /* .uploader-container {
            display: inline-flex;

            width: 45%;

            margin-right: 2%;

            vertical-align: top;

            border: 1px solid #ccc;

            box-sizing: border-box;

            width: 200px;
            height: 200px;
            border: 2px dashed #ccc;
            border-radius: 15px;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        } */

        .uploader-container:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .uploader-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 18px;
            cursor: pointer;
            color: #ccc;
            visibility: hidden;
        }

        .uploader-content {
            text-align: center;
            cursor: pointer;
            position: relative;
        }

        .uploader-plus {
            font-size: 48px;
            color: #ccc;
        }

        .uploader-text {
            margin-top: 10px;
            font-size: 16px;
            color: #ccc;
        }

        .uploader-input {
            display: none;
        }

        .uploader-preview {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 15px;
        }
    </style>
@endsection

@section('main-container')
    <div class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full" id="content" data-astro-cid-sckkx6r4>
        <div class="flex w-full flex-col gap-5" data-astro-cid-ujfssy6h>
            <div class="flex justify-between" data-astro-cid-ujfssy6h>
                <h1 class="text-4xl font-semibold">Campaign Dashboard</h1>
                <a href="/campaign/65eabceab50bda877e811103/settings/index.html" data-astro-cid-ujfssy6h>
                    <button
                        class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                        data-astro-cid-ujfssy6h>
                        <img src="/assets/sidebar/settings.png" class="w-[20px] h-[20px]" data-astro-cid-ujfssy6h />
                        <p class="text-sm font-medium text-[#555555]" data-astro-cid-ujfssy6h>
                            Campaign Settings
                        </p>
                    </button>
                </a>
            </div>
            <div class="flex justify-between items-end" id="campagin-head" data-astro-cid-ujfssy6h>
                <div class="flex gap-3" id="65eabceab50bda877e811103" data-astro-cid-ujfssy6h>
                    @if (!empty($Campaign->image))
                        <img src="/campaignHeaderImage/{{ $Campaign->id }}/{{ $Campaign->image ?? '' }}"
                            class="w-[80px] h-[80px] rounded-xl" data-astro-cid-ujfssy6h />
                    @else
                        <img src="/campaignHeaderImage/draft.png" class="w-[80px] h-[80px] rounded-xl"
                            data-astro-cid-ujfssy6h />
                    @endif
                    <div class="flex flex-col gap-1" data-astro-cid-ujfssy6h>
                        <p class="text-xl font-semibold" data-astro-cid-ujfssy6h>
                            {{ $Campaign->User->name ?? '' }}
                        </p>
                        <h2 class="text-4xl font-medium" data-astro-cid-ujfssy6h>
                            {{ $Campaign->campaign_name ?? '' }}
                        </h2>
                    </div>
                </div>
                <div class="flex gap-3" data-astro-cid-ujfssy6h>
                    <div class="join" data-astro-cid-ujfssy6h>
                        <input
                            class="join-item btn rounded-l-full border-accent bg-white compoenent-btn px-5 hover:bg-white hover:border-accent"
                            type="radio" name="options" aria-label="Visual View" id="component1" onclick="btn1Clicked()"
                            data-astro-cid-ujfssy6h />
                        <input
                            class="join-item btn border-accent bg-white compoenent-btn px-5 hover:bg-white hover:border-accent"
                            type="radio" name="options" aria-label="List View" id="component2" onclick="clicked()"
                            data-astro-cid-ujfssy6h />
                        <input
                            class="join-item btn rounded-r-full border-accent bg-white compoenent-btn px-5 hover:bg-white hover:border-accent"
                            type="radio" name="options" aria-label="Blocking Chart" id="component3" onclick="clicked()"
                            data-astro-cid-ujfssy6h />
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
                                <p class="text-base font-medium">{{ $Campaign->project_code }}</p>
                            </div>
                            <div class="flex flex-col gap-1 w-full">
                                <p class="text-sm font-medium">Total Flights</p>
                                <p class="text-base font-medium">{{ $FlightCount }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-5" data-astro-cid-ih4xnkm6>
                            <div class="flex flex-col gap-1 w-full">
                                <p class="text-sm font-medium">Total Budget</p>
                                <p class="text-base font-medium">${{ $Campaign->budget }}</p>
                            </div>
                            <div class="flex flex-col gap-1 w-full">
                                <p class="text-sm font-medium">Languages</p>
                                <p class="text-base font-medium">
                                    @foreach ($Campaign->CampaignLanguages as $lang)
                                        {{ $lang->language }}
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-5" data-astro-cid-ih4xnkm6>
                            <div class="flex flex-col gap-1 w-full">
                                <p class="text-sm font-medium">In Market Date</p>
                                <p class="text-base font-medium">12/25/2023 – 02/14/2024</p>
                            </div>
                            <div class="flex flex-col gap-1 w-full">
                                <p class="text-sm font-medium">Team</p>
                                <div class="flex gap-1" data-astro-cid-ih4xnkm6>
                                    @if (!empty($Campaign->CampaignMember))
                                        @foreach ($Campaign->CampaignMember as $member)
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

                            @foreach ($Campaign->Flight as $Flights)
                                @foreach ($Flights->FlightConnection as $Connection)
                                    @foreach ($Connection->Assets as $Asset)
                                        @foreach (\App\Models\AdvertisementType::where('id', $Asset->advertisement_id)->get() as $AdvertisementType)
                                            <span
                                                class="badge badge-outline p-3 border border-[#bababa] text-sm text-[#555555]"
                                                style="text-wrap: nowrap">
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
                                @foreach ($Campaign->Flight as $Flight)
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
            <div class="flex w-full flex-col gap-6 mt-6">
                <a class="flex gap-3 items-center"
                    href="{{ route('assetsManage', ['id' => $id, 'language' => $language, 'type' => $type, 'flight_id' => '1']) }}">
                    <img src="/assets/icons/left_arrow.png" alt="create campaign" class="w-3" />
                    <p class="text-2xl font-medium">{{ $type }}</p>
                </a>
                <div class="flex flex-col gap-1">
                    <p class="font-normal text-base">Ad Type</p>
                    <p class="font-normal text-3xl">{{ $AdvertisementName }}</p>
                </div>
                <div class="divider my-0"></div>
            </div>
            <div class="flex mt-4 gap-4">
                @php
                    $num = 1;
                @endphp


                @foreach ($Assets as $AssetKey => $Asset)
                    @if (!isset($Asset->AssetParameters) || $Asset->AssetParameters->isEmpty())
                        @for ($i = 1; $i <= $Asset->ad_version; $i++)
                            <div id="AssetsLink_{{ $num }}" onclick="toggleAssets({{ $num }})"
                                class="{{ $num == 1 ? 'bg-[#EB6E6E] text-white flex rounded-full px-2 py-1 items-center' : 'bg-[#F7E5D0] flex rounded-full px-2 py-1 items-center' }} cursor-pointer">
                                <span id="AssetsLinkCounter_{{ $num }}"
                                    class="border {{ $num == 1 ? 'bg-[#EB6E6E] border-white flex w-7 h-7 justify-center items-center rounded-full font-medium text-base' : 'bg-[#FFAB48] border-white text-white flex w-7 h-7 justify-center items-center rounded-full font-medium text-base' }} ">{{ $num }}</span>

                                <span class="mx-3 font-medium text-lg">Asset {{ $num }}</span>
                            </div>
                            @php
                                $num++;
                            @endphp
                        @endfor
                    @else
                        @foreach ($Asset->AssetParameters as $AssetParameter)
                            <div id="AssetsLink_{{ $num }}" onclick="toggleAssets({{ $num }})"
                                class="{{ $num == 1 ? 'bg-[#EB6E6E] text-white flex rounded-full px-2 py-1 items-center' : 'bg-[#F7E5D0] flex rounded-full px-2 py-1 items-center' }} cursor-pointer">
                                <span id="AssetsLinkCounter_{{ $num }}"
                                    class="border {{ $num == 1 ? 'bg-[#EB6E6E] border-white flex w-7 h-7 justify-center items-center rounded-full font-medium text-base' : 'bg-[#FFAB48] border-white text-white flex w-7 h-7 justify-center items-center rounded-full font-medium text-base' }} ">{{ $num }}</span>

                                <span class="mx-3 font-medium text-lg">{{ $AssetParameter->ad_title }}</span>
                            </div>
                            @php
                                $num++;
                            @endphp
                        @endforeach
                    @endif
                @endforeach

            </div>

            <form method="post"
                action="{{ route('AssetsStore', ['id' => $id, 'language' => $language, 'type' => $type, 'Adtype' => $Adtype]) }}"
                enctype="multipart/form-data" class="mt-7" data-astro-cid-rwhxyfax>

                <input type="hidden" id="changechecker" name="changechecker" value="0">
                @csrf
                <input type="hidden" value="{{ $Asset->id }}" name="assetsId">
                @method('PUT')
                @php
                    $num = 1;
                @endphp

                @foreach ($Assets as $AssetKey => $Asset)
                    @if ($Asset->AssetParameters->isEmpty())
                        @for ($i = 1; $i <= $Asset->ad_version; $i++)
                            <div id="Asset_{{ $num }}" {{ $num != 1 ? 'hidden' : '' }}>
                                <div
                                    class="flex mt-3 py-4 px-6 justify-between items-center bg-[#EB6E6E] text-white rounded-md">
                                    <div class="flex gap-3 items-center">
                                        <p class="font-normal text-base">Ad Title</p>
                                        <input type="text" name="AdTitle[{{ $num }}]"
                                            placeholder="Tic Tac Tea" value=""
                                            class="input input-bordered w-auto border border-[#dddddd] text-black bg-white h-[40px]" />
                                    </div>
                                    <div class="flex gap-3 items-center">
                                        <p class="text-2xl font-medium">In Draft</p>
                                        <div class="w-9 h-9 rounded-full bg-white flex justify-center items-center">
                                            <img src="/assets/icons/rate_review.png" alt="create campaign"
                                                class="w-5" />
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full flex justify-between my-3">
                                    <p class="font-normal text-3xl">Ad Components</p>
                                    <div>
                                        <button type="submit"
                                            class="btn rounded-full bg-accent text-white no-animation w-36">
                                            Save Asset
                                        </button>
                                    </div>
                                </div>
                                <div class="divider"></div>


                                {{-- Previewer --}}
                                <div
                                    class="w-full min-h-[700px] bg-[#dddddd] rounded-3xl border border-gray-300 p-7 relative my-8">
                                    <div class="flex justify-between w-full">
                                        <div class="flex flex-col gap-3">
                                            <p class="text-xl font-medium">Ad Preview</p>
                                            {{-- <p class="mt-2 text-base font-medium">
                                                Ready to submit for approval?
                                            </p> --}}
                                            <div>
                                                {{-- <button type="button"
                                                    class="btn rounded-full bg-accent text-white no-animation px-5">
                                                    Submit for In progress
                                                </button> --}}
                                            </div>
                                        </div>
                                        <div class="flex">
                                            <p class="text-sm font-medium">Preview Full Screen</p>
                                        </div>
                                    </div>
                                    <div class="absolute top-16 w-full">
                                        <div
                                            class="flex justify-center w-[350px] rounded-3xl border border-accent mx-auto bg-white px-3 py-12">
                                            <div class="border border-accent w-full py-4 px-2">
                                                <div class="flex gap-2 w-full">
                                                    <div class="w-8 h-8 bg-accent rounded-full"></div>
                                                    <div class="flex flex-col">
                                                        <p class="text-sm font-semibold">
                                                            {{ $Campaign->User->name ?? 'Client Name' }}</p>
                                                        <p class="text-xs font-medium text-[#555555]">
                                                            Sponsored
                                                        </p>
                                                    </div>
                                                </div>
                                                <p id="PrimaryTextView_{{ $num }}"
                                                    class="my-3 text-sm font-medium text-[#555555]"
                                                    style="word-wrap: break-word">
                                                    Primary text placeholder.
                                                </p>
                                                <div id="imagePreview_{{ $num }}"
                                                    style="flex-direction:row; overflow: hidden;"
                                                    class="w-full h-[250px] bg-[#dddddd]">
                                                </div>
                                                <div class="w-full p-2 bg-gray-200 mb-20">
                                                    <p id="clickThroughUrlPreview_{{ $num }}"
                                                        class="text-xs font-medium text-[#555555]">
                                                        Clickthroghurl.com
                                                    </p>
                                                    <div class="flex justify-between items-center mb-1">
                                                        <p id="HeadlinePreview_{{ $num }}"
                                                            class="text-xs font-semibold items-center">
                                                            Headline Placehodler to go here.
                                                        </p>
                                                        <p id="CtaPreview_{{ $num }}" type="button"
                                                            class="btn btn-sm bg-[#dddddd] px-7">CTA</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="my-10">
                                    <div class="text-2xl font-medium">
                                        Ad Specs
                                    </div>

                                    <div class="flex gap-10 my-10">
                                        <div class="flex flex-col gap-1">
                                            <p class="text-sm font-medium">Language</p>
                                            <p class="text-base font-medium">{{ $Connection->language }}</p>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <p class="text-sm font-medium">Region</p>
                                            <p class="text-base font-medium">{{ $Connection->location }}</p>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <p class="text-sm font-medium">Ratio</p>
                                            <p class="text-base font-medium">{{ $Asset->ad_format }}</p>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <p class="text-sm font-medium">File Type</p>
                                            <p class="text-base font-medium">{{ $Asset->file_type }}</p>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <p class="text-sm font-medium">Max Size</p>
                                            <p class="text-base font-medium">30</p>
                                        </div>
                                        <div class="flex flex-col ">
                                            <a href="#" class="underline text-gray-500" style="float: right">Link
                                                to
                                                full
                                                specs</a>
                                        </div>
                                    </div>
                                </div>

                                <p class="font-semibold text-xl my-5">Ad Objective</p>
                                <div class="divider mb-5"></div>

                                <div class="flex items-between justify-between gap-8 mb-10" style="width: 85%">
                                    <!-- Item 1 -->
                                    <div class="flex-1 text-left w-40">
                                        <div>
                                            <input type="hidden" name="AssetParametersId[{{ $num }}]"
                                                value=""
                                                class="input input-bordered input-primary w-full rounded-md w-full"
                                                placeholder="Enter valid URL" />
                                            <p class="font-semibold text-base w-64 ">
                                                Conversion Location
                                            </p>
                                            <select name="ConversionLocation[{{ $num }}]"
                                                class="select select-primary w-64 rounded-full">
                                                <option {{-- {{ optional($Asset->AssetParameters)->cta == 'OnYourAd' ? 'Selected' : '' }} --}} value="OnYourAd">On your ad</option>
                                                <option {{-- {{ optional($Asset->AssetParameters)->cta == 'ApplyNow' ? 'Selected' : '' }} --}} value="ApplyNow">Apply Now</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Item 2 -->
                                    <div class="flex-1 text-left w-40">
                                        <div>
                                            <p class="font-semibold text-base w-64">CTA</p>
                                            <select id="Cta-{{ $num }}"
                                                onchange="AddPreviewOfCta({{ $num }})"
                                                name="Cta[{{ $num }}]"
                                                class="select select-primary w-64 rounded-full">
                                                <option {{-- {{ optional($Asset->AssetParameters)->cta == 'OnYourAd' ? 'selected' : '' }} --}} value="OnYourAd">On your ad</option>
                                                <option {{-- {{ optional($Asset->AssetParameters)->cta == 'ApplyNow' ? 'selected' : '' }} --}} value="ApplyNow">Apply Now</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Item 3 -->
                                    <div class="flex-1 text-left w-full">
                                        <div>
                                            <p class="font-semibold text-base w-full">Click Through URL</p>
                                            <input type="text" onkeydown="AddInfoToPreview({{ $num }})"
                                                name="ClickthrougnURL[{{ $num }}]"
                                                id="click-through-url-{{ $num }}" {{-- value="{{ $Asset->AssetParameters->clickthrougn_url ?? '' }}" --}}
                                                value=""
                                                class="input input-bordered input-primary w-full rounded-md w-full"
                                                placeholder="Enter valid URL" />
                                        </div>
                                    </div>
                                    <!-- Item 4 -->
                                    <div class="flex-1 text-left w-full">
                                        <div>
                                            <p class="font-semibold text-base w-full">UTM</p>
                                            <input type="text" name="Utm[{{ $num }}]" {{-- value="{{ $Asset->AssetParameters->utm ?? '' }}" --}}
                                                value=""
                                                class="input input-bordered input-primary w-full rounded-md w-full"
                                                placeholder="Enter valid URL" />
                                        </div>
                                    </div>
                                </div>

                                <p class="font-semibold text-xl my-5">Content</p>
                                <div class="divider mb-10"></div>

                                <div class="flex gap-8 mt-5">
                                    <div class="w-full">
                                        <div class="w-full flex flex-col gap-3">
                                            <div class="flex justify-between w-full">
                                                <p class="font-semibold text-base">Primary Text</p>
                                                <div class="flex items-center">
                                                    <label for="checkbox" class="ml-4">Link across versions</label>
                                                    <input type="checkbox" name="LinkPrimaryText[{{ $num }}]"
                                                        id="checkbox" value="1" {{-- {{ optional($Asset->AssetParameters)->link_primary_text != null ? 'checked' : '' }} --}}
                                                        class="form-checkbox checked:bg-[#ea33c0]">
                                                </div>

                                            </div>
                                            <textarea onkeydown="AddInfoToPreview({{ $num }})" id="primary-input-{{ $num }}"
                                                name="PrimaryText[{{ $num }}]" class="textarea textarea-primary min-h-36 rounded-2xl"
                                                {{-- placeholder="Placeholder Text..." maxlength="125">{{ $Asset->AssetParameters->primary_text ?? '' }}</textarea>  --}}
                                                placeholder="Placeholder Text..." maxlength="125"></textarea>
                                            <p id="char-count-primary-{{ $num }}"
                                                class="font-normal text-base text-[#888888]">
                                                Maximum 125 Characters
                                            </p>
                                        </div>
                                    </div>
                                    <div class="w-full flex flex-col gap-5">
                                        <div class="w-full flex flex-col gap-3">
                                            <div class="flex justify-between w-full">
                                                <p class="font-semibold text-base">Headline</p>
                                                <div class="flex items-center">
                                                    <label for="checkbox" class="ml-4">Link across versions</label>
                                                    <input type="checkbox" id="checkbox"
                                                        name="LinkHeadline[{{ $num }}]" value="1"
                                                        {{-- {{ optional($Asset->AssetParameters)->link_headline != null ? 'checked' : '' }} --}} class="form-checkbox checked:bg-[#ea33c0]">
                                                </div>
                                            </div>
                                            <input type="text" onkeydown="AddInfoToPreview({{ $num }})"
                                                id="headline-input-{{ $num }}" placeholder="Placeholder Text..."
                                                name="Headline[{{ $num }}]" {{-- value="{{ $Asset->AssetParameters->headline ?? '' }}" --}}
                                                class="input input-bordered input-primary w-full" maxlength="27" />
                                            <p id="char-count-headline-{{ $num }}"
                                                class="font-normal text-base text-[#888888]">
                                                Maximum 27 Characters
                                            </p>


                                        </div>
                                        <div class="w-full flex flex-col gap-3">
                                            <div class="flex justify-between w-full">
                                                <p class="font-semibold text-base">Description</p>
                                                <div class="flex items-center">
                                                    <label for="checkbox" class="ml-4">Link across versions</label>
                                                    <input type="checkbox" id="checkbox" value="1"
                                                        style="margin-left: 10px !importantf;" {{-- {{ optional($Asset->AssetParameters)->link_description != null ? 'checked' : '' }} --}}
                                                        name="LinkDescription[{{ $num }}]"
                                                        class="form-checkbox checked:bg-[#ea33c0]">
                                                </div>
                                            </div>
                                            <input type="text" id="description-input-{{ $num }}"
                                                placeholder="Placeholder Text..." name="Description[{{ $num }}]"
                                                {{-- value="{{ $Asset->AssetParameters->description ?? '' }}" --}} class="input input-bordered input-primary w-full"
                                                maxlength="27" />
                                            <p id="char-count-description-{{ $num }}"
                                                class="font-normal text-base text-[#888888]">
                                                Maximum 27 Characters
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex gap-8 mt-5">
                                    <div class="w-full">
                                        <div class="flex justify-between w-64">
                                            <p class="font-semibold text-base">Visuals</p>
                                            {{-- <p class="font-normal text-base text-[#888888]">0/1 Image</p> --}}
                                        </div>
                                        <div id="appendUploaderContainer_{{ $num }}" class="flex gap-3 ">
                                            <div class="uploader-container mt-10" id="uploader_{{ $num }}">
                                                <div class="uploader-close" id="removeBtn_{{ $num }}"
                                                    onclick="removeFile({{ $num }})">
                                                    ×
                                                </div>
                                                <div class="uploader-content" id="uploaderContent_{{ $num }}"
                                                    onclick="document.getElementById('fileInput_{{ $num }}').click()">
                                                    <div id="uploadIcon_{{ $num }}">
                                                        <div class="uploader-plus">+</div>
                                                        <div class="uploader-text">Add content</div>
                                                    </div>
                                                    <input name="Visuals[{{ $num }}][]" type="file"
                                                        id="fileInput_{{ $num }}" class="uploader-input"
                                                        onchange="previewFile({{ $num }},{{ $num }})" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($Asset->AssetParameters->visuals))
                                    <div class="divider"></div>
                                    <div class="flex gap-8 mt-5">
                                        <div class="w-full">
                                            <div class="flex justify-between w-64">
                                                <p class="font-semibold text-base">Uploaded Visuals
                                                </p>
                                            </div>
                                            {{-- {{dd($fileUrls[$Asset->AssetParameters->id])}} --}}
                                            <div id="" class="flex gap-3 ">
                                                @foreach ($fileUrls[$Asset->AssetParameters->id] as $fileUrl)
                                                    <div class="uploader-container mt-10" id="">
                                                        <img src="{{ $fileUrl }}" alt="">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- <div class="divider"></div>
                                <div class="flex gap-8 mt-5 w-full">
                                    <div class="w-full">
                                        <p class="text-lg font-semibold">Change Log</p>
                                        <div class="flex flex-col w-full gap-2 mt-5">
                                            <div class="flex gap-10">
                                                <p class="text-base text-[#555555]">01/03/2024 3:33pm</p>
                                                <p class="text-sm text-[#555555]">
                                                    Brad Wilton edited budget and CTA.
                                                </p>
                                            </div>
                                            <div class="flex gap-10">
                                                <p class="text-base text-[#555555]">01/03/2024 3:33pm</p>
                                                <p class="text-sm text-[#555555]">
                                                    Brad Wilton edited budget and CTA.
                                                </p>
                                            </div>
                                            <div class="flex gap-10">
                                                <p class="text-base text-[#555555]">01/03/2024 3:33pm</p>
                                                <p class="text-sm text-[#555555]">
                                                    Brad Wilton edited budget and CTA.
                                                </p>
                                            </div>
                                            <div class="flex gap-10">
                                                <p class="text-base text-[#555555]">01/03/2024 3:33pm</p>
                                                <p class="text-sm text-[#555555]">
                                                    Brad Wilton edited budget and CTA.
                                                </p>
                                            </div>
                                            <div class="flex gap-10">
                                                <p class="text-base text-[#555555]">01/03/2024 3:33pm</p>
                                                <p class="text-sm text-[#555555]">
                                                    Brad Wilton edited budget and CTA.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            @php
                                $num++;
                            @endphp
                        @endfor
                    @else
                        @foreach ($Asset->AssetParameters as $AssetParameter)
                            <div id="Asset_{{ $num }}" {{ $num != 1 ? 'hidden' : '' }}>
                                <div
                                    class="flex mt-3 py-4 px-6 justify-between items-center bg-[#EB6E6E] text-white rounded-md">
                                    <div class="flex gap-3 items-center">
                                        <p class="font-normal text-base">Ad Title</p>
                                        <input type="text" name="AdTitle[{{ $num }}]"
                                            placeholder="Tic Tac Tea" value="{{ $AssetParameter->ad_title }}"
                                            class="input input-bordered w-auto border border-[#dddddd] text-black bg-white h-[40px]" />
                                    </div>
                                    <div class="flex gap-3 items-center">
                                        <p class="text-2xl font-medium">
                                            {{-- {{ dd($AssetParameter->status) }} --}}
                                            @if ($AssetParameter->status == 'progress' || $AssetParameter->status == 'review')
                                                In {{ $AssetParameter->status }}
                                            @else
                                                {{ $AssetParameter->status }}
                                            @endif
                                        </p>
                                        <div class="w-9 h-9 rounded-full bg-white flex justify-center items-center">
                                            <img src="/assets/icons/rate_review.png" alt="create campaign"
                                                class="w-5" />
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full flex justify-between my-3">
                                    <p class="font-normal text-3xl">Ad Components</p>
                                    <div>
                                        @if ($AssetParameter->status != 'live')
                                            <button type="submit"
                                                class="btn rounded-full bg-accent text-white no-animation w-36">
                                                Save Asset
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="divider"></div>


                                {{-- Previewer --}}
                                <div
                                    class="w-full min-h-[700px] bg-[#dddddd] rounded-3xl border border-gray-300 p-7 relative my-8">
                                    <div class="flex justify-between w-full">
                                        <div class="flex flex-col gap-3">
                                            <p class="text-xl font-medium">Ad Preview</p>
                                            @if ($AssetParameter->status != 'live')
                                                <p class="mt-2 text-base font-medium">
                                                    Ready to submit for approval?
                                                </p>
                                                <div>

                                                </div>

                                                @php
                                                    if (strtolower($AssetParameter->status) == 'briefed') {
                                                        $statusValue = 'In Progress';
                                                    } elseif (strtolower($AssetParameter->status) == 'progress') {
                                                        $statusValue = 'In Review';
                                                    } elseif (strtolower($AssetParameter->status) == 'review') {
                                                        $statusValue = 'Approval';
                                                    } elseif (strtolower($AssetParameter->status) == 'approved') {
                                                        $statusValue = 'Trafficking';
                                                    } elseif (strtolower($AssetParameter->status) == 'trafficking') {
                                                        $statusValue = 'Live';
                                                    }
                                                @endphp
                                                @if (strtolower($AssetParameter->status) == 'review' ||
                                                        strtolower($AssetParameter->status) == 'approved' ||
                                                        strtolower($AssetParameter->status) == 'trafficking')
                                                    @if (Auth::user()->role == 'Media')
                                                        <button style="z-index: 10000"
                                                            value="{{ $AssetParameter->status }}" type="submit"
                                                            name="statusButton"
                                                            class="btn rounded-full bg-accent text-white no-animation w-50">
                                                            Submit For {{ $statusValue ?? 'Approval' }}
                                                        </button>
                                                    @endif
                                                @else
                                                    <button style="z-index: 10000" value="{{ $AssetParameter->status }}"
                                                        type="submit" name="statusButton"
                                                        class="btn rounded-full bg-accent text-white no-animation w-50">
                                                        Submit For {{ $statusValue ?? 'Approval' }}
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="flex">
                                            <p class="text-sm font-medium">Preview Full Screen</p>
                                        </div>
                                    </div>
                                    <div class="absolute top-16 w-full">
                                        <div
                                            class="flex justify-center w-[350px] rounded-3xl border border-accent mx-auto bg-white px-3 py-12">
                                            <div class="border border-accent w-full py-4 px-2">
                                                <div class="flex gap-2 w-full">
                                                    <div class="w-8 h-8 bg-accent rounded-full"></div>
                                                    <div class="flex flex-col">
                                                        <p class="text-sm font-semibold">
                                                            {{ $Campaign->User->name ?? 'Client Name' }}</p>
                                                        <p class="text-xs font-medium text-[#555555]">
                                                            Sponsored
                                                        </p>
                                                    </div>
                                                </div>
                                                <p id="PrimaryTextView_{{ $num }}"
                                                    class="my-3 text-sm font-medium text-[#555555]"
                                                    style="word-wrap: break-word !important">
                                                    Primary text placeholder.
                                                </p>
                                                <div id="imagePreview_{{ $num }}{{ old($num) }}"
                                                    class="w-full h-[250px] bg-[#dddddd]">
                                                </div>
                                                <div class="w-full p-2 bg-gray-200 mb-20">
                                                    <p id="clickThroughUrlPreview_{{ $num }}"
                                                        class="text-xs font-medium text-[#555555]">
                                                        Clickthroghurl.com
                                                    </p>
                                                    <div class="flex justify-between items-center mb-1">
                                                        <p id="HeadlinePreview_{{ $num }}"
                                                            class="text-xs font-semibold items-center">
                                                            Headline Placehodler to go here.
                                                        </p>
                                                        <p id="CtaPreview_{{ $num }}" type="button"
                                                            class="btn btn-sm bg-[#dddddd] px-7">CTA</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="my-10">
                                    <div class="text-2xl font-medium">
                                        Ad Specs
                                    </div>

                                    <div class="flex gap-10 my-10">
                                        <div class="flex flex-col gap-1">
                                            <p class="text-sm font-medium">Language</p>
                                            <p class="text-base font-medium">{{ $Connection->language }}</p>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <p class="text-sm font-medium">Region</p>
                                            <p class="text-base font-medium">{{ $Connection->location }}</p>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <p class="text-sm font-medium">Ratio</p>
                                            <p class="text-base font-medium">{{ $Asset->ad_format }}</p>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <p class="text-sm font-medium">File Type</p>
                                            <p class="text-base font-medium">{{ $Asset->file_type }}</p>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <p class="text-sm font-medium">Max Size</p>
                                            <p class="text-base font-medium">30</p>
                                        </div>
                                        <div class="flex flex-col ">
                                            <a href="#" class="underline text-gray-500" style="float: right">Link
                                                to
                                                full
                                                specs</a>
                                        </div>
                                    </div>
                                </div>

                                @if (strtolower($AssetParameter->status) == 'review' ||
                                        strtolower($AssetParameter->status) == 'approved' ||
                                        strtolower($AssetParameter->status) == 'trafficking')
                                    @if (Auth::user()->role == 'Media')
                                        <p class="font-semibold text-xl my-5">Remark</p>
                                        <div class="divider mb-5"></div>
                                        <div class="flex-1 text-left w-40">
                                            <div class="w-full">
                                                <div class="w-full flex flex-col gap-3">
                                                    <div class="flex justify-between w-full">
                                                        <p class="font-semibold text-base">Set Remark</p>

                                                    </div>
                                                    <textarea required id="remark" name="remark[{{ $num }}]"
                                                        class="textarea textarea-primary min-h-36 rounded-2xl" placeholder="Remark Text..." maxlength="125">{{ $AssetParameter->remark ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <p class="font-semibold text-xl my-5">Ad Objective</p>
                                <div class="divider mb-5"></div>

                                <div class="flex items-between justify-between gap-8 mb-10" style="width: 85%">
                                    <!-- Item 1 -->
                                    <div class="flex-1 text-left w-40">
                                        <div>
                                            <input type="hidden" name="AssetParametersId[{{ $num }}]"
                                                value="{{ $AssetParameter->id }}"
                                                class="input input-bordered input-primary w-full rounded-md w-full"
                                                placeholder="Enter valid URL" />
                                            <p class="font-semibold text-base w-64 ">
                                                Conversion Location
                                            </p>
                                            <select name="ConversionLocation[{{ $num }}]"
                                                class="select select-primary w-64 rounded-full">
                                                <option
                                                    {{ optional($AssetParameter)->conversion_location == 'OnYourAd' ? 'Selected' : '' }}
                                                    value="OnYourAd">On your ad</option>
                                                <option
                                                    {{ optional($AssetParameter)->conversion_location == 'ApplyNow' ? 'Selected' : '' }}
                                                    value="ApplyNow">Apply Now</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Item 2 -->
                                    <div class="flex-1 text-left w-40">
                                        <div>
                                            <p class="font-semibold text-base w-64">CTA</p>
                                            <select id="Cta-{{ $num }}"
                                                onchange="AddPreviewOfCta({{ $num }})"
                                                name="Cta[{{ $num }}]"
                                                class="select select-primary w-64 rounded-full">
                                                <option
                                                    {{ optional($AssetParameter)->cta == 'OnYourAd' ? 'selected' : '' }}
                                                    value="OnYourAd">On your ad</option>
                                                <option
                                                    {{ optional($AssetParameter)->cta == 'ApplyNow' ? 'selected' : '' }}
                                                    value="ApplyNow">Apply Now</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Item 3 -->
                                    <div class="flex-1 text-left w-full">
                                        <div>
                                            <p class="font-semibold text-base w-full">Click Through URL</p>
                                            <input type="text" onkeydown="AddInfoToPreview({{ $num }})"
                                                name="ClickthrougnURL[{{ $num }}]"
                                                id="click-through-url-{{ $num }}"
                                                value="{{ $AssetParameter->clickthrougn_url ?? '' }}" value=""
                                                class="input input-bordered input-primary w-full rounded-md w-full"
                                                placeholder="Enter valid URL" />
                                        </div>
                                    </div>
                                    <!-- Item 4 -->
                                    <div class="flex-1 text-left w-full">
                                        <div>
                                            <p class="font-semibold text-base w-full">UTM</p>
                                            <input type="text" name="Utm[{{ $num }}]"
                                                value="{{ $AssetParameter->utm ?? '' }}" value=""
                                                class="input input-bordered input-primary w-full rounded-md w-full"
                                                placeholder="Enter valid URL" />
                                        </div>
                                    </div>
                                </div>

                                <p class="font-semibold text-xl my-5">Content</p>
                                <div class="divider mb-10"></div>

                                <div class="flex gap-8 mt-5">
                                    <div class="w-full">
                                        <div class="w-full flex flex-col gap-3">
                                            <div class="flex justify-between w-full">
                                                <p class="font-semibold text-base">Primary Text</p>
                                                <div class="flex items-center">
                                                    <label for="checkbox" class="ml-4">Link across versions</label>
                                                    <input type="checkbox" name="LinkPrimaryText[{{ $num }}]"
                                                        id="checkbox" value="1"
                                                        {{ optional($AssetParameter)->link_primary_text != null ? 'checked' : '' }}
                                                        class="form-checkbox checked:bg-[#ea33c0]">
                                                </div>

                                            </div>
                                            <textarea onkeydown="AddInfoToPreview({{ $num }})" id="primary-input-{{ $num }}"
                                                name="PrimaryText[{{ $num }}]" class="textarea textarea-primary min-h-36 rounded-2xl"
                                                placeholder="Placeholder Text..." maxlength="125">{{ $AssetParameter->primary_text ?? '' }}</textarea>
                                            <p id="char-count-primary-{{ $num }}"
                                                class="font-normal text-base text-[#888888]">
                                                Maximum 125 Characters
                                            </p>
                                        </div>
                                    </div>
                                    <div class="w-full flex flex-col gap-5">
                                        <div class="w-full flex flex-col gap-3">
                                            <div class="flex justify-between w-full">
                                                <p class="font-semibold text-base">Headline</p>
                                                <div class="flex items-center">
                                                    <label for="checkbox" class="ml-4">Link across versions</label>
                                                    <input type="checkbox" id="checkbox"
                                                        name="LinkHeadline[{{ $num }}]" value="1"
                                                        {{ optional($AssetParameter)->link_headline != null ? 'checked' : '' }}
                                                        class="form-checkbox checked:bg-[#ea33c0]">
                                                </div>
                                            </div>
                                            <input type="text" onkeydown="AddInfoToPreview({{ $num }})"
                                                id="headline-input-{{ $num }}"
                                                placeholder="Placeholder Text..." name="Headline[{{ $num }}]"
                                                value="{{ $AssetParameter->headline ?? '' }}"
                                                class="input input-bordered input-primary w-full" maxlength="27" />
                                            <p id="char-count-headline-{{ $num }}"
                                                class="font-normal text-base text-[#888888]">
                                                Maximum 27 Characters
                                            </p>


                                        </div>
                                        <div class="w-full flex flex-col gap-3">
                                            <div class="flex justify-between w-full">
                                                <p class="font-semibold text-base">Description</p>
                                                <div class="flex items-center">
                                                    <label for="checkbox" class="ml-4">Link across versions</label>
                                                    <input type="checkbox" id="checkbox" value="1"
                                                        {{ optional($AssetParameter)->link_description != null ? 'checked' : '' }}
                                                        name="LinkDescription[{{ $num }}]"
                                                        class="form-checkbox checked:bg-[#ea33c0]">
                                                </div>
                                            </div>
                                            <input type="text" id="description-input-{{ $num }}"
                                                placeholder="Placeholder Text..."
                                                name="Description[{{ $num }}]"
                                                value="{{ $AssetParameter->description ?? '' }}"
                                                class="input input-bordered input-primary w-full" maxlength="27" />
                                            <p id="char-count-description-{{ $num }}"
                                                class="font-normal text-base text-[#888888]">
                                                Maximum 27 Characters
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex gap-8 mt-5">
                                    <div class="w-full">
                                        <div class="flex justify-between w-64">
                                            <p class="font-semibold text-base">Visuals</p>
                                            {{-- <p class="font-normal text-base text-[#888888]">0/1 Image</p> --}}
                                        </div>
                                        <div id="appendUploaderContainer_{{ $num }}" class="flex gap-3 ">
                                            <div class="uploader-container mt-10" id="uploader_{{ $num }}">
                                                <div class="uploader-close" id="removeBtn_{{ $num }}"
                                                    onclick="removeFile({{ $num }})">
                                                    ×
                                                </div>
                                                <div class="uploader-content" id="uploaderContent_{{ $num }}"
                                                    onclick="document.getElementById('fileInput_{{ $num }}').click()">
                                                    <div id="uploadIcon_{{ $num }}">
                                                        <div class="uploader-plus">+</div>
                                                        <div class="uploader-text">Add content</div>
                                                    </div>
                                                    <input name="Visuals[{{ $num }}][]" type="file"
                                                        id="fileInput_{{ $num }}" class="uploader-input"
                                                        onchange="previewFile({{ $num }},{{ $num }})" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($AssetParameter->visuals))
                                    <div class="divider"></div>
                                    <div class="flex gap-8 mt-5">
                                        <div class="w-full">
                                            <div class="flex justify-between w-64">
                                                <p class="font-semibold text-base">Uploaded Visuals
                                                </p>
                                            </div>
                                            {{-- {{dd($fileUrls[$Asset->AssetParameters->id])}} --}}
                                            <div id="" class="flex gap-3 ">
                                                @foreach ($fileUrls[$AssetParameter->id] as $fileUrl)
                                                    <div class="uploader-container mt-10" id="">
                                                        <img src="{{ $fileUrl }}" alt="">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="divider"></div>
                                <div class="flex gap-8 mt-5 w-full">
                                    <div class="w-full">
                                        <p class="text-lg font-semibold">Change Log</p>
                                        <div class="flex flex-col w-full gap-2 mt-5">
                                            {{-- {{ dd($AssetParameter->AsstesChangeLog) }} --}}
                                            @foreach ($AssetParameter->AsstesChangeLog as $AsstesChangeLog)
                                                <div class="flex gap-10">
                                                    @php
                                                        // Create a DateTime object from the given date
                                                        $dateTime = DateTime::createFromFormat(
                                                            'Y-m-d',
                                                            $AsstesChangeLog->date,
                                                        );

                                                        // Format the date to 'F d, Y'
                                                        $readableDate = $dateTime->format('F d, Y');
                                                    @endphp
                                                    <p class="text-base text-[#555555]">
                                                        {{ $readableDate }} - {{ $AsstesChangeLog->time }}</p>
                                                    <p class="text-sm text-[#555555]">
                                                        {{ $AsstesChangeLog->User->name }} has changed to
                                                        @if ($AsstesChangeLog->type == 'processUpdate')
                                                            updated and apply for the further process
                                                        @else
                                                            {{ $AsstesChangeLog->type }} -
                                                            {{ $AsstesChangeLog->remarks }}
                                                        @endif
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $num++;
                            @endphp
                        @endforeach
                    @endif
                @endforeach

            </form>



            {{-- Flight Listing --}}
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
                        <option disabled selected>Targeting</option>
                        <option>Game of Thrones</option>
                        <option>Lost</option>
                        <option>Breaking Bad</option>
                        <option>Walking Dead</option>
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
                    <div class="collapse collapse-arrow join-item" data-astro-cid-5kgwmqn7>
                        <input type="radio" name="my-accordion-4" checked="checked" data-astro-cid-5kgwmqn7 />
                        <div class="collapse-title text-xl font-medium">
                            <div class="flex justify-between pb-2 border-b border-b-primary">
                                <p class="text-2xl font-medium">Flight 1</p>
                                <p class="text-xl font-medium" data-astro-cid-5kgwmqn7>45</p>
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

                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="collapse collapse-arrow join-item" data-astro-cid-5kgwmqn7>
                        <input type="radio" name="my-accordion-4" data-astro-cid-5kgwmqn7 />
                        <div class="collapse-title text-xl font-medium">
                            <div class="flex justify-between pb-2 border-b border-b-primary">
                                <p class="text-2xl font-medium">Flight 2</p>
                                <p class="text-xl font-medium" data-astro-cid-5kgwmqn7>654</p>
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

                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="collapse collapse-arrow join-item" data-astro-cid-5kgwmqn7>
                        <input type="radio" name="my-accordion-4" data-astro-cid-5kgwmqn7 />
                        <div class="collapse-title text-xl font-medium">
                            <div class="flex justify-between pb-2 border-b border-b-primary">
                                <p class="text-2xl font-medium">Flight 3</p>
                                <p class="text-xl font-medium" data-astro-cid-5kgwmqn7>654</p>
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

                                </table>
                            </div>
                        </div>
                    </div>
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
    </div>

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
        function charCountForField(id, type, maxChars) {
            const inputField = document.getElementById(`${type}-input-${id}`);
            const charCount = document.getElementById(`char-count-${type}-${id}`);

            function updateCharCount() {
                const remainingChars = maxChars - inputField.value.length;
                charCount.textContent = `${remainingChars}/${maxChars} Characters`;
            }

            if (inputField) {
                inputField.addEventListener('input', updateCharCount);
                // Initialize the count on page load
                updateCharCount();
            }
        }

        function AddInfoToPreview(assetId) {
            var textarea = document.getElementById('primary-input-' + assetId);
            var textView = document.getElementById('PrimaryTextView_' + assetId);
            var text = textarea.value;
            textView.textContent = text;


            var clickThrough = document.getElementById('click-through-url-' + assetId);
            var clickThroughView = document.getElementById('clickThroughUrlPreview_' + assetId);
            var ClickText = clickThrough.value;
            clickThroughView.textContent = ClickText;

            var Headline = document.getElementById('headline-input-' + assetId);
            var HeadlineView = document.getElementById('HeadlinePreview_' + assetId);
            var HeadlineText = Headline.value;
            HeadlineView.textContent = HeadlineText;
        }

        function AddPreviewOfCta(assetId) {
            var Cta = document.getElementById('Cta-' + assetId);
            var CtaView = document.getElementById('CtaPreview_' + assetId);
            var CtaText = Cta.value;
            CtaView.textContent = CtaText;
        }


        document.addEventListener('DOMContentLoaded', (event) => {
            // Fetch asset IDs
            const assetIds = @json($Connection->Assets->pluck('id'));

            // Initialize character counting for each input type and asset ID
            assetIds.forEach(assetId => {
                charCountForField(assetId, 'headline', 27);
                charCountForField(assetId, 'description', 27);
                charCountForField(assetId, 'primary', 125);
                AddInfoToPreview(assetId);
                AddPreviewOfCta(assetId);
            });
        });
    </script>


    <script></script>

    <script>
        function toggleAssets(id) {
            // Loop through all flight divs
            var Asset = document.querySelectorAll('[id^="Asset_"]');
            var AssetsLink = document.querySelectorAll('[id^="AssetsLink_"]');
            var AssetsLinkCounter = document.querySelectorAll('[id^="AssetsLinkCounter_"]');
            Asset.forEach(function(AssetDiv) {
                // Check if the current flight div matches the specified ID
                if (AssetDiv.id == `Asset_${id}`) {
                    // Show the flight div
                    AssetDiv.removeAttribute('hidden');
                } else {
                    // Hide other flight divs
                    AssetDiv.setAttribute('hidden', '');
                }
            });
            AssetsLink.forEach(function(AssetsLinkDiv) {
                if (AssetsLinkDiv.id === `AssetsLink_${id}`) {
                    // Add active class to the matched AssetsLink_ div
                    AssetsLinkDiv.classList.add('bg-[#EB6E6E]');
                    AssetsLinkDiv.classList.remove('bg-[#F7E5D0]');

                    AssetsLinkDiv.classList.add('text-white');
                    AssetsLinkDiv.classList.remove('text-black');
                } else {
                    // Remove active class from other AssetsLink_ divs
                    AssetsLinkDiv.classList.remove('bg-[#EB6E6E]');
                    AssetsLinkDiv.classList.add('bg-[#F7E5D0]');

                    AssetsLinkDiv.classList.remove('text-white');
                    AssetsLinkDiv.classList.add('text-black');
                }
            });
            AssetsLinkCounter.forEach(function(AssetsLinkCounterDiv) {
                if (AssetsLinkCounterDiv.id === `AssetsLink_${id}`) {
                    // Add active class to the matched AssetsLink_ div
                    AssetsLinkCounterDiv.classList.add('bg-[#EB6E6E]');
                    AssetsLinkCounterDiv.classList.remove('bg-[#FFAB48]');
                } else {
                    // Remove active class from other AssetsLink_ divs
                    AssetsLinkCounterDiv.classList.remove('bg-[#EB6E6E]');
                    AssetsLinkCounterDiv.classList.add('bg-[#FFAB48]');
                }
            });
        }
    </script>
    <script>
        var ContainerCounter = {{ $num }};

        function previewFile(ContainerId, AssetParameterId) {
            ContainerCounter++;
            const file = document.getElementById("fileInput_" + ContainerId).files[0];
            const uploadIcon = document.getElementById("uploadIcon_" + ContainerId);
            const uploaderContent =
                document.getElementById("uploaderContent_" + ContainerId);
            const removeBtn = document.getElementById("removeBtn_" + ContainerId);
            const previewArea = document.getElementById("imagePreview_" + AssetParameterId);

            // Clear previous preview if an
            const existingPreview = document.getElementById("filePreview_" + ContainerId);
            if (existingPreview) {
                existingPreview.remove();
            }

            // Create a new preview element based on file type
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let previewElement;

                    if (file.type.startsWith("image/")) {
                        previewElement = document.createElement("img");
                        previewElement.src = e.target.result;
                        previewElement.className = "uploader-preview";
                        previewElement.id = "filePreview";
                    } else {
                        previewElement = document.createElement("div");
                        previewElement.className = "uploader-preview";
                        previewElement.id = "filePreview";
                        previewElement.innerText = "File uploaded";
                    }

                    uploaderContent.appendChild(previewElement);
                    previewArea.appendChild(previewElement.cloneNode(true));
                    uploadIcon.style.display = "none";
                    removeBtn.style.visibility = "visible";
                };
                reader.readAsDataURL(file);

            }
            addFileuploader(ContainerCounter, AssetParameterId);
            // previewArea.innerHTML = "";
        }

        function addFileuploader(ContainerId, AssetParameterId) {

            var uploaderHtml = `
                        <div class="uploader-container mt-10" id="uploader_${ContainerId}">
                            <div class="uploader-close" id="removeBtn_${ContainerId}" onclick="removeFile(${ContainerId})">
                                ×
                            </div>
                            <div class="uploader-content" id="uploaderContent_${ContainerId}" onclick="document.getElementById('fileInput_${ContainerId}').click()">
                                <div id="uploadIcon_${ContainerId}">
                                    <div class="uploader-plus">+</div>
                                    <div class="uploader-text">Add content</div>
                                </div>
                                <input name="Visuals[${AssetParameterId}][]" type="file" id="fileInput_${ContainerId}" class="uploader-input" onchange="previewFile(${ContainerId}, ${AssetParameterId})" multiple />
                            </div>
                        </div>
                        `;

            document.getElementById('appendUploaderContainer_' + AssetParameterId).insertAdjacentHTML('beforeend',
                uploaderHtml);

        }


        function removeFile(id) {
            const fileInput = document.getElementById("fileInput_" + id);
            const uploadIcon = document.getElementById("uploadIcon_" + id);
            const removeBtn = document.getElementById("removeBtn_" + id);

            // Clear the file input value
            fileInput.value = "";

            // Remove the preview element
            const existingPreview = document.getElementById("filePreview_" + id);
            if (existingPreview) {
                existingPreview.remove();
            }

            // Show the upload icon and hide the remove button
            uploadIcon.style.display = "block";
            removeBtn.style.visibility = "hidden";
        }
    </script>
    {{-- <script>
        // Function to set the changechecker field to 1
        function setChangeChecker() {
            document.getElementById('changechecker').value = '1';
        }

        // Add event listeners to input fields
        window.onload = function() {
            var inputs = document.querySelectorAll(
                'input[type="text"], input[type="number"], input[type="email"], textarea');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('input', setChangeChecker);
            }
        }
    </script> --}}

    <script>
        // Function to set the changechecker field to 1
        function setChangeChecker() {
            document.getElementById('changechecker').value = '1';
        }

        // Add event listeners to input fields
        window.onload = function() {
            var inputs = document.querySelectorAll(
                'input[type="text"], input[type="number"], input[type="email"], textarea'
            );
            for (var i = 0; i < inputs.length; i++) {
                // Skip the input fields that have names starting with "remark"
                if (!inputs[i].name.startsWith('remark')) {
                    inputs[i].addEventListener('input', setChangeChecker);
                }
            }
        }
    </script>

@endsection
