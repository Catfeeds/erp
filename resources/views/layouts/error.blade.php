@if (session('status'))
    <script type="text/javascript">
        layer.open({
            title: '提示：'
            ,content: '{{ session('status') }}'
        });
    </script>

@endif