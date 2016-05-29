@extends('layouts.layout')
<!-- will have condition if the user is login if not show the login page -->
@section('content')
    <!-- Start Header Section -->
    <header id="header-wrap" class="site-header clearfix">
<!-- Start Top Bar -->
        <div class="top-bar hidden-xs">
          <div class="container">
            <div class="row">
              <div class="col-md-7 col-sm-9">
               
                <!-- End Contact Info -->
              </div>
              <div class="col-md-5 col-sm-3">
                <!-- Start Social Links -->
                {!! Form::open(['url' => 'login', 'data-parsley-validate', 'data-parsley-ui-enabled' => 'false', 'data-parsley-focus' => 'none']) !!}
                <ul class="social-list">
		     <li> 
                         {!! Form::text('email','',
                               ['id'                            =>'email',
                                'placeholder'                   => 'Please Enter your Email',
                                'required'                      => 'required',
               	                'data-parsley-required-message' => 'Email is required',
	                        'data-parsley-trigger'          => 'change',
	                        'data-parsley-class-handler'    => '#email-group'
                                ]) !!}
                               
		     </li>
		     <li>&nbsp; </li>
		     <li>&nbsp; </li>
		     <li>&nbsp; </li>
		     <li>&nbsp; </li>
                    <li>
                      {!! Form::password('password',
                             ['placeholder'                   => 'Please Enter your Password',
                              'required'                      => 'required',
               	              'data-parsley-required-message' => 'Password is required',
	                      'data-parsley-trigger'          => 'change',
                              'data-parsley-minlength'        => '6',
                              'data-parsley-class-handler'    => '#password-group'
                      ]) !!}
                    </li>
                     <li>
                        <div class="col-md-4 col-sm-4">
                         {!! Form::submit('Sign In', array('class' => 'btn btn-border btn-login')) !!}
             	         </div>
                     </li>
                </ul>
                <div class="col-md-7 col-sm-9"> </div>
                <div class="col-md-5 col-sm-3"> 
                    <ul class="social-list">
                        @foreach ($errors->all() as $error)
                             <li>{{ $error }}</li>
                        @endforeach
   		        <li>&nbsp; </li>
		        <li>&nbsp; </li>
		        <li>&nbsp; </li>
		        <li>&nbsp; </li>
                        <li>
                           {!! $errors->first('password') !!}
                        </li>
                    </ul>
                </div>
                {!! Form::close() !!}
                <!-- End Social Links -->
              </div>
            </div>
          </div>
        </div>
        <!-- End Top Bar -->
 </header>
@endsection
@push('page_plugins')
    <!-- Validation -->
     <script type="text/javascript" src="{{ asset('iknowwelding/js/parsley.min.js') }}"></script>
    <!--<script src="http://parsleyjs.org/dist/parsley.js"> </script>-->
    <!--<script src="//ajax.aspnetcdn.com/ajax/jQuery.validate/1.11.1/jquery.validate.js" type="text/javascript"></script>-->
    <script>
//      window.ParsleyConfig = {
//        errorsWrapper: '<div></div>',
//        errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
//        errorClass: 'has-error',
//        successClass: 'has-success'
//    };
// create external js for this
    $(function() {
        $('[data-toggle="popover"]').popover()
    });
//    $.listen('parsley:field:error', function (fieldInstance) {
//    arrErrorMsg = ParsleyUI.getErrorsMessages(fieldInstance);
//    errorMsg = arrErrorMsg.join(';');
//    console.log(fieldInstance.$element);
//    fieldInstance.$element
//        .popover('destroy')
//        .popover({
//            container: 'body',
//            placement: 'bottom',
//            content: errorMsg
//        })
//        .popover('show');
//
//    });
    window.Parsley.on('field:error', function(fieldInstance) {
    // This global callback will be called for any field that fails validation.
        arrErrorMsg = ParsleyUI.getErrorsMessages(fieldInstance);
        errorMsg = arrErrorMsg.join(';');
        console.log('Validation failed for: ', this.$element);
        fieldInstance.$element
        .popover('destroy')
        .popover({
            container: 'body',
            placement: 'bottom',
            content: errorMsg
        }).popover('show');
    });
    $.listen('parsley:field:success', function (fieldInstance) {
      fieldInstance.$element.popover('destroy');
    });
    
    </script>
 @endpush