@extends('Layout.sidebar')

@section('main-container')

    <div class="ml-0 md:ml-[300px] mt-[55px] py-7 px-10 w-full" id="content" data-astro-cid-sckkx6r4>
        <div class="flex justify-between" data-astro-cid-rwhxyfax>
            <h1 class="text-4xl font-semibold">Create Client</h1>
        </div>
        <form method="post" action="{{ route('User.store') }}" enctype="multipart/form-data" class="mt-7"
              data-astro-cid-rwhxyfax>
            @csrf

            <div class="flex flex-col gap-3 w-full" data-astro-cid-rwhxyfax>

                <div class="input-group flex items-center w-full">
                    <label class="label-text whitespace-normal w-36 min-w-[150px]">Client Name</label>
                    <input type="text" placeholder="John" name="ClientName"
                           class="input input-bordered input-primary w-full" value="{{ old('ClientName') }}" />

                </div>

                <p style="color: red">
                    @error('ClientName')
                    {{ $message }}
                    @enderror
                </p>
                <div class="input-group flex items-center w-full">
                    <label class="label-text whitespace-normal w-36 min-w-[150px]">Client Number</label>
                    <div class="flex items-center gap-5 w-full" data-astro-cid-rwhxyfax>
                        <input type="text" placeholder="+1 12131224" name="ClientNumber"
                               class="input input-bordered input-primary min-w-96" value="{{ old('ClientNumber') }}" />
                        <p style="color: red">
                            @error('ClientNumber')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>
                </div>

                <div class="input-group flex items-center w-full">
                    <label class="label-text whitespace-normal w-36 min-w-[150px]">Client Email</label>
                    <div class="flex items-center gap-5 w-full" data-astro-cid-rwhxyfax>
                        <input type="text" placeholder="example@gmail.com" name="ClientEmail"
                               class="input input-bordered input-primary min-w-96" value="{{ old('ClientEmail') }}" />
                        <p style="color: red">
                            @error('ClientEmail')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>
                </div>


                <div class="divider" data-astro-cid-rwhxyfax></div>
                <div data-astro-cid-rwhxyfax>
                    <button role="button" type="submit" class="btn rounded-full bg-accent text-white no-animation"
                            data-astro-cid-rwhxyfax>
                        Create Client
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
                            Create Client
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
@endsection
