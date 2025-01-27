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

    //renders the franchise history data.
    public function render() {
        $aes = new AESCipher;
        $franchise = Franchise::where('userID', $aes->decrypt($this->accountID))->where('hasComment', null)
                            ->orderBy('created_at', 'DESC')
                            ->paginate(50);
        return view('livewire.view-franchise-history-data', ['aes' => $aes, 'franchise' => $franchise])->section('content');
    }
    public function paginationView() {
        return 'vendor.livewire.custom-pagination';
    }
}
