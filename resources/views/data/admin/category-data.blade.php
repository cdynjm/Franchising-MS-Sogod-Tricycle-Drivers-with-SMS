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
                <td
                
                id="{{ $aes->encrypt($cat->id) }}"
                category="{{ $cat->category }}"
                color="{{ $cat->color }}"
                description="{{ $cat->description }}"

                >{{ $count++ }}</td>
                <td>{{ $cat->category }}</td>
                <td>{{ $cat->color }}</td>
                <td>{{ $cat->description }}</td>
                <td>
                    <a href="javascript:;" class="me-2" id="edit-category">
                        <i class="fas fa-marker"></i>
                    </a>
                    <a href="javascript:;" class="me-2" id="delete-category">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        @if($count == 1)
            <tr>
                <td class="text-center" colspan="4">No Data Found</td>
            </tr>
        @endif
    </tbody>
</table>