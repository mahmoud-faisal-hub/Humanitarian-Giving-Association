<!-- main-header opened -->
			<div class="main-header sticky side-header nav nav-item">
				<div class="container-fluid">
					<div class="main-header-left ">
						<div class="responsive-logo">
							<a href="{{ route('home') }}"><img src="{{URL::asset('images/logo.png')}}" class="logo-1" alt="logo"></a>
							<a href="{{ route('home') }}"><img src="{{URL::asset('images/logo.png')}}" class="dark-logo-1" alt="logo"></a>
							<a href="{{ route('home') }}"><img src="{{URL::asset('images/logo.png')}}" class="logo-2" alt="logo"></a>
							<a href="{{ route('home') }}"><img src="{{URL::asset('images/logo.png')}}" class="dark-logo-2" alt="logo"></a>
						</div>
						<div class="app-sidebar__toggle" data-toggle="sidebar">
							<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
							<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
						</div>
						<div class="main-header-center mr-3 d-sm-none d-md-none d-lg-block">
                            <form action="{{ route('admin.news.search') }}" method="GET">
                                <input class="form-control" placeholder="بحث عن أخبار" type="search" name="search">
                                <button class="btn" type="submit"><i class="fas fa-search d-none d-md-block"></i></button>
                            </form>
                        </div>
					</div>
					<div class="main-header-right">
						<div class="nav nav-item  navbar-nav-right ml-auto">
							{{-- <div class="nav-link" id="bs-example-navbar-collapse-1">
								<form class="navbar-form" action="{{ route('admin.news.search') }}" method="GET">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="بحث" name="search">
										<span class="input-group-btn">
											<button type="reset" class="btn btn-default">
												<i class="fas fa-times"></i>
											</button>
											<button type="submit" class="btn btn-default nav-link resp-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
											</button>
										</span>
									</div>
								</form>
							</div> --}}
                            @can('عرض الرسائل')
                                <div class="dropdown nav-item main-header-message ">
                                    <a class="new nav-link" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        @if ($unread_messages->count())
                                            <span class=" pulse-danger"></span>
                                        @endif
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="menu-header-content bg-primary text-right">
                                            <div class="d-flex">
                                                <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">الرسائل</h6>
                                            </div>
                                            @if ($unread_messages->count())
                                                <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">لديك {{ arabicNumbers($unread_messages->count()) }} رسائل غير مقروءة</p>
                                            @endif
                                        </div>
                                        <div class="main-message-list chat-scroll">
                                            @if ($unread_messages->isNotEmpty())
                                                @foreach ($unread_messages as $message)
                                                    <a href="{{ route('admin.message.show', $message->id) }}" class="p-3 d-flex border-bottom">
                                                        <div class="wd-90p">
                                                            <div class="d-flex">
                                                                <h5 class="mb-1 name">{{ $message->name }}</h5>
                                                            </div>
                                                            <p class="mb-0 desc">{{ getWord($message->message, 10) }}</p>
                                                            <p class="time mb-0 text-left float-right mr-2 mt-2">{{ arabicDate(arabicNumbers($message->created_at->format('D، j M Y ~ g:i a'))) }}</p>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            @else
                                                <div class="card text-center rounded-0 mb-0">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/img/svgicons/note_taking.svg') }}" alt="" class="wd-35p">
                                                        <h5 class="mg-b-10 mg-t-15 tx-18">لا يوجد رسائل غير مقروءة</h5>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-center dropdown-footer">
                                            <a href="{{ route('admin.message.index') }}">جميع الرسائل</a>
                                        </div>
                                    </div>
                                </div>
                            @endcan
							<div class="nav-item full-screen fullscreen-button">
								<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
							</div>
							<div class="dropdown main-profile-menu nav nav-item nav-link">
								<a class="profile-user d-flex" href="">
                                    @if (Auth::user()->info && Auth::user()->info->image)
                                        <img alt="{{ Auth::user()->name }}" src="{{ URL::asset('storage/images/admins' . '/' . Auth::user()->info->image) }}">
                                    @else
                                        <img alt="{{ Auth::user()->name }}" src="{{URL::asset('images/user.png')}}">
                                    @endif
                                </a>
								<div class="dropdown-menu">
									<div class="main-header-profile bg-primary p-3">
										<div class="d-flex wd-100p">
											<div class="main-img-user">
                                                @if (Auth::user()->info && Auth::user()->info->image)
                                                    <img alt="{{ Auth::user()->name }}" src="{{ URL::asset('storage/images/admins' . '/' . Auth::user()->info->image) }}">
                                                @else
                                                    <img alt="{{ Auth::user()->name }}" src="{{URL::asset('images/user.png')}}">
                                                @endif
                                            </div>
											<div class="mr-3 my-auto">
												<h6>{{ getWord(Auth::user()->name, 2, '') }}</h6><span>{{ Auth::user()->email }}</span>
											</div>
										</div>
									</div>
									<a class="dropdown-item" href="{{ route('admin.show', Auth::id()) }}"><i class="bx bx-user-circle"></i>الصفحة الشخصية</a>
									{{-- <a class="dropdown-item" href=""><i class="bx bx-cog"></i> Edit Profile</a>
									<a class="dropdown-item" href=""><i class="bx bxs-inbox"></i>Inbox</a>
									<a class="dropdown-item" href=""><i class="bx bx-envelope"></i>Messages</a>
									<a class="dropdown-item" href=""><i class="bx bx-slider-alt"></i> Account Settings</a> --}}
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        <i class="bx bx-log-out"></i> تسجيل الخروج
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
								</div>
							</div>
							{{-- <div class="dropdown main-header-message right-toggle">
								<a class="nav-link pr-0" data-toggle="sidebar-left" data-target=".sidebar-left">
									<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
								</a>
							</div> --}}
						</div>
					</div>
				</div>
			</div>
<!-- /main-header -->
