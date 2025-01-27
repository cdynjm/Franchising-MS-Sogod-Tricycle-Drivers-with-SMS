
<!-- displays all the franchise history and previous applicants for that franchise -->

<table class="table table-hover text-nowrap" id="view-franchise-history-data" style="font-size: 13px">
    <thead>
        <th width="5%">No.</th>
        <th>Applicant</th>
        <th>Address</th>
        <th>Case Number</th>
        <th>Applied/Renew</th>
        <th>Expiration</th>
        <th>Status</th>
        <th>Action</th>
    </thead>
    <tbody>
        @php $count = 1; @endphp
        @foreach ($franchise as $fr)
            <tr>
                <td><span class="d-flex mt-2">
                        {{ $count++ }}
                    </span></td>
                <td class="text-center">
                    <span class="d-flex mt-2">
                        <a class="text-dark" wire:navigate
                            href="{{ route('user.view-application', ['id' => $aes->encrypt($fr->id)]) }}?{{ \Str::random(20) }}"
                            class="me-2">
                            {{ $fr->applicant }}
                        </a>
                    </span>
                </td>
                <td>
                    <span class="d-flex mt-2">
                        {{ $fr->address }}
                    </span>
                </td>
                <td>
                    <span class="d-flex mt-2">
                        {{ $fr->caseNumber }}
                    </span>
                </td>
                <td>
                    <span class="d-flex mt-2">
                        {{ date('F d, Y', strtotime($fr->created_at)) }}
                    </span>
                </td>
                <td>
                    @if ($fr->expiresOn != null)
                        <span class="d-flex mt-2">
                            {{ date('F d, Y', strtotime($fr->expiresOn)) }}
                        </span>
                    @else
                        <span class="d-flex mt-2">-</span>
                    @endif
                </td>
                <td>
                    @if ($fr->status == 0 && $fr->isActive == 0)
                        <span class="d-flex mt-2 text-danger">
                            Pending
                        </span>
                    @endif
                    @if ($fr->status == 1 && $fr->isActive == 0)
                        <span class="d-flex mt-2 text-primary">
                            For Payment & Signature/s
                        </span>
                    @endif
                    @if ($fr->status == 2 && $fr->isActive == 1)
                        <span class="d-flex mt-2 text-success">
                            Valid
                        </span>
                    @endif
                    @if ($fr->status == 2 && $fr->isActive == 0)
                        <span class="d-flex mt-2 text-danger">
                            Expired
                        </span>
                    @endif
                    @if ($fr->status == 3 && $fr->isActive == 0)
                        <span class="d-flex mt-2 text-danger">
                            Pending
                        </span>
                    @endif
                    @if ($fr->status == 4 && $fr->isActive == 0)
                        <span class="d-flex mt-2 text-primary">
                            For Payment & Signature/s
                        </span>
                    @endif
                    @if ($fr->status == 5 && $fr->isActive == 5)
                        <span class="d-flex mt-2 text-danger">
                            Expired
                        </span>
                    @endif
                </td>
                <td>
                    <span class="d-flex mt-2">
                        <a wire:navigate
                            href="{{ route('user.view-application', ['id' => $aes->encrypt($fr->id)]) }}?{{ \Str::random(20) }}"
                            class="me-2">
                            <button type="button" class="btn btn-primary">View</button>
                        </a>
                    </span>
                </td>
            </tr>
        @endforeach
        @if ($count == 1)
            <tr>
                <td class="text-center" colspan="10">No Data Found</td>
            </tr>
        @endif
    </tbody>
</table>
