<table class="table table-hover text-nowrap" id="view-category-data" style="font-size: 13px">
    <thead>
        <th width="5%">No.</th>
        <th class="text-center">Body Number</th>
        <th>Current Applicant</th>
        <th>Applied/Renew</th>
        <th>Expiration</th>
        <th>Status</th>
        <th>Action</th>
    </thead>
    <tbody>
        @php $count = 1; @endphp
        @foreach ($users as $us)
            <tr>
                <td

                ><span class="d-flex mt-2">
                    {{ $count++ }}
                </span></td>
                <td class="text-center">
                    <a class="text-dark" wire:navigate href="{{ route('view-franchise-history', ['id' => $aes->encrypt($us->userID)]) }}?{{ \Str::random(20) }}">
                        <button class="btn bg-warning fw-bold shadow-lg text-center">
                            {{ $us->user->name }}
                        </button>
                    </a>
                </td>
                <td> 
                    <span class="d-flex mt-2">
                        {{ $us->applicant }}
                    </span>
                </td>
                <td> 
                    <span class="d-flex mt-2">
                        {{ date('F d, Y', strtotime($us->created_at)) }}
                    </span>
                </td>
                <td> 
                    @if($us->expiresOn != null)
                    <span class="d-flex mt-2">
                        {{ date('F d, Y', strtotime($us->expiresOn)) }}
                    </span>
                    @else
                    <span class="d-flex mt-2">-</span>
                    @endif
                </td>
                <td>
                    @if($us->status == 0 && $us->isActive == 0)
                    <span class="d-flex mt-2 text-danger">
                        Pending
                    </span>
                    @endif
                    @if($us->status == 1 && $us->isActive == 0)
                    <span class="d-flex mt-2 text-primary">
                        For Payment & Signature/s
                    </span>
                    @endif
                    @if($us->status == 2 && $us->isActive == 1)
                    <span class="d-flex mt-2 text-success">
                        Valid
                    </span>
                    @endif
                    @if($us->status == 2 && $us->isActive == 0)
                    <span class="d-flex mt-2 text-danger">
                        Expired
                    </span>
                    @endif
                    @if($us->status == 3 && $us->isActive == 0)
                    <span class="d-flex mt-2 text-danger">
                        Pending
                    </span>
                    @endif
                    @if($us->status == 4 && $us->isActive == 0)
                    <span class="d-flex mt-2 text-primary">
                        For Payment & Signature/s
                    </span>
                    @endif
                </td>
                <td>
                    <span class="d-flex mt-2">
                        <a wire:navigate href="{{ route('view-franchise-history', ['id' => $aes->encrypt($us->userID)]) }}?{{ \Str::random(20) }}" class="me-2">
                            <i class="fas fa-eye"></i>
                        </a>
                    </span>
                </td>
            </tr>
        @endforeach
        @if($count == 1)
            <tr>
                <td class="text-center" colspan="10">No Data Found</td>
            </tr>
        @endif
    </tbody>
</table>