@php
$user = Auth::user();
@endphp

@if($user->isAdmin())

    @include('layouts.partials.sidebar.admin')

@elseif($user->isGuruMapel())

    @include('layouts.partials.sidebar.guru')

@elseif($user->isBK())

    @include('layouts.partials.sidebar.bk')



@elseif($user->isKepalaSekolah())

    @include('layouts.partials.sidebar.kepsek')

@endif
