@extends('Layout.sidebar')
@section('addStyleScript')
<style>
    /* Target the input[type="file"] element */
    .input[type="file"] {
        /* Hide the default button */
        display: none;
    }

    /* Style the custom button */
    .input[type="file"]+label {
        /* Add styles to make it look like a button */
        padding: 0.5em 1em;
        background-color: rgb(201, 54, 187);
        /* Green color, change as needed */
        color: white;
        border-radius: 4px;
        cursor: pointer;
        /* Add any additional styles as needed */
    }

    /* Optional: Style the label text */
    .input[type="file"]+label::before {
        content: "Choose File";
        /* Text for the button */
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('main-container')
    <div class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full" id="content" data-astro-cid-sckkx6r4>
        <div class="flex justify-between" data-astro-cid-rwhxyfax>
            <h1 class="text-4xl font-semibold">Create Campaign</h1>
        </div>
        <form method="post" action="{{ route('campaign.store') }}" enctype="multipart/form-data" class="mt-7"
            data-astro-cid-rwhxyfax>
            @csrf

            <div class="flex flex-col gap-3 w-full" data-astro-cid-rwhxyfax>
                <div class="input-group flex items-center w-full">
                    <label class="label-text whitespace-normal w-36 min-w-[150px]">Client</label>
                    <div class="flex items-center gap-5 w-full" data-astro-cid-rwhxyfax>
                        {{-- {{dd($Clients)}} --}}
                        <select class="select select-primary w-96 text-[#BABABA]" id="Client" name="Client"
                            data-astro-cid-rwhxyfax>
                            <option disabled selected data-astro-cid-rwhxyfax>
                                Please select...
                            </option>
                            {{-- @foreach ($Clients as $Client) --}}

                            @foreach ($Clients as $Client)
                                {{-- {{ dd($Client) }} --}}
                                <option value="{{ $Client->team_id }}">{{ $Client->Team->name }}</option>
                            @endforeach
                        </select>

                        {{-- <a href="{{ route('customer') }}"
                            class="btn btn-outline no-animation btn-accent rounded-3xl w-52 svg-container text-[#555555]"
                            data-astro-cid-yiwyit5q>
                            Create New Client
                            <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481"
                                viewBox="0 0 15.481 15.481" data-astro-cid-yiwyit5q>
                                <path id="add_FILL0_wght400_GRAD0_opsz24"
                                    d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z"
                                    transform="translate(-200 760)" fill="#ea33c0" data-astro-cid-yiwyit5q></path>
                            </svg>
                        </a> --}}
                    </div>
                </div>
                <p style="color: red">
                    @error('client')
                        {{ $message }}
                    @enderror
                </p>
                <div class="input-group flex items-center w-full">
                    <label class="label-text whitespace-normal w-36 min-w-[150px]">Campaign Name</label>
                    <input type="text" placeholder="Q1 Father’s Day Campaign" name="CampaignName"
                        class="input input-bordered input-primary w-full" value="{{ old('CampaignName') }}" />

                </div>

                <p style="color: red">
                    @error('CampaignName')
                        {{ $message }}
                    @enderror
                </p>
                <div class="input-group flex items-center w-full">
                    <label class="label-text whitespace-normal w-36 min-w-[150px]">Project Code</label>
                    <div class="flex items-center gap-5 w-full" data-astro-cid-rwhxyfax>
                        <input type="text" placeholder="Optional" name="projectCode"
                            class="input input-bordered input-primary min-w-96" value="{{ old('projectCode') }}" />
                        {{-- <span class="label-text-alt font-medium text-sm text-[#BABABA]" data-astro-cid-rwhxyfax>Last project
                            code: ABC-1234</span> --}}
                    </div>
                </div>
                <p style="color: red">
                    @error('projectCode')
                        {{ $message }}
                    @enderror
                </p>

                {{-- <div class="input-group flex items-center w-full">
                    <label class="label-text whitespace-normal w-36 min-w-[150px]">Campaign Image</label>
                    <div class="flex items-center gap-5 w-full" data-astro-cid-rwhxyfax>
                        <input type="file" placeholder="Optional" name="CampaignImage"
                            class="input input-bordered input-primary min-w-96" id="fileInput" />
                        <label for="fileInput"></label>
                        <strong>
                            <div id="imageNameShow"></div>
                        </strong>
                    </div>
                </div>


                <p style="color: red">
                    @error('CampaignImage')
                        {{ $message }}
                    @enderror
                </p> --}}

                {{-- <div class="input-group flex items-center w-full">
                    <label class="label-text whitespace-normal w-36 min-w-[150px]">Project Code</label>
                    <div class="flex items-center gap-5 w-full" data-astro-cid-rwhxyfax>
                        <div class="flex items-center">
                            <label for="projectCodeFile" class="input input-bordered input-primary min-w-96">
                                Choose File
                            </label>
                            <input type="file" id="projectCodeFile" name="projectCodeFile" class="hidden" />
                        </div>
                    </div>
                </div> --}}





                <div class="flex flex-col w-full gap-3" data-astro-cid-rwhxyfax>
                    <div class="input-group flex items-center w-full">
                        <label class="label-text whitespace-normal w-36 min-w-[150px]">Languages</label>
                        <div class="flex" data-astro-cid-rwhxyfax>
                            {{-- <input type="checkbox" class="" placeholder="Enter language…" value="EN"
                                class="grow" name="Languages[]" {{ old('Languages') ? 'checked' : '' }} /> &nbsp; English
                            &nbsp;&nbsp;
                            <input type="checkbox" placeholder="Enter language…" value="FR" class="grow"
                                name="Languages[]" {{ old('Languages') ? 'checked' : '' }} /> &nbsp; French --}}
                            <select class="select select-primary w-96 text-[#BABABA]" aria-placeholder="Select Language"
                                id="Languages" name="Languages[]" data-astro-cid-rwhxyfax multiple>
                                <option value="EN">English</option>
                                <option value="FR">French</option>
                            </select>
                        </div>
                    </div>
                    <p style="color: red"> @error('Languages')
                            {{ $message }}
                        @enderror
                    </p>

                </div>
                {{-- <div class="flex flex-col w-full gap-3" data-astro-cid-rwhxyfax>
                    <div class="input-group flex items-center w-full">
                        <label class="label-text whitespace-normal w-36 min-w-[150px]">Export Naming
                            Convention</label>
                        <div class="flex items-center gap-5 w-full flex-wrap" data-astro-cid-rwhxyfax>
                            <select class="select select-primary" name="exClient" data-astro-cid-rwhxyfax>
                                <option disabled selected data-astro-cid-rwhxyfax>
                                    Client
                                </option>
                                @foreach ($Clients as $Client)
                                    <option value="{{ $Client->team_id }}">{{ $Client->Team->name }}</option>
                                @endforeach
                            </select>
                            <select class="select select-primary" name="exLanguage" onchange="setLangName();"
                                data-astro-cid-rwhxyfax>
                                <option disabled selected data-astro-cid-rwhxyfax>
                                    Language
                                </option>
                                <option data-astro-cid-rwhxyfax>English</option>
                                <option data-astro-cid-rwhxyfax>French</option>
                            </select>
                            <select class="select select-primary" name="exTarget" onchange="setTargetName()"
                                data-astro-cid-rwhxyfax>
                                <option disabled selected data-astro-cid-rwhxyfax>
                                    Targeting
                                </option>
                                <option data-astro-cid-jf5gi763>
                                    Awareness
                                </option>
                                <option data-astro-cid-jf5gi763>
                                    Consideration
                                </option>
                                <option data-astro-cid-jf5gi763>
                                    Trail
                                </option>
                            </select>
                            <input type="text" name="exRegion" onkeyup="setRegionName();"
                                class="input input-bordered input-primary min-w-10" />

                            <select class="select select-primary" name="exPublisher" onchange="setPublisherName()"
                                data-astro-cid-rwhxyfax>
                                <option disabled selected data-astro-cid-rwhxyfax>
                                    Publisher
                                </option>
                                @foreach (\App\Models\PublisherMaster::all() as $Publisher)
                                    <option value="{{ $Publisher->id }}">{{ $Publisher->name }}</option>
                                @endforeach
                            </select>
                            <select class="select select-primary" name="exAdtype" onchange="setAdName()"
                                data-astro-cid-rwhxyfax>
                                <option disabled selected data-astro-cid-rwhxyfax>
                                    Ad Type
                                </option>
                                @foreach (\App\Models\AdvertisementType::with('PublisherMaster')->get() as $Advertise)
                                    <option value="{{ $Advertise->id }}">{{ $Advertise->name }} -
                                        {{ $Advertise->PublisherMaster->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="ml-[150px] w-full" data-astro-cid-rwhxyfax>
                        <span class="label-text-alt font-semibold text-base" id="FileNameClient"></span>
                        <span class="label-text-alt font-semibold text-base" id="FileNameLanguage"></span>
                        <span class="label-text-alt font-semibold text-base" id="FileNameTarget"></span>
                        <span class="label-text-alt font-semibold text-base" id="FileNameRegion"></span>
                        <span class="label-text-alt font-semibold text-base" id="FileNamePublisher"></span>
                        <span class="label-text-alt font-semibold text-base" id="FileNameAdType"></span>
                    </div>
                </div> --}}
                <div class="input-group flex items-center w-full">
                    <label class="label-text whitespace-normal w-36 min-w-[150px]">Budget</label>
                    <input type="number" placeholder="Enter value (Optional)" name="Budget"
                        class="input input-bordered input-primary min-w-96" value="{{ old('Budget') }}" />

                </div>
                <p style="color: red"> @error('Budget')
                        {{ $message }}
                    @enderror
                </p>
                <div class="flex flex-col w-full gap-3" data-astro-cid-rwhxyfax>
                    <div class="input-group flex items-center w-full">
                        <label class="label-text whitespace-normal w-36 min-w-[150px]">Add Team Members</label>
                        <div class="flex items-center gap-5 w-full" data-astro-cid-rwhxyfax>
                            <select class="select select-primary w-96 text-[#BABABA]" placeholder="Please Select Team member" id="TeamMember" name="TeamMember[]"
                                data-astro-cid-rwhxyfax multiple>
                                @foreach (\App\Models\User::all() as $User)
                                    <option @php if($User->id==old('TeamMember')){ echo 'selected';} @endphp
                                        value="{{ $User->id }}">{{ $User->name }} - {{ $User->type }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p style="color: red"> @error('TeamMember')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="divider" data-astro-cid-rwhxyfax></div>
                <div data-astro-cid-rwhxyfax>
                    <button role="button" type="submit" class="btn rounded-full bg-accent text-white no-animation"
                        data-astro-cid-rwhxyfax>
                        Create Campaign
                        <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481" viewBox="0 0 15.481 15.481"
                            data-astro-cid-rwhxyfax>
                            <path id="add_FILL0_wght400_GRAD0_opsz24"
                                d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z"
                                transform="translate(-200 760)" fill="#f5f5f5" data-astro-cid-rwhxyfax></path>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
        <div data-astro-cid-rwhxyfax>
            <button onclick="create_modal.showModal()" class="invisible" id="create_modal_button" data-astro-cid-rwhxyfax>
                Brief Campaign
            </button>
            <dialog id="create_modal" class="modal" data-astro-cid-rwhxyfax>
                <div class="modal-box w-5/12 max-w-5xl py-10" data-astro-cid-rwhxyfax>
                    <h3 class="font-semibold text-3xl text-center" data-astro-cid-rwhxyfax>
                        Let’s set up a new campaign.
                    </h3>
                    <div class="flex w-full justify-between py-8 gap-5" data-astro-cid-rwhxyfax>
                        <div class="start_icon flex flex-col gap-2 w-full h-[200px] justify-center items-center border border-[#DDDDDD] rounded-xl"
                            id="start_from_scratch" onclick="handleClick(this)" data-astro-cid-rwhxyfax>
                            <svg xmlns="http://www.w3.org/2000/svg" width="46.279" height="48.715"
                                viewBox="0 0 46.279 48.715" data-astro-cid-rwhxyfax>
                                <path id="edit_document_FILL0_wght400_GRAD0_opsz24"
                                    d="M184.357-831.285v-7.49l13.457-13.4a3.318,3.318,0,0,1,1.218-.792,3.9,3.9,0,0,1,1.34-.244,3.665,3.665,0,0,1,1.4.274,3.693,3.693,0,0,1,1.218.822l2.253,2.253A4.236,4.236,0,0,1,206-848.64a3.515,3.515,0,0,1,.274,1.34,4.157,4.157,0,0,1-.244,1.37,3.268,3.268,0,0,1-.792,1.248l-13.4,13.4ZM202.625-847.3l-2.253-2.253Zm-14.614,12.361h2.314l7.368-7.429-1.1-1.157-1.157-1.1-7.429,7.368Zm-23.139,3.654a4.691,4.691,0,0,1-3.44-1.431,4.691,4.691,0,0,1-1.431-3.44v-38.972a4.691,4.691,0,0,1,1.431-3.44,4.691,4.691,0,0,1,3.44-1.431h19.486l14.614,14.614v7.307H194.1v-4.872H181.922v-12.179h-17.05v38.972h14.614v4.871ZM181.922-855.643ZM196.6-843.525l-1.157-1.1,2.253,2.253Z"
                                    transform="translate(-160 880)" fill="#bababa" data-astro-cid-rwhxyfax></path>
                            </svg>
                            <p data-astro-cid-rwhxyfax>Start from scratch</p>
                        </div>
                        <div class="start_icon flex flex-col gap-2 w-full h-[200px] justify-center items-center border border-[#DDDDDD] rounded-xl"
                            id="duplicate_existing" onclick="handleClick(this)" data-astro-cid-rwhxyfax>
                            <svg xmlns="http://www.w3.org/2000/svg" width="39.783" height="46.804"
                                viewBox="0 0 39.783 46.804" data-astro-cid-rwhxyfax>
                                <path id="content_copy_FILL0_wght400_GRAD0_opsz24"
                                    d="M134.041-842.557a4.507,4.507,0,0,1-3.306-1.375,4.507,4.507,0,0,1-1.375-3.306v-28.082a4.507,4.507,0,0,1,1.375-3.306A4.507,4.507,0,0,1,134.041-880H155.1a4.507,4.507,0,0,1,3.306,1.375,4.507,4.507,0,0,1,1.375,3.306v28.082a4.507,4.507,0,0,1-1.375,3.306,4.507,4.507,0,0,1-3.306,1.375Zm0-4.68H155.1v-28.082H134.041ZM124.68-833.2a4.507,4.507,0,0,1-3.306-1.375A4.507,4.507,0,0,1,120-837.877v-32.763h4.68v32.763h25.742v4.68Zm9.361-14.041v0Z"
                                    transform="translate(-120 880)" fill="#bababa" data-astro-cid-rwhxyfax></path>
                            </svg>
                            <p data-astro-cid-rwhxyfax>Duplicate existing campaign</p>
                        </div>
                    </div>
                    <div class="w-full justify-center flex items-center" data-astro-cid-rwhxyfax>
                        <button class="btn btn-accent btn-md rounded-full text-white" disabled id="create_campaign_button"
                            onclick="create_modal.close()" data-astro-cid-rwhxyfax>
                            Create Campaign
                            <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481"
                                viewBox="0 0 15.481 15.481" data-astro-cid-rwhxyfax>
                                <path id="add_FILL0_wght400_GRAD0_opsz25"
                                    d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z"
                                    transform="translate(-200 760)" fill="#bababa" data-astro-cid-rwhxyfax></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </dialog>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#Languages').select2();
            $('#TeamMember').select2();
            $('#category').select2();
        });
    </script>
    <script type="text/javascript">
        let queryString = window.location.search;
        let urlParams = new URLSearchParams(queryString);
        const createModalButton = document.getElementById("create_modal_button");

        let createCampaignButton = document.getElementById("create_campaign_button");
        let url = new URL(window.location.origin + "/campaign/create");

        let create_modal = document.getElementById("create_modal");

        const isCreate = urlParams.get("isCreate");

        createCampaignButton.onclick = () => {
            // window.location.href = "/campaign/create/flight";
            window.history.pushState({}, "", url);
            create_modal.close();
        };

        window.handleClick = (e) => {
            if (!e) return;

            const startFromScratch = document.getElementById("start_from_scratch");
            const duplicateExisting = document.getElementById("duplicate_existing");

            createCampaignButton.disabled = false;

            let svgElement = document.getElementById("add_FILL0_wght400_GRAD0_opsz25");

            // Check if the SVG element exists
            if (svgElement) {
                // Change the fill attribute to the desired color
                svgElement.setAttribute("fill", "#ffffff");
            }

            if (e.id === "start_from_scratch") {
                startFromScratch.style.border = "1px solid #c72ba4";
                startFromScratch.querySelector("svg path").style.fill = "#c72ba4";
                duplicateExisting.style.border = "1px solid #DDDDDD";
                duplicateExisting.querySelector("svg path").style.fill = "#bababa";
            } else {
                duplicateExisting.style.border = "1px solid #c72ba4";
                duplicateExisting.querySelector("svg path").style.fill = "#c72ba4";
                startFromScratch.style.border = "1px solid #DDDDDD";
                startFromScratch.querySelector("svg path").style.fill = "#bababa";
            }
        };

        window.onload = () => {
            if (isCreate === "true" && createModalButton) {
                createModalButton.click();
            }
        };
    </script>
    <script>
        function setClientName() {
            var select = document.querySelector('select[name="Client"]');
            var selectedIndex = select.selectedIndex;
            var selectedOption = select.options[selectedIndex];
            var clientName = selectedOption.text + "_";
            var clientValue = selectedOption.value;
            document.getElementById('FileNameClient').textContent = clientName;

            var exClientSelect = document.querySelector('select[name="exClient"]');
            exClientSelect.value = clientValue;
        }

        function setLangName() {
            var select = document.querySelector('select[name="exLanguage"]');
            var selectedIndex = select.selectedIndex;
            var selectedOption = select.options[selectedIndex];
            var languageName = selectedOption.text + "_";
            document.getElementById('FileNameLanguage').textContent = languageName;
        }

        function setTargetName() {
            var select = document.querySelector('select[name="exTarget"]');
            var selectedIndex = select.selectedIndex;
            var selectedOption = select.options[selectedIndex];
            var targetName = selectedOption.text + "_";
            document.getElementById('FileNameTarget').textContent = targetName;
        }

        function setPublisherName() {
            var select = document.querySelector('select[name="exPublisher"]');
            var selectedIndex = select.selectedIndex;
            var selectedOption = select.options[selectedIndex];
            var publisherName = "_" + selectedOption.text + "_";
            document.getElementById('FileNamePublisher').textContent = publisherName;
        }

        function setRegionName() {
            var exRegionInput = document.querySelector('input[name="exRegion"]').value;
            document.getElementById('FileNameRegion').textContent = exRegionInput;
        }

        function setAdName() {
            var select = document.querySelector('select[name="exAdtype"]');
            var selectedIndex = select.selectedIndex;
            var selectedOption = select.options[selectedIndex];
            var AdName = selectedOption.text + '.jpg/.png/.jpeg';
            document.getElementById('FileNameAdType').textContent = AdName;
        }
    </script>

    <script>
        // Get the file input element
        const fileInput = document.getElementById('fileInput');
        // Get the div to display the image name
        const imageNameShow = document.getElementById('imageNameShow');

        // Add event listener for when a file is selected
        fileInput.addEventListener('change', function() {
            // Check if any file is selected
            if (fileInput.files.length > 0) {
                // Display the name of the first selected file
                imageNameShow.textContent = fileInput.files[0].name;
            } else {
                // If no file is selected, clear the content of the div
                imageNameShow.textContent = '';
            }
        });
    </script>
@endsection
