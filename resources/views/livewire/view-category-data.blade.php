<div>

    <!-- this is livewire generated/livewire component which automatically updates the UI once there is changes -->
    <!-- you can refer the 1:1 component based for this in the app/livewire folder -->

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <!-- Search input field -->
                <label for="" class="ms-1"><small>Search:</small></label>
                <input type="text" wire:model="searchTerm" wire:keyup="filterData" class="form-control" placeholder="Search by Body Number or Applicant">
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="mb-3">
                <!-- Select Year dropdown -->
                <label for="" class="ms-1"><small>Renewed on Year:</small></label>
                <select wire:model="selectedYear" wire:change="filterData" class="form-select">
                    <option value="">Select Year</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    
        <div class="col-md-3">
            <div class="mb-3">
                <!-- Select Status dropdown -->
                <label for="" class="ms-1"><small>Status:</small></label>
                <select wire:model="selectedStatus" wire:change="filterData" class="form-select">
                    <optgroup label="General">
                        <option value="2_1">Valid</option>
                        <option value="2_0">Expired</option>
                        <option value="5_5">Already Renewed</option>
                    </optgroup>
                    <optgroup label="New Application">
                        <option value="0_0">Pending New Application</option>
                        <option value="1_0">Payment & Signature/s (New Application)</option>
                    </optgroup>
                    <optgroup label="Renewal">
                        <option value="3_0">Pending Renewal</option>
                        <option value="4_0">Payment & Signature/s (Renewal)</option>
                    </optgroup>
                </select>
                
            </div>
        </div>
    </div>
    
    
    <!-- dispalys all the data of numbers based on the category selected -->

    <div class="table-responsive">
        <table class="table table-hover text-nowrap" id="view-category-data" style="font-size: 13px">
            <thead>
                <th width="5%">No.</th>
                <th class="text-center">Body Number</th>
                <th width="40%">Current Applicant</th>
                <th>Applied/Renew</th>
                <th>Expiration</th>
                <th>Status</th>
               <!-- <th>Account</th> -->
                <th class="text-center">Action</th>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @foreach ($users as $us)
                    <tr>
                        <td><span class="d-flex mt-2">
                                {{ $count++ }}
                            </span></td>
                        <td class="text-center">
                            <a class="text-dark" wire:navigate
                                href="{{ route('view-franchise-history', ['id' => $aes->encrypt($us->userID)]) }}?{{ \Str::random(20) }}">
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
                            @if ($us->expiresOn != null)
                                <span class="d-flex mt-2">
                                    {{ date('F d, Y', strtotime($us->expiresOn)) }}
                                </span>
                            @else
                                <span class="d-flex mt-2">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($us->status == 0 && $us->isActive == 0)
                                <span class="d-flex mt-2 text-danger">
                                    Pending
                                </span>
                            @endif
                            @if ($us->status == 1 && $us->isActive == 0)
                                <span class="d-flex mt-2 text-primary">
                                    For Payment & Signature/s
                                </span>
                            @endif
                            @if ($us->status == 2 && $us->isActive == 1)
                                <span class="d-flex mt-2 text-success">
                                    Valid
                                </span>
                            @endif
                            @if ($us->status == 2 && $us->isActive == 0)
                                <span class="d-flex mt-2 text-danger">
                                    Expired
                                </span>
                            @endif
                            @if ($us->status == 3 && $us->isActive == 0)
                                <span class="d-flex mt-2 text-danger">
                                    Pending
                                </span>
                            @endif
                            @if ($us->status == 4 && $us->isActive == 0)
                                <span class="d-flex mt-2 text-primary">
                                    For Payment & Signature/s
                                </span>
                            @endif
                            @if ($us->status == 5 && $us->isActive == 5)
                                <span class="d-flex mt-2 text-danger">
                                    Already Renewed
                                </span>
                            @endif
                        </td>
                     <!--   <td>
                            <div>Username: <b>{{ $us->User->email }}</b></div>
                            <div>Password: <b>{{ $us->password }}</b></div>
                        </td> -->
                        <td>
                            <span class="d-flex mt-2 align-items-center">
                                <a wire:navigate
                                    href="{{ route('view-franchise-history', ['id' => $aes->encrypt($us->userID)]) }}?{{ \Str::random(20) }}"
                                    class="me-2">
                                    <button type="button" class="btn btn-primary">View</button>
                                </a>
    
                                <!-- this button will be dispalyed once the franchise has expired. the admin can renew the franchise of the applcant through walkin process -->
    
                                @if($us->status == 2 && $us->isActive == 0)
                                <button href="javascript:;" class="btn btn-danger btn-sm shadow-lg ms-1" style="font-size: 12px" id="renew-franchise-walk-in" data-id="{{ $aes->encrypt($us->userID) }}">Renew</button>
                                @endif

                                @if($us->status == 2 && $us->isActive == 1)
                                <a wire:navigate href="{{ route('admin.change-owner-motor', ['id' => $aes->encrypt($us->userID), 'unit' => $aes->encrypt('0')]) }}" class="btn btn-danger btn-sm shadow-lg ms-1" style="font-size: 12px" >Change Motor/Owner</a>
                                @endif
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
    
        <div>
            <!-- this is table pagination. locate the code for this as stated below. -->
            {{ $users->links('vendor.livewire.custom-pagination') }}
        </div>
    </div>
</div>
