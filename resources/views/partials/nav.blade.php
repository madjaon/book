<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            {{-- Collapsed Hamburger --}}
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">{!! trans('titles.toggleNav') !!}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            {{-- Branding Image --}}
            <a class="navbar-brand" href="{{ url('/') }}">
                {!! config('app.name', Lang::get('titles.app')) !!}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            {{-- Left Side Of Navbar --}}
            <ul class="nav navbar-nav">
                @role('admin')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Admin <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li {{ Request::is('users', 'users/' . Auth::user()->id, 'users/' . Auth::user()->id . '/edit') ? 'class=active' : null }}>{!! HTML::link(url('/users'), Lang::get('titles.adminUserList')) !!}</li>
                            <li {{ Request::is('users/create') ? 'class=active' : null }}>{!! HTML::link(url('/users/create'), Lang::get('titles.adminNewUser')) !!}</li>
                            <li {{ Request::is('themes','themes/create') ? 'class=active' : null }}>{!! HTML::link(url('/themes'), Lang::get('titles.adminThemesList')) !!}</li>
                            <li {{ Request::is('logs') ? 'class=active' : null }}>{!! HTML::link(url('/logs'), Lang::get('titles.adminLogs')) !!}</li>
                            <li {{ Request::is('php') ? 'class=active' : null }}>{!! HTML::link(url('/php'), Lang::get('titles.adminPHP')) !!}</li>
                            <li {{ Request::is('routes') ? 'class=active' : null }}>{!! HTML::link(url('/routes'), Lang::get('titles.adminRoutes')) !!}</li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Posts <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li {{ Request::is('posts') ? 'class=active' : null }}>{!! HTML::link(url('/posts'), 'Posts Management') !!}</li>
                            <li {{ Request::is('posts/create') ? 'class=active' : null }}>{!! HTML::link(url('/posts/create'), 'Create New Post') !!}</li>
                            <li {{ Request::is('posttypes','posttypes/create') ? 'class=active' : null }}>{!! HTML::link(url('/posttypes'), 'Post Types Management') !!}</li>
                            <li {{ Request::is('posttags','posttags/create') ? 'class=active' : null }}>{!! HTML::link(url('/posttags'), 'Post Tags Management') !!}</li>
                            <li {{ Request::is('postseries','postseries/create') ? 'class=active' : null }}>{!! HTML::link(url('/postseries'), 'Post Series Management') !!}</li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Others <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li {{ Request::is('ads') ? 'class=active' : null }}>{!! HTML::link(url('/ads'), 'Ads Management') !!}</li>
                            <li {{ Request::is('configs') ? 'class=active' : null }}>{!! HTML::link(url('/configs/1/edit'), 'Configuration') !!}</li>
                            <li>{!! HTML::link(url('/uploadimages'), 'Multi Upload Images') !!}</li>
                            <li>{!! HTML::link(url('/clearallstorage'), 'Clear Cache') !!}</li>
                            <li>{!! HTML::link(url('/gensitemap'), 'Gen Sitemap.xml') !!}</li>
                            <li>{!! HTML::link(url('/sitemap.xml'), 'Open Sitemap.xml', array('target' => '_blank')) !!}</li>
                        </ul>
                    </li>
                @endrole
            </ul>

            {{-- Right Side Of Navbar --}}
            <ul class="nav navbar-nav navbar-right">
                {{-- Authentication Links --}}
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">{!! trans('titles.login') !!}</a></li>
                    <li><a href="{{ route('register') }}">{!! trans('titles.register') !!}</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">

                            @if ((Auth::User()->profile) && Auth::user()->profile->avatar_status == 1)
                                <img src="{{ Auth::user()->profile->avatar }}" alt="{{ Auth::user()->name }}" class="user-avatar-nav">
                            @else
                                <div class="user-avatar-nav"></div>
                            @endif

                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li {{ Request::is('profile/'.Auth::user()->name, 'profile/'.Auth::user()->name . '/edit') ? 'class=active' : null }}>
                                {!! HTML::link(url('/profile/'.Auth::user()->name), trans('titles.profile')) !!}
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    {!! trans('titles.logout') !!}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
