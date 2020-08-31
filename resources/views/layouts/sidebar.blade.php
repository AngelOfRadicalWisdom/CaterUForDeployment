<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="{{url('/dashboard')}}"><i class="fa fa-home"></i> Home</a>
                  </li>
                  <li><a><i class="fa fa-file-text"></i> Manage Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('/menu/list?mode=list')}}">Menu List</a></li>
                      <li><a href="{{url('/menu/addmenu')}}">Add New Menu</a></li>
                      <li><a href="{{url('/admin/view_categories')}}">Category List</a></li>
                      <li><a href="{{url('/admin/add_category')}}">Add New Category</a></li>
                      <li><a href="{{url('/admin/view_subcategories')}}">SubCategory List</a></li>
                      <li><a href="{{url('/admin/add_subcategory')}}">Add new SubCategory</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-users"></i> Manage Employees<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('/employee/employeelist')}}">Employee List</a></li>
                      <li><a href="{{url('/employee/addemployee')}}">Add New Employee</a></li>
                      <li><a href="{{url('/generateQRCode')}}">Generate QR</a></li>
                    </ul>
                  </li>
                  <!-- <li><a><i class="fa fa-desktop"></i> Manage Company<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('/company/companylist')}}">Company List</a></li>
                      <li><a href="{{url('/company/addcompany')}}">Add New Company</a></li>
                    </ul>
                  </li> -->
                  <li><a><i class="fa fa-bar-chart"></i> Report<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('/sales')}}">Sales Report</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-table"></i> Tables <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                      <li><a href="{{ url('/table/tablelist')}}">Table List</a></li>
                      <li><a href="{{ url('/table/addtable')}}">Add New Table</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-random"></i>Recommendation<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/apriori/apriorisettings')}}">Recommendation Settings</a></li>
                      <li><a href="{{url('/generateapr')}}">Generate Recommendations</a></li>
                    </ul>
                  </li>
                  
                  <li><a><i class="fa fa-list-alt"></i>Promos<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('/promo/promolist')}}">Promo List</a></li>
                      <li><a href="{{url('/promo/addpromo')}}">Add New Promo</a></li>
                    </ul>
                  </li>
                  <li><a href="{{url('/ratings')}}"><i class="fa fa-star"></i> Ratings</a>
                  </li>
                </ul>
              </div>
              </div>
            <!-- /sidebar menu -->