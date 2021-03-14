<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use \Bissolli\ValidadorCpfCnpj\CPF;
use \Bissolli\ValidadorCpfCnpj\CNPJ;

class CpfCnpj implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $documentCpf = new CPF($value);
        $documentCnpj = new CNPJ($value);
        return $documentCpf->isValid() || $documentCnpj->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Field register_code invalid.';
    }
}
