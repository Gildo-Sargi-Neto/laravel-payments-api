<?php

/**
 * Validates if value is a valid CPF or CNPJ
 *
 * @param  $value
 *
 * @return boolean
 */
function cpfOrCnpjValid($value)
{
    if (!validateCpf($value) && !validateCnpj($value)) {
        return false;
    }
    return true;
}

/**
 * Validates the CPF
 *
 * @param  $value
 *
 * @return boolean
 */
function validateCpf($value)
{
    if (!isCpf($value)) {
        return false;
    }

    if (substr_count($value, $value[0]) === 11) {
        return false;
    }

    $value = preg_replace('#[^0-9]#', '', $value);

    for ($i = 0; $i < 2; $i++) {
        $total = 0;
        for ($j = 0; $j < 9 + $i; $j++) {
            $total += $value[$j] * ((10 + $i) - $j);
        }
        $digit = ($total % 11) < 2 ? 0 : (11 - ($total % 11));
        if ($digit != $value[$j]) {
            return false;
        }
    }
    return true;
}

/**
 * Utilizes regex to verify if informed value is a CPF
 *
 * @param string $value
 *
 * @return bool
 */
function isCpf($value)
{
    return preg_match('/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/', $value) || preg_match('/^\d{11}$/', $value);
}

/**
 * Validates the CNPJ
 *
 * @param  $value
 *
 * @return boolean
 */
function validateCnpj($value)
{
    if (!isCnpj($value)) {
        return false;
    }

    $value = preg_replace('/[^0-9]/', '', $value);

    if (substr_count($value, $value[0]) === 14) {
        return false;
    }

    $length =  12;
    $numbers = $value;
    $digits = substr($value, 12);
    $total = 0;
    $pos = $length - 7;
    for ($i = $length; $i >= 1; $i--) {
        $total += $numbers[$length - $i] * $pos--;
        if ($pos < 2) {
            $pos = 9;
        }
    }
    $resultado = $total % 11 < 2 ? 0 : 11 - $total % 11;
    if ($resultado != $digits[0]) {
        return false;
    }

    $length = $length + 1;
    $numbers = substr($value, 0, $length);
    $total = 0;
    $pos = $length - 7;
    for ($i = $length; $i >= 1; $i--) {
        $total += $numbers[$length - $i] * $pos--;
        if ($pos < 2) {
            $pos = 9;
        }
    }
    $resultado = $total % 11 < 2 ? 0 : 11 - $total % 11;
    if ($resultado != $digits[1]) {
        return false;
    }
    return true;
}

/**
 * Utilizes regex to verify if informed value is a cnpj
 *
 * @param string $cnpj
 *
 * @return bool
 */
function isCnpj($cnpj)
{
    return preg_match('/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/', $cnpj) || strlen($cnpj) === 14;
}
