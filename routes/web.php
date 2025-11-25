<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\customerController;
use App\Http\Controllers\groupReceiptController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavisionController;
use App\Http\Controllers\invoiceController;
use App\Http\Controllers\Madem3;
use App\Http\Controllers\Receipt;
use App\Http\Controllers\login;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\userTwoController;
use App\Http\Controllers\userTreeController;
use App\Http\Controllers\utilitController;
use App\Http\Middleware\CheckRole;
use App\Models\User;

Route::get('/', function () {
    return view('home.home');
});

// Route::get('/otp/view', function () {
//     return view('auth.otp');
// });

Route::get('/otp/view', [LoginController::class, 'otpView'])->name('otp.view');


Route::get('/password/reset', [LoginController::class, 'passwordReset'])->name('passwordReset');

Route::post('/password/reset/send', [LoginController::class, 'passwordResetSend'])->name('password-reset-send');

Route::match(['get', 'post'], '/verify/otp', [LoginController::class, 'verifyotp'])->name('verify-otp');

Route::post('/new/password', [LoginController::class, 'newPassword'])->name('new-password');



Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/login-check', [login::class, 'loginCheck'])->name('Login-check');
 Route::get('/preview/advance/{id}', [utilitController::class, 'previewAdvance']);

Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => ['App\Http\Middleware\CheckRole:' . User::ROLE_USER]], function () {
        Route::get('/dashboard', [NavisionController::class, 'dashboard'])->name('dashboard');

        Route::get('/all/Invoice', [NavisionController::class, 'allInvoice'])->name('allInvoice');

        Route::post('/edit/invoice/number/{id}', [invoiceController::class, 'editInvoiceNumber'])->name('edit.invoice.number');

        Route::post('/edit/new/invoice/number/{id}', [invoiceController::class, 'editnewInvoiceNumber'])->name('edit.new.invoice.number');


        Route::get('/reject/Invoice', [NavisionController::class, 'RejectInvoice'])->name('rejectInvoice');

        Route::get('/reject/Invoice/View/{id}', [NavisionController::class, 'RejectInvoiceView'])->name('view-reject-Invoice');

        Route::get('/new/invoice', [invoiceController::class, 'NewInvoice'])->name('new-invoice');

        Route::get('/ongoing/invoice', [NavisionController::class, 'ongoingInvoice'])->name('ongoing-invoice');

        Route::post('/RegisterCompanySave', [invoiceController::class, 'RegisterCompanySave'])->name('RegisterCompanySave');

        Route::get('/fixed/{id}', [invoiceController::class, 'fixed'])->name('fixed');

        Route::get('/recent/home/{invoiceNumber}', [invoiceController::class, 'recentHome'])->name('recent.home');



        Route::get('/search/customer', [invoiceController::class, 'SearchCustomer'])->name('search.customer');



        Route::get('recent/delete/{id}', [invoiceController::class, 'recentDelete'])->name('recent.delete');

        Route::put('/update/company', [CompanyController::class, 'update'])->name('update.company');

        Route::get('reject/invoice/re/send/{invoiceNumber}', [invoiceController::class, 'rejectResend']);


    });

    Route::group(['middleware' => ['App\Http\Middleware\CheckRole:' . User::ROLE_FINANCE]], function () {
        Route::get('/user2', [NavisionController::class, 'user2'])->name('user2');

        Route::get('/user2/two-allInvoice', [NavisionController::class, 'twoallInvoice'])->name('two-allInvoice');

        Route::get('/new/invoice/approvel', [invoiceController::class, 'NewInvoiceUser'])->name('new-invoice-user');

        // Route::get('/delete/invoice/{invoiceNUmber}', [invoiceController::class, 'deleteinvoiceadmin']);

        Route::get('/reject/Invoice/View/two/{id}', [NavisionController::class, 'RejectInvoiceView'])->name('view-reject-Invoice-two');

        Route::get('/two/rejected/invoice', [invoiceController::class, 'rejectInvoiceUser'])->name('rejectInvoiceUserTwo');

        Route::post('/handler/add', [PaymentController::class, 'handlerAdd'])->name('handler.add');

        Route::get('/pin/{id}', [PaymentController::class, 'pin'])->name('pin');

        Route::post('/add-bank', [PaymentController::class, 'addBank'])->name('add.bank');

        Route::get('/update', [NavisionController::class, 'updateForm'])->name('update');

        Route::get('2/outstanding', [userTwoController::class, 'OutstandingInvoice'])->name('two-Outstanding-invoice');

        Route::get('2/outstanding/view', [userTwoController::class, 'OutstandingInvoiceView'])->name('two-Outstanding-view');

        Route::get('2/Reports', [userTwoController::class, 'Reports'])->name('Reports');

        Route::get('/filter-invoices', [userTwoController::class, 'filterInvoices'])->name('filter.invoices');

        Route::get('/invoiceNumber/last/{id}', [invoiceController::class, 'sendInvoiceLast'])->name('send-invoice-last');

        Route::get('/invoice/generate/{id}', [InvoiceController::class, 'generateInvoiceFinal'])->name('generate-Invoice');

        Route::post('/invoice/generate/pdf', [InvoiceController::class, 'generateInvoicePdf'])->name('lastGenerate');

        Route::get('customer/on/{id}', [customerController::class, 'on'])->name('customer.on');

        Route::get('customer/off/{id}', [customerController::class, 'off'])->name('customer.off');

        Route::get('/delete/invoice/{id}', [invoiceController::class, 'deleteInvoice'])->name('deleteInvoice');

        Route::get('/group/receipt', [groupReceiptController::class, 'groupReceipt'])->name('group.receipt');

        Route::get('/settle/invoice/manual/{id}', [groupReceiptController::class, 'settleInvoice']);

        Route::get('/report/two', [userTwoController::class, 'reporttwo'])->name('reporttwo');

        Route::get('/fix/receipt', [userTwoController::class, 'fixReceipt']);

        Route::post('/receipt/update/{id}', [userTwoController::class, 'receiptUpdatesave'])->name('update.receipt');

        Route::get('/change/bank', [invoiceController::class, 'changeBank'])->name('change.bank');

        Route::get('/delete/receipt/{id}', [PaymentController::class, 'deleteReceipt'])->name('delete.receipt');

        Route::get('/advance/delete/{id}', [utilitController::class, 'deleteAdvance']);

    });

    Route::get('/company/history/report/{id}/{crn}', [userTwoController::class, 'reporttwoView']);

    Route::group(['middleware' => ['App\Http\Middleware\CheckRole:' . User::ROLE_APPROVER]], function () {
        Route::get('/user3', [Madem3::class, 'home'])->name('Home');


        Route::get('/reject/Invoice/View/Three/{id}', [userTreeController::class, 'RejectInvoiceView'])->name('view-reject-Invoice-Three');


        Route::get('/Three/rejected/invoice', [userTreeController::class, 'rejectInvoiceUser'])->name('rejectInvoiceUserThree');


        Route::get('3/outstanding', [userTreeController::class, 'OutstandingInvoice'])->name('tree-Outstanding-invoice');

        Route::get('3/all/Invoices', [NavisionController::class, 'treeAllInvoices'])->name('tree-allinvoice');


        Route::get('3/outstanding/view', [userTreeController::class, 'OutstandingInvoiceView'])->name('tree-Outstanding-view');

        Route::get('/new-invoice-user-tree', [Madem3::class, 'newInvoices'])->name('new-invoice-user-tree');

        Route::get('/view/user/tree/{invoiceNumber}', [Madem3::class, 'viewUser3'])->name('view-user-3');
    });

    // Route::get('2/outstanding/view' ,[userTwoController::class, 'OutstandingInvoiceView'])->name('two-Outstanding-view');

    Route::post('/update-data', [PaymentController::class, 'updateData'])->name('updatedata');

    // ================== Sidebar =========================================

    Route::get('/Company/register', [NavisionController::class, 'CompanyRegister'])->name('Company-register');

    Route::get('/Approved/invoice', [NavisionController::class, 'ApprovedInvoice'])->name('Approved-invoice');

    Route::get('/Outstanding/invoice', [NavisionController::class, 'OutstandingInvoice'])->name('Outstanding-invoice');

    Route::get('/Receipt', [NavisionController::class, 'Receipt'])->name('Receipt');

    Route::get('/modify/{invoiceNumber}', [NavisionController::class, 'modify'])->name('modify');

    Route::get('/user/2/dashboard', [NavisionController::class, 'dashboardUserTwo'])->name('dashboard-user-2');

    Route::get('/generate/Reciept/{id}', [NavisionController::class, 'generateReciept'])->name('generateReciept');

    Route::get('/invoiceNumber/{id}', [invoiceController::class, 'sendInvoice'])->name('send-invoice');

    Route::post('/generate/Reciept', [Receipt::class, 'generateReceipt'])->name('generateReceipt');

    // ====================End Sidebar======================================

    // ==========================User 2 sidebar==================================

    Route::get('/view/user/2/{invoiceNumber}', [NavisionController::class, 'viewUserTwo'])->name('view-user-2');

    Route::get('/sent/user/3/{invoiceNumber}/{notify}', [NavisionController::class, 'sendUsertree'])->name('send-to-user-3');

    Route::get('/sent/user/1/{invoiceNumber}', [NavisionController::class, 'sendUserOne'])->name('send-to-user-1');

    Route::get('/delete-invoice/{id}', [invoiceController::class, 'deleteInvoiceData'])->name('deleteInvoiceData');

    // =========================End Use======================

    // Route::get('/generateInvoice/{id}', [NavisionController::class, 'generateInvoice'])->name('generateInvoice');

    Route::get('/generateInvoice/{id}', [NavisionController::class, 'generateInvoice'])->name('generateInvoice');


    Route::post('/invoiceDataAdd', [invoiceController::class, 'invoiceDataAdd'])->name('invoiceDataAdd');

    Route::get('/invoice/{invoiceNumber}', [invoiceController::class, 'invoiceGenForm'])->name('invoiceGenForm');

    Route::post('/invoiceEditDataSave/{id}', [invoiceController::class, 'invoiceEditDataSave'])->name('invoiceEditDataSave');

    Route::get('/send-to-approver/{invoiceNumber}/{bankId}', [InvoiceController::class, 'sendToApprover'])->name('sendToApprover');

    // ===============================================

    Route::get('/sent/user/two/{invoiceNumber}', [Madem3::class, 'sentBack'])->name('send-to-user-back');

    // =======================Receipt==============

    // Route::get('/receipt/generate/{id}', [Receipt::class, 'receiptGen'])->name('generateReciept');

    // Route::get('/invoice/generate/redirect', [InvoiceController::class, 'redirectInvoicePage'])->name('redirect_invoice_page');

    Route::post('/add/comment', [InvoiceController::class, 'addComment'])->name('add-comment');

    Route::post('/receipt/settlement', [Receipt::class, 'receiptSettlement'])->name('receipt.settlement');

    Route::get('/cus-receipt/{id}', [Receipt::class, 'showReceipt'])->name('customer.receipt');

    // routes/web.php
    Route::post('/upload-pdf', [App\Http\Controllers\PDFController::class, 'upload'])->name('upload-pdf');

    Route::post('/upload-invoice', [App\Http\Controllers\PDFController::class, 'uploadInvoice'])->name('upload-invoice');

    Route::get('/reSend/{id}', [invoiceController::class, 'reSend'])->name('re.send');

    Route::get('/reject-invoice/{invoiceNumber}', [invoiceController::class, 'rejectInvoice'])->name('reject.invoice');

});

