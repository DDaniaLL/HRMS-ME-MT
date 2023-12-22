
@include('layouts.navbars.navs.guest')
<div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black"
        style="background-image: url('{{ asset('material') }}/img/NRC.jpg'); background-size: 100% 100%; ; background-position:center;"
        data-color="orange">
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
        @yield('content')
    </div>
</div>

