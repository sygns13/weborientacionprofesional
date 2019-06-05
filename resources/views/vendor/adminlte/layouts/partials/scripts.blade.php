<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>

{{--<script src="{{ asset('js/select2-vue2.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.min.js')}}" type="text/javascript"></script>


<script src="{{ asset('js/jquery.dataTables.min.js')}}"  type="text/javascript"></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>>--}}

<script src="{{ asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.prettyPhoto.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.dataTables.min.js')}}"  type="text/javascript"></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/sweetalert2.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/alertify.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.PrintArea.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/fileinput.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/locales/es.js')}}" type="text/javascript"></script>
<script src="{{ asset('iCheck/icheck.min.js')}}" type="text/javascript"></script>
<script src="{{asset('Ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('js/bootstrap-colorpicker.js')}}"  type="text/javascript"></script>
<script src="{{ asset('js/axios.js')}}"  type="text/javascript"></script>


<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>
