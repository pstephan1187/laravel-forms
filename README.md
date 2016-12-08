Formery is a package for programmatically creating and validating forms in Laravel. It comes preconfigured to use Twitter Bootstrap, but can easily be customized to use whatever you want.

Currently, Formery has only been tested in Laravel 5.3. There is no minimum requirement for Laravel set in the composer file yet because it may very well work in earlier versions. I just haven’t tested them yet. It, however, must be used in blade templates. It does not support plain PHP templates or Twig yet.

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

Creating the form:

```
use Formery\FormBuilder;

// In your controller constructor, new up a form and set the action:
$this->form = new FormBuilder('/');

// You may also override the default 'POST' method
$this->form = new FormBuilder('/', 'GET');

// Create a text field with a name of "name" and label of "Name". Also make it required.
$this->form->addField('name', 'Name', \Formery\FieldTypes\Text::class)->addRules('required');

// Create an email field. Make sure the email is unique
$this->form->addField('email', 'Email', \Formery\FieldTypes\Email::class)->addRules(['required', 'unique:users,email_address']);

// Add a password field. Make sure it matches its confirmation field.
$this->form->addField('password', 'Password', \Formery\FieldTypes\Password::class)->addRules(['required', 'confirmed']);

$this->form->addField('password_confirmation', 'Confirm Password', \Formery\FieldTypes\Password::class);

// Add the submit button. Align it to the right
$this->form->addButton('Login', 'submit', ['class' => 'pull-right']);
```

Pass the form to your view:

```
// In your controller route, pass the form to the view:
return view('form-view')->with(['form' => $this->form]);
```

Render the form in your blade template:

```
@form($form)
```

Validate the form when it is submitted:

```
// In your controller route:
$this->form->validate($request);
// Process your data here!
```

The `validate` method utilizes the same functionality as the one included in Laravel. It will automatically redirect back to the form with the errors and old input.

## The FormBuilder

### The Constructor

When you new up a form, the first parameter is required. This sets the target path that the form will submit to. The second parameter sets the submission method and defaults to `POST`. 

```
$form = new FormBuilder(‘/create-user’);
$form = new FormBuilder(route(‘user.create’), ‘PUT’);
```

### Cross Site Request Forgery Protection

Formery utilizes Laravel’s CSRF protection by default. You can disable it if needed:

```
$form->useCsrf(false);
```

### Automatic Placeholders

You can tell the form to automatically generate placeholders for all applicable input fields. The placeholder text will be set to the field’s label.

```
$form->usePlaceholders();
```

### Using Old Input

Formery will automatically capture old input and push it into the form fields whenever validation doesn’t pass. You can turn this off if you wish.

```
$form->captureOldInput(false);
```

### Adding Fields

You must set the name, label, and type of the field when you create it. You can optionally set any attributes that you want set on the input element as well:

```
$first_name_field = $form->addField('first_name', 'First Name', \Formery\FieldTypes\Text::class);
$last_name_field = $form->addField('last_name', 'Last Name', \Formery\FieldTypes\Text::class, ['title' => 'Last Name']);

$email_field = new \Formery\FieldTypes\Email('email', 'Email');
$form->getFields->push($email_field);
```

There is more information of Fields below.

### Buttons

Buttons are placed at the bottom of form by default. You can override this by customizing the form view if you’d like. Buttons are added similarly to fields, but you do not need to specify a type. The first parameter is the label and the second parameter is the button type. Button type defaults to `button`.

```
$form->addButton('Register', 'submit', ['class' => 'pull-right']);
```

### Uploads

You can set the appropriate form `enctype` for uploads by calling the `allowUploads` method.

```
$form->allowUploads();
```

### Rendering the form

Formery registers  a blade directive for registering the form.

```
@form($form)
```

You can also render the form manually. Calling the `render` method will return the form’s view object.

```
$form->render();
```

## The Fields

### Creating Fields

New fields can be added 2 ways. You can add them via the `FormBuilder` `addField` method, or you can manually create a field and add it to the form.

```
$name_field = $form->addField('name', 'Name', \Formery\FieldTypes\Text::class);

$email_field = new \Formery\FieldTypes\Email('email', 'Email');
$form->getFields->push($email_field);
```

