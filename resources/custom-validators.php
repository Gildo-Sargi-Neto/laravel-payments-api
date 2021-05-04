<?php

use Illuminate\Support\Facades\Validator;

Validator::extend('cpf_cnpj', function ($attribute, $value, $parameters) {
    return cpfOrCnpjValid($value);
});
