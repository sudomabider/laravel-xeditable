<?php
/**
 * Created by PhpStorm.
 * User: veoc
 * Date: 9/01/17
 * Time: 11:31 AM
 */

namespace Sudomabider\LaravelXEditable;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class XEditableRequest extends FormRequest
{
    protected function allowedEditableNames()
    {
        return [];
    }

    protected function xeditRules()
    {
        if ($names = $this->allowedEditableNames()) {
            return [
                'name' => 'required|in:' . implode(',', $names),
                'value' => 'present'
            ];
        }

        return [
            'name' => 'required',
            'value' => 'present'
        ];
    }

    public function validate()
    {
        Validator::make($this->all(), $this->xeditRules())->validate();

        $this->normalizeXEditableRequestData();

        parent::validate();
    }

    public function authorize()
    {
        return true;
    }

    private function normalizeXEditableRequestData()
    {
        // copying the parameters first because there might be a name collision
        list($name, $value) = [$this->input('name'), $this->input('value')];

        $this->request->remove('name');
        $this->request->remove('value');
        $this->request->set($name, $value);
    }
}