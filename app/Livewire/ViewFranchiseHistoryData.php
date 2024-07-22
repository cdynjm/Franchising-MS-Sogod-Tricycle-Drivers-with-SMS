<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Franchise;
use App\Models\Categories;
use App\Http\Controllers\AESCipher;

class ViewFranchiseHistoryData extends Component
{
    use WithPagination;

    public $accountID;

    public function render()
    {
        $aes = new AESCipher;
        $franchise = Franchise::where('userID', $aes->decrypt($this->accountID))
                            ->orderBy('created_at', 'DESC')
                            ->paginate(20);
        return view('livewire.view-franchise-history-data', ['aes' => $aes, 'franchise' => $franchise]);
    }
}
