
@extends('Layout.sidebar')

@section('main-section')
    <div
        class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full"
        id="content"
        data-astro-cid-sckkx6r4
    >
        <div data-astro-cid-oextfizd>
            <div class="flex justify-between" data-astro-cid-oextfizd>
                <h1 class="text-4xl font-semibold">Campaign Summary</h1>
                <div class="flex gap-3" data-astro-cid-oextfizd>
                    <a href="/campaign/create/index.html" data-astro-cid-oextfizd>
                        <button
                            class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                            data-astro-cid-oextfizd
                        >
                            <img
                                src="/assets/sidebar/settings.png"
                                class="w-[20px] h-[20px]"
                                data-astro-cid-oextfizd
                            />
                            <p
                                class="text-sm font-medium text-[#555555]"
                                data-astro-cid-oextfizd
                            >
                                Edit Settings
                            </p>
                        </button>
                    </a>
                    <a
                        href="{{ 'CreateFlight' }}"
                        data-astro-cid-oextfizd
                    >
                        <button
                            class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                            data-astro-cid-oextfizd
                        >
                            <img
                                src="/assets/sidebar/settings.png"
                                class="w-[20px] h-[20px]"
                                data-astro-cid-oextfizd
                            />
                            <p
                                class="text-sm font-medium text-[#555555]"
                                data-astro-cid-oextfizd
                            >
                                Edit Flights
                            </p>
                        </button>
                    </a>
                </div>
            </div>
            <div
                class="my-7 flex justify-between relative"
                data-astro-cid-oextfizd
            >
                <div class="flex flex-col w-full gap-7">
                    <div class="flex flex-col gap-1">
                        <p class="text-xl font-semibold">McDonald's</p>
                        <h2 class="text-4xl font-medium">Q1 Father's Day Campaign</h2>
                    </div>
                    <div class="flex gap-7 justify-start">
                        <div class="flex flex-col gap-1">
                            <p class="text-sm font-medium">Project Number</p>
                            <p class="text-base font-medium">KUS-9789</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-sm font-medium">Total Budget</p>
                            <p class="text-base font-medium">$1,500,000</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-sm font-medium">Languages</p>
                            <p class="text-base font-medium">EN, FR</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-sm font-medium">Team</p>
                            <div class="flex gap-1">
                                <div
                                    class="bg-[#c72ba4] flex justify-center items-center text-white w-8 h-8 rounded-full font-semibold border border-[#ea33c0]"
                                >
                                    B
                                </div>
                                <div
                                    class="bg-[#c72ba4] flex justify-center items-center text-white w-8 h-8 rounded-full font-semibold border border-[#ea33c0]"
                                >
                                    R
                                </div>
                                <div
                                    class="bg-[#d99c11] flex justify-center items-center text-black w-8 h-8 rounded-full font-semibold border border-[#f0bd4a]"
                                >
                                    C
                                </div>
                                <div
                                    class="bg-[#5e78d0] flex justify-center items-center text-white w-8 h-8 rounded-full font-semibold border border-[#7690e8]"
                                >
                                    T
                                </div>
                                <div
                                    class="bg-[#5e78d0] flex justify-center items-center text-white w-8 h-8 rounded-full font-semibold border border-[#7690e8]"
                                >
                                    D
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#EA33C0] h-[2px]"></div>
                </div>
                <div class="absolute bottom-7 right-0" data-astro-cid-oextfizd>
                    <button
                        onclick="confirm_modal.showModal()"
                        class="btn btn-accent btn-md px-28 rounded-full text-white"
                        data-astro-cid-oextfizd
                    >
                        Brief Campaign
                    </button>
                </div>
            </div>
            <div
                class="flex w-full items-center justify-between"
                data-astro-cid-oextfizd
            >
                <div class="flex grow gap-3 items-center" data-astro-cid-oextfizd>
                    <div class="join" data-astro-cid-oextfizd>
                        <input
                            class="join-item btn rounded-l-full border-accent bg-white px-10 hover:bg-white hover:border-accent"
                            type="radio"
                            name="options"
                            aria-label="Flight 1"
                            checked
                            data-astro-cid-oextfizd
                        />
                        <input
                            class="join-item btn border-accent bg-white px-10 hover:bg-white hover:border-accent"
                            type="radio"
                            name="options"
                            aria-label="Flight 2"
                            data-astro-cid-oextfizd
                        />
                        <input
                            class="join-item btn rounded-r-full border-accent bg-white px-10 hover:bg-white hover:border-accent"
                            type="radio"
                            name="options"
                            aria-label="Flight 3"
                            data-astro-cid-oextfizd
                        />
                    </div>
                    <p class="text-lg font-medium" data-astro-cid-oextfizd>
                        Language
                    </p>
                    <select
                        class="select select-primary w-[150px] rounded-md"
                        data-astro-cid-oextfizd
                    >
                        <option selected data-astro-cid-oextfizd>EN</option>
                        <option data-astro-cid-oextfizd>JP</option>
                    </select>
                </div>
                <div class="" data-astro-cid-oextfizd>
                    <a
                        href="{{ 'CreatePublisher' }}"
                        data-astro-cid-oextfizd
                    >
                        <button
                            class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                            data-astro-cid-oextfizd
                        >
                            <img
                                src="/assets/sidebar/settings.png"
                                class="w-[20px] h-[20px]"
                                data-astro-cid-oextfizd
                            />
                            <p
                                class="text-sm font-medium text-[#555555]"
                                data-astro-cid-oextfizd
                            >
                                Edit Assets
                            </p>
                        </button>
                    </a>
                </div>
            </div>
            <div
                id="example-table-container"
                class="mt-10 w-full mx-auto"
                data-astro-cid-oextfizd
            >
                <!-- Table -->
                <div id="example-table" data-astro-cid-oextfizd></div>
            </div>
        </div>
        <div data-astro-cid-oextfizd>
            <dialog id="confirm_modal" class="modal" data-astro-cid-oextfizd>
                <div
                    class="modal-box w-6/12 max-w-5xl py-10"
                    data-astro-cid-oextfizd
                >
                    <h3
                        class="font-semibold text-3xl text-center"
                        data-astro-cid-oextfizd
                    >
                        Ready to brief your campaign?
                    </h3>
                    <p class="py-4 text-center" data-astro-cid-oextfizd>
                        Briefing your campaign will notify all team members and allow
                        them to edit
                    </p>
                    <div
                        class="modal-action flex justify-center"
                        data-astro-cid-oextfizd
                    >
                        <form method="dialog" data-astro-cid-oextfizd>
                            <a
                                role="button"
                                href="/index.html"
                                class="btn btn-accent btn-md rounded-full text-white px-10"
                                data-astro-cid-oextfizd
                            >Brief it, baby!
                            </a>
                        </form>
                    </div>
                </div>
            </dialog>
        </div>
    </div>
    </div>
    </body>
    </html>
    <script type="text/javascript">
        // Define table data
        const campaignSummaryTableData = [
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
        ];

        // Initialize Tabulator
        const table = new Tabulator("#example-table", {
            data: campaignSummaryTableData,
            autoColumns: true,
            layout: "fitColumns", //fit columns to width of table
            responsiveLayout: "hide", //hide columns that don't fit on the table
            addRowPos: "top", //when adding a new row, add it to the top of the table
            history: true, //allow undo and redo actions on the table
            pagination: "local", //paginate the data
            paginationSize: 7, //allow 7 rows per page of data
            paginationCounter: "rows", //display count of paginated rows in footer
            resizableColumnFit: true,
            initialSort: [
                //set the initial sort order of the data
                {column: "name", dir: "asc"},
            ],
            columnDefaults: {
                tooltip: true, //show tool tips on cells
            },
        });
    </script>
