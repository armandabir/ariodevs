  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard')}}" class="brand-link">

      <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
      <div style="direction: rtl">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset('dashboard/img/Sample_User_Icon.jpg')}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><span>{{Auth::user()->firstName}}</span> <span>{{Auth::user()->lastName}}</span></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <!-- <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>
                  داشبوردها
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="./index.html" class="nav-link active">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>داشبورد اول</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index2.html" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>داشبورد دوم</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index3.html" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>داشبورد سوم</p>
                  </a>
                </li>
              </ul>
            </li> -->
            @canany(['admins','superadmin'])
            <li class="nav-item has-treeview">
              <a href="" class="nav-link">
                <i class="nav-icon fa fa-edit"></i>
                <p>
                  مقالات
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('article.cats')}}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>افزودن دسته</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('blog.create')}}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>افرودن مقاله</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('articles')}}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>مقالات من</p>
                  </a>
                </li>
                
              </ul>
            </li>
            @endcanany
            @canany(['admins','superadmin'])
            
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-book"></i>
                <p>
                  محصولات
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('product.cats')}}" class="nav-link">
                      <i class="fa fa-circle-o nav-icon"></i>
                      <p>افزودن دسته</p>
                    </a>
                  </li>
     
                <li class="nav-item">
                  <a href="{{route('product.create')}}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>افرودن محصول</p>
                  </a>
                </li>

                  <li class="nav-item">
                  <a href="{{route('product.edit')}}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>محصولات من</p>
                  </a>
                </li>

                
               @endcanany
              </ul>
            </li>
            @canany(['admins','superadmin'])
            
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-book"></i>
                <p>
                  تگها
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('tags')}}" class="nav-link">
                      <i class="fa fa-circle-o nav-icon"></i>
                      <p>افزودن تگ</p>
                    </a>
                </li>
             
               @endcanany
              </ul>
            </li>

            @canany(['admins','superadmin'])
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-user"></i>
                <p>
                  کاربران
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('admin.userCreate')}}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>ایجاد کاربر</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('admin.users')}}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>کاربران من</p>
                  </a>
                </li>
              </ul>
            </li>
            @endcanany
            <li class="nav-item has-treeview">
              <a href="" class="nav-link">
                <i class="nav-icon fa fa-envelope-o"></i>
                <p>
                 سفارشات
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('orders')}}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>سفارشات من</p>
                  </a>
                </li>
              </ul>
            </li>
            @canany(['admins','superadmin'])
           <!-- <li class="nav-header">صفحه اصلی</li> -->
            <!-- <li class="nav-item">
              <a href="pages/calendar.html" class="nav-link">
                <i class="nav-icon fa fa-calendar"></i>
                <p>
                  تقویم
                  <span class="badge badge-info right">2</span>
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-envelope-o"></i>
                <p>
                  ایمیل‌ باکس
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages/mailbox/mailbox.html" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>اینباکس</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/mailbox/compose.html" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>ایجاد</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/mailbox/read-mail.html" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>خواندن</p>
                  </a>
                </li>
              </ul>
            </li> -->
    
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-file"></i>
                <p>
                  صفحات
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                 <li class="nav-item">
                  <a href="pages/examples/invoice.html" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>صفحه اصلی

                      <i class="fa fa-angle-left right"></i>
                    </p>
                    
                  </a>
                  <ul class="nav nav-treeview">
                     <li class="nav-item">
                        <a href="{{route('admin.home',[1,1])}}" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>اسلایدر</p>
                        </a>
                      </li>

                       <li class="nav-item">
                        <a href="{{route('admin.home',[1,2])}}" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>ارائه خدمات مهندسی</p>
                        </a>
                      </li>
                  </ul>


                </li>
                <li class="nav-item">
                  <a href="{{route('admin.home',[2,0])}}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>خدمات ما</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/profile.html" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>نمایندگی فروش 
                        <i class="fa fa-angle-left right"></i>
                    </p>
                  </a>

                  <ul class="nav nav-treeview">
                        <li class="nav-item">
                        <a href="{{route('admin.home',[1,3])}}" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>افزودن</p>
                        </a>
                      </li>

                       <li class="nav-item">
                        <a href="{{route('admin.pages.show',[1,3])}}" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>نمایدگی های من</p>
                        </a>
                      </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/login.html" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p> محاسبات 
                      
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/register.html" class="nav-link">
                     <i class="fa fa-circle-o nav-icon"></i>
                    <p> تماس باما 
                        <i class="fa fa-angle-left right"></i>
                    </p>
                  
                  </a>

                   <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="{{route('admin.home',[3,1])}}" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>آشنایی</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{route('admin.home',[3,2])}}" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>ویژگی ها</p>
                        </a>
                      </li>

                       <li class="nav-item">
                        <a href="{{route('admin.home',[3,3])}}" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>اهداف وماموریت</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="{{route('admin.home',[3,4])}}" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>اهداف</p>
                        </a>
                      </li>
                  </ul>


                </li>
                <li class="nav-item">
                  <a href="pages/examples/profile.html" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>پروژه ها 
                        <i class="fa fa-angle-left right"></i>
                    </p>
                  </a>

                  <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="{{route('project.cats')}}" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>دسته افزودن</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{route('project.create')}}" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>پروژه افزودن</p>
                        </a>
                      </li>

                       <li class="nav-item">
                        <a href="{{route('project.list')}}" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>پروژه های من</p>
                        </a>
                      </li>
                  </ul>
                </li>
              </ul>
            </li>
            @endcanany
            <a class="dropdown-item" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                      {{ __('خروج') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
            <!-- <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-plus-square-o"></i>
                <p>
                  بیشتر
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages/examples/404.html" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>ارور 404</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/500.html" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>ارور 500</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/blank.html" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>صفحه خالی</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="starter.html" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>صفحه شروع</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-header">متفاوت</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-file"></i>
                <p>مستندات</p>
              </a>
            </li>
            <li class="nav-header">برچسب‌ها</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-circle-o text-danger"></i>
                <p class="text">مهم</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-circle-o text-warning"></i>
                <p>هشدار</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-circle-o text-info"></i>
                <p>اطلاعات</p>
              </a>
            </li> -->
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
    </div>
    <!-- /.sidebar -->
  </aside>