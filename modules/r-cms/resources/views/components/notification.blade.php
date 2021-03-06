@foreach (['success', 'error', 'info'] as $message)
@if(Session::has($message))
<script>
    $(document).ready(function() {
        toastr.{{$message}}('{{ Session::get($message) }}')
    });
</script>
@endif
@endforeach

@if ($errors->any())
<script>
    $(document).ready(function() {
        toastr.error('{{ $errors->first() }}')
    });
</script>
@endif