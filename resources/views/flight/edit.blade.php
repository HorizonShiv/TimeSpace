@extends('Layout.sidebar')
<style>
    /* Container */
    .select2-container {
        @apply w-full;
    }

    /* Dropdown */
    .select2-dropdown {
        @apply border border-gray-300 rounded-md shadow-md;
    }

    /* Selected option */
    .select2-selection {
        --tw-border-opacity: 1;
        border-color: var(--fallback-p, oklch(var(--p) / var(--tw-border-opacity)));
    }
</style>
<!-- CSS -->
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

<!-- JavaScript -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

@section('main-container')
    <div class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full" id="content" data-astro-cid-sckkx6r4>


        <div>
            <div class="flex justify-between">
                <h1 class="text-4xl font-semibold">Flight Setup</h1>
                <a href="/campaign/create/index.html">
                    <button
                        class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary">
                        <img src="/assets/sidebar/settings.png" class="w-[20px] h-[20px]" />
                        <p class="text-sm font-medium text-[#555555]">
                            Edit Settings
                        </p>
                    </button>
                </a>
            </div>
            <div class="my-7">
                <div class="flex flex-col w-full gap-7">
                    <div class="flex flex-col gap-1">
                        <p class="text-xl font-semibold">{{ $Campaign->User->name ?? '' }}</p>
                        <h2 class="text-4xl font-medium">{{ $Campaign->campaign_name ?? '' }}</h2>
                    </div>
                    <div class="flex gap-7 justify-start">
                        <div class="flex flex-col gap-1">
                            <p class="text-sm font-medium">Project Number</p>
                            <p class="text-base font-medium">{{ $Campaign->project_code }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-sm font-medium">Total Budget</p>
                            <p class="text-base font-medium">{{ $Campaign->budget }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-sm font-medium">Languages</p>
                            <p class="text-base font-medium">
                                @foreach ($Language as $lang)
                                    {{ $lang->language }}
                                @endforeach
                            </p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-sm font-medium">Team</p>
                            <div class="flex gap-1">
                                @foreach ($CampaignMember as $member)
                                    <div
                                        class="bg-[#c72ba4] flex justify-center items-center text-white w-8 h-8 rounded-full font-semibold border border-[#ea33c0]">
                                        {{ strtoupper(substr($member->User->name, 0, 2)) }}
                                    </div>
                                @endforeach


                            </div>
                        </div>
                    </div>
                    <div class="bg-[#EA33C0] h-[2px]"></div>
                </div>
            </div>
            <form method="POST" action="{{ route('flight-update') }}" enctype="multipart/form-data" class="mt-7"
                data-astro-cid-rwhxyfax>
                @csrf
                <input value="{{ $Campaign->id }}" name="CampaignId" hidden>




                <div>
                    @foreach ($Flights as $Flight)
                        @php
                            $fligthCounter = $Flight->flight_count;
                            $connectionRow = 1;
                        @endphp
                        <div class="flex w-full justify-center items-center">
                            <div class="flex w-full gap-10 items-center">
                                <h1 class="text-4xl font-semibold">Flight {{ $Flight->flight_count }}</h1>
                                <div class="flex gap-3 items-center">
                                    <p class="text-base font-medium">
                                        In Market Date
                                    </p>
                                    <input type="date" required name="startDate[{{ $fligthCounter }}]"
                                        class="input input-bordered input-primary"
                                        value="{{ $Flight->in_market_start_date }}" placeholder="MM/DD/YYYY" />
                                    <p class="text-sm font-medium">to</p>
                                    <input type="date" required name="endDate[{{ $fligthCounter }}]"
                                        class="input input-bordered input-primary"
                                        value="{{ $Flight->in_market_end_date }}" placeholder="MM/DD/YYYY" />
                                    <input type="hidden" required name="flightId[{{ $fligthCounter }}]"
                                        class="input input-bordered input-primary" value="{{ $Flight->id }}" hidden />
                                </div>
                            </div>
                            @if (Auth::user()->role == 'Media')
                                <div>
                                    <button type="button" onclick="deleteFlight({{ $Flight->id }})"
                                        class="btn btn-ghost w-36 rounded-3xl">
                                        Delete Flight
                                    </button>
                                </div>
                            @endif
                        </div>

                        @php
                            $FlightConnectionData = $Flight->FlightConnection->groupBy('tag');
                            $htmlCategories = [];
                            $htmlCategoriesChecker = [];
                        @endphp

                        {{-- grouping  --}}
                        @foreach ($FlightConnectionData as $ConnectionData)
                            @foreach ($ConnectionData as $Connection)
                                @foreach (\App\Models\CategoryMaster::all() as $Category)
                                    @if ($Connection->category_id == $Category->id)
                                        @php
                                            $htmlCategories[$Connection->tag][$Connection->id] =
                                                '<span class="badge bg-white text-black p-3 text-sm" >

                                                    <svg onclick="deleteFlightConnectionCategory(' .
                                                $Connection->id .
                                                ')" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        xmlns="http://www.w3.org/2000/svg" width="25"
                                                        onclick="removeRow(0,1)" height="25" viewBox="0 0 24 24"
                                                        fill="none" >
                                                        <path
                                                            d="M6.99486 7.00636C6.60433 7.39689 6.60433 8.03005 6.99486 8.42058L10.58 12.0057L6.99486 15.5909C6.60433 15.9814 6.60433 16.6146 6.99486 17.0051C7.38538 17.3956 8.01855 17.3956 8.40907 17.0051L11.9942 13.4199L15.5794 17.0051C15.9699 17.3956 16.6031 17.3956 16.9936 17.0051C17.3841 16.6146 17.3841 15.9814 16.9936 15.5909L13.4084 12.0057L16.9936 8.42059C17.3841 8.03007 17.3841 7.3969 16.9936 7.00638C16.603 6.61585 15.9699 6.61585 15.5794 7.00638L11.9942 10.5915L8.40907 7.00636C8.01855 6.61584 7.38538 6.61584 6.99486 7.00636Z"
                                                            fill="#BABABA" ></path>
                                                    </svg>' .
                                                $Category->name .
                                                '</span>';

                                            $htmlCategoriesChecker[$Connection->tag][$Connection->id] = $Category->name;
                                        @endphp
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach



                        <div class="divider my-3"></div>
                        <div class="flex flex-col gap-1 w-full" id="">
                            @foreach ($FlightConnectionData as $ConnectionData)
                                @php
                                    $multiFlightConnectionChecker = false;
                                @endphp
                                @foreach ($ConnectionData as $Connection)
                                    <div class="flex relative items-start gap-4">
                                        @if (!$multiFlightConnectionChecker)
                                            @if (Auth::user()->role == 'Media')
                                                <div onclick="deleteFlightConnection({{ $Flight->id }},'{{ $Connection->tag }}')"
                                                    class="absolute left-[-30px] top-3">
                                                    <svg xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        xmlns="http://www.w3.org/2000/svg" width="25"
                                                        onclick="removeRow(0,1)" height="25" viewBox="0 0 24 24"
                                                        fill="none">
                                                        <path
                                                            d="M6.99486 7.00636C6.60433 7.39689 6.60433 8.03005 6.99486 8.42058L10.58 12.0057L6.99486 15.5909C6.60433 15.9814 6.60433 16.6146 6.99486 17.0051C7.38538 17.3956 8.01855 17.3956 8.40907 17.0051L11.9942 13.4199L15.5794 17.0051C15.9699 17.3956 16.6031 17.3956 16.9936 17.0051C17.3841 16.6146 17.3841 15.9814 16.9936 15.5909L13.4084 12.0057L16.9936 8.42059C17.3841 8.03007 17.3841 7.3969 16.9936 7.00638C16.603 6.61585 15.9699 6.61585 15.5794 7.00638L11.9942 10.5915L8.40907 7.00636C8.01855 6.61584 7.38538 6.61584 6.99486 7.00636Z"
                                                            fill="#BABABA"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        @endif

                                        <div class="flex gap-3 items-center">

                                            @if (!$multiFlightConnectionChecker)
                                                <select class="select select-primary w-[150px] rounded-md"
                                                    name="lang[{{ $Flight->flight_count }}][{{ $connectionRow }}]"
                                                    id="Flight_{{ $Flight->flight_count }}_lang_0" required>
                                                    <option {{ $Connection->language == 'EN' ? 'Selected' : '' }}
                                                        value="EN">
                                                        EN
                                                    </option>
                                                    <option {{ $Connection->language == 'FR' ? 'Selected' : '' }}
                                                        value="FR">FR</option>
                                                </select>
                                                <select class="select select-primary w-[150px] rounded-md"
                                                    name="type[{{ $Flight->flight_count }}][{{ $connectionRow }}]"
                                                    id="Flight_1_type_0" required>
                                                    <option {{ $Connection->type == 'Awareness' ? 'Selected' : '' }}>
                                                        Awareness
                                                    </option>
                                                    <option {{ $Connection->type == 'Consideration' ? 'Selected' : '' }}>
                                                        Consideration
                                                    </option>
                                                    <option {{ $Connection->type == 'Trial' ? 'Selected' : '' }}>
                                                        Trial
                                                    </option>

                                                </select>
                                                <input type="text"
                                                    name="location[{{ $Flight->flight_count }}][{{ $connectionRow }}]"
                                                    id="Flight_{{ $Flight->flight_count }}_location_0"
                                                    value="{{ $Connection->location }}"
                                                    class="input input-bordered input-primary min-w-36 rounded-md"
                                                    placeholder="Nova Scotia<" required />
                                                <select class="select select-primary w-[150px] rounded-md select21"
                                                    name="category[{{ $Flight->flight_count }}][{{ $connectionRow }}][]"
                                                    id="Flight_{{ $Flight->flight_count }}_category_{{ $connectionRow }}"
                                                    multiple>

                                                    @foreach (\App\Models\CategoryMaster::all() as $Category)
                                                        @if (!in_array($Category->name, $htmlCategoriesChecker[$Connection->tag]))
                                                            <option value="{{ $Category->id }}">
                                                                {{ $Category->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>

                                                <input type="hidden"
                                                    name="flightConnectionId[{{ $Flight->flight_count }}][{{ $connectionRow }}]"
                                                    id="Flight_{{ $Flight->flight_count }}_location_0"
                                                    value="{{ $Flight->id }}#{{ $Connection->tag }}"
                                                    class="input input-bordered input-primary min-w-36  rounded-md"
                                                    placeholder="Nova Scotia<" />

                                                @foreach ($htmlCategories[$Connection->tag] as $Key => $data)
                                                    {!! $data !!}
                                                @endforeach
                                            @endif
                                        </div>

                                        <div class="flex flex-wrap items-center gap-3">
                                        </div>

                                    </div>
                                    @if (!$multiFlightConnectionChecker)
                                        <div class="divider my-3"></div>
                                    @endif
                                    @php
                                        $multiFlightConnectionChecker = true; // Set the variable to true to indicate English assets have been displayed
                                        $connectionRow++;
                                    @endphp
                                @endforeach
                            @endforeach
                            <div id="contentContainerFlight_{{ $Flight->flight_count }}"></div>


                            @if (Auth::user()->role == 'Media')
                                <button type="button"
                                    class="btn btn-outline no-animation btn-accent rounded-3xl w-32 svg-container text-[#555555]"
                                    id="addNewRow" onclick="AddRow({{ $Flight->flight_count }});">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481"
                                        viewBox="0 0 15.481 15.481">
                                        <path id="add_FILL0_wght400_GRAD0_opsz24"
                                            d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z"
                                            transform="translate(-200 760)" fill="#ea33c0"></path>
                                    </svg>
                                    Add Row
                                </button>

                                <div class="divider my-3"></div>
                            @endif
                    @endforeach
                    <div id="MainFlightContainer"></div>


                    @if (Auth::user()->role == 'Media')
                        <div class="flex gap-4">
                            <button type="button" onclick="addFlight();"
                                class="btn btn-outline no-animation btn-accent rounded-3xl w-48 svg-container text-[#555555]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481"
                                    viewBox="0 0 15.481 15.481">
                                    <path id="add_FILL0_wght400_GRAD0_opsz24"
                                        d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z"
                                        transform="translate(-200 760)" fill="#ea33c0"></path>
                                </svg>
                                Add New Flight
                            </button>
                        </div>

                        <div class="divider my-3"></div>
                    @endif
                    @if (Auth::user()->role == 'Media')
                        <div>
                            <button type="submit" class="btn rounded-full bg-accent text-white no-animation w-48">
                                Save Changes
                            </button>
                        </div>
                    @endif
                </div>
        </div>



        </form>
    </div>
    </div>


    @php
        $lang = json_encode($Language);
    @endphp

    <script>
        $(document).ready(function() {
            $('.select21').select2();

        });
        var counter = {{ $connectionRow }};
        var flightCounter = {{ $fligthCounter }};

        function AddRow(flightCounter) {
            counter++;
            var lang = <?php echo $lang; ?>;
            console.log(lang);
            let htmlContent = `
<div
    class="flex relative items-start gap-4"
    id="Flight_` + flightCounter + `_Row_` + counter + `"

>
    <div
        class="absolute left-[-30px] top-3"

    >
        <svg
            xmlns:xlink="http://www.w3.org/1999/xlink"
            xmlns="http://www.w3.org/2000/svg"
            onclick="removeRow(` + counter + `,` + flightCounter + `)"
            width="25"
            height="25"
            viewBox="0 0 24 24"
            fill="none"

        >
            <path
                d="M6.99486 7.00636C6.60433 7.39689 6.60433 8.03005 6.99486 8.42058L10.58 12.0057L6.99486 15.5909C6.60433 15.9814 6.60433 16.6146 6.99486 17.0051C7.38538 17.3956 8.01855 17.3956 8.40907 17.0051L11.9942 13.4199L15.5794 17.0051C15.9699 17.3956 16.6031 17.3956 16.9936 17.0051C17.3841 16.6146 17.3841 15.9814 16.9936 15.5909L13.4084 12.0057L16.9936 8.42059C17.3841 8.03007 17.3841 7.3969 16.9936 7.00638C16.603 6.61585 15.9699 6.61585 15.5794 7.00638L11.9942 10.5915L8.40907 7.00636C8.01855 6.61584 7.38538 6.61584 6.99486 7.00636Z"
                fill="#BABABA"

            ></path>
        </svg>
    </div>
    <div class="flex gap-3 items-center" >
        <select
            name="lang[` + flightCounter + `][` + counter + `]"
            id="Flight_` + flightCounter + `_lang_[` + counter + `]"
            class="select select-primary w-[150px] rounded-md"
             required
        >`;

            lang.forEach(function(langItem, index) {
                htmlContent += `
                 <option >` + langItem.language + `</option>`;
            });

            htmlContent += `
        </select>
        <select
            class="select select-primary w-[150px] rounded-md"
            name="type[` + flightCounter + `][` + counter + `]"
            id="Flight_` + flightCounter + `_type_` + counter + `"
             required
        >
            <option selected >Awareness</option>
            <option >Consideration</option>
            <option >Trial</option>
        </select>
        <input
            type="text"
            name="location[` + flightCounter + `][` + counter + `]"
            id="Flight_` + flightCounter + `_location_` + counter + `"
            class="input input-bordered input-primary min-w-36 rounded-md"
            placeholder="Nova Scotia<"
             required
        />
        <select
            class="select select-primary w-[150px] rounded-md"
            name="category[` + flightCounter + `][` + counter + `][]"
            id="Flight_` + flightCounter + `_category` + counter + `"
             multiple required
        >
        @foreach (\App\Models\CategoryMaster::all() as $Category)
            <option value="{{ $Category->id }}">
                {{ $Category->name }}</option>
        @endforeach
        </select>
        <strong>
            <div id="categoryDisplay_` + flightCounter + `_` + counter + `"></div>
        </strong>
    </div>
    <div
        class="flex flex-wrap items-center gap-3"

    >
    </div>
</div>
<div class="divider my-3" id="Flight_` + flightCounter + `_Divider_` + counter + `" ></div>
`;
            // document.getElementById('contentContainerFlight_' + flightCounter).innerHTML += htmlContent;
            // $('#Flight_' + flightCounter + '_category' + counter).select2();

            $('#contentContainerFlight_' + flightCounter).append(htmlContent);
            $('#Flight_' + flightCounter + '_category' + counter).select2();
            htmlContent = '';

        }



        function removeRow(counter, flight) {
            var Row = document.getElementById("Flight_" + flight + "_Row_" + counter);
            var Divider = document.getElementById("Flight_" + flight + "_Divider_" + counter);
            if (Row) {
                Row.remove();
                Divider.remove();
            } else {
                console.log("Element with ID 'Row_" + counter + "' not found.");
            }
        }

        function removeFlight(flight) {
            var FlightRow = document.getElementById("Flight_Row_" + flight);
            if (FlightRow) {
                FlightRow.remove();
            } else {
                console.log("Element with ID 'Row_" + counter + "' not found.");
            }
        }

        function addFlight() {
            flightCounter++;
            var lang = <?php echo $lang; ?>;
            console.log(lang);
            let flightContent = `
<div  id="Flight_Row_` + flightCounter + `">
    <div class="flex w-full justify-center items-center" >
        <div class="flex w-full gap-10 items-center" >
            <h1 class="text-4xl font-semibold">Flight ` + flightCounter + `</h1>
            <div class="flex gap-3 items-center" >
                <p class="text-base font-medium" >In Market Date</p>
                <input type="date" required name="startDate[` + flightCounter + `]" class="input input-bordered input-primary" placeholder="MM/DD/YYYY"  />
                <p class="text-sm font-medium" >to</p>
                <input type="date" required name="endDate[` + flightCounter + `]" class="input input-bordered input-primary" placeholder="MM/DD/YYYY"  />
            </div>
        </div>
        <div >
            <button class="btn btn-ghost w-36 rounded-3xl" onclick="removeFlight(` + flightCounter + `);" ta-astro-cid-jf5gi763>Delete Flight</button>
        </div>
    </div>
    <div class="divider my-3" ></div>
    <div class="flex flex-col gap-1 w-full"  id="">
        <div class="flex relative items-start gap-4" >
            <div class="absolute left-[-30px] top-3" >
                <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="25" onclick="removeRow(0)" height="25" viewBox="0 0 24 24" fill="none" >
                    <path d="M6.99486 7.00636C6.60433 7.39689 6.60433 8.03005 6.99486 8.42058L10.58 12.0057L6.99486 15.5909C6.60433 15.9814 6.60433 16.6146 6.99486 17.0051C7.38538 17.3956 8.01855 17.3956 8.40907 17.0051L11.9942 13.4199L15.5794 17.0051C15.9699 17.3956 16.6031 17.3956 16.9936 17.0051C17.3841 16.6146 17.3841 15.9814 16.9936 15.5909L13.4084 12.0057L16.9936 8.42059C17.3841 8.03007 17.3841 7.3969 16.9936 7.00638C16.603 6.61585 15.9699 6.61585 15.5794 7.00638L11.9942 10.5915L8.40907 7.00636C8.01855 6.61584 7.38538 6.61584 6.99486 7.00636Z" fill="#BABABA" ></path>
                </svg>
            </div>
            <div class="flex gap-3 items-center" >
                <select required class="select select-primary w-[150px] rounded-md" name="lang[` + flightCounter +
                `][1]" id="Flight_` + flightCounter +
                `_lang_0" >`;
            lang.forEach(function(langItem, index) {
                flightContent += `
                 <option >` + langItem.language + `</option>`;
            });
            flightContent += `
                </select>
                <select required class="select select-primary w-[150px] rounded-md" name="type[` + flightCounter + `][1]" id="type_0" >
                    <option  selected >Awareness</option>
                    <option >Consideration</option>
                    <option >Trial</option>
                </select>
                <input required type="text" name="location[` + flightCounter + `][1]" id="Flight_` + flightCounter + `_location_0" class="input input-bordered input-primary min-w-36 rounded-md" placeholder="Nova Scotia<"  />
                <select required class="select select-primary w-[150px] rounded-md" name="category[` + flightCounter +
                `][1][]" id="Flight_` + flightCounter + `_category_1"  multiple>
                    @foreach (\App\Models\CategoryMaster::all() as $Category)
                        <option value="{{ $Category->id }}">
                            {{ $Category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-wrap items-center gap-3" >
            </div>
        </div>
        <div class="divider my-3" ></div>
        <div id="contentContainerFlight_` + flightCounter +
                `"></div>
        <button class="btn btn-outline no-animation btn-accent rounded-3xl w-32 svg-container text-[#555555]" type="button" id="addNewRow" onclick="AddRow(` +
                flightCounter + `);" >
            <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481" viewBox="0 0 15.481 15.481" >
                <path id="add_FILL0_wght400_GRAD0_opsz24" d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z" transform="translate(-200 760)" fill="#ea33c0" ></path>
            </svg>
            Add Row
        </button>
        <div class="divider my-3" ></div>
    </div>
</div>
`;

            // document.getElementById('MainFlightContainer').innerHTML += flightContent;
            document.getElementById('MainFlightContainer').insertAdjacentHTML('beforeend', flightContent);
            $('#Flight_' + flightCounter + '_category_1').select2();
        }

        $(document).ready(function() {
            $('#Flight_1_category_0').select2();
        });


        function deleteFlightConnectionCategory(ConnectionId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#overlay").fadeIn(100);
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('flight-connection-category-delete') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            connectionId: ConnectionId,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(resultData) {
                            Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                                location.reload();
                                $("#overlay").fadeOut(100);
                            });
                        }
                    });
                }
            });
        }

        function deleteFlightConnection(FlightId, ConnectionTag) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#overlay").fadeIn(100);
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('flight-connection-delete') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            flightId: FlightId,
                            connectionTag: ConnectionTag,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(resultData) {
                            Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                                location.reload();
                                $("#overlay").fadeOut(100);
                            });
                        }
                    });
                }
            });
        }

        function deleteFlight(FlightId) {

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#overlay").fadeIn(100);
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('flight-delete') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            flightId: FlightId,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(resultData) {
                            if (resultData.success) {
                                if (resultData.redirect == 1) {
                                    Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                                        window.location.href = '/flight/create/' + resultData
                                            .campaign_id;
                                        $("#overlay").fadeOut(100);
                                    });

                                    // Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                                    //     this.$router.push(`/flight/create/` + resultData
                                    //         .campaign_id);
                                    //     $("#overlay").fadeOut(100);
                                    // });
                                } else {
                                    Swal.fire('Done', 'Successfully! Done', 'success').then(() => {
                                        location.reload();
                                        $("#overlay").fadeOut(100);
                                    });
                                }
                            }

                        }
                    });
                }
            });
        }
    </script>
@endsection
