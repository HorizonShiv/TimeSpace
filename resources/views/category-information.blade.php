@extends('Layout.sidebar')
@section('main-container')

    <div class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full" id="content" data-astro-cid-sckkx6r4>

        <div class="my-7" data-astro-cid-jf5gi763>
            <div class="flex flex-col w-full gap-7 mt-5">
                <div class="flex gap-7 justify-start">
                    <div class="flex flex-col gap-1 mt-5">
                        <text class="text-3xl">Category Information</text>
                    </div>
                </div>
                <div class="bg-[#EA33C0] h-[2px]"></div>
            </div>
        </div>
        <form method="post" action="{{ route('Company.store') }}" enctype="multipart/form-data" class="mt-7"
              data-astro-cid-rwhxyfax>
            @csrf

            <div class="flex flex-col gap-3 w-full" data-astro-cid-rwhxyfax>


                <div class="flex flex-row gap-10 mb-10 w-100%">
                    <div class="mb-4 w-50%" id="clientDropdown">
                        <label for="category" class="block font-medium mb-1">Category</label>
                        <select id="selectCategory" name="selectCategory" class="select select-primary w-32">
                            <option>ABC</option>
                            <option>CDF</option>
                        </select>
                    </div>

                    <div class="mb-4" id="partnerDropdown">
                        <label for="publisher" class="block font-medium mb-1">Publisher</label>
                        <select id="select_publisher" name="selectPublisher" class="select select-primary w-32">
                            <option>CDF</option>
                            <option>GHI</option>
                        </select>
                    </div>
                </div>

                <hr class="border-b border-solid" style="border-color:#ea33c0"/>

                <div id="dynamicFormContainer">
                    <div class="mb-4">
                        <label for="addType_0" class="block font-medium mb-1">Ad Type</label>
                        <input id="addType_0" type="text" name="addType[0]" placeholder="Enter the type"
                               class="input input-bordered input-primary w-64" value="{{ old('addType') }}"/>
                        @error('teamName')
                        <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button type="button" id="addTypeButton" onclick="addItem()" class="btn btn-primary w-24">Add Type</button>
            </div>


            <div class="divider" data-astro-cid-rwhxyfax>
                <div data-astro-cid-rwhxyfax>
                    <button role="button" type="submit" class="btn rounded-full bg-accent text-white no-animation"
                            id="btnAddTeam"
                            data-astro-cid-rwhxyfax>
                        Save Changes
                    </button>
                </div>
            </div>
        </form>

        <script>
            var counter = 0;

            function addItem() {
                counter++;
                // Create a new div element with the specified HTML code
                var newDiv = document.createElement("div");
                newDiv.className = "col-md-6";
                newDiv.id = "item_" + counter;
                newDiv.innerHTML = `
                <div class="row mt-5">
                         <label for="addType` + counter + `" class="block font-medium mb-1">Ad Type</label>
                        <div class="mb-4 flex gap-2">
                            <input id="addType` + counter + `" type="text" name="addType[` + counter + `]" placeholder="Enter the type"
                                   class="input input-bordered input-primary w-64" value="{{ old('addType') }}" />
                            @error('teamName')
                            <p class="text-red-500">{{ $message }}</p>
                            @enderror

                                <button type="button" onclick="removeItem(` + counter + `)"
                                class="btn rounded-pill btn-icon btn-label-danger waves-effect">
                                <span><svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                <g id="SVGRepo_iconCarrier"> <path d="M5 6.77273H9.2M19 6.77273H14.8M9.2 6.77273V5.5C9.2 4.94772 9.64772 4.5 10.2 4.5H13.8C14.3523 4.5 14.8 4.94772 14.8 5.5V6.77273M9.2 6.77273H14.8M6.4 8.59091V15.8636C6.4 17.5778 6.4 18.4349 6.94673 18.9675C7.49347 19.5 8.37342 19.5 10.1333 19.5H13.8667C15.6266 19.5 16.5065 19.5 17.0533 18.9675C17.6 18.4349 17.6 17.5778 17.6 15.8636V8.59091M9.2 10.4091V15.8636M12 10.4091V15.8636M14.8 10.4091V15.8636" stroke="#ea33c0" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                </svg></span></button>
                        </div>
                </div>
      `;

                // Append the new div to the container
                document.getElementById("dynamicFormContainer").appendChild(newDiv);

                // Set focus to the input field
                newDiv.querySelector("input").focus();

            }

            function removeItem(counter) {
                var elementToRemove = document.getElementById("item_" + counter);
                elementToRemove.remove();
            }
        </script>
@endsection
