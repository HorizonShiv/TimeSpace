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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@section('main-container')
    <div class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full" id="content" data-astro-cid-sckkx6r4>


        <div data-astro-cid-jf5gi763>
            <div class="flex justify-between" data-astro-cid-jf5gi763>
                <h1 class="text-4xl font-semibold">Flight Setup</h1>
                <a href="/campaign/create/index.html" data-astro-cid-jf5gi763>
                    <button
                        class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                        data-astro-cid-jf5gi763>
                        <img src="/assets/sidebar/settings.png" class="w-[20px] h-[20px]" data-astro-cid-jf5gi763 />
                        <p class="text-sm font-medium text-[#555555]" data-astro-cid-jf5gi763>
                            Edit Settings
                        </p>
                    </button>
                </a>
            </div>
            <div class="my-7" data-astro-cid-jf5gi763>
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
                                {{-- @php
                                    $LangCounter = 1;
                                @endphp --}}
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
            <form method="post" action="{{ route('Flight.store') }}" enctype="multipart/form-data" class="mt-7"
                data-astro-cid-rwhxyfax>
                @csrf
                <input value="{{ $Campaign->id }}" name="CampaignId" hidden>
                <div data-astro-cid-jf5gi763>
                    <div class="flex w-full justify-center items-center" data-astro-cid-jf5gi763>
                        <div class="flex w-full gap-10 items-center" data-astro-cid-jf5gi763>
                            <h1 class="text-4xl font-semibold">Flight 1</h1>
                            <div class="flex gap-3 items-center" data-astro-cid-jf5gi763>
                                <p class="text-base font-medium" data-astro-cid-jf5gi763>
                                    In Market Date
                                </p>
                                <input type="date" required name="startDate[1]"
                                    class="input input-bordered input-primary" placeholder="MM/DD/YYYY"
                                    data-astro-cid-jf5gi763 />
                                <p class="text-sm font-medium" data-astro-cid-jf5gi763>to</p>
                                <input type="date" required name="endDate[1]" class="input input-bordered input-primary"
                                    placeholder="MM/DD/YYYY" data-astro-cid-jf5gi763 />
                            </div>
                        </div>
                        <div data-astro-cid-jf5gi763>
                            <button type="button" class="btn btn-ghost w-36 rounded-3xl" data-astro-cid-jf5gi763>
                                Delete Flight
                            </button>
                        </div>
                    </div>
                    <div class="divider my-3" data-astro-cid-jf5gi763></div>
                    <div class="flex flex-col gap-1 w-full" data-astro-cid-jf5gi763 id="">
                        <div class="w-full flex gap-3" style="margin-bottom:15px;" data-astro-cid-b7mymyte>
                            <p class="text-base font-normal w-[150px]">Language</p>
                            <p class="text-base font-normal w-[150px]">Objective</p>
                            <p class="text-base font-normal" style="width:215px;">Region</p>
                            <p class="text-base font-normal w-[150px]">Ad Categories</p>
                        </div>
                        <div class="flex relative items-start gap-4" data-astro-cid-jf5gi763>
                            <div class="absolute left-[-30px] top-3" data-astro-cid-jf5gi763>
                                <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"
                                    width="25" onclick="removeRow(0,1)" height="25" viewBox="0 0 24 24"
                                    fill="none" data-astro-cid-jf5gi763>
                                    <path
                                        d="M6.99486 7.00636C6.60433 7.39689 6.60433 8.03005 6.99486 8.42058L10.58 12.0057L6.99486 15.5909C6.60433 15.9814 6.60433 16.6146 6.99486 17.0051C7.38538 17.3956 8.01855 17.3956 8.40907 17.0051L11.9942 13.4199L15.5794 17.0051C15.9699 17.3956 16.6031 17.3956 16.9936 17.0051C17.3841 16.6146 17.3841 15.9814 16.9936 15.5909L13.4084 12.0057L16.9936 8.42059C17.3841 8.03007 17.3841 7.3969 16.9936 7.00638C16.603 6.61585 15.9699 6.61585 15.5794 7.00638L11.9942 10.5915L8.40907 7.00636C8.01855 6.61584 7.38538 6.61584 6.99486 7.00636Z"
                                        fill="#BABABA" data-astro-cid-jf5gi763></path>
                                </svg>
                            </div>

                            <div class="flex gap-3 items-center" data-astro-cid-jf5gi763>

                                <select class="select select-primary w-[150px] rounded-md" name="lang[1][1]"
                                    id="Flight_1_lang_0" data-astro-cid-jf5gi763 required>
                                    @foreach ($Language as $lang)
                                        <option data-astro-cid-jf5gi763>{{ $lang->language }}</option>
                                    @endforeach
                                </select>
                                <select class="select select-primary w-[150px] rounded-md" name="type[1][1]"
                                    id="Flight_1_type_0" data-astro-cid-jf5gi763 required>
                                    <option selected data-astro-cid-jf5gi763>
                                        Awareness
                                    </option>

                                    <option data-astro-cid-jf5gi763>
                                        Consideration
                                    </option>
                                    <option data-astro-cid-jf5gi763>
                                        Trial
                                    </option>

                                </select>
                                <input type="text" name="location[1][1]" id="Flight_1_location_0"
                                    class="input input-bordered input-primary min-w-36 rounded-md"
                                    placeholder="Nova Scotia<" data-astro-cid-jf5gi763 required />
                                <select class="select select-primary w-[150px] category rounded-md" name="category[1][1][]"
                                    id="Flight_1_category_1" data-astro-cid-jf5gi763 required multiple>
                                    @foreach (\App\Models\CategoryMaster::all() as $Category)
                                        <option value="{{ $Category->id }}">{{ $Category->name }}</option>
                                    @endforeach
                                </select>

                                <strong>
                                    <div id="categoryDisplay_1_1"></div>
                                </strong>
                            </div>
                            <div class="flex flex-wrap items-center gap-3" data-astro-cid-jf5gi763>
                            </div>
                        </div>
                        <div class="divider my-3" data-astro-cid-jf5gi763></div>
                        <div id="contentContainerFlight_1"></div>


                        <button type="button"
                            class="btn btn-outline no-animation btn-accent rounded-3xl w-32 svg-container text-[#555555]"
                            id="addNewRow" onclick="AddRow(1);" data-astro-cid-jf5gi763>
                            <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481"
                                viewBox="0 0 15.481 15.481" data-astro-cid-jf5gi763>
                                <path id="add_FILL0_wght400_GRAD0_opsz24"
                                    d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z"
                                    transform="translate(-200 760)" fill="#ea33c0" data-astro-cid-jf5gi763></path>
                            </svg>
                            Add Row
                        </button>
                        <div class="divider my-3" data-astro-cid-jf5gi763></div>


                        <div id="MainFlightContainer"></div>


                        <div class="flex gap-4" data-astro-cid-jf5gi763>
                            <button type="button" onclick="addFlight();"
                                class="btn btn-outline no-animation btn-accent rounded-3xl w-48 svg-container text-[#555555]"
                                data-astro-cid-jf5gi763>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481"
                                    viewBox="0 0 15.481 15.481" data-astro-cid-jf5gi763>
                                    <path id="add_FILL0_wght400_GRAD0_opsz24"
                                        d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z"
                                        transform="translate(-200 760)" fill="#ea33c0" data-astro-cid-jf5gi763></path>
                                </svg>
                                Add New Flight
                            </button>
                            <button type="button"
                                class="btn btn-outline no-animation btn-accent rounded-3xl w-64 svg-container text-[#555555]"
                                data-astro-cid-jf5gi763>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481"
                                    viewBox="0 0 15.481 15.481" data-astro-cid-jf5gi763>
                                    <path id="add_FILL0_wght400_GRAD0_opsz24"
                                        d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z"
                                        transform="translate(-200 760)" fill="#ea33c0" data-astro-cid-jf5gi763></path>
                                </svg>
                                Duplicate Previous Flight
                            </button>
                        </div>
                        <div class="divider my-3" data-astro-cid-jf5gi763></div>
                        <div data-astro-cid-jf5gi763>
                            <button type="submit" class="btn rounded-full bg-accent text-white no-animation w-48"
                                data-astro-cid-jf5gi763>
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@php
    $lang = json_encode($Language);
