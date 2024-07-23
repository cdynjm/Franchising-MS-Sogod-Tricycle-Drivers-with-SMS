<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Franchise;
use App\Models\Categories;
use App\Http\Controllers\AESCipher;

class ViewCategoryData extends Component
{
    use WithPagination;

    public $category;

    public function render()
    {
        $aes = new AESCipher;
        $users = Franchise::where('category', $aes->decrypt($this->category))
                    ->where('status', '!=', 5)
                    ->where('isActive', '!=', 5)
                    ->orderBy('code')
                    ->paginate(50);

        return view('livewire.view-category-data', ['users' => $users, 'aes' => $aes])->section('content');
    }

    public function paginationView()
    {
        return 'vendor.livewire.custom-pagination';
    }
}
