@include("components.header")

<!-- @yield("content") -->
 {{ $slot }}

@include("components.footer")

@yield("js_content")
</body>
</html>