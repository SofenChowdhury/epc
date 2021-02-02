
<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href=""><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="" style="padding-left:15%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="150">
            </div>
        </div>

        <div class="pcoded-navigation-label">Navigation</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="pcoded-hasmenu dashboard active pcoded-trigger">
                <a href="{{url('/')}}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                    <span class="pcoded-mtext">Home</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            {{--            @canany(['Add/Edit Setup','View Setup'])--}}
            {{--			<li class="pcoded-hasmenu setup">--}}
            {{--				<a href="{{route('setup')}}" class="waves-effect waves-dark">--}}
            {{--					<span class="pcoded-micon"><i class="ti-info-alt"></i><b>D</b></span>--}}
            {{--					<span class="pcoded-mtext">Setup</span>--}}
            {{--					<span class="pcoded-mcaret"></span>--}}
            {{--				</a>--}}
            {{--			</li>--}}
            {{--            @endcanany--}}

            <li class="pcoded-hasmenu chart_of_accounts">
                @canany(['Chart of Accounts','view COA','Add Account COA','Add Transaction','Journal Entry','View Category List','Add/Edit Indent'])
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-layout"></i><b>P</b></span>
                        <span class="pcoded-mtext">Accounts</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                @endcanany
                <ul class="pcoded-submenu">
                    @canany(['Add New Coa Header','View Category List'])
                        <li class="add-new-coa-header">
                            <a href="{{url('add-new-coa-header')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Add New COA Header</span>
                            </a>
                        </li>
                    @endcanany
                    @canany(['Add New COA','View COA List'])
                        <li class="create-coa">
                            <a href="{{url('create-coa')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Add New COA</span>
                            </a>
                        </li>
                    @endcanany
                    @canany(['view COA','Add Account COA'])
                        <li class="coa_view">
                            <a href="{{url('coa_view')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Chart of Account</span>
                            </a>
                        </li>
                    @endcanany
                    @can('Add Transaction')
                        <li class="add_transactions">
                            <a href="{{url('add_transactions')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Add Transactions</span>
                            </a>
                        </li>
                    @endcan
                    @can('Journal Entry')
                        <li class="journal_entry">
                            <a href="{{url('journal_entry')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Journal Entry</span>
                            </a>
                        </li>
                    @endcan
{{--                    @can('Add/Edit Indent')--}}
{{--                        <li class="account-indent">--}}
{{--                            <a href="{{url('select')}}" class="waves-effect waves-dark">--}}
{{--                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>--}}
{{--                                <span class="pcoded-mtext">Indent</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endcan--}}
                </ul>
            </li>

            <li class="pcoded-hasmenu reports">
                @canany(['View Trail Balance','View Income Statement','View Balance Sheet'])
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-printer"></i><b>P</b></span>
                        <span class="pcoded-mtext">Account Reports</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                @endcanany
                <ul class="pcoded-submenu">
                    <li class="monthly_expense_date">
                        <a href="{{url('monthly_expense_date')}}" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Monthly Expense</span>
                        </a>
                    </li>
                    @can('View Trail Balance')
                        <li class="trial_balance_date">
                            <a href="{{url('trial_balance_date')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Trial balance</span>
                            </a>
                        </li>
                    @endcan
                    @can('View Income Statement')
                        <li class="income_statement_date">
                            <a href="{{url('income_statement_date')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Income Statement</span>
                            </a>
                        </li>
                    @endcan
                    @can('View Balance Sheet')
                        <li class="balance_sheet_date">
                            <a href="{{url('balance_sheet_date')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Balance Sheet</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="pcoded-hasmenu add">
                @canany(['Add/Edit Category', 'Add/Edit Designation','Add/Edit Department', 'Add/Edit Incentives'])
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-book"></i><b>P</b></span>
                        <span class="pcoded-mtext">HR Basic Info</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                @endcanany
                <ul class="pcoded-submenu">
                    @can('Add/Edit Category')
                        <li class="employee-category">
                            <a href="{{url('employee-category')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Category</span>
                            </a>
                        </li>
                    @endcan
                    @can('Add/Edit Designation')
                        <li class="designation">
                            <a href="{{url('designation')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Designation</span>
                            </a>
                        </li>
                    @endcan
                    @can('Add/Edit Department')
                        <li class="department">
                            <a href="{{url('department')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Department</span>
                            </a>
                        </li>
                    @endcan
                    @can('Add/Edit Location')
                        <li class="location">
                            <a href="{{url('location')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Locations</span>
                            </a>
                        </li>
                    @endcan
                    @can('Add/ Edit Conveyance Schedule')
                        <li class="conveyance">
                            <a href="{{url('conveyance')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Conveyance Schedule</span>
                            </a>
                        </li>
                    @endcan
                    @can('Add Chalan Number')
                        <li class="chalan_no">
                            <a href="{{url('chalan_no')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Chalan Number</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="pcoded-hasmenu employees">
                @canany(['View Employee List','Add as User','Add/Edit Designation','Add/Edit Department'])
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-agenda"></i><b>P</b></span>
                        <span class="pcoded-mtext">HR Employees</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                @endcanany
                <ul class="pcoded-submenu">
                    @can('View Employee List')
                        <li class="employee">
                            <a href="{{url('employee')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Employees List</span>
                            </a>
                        </li>
                    @endcan

                    @can('View Employee List')
                        <li class="attendance">
                            <a href="{{url('attendance')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Attendance</span>
                            </a>
                        </li>
                    @endcan

                    @can('Upload Documents')
                        <li class="document">
                            <a href="{{url('document')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Documents</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="pcoded-hasmenu payroll">
                @canany(['View Employee List','Add as User','Add/Edit Designation','Add/Edit Department'])
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-agenda"></i><b>P</b></span>
                        <span class="pcoded-mtext">HR Payroll</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                @endcanany
                <ul class="pcoded-submenu">
                    @role('Super Admin')
                    <li class="authorize">
                        <a href="{{url('authorize')}}" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Payslip Authorize</span>
                        </a>
                    </li>
                    @endrole

                    @can('Add Bonus and Advances')
                        <li class="allowance">
                            <a href="{{url('allowance')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Incentive, Advances, Overtime, Conveyance</span>
                            </a>
                        </li>
                    @endcan

                    @can('Add Employee Salary Divisions')
                        <li class="salaryDivision">
                            <a href="{{url('salaryDivision')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Employee Salary Divisions</span>
                            </a>
                        </li>
                    @endcan

                    @can('Upload Documents')
                        <li class="salary_statement">
                            <a href="{{url('salary_statement')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Salary Statements</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="pcoded-hasmenu inventories">
                @canany(['View Inventory','Add Inventory','Edit Inventory', 'Add Product'])
                    <a href="javascript:void(2)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-harddrives"></i><b>P</b></span>
                        <span class="pcoded-mtext">Asset Management</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                @endcanany

                <ul class="pcoded-submenu">
                    <li class="pcoded-hasmenu nonfixed">
                        @canany(['View Inventory','Add Inventory','Edit Inventory', 'Add Product'])
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-harddrives"></i><b>P</b></span>
                                <span class="pcoded-mtext">Non Fixed asset</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        @endcanany
                        <ul class="pcoded-submenu">
                            @canany(['View Inventory','Add Inventory','Edit Inventory'])
                                <li class="inventory">
                                    <a href="{{url('inventory')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                        <span class="pcoded-mtext">Inventory List</span>
                                    </a>
                                </li>
                            @endcanany

                            @can('Add Product')
                                <li class="product">
                                    <a href="{{url('product')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                        <span class="pcoded-mtext">Products List</span>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>

                    <li class="pcoded-hasmenu fixed">
                        @canany(['View Inventory','Add Inventory','Edit Inventory', 'Add Product'])
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-harddrives"></i><b>P</b></span>
                                <span class="pcoded-mtext">Fixed Asset</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                            <ul class="pcoded-submenu">
                                @canany(['View Inventory','Add Inventory','Edit Inventory'])
                                    <li class="equipment">
                                        <a href="{{url('equipment')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                            <span class="pcoded-mtext">Property, Plant and Equipment</span>
                                        </a>
                                    </li>

                                    <li class="vehicles">
                                        <a href="{{url('vehicles')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                            <span class="pcoded-mtext">Vehicles</span>
                                        </a>
                                    </li>

                                    <li class="furniture">
                                        <a href="{{url('furniture')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                            <span class="pcoded-mtext">Furniture</span>
                                        </a>
                                    </li>
                                @endcanany
                                @can('Add Product')
                                    <li class="product">
                                        <a href="{{url('products')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                            <span class="pcoded-mtext">Assets List</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        @endcanany

                    </li>
{{--                    <li class="pcoded-hasmenu Indent">--}}
{{--                        @can('Add/Edit Indent')--}}
{{--                            <li class="account-indent">--}}
{{--                                <a href="{{url('select')}}" class="waves-effect waves-dark">--}}
{{--                                    <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>--}}
{{--                                    <span class="pcoded-mtext">Indent</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endcan--}}
{{--                    </li>--}}
                </ul>
            </li>

            <li class="pcoded-hasmenu projects">
                @canany(['view Project List','view Project Details','view Project Payment','view Project Documents','Add/Edit Project','Add Task','View Client List','View Client Details','View Client Payment','View Client Provided Documents','Add/Edit Client','View Vendor','Add Vendor', 'Edit Client'])
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-folder"></i><b>P</b></span>
                        <span class="pcoded-mtext">Project Management</span>
                        <span class="pcoded-mcaret"></span>
                    </a>

                    <ul class="pcoded-submenu">
                        @canany(['View Client List','View Client Details','View Client Payment','View Client Provided Documents','Add/Edit Client'])
                            <li class="client">
                                <a href="{{url('client')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                    <span class="pcoded-mtext">Client List</span>
                                </a>
                            </li>
                        @endcanany

                        @canany(['view Project List','view Project Details','view Project Payment','view Project Documents','Add/Edit Project','Add Task'])
                            <li class="project">
                                <a href="{{url('project')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-layout-grid3"></i></span>
                                    <span class="pcoded-mtext">Project List</span>
                                </a>
                            </li>
                        @endcanany

                        @canany(['View Vendor','Add Vendor', 'Edit Client'])
                            <li class="vendors">
                                <a href="{{url('vendors')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                    <span class="pcoded-mtext">Vendor List</span>
                                </a>
                            </li>
                        @endcanany
                    </ul>

                @endcanany
            </li>

            <li class="pcoded-hasmenu indents">
                @canany(['View Indent List','Add Indent List','View Inventory Indent List','Add Inventory Indent List'])
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-layout"></i><b>P</b></span>
                        <span class="pcoded-mtext">Indents</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                @endcanany
                <ul class="pcoded-submenu">
                    @canany(['View Indent List'])
                        <li class="inventory">
                            <a href="{{url('show_indents')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">View Account Indents</span>
                            </a>
                        </li>
                    @endcanany
                    @canany(['Add Indent List'])
                        <li class="inventory">
                            <a href="{{url('add_indents')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Add Account Indents</span>
                            </a>
                        </li>
                    @endcanany
                    @canany(['View Inventory Indent List'])
                        <li class="inventory">
                            <a href="{{url('show_indents_Inventory')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">View Inventory Indents</span>
                            </a>
                        </li>
                    @endcanany
                    @canany(['Add Inventory Indent List'])
                        <li class="inventory">
                            <a href="{{url('add_indents_Inventory')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Add Inventory Indents</span>
                            </a>
                        </li>
                    @endcanany
                </ul>
            </li>

            <li class="pcoded-hasmenu settings">
                @canany(['View User List','Edit User','Delete User','Add/Edit Role','Assign Permission by User','Assign Permission by Role'])
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-settings"></i><b>P</b></span>
                        <span class="pcoded-mtext">Settings</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                @endcanany

                <ul class="pcoded-submenu">
                    @canany(['View User List','Edit User','Delete User','Assign Permission by User'])
                        <li class="user">
                            <a href="{{url('user')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">User</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['Add/Edit Role','Assign Permission by Role'])
                        <li class="role">
                            <a href="{{url('role')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Role</span>
                            </a>
                        </li>
                    @endcanany
                </ul>
            </li>
        </ul>
    </div>
</nav>
