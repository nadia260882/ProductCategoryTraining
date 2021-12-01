@if(isset(Auth::user()->email))
    <div class="wrapper text-center">
        <strong>Welcome {{ Auth::user()->name }}</strong>
        <br />
        <a href="{{ route ('logout') }}">Logout</a>
    </div>
@else
    <script>window.location = "{{ url('/') }}";</script>
@endif



