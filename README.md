Formery is a package for programmatically creating and validating forms in Laravel. It comes preconfigured to use Twitter Bootstrap, but can easily be customized to use whatever you want.

Currently, Formery has only been tested in Laravel 5.3 and must be used in blade templates.

## Installation

```
composer require pstephan1187/laravel-forms
```

Register the service provider in your app config:

```
Formery\ServiceProvider::class,
```

Optionally, publish the views to your `resources/views/` directory:

```
php artisan vendor:publish
```

## Quickstart

Creating and displaying the form:

```
use Formery\FormBuilder;

// In your controller constructor:
$this->form = new FormBuilder('/');
$this->form->addField('name', 'Name', \Formery\FieldTypes\Text::class)->addRules('required');
$this->form->addField('email', 'Email', \Formery\FieldTypes\Email::class)->addRules('required');
$this->form->addField('password', 'Password', \Formery\FieldTypes\Password::class)->addRules(['required', 'confirmed']);
$this->form->addField('password_confirmation', 'Confirm Password', \Formery\FieldTypes\Password::class);
$this->form->addButton('Login', 'submit', ['class' => 'pull-right']);

// In your controller route:
return view('form-view')->with(['form' => $this->form]);

// In your view:
@form($form)
```

Validating:

```
// In your controller route:
$this->form->validate($request);
// Process your data here!
```

The `validate` method utilizes the same functionality as the one included in Laravel. It will automatically redirect back to the form with the errors and old input.

## FormBuilder Methods

* `__construct($action, $method = ‘POST’)`
* `useCsrf($use = true)` Formery utilizes CSRF protection automatically. If you wish to disable, you can turn it off via `$form->useCsrf(false);`
* `usePlaceholders($value = true)` Formery can automatically set placeholders for all applicable inputs. `$form->usePlaceholders();`
* `captureOldInput($value = true)` Formery will automatically capture old input if there are errors. To disable: `$form->captureOldInput(false);`
* `addField($name, $label, $type, $attributes = [])` The `$attributes` parameter will apply key-value pairs as attributes on the input tag.
* `addButton($label, $type = 'button', $attributes = [])` The `$type` parameter coincides with the button’s `type` attribute.
* `allowUploads()` Sets the appropriate `enctype` of the form.
* `render()` Returns the processed Blade view object.

## Field Methods

* `__construct($name, $label, $attributes = [])`
* `addRules($rule)` Add one or more Laravel validation rules. You can add one, or an array of many.
* `options(array $options)` For fields of types Select, Radio, and Checkbox, you will need to add available options. That can be done via this method. The array should be composed of options in this format: `[‘label’ => ‘The Option Label’, ‘value’ => ‘the_option_label’]`. For Select fields, you may also define optgroups by nesting options inside of a `options` key: [‘label’ => ‘My Option Group’, ‘options’ => [/*…*/]]
* You can also programmatically set attributes to the input field like so: `$field->attribute(‘value’)`

## Available Field Types

* `Formery\FieldTypes\Checkbox`
* `Formery\FieldTypes\Email`
* `Formery\FieldTypes\Number`
* `Formery\FieldTypes\Password`
* `Formery\FieldTypes\Radio`
* `Formery\FieldTypes\Select`
* `Formery\FieldTypes\Text`
* `Formery\FieldTypes\Url`

## Custom Field Types

[Coming Soon]

## Customizing the HTML

[Coming Soon]