The `addField` method will return the field so that you can chain field methods on to it.

```
$form->addField('name', 'Name', \Formery\FieldTypes\Text::class)->addRule('required');
```

### Validation Rules

Validation is handled by Laravel but Formery sets up some sensible defaults and ways to add rules to your fields. Many Fields are created with default rules in place. An example would be the `Email` field; it requires that its input be a valid email address.

You can also add rules. The `addRule` method will chain on any given string onto the field’s rules. For example:

```
$email_field->addRule('required');
```

will append `|required` on the field’s current ruleset, giving us `email|required` as the final result.

You can also give an array of rules to add as well.

```
$email_field->addRule(['required', 'unique:users,email_address']);
```

### Attributes

You can add attributes to your fields as well. Any attributes will be placed on the input element. There are a number of ways to add attributes. Firstly, you can add them when creating the field:

```
$form->addField('name', 'Name', \Formery\FieldTypes\Text::class, ['disabled' => true]);

new \Formery\FieldTypes\Email('email', 'Email', ['placeholder' => 'email@example.com']);
```

You can also add attributes the `__call` magic method. The method name will be the attribute and the value of the method will be the value of the attribute. Calling a method without a value will set the attribute as a flag.

```
$field->class('my-class');
$field->disabled();
```

The methods are chainable as well.

```
$field->class('my-class')->disabled();
```

### Options

Some field types (select, checkbox, radio) require a set of options. You can use the `options` method for that. Options should be defined as an array of arrays. Each option array will need a `label` key. You should also define a `value` key. If no value key is defined, the value for that option will be `null`. You may also define a `disabled` key. If you set that key to `true` then that option will be disabled.

```
$checkbox_field->options([
	['label' => 'Extra Small', 'value' => 'xs'],
	['label' => 'Small', 'value' => 'sm'],
	['label' => 'Medium', 'value' => 'md'],
	['label' => 'Large', 'value' => 'lg'],
	['label' => 'Extra Large', 'value' => 'xl'],
]);
```

Select fields also support “optgroups”. Those are defined very similarly to options, but instead of a value, they require a `options` key. The `options` key will contain an array of options.

```
$select_field->options([
	['label' => 'United States', 'value' => 'us'],
	['label' => 'US States', 'options' => [
		['label' => 'Alabama', 'value' => 'al'],
		['label' => 'Missouri', 'value' => 'mo'],
		['label' => 'Washington', 'value' => 'wa'],
	]],
	['label' => 'Great Britain', 'value' => 'gb'],
	['label' => 'Australia', 'value' => 'au'],
	['label' => 'Spain', 'value' => 'sp'],
]);
```

### Default Values

For normal fields, you can assign a value by using the `value` method.

```
$field->value('Default Value');
```

For checkboxes, radios, and multi-select boxes, you can assign an array.

```
$field->value(['option_one', 'option_two']);
```

For select boxes, you can also assign a default select option.

```
$select_field->default('Selection an option');
```

This will set a disabled option as the first and selected option (unless the select box has a value) with the given label. You can also pass it a value as the second parameter.

```
$select_field->default('Selection an option', 'nothing');
```

### Available Field Types

The following field types are available with Formery. You can, of course, create your own as well.

* `Formery\FieldTypes\Checkbox`
* `Formery\FieldTypes\Email`
* `Formery\FieldTypes\Number`
* `Formery\FieldTypes\Password`
* `Formery\FieldTypes\Radio`
* `Formery\FieldTypes\Select`
* `Formery\FieldTypes\Text`
* `Formery\FieldTypes\Url`

### Overriding the view file

If you would like to use a custom view for an individual field, you may use the `setViewFile` method.

```
$field->setViewFile('my-custom-blade-file');
```

If you would like to customize the views for all fields of a type, you can publish the views to your `resources/views/vendor/form/` directory (see above in installation) and customize the field type template.

## Custom Field Types

You can create custom field types as well. Examples would be a date picker, a color picker, a file browser, etc. To do so, create a class that extends the `Formery\Field` class.

At the very least, you must define a `protected $view_file` property. When the field is rendered, it will process that view will passing itself to the view as a `$field` variable.

You can also define default rules in the `protected $rules` property and default attributes in the `protected $attributes` property.

You can then set or override any custom methods as well.