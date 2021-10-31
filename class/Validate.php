<?php

class validate
{
    private $_errors = array();
    private $_formMethod = null;

    public function __construct($formMethod)
    {
        $this->_formMethod = $formMethod;
    }

    public function setRules($item, $itemLabel, $rules)
    {
        $formValue = Input::get($item);

        if (array_key_exists("sanitize", $rules)) {
            $formValue = Input::runSanitize($formValue, $rules["sanitize"]);
        }

        foreach ($rules as $ruleKey => $ruleValue) {
            switch ($ruleKey) {
                case "required":
                    if ($ruleValue === true && empty($formValue)) {
                        $this->_errors[$item] = "{$itemLabel} tidak boleh kosong";
                    }
                break;
                case "min_char":
                    if (strlen($formValue) < $ruleValue) {
                        $this->_errors[$item] = "{$itemLabel} minimal {$ruleValue} karakter";
                    }
                break;
                case "max_char":
                    if (strlen($formValue) > $ruleValue) {
                        $this->_errors[$item] = "{$itemLabel} maximal {$ruleValue} karakter";
                    }
                break;
                case "numeric":
                    if ($ruleValue === true && !is_numeric($formValue)) {
                        $this->_errors[$item] = "{$itemLabel} harus berupa angka";
                    }
                break;
                case "min_value":
                    if ($formValue < $ruleValue) {
                        $this->_errors[$item] = "{$itemLabel} minimal {$ruleValue}";
                    }
                break;
                case "max_value":
                    if ($formValue > $ruleValue) {
                        $this->_errors[$item] = "{$itemLabel} minimal {$ruleValue}";
                    }
                break;
                case "matches":
                    if ($formValue != Input::get($ruleValue)) {
                        $this->_errors[$item] = "{$itemLabel} tidak sama";
                    }
                break;
                case "email":
                    if ($ruleValue === true && !filter_var($formValue, FILTER_VALIDATE_EMAIL)) {
                        $this->_errors[$item] = "{$itemLabel} tidak sesuai format";
                    }
                break;
                case "url":
                    if ($ruleValue === true && !filter_var($formValue, FILTER_VALIDATE_URL)) {
                        $this->_errors[$item] = "Format {$itemLabel} tidak sesuai";
                    }
                break;
                case "regexp":
                    if (!preg_match($ruleValue, $formValue)) {
                        $this->_errors[$item] = "Pola {$itemLabel} tidak sesuai";
                    }
                break;
                case "unique":
                    $DB = DB::getInstance();
                    $tableName = array_key_first($ruleValue);
                    $columnName = $ruleValue[$tableName];
                    if ($DB->check($tableName, $columnName, $formValue)) {
                        $this->_errors[$item] = "{$itemLabel} {$formValue} sudah ada";
                    }
                break;
            }

            if (!empty($this->_errors[$item])) {
                break;
            }
        }

        return $formValue;
    }

    public function getError()
    {
        return $this->_errors;
    }

    public function isPassed()
    {
        return (empty($this->_errors)) ? true : false;
    }
}
