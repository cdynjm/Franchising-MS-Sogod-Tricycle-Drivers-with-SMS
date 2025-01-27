
<!-- list of all categories -->

<table class="table table-hover text-nowrap" id="category-data" style="font-size: 13px">
    <thead>
        <th>No.</th>
        <th>Category</th>
        <th>Color Code</th>
        <th>Description/Route</th>
        <th>Action</th>
    </thead>
    <tbody>
        @php $count = 1; @endphp
        @foreach ($categories as $cat)
            <tr>
                <td id="{{ $aes->encrypt($cat->id) }}" category="{{ $cat->category }}" color="{{ $cat->color }}"
                    description="{{ $cat->description }}">{{ $count++ }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="me-3"><img src="{{ asset('storage/files/'.$cat->picture) }}" class="avatar avatar-xl object-fit-cover rounded shadow-lg border border-secondary" alt=""></div>
                        <div class="fw-bold">{{ $cat->category }}</div>
                    </div>
                </td>
                <td>{{ $cat->color }}</td>
                <td>{{ $cat->description }}</td>
                <td>
                    <a href="javascript:;" class="me-2" id="edit-category">
                    <button type="button" class="btn btn-primary">Edit</button>
                    </a>
                    <a href="javascript:;" class="me-2" id="delete-category">
                    <button type="button" class="btn btn-danger">Delete</button>
                    </a>
                </td>
            </tr>
        @endforeach
        @if ($count == 1)
            <tr>
                <td class="text-center" colspan="4">No Data Found</td>
            </tr>
        @endif
    </tbody>
</table>
