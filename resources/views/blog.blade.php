<x-app-layout>
<body class="mb-5">

<div id="ui">
    <router-view></router-view>
</div>

<script>
    window.CanvasUI = @json($config);
</script>

<script type="text/javascript" src="{{ mix('js/canvas-ui.js') }}"></script>
</x-app-layout>