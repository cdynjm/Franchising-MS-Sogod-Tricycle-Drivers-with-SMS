<?php

namespace App\Repositories\Interfaces;

interface UserInterface {

    public function categories();
    
    public function activeUser();

    public function previousFranchise();

    public function franchiseHistory($request);
    
    public function application($request);

    public function signature();
}

?>
