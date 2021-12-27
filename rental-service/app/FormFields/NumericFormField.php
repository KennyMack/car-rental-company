<?php

namespace App\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class NumericFormField extends AbstractHandler
{
    protected $codename = 'numeric';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('formFields.numeric', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
