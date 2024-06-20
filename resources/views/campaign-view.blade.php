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
    <div class="flex flex-col md:flex-row justify-between">
        <h1 class="text-4xl font-semibold">Campaign List</h1>
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
    <div class="flex flex-col gap-7 mt-7">
        <!-- Kusmi Tea -->
        <div class="flex flex-col gap-4">
            {{-- <h4 class="text-2xl font-medium">Campaign List</h4> --}}
            <div class="flex flex-col gap-5">
                @foreach (\App\Models\Campaign::all() as $Campaign)
                    <div class="flex items-center gap-8">
                        <img src="/campaignHeaderImage/{{ $Campaign->id }}/{{ $Campaign->image ?? '' }}" class="w-[40px] h-[40px] rounded-xl" />
                        <p class="font-medium text-sm text-[#888888]">{{ $Campaign->project_code }}</p>
                        <h4 class="font-medium text-xl">{{ $Campaign->campaign_name }}</h4>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
