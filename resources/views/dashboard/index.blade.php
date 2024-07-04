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
        {{-- {{dd($Campaigns->toArray())}} --}}
        <div class="flex flex-col md:flex-row justify-between">
            <h1 class="text-4xl font-semibold">Campaign Dashboard</h1>

           
            <div class="flex gap-3">
                <!-- search  -->
                <label
                    class="input input-bordered input-primary flex items-center gap-2 rounded-full bg-white px-3 py-2 w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="#c72ba4" class="w-4 h-4 opacity-70">
                        <path fill-rule="evenodd"
                            d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <input type="text" class="text-xs text-[#555555] min-w-48"
                        placeholder="Search by keyword, project #, etc." />
                </label>
                <select
                    class="select select-primary rounded-full bg-white w-full max-w-md select-md text-xs text-[#555555]">
                    <option disabled selected>Filter by Client</option>
                    <option>Kusmi Tea</option>
                    <option>McDonald’s</option>
                    <option>Unilever</option>
                </select>
                <select
                    class="select select-primary rounded-full bg-white w-full max-w-md select-md text-xs text-[#555555]">
                    <option disabled selected>Filter by Status</option>
                    <option>Live</option>
                    <option>Draft</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-4 mt-10">
            @if (Auth::user()->role == 'Media')
                <div class="w-full h-full">

                    <div class="pt-16 h-full w-full h-full">
                        <a href="{{ route('campaign.create') }}"
                            class="flex w-full border border-accent justify-center items-center h-full rounded-3xl">
                            <img src="data:image/png;base64,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"
                                alt="create campaign" class="w-28 pb-9" />
                        </a>
                    </div>
                </div>
            @endif

            {{-- Campaign Listing --}}
            @foreach ($Campaigns as $Campaign)
                <div class="flex flex-col w-full gap-2" data-astro-cid-lhxslpwo>
                    <div class="flex justify-between" data-astro-cid-lhxslpwo>
                        <h5 class="font-medium text-base underline" data-astro-cid-lhxslpwo>
                            {{ $Campaign->campaign_name }}
                        </h5>
                        <p class="font-medium text-sm text-[#555555]" data-astro-cid-lhxslpwo>
                            {{ $Campaign->project_code }}
                        </p>
                    </div>
                    <div data-astro-cid-lhxslpwo>
                        <h4 data-astro-cid-lhxslpwo>{{ $Campaign->campaign_name }}</h4>
                    </div>
                    <a href="{{ route('campaign-show', $Campaign->id) }}" class="w-full h-full" data-astro-cid-lhxslpwo>
                        <div class="w-full h-80" data-astro-cid-lhxslpwo>
                            @if (!empty($Campaign->image))
                                <div class="bg-cover bg-no-repeat bg-center w-full h-full rounded-2xl"
                                    style="background-image: url(/campaignHeaderImage/{{ $Campaign->id }}/{{ $Campaign->image ?? '' }})"
                                    onmouseover="mouseOver(this)" onmouseout="mouseOut(this)" data-astro-cid-lhxslpwo>
                                @else
                                    <div class="bg-cover bg-no-repeat bg-center w-full h-full rounded-2xl"
                                        style="background-image: url(/campaignHeaderImage/draft.png)"
                                        onmouseover="mouseOver(this)" onmouseout="mouseOut(this)" data-astro-cid-lhxslpwo>
                            @endif


                            {{-- {{ dd($assetStatusCount) }} --}}
                            @foreach($assetStatusCount as $statusCount)
                            {{-- {{ $statusCount->status }}</br> --}}

                            <div class="w-full h-full p-0 invisible" data-astro-cid-lhxslpwo>

                                <div class="p-0 flex w-full flex-col gap-10 justify-center items-center h-full card-drop rounded-2xl"
                                    data-astro-cid-lhxslpwo>
                                    <div class="flex w-full justify-center gap-3" data-astro-cid-lhxslpwo>
                                        <div class="flex flex-col gap-3 items-center justify-center"
                                            data-astro-cid-lhxslpwo>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign" class="w-8 h-8"
                                                data-astro-cid-lhxslpwo />
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign" class="w-8 h-8"
                                                data-astro-cid-lhxslpwo />
                                            <img src="/assets/home/card/Icon4.svg" alt="create campaign" class="w-8 h-8"
                                                data-astro-cid-lhxslpwo />
                                        </div>

                                        <div class="flex flex-col gap-3 items-center justify-center"
                                            data-astro-cid-lhxslpwo>
                                            <p class="text-white w-8 h-8 flex justify-center items-center"
                                                data-astro-cid-lhxslpwo>
                                                @if ($statusCount->status == 'draft')
                                                {{ $statusCount->status_count}}
                                                @else
                                                {{ '0' }}
                                                @endif
                                            </p>
                                            <p class="text-white w-8 h-8 flex justify-center items-center"
                                                data-astro-cid-lhxslpwo>
                                                @if($statusCount->status == 'progress')
                                                {{ $statusCount->status_count}}
                                                @else
                                                {{ '0' }}
                                                @endif
                                            </p>
                                            <p class="text-white w-8 h-8 flex justify-center items-center"
                                                data-astro-cid-lhxslpwo>
                                                @if($statusCount->status == 'review')
                                                {{ $statusCount->status_count}}
                                                @else
                                                {{ '0' }}
                                                @endif
                                            </p>
                                            {{-- @endif --}}
                                        </div>
                                        {{-- @endforeach --}}

                                        <div class="flex flex-col gap-3 items-center justify-center"
                                            data-astro-cid-lhxslpwo>
                                            <img src="/assets/home/card/Icon1.svg" alt="create campaign" class="w-8 h-8"
                                                data-astro-cid-lhxslpwo />
                                            <img src="/assets/home/card/Icon6.svg" alt="create campaign" class="w-8 h-8"
                                                data-astro-cid-lhxslpwo />
                                            <img src="/assets/home/card/Icon5.svg" alt="create campaign" class="w-8 h-8"
                                                data-astro-cid-lhxslpwo />
                                        </div>
                                        {{-- @foreach($assetStatusCount as $statusCount) --}}
                                        <div class="flex flex-col gap-3 items-center justify-center"
                                            data-astro-cid-lhxslpwo>
                                            <p class="text-white w-8 h-8 flex justify-center items-center"
                                                data-astro-cid-lhxslpwo>
                                                @if($statusCount->status == 'approved')
                                                {{ $statusCount->status_count ?? '0'}}
                                                @else
                                                {{ '0' }}
                                                @endif
                                            </p>
                                            <p class="text-white w-8 h-8 flex justify-center items-center"
                                                data-astro-cid-lhxslpwo>
                                                @if($statusCount->status == 'trafficking')
                                                {{ $statusCount->status_count ?? '0'}}
                                                @else
                                                {{ '0' }}
                                                @endif
                                            </p>
                                            <p class="text-white w-8 h-8 flex justify-center items-center"
                                                data-astro-cid-lhxslpwo>
                                                @if($statusCount->status == 'live')
                                                {{ $statusCount->status_count ?? '0'}}
                                                @else
                                                {{ '0' }}
                                                @endif
                                            </p>
                                            {{-- @endif --}}
                                        </div>

                                    </div>
                                    <div data-astro-cid-lhxslpwo>
                                        <button
                                            class="btn btn-outline btn-sm px-5 rounded-full bg-transparent text-white hover:bg-white hover:text-black hover:border-white"
                                            data-astro-cid-lhxslpwo>
                                            View Campaign
                                        </button>
                                    </div>
                                </div>

                            </div>
                            @endforeach


                        </div>
                </div>
                </a>
        </div>
        <script type="text/javascript">
            function mouseOver(element) {
                const firstChild = element.firstElementChild;
                firstChild.classList.remove("invisible");
            }

            function mouseOut(element) {
                const firstChild = element.firstElementChild;
                firstChild.classList.add("invisible");
            }
        </script>
        @endforeach
    </div>


    </div>
@endsection
