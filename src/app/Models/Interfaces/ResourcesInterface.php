<?php
namespace App\Models\Interfaces;

interface ResourcesInterface {
    public function checkIfUserHasAccess() : bool ;
}
