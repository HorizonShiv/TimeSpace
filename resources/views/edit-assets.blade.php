@extends('Layout.sidebar')

@section('main-container')
    <form action="{{ route('assets-update') }}" method="POST">
        @csrf
        <input type="hidden" id="CampaignId" name="CampaignId" value="{{ $id }}" id="">
        <div class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full" id="content" data-astro-cid-sckkx6r4>
            <div data-astro-cid-b7mymyte>
                <div class="flex justify-between" data-astro-cid-b7mymyte>
                    <h1 class="text-4xl font-semibold">Assets Setup</h1>
                    <a href="/campaign/create/index.html" data-astro-cid-b7mymyte>
                        <button
                            class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                            data-astro-cid-b7mymyte>
                            <img src="/assets/sidebar/settings.png" class="w-[20px] h-[20px]" data-astro-cid-b7mymyte />
                            <p class="text-sm font-medium text-[#555555]" data-astro-cid-b7mymyte>
                                Edit Settings
                            </p>
                        </button>
                    </a>
                </div>
                <div class="my-7" data-astro-cid-b7mymyte>
                    <div class="flex flex-col w-full gap-7">
                        <div class="flex flex-col gap-1">
                            <p class="text-xl font-semibold">{{ $CampaignData->campaign_name }}</p>
                            <h2 class="text-4xl font-medium">{{ $CampaignData->campaign_name }}</h2>
                        </div>
                        <div class="flex gap-7 justify-start">
                            <div class="flex flex-col gap-1">
                                <p class="text-sm font-medium">Project Number</p>
                                <p class="text-base font-medium">{{ $CampaignData->project_code }}</p>
                            </div>
                            <div class="flex flex-col gap-1">
                                <p class="text-sm font-medium">Total Budget</p>
                                <p class="text-base font-medium">${{ $CampaignData->budget }}</p>
                            </div>
                            <div class="flex flex-col gap-1">
                                <p class="text-sm font-medium">Languages</p>
                                <p class="text-base font-medium">
                                    @foreach ($CampaignData->CampaignLanguages as $lang)
                                        {{ $lang->language }}
                                    @endforeach
                                </p>
                            </div>
                            <div class="flex flex-col gap-1">
                                <p class="text-sm font-medium">Team</p>
                                <div class="flex gap-1">
                                    <div class="flex gap-1" data-astro-cid-ih4xnkm6>
                                        @if (!empty($CampaignData->CampaignMember))
                                            @foreach ($CampaignData->CampaignMember as $member)
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
                        <div class="bg-[#EA33C0] h-[2px]"></div>
                    </div>
                </div>

                <div class="flex w-full items-center justify-between" data-astro-cid-b7mymyte>
                    <div class="flex grow gap-3 items-center" data-astro-cid-b7mymyte>
                        <div class="join" data-astro-cid-b7mymyte>
                            @foreach ($CampaignData->Flight as $Campaign)
                                <input class="join-item btn border-accent bg-white px-10 hover:bg-white hover:border-accent"
                                    type="radio" name="options" onclick="toggleFlight({{ $Campaign->flight_count }})"
                                    aria-label="Flight {{ $Campaign->flight_count }}" data-astro-cid-b7mymyte />
                            @endforeach
                        </div>
                    </div>
                    <div class="" data-astro-cid-b7mymyte>
                        <a href="{{ route('flight-edit', $CampaignData->id) }}" data-astro-cid-b7mymyte>
                            <button type="button"
                                class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                                data-astro-cid-b7mymyte>
                                <img src="/assets/sidebar/settings.png" class="w-[20px] h-[20px]" data-astro-cid-b7mymyte />
                                <p class="text-sm font-medium text-[#555555]" data-astro-cid-b7mymyte>
                                    Edit Flights
                                </p>
                            </button>


                        </a>
                    </div>
                </div>

                @php
                    $counter = 0;
                    $ContainerCounter = 0;

                @endphp

                @foreach ($CampaignData->Flight as $Flights)
                    @php
                        $multiAssetsCounter = 0;
                    @endphp
                    {{-- {{ dd($Flights->id) }} --}}
                    <div id="Flight_{{ $Flights->flight_count }}" {{ $Flights->flight_count != 1 ? 'hidden' : '' }}>
                        <!-- Flight Title -->
                        <div class="my-6" data-astro-cid-b7mymyte>
                            <h1 class="text-2xl " data-astro-cid-b7mymyte>
                                Flight {{ $Flights->flight_count }}
                            </h1>
                        </div>
                        @php
                            $englishAssetsDisplayed = false; // Initialize a variable to track whether English assets have been displayed
                            $frenchAssetsDisplayed = false; // Initialize a variable to track whether English assets have been displayed

                        @endphp
                        @php
                            $CategpryChecker = 0;
                        @endphp
                        @foreach ($Flights->FlightConnection as $FlightConnection)
                            @if ($FlightConnection->language === 'EN')
                                @if (!$englishAssetsDisplayed)
                                    <div class="my-6" data-astro-cid-b7mymyte>
                                        <h3 class="text-2xl font-medium" data-astro-cid-b7mymyte>
                                            English Assets
                                        </h3>
                                        <div class="bg-[#EA33C0] h-[2px] mt-2" data-astro-cid-b7mymyte></div>
                                    </div>
                                @endif
                                @php
                                    $englishAssetsDisplayed = true; // Set the variable to true to indicate English assets have been displayed
                                    $counter++;
                                @endphp

                                <div class="flex w-full flex-col gap-4 my-4 {{ $multiAssetsCounter != 0 ? 'hidden' : '' }}"
                                    data-astro-cid-b7mymyte
                                    id="CopyContainer_{{ $FlightConnection->tag }}_{{ $FlightConnection->CategoryMaster->id }}">
                                    <div class="flex w-full flex-col" data-astro-cid-b7mymyte>
                                        <div class="flex justify-between items-center" data-astro-cid-b7mymyte>
                                            <h3 class="text-3xl font-medium" data-astro-cid-b7mymyte>
                                                {{ $FlightConnection->type }} - {{ $FlightConnection->location }}
                                            </h3>
                                            <div class="flex gap-2" data-astro-cid-b7mymyte>
                                                @if ($multiAssetsCounter == 0)
                                                    @php
                                                        $oldTagChecker = $FlightConnection->tag;
                                                    @endphp
                                                @endif

                                                @php
                                                    $counterAdder = 0;
                                                @endphp
                                                {{-- @if ($CategpryChecker == 0) --}}
                                                @foreach ($tags[$Flights->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->tag] as $Category)
                                                    @php
                                                        $categoryData = explode('_', $Category);
                                                    @endphp
                                                    <span id="Span_{{ $FlightConnection->tag }}_{{ $categoryData[1] }}"
                                                        style="cursor: pointer;"
                                                        onclick="categoryShow('{{ $FlightConnection->tag }}',{{ $categoryData[1] }},{{ $FlightConnection->id + $counterAdder }})"
                                                        class="badge bg-white text-black p-3 text-sm">
                                                        {{-- {{ $Category }} --}}

                                                        {{ $categoryData[0] }}
                                                    </span>
                                                    @php
                                                        $counterAdder++;
                                                    @endphp
                                                @endforeach
                                                {{-- @endif --}}

                                                @php
                                                    $CategpryChecker++;
                                                @endphp

                                                @php
                                                    $CategoryName =
                                                        $html[$Flights->id][$FlightConnection->id][
                                                            $FlightConnection->language
                                                        ][$FlightConnection->type][
                                                            $FlightConnection->CategoryMaster->id
                                                        ]['categoryName'];

                                                @endphp
                                            </div>
                                        </div>



                                        {{-- <div>3 Assets</div> --}}
                                        <div class="divider mt-4 mb-0" data-astro-cid-b7mymyte></div>

                                        <!-- Row Template -->
                                        @if ($FlightConnection->Assets->isNotEmpty())
                                            @foreach ($FlightConnection->Assets as $Asset)
                                                @if ($Asset->flight_id == $Flights->id && $FlightConnection->CategoryMaster->id == $Asset->category_id)
                                                    <div class="flex w-full flex-col gap-2 relative" id=""
                                                        data-row-template data-astro-cid-b7mymyte>
                                                        <div class="absolute bg-[#bababa73] w-[190px] h-full right-0 top-[-8px]"
                                                            data-astro-cid-b7mymyte>
                                                        </div>
                                                        <div class="w-full flex justify-between" data-astro-cid-b7mymyte>
                                                            <div class="w-auto flex gap-3" {{-- id="inputFieldsNameContainer_{{ $FlightConnection->id }}" --}}
                                                                data-astro-cid-b7mymyte>
                                                                {{-- Labels of all the fields --}}
                                                                {!! $html[$Flights->id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][
                                                                    $FlightConnection->CategoryMaster->id
                                                                ][$Asset->id]['htmlFieldName'] ?? '' !!}
                                                                <span class="w-auto flex gap-3"
                                                                    id="inputFieldsNameContainer_{{ $Flights->id }}_{{ $FlightConnection->id }}_{{ $FlightConnection->language }}_{{ $FlightConnection->type }}_{{ $FlightConnection->CategoryMaster->id }}_{{ $ContainerCounter }}"></span>
                                                            </div>
                                                            <div class="z-10 mr-3" data-astro-cid-b7mymyte>
                                                                <p class="text-lg w-[165px] text-start"
                                                                    data-astro-cid-b7mymyte>
                                                                    Due to Publisher
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="w-full flex justify-between" data-astro-cid-b7mymyte>
                                                            <div class="w-full flex gap-3" {{-- id="inputFieldsContainer_{{ $FlightConnection->id }}" --}}
                                                                data-astro-cid-b7mymyte>
                                                                {{-- all the input fields --}}
                                                                {!! $html[$Flights->id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][
                                                                    $FlightConnection->CategoryMaster->id
                                                                ][$Asset->id]['htmlField'] ?? '' !!}
                                                                <span class="w-auto flex gap-3"
                                                                    id="inputFieldsContainer_{{ $Flights->id }}_{{ $FlightConnection->id }}_{{ $FlightConnection->language }}_{{ $FlightConnection->type }}_{{ $FlightConnection->CategoryMaster->id }}_{{ $ContainerCounter }}"></span>
                                                            </div>
                                                            <div class="z-10 mr-3" data-astro-cid-b7mymyte>
                                                                {!! $html[$Flights->id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][
                                                                    $FlightConnection->CategoryMaster->id
                                                                ][$Asset->id]['htmlData'] ?? '' !!}

                                                            </div>
                                                        </div>

                                                        <div class="divider my-0" data-astro-cid-b7mymyte></div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        <!-- End of Row Template -->
                                        <div id="AddContainer_{{ $FlightConnection->id }}"></div>
                                    </div>

                                </div>


                                <!-- End of Rows Section -->

                                <!-- Add Row Button -->
                                <div class="{{ $multiAssetsCounter != 0 ? 'hidden' : '' }}"
                                    id="container_{{ $FlightConnection->tag }}_{{ $FlightConnection->CategoryMaster->id }}"
                                    data-astro-cid-b7mymyte>
                                    <button type="button" id="addRowBtn"
                                        onclick="AddRow({{ $Flights->id }},{{ $FlightConnection->id }},'{{ $FlightConnection->language }}','{{ $FlightConnection->type }}',{{ $FlightConnection->CategoryMaster->id }},'{{ $CategoryName }}',{{ $ContainerCounter }})"
                                        class="btn btn-outline no-animation btn-accent rounded-3xl w-36 svg-container text-[#555555]"
                                        data-astro-cid-b7mymyte>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481"
                                            viewBox="0 0 15.481 15.481" data-astro-cid-b7mymyte>
                                            <path id="add_FILL0_wght400_GRAD0_opsz24"
                                                d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z"
                                                transform="translate(-200 760)" fill="#ea33c0" data-astro-cid-b7mymyte>
                                            </path>
                                        </svg>
                                        Add Row
                                    </button>
                                </div>
                                @if ($FlightConnection->tag == $oldTagChecker)
                                    @php
                                        $multiAssetsCounter++;
                                    @endphp
                                @else
                                    @php
                                        $multiAssetsCounter = 0;
                                        $CategpryChecker = 0;
                                    @endphp
                                @endif
                                @php
                                    $oldTagChecker = $FlightConnection->tag;
                                @endphp
                            @endif



                            @if ($FlightConnection->language === 'FR')
                                @if (!$englishAssetsDisplayed)
                                    <div class="my-6" data-astro-cid-b7mymyte>
                                        <h3 class="text-2xl font-medium" data-astro-cid-b7mymyte>
                                            English Assets
                                        </h3>
                                        <div class="bg-[#EA33C0] h-[2px] mt-2" data-astro-cid-b7mymyte></div>
                                    </div>
                                @endif
                                @php
                                    $englishAssetsDisplayed = true; // Set the variable to true to indicate English assets have been displayed
                                    $counter++;
                                @endphp

                                <div class="flex w-full flex-col gap-4 my-4 {{ $multiAssetsCounter != 0 ? 'hidden' : '' }}"
                                    data-astro-cid-b7mymyte
                                    id="CopyContainer_{{ $FlightConnection->tag }}_{{ $FlightConnection->CategoryMaster->id }}">
                                    <div class="flex w-full flex-col" data-astro-cid-b7mymyte>
                                        <div class="flex justify-between items-center" data-astro-cid-b7mymyte>
                                            <h3 class="text-3xl font-medium" data-astro-cid-b7mymyte>
                                                {{ $FlightConnection->type }} - {{ $FlightConnection->location }}
                                            </h3>
                                            <div class="flex gap-2" data-astro-cid-b7mymyte>
                                                @if ($multiAssetsCounter == 0)
                                                    @php
                                                        $oldTagChecker = $FlightConnection->tag;
                                                    @endphp
                                                @endif

                                                @php
                                                    $counterAdder = 0;
                                                @endphp
                                                {{-- @if ($CategpryChecker == 0) --}}
                                                @foreach ($tags[$Flights->id][$FlightConnection->language][$FlightConnection->type][$FlightConnection->tag] as $Category)
                                                    @php
                                                        $categoryData = explode('_', $Category);
                                                    @endphp
                                                    <span id="Span_{{ $FlightConnection->tag }}_{{ $categoryData[1] }}"
                                                        style="cursor: pointer;"
                                                        onclick="categoryShow('{{ $FlightConnection->tag }}',{{ $categoryData[1] }},{{ $FlightConnection->id + $counterAdder }})"
                                                        class="badge bg-white text-black p-3 text-sm">
                                                        {{-- {{ $Category }} --}}

                                                        {{ $categoryData[0] }}
                                                    </span>
                                                    @php
                                                        $counterAdder++;
                                                    @endphp
                                                @endforeach
                                                {{-- @endif --}}

                                                @php
                                                    $CategpryChecker++;
                                                @endphp

                                                @php
                                                    $CategoryName =
                                                        $html[$Flights->id][$FlightConnection->id][
                                                            $FlightConnection->language
                                                        ][$FlightConnection->type][
                                                            $FlightConnection->CategoryMaster->id
                                                        ]['categoryName'];

                                                @endphp
                                            </div>
                                        </div>



                                        {{-- <div>3 Assets</div> --}}
                                        <div class="divider mt-4 mb-0" data-astro-cid-b7mymyte></div>

                                        <!-- Row Template -->

                                        @if ($FlightConnection->Assets->isNotEmpty())
                                            @foreach ($FlightConnection->Assets as $Asset)
                                                @if ($Asset->flight_id == $Flights->id && $FlightConnection->CategoryMaster->id == $Asset->category_id)
                                                    <div class="flex w-full flex-col gap-2 relative" id=""
                                                        data-row-template data-astro-cid-b7mymyte>
                                                        <div class="absolute bg-[#bababa73] w-[190px] h-full right-0 top-[-8px]"
                                                            data-astro-cid-b7mymyte>
                                                        </div>
                                                        <div class="w-full flex justify-between" data-astro-cid-b7mymyte>
                                                            <div class="w-auto flex gap-3" {{-- id="inputFieldsNameContainer_{{ $FlightConnection->id }}" --}}
                                                                data-astro-cid-b7mymyte>
                                                                {{-- Labels of all the fields --}}
                                                                {!! $html[$Flights->id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][
                                                                    $FlightConnection->CategoryMaster->id
                                                                ][$Asset->id]['htmlFieldName'] ?? '' !!}
                                                                <span class="w-auto flex gap-3"
                                                                    id="inputFieldsNameContainer_{{ $Flights->id }}_{{ $FlightConnection->id }}_{{ $FlightConnection->language }}_{{ $FlightConnection->type }}_{{ $FlightConnection->CategoryMaster->id }}_{{ $ContainerCounter }}"></span>
                                                            </div>
                                                            <div class="z-10 mr-3" data-astro-cid-b7mymyte>
                                                                <p class="text-lg w-[165px] text-start"
                                                                    data-astro-cid-b7mymyte>
                                                                    Due to Publisher
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="w-full flex justify-between" data-astro-cid-b7mymyte>
                                                            <div class="w-full flex gap-3" {{-- id="inputFieldsContainer_{{ $FlightConnection->id }}" --}}
                                                                data-astro-cid-b7mymyte>
                                                                {!! $html[$Flights->id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][
                                                                    $FlightConnection->CategoryMaster->id
                                                                ][$Asset->id]['htmlField'] ?? '' !!}
                                                                <span class="w-auto flex gap-3"
                                                                    id="inputFieldsContainer_{{ $Flights->id }}_{{ $FlightConnection->id }}_{{ $FlightConnection->language }}_{{ $FlightConnection->type }}_{{ $FlightConnection->CategoryMaster->id }}_{{ $ContainerCounter }}"></span>
                                                            </div>
                                                            <div class="z-10 mr-3" data-astro-cid-b7mymyte>
                                                                {!! $html[$Flights->id][$Asset->flight_connection_id][$FlightConnection->language][$FlightConnection->type][
                                                                    $FlightConnection->CategoryMaster->id
                                                                ][$Asset->id]['htmlData'] ?? '' !!}
                                                            </div>
                                                        </div>

                                                        <div class="divider my-0" data-astro-cid-b7mymyte></div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif

                                        <div class="flex w-full flex-col gap-2 relative" id="" data-row-template
                                            data-astro-cid-b7mymyte>
                                            <div class="absolute bg-[#bababa73] w-[190px] h-full right-0 top-[-8px]"
                                                data-astro-cid-b7mymyte>
                                            </div>
                                            <div class="w-full flex justify-between" data-astro-cid-b7mymyte>
                                                <div class="w-auto flex gap-3" {{-- id="inputFieldsNameContainer_{{ $FlightConnection->id }}" --}}
                                                    data-astro-cid-b7mymyte>
                                                    {{-- Labels of all the fields --}}
                                                    {!! $html[$Flights->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][
                                                        $FlightConnection->CategoryMaster->id
                                                    ]['htmlFieldName'] !!}
                                                    <span class="w-auto flex gap-3"
                                                        id="inputFieldsNameContainer_{{ $Flights->id }}_{{ $FlightConnection->id }}_{{ $FlightConnection->language }}_{{ $FlightConnection->type }}_{{ $FlightConnection->CategoryMaster->id }}_{{ $ContainerCounter }}"></span>
                                                </div>
                                                <div class="z-10 mr-3" data-astro-cid-b7mymyte>
                                                    <p class="text-lg w-[165px] text-start" data-astro-cid-b7mymyte>
                                                        Due to Publisher
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="w-full flex justify-between" data-astro-cid-b7mymyte>
                                                <div class="w-full flex gap-3" {{-- id="inputFieldsContainer_{{ $FlightConnection->id }}" --}}
                                                    data-astro-cid-b7mymyte>
                                                    {{-- all the input fields --}}
                                                    {!! $html[$Flights->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][
                                                        $FlightConnection->CategoryMaster->id
                                                    ]['htmlField'] !!}
                                                    <span class="w-auto flex gap-3"
                                                        id="inputFieldsContainer_{{ $Flights->id }}_{{ $FlightConnection->id }}_{{ $FlightConnection->language }}_{{ $FlightConnection->type }}_{{ $FlightConnection->CategoryMaster->id }}_{{ $ContainerCounter }}"></span>
                                                </div>
                                                <div class="z-10 mr-3" data-astro-cid-b7mymyte>
                                                    {!! $html[$Flights->id][$FlightConnection->id][$FlightConnection->language][$FlightConnection->type][
                                                        $FlightConnection->CategoryMaster->id
                                                    ]['htmlData'] !!}

                                                </div>
                                            </div>

                                            <div class="divider my-0" data-astro-cid-b7mymyte></div>
                                        </div>
                                        <!-- End of Row Template -->
                                        <div id="AddContainer_{{ $FlightConnection->id }}"></div>
                                    </div>

                                </div>


                                <!-- End of Rows Section -->

                                <!-- Add Row Button -->
                                <div class="{{ $multiAssetsCounter != 0 ? 'hidden' : '' }}"
                                    id="container_{{ $FlightConnection->tag }}_{{ $FlightConnection->CategoryMaster->id }}"
                                    data-astro-cid-b7mymyte>
                                    <button type="button" id="addRowBtn"
                                        onclick="AddRow({{ $Flights->id }},{{ $FlightConnection->id }},'{{ $FlightConnection->language }}','{{ $FlightConnection->type }}',{{ $FlightConnection->CategoryMaster->id }},'{{ $CategoryName }}',{{ $ContainerCounter }})"
                                        class="btn btn-outline no-animation btn-accent rounded-3xl w-36 svg-container text-[#555555]"
                                        data-astro-cid-b7mymyte>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481"
                                            viewBox="0 0 15.481 15.481" data-astro-cid-b7mymyte>
                                            <path id="add_FILL0_wght400_GRAD0_opsz24"
                                                d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z"
                                                transform="translate(-200 760)" fill="#ea33c0" data-astro-cid-b7mymyte>
                                            </path>
                                        </svg>
                                        Add Row
                                    </button>
                                </div>
                                @if ($FlightConnection->tag == $oldTagChecker)
                                    @php
                                        $multiAssetsCounter++;
                                    @endphp
                                @else
                                    @php
                                        $multiAssetsCounter = 0;
                                        $CategpryChecker = 0;
                                    @endphp
                                @endif
                                @php
                                    $oldTagChecker = $FlightConnection->tag;
                                @endphp
                            @endif
                            @php
                                $ContainerCounter++;
                            @endphp
                        @endforeach
                    </div>
                @endforeach


                <!-- Save Changes Button -->
                <div data-astro-cid-b7mymyte class="mt-10">
                    <button class="btn rounded-full bg-accent text-white no-animation w-48" data-astro-cid-b7mymyte>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        var counter = {{ $ContainerCounter }};

        function AddRow(FlightId, CampaignId, CampaignLan, CampaignType, CategoryMasterId, CategoryName, ContainerCounter) {
            counter++;
            let htmlContent = `
                    <div class="flex w-full flex-col gap-2 relative" id="CopyContainer_9" data-row-template="" data-astro-cid-b7mymyte="">
                        <div class="absolute bg-[#bababa73] w-[190px] h-full right-0 top-[-8px]" data-astro-cid-b7mymyte="">
                        </div>
                        <div class="w-full flex justify-between" data-astro-cid-b7mymyte="">
                            <div class="w-auto flex gap-3" data-astro-cid-b7mymyte="">
                                <p class="text-base font-normal w-32">Publisher</p><p class="text-base font-normal w-32">Ad Type</p>
                                <span class="w-auto flex gap-3" id="inputFieldsNameContainer_` + FlightId + `_` +
                CampaignId + `_` + CampaignLan + `_` + CampaignType + `_` + CategoryMasterId + `_` +
                counter + `"></span>
                            </div>
                            <div class="z-10 mr-3" data-astro-cid-b7mymyte="">
                                <p class="text-lg w-[165px] text-start" data-astro-cid-b7mymyte="">
                                    Due to Publisher
                                </p>
                            </div>
                        </div>
                        <div class="w-full flex justify-between" data-astro-cid-b7mymyte="">`;

            if (CategoryName != 'social') {
                let optionsHTML = '';

                // Make an AJAX request to fetch data from the server
                fetch('/fetch-advertisement-types/' + CategoryMasterId)
                    .then(response => response.json())
                    .then(data => {
                        // Iterate over the data and create option elements
                        data.forEach(advertisement => {
                            optionsHTML +=
                                `<option value="${advertisement.id}">${advertisement.name}</option>`;
                        });

                        // console.log(optionsHTML);
                        // Append the dynamically generated options to the select element
                        htmlContent += `
                            <div class="w-full flex gap-3" data-astro-cid-b7mymyte="">
                                <input type="text" value="" name="NewAdPublisher[` + FlightId + `][` + CampaignId +
                            `][` + CampaignLan + `][` + CampaignType + `][` + CategoryMasterId +
                            `][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher">
                                <select id="AdType_` + counter + `"
                                        onchange="getInputFields(` + FlightId + `,` + CampaignId + `,'` +
                            CampaignLan + `','` + CampaignType + `',` + CategoryMasterId + `,'` + CategoryName + `',` +
                            counter + `)"
                                    class="select select-primary w-32 rounded-md"
                                    name="NewAdType[` + FlightId + `][` + CampaignId + `][` + CampaignLan + `][` +
                            CampaignType + `][` + CategoryMasterId + `][]">
                                    ${optionsHTML}
                                </select>
                                <span class="w-auto flex gap-3" id="inputFieldsContainer_` + FlightId + `_` +
                            CampaignId + `_` + CampaignLan + `_` + CampaignType + `_` + CategoryMasterId + `_` +
                            counter + `"></span>
                            </div>`;

                        htmlContent += `
                                <div class="z-10 mr-3" data-astro-cid-b7mymyte="">
                                    <input type="date" value="" name="NewAdDate[` + FlightId +
                            `][` + CampaignId + `][` + CampaignLan +
                            `][` + CampaignType + `][` + CategoryMasterId + `][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte="" id="DueToPublisher">
                                </div>
                            </div>
                            <div class="divider my-0" data-astro-cid-b7mymyte=""></div>
                            </div>`;

                        document.querySelector('#AddContainer_' + CampaignId).innerHTML += htmlContent;
                    })
                    .catch(error => {
                        console.error('Error fetching advertisement types:', error);
                    });
            } else if (CategoryName == 'social') {
                let optionsHTML = '';

                // Make an AJAX request to fetch data from the server
                fetch('/fetch-advertisement-types/' + CategoryMasterId)
                    .then(response => response.json())
                    .then(data => {
                        // Iterate over the data and create option elements
                        data.forEach(advertisement => {
                            optionsHTML +=
                                `<option value="${advertisement.id}">${advertisement.name}</option>`;
                        });

                        // console.log(optionsHTML);
                        // Append the dynamically generated options to the select element
                        htmlContent += `
                            <div class="w-full flex gap-3" data-astro-cid-b7mymyte="">
                                <select
                                    id="publisher_12"
                                    onchange="getPublisherAdType(12)"
                                    class="select select-primary w-32 rounded-md"
                                    name="NewAdPublisher[` + FlightId + `][` + CampaignId + `][` + CampaignLan +
                            `][` + CampaignType + `][` + CategoryMasterId +
                            `][]"
                                    >
                                    <option value="" selected disabled>Select publisher</option>
                                    <option value="1">Meta</option>
                                    <option value="2">Pinterest</option>
                                    <option value="3">TikTok</option>
                                    <option value="4">SnapChat</option>
                                    <option value="5">X/Twitter</option>
                                    <option value="6">Podcast</option>
                                    <option value="7">Influencer</option>
                                </select>

                                <select id="AdType_` + counter + `" onchange="getInputFields(` + FlightId + `,` +
                            CampaignId + `,'` +
                            CampaignLan + `','` + CampaignType + `',` + CategoryMasterId + `,'` + CategoryName + `',` +
                            counter + `)" class="select select-primary w-32 rounded-md" name="NewAdType[` + FlightId +
                            `][` + CampaignId + `][` + CampaignLan +
                            `][` + CampaignType + `][` + CategoryMasterId + `][]">
                                    ${optionsHTML}
                                </select>
                                <span class="w-auto flex gap-3" id="inputFieldsContainer_` + FlightId + `_` +
                            CampaignId + `_` + CampaignLan + `_` + CampaignType + `_` + CategoryMasterId + `_` +
                            counter + `"></span>
                            </div>`;

                        htmlContent += `
                                <div class="z-10 mr-3" data-astro-cid-b7mymyte="">
                                    <input type="date" value="" name="NewAdDate[` + FlightId +
                            `][` + CampaignId + `][` + CampaignLan +
                            `][` + CampaignType + `][` + CategoryMasterId + `][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte="" id="DueToPublisher">
                                </div>
                            </div>
                            <div class="divider my-0" data-astro-cid-b7mymyte=""></div>
                            </div>`;


                        console.log(counter);
                        document.querySelector('#AddContainer_' + CampaignId).innerHTML += htmlContent;
                        htmlContent = '';
                    })
                    .catch(error => {
                        console.error('Error fetching advertisement types:', error);
                    });
            } else {
                // Append the completed htmlContent to the container
                document.querySelector('#AddContainer_' + CampaignId).innerHTML += htmlContent;
            }
        }

        //Newer one
        // function AddRow(FlightId, CampaignId, CampaignLan, CampaignType, CategoryMasterId, CategoryName, ContainerCounter) {
        //     counter++;
        //     let htmlContent = `
    //             <div class="flex w-full flex-col gap-2 relative" id="CopyContainer_9" data-row-template="" data-astro-cid-b7mymyte="">
    //                 <div class="absolute bg-[#bababa73] w-[190px] h-full right-0 top-[-8px]" data-astro-cid-b7mymyte="">
    //                 </div>
    //                 <div class="w-full flex justify-between" data-astro-cid-b7mymyte="">
    //                     <div class="w-auto flex gap-3" data-astro-cid-b7mymyte="">
    //                         <p class="text-base font-normal w-32">Publisher</p><p class="text-base font-normal w-32">Ad Type</p>
    //                         <span class="w-auto flex gap-3" id="inputFieldsNameContainer_` + FlightId + `_` +
        //         CampaignId + `_` + CampaignLan + `_` + CampaignType + `_` + CategoryMasterId + `_` +
        //         counter + `"></span>
    //                     </div>
    //                     <div class="z-10 mr-3" data-astro-cid-b7mymyte="">
    //                         <p class="text-lg w-[165px] text-start" data-astro-cid-b7mymyte="">
    //                             Due to Publisher
    //                         </p>
    //                     </div>
    //                 </div>
    //                 <div class="w-full flex justify-between" data-astro-cid-b7mymyte="">`;

        //     if (CategoryName != 'social') {
        //         let optionsHTML = '';

        //         // Make an AJAX request to fetch data from the server
        //         fetch('/fetch-advertisement-types/' + CategoryMasterId)
        //             .then(response => response.json())
        //             .then(data => {
        //                 // Iterate over the data and create option elements
        //                 data.forEach(advertisement => {
        //                     optionsHTML +=
        //                         `<option value="${advertisement.id}">${advertisement.name}</option>`;
        //                 });

        //                 // console.log(optionsHTML);
        //                 // Append the dynamically generated options to the select element
        //                 htmlContent += `
    //                     <div class="w-full flex gap-3" data-astro-cid-b7mymyte="">
    //                         <input type="text" value="" required name="AdPublisher[` + FlightId + `][` +
        //                     CampaignId +
        //                     `][` + CampaignLan + `][` + CampaignType + `][` + CategoryMasterId +
        //                     `][]" class="input input-bordered input-primary w-32 rounded-md" placeholder="publisher">
    //                         <select required id="AdType_` + counter + `"
    //                                 onchange="getInputFields(` + FlightId + `,` + CampaignId + `,'` +
        //                     CampaignLan + `','` + CampaignType + `',` + CategoryMasterId + `,'` + CategoryName + `',` +
        //                     counter + `)"
    //                             class="select select-primary w-32 rounded-md"
    //                             name="AdType[` + FlightId + `][` + CampaignId + `][` + CampaignLan + `][` +
        //                     CampaignType + `][` + CategoryMasterId + `][]">
    //                             ${optionsHTML}
    //                         </select>
    //                         <span class="w-auto flex gap-3" id="inputFieldsContainer_` + FlightId + `_` +
        //                     CampaignId + `_` + CampaignLan + `_` + CampaignType + `_` + CategoryMasterId + `_` +
        //                     counter + `"></span>
    //                     </div>`;

        //                 htmlContent += `
    //                         <div class="z-10 mr-3" data-astro-cid-b7mymyte="">
    //                             <input required type="date" value="" name="AdDate[` + FlightId +
        //                     `][` + CampaignId + `][` + CampaignLan +
        //                     `][` + CampaignType + `][` + CategoryMasterId + `][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte="" id="DueToPublisher">
    //                         </div>
    //                     </div>
    //                     <div class="divider my-0" data-astro-cid-b7mymyte=""></div>
    //                     </div>`;

        //                 document.querySelector('#AddContainer_' + CampaignId).innerHTML += htmlContent;
        //             })
        //             .catch(error => {
        //                 console.error('Error fetching advertisement types:', error);
        //             });
        //     } else if (CategoryName == 'social') {
        //         let optionsHTML = '';

        //         // Make an AJAX request to fetch data from the server
        //         fetch('/fetch-advertisement-types/' + CategoryMasterId)
        //             .then(response => response.json())
        //             .then(data => {
        //                 // Iterate over the data and create option elements
        //                 data.forEach(advertisement => {
        //                     optionsHTML +=
        //                         `<option value="${advertisement.id}">${advertisement.name}</option>`;
        //                 });

        //                 // console.log(optionsHTML);
        //                 // Append the dynamically generated options to the select element
        //                 htmlContent += `
    //                     <div class="w-full flex gap-3" data-astro-cid-b7mymyte="">
    //                         <select
    //                         required
    //                             id="publisher_12"
    //                             onchange="getPublisherAdType(12)"
    //                             class="select select-primary w-32 rounded-md"
    //                             name="AdPublisher[` + FlightId + `][` + CampaignId + `][` + CampaignLan +
        //                     `][` + CampaignType + `][` + CategoryMasterId +
        //                     `][]"
    //                             >
    //                             <option value="" selected disabled>Select publisher</option>
    //                             <option value="1">Meta</option>
    //                             <option value="2">Pinterest</option>
    //                             <option value="3">TikTok</option>
    //                             <option value="4">SnapChat</option>
    //                             <option value="5">X/Twitter</option>
    //                             <option value="6">Podcast</option>
    //                             <option value="7">Influencer</option>
    //                         </select>

    //                         <select required id="AdType_` + counter + `" onchange="getInputFields(` + FlightId +
        //                     `,` +
        //                     CampaignId + `,'` +
        //                     CampaignLan + `','` + CampaignType + `',` + CategoryMasterId + `,'` + CategoryName + `',` +
        //                     counter + `)" class="select select-primary w-32 rounded-md" name="AdType[` + FlightId +
        //                     `][` + CampaignId + `][` + CampaignLan +
        //                     `][` + CampaignType + `][` + CategoryMasterId + `][]">
    //                             ${optionsHTML}
    //                         </select>
    //                         <span class="w-auto flex gap-3" id="inputFieldsContainer_` + FlightId + `_` +
        //                     CampaignId + `_` + CampaignLan + `_` + CampaignType + `_` + CategoryMasterId + `_` +
        //                     counter + `"></span>
    //                     </div>`;

        //                 htmlContent += `
    //                         <div class="z-10 mr-3" data-astro-cid-b7mymyte="">
    //                             <input required type="date" value="" name="AdDate[` + FlightId +
        //                     `][` + CampaignId + `][` + CampaignLan +
        //                     `][` + CampaignType + `][` + CategoryMasterId + `][]" class="input input-bordered input-primary w-[165px]" placeholder="MM/DD/YYYY" data-astro-cid-b7mymyte="" id="DueToPublisher">
    //                         </div>
    //                     </div>
    //                     <div class="divider my-0" data-astro-cid-b7mymyte=""></div>
    //                     </div>`;


        //                 console.log(counter);
        //                 document.querySelector('#AddContainer_' + CampaignId).innerHTML += htmlContent;
        //                 htmlContent = '';
        //             })
        //             .catch(error => {
        //                 console.error('Error fetching advertisement types:', error);
        //             });
        //     } else {
        //         // Append the completed htmlContent to the container
        //         document.querySelector('#AddContainer_' + CampaignId).innerHTML += htmlContent;
        //     }
        // }
    </script>
    <script>
        function AddPrintRow(id) {
            const new = document.querySelector('#CopyContainer_' + id).cloneNode(true);

            const inputs = newRow.querySelectorAll('input, select');
            inputs.forEach(input => {
                const currentId = input.id || '';
                const currentName = input.getAttribute('name') || '';
                input.setAttribute('name', currentName);
            });
            // Append the cloned row element to the container
            document.querySelector('#AddContainer_' + id).appendChild(newRow);
        }
    </script>

    <script>
        function toggleFlight(id) {
            // Loop through all flight divs
            var flights = document.querySelectorAll('[id^="Flight_"]');
            flights.forEach(function(flightDiv) {
                // Check if the current flight div matches the specified ID
                if (flightDiv.id == `Flight_${id}`) {
                    // Show the flight div
                    flightDiv.removeAttribute('hidden');
                } else {
                    // Hide other flight divs
                    flightDiv.setAttribute('hidden', '');
                }
            });
        }
    </script>
    <script>
        function getPublisherAdType(id) {
            var publisher_Id = document.getElementById('publisher_' + id).value;
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '{{ route('getPublisherAdType') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    publisher_Id: publisher_Id,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(response) {
                    $('#AdType_' + id).empty();
                    $.each(response, function(key, value) {
                        $('#AdType_' + id).append('<option value="' + value.id +
                            '">' + value.name + '</option>');
                    });
                },
            });
        }


        function getInputFields(FlightsId, ConnectionId, ConnectionLang, ConnectionType, CategoryMasterId,
            CategoryMasterName, AddingCounter) {
            var AdType_id = document.getElementById('AdType_' + AddingCounter).value;
            // var CampaignId = document.getElementById('CampaignId').value;
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '{{ route('getEditInputFields') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    ad_type_id: AdType_id,
                    flightConnectionId: ConnectionId,

                    "_token": "{{ csrf_token() }}"
                },
                success: function(result) {
                    // Ensure unique IDs for each instance
                    var fieldNameContainer = $("#inputFieldsNameContainer_" + FlightsId + "_" + ConnectionId +
                        "_" + ConnectionLang + "_" + ConnectionType + "_" + CategoryMasterId + "_" +
                        AddingCounter);
                    var fieldContainer = $("#inputFieldsContainer_" + FlightsId + "_" + ConnectionId +
                        "_" + ConnectionLang + "_" + ConnectionType + "_" + CategoryMasterId + "_" +
                        AddingCounter);

                    // Empty the containers
                    fieldNameContainer.empty();
                    fieldContainer.empty();

                    // Append new content
                    fieldNameContainer.append(result.htmlFieldName);
                    fieldContainer.append(result.htmlField);
                },
            });
        }

        // function categoryShow(tag, Category, CampaingId) {
        //     var CopyContainer = document.querySelectorAll(`[class^="CopyContainer_${tag}_"]`);

        //     console.log(CopyContainer);

        //     CopyContainer.forEach(function(CopyContainerDiv) {
        //         if (CopyContainerDiv.id == `CopyContainer_${tag}_${CampaingId}`) {
        //             CopyContainerDiv.removeAttribute('hidden');
        //         } else {
        //             CopyContainerDiv.setAttribute('hidden', '');
        //         }
        //     });
        // }
        // function categoryShow(tag, Category, CampaignId) {
        //     // Use querySelectorAll to select all elements that start with 'CopyContainer_{tag}_'
        //     var copyContainers = document.querySelectorAll(`[id^="CopyContainer_${tag}_"]`);

        //     // Log the selected elements for debugging
        //     console.log(copyContainers);

        //     // Iterate over each selected element
        //     copyContainers.forEach(function(copyContainerDiv) {
        //         // Log the current element's ID for debugging
        //         console.log(copyContainerDiv.id);

        //         // Check if the current element's ID matches the pattern 'CopyContainer_{tag}_{CampaignId}'
        //         if (copyContainerDiv.id === `CopyContainer_${tag}_${CampaignId}`) {
        //             // Remove the 'hidden' attribute to show the element
        //             copyContainerDiv.removeAttribute('hidden');
        //             console.log(`Showing: ${copyContainerDiv.id}`);
        //         } else {
        //             // Set the 'hidden' attribute to hide the element
        //             copyContainerDiv.setAttribute('hidden', '');
        //             console.log(`Hiding: ${copyContainerDiv.id}`);
        //         }
        //     });
        // }

        function categoryShow(tag, Category, CampaignId) {
            // Use querySelectorAll to select all elements that start with 'CopyContainer_{tag}_'
            var copyContainers = document.querySelectorAll(`[id^="CopyContainer_${tag}_"]`);
            var container = document.querySelectorAll(`[id^="container_${tag}_"]`);
            var span = document.querySelectorAll(`[id^="Span_${tag}_"]`);

            // Log the selected elements for debugging
            console.log(copyContainers);

            // Iterate over each selected element
            copyContainers.forEach(function(copyContainerDiv) {
                // Log the current element's ID for debugging
                console.log(copyContainerDiv.id);

                // Check if the current element's ID matches the pattern 'CopyContainer_{tag}_{CampaignId}'
                if (copyContainerDiv.id === `CopyContainer_${tag}_${Category}`) {
                    // Remove the class to show the element
                    copyContainerDiv.classList.remove('hidden');
                    console.log(`Showing: ${copyContainerDiv.id}`);
                } else {
                    // Add the class to hide the element
                    copyContainerDiv.classList.add('hidden');
                    console.log(`Hiding: ${copyContainerDiv.id}`);
                }
            });


            container.forEach(function(containerDiv) {
                // Log the current element's ID for debugging
                console.log(containerDiv.id);

                // Check if the current element's ID matches the pattern 'CopyContainer_{tag}_{CampaignId}'
                if (containerDiv.id === `container_${tag}_${Category}`) {
                    // Remove the class to show the element
                    containerDiv.classList.remove('hidden');
                    console.log(`Showing: ${containerDiv.id}`);
                } else {
                    // Add the class to hide the element
                    containerDiv.classList.add('hidden');
                    console.log(`Hiding: ${containerDiv.id}`);
                }
            });

            span.forEach(function(spanDiv) {
                // Log the current element's ID for debugging
                console.log(spanDiv.id);

                // Check if the current element's ID matches the pattern 'CopyContainer_{tag}_{CampaignId}'
                if (spanDiv.id === `Span_${tag}_${Category}`) {
                    // Remove the class to show the element

                    spanDiv.classList.remove('bg-white');
                    spanDiv.classList.add('bg-black');
                    // Remove 'text-black' and add 'text-white'
                    spanDiv.classList.remove('text-black');
                    spanDiv.classList.add('text-white');
                    console.log(`Showing: ${spanDiv.id}`);
                } else {
                    // Add the class to hide the element
                    spanDiv.classList.add('bg-white');
                    spanDiv.classList.remove('bg-black');
                    // Add 'text-black' and remove 'text-white'
                    spanDiv.classList.add('text-black');
                    spanDiv.classList.remove('text-white');
                    console.log(`Hiding: ${spanDiv.id}`);
                }
            });
            toastr.success('Changed');
        }
    </script>
@endsection
