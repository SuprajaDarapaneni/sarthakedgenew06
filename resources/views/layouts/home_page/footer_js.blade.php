<!-- Jquery-js-Link -->
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<!-- owl-js-Link -->
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<!-- bootstrap-js-Link -->
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<!-- aos-js-Link -->
<script src="{{ asset('assets/js/aos.js') }}"></script>
<script src="{{ asset('assets/js/image.js') }}"></script>
<!-- main-js-Link -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<script src="{{ asset('/assets/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
<script>


</script>
<script type='text/javascript'>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            $.toast({
                text: '{{ $error }}',
                showHideTransition: 'slide',
                icon: 'error',
                loaderBg: '#f2a654',
                position: 'top-right'
            });
        @endforeach
    @endif

    @if (Session::has('success'))
        $.toast({
            text: '{{ Session::get('success') }}',
            showHideTransition: 'slide',
            icon: 'success',
            loaderBg: '#f96868',
            position: 'top-right'
        });
    @endif

    @if (Session::has('error'))
        $.toast({
            text: '{{ Session::get('error') }}',
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#f2a654',
            position: 'top-right'
        });
    @endif
</script>
<script>
    var baseUrl = "{{ URL::to('/') }}";
    const onErrorImage = (e) => {
        e.target.src = "{{ asset('/assets/no_image_available.jpg') }}";
    };
</script>