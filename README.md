## A simple package to make xeditable easier to use within Laravel.

### Installation

```
composer require sudomabider/laravel-xeditable
```

That's it.

### Instructions

1. Have your x-editable based requests extend `Sudomabider\LaravelXEditable\XEditableRequest`. This class will first validate the initial request to make sure it's a valid x-editable request, and then rearrange the request parameters into a normal form request, e.g. from `{name: 'gender', value: 'male'}` into `{gender: 'male'}`  

2. You may restrict the names allowed from a request
```php
protected function allowedEditableNames()
{
    return ['name', 'gender', 'email'];
}
```
This is particular useful when multiple x-editable requests are grouped into a single class.

3. Define validation rules as you would in a normal form request:
```php
public function rules()
{
    return [
        'email' => 'required|email'
    ];
}
```
You may want to return different rules depending on which parameter is present:
```php
public function rules()
{
    if ($this->exists('email')) {
        return [
            'email' => 'required|email'
        ];
    }
    
    if ($this->exists('name')) {
        return [
            'name' => 'required|min:3'
        ];
    }
}
```