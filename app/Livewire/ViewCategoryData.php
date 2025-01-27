<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Franchise;
use App\Http\Controllers\AESCipher;
use Carbon\Carbon;

class ViewCategoryData extends Component
{
    use WithPagination;

    public $category;
public $selectedYear;
public $selectedStatus = '2_1'; // Default to 'Valid'
public $searchTerm = ''; // Add searchTerm property

public function mount() {
    $this->selectedYear = Carbon::now()->year;
}

public function filterData() {
    $this->resetPage();
}

public function render() {
    $aes = new AESCipher;
    $currentYear = Carbon::now()->year;
    $years = range(2019, $currentYear);

    // Query for the data, filtered by year, status, and search term
    $usersQuery = Franchise::where('category', $aes->decrypt($this->category))->where('hasComment', null);

    if ($this->selectedYear) {
        $usersQuery->whereYear('created_at', $this->selectedYear);
    }

    if ($this->searchTerm) {
        $usersQuery->where(function ($query) {
            $query->where('applicant', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('code', 'like', '%' . $this->searchTerm . '%');
        });
    }

    if (!is_null($this->selectedStatus)) {
        list($status, $isActive) = explode('_', $this->selectedStatus);
        $usersQuery->where('status', $status)->where('isActive', $isActive);
    }

    $users = $usersQuery->orderBy('code')->paginate(50);

    return view('livewire.view-category-data', [
        'users' => $users,
        'aes' => $aes,
        'years' => $years,
    ])->section('content');
}

public function paginationView() {
    return 'vendor.livewire.custom-pagination';
}
}
