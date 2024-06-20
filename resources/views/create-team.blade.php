@extends('Layout.sidebar')

@section('main-container')
    <div class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full" id="content" data-astro-cid-sckkx6r4>

        <div class="my-7" data-astro-cid-jf5gi763>
            <div class="flex flex-col w-full gap-7 mt-5">
                <div class="flex gap-7 justify-start">
                    <div class="flex flex-col gap-1 mt-5">
                        <text class="text-3xl">Add Team</text>
                    </div>
                </div>
                <div class="bg-[#EA33C0] h-[2px]"></div>
            </div>
        </div>
        <form method="post" action="{{ route('Team.store') }}" enctype="multipart/form-data" class="mt-7"
            data-astro-cid-rwhxyfax>
            @csrf

            <div class="flex py-5 gap-3" data-astro-cid-rwhxyfax>
                <input type="radio" id="clientradio" name="TeamType" value="Client" checked>
                <label for="clientradio">Client Team</label>

                <input type="radio" id="partnerradio" name="TeamType" value="Creative">
                <label for="partnerradio">Creative Partner Team</label>

                <input type="radio" id="partnerradio" name="TeamType" value="Media">
                <label for="partnerradio">Media Agency</label>
            </div>


            <div class="flex flex-col gap-3 w-full" data-astro-cid-rwhxyfax>
                <div class="mb-4">
                    <label for="teamName" class="block font-medium mb-1">Team Name</label>
                    <input required id="teamName" type="text" name="teamName" placeholder="Enter Team Name"
                        class="input input-bordered input-primary w-64" value="{{ old('teamName') }}" />
                    @error('teamName')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                <div class="divider" data-astro-cid-rwhxyfax></div>
                <div data-astro-cid-rwhxyfax>
                    <button role="button" type="submit" class="btn rounded-full bg-accent text-white no-animation"
                        id="btnAddTeam" data-astro-cid-rwhxyfax>
                        Save Changes
                    </button>
                </div>
            </div>
        </form>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Get references to the radio buttons
                const clientRadio = document.getElementById("clientradio");
                const partnerRadio = document.getElementById("partnerradio");

                const clientDropdown = document.getElementById("clientDropdown");
                const partnerDropdown = document.getElementById("partnerDropdown");

                clientDropdown.style.display = "none";
                partnerDropdown.style.display = "none";

                // Add event listeners to the radio buttons
                clientRadio.addEventListener("change", function() {
                    if (clientRadio.checked) {
                        clientDropdown.style.display = "block";
                        partnerDropdown.style.display = "none";
                    }
                });

                partnerRadio.addEventListener("change", function() {
                    if (partnerRadio.checked) {
                        partnerDropdown.style.display = "block";
                        clientDropdown.style.display = "none";
                    }
                });
            });
        </script>
    @endsection
