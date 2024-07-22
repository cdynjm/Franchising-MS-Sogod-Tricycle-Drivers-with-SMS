<table class="table table-hover text-nowrap" id="renewal-data" style="font-size: 13px">
    <thead>
        <th>No.</th>
        <th>Applicant Name</th>
        <th>Category</th>
        <th class="text-center">Body Number</th>
        <th>Status</th>
        <th>Action</th>
    </thead>
    <tbody>
        @php $count = 1; @endphp
        @foreach ($renewal as $rw)
            <tr>
                <td>
                    <span class="d-flex mt-2">
                        {{ $count++ }}
                    </span>
                </td>
                <td>
                    <span class="d-flex mt-2">
                        <a class="text-dark" wire:navigate
                            href="{{ route('view-application', ['id' => $aes->encrypt($rw->id)]) }}?{{ \Str::random(20) }}">
                            {{ $rw->applicant }}
                        </a>
                    </span>
                </td>
                <td class="text-center">
                    <span class="d-flex mt-2">
                        {{ $rw->user->categories->category }}
                    </span>
                </td>
                <td class="text-center">
                    <a class="text-dark" wire:navigate href="">
                        <button class="btn bg-warning fw-bold shadow-lg text-center">
                            {{ $rw->user->name }}
                        </button>
                    </a>
                </td>
                <td>
                    @php
                        $statusLabels = [3 => 'text-danger|Pending', 4 => 'text-success|For Payment & Signature/s'];
                        [$class, $label] = explode('|', $statusLabels[$rw->status] ?? 'text-muted|Unknown');
                    @endphp
                    <span class="{{ $class }} d-flex mt-2">{{ $label }}</span>
                </td>
                <td>
                    <span class="d-flex mt-2">
                        <a wire:navigate
                            href="{{ route('view-application', ['id' => $aes->encrypt($rw->id)]) }}?{{ \Str::random(20) }}"
                            class="me-2">
                            <i class="fas fa-eye"></i>
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
