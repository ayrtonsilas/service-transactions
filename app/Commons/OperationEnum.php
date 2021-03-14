<?php

namespace App\Commons;

class OperationEnum
{
    const DEBIT = 'debit';
    const CREDIT = 'credit';

    static function enumToString(){
        return OperationEnum::DEBIT.','.OperationEnum::CREDIT;
    }
}
