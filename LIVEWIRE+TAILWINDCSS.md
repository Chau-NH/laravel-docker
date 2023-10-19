# Livewire + Tailwind CSS

## Set up Tailwind CSS
Reference: https://tailwindcss.com/docs/guides/laravel

### Requisite
- NodeJS Installed

### Install Tailwind CSS dependencies
```sh
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

### Configure your template paths
Add the paths to all of your template files in your `tailwind.config.js` file.

```js
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
```

### Add the Tailwind directives to your CSS
Add the @tailwind directives for each of Tailwind’s layers to your `./resources/css/app.css` file.
```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

### Using Tailwind in your project
Make sure your compiled CSS is included in the `<head>` then start using Tailwind’s utility classes to style your content.
```php
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
```

## Set up Livewire
Reference: https://livewire.laravel.com/docs/installation

### Requisite
- Composer Installed

### Install Livewire
```sh
composer require livewire/livewire
```

### Publishing the configuration file (optional)
```sh
php artisan livewire:publish --config
```

### Using Livewire's frontend assets
```html
<html>
<head>
    ...
    @livewireStyles
</head>
<body>
    ...
    @livewireScripts
</body>
</html>
```