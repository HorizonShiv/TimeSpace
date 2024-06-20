@extends('Layout.sidebar')



@section('main-container')
    <div class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full" id="content" data-astro-cid-sckkx6r4>

        <div class="flex justify-between" data-astro-cid-b7mymyte>
            <div class="w-1/2">
                <h1 class="text-4xl font-semibold">Campaign Summery</h1>
            </div>
            <div class="justify-end  gap-2 w-1/2">
                <a href="{{ route('Campaign.create') }}" data-astro-cid-b7mymyte>
                    <button
                        class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                        data-astro-cid-b7mymyte>
                        <img src="/assets/sidebar/settings.png" class="w-[20px] h-[20px]" data-astro-cid-b7mymyte />
                        <p class="text-sm font-medium text-[#555555]" data-astro-cid-b7mymyte>
                            Edit Settings
                        </p>
                    </button>
                </a>
                <a href="{{ route('Flight.create') }}" data-astro-cid-b7mymyte>
                    <button
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

        <div class="my-7" data-astro-cid-b7mymyte>
            <div class="flex flex-col w-full gap-7">
                <div class="flex flex-col gap-1">
                    <p class="text-xl font-semibold">Kusmi Tea</p>
                    <h2 class="text-4xl font-medium">Q1 Spring Campaign</h2>
                </div>
                <div class="flex row justify-between">
                    <div class="flex gap-7 justify-start w-1/2">
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
                                    class="bg-[#c72ba4] flex justify-center items-center text-white w-8 h-8 rounded-full font-semibold border border-[#ea33c0]">
                                    B
                                </div>
                                <div
                                    class="bg-[#c72ba4] flex justify-center items-center text-white w-8 h-8 rounded-full font-semibold border border-[#ea33c0]">
                                    R
                                </div>
                                <div
                                    class="bg-[#d99c11] flex justify-center items-center text-black w-8 h-8 rounded-full font-semibold border border-[#f0bd4a]">
                                    C
                                </div>
                                <div
                                    class="bg-[#5e78d0] flex justify-center items-center text-white w-8 h-8 rounded-full font-semibold border border-[#7690e8]">
                                    T
                                </div>
                                <div
                                    class="bg-[#5e78d0] flex justify-center items-center text-white w-8 h-8 rounded-full font-semibold border border-[#7690e8]">
                                    D
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid  justify-items-end w-1/2 mt-5">
                        <button
                            class="btn btn-outline no-animation btn-accent rounded-3xl w-96 svg-container text-[#ffffff]"
                            data-astro-cid-yiwyit5q>
                            Downloads Approved Assets
                            <svg xmlns="http://www.w3.org/2000/svg" width="15.481" height="15.481"
                                viewBox="0 0 15.481 15.481" data-astro-cid-yiwyit5q>
                                {{--                                <path id="add_FILL0_wght400_GRAD0_opsz24" --}}
                                {{--                                      d="M206.635-751.154H200v-2.212h6.635V-760h2.212v6.635h6.635v2.212h-6.635v6.635h-2.212Z" --}}
                                {{--                                      transform="translate(-200 760)" fill="#f4f4f4" data-astro-cid-yiwyit5q> --}}
                                {{--                                </path> --}}
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="bg-[#EA33C0] h-[2px]"></div>
            </div>
        </div>
        <div class="flex w-full items-center justify-between" data-astro-cid-b7mymyte>
            <div class="flex grow gap-3 items-center" data-astro-cid-b7mymyte>
                <div class="join" data-astro-cid-b7mymyte>
                    <input
                        class="join-item btn rounded-l-full border-accent bg-white px-10 hover:bg-white hover:border-accent"
                        type="radio" name="options" aria-label="Flight 1" checked data-astro-cid-b7mymyte />
                    <input class="join-item btn border-accent bg-white px-10 hover:bg-white hover:border-accent"
                        type="radio" name="options" aria-label="Flight 2" data-astro-cid-b7mymyte />
                    <input
                        class="join-item btn rounded-r-full border-accent bg-white px-10 hover:bg-white hover:border-accent"
                        type="radio" name="options" aria-label="Flight 3" data-astro-cid-b7mymyte />
                </div>
                <p class="text-lg font-medium" data-astro-cid-b7mymyte>
                    Language
                </p>
                <select class="select select-primary w-[150px] rounded-md" data-astro-cid-b7mymyte>
                    <option selected data-astro-cid-b7mymyte>EN</option>
                    <option data-astro-cid-b7mymyte>JP</option>
                </select>
            </div>
            <div class="" data-astro-cid-b7mymyte>
                <a href="{{ route('Assets.create') }}" data-astro-cid-b7mymyte>
                    <button
                        class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary"
                        data-astro-cid-b7mymyte>
                        <img src="/assets/sidebar/settings.png" class="w-[20px] h-[20px]" data-astro-cid-b7mymyte />
                        <p class="text-sm font-medium text-[#555555]" data-astro-cid-b7mymyte>
                            Edit Assets
                        </p>
                    </button>
                </a>
            </div>
        </div>

        <div id="component2" class="component py-8" data-astro-cid-5kgwmqn7>
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
                                <tbody>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">---</td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
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
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Ontario
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td class="flex items-center">
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <p>+5</p>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Alberta
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                        <div class="flex"></div>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">---</td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            New Brunswick
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">Quebec</td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            New Brunswick
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">---</td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Stories
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">Quebec</td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Stories
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                </tbody>
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
                                <tbody>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">---</td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
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
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Ontario
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td class="flex items-center">
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <p>+5</p>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Alberta
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                        <div class="flex"></div>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">---</td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            New Brunswick
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">Quebec</td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            New Brunswick
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">---</td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Stories
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">Quebec</td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Stories
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                </tbody>
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
                                <tbody>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">---</td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
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
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Ontario
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td class="flex items-center">
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                            <p>+5</p>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Alberta
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                        <div class="flex"></div>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">---</td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            New Brunswick
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">Quebec</td>
                                        <td class="text-base font-normal text-black">
                                            Facebook
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            Nova Scotia
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">
                                            New Brunswick
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">Feed</td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">---</td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Stories
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon2.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td>
                                            <img src="/assets/card/card1.png" class="w-8 h-8 rounded-sm" />
                                        </td>
                                        <td class="text-base font-normal text-black">EN</td>
                                        <td class="text-base font-normal text-black">
                                            Awareness
                                        </td>
                                        <td class="text-base font-normal text-black">Social</td>
                                        <td class="text-base font-normal text-black">Quebec</td>
                                        <td class="text-base font-normal text-black">
                                            Instagram
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            Stories
                                        </td>
                                        <td class="text-base font-normal text-black">
                                            02/02/2024
                                        </td>
                                        <td>
                                            <img src="/assets/home/card/Icon3.svg" alt="create campaign"
                                                class="w-6 h-6" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Add Row Button
                const addRowBtn = document.getElementById("addRowBtn");
                const addRowBtn1 = document.getElementById("addRowBtn1");
                const addRowBtn2 = document.getElementById("addRowBtn2");

                let rowCount = 1; // Counter for unique IDs
                addRowBtn.addEventListener("click", function() {
                    // Clone the row element
                    const newRow = document.querySelector('[data-row-template]').cloneNode(true);
                    // Update IDs and other attributes of input elements
                    const inputs = newRow.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        const currentId = input.id || '';
                        const currentName = input.getAttribute('name') || '';
                        input.id = currentId + rowCount;
                        input.setAttribute('name', currentName + rowCount);
                        // Clear input values if needed
                        input.value = ''; // You might want to clear values if necessary
                    });
                    // Append the cloned row element to the container
                    document.querySelector('#AddContainer').appendChild(newRow);
                    rowCount++; // Increment the row counter
                });

                let rowCount1 = 1; // Counter for unique IDs
                addRowBtn1.addEventListener("click", function() {
                    // Clone the row element
                    const newRow = document.querySelector('[data-row-template]').cloneNode(true);
                    // Update IDs and other attributes of input elements
                    const inputs = newRow.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        const currentId = input.id || '';
                        const currentName = input.getAttribute('name') || '';
                        input.id = currentId + rowCount1;
                        input.setAttribute('name', currentName + rowCount1);
                        // Clear input values if needed
                        input.value = ''; // You might want to clear values if necessary
                    });
                    // Append the cloned row element to the container
                    document.querySelector('#AddContainer1').appendChild(newRow);
                    rowCount1++; // Increment the row counter
                });

                let rowCount2 = 1; // Counter for unique IDs
                addRowBtn2.addEventListener("click", function() {
                    // Clone the row element
                    const newRow = document.querySelector('[data-row-template]').cloneNode(true);
                    // Update IDs and other attributes of input elements
                    const inputs = newRow.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        const currentId = input.id || '';
                        const currentName = input.getAttribute('name') || '';
                        input.id = currentId + rowCount2;
                        input.setAttribute('name', currentName + rowCount2);
                        // Clear input values if needed
                        input.value = ''; // You might want to clear values if necessary
                    });
                    // Append the cloned row element to the container
                    document.querySelector('#French_Awareness-Quebec').appendChild(newRow);
                    rowCount2++; // Increment the row counter
                });
            });
        </script>
    @endsection
