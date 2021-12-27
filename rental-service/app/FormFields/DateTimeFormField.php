<?php

namespace App\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class DateTimeFormField extends AbstractHandler
{
    protected $codename = 'datetime';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('formFields.datetime', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
