<script type="x/templates" id="section-{{ $section_index }}-template">

    <div class="row-mt">
        <div class="col-xs-10 col-xs-offset-1 text-center">
    		<h5>@{{section.label}}</h5>
    		<p>
    		    @{{{section.description}}}
    		</p>
            @yield('page_section-content')
        </div>

       <div class="col-xs-12 ">
            <div class="divisor" ></div>
        </div>
    </div>

</script>
