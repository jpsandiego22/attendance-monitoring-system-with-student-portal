@extends('layouts.master')

@section('title', 'Home')


@section('content')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            @include('partials.message')
        </div>
        <div class="col-md-2"></div>
    </div>
    <form method="POST" action="{{ route('user.create') }}">
        @csrf
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <label>USER TYPE</label>
                <div class="form-group">
                    <select id="user_type" name="user_type" class="form-control select2">
                        <option label="Select User Type"></option>
                        @foreach($user_types as $type)
                            <option value="{{ $type->type }}">{{ $type->description }}</option>
                        @endforeach
                </select>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="form-group">
                <label>IDENTIFICATION <span class="text-danger">*</span></label>
                <input type="text" name="identification" id="identification" class="form-control" placeholder="Identification" required>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="form-group">
                <label>NAME <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                </div>
            
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <div class="form-group">
                <label class="">YEAR <span class="text-danger year-section-label"></span></label>
                <input type="text" name="year" id="year" class="form-control" placeholder="Year">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                <label>SECTION <span class="text-danger year-section-label"></span></label>
                <input type="text" name="section" id="section" class="form-control" placeholder="Section">
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="form-group">
                    <button  class="btn btn-indigo btn-rounded btn-block">REGISTER</button>
                </div>
            </div>
             <div class="col-md-2"></div>
        
        </div>
    </form>
@endsection
@section('css')
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('js')
    <script>
       
    </script>
  <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
  <script>
    
    // Additional code for adding placeholder in search box of select2
    (function($) {
        var Defaults = $.fn.select2.amd.require('select2/defaults');
        $.extend(Defaults.defaults, {
            searchInputPlaceholder: ''
        });
        var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');
        var _renderSearchDropdown = SearchDropdown.prototype.render;
        SearchDropdown.prototype.render = function(decorated) {
            // invoke parent method
            var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));
            this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));
            return $rendered;
        };
    })(window.jQuery);
   
        $(document).ready(function(){
            $('.select2').select2({
                placeholder: 'Select Type',
                searchInputPlaceholder: 'Search'
            });
            const sectionInput = document.getElementById('section');
            const yearInput = document.getElementById('year');
            $('#user_type').on('change', function() {
                const value = $(this).val();
                const sectionLabels = document.querySelectorAll('.year-section-label');
                
                if(value == '2') {
                    sectionInput.required = true;
                    yearInput.required = true;
                    sectionLabels.forEach(label => label.innerHTML = '*');
                } else {
                    sectionInput.required = false;
                    yearInput.required = false;
                    sectionLabels.forEach(label => label.innerHTML = '');
                }
            });
           
        });
       
  
    </script>
    
@endsection
