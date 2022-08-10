<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
				<a class="desktop-logo logo-light active" href="{{ url('admin/' . $page='home') }}"><img src="{{URL::asset('images/logo.png')}}" class="main-logo" alt="logo"></a>
				<a class="desktop-logo logo-dark active" href="{{ url('admin/' . $page='home') }}"><img src="{{URL::asset('images/logo.png')}}" class="main-logo dark-theme" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-light active" href="{{ url('admin/' . $page='home') }}"><img src="{{URL::asset('images/logo.png')}}" class="logo-icon" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-dark active" href="{{ url('admin/' . $page='home') }}"><img src="{{URL::asset('images/logo.png')}}" class="logo-icon dark-theme" alt="logo"></a>
			</div>
			<div class="main-sidemenu">
				<div class="app-sidebar__user clearfix">
					<div class="dropdown user-pro-body">
						<div class="">
                            @if (Auth::user()->info && Auth::user()->info->image)
                                <img alt="{{ Auth::user()->name }}" class="avatar avatar-xl brround" src="{{ URL::asset('storage/images/admins' . '/' . Auth::user()->info->image) }}">
                            @else
                                <img alt="{{ Auth::user()->name }}" class="avatar avatar-xl brround" src="{{URL::asset('images/user.png')}}">
                            @endif
                            <span class="avatar-status profile-status bg-green"></span>
						</div>
						<div class="user-info">
							<h4 class="font-weight-semibold mt-3 mb-0">{{ getWord(Auth::user()->name, 2, '') }}</h4>
							<span class="mb-0 text-muted">{{ Auth::user()->email }}</span>
						</div>
					</div>
				</div>
				<ul class="side-menu">
					{{-- <li class="side-item side-item-category">جمعية العطاء الإنسانى</li> --}}
					<li class="slide">
						<a class="side-menu__item" href="{{ url('admin/' . $page='home') }}"><i class="fa-solid fa-house fa-lg"></i><span class="side-menu__label pe-3">الصفحة الرئيسية</span></a>
					</li>
                    @canany(['عرض الأخبار', 'إضافة خبر'])
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="{{ url('admin/' . $page='#') }}"><i class="fa-solid fa-newspaper fa-lg"></i><span class="side-menu__label pe-3">الأخبار</span><i class="angle fe fe-chevron-down"></i></a>
                            <ul class="slide-menu">
                                @can('عرض الأخبار')
                                    <li><a class="slide-item" href="{{ route('news.index') }}">قائمة الأخبار</a></li>
                                @endcan
                                @can('إضافة خبر')
                                    <li><a class="slide-item" href="{{ route('news.create') }}">إضافة خبر</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    @canany(['عرض الأقسام', 'إضافة قسم'])
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="{{ url('admin/' . $page='#') }}"><i class="fa-solid fa-layer-group fa-lg"></i><span class="side-menu__label pe-3">الأقسام</span><i class="angle fe fe-chevron-down"></i></a>
                            <ul class="slide-menu">
                                @can('عرض الأقسام')
                                    <li><a class="slide-item" href="{{ route('category.index') }}">قائمة الأقسام</a></li>
                                @endcan
                                @can('إضافة قسم')
                                    <li><a class="slide-item" href="{{ route('category.create') }}">إضافة قسم</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    @canany(['عرض المعرض', 'إضافة وسائط'])
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="{{ url('admin/' . $page='#') }}"><i class="fa-solid fa-photo-film fa-lg"></i><span class="side-menu__label pe-3"> المعرض</span><i class="angle fe fe-chevron-down"></i></a>
                            <ul class="slide-menu">
                                @can('عرض المعرض')
                                    <li><a class="slide-item" href="{{ route('galary.index') }}">قائمة الوسائط</a></li>
                                @endcan
                                @can('إضافة وسائط')
                                    <li><a class="slide-item" href="{{ route('galary.create') }}">إضافة وسائط</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    @can('عرض الرسائل')
                        <li class="slide">
                            <li class="slide">
                                <a class="side-menu__item" href="{{ route('admin.message.index') }}">
                                    @if ($unread_messages->count())
                                        <i class="fa-solid fa-envelope fa-lg"></i>
                                    @else
                                        <i class="fa-solid fa-envelope-circle-check fa-lg"></i>
                                    @endif
                                    <span class="side-menu__label pe-3">
                                        الرسائل
                                    </span>
                                    @if ($unread_messages->count())
                                        <span class="badge badge-success side-badge">{{ arabicNumbers($unread_messages->count()) }}</span>
                                    @endif
                                </a>
                            </li>
                        </li>
                    @endcan
                    @canany(['عرض الأعضاء', 'إضافة عضو'])
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="{{ url('admin/' . $page='#') }}"><i class="fa-solid fa-users fa-lg"></i><span class="side-menu__label pe-3"> الأعضاء</span><i class="angle fe fe-chevron-down"></i></a>
                            <ul class="slide-menu">
                                @can('عرض الأعضاء')
                                    <li><a class="slide-item" href="{{ route('admin.index') }}">قائمة الأعضاء</a></li>
                                @endcan
                                @can('إضافة عضو')
                                    <li><a class="slide-item" href="{{ route('admin.create') }}">إضافة عضو</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    @canany(['عرض الأدوار', 'إضافة دور'])
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="{{ url('admin/' . $page='#') }}"><i class="fa-solid fa-user-lock fa-lg"></i><span class="side-menu__label pe-3"> الأدوار</span><i class="angle fe fe-chevron-down"></i></a>
                            <ul class="slide-menu">
                                @can('عرض الأدوار')
                                    <li><a class="slide-item" href="{{ route('role.index') }}">قائمة الأدوار</a></li>
                                @endcan
                                @can('إضافة دور')
                                    <li><a class="slide-item" href="{{ route('role.create') }}">إضافة دور</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
				</ul>
			</div>
		</aside>
<!-- main-sidebar -->
