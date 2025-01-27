@php

    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    use App\Models\Franchise;
    use App\Models\SMSToken;
    use App\Models\Signature;
    use Carbon\Carbon;

    $smsToken = SMSToken::first();
    $signature = Signature::first();
    $aes = new AESCipher();

    // this code executes every time the page is navigated.
    // it will check all the franchise records expiration dates and automatically updates it once the the date of expiration has been surpassed.

    Franchise::where('expiresOn', '<', date('Y-m-d'))
                ->where('isActive', '!=', 5)
                ->where('status', '!=', 5)
                ->update(['isActive' => 0]);
    
    // it will display the notifications data, if there is new application and new renewal of franchise.
    $notif = Franchise::whereIn('status', [0, 1, 3, 4])->where('hasComment', null)->orderBy('created_at', 'DESC');


    $franchises = Franchise::where('expiresOn', '>=', date('Y-m-d'))
                        ->where('expiresOn', '<=', date('Y-m-d', strtotime('+90 days')))
                        ->where('isActive', '!=', 5)
                        ->where('status', '!=', 5)
                        ->whereNull('warning') // Ensure no previous warning was sent
                        ->get();

    foreach ($franchises as $franchise) {
        // Calculate the number of days left until expiration
        $expirationDate = new DateTime($franchise->expiresOn);
        $currentDate = new DateTime();
        $interval = $currentDate->diff($expirationDate);
        $daysLeft = $interval->days;  // Get the number of days left

        // Send SMS if franchise is about to expire in 90 days
        $send_data = [];
        $send_data['sender_id'] = "PhilSMS";
        $send_data['recipient'] = "+63" . ltrim($franchise->contactNumber, '0');
        $send_data['message'] = "Reminder: Your tricycle franchise with Sogod Franchising Office will expire in " . $daysLeft . " days on " . date('M d, Y', strtotime($franchise->expiresOn)) . ". Visit our office immediately after the expiration date for renewal to avoid penalties. Body No.: " . $franchise->categories->category . "-" . sprintf('%03d', $franchise->user->name);

        // API Token
        $token = $smsToken->access_token;

        $parameters = json_encode($send_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $get_sms_status = curl_exec($ch);

        if ($get_sms_status === false) {
            $error_message = curl_error($ch);
            // Handle the error as needed
            echo "Error sending SMS: $error_message";
        } else {
            var_dump($get_sms_status);  // For debugging response
        }

        curl_close($ch);

        // Update the 'warning' column to 1 to prevent future SMS
        $franchise->update(['warning' => 1]);
    }
@endphp

@extends('modals.profile-modal')
@extends('modals.admin.update.sms-token-modal')
@extends('modals.admin.update.signature-modal')

<header id="page-topbar" class="isvertical-topbar bg-white border-bottom">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="javascript:;" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('storage/logo/logo-sogod.gif') }}" alt="" class="m-0"
                            height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('storage/logo/logo-sogod.gif') }}" alt="" height="40">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-lg">
                        <img src="/assets/images/logo-light.png" alt="" height="30">
                    </span>
                    <span class="logo-sm">
                        <img src="/assets/images/logo-light-sm.png" alt="" height="26">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm font-size-24 header-item waves-effect vertical-menu-btn">
                <i class="bx bx-menu align-middle"></i>
                <h6 class="d-lg-none d-sm-block">FMS</h6>
            </button>

            <!-- start page title -->
            <div class="page-title-box align-self-center d-none d-md-block">
                <h6 class="fw-bold mt-2" style="font-size: 18px">{!! $page !!}</h6>
            </div>
            <!-- end page title -->

        </div>

        <div class="d-flex">
            
            @can('accessAdmin', Auth::user())
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon" id="page-header-notifications-dropdown-v"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span style="background-color: #f7f4ea; padding: 8px; display: inline-flex; align-items: center; justify-content: center; border-radius: 4px;">
                            <i class="bx bx-bell icon-sm align-middle text-warning"></i>
                        </span>
                        <span class="noti-dot bg-danger rounded-pill">{{ $notif->count() }}</span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown-v">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="m-0 font-size-15"> Notifications </h5>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 250px;">

                            @foreach ($notif->get() as $nf)
                                @php
                                    $created = Carbon::parse($nf->created_at);
                                    $now = Carbon::now();
                                    $diffInDays = $now->diffInDays($created);
                                    $formattedDate =
                                        $diffInDays > 3 ? $created->format('M d, Y h:i A') : $created->diffForHumans();
                                @endphp
                                <a wire:navigate
                                    href="{{ route('view-application', ['id' => $aes->encrypt($nf->id)]) }}?{{ \Str::random(20) }}"
                                    class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-sm me-3">
                                            <span class="avatar-title bg-success rounded-circle font-size-18">
                                                <i class="bx bx-badge-check"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted font-size-13 mb-0 float-end">{{ $formattedDate }}</p>
                                            <h6 class="mb-1">{{ $nf->applicant }}</h6>
                                            <div>
                                                <p class="mb-0">
                                                    @if ($nf->status == 0 || $nf->status == 1)
                                                        New Franchise Application! Check it now
                                                    @endif
                                                    @if ($nf->status == 3 || $nf->status == 4)
                                                        New Franchise Renewal! Check it now
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                            @if ($notif->count() == 0)
                                <div class="alert alert-danger d-flex mx-4">No new notifications</div>
                            @endif
                        </div>

                    </div>
                </div>
            @endcan

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item user text-start d-flex align-items-center"
                    id="page-header-user-dropdown-v" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    @can('accessAdmin', Auth::user())
                        <img class="rounded header-profile-user" src="{{ asset('storage/icons/admin.png') }}" alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-2 fw-medium font-size-15">{{ Auth::user()->name }}</span>
                    @endcan
                    @can('accessUser', Auth::user())
                        <img class="rounded header-profile-user" src="{{ asset('storage/icons/driver.png') }}" alt="Header Avatar">
                        <span class="ms-2 fw-medium font-size-15">{{ Auth::user()->email }} {{ ucwords(Auth::user()->categories->color) }}</span>
                    @endcan

                    <!-- Dropdown icon -->
                    <i class="ms-2 bx bx-chevron-down"></i> <!-- Adjust icon as needed -->
                </button>

                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="p-3 border-bottom">
                        @can('accessAdmin', Auth::user())
                            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                            <p class="mb-0 font-size-11 text-muted">{{ Auth::user()->email }}</p>
                        @endcan
                        @can('accessUser', Auth::user())
                            <h6 class="mb-0">{{ Auth::user()->email }}
                                {{ ucwords(Auth::user()->categories->color) }}</h6>
                            <p class="mb-0 font-size-11 text-muted">{{ Auth::user()->email }}</p>
                        @endcan
                    </div>
                    <a class="dropdown-item" href="javascript:;" id="profile" data-name="{{ Auth::user()->name }}"
                        data-email="{{ Auth::user()->email }}"><i
                            class="mdi mdi-account-circle text-muted font-size-16 align-middle me-2"></i> <span
                            class="align-middle">Profile</span></a>
                    @can('accessAdmin', Auth::user())
                        <a class="dropdown-item" href="javascript:;" id="sms-token"
                            data-token="{{ $smsToken->access_token }}"
                            data-mobile="{{ $smsToken->mobile_identity }}"><i
                                class="bx bxs-message-dots text-muted font-size-16 align-middle me-2"></i> <span
                                class="align-middle">SMS Token</span></a>
                        <a class="dropdown-item" href="javascript:;" id="signature"
                            data-mayor="{{ $signature->mayor }}"
                            data-police="{{ $signature->police }}"><i
                                class="bx bxs-pen text-muted font-size-16 align-middle me-2"></i> <span
                                class="align-middle">Signatures</span></a>
                    @endcan
                   
                </div>
            </div>
        </div>
    </div>
</header>
