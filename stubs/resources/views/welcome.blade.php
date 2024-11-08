<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=comic-neue:400,400i,700,700i&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <header>
            <div class="wrapper">
                <h1>Hearth</h1>
            </div>
        </header>

        <main>
            <div class="wrapper flow">
                <x-hearth-alert type="success" :title="__('Alert')">
                    <p>{{ __('Here is an alert!') }}</p>
                </x-hearth-alert>
                <x-hearth-label for="flavours" :value="__('Flavours')" />
                <x-hearth-checkboxes name="flavours" :options="[
                    [
                        'value' => 'vanilla',
                        'label' => 'Vanilla',
                    ],
                    [
                        'value' => 'chocolate',
                        'label' => 'Chocolate',
                    ],
                ]" x-model="flavours" />
                <x-hearth-date-input name="birthday" :label="__('Birthday')" />
            </div>
        </main>

        <footer>
            <div class="wrapper">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} &middot; PHP v{{ PHP_VERSION }}
            </div>
        </footer>
    </body>
</html>