Route::post('/payment/submit', [Receipt::class, 'paymentSubmit'])->name('payment.submit');

Route::get('/generate/Reciept/form/{id}', [Receipt::class, 'generateReceiptForm'])->name('generateReceiptForm');

Route::match(['get', 'post'], '/custom/Reciept', [Receipt::class, 'CustomReceipt'])->name('CustomReceipt');

Route::get('/send-checked-receipts', [groupReceiptController::class, 'sendCheckedReceipts'])->name('sendCheckedReceipts');

Route::get('/settle/outstanding/group', [groupReceiptController::class, 'settleoutstandinggroup'])->name('settle.outstanding.group');

Route::get('/group/receipt/generate/{id}', [groupReceiptController::class, 'groupreceiptgenerate'])->name('group.receipt.generate');

Route::get('/group/session/forgot', [groupReceiptController::class, 'groupsessionforgot']);

Route::get('/reset/customer', [groupReceiptController::class, 'reset']);

Route::get('/fix/outstanding', [groupReceiptController::class, 'fixOutstanding']);

Route::post('/update-outstanding/{id}', [groupReceiptController::class, 'updateOutstanding'])->name('update.outstanding');

Route::get('/deactivate/fix/{id}', [groupReceiptController::class, 'deactivate'])->name('deactivate.customer');

Route::get('/aging/report/', [userTwoController::class, 'agingReport']);

Route::get('/aging/report/user', [userTwoController::class, 'agingReportuser']);

Route::get('/aging/report/user3', [userTwoController::class, 'agingReport3']);

Route::get('/user/one/delete/invoice/{invoiceNumber}', [userTwoController::class, 'userOneDeleteOngoingInvoice']);

Route::get('/advancePayment', [utilitController::class, 'advancePayment']);

// Route::get('/api/settle/outstanding', [Receipt::class, 'processPrice']);

Route::get('/db/migrate', [login::class, 'migrate']);
