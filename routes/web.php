<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['revalidate','auth']], function(){
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::get('/dashboard', 'HomeController@index');

// Base group routes
    Route::resource('base_group', 'ErpBaseGroupController');
    Route::get('deleteBaseGroupView/{id}', 'ErpBaseGroupController@deleteBaseGroupView');
    Route::get('deleteBaseGroup/{id}', 'ErpBaseGroupController@deleteBaseGroup');

// Base setup routes
    Route::resource('base_setup', 'ErpBaseSetupController');
    Route::get('deleteBaseSetupView/{id}', 'ErpBaseSetupController@deleteBaseSetupView');
    Route::get('deleteBaseSetup/{id}', 'ErpBaseSetupController@deleteBaseSetup');

// Chart of Accounts Category
    Route::resource('account-category', 'ErpAccountsCategoryController');

// Chart of Accounts Class
    Route::resource('account-class', 'ErpAccountsClassController');
    Route::get('deleteAccountClassView/{id}', 'ErpAccountsClassController@deleteAccountClassView');
    Route::get('deleteAccountClass/{id}', 'ErpAccountsClassController@deleteAccountClass');

// Chart of Accounts
    Route::get('account-list', 'ErpChartOfAccountsController@accountList');
    Route::get('add-new-coa-header', 'ErpChartOfAccountsController@addNewCoaHeader')->middleware('permission:View Category List|Add New Coa Header');
    Route::post('save-coa-header', 'ErpChartOfAccountsController@saveCoaHeader')->middleware('permission:Add New Coa Header');
    Route::get('edit-coa-header/{id}', 'ErpChartOfAccountsController@editCoaHeader');
    Route::post('editCoaHeader/{id}', 'ErpChartOfAccountsController@updateCoaHeader');
    Route::get('create-coa', 'ErpChartOfAccountsController@createCOA');
    Route::post('storeCOA', 'ErpChartOfAccountsController@storeCOA');
    Route::get('edit-coa/{id}', 'ErpChartOfAccountsController@editCOA');
    Route::post('editCOA/{id}', 'ErpChartOfAccountsController@updateCOA');

    Route::get('coa_view', 'ErpChartOfAccountsController@coa_view')->middleware('permission:view COA');
    Route::get('addAccountModal/{parentId?}','ErpChartOfAccountsController@showAddAccountModal')->middleware('permission:Add Account COA');

// Client route
    Route::resource('client', 'ErpClientController');
    Route::get('deleteClientView/{id}', 'ErpClientController@deleteClientView');
    Route::get('deleteClient/{id}', 'ErpClientController@deleteClient');

// Chalan Number routes
    Route::resource('chalan_no', 'ErpChalanNoController');

    // Department routes
    Route::resource('conveyance', 'ErpConveyanceController');
    Route::post('increase_conveyance', 'ErpConveyanceController@increaseConveyanceRate');
    Route::get('deleteConveyanceView/{id}', 'ErpConveyanceController@deleteConveyanceView');
    Route::get('deleteConveyance/{id}', 'ErpConveyanceController@deleteConveyance');

// Department routes
    Route::resource('department', 'ErpDepartmentController')->middleware('permission:Add/Edit Department');
    Route::get('deleteDepartmentView/{id}', 'ErpDepartmentController@deleteDepartmentView');
    Route::get('deleteDepartment/{id}', 'ErpDepartmentController@deleteDepartment');

// Designation routes
    Route::resource('designation', 'ErpDesignationController')->middleware('permission:Add/Edit Designation');
    Route::get('deleteDesignationView/{id}', 'ErpDesignationController@deleteDesignationView');
    Route::get('deleteDesignation/{id}', 'ErpDesignationController@deleteDesignation');

// Documents (from employee, client and project)
    Route::resource('document', 'ErpDocumentsController');
    Route::get('document/read/{id}', 'ErpDocumentsController@documentPdf');

    Route::post('employee/uploadDocument/{id}', 'ErpDocumentsController@uploadEmployeeDocument');
    Route::get('employee/joining_letter/{id}', 'ErpDocumentsController@employeePdf');
    Route::get('employee/document/{id}', 'ErpDocumentsController@employeeDocumentPdf');
    Route::get('employee/education/{id}', 'ErpDocumentsController@employeeEducationPdf');
    Route::get('employee/experience/{id}', 'ErpDocumentsController@employeeWorkExperiencePdf');

    Route::get('client/document/{id}', 'ErpDocumentsController@clientPdf');
    Route::post('client/uploadDocument/{id}', 'ErpDocumentsController@uploadClientDocument');

    Route::get('project/document/{id}', 'ErpDocumentsController@projectPdf');
    Route::post('project/uploadDocument/{id}', 'ErpDocumentsController@uploadProjectDocument');

    Route::get('vendor/document/{id}', 'ErpDocumentsController@vendorPdf');
    Route::post('vendor/uploadDocument/{id}', 'ErpDocumentsController@uploadVendorDocument');
    Route::get('inventory/document/{id}', 'ErpDocumentsController@inventoryPdf');

// Employee Category
    Route::resource('employee-category', 'ErpEmployeeCategoryController');
    Route::get('deleteEmployeeCategoryView/{id}', 'ErpEmployeeCategoryController@deleteEmployeeCategoryView');
    Route::get('deleteEmployeeCategory/{id}', 'ErpEmployeeCategoryController@deleteEmployeeCategory');

//Indent
    Route::get('select', 'IndentController@select');
    Route::get('select/{id}/edit', 'IndentController@edit');
    Route::post('insert', 'IndentController@insert');
    Route::post('insert/{id}', 'IndentController@update');
    Route::post('update', 'IndentController@update');
    Route::get('delete', 'IndentController@delete');
    Route::get('deleteView/{id}', 'IndentController@deleteView');
    Route::get('delete/{id}', 'IndentController@delete');
    Route::get('history', 'History_LogController@history');

// Employee routes
    Route::resource('employee', 'ErpEmployeeController');
    Route::get('employee/print/{id}','ErpEmployeeController@printInfo');
    Route::post('employee/printSalary','ErpEmployeeController@printSalaryStatement');
    Route::post('employee/printSalary2','ErpEmployeeController@printSalaryAdvice');
    Route::get('employee/printSalaryIndi/{id}','ErpEmployeeController@printSalaryIndividual');
    Route::post('employee/printSalaryMonth/{id}','ErpEmployeeController@printSalaryMonth');
    Route::get('employee/printCertificate/{id}','ErpEmployeeController@printCertificate');
    Route::get('deleteEmployeeView/{id}', 'ErpEmployeeController@deleteEmployeeView');
    Route::get('deleteEmployee/{id}', 'ErpEmployeeController@deleteEmployee');

    Route::get('salary_statement', 'ErpEmployeeController@salaryStatement');
    Route::post('employee/statement', 'ErpEmployeeController@salaryStatementDate');
    Route::post('employee/advice','ErpEmployeeController@salaryAdviceDate');
    Route::post('statement/approve', 'ErpEmployeeController@salaryStatementApprove');

    Route::get('attendance', 'ErpEmployeeController@viewAttendance');
    Route::post('employee/attendance/{id}', 'ErpEmployeeController@addAttendance');
    Route::post('employee/leaveRequest/{id}', 'ErpEmployeeController@leaveRequest');
    Route::post('employee/leavePermission/{id}', 'ErpEmployeeController@leavePermission');
    Route::post('employee/material/{id}', 'ErpEmployeeController@addEmployeeMaterial');
    Route::post('employee/assign_material/{id}', 'ErpEmployeeController@assignMaterial');

    Route::get('salary/{id}', 'ErpEmployeeController@salary')->name('salary');

// Employee Indent routes
    Route::resource('employeeIndent', 'ErpEmployeeIndentController');
    Route::get('deleteIndentView/{id}', 'ErpEmployeeIndentController@deleteIndentView');
    Route::get('deleteEmployeeIndent/{id}', 'ErpEmployeeIndentController@deleteEmployeeIndent');

// Employee Salary Division routes
    Route::resource('salaryDivision', 'ErpEmployeeSalaryDivisionController');
    Route::get('deleteSalaryDivisionView/{id}', 'ErpEmployeeSalaryDivisionController@deleteSalaryDivisionView');
    Route::get('deleteSalaryDivision/{id}', 'ErpEmployeeSalaryDivisionController@deleteSalaryDivision');

// Incentive routes
    Route::resource('incentive', 'ErpSalaryIncentiveController');
    Route::get('allowance', 'ErpSalaryIncentiveController@allowance');

    Route::post('addBonus', 'ErpSalaryIncentiveController@addBonus');
    Route::get('deleteBonusView/{id}', 'ErpSalaryIncentiveController@deleteBonusView');
    Route::get('deleteBonus/{id}', 'ErpSalaryIncentiveController@deleteBonus');

    Route::post('addAdvance', 'ErpSalaryIncentiveController@addAdvance');
    Route::get('deleteAdvanceView/{id}', 'ErpSalaryIncentiveController@deleteAdvanceView');
    Route::get('deleteAdvance/{id}', 'ErpSalaryIncentiveController@deleteAdvance');

    Route::post('addOvertimePay', 'ErpSalaryIncentiveController@addOvertimePay');
    Route::get('deleteOvertimeView/{id}', 'ErpSalaryIncentiveController@deleteOvertimeView');
    Route::get('deleteOvertime/{id}', 'ErpSalaryIncentiveController@deleteOvertime');

    Route::post('addConveyancePay', 'ErpSalaryIncentiveController@addConveyancePay');
    Route::get('deleteConveyanceView/{id}', 'ErpSalaryIncentiveController@deleteConveyanceView');
    Route::get('deleteConveyance/{id}', 'ErpSalaryIncentiveController@deleteConveyance');

    Route::get('deleteIncentiveView/{id}', 'ErpSalaryIncentiveController@deleteIncentiveView');
    Route::get('deleteIncentive/{id}', 'ErpSalaryIncentiveController@deleteIncentive');

    Route::post('add_chalan', 'ErpSalaryIncentiveController@addChalanNo');


// Inventory routes
    Route::resource('inventory', 'ErpInventoryController');
    Route::get('inventory/create/{id}', 'ErpInventoryController@create');
    Route::get('equipment', 'ErpInventoryController@equipment');
    Route::get('vehicles', 'ErpInventoryController@vehicles');
    Route::get('furniture', 'ErpInventoryController@furniture');

    Route::get('inventory/printList/{id}', 'ErpInventoryController@printList');
    Route::get('inventory/printAssignedList/{id}', 'ErpInventoryController@printAssignedList');

    Route::post('inventory/assign/{id}', 'ErpInventoryController@assign');
    Route::get('assignBackView/{id}', 'ErpInventoryController@assignBackView');
    Route::get('assignBack/{id}', 'ErpInventoryController@assignBack');

    Route::get('deleteInventoryView/{id}', 'ErpInventoryController@deleteInventoryView');
    Route::get('deleteDocument/{id}', 'ErpDocumentsController@deleteDocumentView');
    Route::get('deleteDocument1/{id}', 'ErpDocumentsController@deleteDocument');

    Route::get('deleteInventory/{id}', 'ErpInventoryController@deleteInventory');

// Location
    Route::resource('location', 'ErpLocationController')->middleware('permission:Add/Edit Location');
    Route::get('location/assets/{id}', 'ErpLocationController@assets');
    Route::get('location/employees/{id}', 'ErpLocationController@employees');

// Payslip Authorization
    Route::resource('authorize', 'ErpPayslipAuthorizeController');
    Route::get('deleteAuthorize/{id}', 'ErpPayslipAuthorizeController@deleteAuthorize');

// Product routes
    Route::resource('product', 'ErpProductController');
    Route::get('products', 'ErpProductController@products');
    Route::get('assets/printList', 'ErpProductController@printList');

    Route::get('deleteProductView/{id}', 'ErpProductController@deleteProductView');
    Route::get('deleteProduct/{id}', 'ErpProductController@deleteProduct');

// Project routes
    Route::resource('project', 'ErpProjectController');
    Route::get('project/nextPhase/{id}', 'ErpProjectController@nextPhase');
    Route::post('project/updatePhase/{id}', 'ErpProjectController@updatePhase');

    Route::get('project/createJV/{id}', 'ErpProjectController@createJointVenture');
    Route::post('project/storeJV/{id}', 'ErpProjectController@storeJointVenture');
    Route::get('project/editJV/{id}', 'ErpProjectController@editJointVenture');
    Route::put('project/updateJV/{id}', 'ErpProjectController@updateJointVenture');
    Route::get('print_projects', 'ErpProjectController@printProjects');
    Route::get('print_projects/past', 'ErpProjectController@printProjectsPast');
    Route::get('print_projects/complete', 'ErpProjectController@printProjectsComplete');
    Route::get('print_projects/active', 'ErpProjectController@printProjectsActive');

    Route::get('projects/past','ErpProjectController@pastProjects');
    Route::get('projects/completed','ErpProjectController@completedProjects');

    Route::post('project/employee/{id}', 'ErpProjectController@addProjectEmployee');
    Route::post('project/employee_edit/{id}', 'ErpProjectController@editProjectEmployee');
    Route::post('project/employee_reassign/{id}', 'ErpProjectController@reassignProjectEmployee');
    Route::get('deleteProjectEmployeeView/{id}', 'ErpProjectController@deleteProjectEmployeeView');
    Route::get('deleteProjectEmployee/{id}', 'ErpProjectController@deleteProjectEmployee');

    Route::post('project/material/{id}', 'ErpProjectController@addProjectMaterial');
    Route::put('project/material_edit/{id}', 'ErpProjectController@updateProjectMaterial');
    Route::post('project/material_reassign/{id}', 'ErpProjectController@reassignProjectMaterial');
    Route::get('deleteProjectMaterialView/{id}', 'ErpProjectController@deleteProjectMaterialView');
    Route::get('deleteProjectMaterial/{id}', 'ErpProjectController@deleteProjectMaterial');
    Route::post('project/budget/{id}', 'ErpProjectController@addProjectBudget');
    Route::post('project/budget_edit/{id}', 'ErpProjectController@updateProjectBudget');
    Route::get('deleteProjectBudget/{id}', 'ErpProjectController@deleteProjectBudget');
    Route::get('deleteProjectBudgetView/{id}', 'ErpProjectController@deleteProjectBudgetView');
    Route::post('project/lesson/{id}', 'ErpProjectController@projectLesson');
    Route::post('project/sign_off/{id}', 'ErpProjectController@projectSignOff');
    Route::post('project/check_list/{id}', 'ErpProjectController@projectCheckList');
    Route::get('project/print/{id}','ErpProjectController@printTask');

    Route::get('deleteProjectView/{id}', 'ErpProjectController@deleteProjectView');
    Route::get('deleteProject/{id}', 'ErpProjectController@deleteProject');

// Project Deliverable
    Route::resource('project_advance', 'ErpProjectAdvancesController');
    Route::get('project_advance/create/{id}','ErpProjectAdvancesController@create');

    Route::post('project_advance/create/amendment/{id}','ErpProjectAdvancesController@amendmentCreate');


//Project Progress Payment
    Route::resource('project_progressPayment', 'ErpProjectProgressPaymentController');
    Route::get('project_progress/create/{id}','ErpProjectProgressPaymentController@create');


// Project Deliverable
    Route::resource('project_deliverable', 'ErpProjectDeliverableController');
    Route::get('project_deliverable/create/{id}','ErpProjectDeliverableController@create');

// Project Reporting
    Route::resource('project_reporting', 'ErpProjectReportingController');
    Route::get('project_reporting/create/{id}','ErpProjectReportingController@create');

// Vendor routes
    Route::resource('vendors', 'ErpVendorController');
    Route::get('deleteVendorView/{id}', 'ErpVendorController@deleteVendorView');
    Route::get('deleteVendor/{id}', 'ErpVendorController@deleteVendor');

//  Tasks route
    Route::resource('task', 'ErpTaskController');
    Route::get('task/create/{id}','ErpTaskController@create');

    Route::get('submitTaskView/{id}','ErpTaskController@submitTaskView');
    Route::get('submitTask/{id}','ErpTaskController@submitTask');
    Route::get('confirmTaskView/{id}','ErpTaskController@confirmTaskView');
    Route::get('confirmTask/{id}','ErpTaskController@confirmTask');
    Route::get('reassignTaskView/{id}','ErpTaskController@reassignTaskView');
    Route::get('reassignTask/{id}','ErpTaskController@reassignTask');

    Route::get('deleteTaskView/{id}', 'ErpTaskController@deleteTaskView');
    Route::get('deleteTask/{id}', 'ErpTaskController@deleteTask');

    Route::get('addToDo/{id}','ErpTaskController@addToDo');
    Route::post('saveToDo','ErpTaskController@saveToDo');
    Route::get('editToDo/{id}','ErpTaskController@editToDo');
    Route::put('updateToDo/{id}','ErpTaskController@updateToDo');
    Route::get('deleteToDoView/{id}', 'ErpTaskController@deleteToDoView');
    Route::get('deleteToDo/{id}', 'ErpTaskController@deleteToDo');

// Reports routes
    // Journal Entry
    Route::get('journal_entry','ReportController@journalEntry')->middleware('permission:Journal Entry');
    // Monthly Expense
    Route::get('monthly_expense_date','ReportController@monthlyExpenseDate');
    Route::post('monthly_expense','ReportController@generateMonthlyExpense');
//    Route::post('daily_expense','ReportController@generateMonthlyExpense');
    
    // Trial Balance
    Route::get('trial_balance_date','ReportController@trialBalanceDate')->middleware('permission:View Trail Balance');
    Route::post('trial_balance','ReportController@generateTrialBalance')->middleware('permission:View Trail Balance');
    // Profit Loss
    Route::get('income_statement_date','ReportController@incomeStatementsDate')->middleware('permission:View Income Statement');
    Route::post('income_statement','ReportController@generateIncomeStatement')->middleware('permission:View Income Statement');
    // Balance Sheet
    Route::get('balance_sheet_date','ReportController@balanceSheetDate')->middleware('permission:View Balance Sheet');
    Route::post('balance_sheet','ReportController@generateBalanceSheet')->middleware('permission:View Balance Sheet');

    Route::get('single_account/{id}','ReportController@singleAccountTransactions');
    Route::get('single_transaction/{id}','ReportController@singleTransaction');

// Role route
    Route::resource('role', 'ErpRoleController');
    Route::get('deleteRoleView/{id}', 'ErpRoleController@deleteRoleView');
    Route::get('deleteRole/{id}', 'ErpRoleController@deleteRole');
    Route::get('role_assign-permission/{role_id}', 'ErpRoleController@assignPermission');
    Route::post('role_permission_store', 'ErpRoleController@rolePermissionStore');

    // Amendment
    Route::get('project/remuneration/amendment/create/{id}', 'ErpProjectController@createRemunerationAmendment');
    Route::get('project/reimbursable/amendment/create/{id}', 'ErpProjectController@createReimbursableAmendment');
    Route::get('project/advance/amendment/create/{id}', 'ErpProjectController@createAdvanceAmendment');
    Route::get('project/progress/amendment/create/{id}', 'ErpProjectController@createProgressAmendment');
    Route::get('project/task/amendment/create/{id}', 'ErpProjectController@createTaskAmendment');
    Route::get('project/reporting/amendment/create/{id}', 'ErpProjectController@createReportingAmendment');
    Route::get('project/deliverable/amendment/create/{id}', 'ErpProjectController@createDeliverableAmendment');
    
    
// Transactions routes
    Route::get('add_transactions','TransactionsController@index')->middleware('permission:Add Transaction');
    Route::post('add_transactions',[
        'as' => 'addTransactions',
        'uses'=>'TransactionsController@addTransactions'
    ])->middleware('permission:Add Transaction');

// User route
    Route::resource('user', 'ErpUserController');
    Route::get('user/create/{id}','ErpUserController@create')->middleware('permission:Add as User');
    Route::get('user/editPassword/{id}','ErpUserController@editPassword');
    Route::put('user/changePassword/{id}','ErpUserController@changePassword');
    Route::get('suspended', 'ErpUserController@suspended');
    Route::get('activeUserView/{id}', 'ErpUserController@activeUserView');
    Route::get('activeUser/{id}', 'ErpUserController@activeUser');
    Route::get('deleteUserView/{id}', 'ErpUserController@deleteUserView');
    Route::get('deleteUser/{id}', 'ErpUserController@deleteUser');

    Route::get('user_assign-permission/{user_id}', 'ErpUserController@assignPermission');
    Route::post('user_permission_store', 'ErpUserController@userPermissionStore');

    Route::get('allnotifications', 'ErpUserController@allNotifications');
});

//New Indent Vue routs
Route::get('add_indents','NewIndentController@create');
Route::post('insert_indents','NewIndentController@insert');
Route::get('show_indents','NewIndentController@index');
Route::get('IndentDeleteView/{id}', 'NewIndentController@deleteView');
Route::get('IndentDelete/{id}', 'NewIndentController@delete');
Route::post('approvalAction', 'NewIndentController@action');
Route::get('IndentPrint/{id}', 'NewIndentController@IndentPrint')->name('IndentPrint');
