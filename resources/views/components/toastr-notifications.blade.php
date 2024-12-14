@if (session('success'))
<script type="text/javascript">
    toastr.success('{{ session("success") }}');
</script>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
    <script type="text/javascript">
        toastr.error('{{ $error }}');
    </script>
    @endforeach
@endif
