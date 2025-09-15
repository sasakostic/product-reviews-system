<script type="text/javascript" src="{{ url('assets/libs/noty/js/noty/packaged/jquery.noty.packaged.js') }}"></script>
    
<script type="text/javascript">

    function notify(type, text) {
        var n = noty({
            text        : text,
            type        : type,
            dismissQueue: true,
            layout      : 'topCenter',
            theme       : 'bootstrapTheme',
            closeWith   : ['button', 'click'],
            maxVisible  : 20,
            modal       : false
        });        
    }

</script>

@if (count($errors->all()) > 0)

<script type="text/javascript">
    $(document).ready(function () {
        notify('error', 'Please check the form below for errors');
    });
</script>

@endif
@if ($message = Session::get('success'))
@if(is_array($message))
@foreach ($message as $m)
<script type="text/javascript">
    $(document).ready(function () {
        notify('success', '{{ $m }}');
    });
</script>
@endforeach
@else
<script type="text/javascript">
    $(document).ready(function () {
        notify('success', '{{ $message }}');
    });
</script>
@endif
@endif
@if ($message = Session::get('error'))
@if(is_array($message))
@foreach ($message as $m)
<script type="text/javascript">
    $(document).ready(function () {
        notify('error', '{{ $m }}');
    });
</script>
@endforeach
@else
<script type="text/javascript">
    $(document).ready(function () {
        notify('error', '{{ $message }}');
    });
</script>
@endif
@endif
@if ($message = Session::get('warning'))
@if(is_array($message))
@foreach ($message as $m)
<script type="text/javascript">
    $(document).ready(function () {
        notify('warning', '{{ $m }}');
    });
</script>
@endforeach
@else
<script type="text/javascript">
    $(document).ready(function () {
        notify('warning', '{{ $message }}');
    });
</script>
@endif
@endif
@if ($message = Session::get('info'))
@if(is_array($message))
@foreach ($message as $m)
<script type="text/javascript">
    $(document).ready(function () {
        notify('info', '{{ $m }}');
    });
</script>
@endforeach
@else
<script type="text/javascript">
    $(document).ready(function () {
        notify('info', '{{ $message }}');
    });
</script>
@endif
@endif