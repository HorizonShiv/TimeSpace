@extends('Layout.sidebar')

@section('addStyleScript')
<style>
    .notification {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 10px;
        background-color: #f5f5f5;
        margin-bottom: 10px;
    }
    .profile-pic {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #6a74db;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
    }
    .notification-content {
        flex-grow: 1;
        margin-left: 10px;
    }
    .notification-header {
            display: flex;
            font-size: 12px;
            color: #888888;
        }
        .notification-header span:not(:last-child)::after {
            content: " • ";
            white-space: pre;
        }
        .notification-body {
            font-size: 14px;
            font-weight: normal;
            margin: 5px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .notification-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            font-size: 12px;
            color: #888888;
        }
        .dot {
            height: 15px;
            width: 15px;
            background-color: red;
            border-radius: 50%;
            display: inline-block;
            margin-left: 5px;
        }
</style>
@endsection
@section('main-container')
<div class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full" id="content" data-astro-cid-sckkx6r4>
    <div class="flex flex-col md:flex-row justify-between">
        <h3 class="text-4xl font-semibold">My Notification</h3>
        <div class="flex gap-3">
            <!-- search  -->
            <a href="#" data-astro-cid-ujfssy6h>
                <button
                    class="btn btn-outline border border-primary rounded-full hover:bg-transparent hover:border hover:border-primary mb-3"
                    data-astro-cid-ujfssy6h>
                    <img src="/assets/sidebar/settings.png" class="w-[20px] h-[20px]"
                        data-astro-cid-ujfssy6h />
                    <p class="text-sm font-medium text-[#555555]" data-astro-cid-ujfssy6h>
                            Change Preference
                    </p>
                </button>
            </a>
        </div>

    </div>
    <div class="flex flex-col md:flex-row justify-between" style="margin-top: 10px">
        {{-- @php
        $notifications = \App\Models\Notification::all();
        $notificationCount = $notifications->count();
    @endphp --}}


    @php
    $notificationCount = $notifications->count();
    @endphp
        <h1 class="text-3xl" style="color: red">New! -  {{ $notificationCount }}</h1>
        <div class="flex gap-3">
            <!-- search  -->
            <a href="#" for="checkbox" class="ml-4" style="text-decoration:underline !important;"><ul>Mark all as a Read</ul></a>
        </div>

    </div>

   

    @foreach ($notifications as $notification)
    <div class="notification">
        <div class="flex gap-1" data-astro-cid-ih4xnkm6>
            <div
                class="bg-[#c72ba4] flex justify-center items-center text-white w-10 h-10 rounded-full font-semibold border border-[#ea33c0]">
                {{ strtoupper(substr($user_name, 0, 2)) }}
            </div>
        {{-- @endforeach --}}
    {{-- @endif --}}
</div>
        {{-- <div class="profile-pic">{{ dd() }}</div> --}}
        <div class="notification-content">
            <div class="notification-header mt-2">
                <span>{{ $notification->User->name ?? '' }}</span>
                <span>{{ $notification->campaign->campaign_name ?? '' }}</span>
                <span>{{ $notification->flight_connection->language ?? 'N/A' }} / {{ $notification->flight_connection->type ?? 'N/A' }} / {{ $categoryName ?? '' }}</span>

            </div>
            <div class="notification-body">
                <span>{{ $notification->User->name ?? '' }} has submitted <b>{{ $notification->AdvertisementType->name ?? '' }}</b> assets for review.
                @if($notification->remarks != null)
                And the remarks are <b>{{ $notification->remarks }}</b>
            @endif
        </span>
                <span>
                    {{ $user_name ?? '' }} • {{ $notification->created_at->format('h:ia • m/d/Y') }}
                    <span class="dot" style="margin-left: 40px"></span>
                </span>
                
                
            </div>
            {{-- <div class="notification-footer">
                
            </div> --}}
        </div>
    </div>
    <div class="divider" style="margin: 0px !important; opacity: 40% " data-astro-cid-rwhxyfax></div>
    @endforeach
    
</div>

@endsection