@endsection

@extends('Layout.sidebar')

@section('main-section')
    <div
        class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full"
        id="content"
        data-astro-cid-sckkx6r4
    >
        <div data-astro-cid-oextfizd>
            <div class="flex justify-between" data-astro-cid-oextfizd>
                <h1 class="text-4xl font-semibold">Campaign Summary</h1>
                <div class="flex gap-3" data-astro-cid-oextfizd>
                    <a href="/campaign/create/index.html" data-astro-cid-oextfizd>
                        <button
                            class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                            data-astro-cid-oextfizd
                        >
                            <img
                                src="/assets/sidebar/settings.png"
                                class="w-[20px] h-[20px]"
                                data-astro-cid-oextfizd
                            />
                            <p
                                class="text-sm font-medium text-[#555555]"
                                data-astro-cid-oextfizd
                            >
                                Edit Settings
                            </p>
                        </button>
                    </a>
                    <a
                        href="{{ 'CreateFlight' }}"
                        data-astro-cid-oextfizd
                    >
                        <button
                            class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                            data-astro-cid-oextfizd
                        >
                            <img
                                src="/assets/sidebar/settings.png"
                                class="w-[20px] h-[20px]"
                                data-astro-cid-oextfizd
                            />
                            <p
                                class="text-sm font-medium text-[#555555]"
                                data-astro-cid-oextfizd
                            >
                                Edit Flights
                            </p>
                        </button>
                    </a>
                </div>
            </div>
            <div
                class="my-7 flex justify-between relative"
                data-astro-cid-oextfizd
            >
                <div class="flex flex-col w-full gap-7">
                    <div class="flex flex-col gap-1">
                        <p class="text-xl font-semibold">McDonald's</p>
                        <h2 class="text-4xl font-medium">Q1 Father's Day Campaign</h2>
                    </div>
                    <div class="flex gap-7 justify-start">
                        <div class="flex flex-col gap-1">
                            <p class="text-sm font-medium">Project Number</p>
                            <p class="text-base font-medium">KUS-9789</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-sm font-medium">Total Budget</p>
                            <p class="text-base font-medium">$1,500,000</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-sm font-medium">Languages</p>
                            <p class="text-base font-medium">EN, FR</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-sm font-medium">Team</p>
                            <div class="flex gap-1">
                                <div
                                    class="bg-[#c72ba4] flex justify-center items-center text-white w-8 h-8 rounded-full font-semibold border border-[#ea33c0]"
                                >
                                    B
                                </div>
                                <div
                                    class="bg-[#c72ba4] flex justify-center items-center text-white w-8 h-8 rounded-full font-semibold border border-[#ea33c0]"
                                >
                                    R
                                </div>
                                <div
                                    class="bg-[#d99c11] flex justify-center items-center text-black w-8 h-8 rounded-full font-semibold border border-[#f0bd4a]"
                                >
                                    C
                                </div>
                                <div
                                    class="bg-[#5e78d0] flex justify-center items-center text-white w-8 h-8 rounded-full font-semibold border border-[#7690e8]"
                                >
                                    T
                                </div>
                                <div
                                    class="bg-[#5e78d0] flex justify-center items-center text-white w-8 h-8 rounded-full font-semibold border border-[#7690e8]"
                                >
                                    D
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#EA33C0] h-[2px]"></div>
                </div>
                <div class="absolute bottom-7 right-0" data-astro-cid-oextfizd>
                    <button
                        onclick="confirm_modal.showModal()"
                        class="btn btn-accent btn-md px-28 rounded-full text-white"
                        data-astro-cid-oextfizd
                    >
                        Brief Campaign
                    </button>
                </div>
            </div>
            <div
                class="flex w-full items-center justify-between"
                data-astro-cid-oextfizd
            >
                <div class="flex grow gap-3 items-center" data-astro-cid-oextfizd>
                    <div class="join" data-astro-cid-oextfizd>
                        <input
                            class="join-item btn rounded-l-full border-accent bg-white px-10 hover:bg-white hover:border-accent"
                            type="radio"
                            name="options"
                            aria-label="Flight 1"
                            checked
                            data-astro-cid-oextfizd
                        />
                        <input
                            class="join-item btn border-accent bg-white px-10 hover:bg-white hover:border-accent"
                            type="radio"
                            name="options"
                            aria-label="Flight 2"
                            data-astro-cid-oextfizd
                        />
                        <input
                            class="join-item btn rounded-r-full border-accent bg-white px-10 hover:bg-white hover:border-accent"
                            type="radio"
                            name="options"
                            aria-label="Flight 3"
                            data-astro-cid-oextfizd
                        />
                    </div>
                    <p class="text-lg font-medium" data-astro-cid-oextfizd>
                        Language
                    </p>
                    <select
                        class="select select-primary w-[150px] rounded-md"
                        data-astro-cid-oextfizd
                    >
                        <option selected data-astro-cid-oextfizd>EN</option>
                        <option data-astro-cid-oextfizd>JP</option>
                    </select>
                </div>
                <div class="" data-astro-cid-oextfizd>
                    <a
                        href="{{ 'CreatePublisher' }}"
                        data-astro-cid-oextfizd
                    >
                        <button
                            class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                            data-astro-cid-oextfizd
                        >
                            <img
                                src="/assets/sidebar/settings.png"
                                class="w-[20px] h-[20px]"
                                data-astro-cid-oextfizd
                            />
                            <p
                                class="text-sm font-medium text-[#555555]"
                                data-astro-cid-oextfizd
                            >
                                Edit Assets
                            </p>
                        </button>
                    </a>
                </div>
            </div>
            <div
                id="example-table-container"
                class="mt-10 w-full mx-auto"
                data-astro-cid-oextfizd
            >
                <!-- Table -->
                <div id="example-table" data-astro-cid-oextfizd></div>
            </div>
        </div>
        <div data-astro-cid-oextfizd>
            <dialog id="confirm_modal" class="modal" data-astro-cid-oextfizd>
                <div
                    class="modal-box w-6/12 max-w-5xl py-10"
                    data-astro-cid-oextfizd
                >
                    <h3
                        class="font-semibold text-3xl text-center"
                        data-astro-cid-oextfizd
                    >
                        Ready to brief your campaign?
                    </h3>
                    <p class="py-4 text-center" data-astro-cid-oextfizd>
                        Briefing your campaign will notify all team members and allow
                        them to edit
                    </p>
                    <div
                        class="modal-action flex justify-center"
                        data-astro-cid-oextfizd
                    >
                        <form method="dialog" data-astro-cid-oextfizd>
                            <a
                                role="button"
                                href="/index.html"
                                class="btn btn-accent btn-md rounded-full text-white px-10"
                                data-astro-cid-oextfizd
                            >Brief it, baby!
                            </a>
                        </form>
                    </div>
                </div>
            </dialog>
        </div>
    </div>
    </div>
    </body>
    </html>
    <script type="text/javascript">
        // Define table data
        const campaignSummaryTableData = [
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
            {
                language: "EN",
                targeting: "Awareness",
                category: "Social",
                region: "Nova Scotia",
                publisher: "Facebook",
                adType: "Feed",
                dueDate: "02/02/2024",
                status: "Social",
            },
        ];

        // Initialize Tabulator
        const table = new Tabulator("#example-table", {
            data: campaignSummaryTableData,
            autoColumns: true,
            layout: "fitColumns", //fit columns to width of table
            responsiveLayout: "hide", //hide columns that don't fit on the table
            addRowPos: "top", //when adding a new row, add it to the top of the table
            history: true, //allow undo and redo actions on the table
            pagination: "local", //paginate the data
            paginationSize: 7, //allow 7 rows per page of data
            paginationCounter: "rows", //display count of paginated rows in footer
            resizableColumnFit: true,
            initialSort: [
                //set the initial sort order of the data
                {column: "name", dir: "asc"},
            ],
            columnDefaults: {
                tooltip: true, //show tool tips on cells
            },
        });
    </script>
@endsection
