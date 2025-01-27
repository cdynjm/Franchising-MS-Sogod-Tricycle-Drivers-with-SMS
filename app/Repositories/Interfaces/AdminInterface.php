<?php

namespace App\Repositories\Interfaces;

interface AdminInterface {

   public function categories();
   public function categoriesCount();
   
   public function newApplication();
   public function application($request);

   public function renewal();
   public function categoryUsers($request);

   public function getCategory($request);

   public function getAccount($request);
   public function franchiseHistory($request);

   public function previousFranchise($request);

   public function signature();

   public function getUsersByCategory($request);
}

?>
