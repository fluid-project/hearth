<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Hearth') }}</title>
<meta name="description" content="Hearth is a simple starter kit for the Laravel framework.">
<meta name="theme-color" content="#fff" media="(prefers-color-scheme: light)">
<meta name="theme-color" content="#000" media="(prefers-color-scheme: dark)">

<!-- Manifest -->
<link rel="manifest" href="/manifest.webmanifest">

<!-- Icons -->
<link rel="icon" href="/favicon.ico">
<link rel="icon" href="/icon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<!-- Styles -->
<link href="{{ mix('css/app.css') }}" rel="stylesheet" />
@googlefonts

<!-- Scripts -->
<script>document.documentElement.className = document.documentElement.className.replace("no-js", "js");</script>
<script src="{{ mix('js/manifest.js') }}" defer></script>
<script src="{{ mix('js/vendor.js') }}" defer></script>
<script src="{{ mix('js/app.js') }}" defer></script>
