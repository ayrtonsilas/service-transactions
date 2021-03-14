<?php

namespace App\Commons;

class TypeUserEnum
{
    const USER = 'user';
    const STOREKEEPER = 'storekeeper';

    static function enumToString(){
        return TypeUserEnum::USER.','.TypeUserEnum::STOREKEEPER;
    }
}
