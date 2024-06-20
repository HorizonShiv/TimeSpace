@extends('Layout.sidebar')
@section('main-container')

    <div class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full" id="content" data-astro-cid-sckkx6r4>

        <div class="my-7" data-astro-cid-jf5gi763>
            <div class="flex flex-col w-full gap-7 mt-5">
                <div class="flex gap-7 justify-start">
                    <div class="flex flex-col gap-1 mt-5">
                        <text class="text-3xl">Add SubCategory</text>
                    </div>
                </div>
                <div class="bg-[#EA33C0] h-[2px]"></div>
            </div>
        </div>
        <form method="post" action="{{ route('Company.store') }}" enctype="multipart/form-data" class="mt-7"
              data-astro-cid-rwhxyfax>
            @csrf

            <div class="flex flex-col gap-3 w-full" data-astro-cid-rwhxyfax>

                <div class="mb-4">
                    <label for="teamName" class="block font-medium mb-2">Category</label>
                    <input id="subCategory" type="text" name="subCategory" placeholder="Enter the sub-category"
                           class="input input-bordered input-primary w-96" value="{{ old('subCategory') }}" />
                    @error('teamName')
                    <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                <div class="divider" data-astro-cid-rwhxyfax></div>
                <div data-astro-cid-rwhxyfax>
                    <button role="button" type="submit" class="btn rounded-full bg-accent text-white no-animation" id="btnAddTeam"
                            data-astro-cid-rwhxyfax>
                        Save Changes
                    </button>
                </div>
            </div>
        </form>

@endsection