@endphp

<script>
    var counter = 1;
    var flightCounter = 1;

    function AddRow(flightCounter) {
        counter++;

        var lang = <?php echo $lang; ?>;
        console.log(lang);
        let htmlContent = `
<div
    class="flex relative items-start gap-4"
    id="Flight_` + flightCounter + `_Row_` + counter + `"
    data-astro-cid-jf5gi763
>
    <div
        class="absolute left-[-30px] top-3"
        data-astro-cid-jf5gi763
    >
        <svg
            xmlns:xlink="http://www.w3.org/1999/xlink"
            xmlns="http://www.w3.org/2000/svg"
            onclick="removeRow(` + counter + `,` + flightCounter + `)"
            width="25"
            height="25"
            viewBox="0 0 24 24"
            fill="none"
            data-astro-cid-jf5gi763
        >
            <path
                d="M6.99486 7.00636C6.60433 7.39689 6.60433 8.03005 6.99486 8.42058L10.58 12.0057L6.99486 15.5909C6.60433 15.9814 6.60433 16.6146 6.99486 17.0051C7.38538 17.3956 8.01855 17.3956 8.40907 17.0051L11.9942 13.4199L15.5794 17.0051C15.9699 17.3956 16.6031 17.3956 16.9936 17.0051C17.3841 16.6146 17.3841 15.9814 16.9936 15.5909L13.4084 12.0057L16.9936 8.42059C17.3841 8.03007 17.3841 7.3969 16.9936 7.00638C16.603 6.61585 15.9699 6.61585 15.5794 7.00638L11.9942 10.5915L8.40907 7.00636C8.01855 6.61584 7.38538 6.61584 6.99486 7.00636Z"
                fill="#BABABA"
                data-astro-cid-jf5gi763
            ></path>
        </svg>
    </div>
    <div class="flex gap-3 items-center" data-astro-cid-jf5gi763>
        <select
            name="lang[` + flightCounter + `][` + counter + `]"
            id="Flight_` + flightCounter + `_lang_[` + counter + `]"
            class="select select-primary w-[150px] rounded-md"
            data-astro-cid-jf5gi763 required
        ><option selected disabled>Language</option>`;

            lang.forEach(function(langItem, index) {
                htmlContent += `
                    <option data-astro-cid-jf5gi763>` + langItem.language + `</option>`;
            });
            htmlContent += `
        </select>
        <select
            class="select select-primary w-[150px] rounded-md"
            name="type[` + flightCounter + `][` + counter + `]"
            id="Flight_` + flightCounter + `_type_` + counter + `"
            data-astro-cid-jf5gi763 required
        >
            <option selected data-astro-cid-jf5gi763>Awareness</option>
            <option data-astro-cid-jf5gi763>Consideration</option>
            <option data-astro-cid-jf5gi763>Trial</option>
        </select>
        <input
            type="text"
            name="location[` + flightCounter + `][` + counter + `]"
            id="Flight_` + flightCounter + `_location_` + counter + `"
            class="input input-bordered input-primary min-w-36 rounded-md"
            placeholder="Nova Scotia<"
            data-astro-cid-jf5gi763 required
        />
        <select
            class="select select-primary w-[150px] rounded-md"
            name="category[` + flightCounter + `][` + counter + `][]"
            id="Flight_` + flightCounter + `_category_` + counter + `"
            data-astro-cid-jf5gi763 required multiple
        >
        @foreach (\App\Models\CategoryMaster::all() as $Category)
            <option value="{{ $Category->id }}">{{ $Category->name }}</option>
        @endforeach
        </select>
        <strong><div id="categoryDisplay_` + flightCounter + `_` + counter + `"></div></strong>
    </div>
    <div
        class="flex flex-wrap items-center gap-3"
        data-astro-cid-jf5gi763
    >
    </div>
</div>
<div class="divider my-3" id="Flight_` + flightCounter + `_Divider_` + counter + `" data-astro-cid-jf5gi763></div>
`;

        document.getElementById('contentContainerFlight_' + flightCounter).innerHTML += htmlContent;
        $('#Flight_' + flightCounter + '_category_' + counter).select2();

    }

    function getCategoryName(flightId, rowId) {
        var ad_type = document.getElementById('Flight_' + flightId + '_category_' + rowId).value;
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{{ route('getCategoryName') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                ad_id: ad_type,
                "_token": "{{ csrf_token() }}"
            },
            success: function(result) {
                $("#categoryDisplay_" + flightId + "_" + rowId).html(result.name);
            },
        });
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
        var lang = <?php echo $lang; ?>;
        console.log(lang);

        flightCounter++;
        let flightContent = `
<div data-astro-cid-jf5gi763 id="Flight_Row_` + flightCounter + `" >
    <div class="flex w-full justify-center items-center" data-astro-cid-jf5gi763>
        <div class="flex w-full gap-10 items-center" data-astro-cid-jf5gi763>
            <h1 class="text-4xl font-semibold">Flight ` + flightCounter + `</h1>
            <div class="flex gap-3 items-center" data-astro-cid-jf5gi763>
                <p class="text-base font-medium" data-astro-cid-jf5gi763>In Market Date</p>
                <input type="date" required name="startDate[` + flightCounter + `]" class="input input-bordered input-primary" placeholder="MM/DD/YYYY" data-astro-cid-jf5gi763 />
                <p class="text-sm font-medium" data-astro-cid-jf5gi763>to</p>
                <input type="date" required name="endDate[` + flightCounter + `]" class="input input-bordered input-primary" placeholder="MM/DD/YYYY" data-astro-cid-jf5gi763 />
            </div>
        </div>
        <div data-astro-cid-jf5gi763>
            <button class="btn btn-ghost w-36 rounded-3xl" onclick="removeFlight(` + flightCounter + `);" ta-astro-cid-jf5gi763>Delete Flight</button>
        </div>
    </div>
    <div class="divider my-3" data-astro-cid-jf5gi763></div>
    <div class="flex flex-col gap-1 w-full" data-astro-cid-jf5gi763 id="">
        <div class="w-full flex gap-3" style="margin-bottom:15px;" data-astro-cid-b7mymyte>
                            <p class="text-base font-normal w-[150px]">Language</p>
                            <p class="text-base font-normal w-[150px]">Objective</p>
                            <p class="text-base font-normal" style="width:215px;">Region</p>
                            <p class="text-base font-normal w-[150px]">Ad Categories</p>
                        </div>
        <div class="flex relative items-start gap-4" data-astro-cid-jf5gi763>
            <div class="absolute left-[-30px] top-3" data-astro-cid-jf5gi763>
                <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="25" onclick="removeRow(0)" height="25" viewBox="0 0 24 24" fill="none" data-astro-cid-jf5gi763>
                    <path d="M6.99486 7.00636C6.60433 7.39689 6.60433 8.03005 6.99486 8.42058L10.58 12.0057L6.99486 15.5909C6.60433 15.9814 6.60433 16.6146 6.99486 17.0051C7.38538 17.3956 8.01855 17.3956 8.40907 17.0051L11.9942 13.4199L15.5794 17.0051C15.9699 17.3956 16.6031 17.3956 16.9936 17.0051C17.3841 16.6146 17.3841 15.9814 16.9936 15.5909L13.4084 12.0057L16.9936 8.42059C17.3841 8.03007 17.3841 7.3969 16.9936 7.00638C16.603 6.61585 15.9699 6.61585 15.5794 7.00638L11.9942 10.5915L8.40907 7.00636C8.01855 6.61584 7.38538 6.61584 6.99486 7.00636Z" fill="#BABABA" data-astro-cid-jf5gi763></path>
                </svg>
            </div>
            <div class="flex gap-3 items-center" data-astro-cid-jf5gi763>
                <select required class="select select-primary w-[150px] rounded-md" name="lang[` + flightCounter +
            `][1]" id="Flight_` + flightCounter + `_lang_0" data-astro-cid-jf5gi763>
            <option selected disabled>Language</option>`;
        lang.forEach(function(langItem, index) {
            flightContent += `
                 <option data-astro-cid-jf5gi763>` + langItem.language + `</option>`;
        });
        flightContent += `
                </select>
                <select required class="select select-primary w-[150px] rounded-md" name="type[` + flightCounter + `][1]" id="type_0" data-astro-cid-jf5gi763>
                    <option  selected data-astro-cid-jf5gi763>Awareness</option>
                    <option data-astro-cid-jf5gi763>Consideration</option>
                    <option data-astro-cid-jf5gi763>Trial</option>
                </select>
                <input required type="text" name="location[` + flightCounter + `][1]" id="Flight_` + flightCounter + `_location_0" class="input input-bordered input-primary min-w-36 rounded-md" placeholder="Nova Scotia<" data-astro-cid-jf5gi763 />
                <select required class="select select-primary w-[150px] rounded-md" name="category[` + flightCounter +
            `][1][]" id="Flight_` + flightCounter + `_category_1" data-astro-cid-jf5gi763 multiple>
                    @foreach (\App\Models\CategoryMaster::all() as $Category)
                        <option value="{{ $Category->id }}">{{ $Category->name }}</option>
                    @endforeach
                </select>
                <strong>
                    <div id="categoryDisplay_` + flightCounter + `_1"></div>
                </strong>
            </div>
            <div class="flex flex-wrap items-center gap-3" data-astro-cid-jf5gi763>
            </div>
        </div>
        <div class="divider my-3" data-astro-cid-jf5gi763></div>
        <div id="contentContainerFlight_` + flightCounter +
            `"></div>
        <button class="btn btn-outline no-animation btn-accent rounded-3xl w-32 svg-container text-[#555555]" type="button" id="addNewRow" onclick="AddRow(` +
            flightCounter + `);" data-astro-cid-jf5gi763>
            <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481" viewBox="0 0 15.481 15.481" data-astro-cid-jf5gi763>
                <path id="add_FILL0_wght400_GRAD0_opsz24" d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z" transform="translate(-200 760)" fill="#ea33c0" data-astro-cid-jf5gi763></path>
            </svg>
            Add Row
        </button>
        <div class="divider my-3" data-astro-cid-jf5gi763></div>
    </div>
</div>
`;

        document.getElementById('MainFlightContainer').insertAdjacentHTML('beforeend', flightContent);
        $('#Flight_' + flightCounter + '_category_1').select2();
    }
</script>


<script>
    $(document).ready(function() {
        $('#Flight_1_category_1').select2();

    });
</script>
