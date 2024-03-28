@if ($errors->any())
    <div class="alert alert-danger col-md-6" id="removeAlert">
        <ul>
            @foreach ($errors->all() as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::get('success'))
    <div class="alert alert-success col-md-6" id="removeAlert">{{ Session::get('success') }}</div>
@endif

<script>
    setTimeout(function () {
        document.getElementById('removeAlert').remove();
    }, 2000);
</script>