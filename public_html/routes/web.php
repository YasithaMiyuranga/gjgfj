<?php

use App\Models\PurchaseOrder;
use App\Http\Controllers\Home;
use App\Models\AdditionalExpense;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagerEvents;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SEOController;
use App\Http\Controllers\CustomPacakges;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\AdminCmsController;
use App\Http\Controllers\CashFlowController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RentItemController;
use App\Http\Controllers\StrategyController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ImageMetaController;
use App\Http\Controllers\AdminEventController;
use App\Http\Controllers\DamageItemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserTicketController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\TicketOwnerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\PackageImageController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TaskTemplateController;
use App\Http\Controllers\events\AgendaController;
use App\Http\Controllers\events\artistController;
use App\Http\Controllers\events\TicketController;
use App\Http\Controllers\ManagerEventsController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\EmployeeCreditController;
use App\Http\Controllers\events\SponsorController;
use App\Http\Controllers\TaskManagementController;
use App\Http\Controllers\EventCouponListController;
use App\Http\Controllers\events\CategoryController;
use App\Http\Controllers\RentItemPackageController;
use App\Http\Controllers\TicketOrderListController;
use App\Http\Controllers\EquipmentWastageController;
use App\Http\Controllers\events\agentlistcontroller;
use App\Http\Controllers\AdditionalExpenseController;
use App\Http\Controllers\AgreementCategoryController;
use App\Http\Controllers\AgreementTemplateController;
use App\Http\Controllers\PredefinedPackageController;
use App\Http\Controllers\EmployeePermissionController;
use App\Http\Controllers\TermsAndConditionsController;
use App\Http\Controllers\CustomerRequirementController;
use App\Http\Controllers\EquipmentInvestmentController;
use App\Http\Controllers\ManualExpensesIncomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/', [Home::class, 'Home']);
// Redirect to /admin/login
Route::get('/admin', function () {
    return redirect()->route('admin.login');
});
Route::get('/Packages', [Home::class, 'packages']);
Route::get('/single-package/{package_id}', [Home::class, 'singlepackage']);
Route::get('/single-item/{item_id}', [Home::class, 'singleitem']);
Route::get('/Events', [Home::class, 'events']);
Route::get('/single_event/{event}', [Home::class, 'single_event'])->name('single.event');
Route::get('/Gallery', [Home::class, 'gallery']);
Route::get('/single_gallery/{id}', [Home::class, 'single_gallery']);
Route::get('/About', [Home::class, 'about']);
Route::get('/Contact', [Home::class, 'contactus'])->name('contactus');
Route::get('/Blog', [Home::class, 'blog']);
Route::get('/Privacy', [Home::class, 'privacy']);
Route::get('/Terms-Conditions', [Home::class, 'terms']);




// image name alt update edit route
Route::post('/image-meta/{aid}/{id}', [ImageMetaController::class, 'storeOrUpdate'])->name('useradmin.album.updateMeta');

/* CUSTOM PACKAGE ROUTES */
Route::get('/Custome-Events-Packages', [Home::class, 'cp_item_view'])->name('custom.package');
Route::get('/Custome-Events-Packages/{id}', [Home::class, 'cp_single_item_view'])->name('custom.package.single');
Route::get('/Custome-Packages-Complete', [CustomPacakges::class, 'cp_complate'])->name('custom.package.complate');
Route::post('/Custome-Packages-store', [CustomPacakges::class, 'cp_complate_store'])->name('custom.package.complate.store');
Route::get('/Custome-Packages-ContactUs/{id}', [CustomPacakges::class, 'cp_contactus'])->name('custom.package.contactus');
Route::get('/test', [CustomPacakges::class, 'carttest'])->name('custom.package.contactus.test');
/* END */

/* ADD TO CART ROUTE */
Route::post('/add-to-cart', [CustomPacakges::class, 'addToCart'])->name('add-to-cart');
Route::get('/cart', [CustomPacakges::class, 'showCart'])->name('cart.show');
Route::get('/remove-from-cart/{id}', [CustomPacakges::class, 'removeItem'])->name('remove-from-cart');
Route::post('/cart/update', [CustomPacakges::class, 'updateCart'])->name('update-cart');
/* END */

//*** SUBSCRIPTION ROUTE ***//
Route::post('/subscribe', [SubscriptionController::class, 'subscription'])->name('subscription.store');
//*** END OF SUBSCRIPTION ROUTE ***//

// *** GROUP ROUTES FOR ADMIN ***//
Route::prefix('useradmin')->as('useradmin.')->group(function () {


    // Send Ticket Email
    Route::post('/ticket/send', action: [UserTicketController::class, 'sendMail'])->name('ticket.send')->middleware(['auth:admin', 'xss', 'setlocate']);



    //***Event Management***//
    Route::get('/events_dashboard', [AdminEventController::class, 'index'])->name('event_dashboard')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** EVENT TICKET SALES ADMIN PANEL CALENDER */
    Route::get('/events/calender', [AdminEventController::class, 'eventCalender'])->name('events.calender')->middleware(['auth:admin', 'xss', 'setlocate']);


    // *** AGENTS */
    Route::get('/agents_list', [agentlistcontroller::class, 'agents_list'])->name('events.agents_list')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agents/create', [agentlistcontroller::class, 'add_agent'])->name('events.create_agent')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/agents/store', [agentlistcontroller::class, 'store'])->name('events.agets.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agents/edit/{id}', [agentlistcontroller::class, 'edit_agent'])->name('events.edit_agent')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/agents/update/{id}', [agentlistcontroller::class, 'update_agent'])->name('events.update_agent')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agents/delete_agent_view/{id}', [agentlistcontroller::class, 'delete_agent_view'])->name('events.delete_agent_view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/agents/delete/{id}', [agentlistcontroller::class, 'delete_agent'])->name('events.delete_agent')->middleware(['auth:admin', 'xss', 'setlocate']);

    Route::get('/agent_ticket_sale', [agentlistcontroller::class, 'agent_ticket_sale'])->name('events.agent_ticket_sale')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agent_paymants', [agentlistcontroller::class, 'agent_paymants'])->name('events.agent_paymants')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agent_commission', [agentlistcontroller::class, 'agent_commission'])->name('events.agent_commission')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** EVENTS */
    Route::get('/events_list', [AdminEventController::class, 'events_list'])->name('events.events_list')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/events/create', [AdminEventController::class, 'event_create'])->name('events.event_create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/events/store', [AdminEventController::class, 'store'])->name(name: 'events.event_store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/events/edit/{id}', [AdminEventController::class, 'edit_event'])->name('events.event_edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/events/update/{id}', [AdminEventController::class, 'update_event'])->name('events.event_update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/events/delete/{id}', [AdminEventController::class, 'delete_event_view'])->name('events.delete_event_view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/events/delete/{id}', [AdminEventController::class, 'delete_event'])->name('events.event_delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/events/check-name', [AdminEventController::class, 'checkEventName'])->name('events.checkeventname')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/events/cashflow/{id}', [AdminEventController::class, 'cashflowByEvent'])->name('events.cashflow')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/event/status/update/{id}', [AdminEventController::class, 'updateEventStatusView'])->name('events.update_event_status.view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/event/status/update/{id}', [AdminEventController::class, 'updateEventStatus'])->name('events.update_event_status')->middleware(['auth:admin', 'xss', 'setlocate']);

    //** EVENT PDF DOWNLOAD */
    Route::get('/download-details-docs/{eid}', [AdminEventController::class, 'downloadPdf'])->name('download.details.docs')->middleware(['auth:admin', 'xss', 'setlocate']);

    ///*** EVENTS AGENDA RELATED ROUTES *** */
    Route::get('/agendas', [AgendaController::class, 'agenda_list'])->name('agenda.view')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL EVENTS AGENDA ***//
    Route::get('/agendas/add', [AgendaController::class, 'add_agenda'])->name('agenda.add')->middleware(['auth:admin', 'xss', 'setlocate']); //*** ROUTE TO DISPLAY ADD AGENDA FORM ***//
    Route::post('/agendas/store', [AgendaController::class, 'store_agenda'])->name('agenda.store')->middleware(['auth:admin', 'xss', 'setlocate']); //*** ROUTE TO STORE NEW AGENDA IN THE SYSTEM ***//
    Route::get('/agendas/{agenda}', [AgendaController::class, 'edit_agenda'])->name('agenda.edit')->middleware(['auth:admin', 'xss', 'setlocate']); //*** ROUTE TO EDIT AGENDA IN THE SYSTEM ***//
    Route::put('/agendas/{agenda}', [AgendaController::class, 'update_agenda'])->name('agenda.update')->middleware(['auth:admin', 'xss', 'setlocate']); //*** ROUTE TO UPDATE AGENDA IN THE SYSTEM ***//
    ROUTE::get('/agendas/delete/{agenda}', [AgendaController::class, 'delete_agenda_view'])->name('agenda.delete_view')->middleware(['auth:admin', 'xss', 'setlocate']); //*** ROUTE TO DELETE AGENDA VIEW ***//
    ROUTE::delete('/agendas/{agenda}', [AgendaController::class, 'delete_agenda'])->name('agenda.delete')->middleware(['auth:admin', 'xss', 'setlocate']); //*** ROUTE TO DELETE AGENDA IN THE SYSTEM ***//

    Route::get('/agendas/generate/{event}/pdf', [AgendaController::class, 'generate_AgendaPDF'])->name('agenda_pdf');
    ///*** END OF EVENTS AGENDA RELATED ROUTES *** */


    //*** CATEGORY */
    Route::get('/category', [CategoryController::class, 'category_list'])->name('events.category')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/category/create', [CategoryController::class, 'category_create'])->name('events.category_create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/category/store', [CategoryController::class, 'category_store'])->name('events.category_store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/category/storeandget', [CategoryController::class, 'category_store_and_get_recent'])->name('events.category_store_and_get_recent')->middleware(['auth:admin', 'xss', 'setlocate']);

    Route::get('/category/edit/{id}', [CategoryController::class, 'category_edit'])->name('events.category_edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/category/update/{id}', [CategoryController::class, 'category_update'])->name('events.category_update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/category/delete/{id}', [CategoryController::class, 'category_delete_view'])->name('events.category_delete_view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/category/delete/{id}', [CategoryController::class, 'category_delete'])->name('events.category_delete')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** EVENTS TICKETS */
    Route::get('/events_ticket', [TicketController::class, 'events_ticket_list'])->name('events.ticket.list')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/events_ticket/create', [TicketController::class, 'events_ticket_create'])->name('events.ticket_create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/events_ticket/store', [TicketController::class, 'events_ticket_store'])->name('events.ticket_store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/events_ticket/edit/{id}', [TicketController::class, 'events_ticket_edit'])->name('events.ticket_edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/events_ticket/update/{id}', [TicketController::class, 'events_ticket_update'])->name('events.ticket_update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/events_ticket/delete/{id}', [TicketController::class, 'events_ticket_delete_view'])->name('events.ticket_delete_view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/events_ticket/delete/{id}', [TicketController::class, 'events_ticket_delete'])->name('events.ticket_delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/events_ticket/report_generate', [TicketController::class, 'report_generate'])->name('events.ticket_report_generate')->middleware(['auth:admin', 'xss', 'setlocate']);//*** Route generate report button in view of tickets  ***//
    Route::get('/events_ticket/report_generate', [TicketController::class, 'report_form'])->name('events.ticket_report_generate')->middleware(['auth:admin', 'xss', 'setlocate']);//** Route generate report submit form in generate report button***//
    Route::post('/events_ticket/report_generate', [TicketController::class, 'getReport'])->name('events.ticket_report_generate')->middleware(['auth:admin', 'xss', 'setlocate']); //***Route to display filtered report about tickets sales ***//
    Route::get('/events_ticket/report', [TicketController::class, 'report'])->name('events.ticket_report')->middleware(['auth:admin', 'xss', 'setlocate']); //***Route to download to filtered report about tickets sales ***//
    Route::get('/events_ticket/total_report', [TicketController::class, 'totalreport'])->name('events.ticket_total_report')->middleware(['auth:admin', 'xss', 'setlocate']); //***Route to download total tickets sales report ***//
    // Ticket create for specific event
    Route::get('/events/ticket_create/{eid}', [TicketController::class, 'ticket_create'])->name('events.event_ticket_create')->middleware(['auth:admin', 'xss', 'setlocate']);
    // View tickets summary
    Route::get('/events/ticket_summary/{eid}', [TicketController::class, 'ticket_summary'])->name('events.event_ticket_summary')->middleware(['auth:admin', 'xss', 'setlocate']);
    // View seeating summery
    Route::get('/events/seat_summary/{eid}', [TicketController::class, 'seat_summery'])->name('events.event_seat_summary')->middleware(['auth:admin', 'xss', 'setlocate']);

    //event qrcode details
    Route::get('/events/qr/{eid}', [TicketController::class, 'qr'])->name('events.qr')->middleware(['auth:admin', 'xss', 'setlocate']);

    // Company Profit report
    Route::get('/events/company_profit_report', [TicketController::class, 'profit_report'])->name('events.event_profit_report')->middleware(['auth:admin', 'xss', 'setlocate']);




    //*** EVENT SPONSORS */
    Route::get('/event_sponsors', [SponsorController::class, 'sponsor_list'])->name('events.sponsor.list')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/event_sponsors/create', [SponsorController::class, 'sponsor_create'])->name('events.sponsor_create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/event_sponsors/store', [SponsorController::class, 'sponsor_store'])->name('events.sponsor_store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/event_sponsors/edit/{sponsor}', [SponsorController::class, 'sponsor_edit'])->name('events.sponsor_edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/event_sponsors/update/{sponsor}', [SponsorController::class, 'sponsor_update'])->name('events.sponsor_update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/event_sponsors/delete/{sponsor}', [SponsorController::class, 'sponsor_delete_view'])->name('events.sponsor_delete_view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/event_sponsors/delete/{sponsor}', [SponsorController::class, 'sponsor_delete'])->name('events.sponsor_delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    // Special Event Assign Sponsor
    Route::get('/event_sponsors/assign/{eid}', [SponsorController::class, 'sponsor_assign'])->name('events.sponsor_assign')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/event_sponsors/assign/{eid}', [SponsorController::class, 'sponsor_assign_store'])->name('events.sponsor_assign_store')->middleware(['auth:admin', 'xss', 'setlocate']);
    //*** END OF EVENT SPONSORS */


    //***EVENT TICKET COUPON LIST */
    Route::get('/event_ticket_coupon', [EventCouponListController::class, 'coupon_list'])->name('events.ticket.coupon.list')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/event_ticket_coupon/create', [EventCouponListController::class, 'coupon_create'])->name('events.ticket.coupon_create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/event_ticket_coupon/store', [EventCouponListController::class, 'coupon_store'])->name('events.ticket.coupon_store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/event_ticket_coupon/edit/{id}', [EventCouponListController::class, 'coupon_edit'])->name('events.ticket.coupon_edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/event_ticket_coupon/update/{id}', [EventCouponListController::class, 'coupon_update'])->name('events.ticket.coupon_update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/events_ticket_coupon/delete/{id}', [EventCouponListController::class, 'coupon_delete_view'])->name('events.ticket_coupon_delete_view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/event_ticket_coupon/delete/{id}', [EventCouponListController::class, 'coupon_delete'])->name('events.ticket.coupon_delete')->middleware(['auth:admin', 'xss', 'setlocate']);


    // Route for Ajax request to fetch event date
    Route::post('/get-event-date', [EventCouponListController::class, 'getEventDate'])->middleware(['auth:admin', 'xss', 'setlocate']);


    //*** TICKET ORDER LIST */
    Route::get('/ticket_order', [TicketOrderListController::class, 'ticket_order_list'])->name('events.ticket.order.list')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/ticket_order/create', [TicketOrderListController::class, 'ticket_order_create'])->name('events.ticket.order_create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/ticket_order/store', [TicketOrderListController::class, 'ticket_order_store'])->name('events.ticket.order_store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/ticket_order/edit/{id}', [TicketOrderListController::class, 'ticket_order_edit'])->name('events.ticket.order_edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/ticket_order/update/{id}', [TicketOrderListController::class, 'ticket_order_update'])->name('events.ticket.order_update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/ticket_order/delete/{id}', [TicketOrderListController::class, 'ticket_order_delete'])->name('events.ticket.order_delete')->middleware(['auth:admin', 'xss', 'setlocate']);

    //ticket mark
    Route::get('/ticket/mark', [TicketOrderListController::class, 'markView'])->name('ticket.mark')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/ticket/mark-ticket', [TicketOrderListController::class, 'mark'])->name('ticket.markTicket')->middleware(['auth:admin', 'xss', 'setlocate']);


    //*** TICKET OWNER ORDER LIST */
    Route::get('/ticket_owner', [TicketOwnerController::class, 'ticket_owner_list'])->name('events.ticket.owner.list')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/ticket_owner/create', [TicketOwnerController::class, 'ticket_owner_create'])->name('events.ticket.owner_create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/ticket_owner/store', [TicketOwnerController::class, 'ticket_owner_store'])->name('events.ticket.owner_store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/ticket_owner/edit/{id}', [TicketOwnerController::class, 'ticket_owner_edit'])->name('events.ticket.owner_edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/ticket_owner/update/{id}', [TicketOwnerController::class, 'ticket_owner_update'])->name('events.ticket.owner_update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/ticket_owner/delete/{id}', [TicketOwnerController::class, 'ticket_owner_delete'])->name('events.ticket.owner_delete')->middleware(['auth:admin', 'xss', 'setlocate']);


    //*** ARTISTS */
    Route::get('/artist', [artistController::class, 'artist_list'])->name('events.artist')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/artist/create', [artistController::class, 'add_artist'])->name('events.create_artist')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/artist/store', [artistController::class, 'store_artist'])->name('events.store_artist')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/artist/edit/{id}', [artistController::class, 'edit_artist'])->name('events.edit_artist')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/artist/update/{id}', [artistController::class, 'update_artist'])->name('events.update_artist')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/artist/delete/{id}', [artistController::class, 'delete_artist_view'])->name('events.delete_artist_view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/artist/delete/{id}', [artistController::class, 'delete_artist'])->name('events.delete_artist')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** TRANSACTIONS  */
    Route::get('/transaction', [TransactionController::class, 'transaction_list'])->name('events.transaction')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/transaction/show/{id}', [TransactionController::class, 'show'])->name('transaction.show')->middleware(['auth:admin', 'xss', 'setlocate']);


    //***  USERS */
    Route::get('/user_list', [AdminEventController::class, 'user_list'])->name('events.user_list')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/user_list/edit/{id}', [AdminEventController::class, 'edit_user'])->name('events.edit_user')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/user_list/update/{id}', [AdminEventController::class, 'update_user_status'])->name('events.update_user_status')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/user_list/report', [AdminEventController::class, 'user_report'])->name('events.report')->middleware(['auth:admin', 'xss', 'setlocate']); //***Route to generate users report **//


    Route::get('/dashboard', [AdminCmsController::class, 'index'])->name('dashboard')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/profile', [AdminCmsController::class, 'profile'])->name('profile')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/profile', [AdminCmsController::class, 'update_profile'])->name('profile.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/changepassword', [AdminCmsController::class, 'update_password'])->name('profile.changepassword')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employeeview', [EmployeeController::class, 'view'])->name('empviewdashboard')->middleware(['auth:admin', 'xss', 'setlocate']);
    // Route::delete('/orders/{order}', [OrderController::class, 'cancel'])->name('cancel.order')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** ITEM ORDER */
    Route::get('/order/create', [OrderController::class, 'create'])->name('order.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/create/{eid}', [OrderController::class, 'orderCreateByEvent'])->name('order.createByEvent')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/view', [OrderController::class, 'orderview'])->name('order.view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/cashflow/{order}', [OrderController::class, 'cashflow'])->name('order.cashflow')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/viewinvoice', [OrderController::class, 'invoice'])->name('order.invoiceOrder')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/viewQuotation', [OrderController::class, 'Quotation'])->name('order.quotationorder')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/orderitems/view/edit/{id}', [OrderController::class, 'editvieworderitems'])->name('order.vieworderitems.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/calendar', [OrderController::class, 'calendar'])->name('order.calendar')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/paymentorders', [OrderController::class, 'advanceorder'])->name('order.advanceorder')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/completeorder', [OrderController::class, 'completeorder'])->name('order.completeorder')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/expenses', [AdditionalExpenseController::class, 'viewExpenses'])->name('order.expense.view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('order/expenses/create/{id}', [AdditionalExpenseController::class, 'createExpenses'])->name('order.expenses.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('order/expenses/store', [AdditionalExpenseController::class, 'storeExpenses'])->name('order.expenses.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('order/expenses/edit/{id}', [AdditionalExpenseController::class, 'editExpenses'])->name('order.expenses.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('order/expenses/update/{id}', [AdditionalExpenseController::class, 'updateExpenses'])->name('order.expenses.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('order/expenses/delete/{id}', [AdditionalExpenseController::class, 'deleteExpenses'])->name('order.expenses.destroy')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/creditorder', [OrderController::class, 'creditorder'])->name('order.creditorder')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/creditorder/{order}', [OrderController::class, 'creditorderpayments'])->name('order.creditorderpayment')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('order/creditorder/{credit_order_id}', [OrderController::class, 'creditorderpaymentstore'])->name('order.creditorderpayment.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('order/creditorderView', [OrderController::class, 'creditorderPayemnetsView'])->name('order.creditorder.payments.view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/book', [OrderController::class, 'bookorder'])->name('order.bookorder')->middleware(['auth:admin', 'xss', 'setlocate']);
    //Route::delete('/deleteorderitem/{item_id}', [OrderController::class, 'itemdelete'])->name('orderitem.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/deleteorderitem/{item_id}', [OrderController::class, 'itemdelete'])->name('orderitem.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/{id}/invoice', [OrderController::class, 'generateInvoice'])->name('order.invoice')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/{id}/quatation', [OrderController::class, 'generatequotation'])->name('order.quotation')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/useradmin/order/cancel/{order}', [OrderController::class, 'cancelOrder'])->name('order.cancel')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/order/{id}/delete', [OrderController::class, 'deleteOrder'])->name('order.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/order/bookingorder/{id}', [OrderController::class, 'bookingOrderPaymentCreate'])->name('order.bookingpayment.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/order/bookingorder/{id}', [OrderController::class, 'bookingOrderPaymentStore'])->name('order.bookingPayment.store')->middleware(['auth:admin', 'xss', 'setlocate']);

    // Route for AJAX request to fetch customer details
    Route::post('/fetch-customer-details', [OrderController::class, 'fetchDetails'])->middleware(['auth:admin', 'xss', 'setlocate']);
    // Route for AJAX request to fetch event details
    Route::post('/fetch-event-details', [OrderController::class, 'fetchEventDetails'])->middleware(['auth:admin', 'xss', 'setlocate']);
    // Route for Ajax request to fetch order details to display calender
    Route::get('/order-details/{orderId}', [OrderController::class, 'getOrderDetails'])->name('order.details')->middleware(['auth:admin', 'xss', 'setlocate']);
    // Route for Ajax update or add item description in order
    Route::post('/update/descriptions', [OrderController::class, 'updateDescription'])->name('item.updateDescription')->middleware(['auth:admin', 'xss', 'setlocate']);

    Route::get('/order/event/create', [OrderController::class, 'createEventOrder'])->name('order.event.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/order/event/store', [OrderController::class, 'storeEventOrder'])->name('order.event.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/parse/event/details', [CustomerRequirementController::class, 'parseEventDetails'])->name('event.requirement.parse')->middleware(['auth:admin', 'xss', 'setlocate']);


    //*** CUSTOMER CRUD */
    Route::delete('/viewcustomer/{id}', [CustomerController::class, 'delete'])->name('customer.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/editcustomer/{customer_id}', [CustomerController::class, 'edit'])->name('customer.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/customerupdates/{customer_id}', [CustomerController::class, 'updates'])->name('customer.updates')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/viewcustomer', [CustomerController::class, 'viewcustomer'])->name('viewcustomer')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/customer/create', [CustomerController::class, 'store'])->name('customer.store')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** CUSTOMER REQUIREMENT ROUTES */
    Route::get('/customer/requirement', [CustomerRequirementController::class, 'customerRequirement'])->name('customer.requirement')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/customer/requirement/create', [CustomerRequirementController::class, 'customerRequirementCreate'])->name('customer.requirement.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/customer/requirement/create', [CustomerRequirementController::class, 'customerRequirementStore'])->name('customer.requirement.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/customer/requirement/edit/{customer_requirement}', [CustomerRequirementController::class, 'customerRequirementEdit'])->name('customer.requirement.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/customer/requirement/update/{customer_requirement}', [CustomerRequirementController::class, 'customerRequirementUpdate'])->name('customer.requirement.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/customer/requirement/delete/{id}', [CustomerRequirementController::class, 'customerRequirementDelete'])->name('customer.requirement.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/parse-customer-details', [CustomerRequirementController::class, 'parseCustomerDetails'])->name('customer.requirement.parse')->middleware(['auth:admin', 'xss', 'setlocate']);

    //***  EMPLOYEE CRUD */
    Route::delete('/viewemp/{id}', [EmployeeController::class, 'delete'])->name('emp.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/editemployee/{emp_id}', [EmployeeController::class, 'edit'])->name('emp.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/employeeupdates/{id}', [EmployeeController::class, 'updates'])->name('emp.updates')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/viewemp', [EmployeeController::class, 'viewemp'])->name('viewemployee')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/create', [EmployeeController::class, 'create'])->name('emp.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/employee/create', [EmployeeController::class, 'empstore'])->name('emp.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    // Check emloyee name
    Route::post('/checkempname', [EmployeeController::class, 'check_emp_name'])->name('emp.checkempname')->middleware(['auth:admin', 'xss', 'setlocate']);
    // Check emloyee email
    Route::post('/checkempemail', [EmployeeController::class, 'check_emp_email'])->name('emp.checkempemail')->middleware(['auth:admin', 'xss', 'setlocate']);

    //***EVENTS TEAM LIST */
    Route::get('/team', [TeamController::class, 'team_list'])->name('events.team')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/team/create', [TeamController::class, 'add_team'])->name('events.create_team')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/team/get-members-by-category', [TeamController::class, 'getMembersByCategory'])->name('get.members.by.category')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/team/get-member-details', [TeamController::class, 'getMemberDetails'])->name('get.member.details')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/team/store', [TeamController::class, 'store_team'])->name('events.team.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/team/{team_id}/edit', [TeamController::class, 'edit'])->name('events.edit_team')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/team/{team_id}/delete', [TeamController::class, 'destroy'])->name('events.delete_team')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/team/{team_id}/update', [TeamController::class, 'update_team'])->name('events.team.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/team/create_name', [TeamController::class, 'create_team_name'])->name('events.create_team_name')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/team/team_name/store', [TeamController::class, 'store_team_name'])->name('events.team_category.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/teams/check-team-name', [TeamController::class, 'checkTeamName'])->name('events.teams.checkTeamName')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/team/get-teams-name', [TeamController::class, 'getTeamsName'])->name('get.teams.name')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/team/member/delete/{id}', [TeamController::class, 'destroyMember'])->name('events.delete_member')->middleware(['auth:admin', 'xss', 'setlocate']);


    //*** MANAGER CRUD */
    Route::get('/viewman', [ManagerController::class, 'viewman'])->name('viewmanager')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/manager/create', [ManagerController::class, 'manstore'])->name('man.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/manager/create', [ManagerController::class, 'create'])->name('man.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    // Check manager name
    Route::post('/checkmanname', [ManagerController::class, 'check_man_name'])->name('man.checkmanname')->middleware(['auth:admin', 'xss', 'setlocate']);
    // Check manager email
    Route::post('/checkmanemail', [ManagerController::class, 'check_man_email'])->name('man.checkmanemail')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/editmanager/{manager_id}', [ManagerController::class, 'edit'])->name('man.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/managerupdates/{id}', [ManagerController::class, 'updates'])->name('man.updates')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/viewman/{id}', [ManagerController::class, 'delete'])->name('man.delete')->middleware(['auth:admin', 'xss', 'setlocate']);


    Route::get('/manager/add', [ManagerController::class, 'add'])->name('man.add')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/manager/add', [ManagerController::class, 'manadd'])->name('man.addMan')->middleware(['auth:admin', 'xss', 'setlocate']);


    //***EMPLOYEE SALARY AND OTHER ROUTES***//
    Route::get('/viewemp_salary', [EmployeeController::class, 'emp_salary_view'])->name('emp.salaryview')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/salary/create', [EmployeeController::class, 'emp_salary_create'])->name('emp.salary.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/employee/salary/store', [EmployeeController::class, 'emp_salary_store'])->name('emp.salary.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/salary/edit/{id}', [EmployeeController::class, 'emp_salary_edit'])->name('emp.salary.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/employee/salary/update', [EmployeeController::class, 'emp_salary_update'])->name('emp.salary.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/employee/salary/delete/{id}', [EmployeeController::class, 'emp_salary_delete'])->name('emp.salary.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/salary/get-credit-amount', [EmployeeController::class, 'emp_Credits'])->name('emp.salary.get-credit-amount')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** EVENTBASE SALARY ROUTES */
    Route::get('/viewevent_base_salary', [EventsController::class, 'event_salary_view'])->name('event.base.salaryview')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/get-event-base-salary-data/{event_id}', [EventsController::class, 'getEventBaseSalaryData'])->name('event.base.salarydata')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/generate/event-base-salary-pdf/{event_id}', [PdfController::class, 'generateEventBaseSalaryPDF'])->name('event.base.salary.pdf')->middleware(['auth:admin', 'xss', 'setlocate']);

    //***EMPLOYEE SALARY_PAYMENTS ROUTES***//
    Route::get('/viewemp_payments', [EmployeeController::class, 'emp_salary_payments_view'])->name('emp.salary_pauments_view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/salary/payment/create', [EmployeeController::class, 'emp_salary_payment_create'])->name('emp.salary.payment.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/employee/salary/payment/store', [EmployeeController::class, 'emp_salary_payment_store'])->name('emp.salary.payment.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/salary/payment/edit/{id}', [EmployeeController::class, 'emp_salary_payment_edit'])->name('emp.salary.payment.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/employee/salary/payment/update', [EmployeeController::class, 'emp_salary_payment_update'])->name('emp.salary.payment.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/employee/salary/payment/delete/{id}', [EmployeeController::class, 'emp_salary_payment_delete'])->name('emp.salary.payment.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/salary/get-employee-details', [EmployeeController::class, 'getEmployeeDetails'])->name('emp.salary.get-employee-details')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** EMPLOYEE CREDITS */
    Route::get('/viewemp_credits', [EmployeeCreditController::class, 'empCreditsView'])->name('emp.credits.view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/credit/create', [EmployeeCreditController::class, 'empCreditsCreate'])->name('emp.credits.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/employee/credit/store', [EmployeeCreditController::class, 'empCreditsStore'])->name('emp.credits.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/credit/edit/{id}', [EmployeeCreditController::class, 'empCreditsEdit'])->name('emp.credits.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/employee/credit/update', [EmployeeCreditController::class, 'empCreditsUpdate'])->name('emp.credits.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/employee/credit/delete/{id}', [EmployeeCreditController::class, 'empCreditsDelete'])->name('emp.credits.delete')->middleware(['auth:admin', 'xss', 'setlocate']);

    //***EMPLOYEE JOB_AMOUNT ROUTES***//

    Route::get('/viewemp_job_amount', [EmployeeController::class, 'emp_job_amount_view'])->name('emp.job.amount.view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/jobamount/create', [EmployeeController::class, 'JobAmountCreate'])->name('emp.job.amount.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/jobamount/create/{eventId}', [EmployeeController::class, 'jobAmountCreateEvent'])->name('emp.job.amount.event.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/job_amount_create/{orderId}', [EmployeeController::class, 'getJobAmounts'])->name('employee.job_amount_create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/employee/jobamount/store', [EmployeeController::class, 'jobAmountStore'])->name('emp.job.amount.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/jobamount/edit/{id}', [EmployeeController::class, 'jobAmountEdit'])->name('emp.job.amount.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/employee/jobamount/update', [EmployeeController::class, 'jobAmountUpdate'])->name('emp.job.amount.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/employee/jobamount/delete/{id}', [EmployeeController::class, 'jobAmountDelete'])->name('emp.job.amount.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/event/orders/{event_id}', [OrderController::class, 'getOrdersByEventId'])->name('event.orders')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/jobamount/filter', [EmployeeController::class, 'filterJobAmount'])->name('emp.job.amount.filter')->middleware(['auth:admin', 'xss', 'setlocate']); //*** Route to job filter in job amount view. *** //

    //*** EMPLOYEE VACATIONS ROUTES */
    Route::get('/employee/vacations', [VacationController::class, 'vacationView'])->name('vacations')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/employee/vacations/{vacation}/edit', [VacationController::class, 'edit'])->name('vacations.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/employee/vacations/{vacation}', [VacationController::class, 'update'])->name('vacations.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/employee/vacations/{vacation}', [VacationController::class, 'destroy'])->name('vacations.destroy')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** ITEM RELATED ROUTES ***//
    Route::get('/viewitem', [ItemController::class, 'viewitem'])->name('stockitem.view')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL ITEMS IN THE SYSTEM ***//
    Route::get('/additem', [ItemController::class, 'additemform'])->name('stockitem.addform')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DISPLAY ADD ITEM FORM ***//
    Route::post('/additem', [ItemController::class, 'additem'])->name('stockitem.add')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO ADD NEW ITEMS TO THE SYSTEM ***//
    Route::get('/edititem/{id}', [ItemController::class, 'edititem'])->name('stockitem.edit')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO EDIT ITEMS IN THE SYSTEM ***//
    Route::put('/edititem/{id}', [ItemController::class, 'updateitem'])->name('stockitem.update')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO UPDATE ITEMS IN THE DATABASE ***//
    Route::delete('/deleteitem/{id}', [ItemController::class, 'deleteitem'])->name('stockitem.delete')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DELETE ITEMS IN THE SYSTEM ***//
    //*** END OF ITEM RELATED ROUTES ***//

    //*** ITEM CATEGORY RELATED ROUTES */
    Route::get('/viewcategory', [ItemCategoryController::class, 'viewCategory'])->name('stockcategory.view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/additem/category', [ItemCategoryController::class, 'addCategory'])->name('stockcategory.addform')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/store/category', [ItemCategoryController::class, 'storeCategory'])->name('stockcategory.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/edititem/category/{id}', [ItemCategoryController::class, 'editCategory'])->name('stockcategory.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/updateitem/category/{id}', [ItemCategoryController::class, 'updateCategory'])->name('stockcategory.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/delete/item/category/{id}', [ItemCategoryController::class, 'deleteCategory'])->name('stockcategory.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    //*** END OF ITEM CATEGORY RELATED ROUTES */

    //*** RENT ITEM RELATED ROUTES ***//
    Route::get('/send', [RentItemController::class, 'sendhistory'])->name('send.history')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/send/create', [RentItemController::class, 'senditemform'])->name('send.form')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DISPLAY SEND ITEM FORM ***//
    Route::get('/send/{rent}/edit', [RentItemController::class, 'editrentitems'])->name('send.edit')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO EDIT RENT ITEMS ***//
    Route::put('/send/{rent}/edit', [RentItemController::class, 'updaterentitems'])->name('send.update')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO UPDATE RENT ITEMS ***//
    Route::delete('/send/{rent}', [RentItemController::class, 'deleterentitems'])->name('send.delete')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DELETE RENT ITEMS ***//

    Route::post('/finditems/{order_id}', [RentItemController::class, 'findorderitems'])->name('findorderitems')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO FIND ALL ORDER ITEMS FOR A SPECIFIC ORDER ***//
    Route::post('/saverentitems', [RentItemController::class, 'saverentitems'])->name('saverentitems')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO SAVE RENT ITEMS TO THE DATABASE ***//
    Route::put('/update/{id}', [RentItemController::class, 'receiveitems'])->name('rent.update')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO UPDATE RECEIVED ITEMS ***//
    Route::get('/viewrent', [RentItemController::class, 'viewrent'])->name('rent.view')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL RENT DATA ***//
    Route::get('/viewrent/update', [RentItemController::class, 'viewrentupdate'])->name('rent.update.view')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL RENT EMPLOYEE UPDATES ***//
    Route::get('/viewrent/{id}', [RentItemController::class, 'viewrentitems'])->name('rent.edit')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL RENT ITEMS FOR A SPECIFIC RENT ***//
    Route::get('/viewprevious', [RentItemController::class, 'viewpreviousrent'])->name('rent.history')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL PREVIOUS RENT DATA ***//
    Route::get('/viewprevious/{id}', [RentItemController::class, 'viewpreviousrentitems'])->name('rent.history.view')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL RENT ITEMS FOR A SPECIFIC PREVIOUS RENT ***//

    // Ajax Routes for get rent_item_packages and Order that belongs to the selected event
    Route::get('/get_rent_item_packages_and_orders/{eventId}', [RentItemController::class, 'getRentItemPackagesAndOrders'])->name('getrentitempackages')->middleware(['xss', 'setlocate']);
    // Ajax Route for get rent__item_package_items that belongs to the selected rent_item_package
    Route::get('/get_rent_item_package/items/{id}', [RentItemController::class, 'getRentItemPackageItems'])->name('getrentitempackageitems')->middleware(['xss', 'setlocate']);
    //*** END OF RENT ITEM RELATED ROUTES ***/

    //*** ROUTES THE GALLERY */
    Route::get('/viewgallery', [GalleryController::class, 'viewgallery'])->name('gallery.view')->middleware(['auth:admin', 'xss', 'setlocate']); //gallery view
    Route::get('/albumview/{id}', [GalleryController::class, 'album_view'])->name('gallery.albumview')->middleware(['auth:admin', 'xss', 'setlocate']); //album view
    Route::get('/addgallery/{id}', [GalleryController::class, 'addgallery'])->name('gallery.create')->middleware(['auth:admin', 'xss', 'setlocate']); //galery model view
    Route::get('/addalbum', [GalleryController::class, 'addalbum'])->name('album.create')->middleware(['auth:admin', 'xss', 'setlocate']); //Album Model view

    Route::post('/addgallery', [GalleryController::class, 'store'])->name('gallery.store')->middleware(['auth:admin', 'xss', 'setlocate']); //Gallery Store
    Route::post('/addalbumstore', [GalleryController::class, 'albumstore'])->name('album.albumstore')->middleware(['auth:admin', 'xss', 'setlocate']); //Album Store

    Route::get('/deletegallery/{id}', [GalleryController::class, 'deletegallery'])->name('gallery.delete')->middleware(['auth:admin', 'xss', 'setlocate']); //Gallery Delete
    Route::get('/deletealbum/{id}', [GalleryController::class, 'deletealbum'])->name('album.delete')->middleware(['auth:admin', 'xss', 'setlocate']); //Gallery Delete

    //*** RENT ITEM RELATED ROUTES ***//
    Route::get('/allmissingitems', [RentItemController::class, 'viewmissingitems'])->name('rent.missing')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL MISSING ITEMS ***//
    Route::get('/allmissingitems/{id}', [RentItemController::class, 'editmissingdetails'])->name('missing.edit')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO EDIT MISSING ITEM DATA FOR A SPECIFIC RENT ***//
    Route::put('/updatemissing/{id}', [RentItemController::class, 'updatemissing'])->name('missing.update')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO UPDATE MISSING ITEM DATA IN DB ***//

    // *** Damage Item Related Routes *** //
    Route::get('/damageitems', [DamageItemController::class, 'damageItems'])->name('rent.damage')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL DAMAGE ITEMS ***//
    Route::get('/damageitems/{id}', [DamageItemController::class, 'editDamageItem'])->name('rent.damage.view')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO EDIT DAMAGE ITEM DATA FOR A SPECIFIC RENT ***//
    Route::put('/damageitems/update', [DamageItemController::class, 'updateDamageItem'])->name('damageitem.update')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO UPDATE DAMAGE ITEM DATA IN DB ***//

    Route::get('/check-item-quantity/{itemId}', [RentItemController::class, 'checkAvailability']);
    Route::get('/check-item-quantity/total-quantity/{itemId}', [RentItemController::class, 'checkTotalQuantityAvailability'])->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** END OF RENT ITEM RELATED ROUTES ***//

    //*** PREDEFINED PACKAGES RELATED ROUTES ***//
    Route::get('/viewpredefined', [PredefinedPackageController::class, 'newpackage'])->name('predefined')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DISPLAY PREDEFINED PACKAGES***//
    Route::post('/createpredefined', [PredefinedPackageController::class, 'savepackage'])->name('savepredefined')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO SAVE PREDEFINED PACKAGES***//
    Route::get('/viewallpredefined', [PredefinedPackageController::class, 'allpredefined'])->name('predefined.all')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL PREDEFINED PACKAGES***//
    Route::get('/categories', [PredefinedPackageController::class, 'categories'])->name('predefined.categories')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL PREDEFINED PACKAGE CATEGORIES***//
    Route::get('/addcategory', [PredefinedPackageController::class, 'addcategory'])->name('add.package.category')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO ADD NEW PACKAGE CATEGORY***//
    Route::post('/storecategory', [PredefinedPackageController::class, 'storecategory'])->name('store.package.category')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO SAVE PACKAGE CATEGORY***//
    Route::get('/editcategory/{id}', [PredefinedPackageController::class, 'editcategory'])->name('edit.package.category')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO EDIT PACKAGE CATEGORY***//
    Route::put('/updatecategory/{id}', [PredefinedPackageController::class, 'updatecategory'])->name('update.package.category')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO UPDATE PACKAGE CATEGORY***//
    Route::delete('/deletecategory/{id}', [PredefinedPackageController::class, 'deletecategory'])->name('delete.package.category')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DELETE PACKAGE CATEGORY***//
    Route::get('/editpredefined/{id}', [PredefinedPackageController::class, 'editpredefined'])->name('predefined.edit')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO EDIT PREDEFINED PACKAGES***//
    Route::put('/updatepredefined/{id}', [PredefinedPackageController::class, 'updatepredefined'])->name('predefined.update')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO UPDATE & SAVE PREDEFINED PACKAGES***//
    Route::delete('/deletepredefined/{id}', [PredefinedPackageController::class, 'deletepredefined'])->name('predefined.delete')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DELETE PREDEFINED PACKAGES***//
    Route::post('/deletepredefineditem', [PredefinedPackageController::class, 'deletepredefineditem'])->name('removeitemfrompackage')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DELETE PREDEFINED PACKAGE ITEM***//
    Route::get('/predefinedpackageitems', [PredefinedPackageController::class, 'predefinedpackageitems'])->name('getpredefinedpackageitems')->middleware(['xss', 'setlocate']);  //*** ROUTE TO GET ALL PREDEFINED PACKAGE ITEMS***//
    Route::get('/predefinedpackageitems/order', [PredefinedPackageController::class, 'orderPredefinedPackage'])->name('getpredefinedpackageitems.order')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/check-predefinedpackage-name', [PredefinedPackageController::class, 'checkPackageName'])->name('checkPackageName')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/check-predefinedpackage-edit-name', [PredefinedPackageController::class, 'checkpackagenameedit'])->name('checkPackageName')->middleware(['auth:admin', 'xss', 'setlocate']);


    //*** END OF PREDEFINED PACKAGES RELATED ROUTES ***//

    //*** PDF GENERATION ***/
    Route::get('/generate-pdf/{id}', [PdfController::class, 'generatePdf'])->name('generatePdf')->middleware(['auth:admin', 'xss', 'setlocate']);
    //*** MISSING ITEMS VIEW PDF */
    Route::get('/allmissingitems/pdf/{id}', [PdfController::class, 'generateMissingPdf'])->name('generateMissingPdf')->middleware(['auth:admin', 'xss', 'setlocate']);
    //*** Request for Rent Item View PDF
    Route::get('/generate-viewpdf/{id}', [PdfController::class, 'generateViewPdf'])->name('generateViewPdf')->middleware(['auth:admin', 'xss', 'setlocate']);
    //** Generate payment confirmation pdf */
    Route::get('/confirmation/pdf/{id}', [PdfController::class, 'generatePaymentPdf'])->name('generatePaymentPdf')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** PACKAGE RELATED ROUTES ***/
    Route::get('/viewpackage', [PackageController::class, 'newpackage'])->name('package')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DISPLAY PACKAGES***//
    Route::post('/createpackage', [PackageController::class, 'savepackage'])->name('savepackage')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO SAVE PACKAGES***//
    Route::get('/viewallpackages', [PackageController::class, 'allpackages'])->name('package.all')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL PACKAGES***//
    Route::get('/editpackage/{id}', [PackageController::class, 'editpackage'])->name('package.edit')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO EDIT PACKAGES***//
    Route::put('/updatepackage/{id}', [PackageController::class, 'updatepackage'])->name('package.update')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO UPDATE & SAVE PACKAGES***//
    Route::delete('/deletepackage/{id}', [PackageController::class, 'deletepackage'])->name('package.delete')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DELETE PACKAGES***//
    Route::post('/deletepackageitem', [PackageController::class, 'deletepackageitem'])->name('removefrompackage')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DELETE PACKAGE ITEM***//
    Route::get('/packageitems', [PackageController::class, 'packageitems'])->name('getpackageitems')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO GET ALL PACKAGE ITEMS***//
    Route::post('/check-package-name', [PackageController::class, 'checkPackageName'])->name('checkPackageName')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/check-package-edit-name', [PackageController::class, 'checkPackageNameEdit'])->name('checkPackageNameEdit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/searchpackage', [PackageController::class, 'searchpackage'])->name('package.search')->middleware(['auth:admin', 'xss', 'setlocate']);//**Route to serch and catergory function. **//

    //*** END OF PACKAGE RELATED ROUTES ***//

    //*** PACKAGE IMAGE RELATED ROUTES */
    Route::get('/package/images/{id}', [PackageImageController::class, 'packageImages'])->name('package.images')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/package/images/create/{id}', [PackageImageController::class, 'createPackageImages'])->name('package.images.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/package/images/store', [PackageImageController::class, 'storePackageImages'])->name('package.images.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/package/images/delete/{id}', [PackageImageController::class, 'deletePackageImage'])->name('package.images.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    //*** END OF PACKAGE IMAGE RELATED ROUTES */

    //*** EVENTS RELATED ROUTES ***//
    Route::get('/events', [EventsController::class, 'viewEvents'])->name('events.view')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL EVENTS ***//
    Route::get('/events/add', [EventsController::class, 'addEventForm'])->name('events.addform')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DISPLAY ADD EVENT FORM ***//
    Route::post('/events', [EventsController::class, 'storeEvent'])->name('events.store')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO ADD NEW EVENT TO THE SYSTEM ***//
    Route::get('/events/{event}', [EventsController::class, 'editEvent'])->name('events.edit')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO EDIT EVENTS IN THE SYSTEM ***//
    Route::put('/events/{event}', [EventsController::class, 'updateEvent'])->name('events.update')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO UPDATE EVENT IN THE SYSTEM ***//
    Route::delete('/events/{event}', [EventsController::class, 'deleteEvent'])->name('events.delete')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DELETE EVENT IN THE SYSTEM ***//
    //*** END OF EVENTS RELATED ROUTES ***//

    //*** UPDATE HISTORY ***//
    Route::get('/viewupdatehistory', [ItemController::class, 'ViewUpdateHistory'])->name('updatehistory.view')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL ITEM UPDATE HISTORY ***//
    //*** END OF UPDATE HISTORY ***//

    //*** SUPPLIER RELATED ROUTES ***//
    Route::get('/addsupplier', [SupplierController::class, 'addsupplierform'])->name('supplier.addform')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DISPLAY ADD SUPPLIER FORM ***//
    Route::post('/addsupplier', [SupplierController::class, 'addsupplier'])->name('supplier.add')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO ADD NEW SUPPLIER TO THE SYSTEM ***//
    Route::get('/viewsupplier', [SupplierController::class, 'viewsupplier'])->name('supplier.view')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL SUPPLIERS IN THE SYSTEM ***//
    Route::get('/editsupplier/{id}', [SupplierController::class, 'editsupplier'])->name('supplier.edit')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO EDIT SUPPLIERS IN THE SYSTEM ***//
    Route::put('/updatesupplier', [SupplierController::class, 'updatesupplier'])->name('supplier.update')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO UPDATE SUPPLIERS IN THE SYSTEM ***//
    Route::delete('/deletesupplier/{id}', [SupplierController::class, 'deletesupplier'])->name('supplier.delete')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DELETE SUPPLIERS IN THE SYSTEM ***//
    Route::get('/supplier/{id}', [SupplierController::class, 'getsupplier'])->name('supplier.credits')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW SINGLE SUPPLIER IN THE SYSTEM ***//
    Route::put('/updatesuppliercredits', [SupplierController::class, 'updatesuppliercredits'])->name('supplier.credit.update')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW SINGLE SUPPLIER CREDITS IN THE SYSTEM ***//
    //*** END OF SUPPLIER RELATED ROUTES ***//

    //*** PURCHASE ORDER RELATED ROUTES ***//
    Route::get('/viewpurchaseorder', [PurchaseOrderController::class, 'viewpurchaseorder'])->name('purchaseorder.view')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL PURCHASE ORDERS ***//
    Route::get('/addpurchaseorder', [PurchaseOrderController::class, 'addpurchaseorderform'])->name('purchaseorder.addform')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO DISPLAY ADD PURCHASE ORDER FORM ***//
    Route::post('/addpurchaseorder', [PurchaseOrderController::class, 'addpurchaseorder'])->name('purchaseorder.add')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO ADD NEW PURCHASE ORDER TO THE SYSTEM ***//
    Route::get('/viewpurchaseorder/{id}', [PurchaseOrderController::class, 'purchaseorderdetails'])->name('purchaseorder.details')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW SINGLE PURCHASE ORDER IN THE SYSTEM ***//
    //*** END OF PURCHASE ORDER RELATED ROUTES ***//

    //*** SUBSCRIBER RELATED ROUTES ***/
    Route::get('/viewsubscribers', [SubscriptionController::class, 'viewsubscribers'])->name('subscribers.view')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL SUBSCRIBERS ***//
    //*** END OF SUBSCRIBER RELATED ROUTES ***/

    //***MANUAL EXPENSES & INCOME  RELATED ROUTES ***//
    Route::get('/manual-expenses-income/view', [ManualExpensesIncomeController::class, 'viewmanualexpensesincome'])->name('manual.expenses.income.view')->middleware(['auth:admin', 'xss', 'setlocate']);  //*** ROUTE TO VIEW ALL CASH FLOW ***//
    Route::delete('/ manualExpensesIncome/{id}', [ManualExpensesIncomeController::class, 'destroy'])->name('manual.expenses.income.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/editManualExpensesIncome/{manualExpensesIncome}', [ManualExpensesIncomeController::class, 'edit'])->name('manual.expenses.income.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/manualExpensesIncomeupdate/{id}', [ManualExpensesIncomeController::class, 'update'])->name('manual.expenses.income.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/manualIncomeExpenses/create', [ManualExpensesIncomeController::class, 'create'])->name('manual.expenses.income.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/manualIncomeExpenses/create', [ManualExpensesIncomeController::class, 'store'])->name('manual.expenses.income.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    //*** END OF MANUAL EXPENSES & INCOME  RELATED ROUTES ***//

    //*** CASH FLOW RELATED ROUTES ***//
    Route::post('/cashflow/create', [CashFlowController::class, 'store'])->name('cashflow.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/cashflow/manage', [CashFlowController::class, 'index'])->name('cashflow.manage')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/cashflow/{id}', [CashFlowController::class, 'destroy'])->name('cashflow.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/cashflow/search', [CashFlowController::class, 'search'])->name('cashflow.search')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/cashflow/view', [CashFlowController::class, 'viewCashFlows'])->name('cashflow.view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/cash-flow/search/result', [CashFlowController::class, 'filter'])->name('cashflow.search.result')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/cash-flow/download', [CashFlowController::class, 'downloadCashFlows'])->name('cashflow.download')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/cash-flow/logs', [CashFlowController::class, 'viewCashFlowLogs'])->name('cashflow.logs')->middleware(['auth:admin', 'xss', 'setlocate']);
    //*** END OF CASH FLOW RELATED ROUTES ***//

    //*** TASK MANAGEMENT RELATED ROUTES ***//
    Route::get('/taskmanage', [TaskManagementController::class, 'showTaskManagement'])->name('taskmanage.show')->middleware(['auth:admin', 'xss', 'setlocate']);
    //*** END OF TASK MANAGEMENT RELATED ROUTES ***//


    // SEO Cp
    Route::get('/SEO', [SEOController::class, 'showSEO'])->name('seo.show')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/SEO/save', [SEOController::class, 'saveDetails'])->name('seo.save')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/SEO/home', [SEOController::class, 'home'])->name('seo.home')->middleware(['auth:admin', 'xss', 'setlocate']);

    Route::get('/SEO/packages', [SEOController::class, 'packages'])->name('seo.packages')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/SEO/contact', [SEOController::class, 'contact'])->name(name: 'seo.contact')->middleware(['auth:admin', 'xss', 'setlocate']);


    Route::post('/SEO/images/alt/save', [SEOController::class, 'saveImageAlt'])->name('seo.images.alt.save')->middleware(['auth:admin', 'xss', 'setlocate']);


    //** BANKS ACCOUNT RELATED ROUTES *****/
    Route::get('/bank_accounts/create', [BankAccountController::class, 'create'])->name('bank_accounts.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/bank_accounts', [BankAccountController::class, 'store'])->name('bank_accounts.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/bank_accounts/{bankAccount}/edit', [BankAccountController::class, 'edit'])->name('bank_accounts.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/bank_accounts/{bankAccount}', [BankAccountController::class, 'update'])->name('bank_accounts.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/bank_accounts/{bankAccount}', [BankAccountController::class, 'destroy'])->name('bank_accounts.destroy')->middleware(['auth:admin', 'xss', 'setlocate']);

    //** EVENT RENT PACKAGES RELATED ROUTES */
    Route::get('/event_rent_packages', [RentItemPackageController::class, 'index'])->name('event_rent_packages.index')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/event_rent_packages/create', [RentItemPackageController::class, 'create'])->name('event_rent_packages.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/event_rent_packages', [RentItemPackageController::class, 'store'])->name('event_rent_packages.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/event_rent_packages/{rentItemPackage}/edit', [RentItemPackageController::class, 'edit'])->name('event_rent_packages.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/event_rent_packages/{rentItemPackage}', [RentItemPackageController::class, 'update'])->name('event_rent_packages.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/event_rent_packages/{rentItemPackage}', [RentItemPackageController::class, 'destroy'])->name('event_rent_packages.destroy')->middleware(['auth:admin', 'xss', 'setlocate']);

    //** CALENDER THROUGH EVENT RENT PACKAGES CREATION */
    Route::get('/event_rent_packages/add/{event}', [RentItemPackageController::class, 'eventCreate'])->name('event_rent_packages.eventCreate')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/event_rent_packages/eventEdit/{rentItemPackage}/{event}', [RentItemPackageController::class, 'eventEdit'])->name('event_rent_packages.eventEdit')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** terms and conditions router ***/
    Route::get('/viewTermsAndConditions', [TermsAndConditionsController::class, 'viewTermsAndConditions'])->name('viewTermsAndConditions')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/viewTermsAndConditionsedit/{id}', [TermsAndConditionsController::class, 'edit'])->name('termsAndConditions.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/viewTermsAndConditions/{id}', [TermsAndConditionsController::class, 'delete'])->name('termsAndConditions.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/viewTermsAndConditionsupdate/{id}', [TermsAndConditionsController::class, 'updates'])->name('termsAndConditions.updates')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/viewTermsAndCondition/create', [TermsAndConditionsController::class, 'create'])->name('termsAndConditions.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/viewTermsAndConditions/create', [TermsAndConditionsController::class, 'store'])->name('termsAndConditions.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/terms/update/{id}', [TermsAndConditionsController::class, 'updates'])->name('terms.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    //*** End Of Terms and conditions router ***/

    //*** PERMISSIONS ROUTES */
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware(['auth:admin', 'xss', 'setlocate']);
    //*** END OF PERMISSIONS ROUTES */

    //*** ASSIGN PERMISSIONS TO EMPLOYEES ROUTES */
    Route::get('/assign-permissions/{emp_id}/create', [EmployeePermissionController::class, 'create'])->name('assign-permissions.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/assign-permissions', [EmployeePermissionController::class, 'store'])->name('assign-permissions.store')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** AGREEMENT  CATEGORIES ROUTES */
    Route::get('/agreement_categories', [AgreementCategoryController::class, 'index'])->name('agreement_categories.index')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agreement_categories/create', [AgreementCategoryController::class, 'create'])->name('agreement_categories.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/agreement_categories', [AgreementCategoryController::class, 'store'])->name('agreement_categories.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agreement_categories/{agreementCategory}/edit', [AgreementCategoryController::class, 'edit'])->name('agreement_categories.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/agreement_categories/{agreementCategory}', [AgreementCategoryController::class, 'update'])->name('agreement_categories.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/agreement_categories/{agreementCategory}', [AgreementCategoryController::class, 'destroy'])->name('agreement_categories.destroy')->middleware(['auth:admin', 'xss', 'setlocate']);

    //***AGREEMENT ROUTES***//
    Route::get('/agreements', [AgreementController::class, 'index_records_employees'])->name('show_agreement_employee')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agreements/create', [AgreementController::class, 'create_agreement'])->name('agreement.view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/agreements', [AgreementController::class, 'store_agreement'])->name('agreement.store_create_agreement')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agreements/{agreement}/edit', [AgreementController::class, 'edit'])->name('agreement.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/agreements/{agreement}', [AgreementController::class, 'update'])->name('agreement.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agreements/generate/{id}', [PdfController::class, 'generateAgreement'])->name('agreement.generate_agreement')->middleware(['auth:admin', 'xss', 'setlocate']);

    //** AGREEMENT TEMPLATES ROUTES **/
    Route::get('/agreement_templates', [AgreementTemplateController::class, 'index'])->name('agreement_templates.index')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agreement_templates/create', [AgreementTemplateController::class, 'create'])->name('agreement_templates.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/agreement_templates', [AgreementTemplateController::class, 'store'])->name('agreement_templates.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agreement_templates/{agreementTemplate}/edit', [AgreementTemplateController::class, 'edit'])->name('agreement_templates.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/agreement_templates/{agreementTemplate}', [AgreementTemplateController::class, 'update'])->name('agreement_templates.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/agreement_templates/{agreementTemplate}', [AgreementTemplateController::class, 'destroy'])->name('agreement_templates.destroy')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** AGREEMENT EMPLOYEE RELATED ROUTES ***//
    Route::get('/agreements/records/events', [AgreementController::class, 'index_records_events'])->name('show_agreement_event')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agreements/create/event', [AgreementController::class, 'create_agreement_event'])->name('agreement.view_event')->middleware(['auth:admin', 'xss', 'setlocate']);
    // Route::get('/agreements/create-event', [AgreementController::class, 'create_agreement_event'])->name('agreements.create_event')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/agreements/store-event', [AgreementController::class, 'store_agreement_event'])->name('agreements.store_event')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agreements/{agreement}/edit/event', [AgreementController::class, 'edit_agreement_event'])->name('agreement.edit_event')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/agreements/{agreement}/update/event', [AgreementController::class, 'update_agreement_event'])->name('agreement.update_event')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agreements/generate/event/pdf/download/{id}', [PdfController::class, 'generateAgreementEvent'])->name('agreement.generate_event_agreement')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agreements/generate/event/{eid}', [AgreementController::class, 'generateAgreementEvent'])->name('agreement.generate_event')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/agreements/generate/event/{agreement}/edit', [AgreementController::class, 'generateAgreementEdit'])->name('agreement.generate_event_edit')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** EQUIPMENT INVESTMENT ROUTES */
    Route::get('/equipment/investment', [EquipmentInvestmentController::class, 'index'])->name('equipment.investment')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/equipment/calculate-roi', [EquipmentInvestmentController::class, 'calculateROI'])->name('equipment.calculate.roi')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** EQUIPMENT WASTAGE ROUTES   */
    Route::get('/equipment/wastage', [EquipmentWastageController::class, 'index'])->name('equipment.wastage')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/equipment/wastage/create', [EquipmentWastageController::class, 'create'])->name('equipment.wastage.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/equipment/wastage', [EquipmentWastageController::class, 'store'])->name('equipment.wastage.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/equipment/wastage/{id}/edit', [EquipmentWastageController::class, 'edit'])->name('equipment.wastage.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/equipment/wastage/{id}/update', [EquipmentWastageController::class, 'update'])->name('equipment.wastage.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/equipment/wastage/{id}/delete', [EquipmentWastageController::class, 'destroy'])->name('equipment.wastage.delete')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/equipment/wastage/{id}', [EquipmentWastageController::class, 'show'])->name('equipment.wastage.show')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** EVENTS TASK TEMPLATE ROUTES */
    Route::get('/task_templates', [TaskTemplateController::class, 'index'])->name('task_templates.index')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/task_templates/create', [TaskTemplateController::class, 'create'])->name('task_templates.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/task_templates', [TaskTemplateController::class, 'store'])->name('task_templates.store')->middleware(['auth:admin', 'xss', 'setlocate']);

    Route::post('/str_task_templates', [TaskTemplateController::class, 'str_store'])->name('str_task_templates.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/str_task_templates/{taskTemplate}', [TaskTemplateController::class, 'str_update'])->name('str_task_templates.update')->middleware(['auth:admin', 'xss', 'setlocate']);


    Route::get('/task_templates/{taskTemplate}/edit', [TaskTemplateController::class, 'edit'])->name('task_templates.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/task_templates/{taskTemplate}', [TaskTemplateController::class, 'update'])->name('task_templates.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/task_templates/{taskTemplate}', [TaskTemplateController::class, 'destroy'])->name('task_templates.destroy')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/task-templates/{taskTemplate}/edit/{task}/taskedit', [TaskTemplateController::class, 'taskEdit'])->name('task_templates.taskedit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/task-templates/{taskTemplate}/task/{task}/update', [TaskTemplateController::class, 'taskUpdate'])->name('task_templates.taskUpdate')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/task-templates/{taskTemplate}/category/{status}/edit', [TaskTemplateController::class, 'categoryEdit'])->name('task_templates.categoryedit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/task-templates/{taskTemplate}/category/{status}', [TaskTemplateController::class, 'categoryUpdate'])->name('task_templates.categoryupdate')->middleware(['auth:admin', 'xss', 'setlocate']);

    //*** EVENT TASKS LIST */
    Route::get('/event/tasks', [TaskTemplateController::class, 'eventTasks'])->name('events.task.index')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/event/tasks/template', [TaskTemplateController::class, 'getEventTaskTemplate'])->name('events.task.template')->middleware(['auth:admin', 'xss', 'setlocate']);

    Route::post('/event/tasks/status', [TaskTemplateController::class, 'getTaskTemplateStatus'])->name('events.task.status')->middleware(['auth:admin', 'xss', 'setlocate']);


    Route::post('/event/tasks', [TaskTemplateController::class, 'storeEventTask'])->name('events.task.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/event/tasks/update', [TaskTemplateController::class, 'updateEventTask'])->name('events.task.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/getTaskTemplates', [TaskTemplateController::class, 'getTaskTemplates'])->name('getTaskTemplates')->middleware(['auth:admin', 'xss', 'setlocate']);

    Route::post('/event/tasks/update/column', [TaskTemplateController::class, 'updateEventTaskColumn'])->name('events.task.update.column')->middleware(['auth:admin', 'xss', 'setlocate']);

    Route::delete('/event/tasks/delete/column', [TaskTemplateController::class, 'deleteColumn'])->name('events.task.delete.column')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/event/tasks/delete/task', [TaskTemplateController::class, 'deleteTask'])->name('events.task.delete.task')->middleware(['auth:admin', 'xss', 'setlocate']);

    Route::put('/event/tasks/update/task', [TaskTemplateController::class, 'updateTask'])->name('events.task.update.task')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/event/tasks/update/column', [TaskTemplateController::class, 'updateColumn'])->name('events.task.update.column')->middleware(['auth:admin', 'xss', 'setlocate']);


    Route::get('/events/{eventId}/team-categories/{taskId}', [TeamController::class, 'loadTeamCategories'])->name('events.team_categories')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/events/{eventId}/team-members/{categoryId}', [TeamController::class, 'getTeamMembers'])->name('team_members')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/tasks/{taskId}/assigned-team/members', [TeamController::class, 'getAssignedTeamMembers'])->name('assigned_team_members')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/tasks/{taskId}/assign-team', [TeamController::class, 'assignTeamToTask'])->name('assign_team')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/tasks/{taskId}/team-members/{teamMemberId}', [TeamController::class, 'removeTeamMemberFromTask'])->name('tasks.remove-team-member')->middleware(['auth:admin', 'xss', 'setlocate']);

    // Strategy CRUD routes
    Route::get('/strategies', [StrategyController::class, 'index'])->name('strategies.index')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/strategies/create', [StrategyController::class, 'create'])->name('strategies.create')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/strategies', [StrategyController::class, 'store'])->name('strategies.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/strategies/{strategy}/edit', [StrategyController::class, 'edit'])->name('strategies.edit')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::put('/strategies/{strategy}', [StrategyController::class, 'update'])->name('strategies.update')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::delete('/strategies/{strategy}', [StrategyController::class, 'destroy'])->name('strategies.destroy')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/strategies/view', [StrategyController::class, 'strategiesView'])->name('strategies.view')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/strategies/{strategyId}/page/{page}/sub/{subPage}/save', [StrategyController::class, 'saveSubOption'])->name('strategies.saveSubOption')->middleware(['auth:admin', 'xss', 'setlocate']);


    //load sub options
    Route::get('/strategies/suboptions/load', [StrategyController::class, 'loadSubOption'])->name('strategies.suboptions.load')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/strategies/suboptionsEdit/load', [StrategyController::class, 'loadSubOptionEdit'])->name('strategies.suboptionsEdit.load')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/strategies/team/store', [TeamController::class, 'st_store_team'])->name('strategies.events.team.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::post('/strategies/team/team_name/store', [TeamController::class, 'str_store_team_name'])->name('strategies.events.team_category.store')->middleware(['auth:admin', 'xss', 'setlocate']);
    Route::get('/strategies/team/create_name', [TeamController::class, 'str_create_team_name'])->name('strategies.events.create_team_name')->middleware(['auth:admin', 'xss', 'setlocate']);

    Route::post('/strategies/mainTasks/load', [StrategyController::class, 'loadSubOptionMainTasks'])->name('strategies.mainTasks.load')->middleware(['auth:admin', 'xss', 'setlocate']);
});

//*** CONTACT US RELATED ROUTES ***//
Route::post('/viewcontactus', [ContactUsController::class, 'store'])->name('contactus.create');  //*** ROUTE TO VIEW ALL CONTACT US MESSAGES ***//

Route::prefix('employee')->as('employee.')->group(function () {
    //** EMPLOYEE DASHBOARD */
    Route::get('/empdashboard', [EmployeeController::class, 'dashboard'])->name('emp.empdashboard')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::get('/profile', [EmployeeController::class, 'profile'])->name('emp.profile')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::put('/updateprofile', [EmployeeController::class, 'updateprofile'])->name('emp.updateprofile')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::put('/changepassword', [EmployeeController::class, 'updatepassword'])->name('emp.changepassword')->middleware(['auth:employee', 'xss', 'setlocate']);

    //** EMPLOYEE EVENTS */
    Route::get('/view/events', [EmployeeController::class, 'viewevents'])->name('emp.viewevents')->middleware(['auth:employee', 'xss', 'setlocate']);

    //**   EMPLOYEE SALARY */
    Route::get('/viewjobamount', [EmployeeController::class, 'viewjobamount'])->name('emp.viewjobamount')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::get('/emp/payments', [EmployeeController::class, 'employeeSalary'])->name('emp.payments')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::get('/emp/credits', [EmployeeController::class, 'employeeCreditsView'])->name('emp.credits')->middleware(['auth:employee', 'xss', 'setlocate']);

    //** ADDITIONAL EXPENSES IN EVENT */
    Route::get('/create/expenses/{order_id}', [AdditionalExpenseController::class, 'createEmpExpense'])->name('emp.order.expenses.create')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::post('/order/expenses/store', [AdditionalExpenseController::class, 'storeExpenses'])->name('emp.order.expenses.store')->middleware(['xss', 'setlocate']); // Both admin and employee routh
    Route::get('/order/ecpenses/edit/{id}', [AdditionalExpenseController::class, 'editExpenses'])->name('emp.order.expenses.edit')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::put('/order/expenses/update/{id}', [AdditionalExpenseController::class, 'updateExpenses'])->name('emp.order.expenses.update')->middleware(['auth:employee', 'xss', 'setlocate']);

    //*** EMPLOYEE CALENDER */
    // Employer view calender
    Route::get('/viewcalender', [EmployeeController::class, 'viewcalender'])->name('emp.viewcalendar')->middleware(['auth:employee', 'xss', 'setlocate']);
    // Route for Ajax request to fetch order details to display employer calender
    Route::get('/order-details/employer/{eventId}', [EmployeeController::class, 'getOrderDetails'])->name('emp.order.details')->middleware(['auth:employee', 'xss', 'setlocate']);


    //*** EMPLOYEE RENT ITEMS */
    Route::get('/view/rentitems', [RentItemController::class, 'assignRentItems'])->name('emp.assign.rent')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::get('/view/rentitems/create', [RentItemController::class, 'senditemform'])->name('emp.rent.create')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::post('/view/rentitems', [RentItemController::class, 'saverentitems'])->name('emp.send.store')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::get('/viewrentitems/{emp_id}/assign', [RentItemController::class, 'assignRentItemsView'])->name('emp.assign.rent.view')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::put('/viewrentitems/{rent_id}/update', [RentItemController::class, 'assignRentItemsUpdate'])->name('emp.assign.rent.update')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::get('/check-item-quantity/{itemId}', [RentItemController::class, 'checkAvailability']); //Can access both admin and employee

    //*** EMPLOYEE RECEIVED ITEMS  */
    Route::get('/viewreceiveitems', [RentItemController::class, 'viewReceivedItems'])->name('emp.view.received.items')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::get('/viewreceiveitems/{id}', [RentItemController::class, 'viewReceivedItemsDetails'])->name('emp.view.received.items.details')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::put('/viewreceiveitems/{id}/update', [RentItemController::class, 'receiveitems'])->name('emp.update.received.items')->middleware(['auth:employee', 'xss', 'setlocate']);

    //*** EMPLOYEE VACATIONS ROUTES */
    Route::get('/vacations', [VacationController::class, 'index'])->name('vacations')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::get('/vacations/create', [VacationController::class, 'create'])->name('vacations.create')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::post('/vacations', [VacationController::class, 'store'])->name('vacations.store')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::get('/vacations/{vacation}/edit', [VacationController::class, 'edit'])->name('vacations.edit')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::put('/vacations/{vacation}', [VacationController::class, 'update'])->name('vacations.update')->middleware(['auth:employee', 'xss', 'setlocate']);
    Route::delete('/vacations/{vacation}', [VacationController::class, 'destroy'])->name('vacations.destroy')->middleware(['auth:employee', 'xss', 'setlocate']);




    //*** PDF GENERATION ***/
    Route::get('/generate-pdf/{id}', [PdfController::class, 'generatePdf'])->name('generatePdf')->middleware(['auth:employee', 'xss', 'setlocate']);

    //*** TASK MANAGEMENT RELATED ROUTES ***//
    Route::get('/taskmanage/show', [TaskManagementController::class, 'showTaskManagementEmployee'])->name('taskmanage.employee.show')->middleware(['auth:employee', 'xss', 'setlocate']);

});



Route::prefix('manager')->as('manager.')->group(function () {
    //** EMPLOYEE DASHBOARD */
    Route::get('/managerdashboard', [ManagerController::class, 'dashboard'])->name('man.managerdashboard')->middleware(['auth:manager', 'xss', 'setlocate']);
    Route::get('/profile', [ManagerController::class, 'profile'])->name('man.profile')->middleware(['auth:manager', 'xss', 'setlocate']);
    Route::put('/updateprofile', [ManagerController::class, 'updateprofile'])->name('man.updateprofile')->middleware(['auth:manager', 'xss', 'setlocate']);
    Route::put('/changepassword', [ManagerController::class, 'updatepassword'])->name('man.changepassword')->middleware(['auth:manager', 'xss', 'setlocate']);
    Route::get('/viewcalender', [ManagerController::class, 'viewcalender'])->name('man.viewcalendar')->middleware(['auth:manager', 'xss', 'setlocate']);


    //events
    Route::get('/events_list', [ManagerEventsController::class, 'events_list'])->name('events.events_list')->middleware(['auth:manager', 'xss', 'setlocate']);
    Route::get('/events/create', [ManagerEventsController::class, 'event_create'])->name('events.event_create')->middleware(['auth:manager', 'xss', 'setlocate']);
    Route::post('/events/store', [ManagerEventsController::class, 'store'])->name('events.event_store')->middleware(['auth:manager', 'xss', 'setlocate']);
    Route::get('/events/edit/{id}', [ManagerEventsController::class, 'edit_event'])->name('events.event_edit')->middleware(['auth:manager', 'xss', 'setlocate']);
    Route::post('/events/update/{id}', [ManagerEventsController::class, 'update_event'])->name('events.event_update')->middleware(['auth:manager', 'xss', 'setlocate']);
    Route::get('/events/delete/{id}', [ManagerEventsController::class, 'delete_event_view'])->name('events.delete_event_view')->middleware(['auth:manager', 'xss', 'setlocate']);
    Route::delete('/events/delete/{id}', [ManagerEventsController::class, 'delete_event'])->name('events.event_delete')->middleware(['auth:manager', 'xss', 'setlocate']);
    Route::get('/download-details-docs/{eid}', [ManagerEventsController::class, 'downloadPdf'])->name('download.details.docs')->middleware(['auth:manager', 'xss', 'setlocate']);

});

//*** USER ROUTES ***/
Route::prefix('user')->as('user.')->group(function () {
    //customer dashboard
    Route::get('/userdashboard', [UserController::class, 'dashboard'])->name('dashboard')->middleware(['auth:user', 'xss', 'setlocate']);


    //tickets routes
    Route::post('/storeTicket/{id}', [UserTicketController::class, 'userTicketCreate'])->name('viewTicket');
    Route::post('/billingDetails', [UserTicketController::class, 'viewBillingDetails'])->name('ViewBillingDetails');
    Route::post('/storeTicket/billingDetails/{id}', [UserTicketController::class, 'userbillingDetailsStore'])->name('store.BillingDetails');

    //process ticket
    Route::post('/ticket/processData', [UserTicketController::class, 'paymentProcess'])->name('process');

    Route::post('/ticket/notify', [UserTicketController::class, 'payhereNotify'])->name('notify');

    Route::post('/pay/token', [UserTicketController::class, 'getToken'])->name('token');

    Route::get('/pay/payment-details', [UserTicketController::class, 'getPaymentDetails']);




    //profile routes
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/updatePersionalDetails', [UserController::class, 'updatePersionalDetails'])->name('updatePersionalDetails');
    Route::put('/update/Password', [UserController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/update-profile-picture/{id}', [UserController::class, 'updateProfilePicture'])->name('updateProfilePicture');

    //coupon routes
    Route::post('/apply-coupon/{eid}', [EventCouponListController::class, 'applyCoupon'])->name('apply.coupon');

    //*** PDF GENERATION FOR CUSTOMER PACKAGE ***/
    Route::get('/generate-custompdf/{package_id}', [PdfController::class, 'generateCmPackagePdf'])->name('generateCmPackagePdf');


});

//*** AGENT ROUTES ***//
Route::prefix('agent')->as('agent.')->group(function () {
    //** AGENT DASHBOARD /
    Route::get('/dashboard', [AgentController::class, 'dashboard'])->name('dashboard')->middleware(['auth:agent', 'xss', 'setlocate']);

    //** AGENT PROFILE /
    Route::get('/profile', [AgentController::class, 'profile'])->name('profile')->middleware(['auth:agent', 'xss', 'setlocate']);
    Route::put('/updateprofile', [AgentController::class, 'updateprofile'])->name('updateprofile')->middleware(['auth:agent', 'xss', 'setlocate']);
    Route::put('/changepassword', [AgentController::class, 'updatepassword'])->name('updatepassword')->middleware(['auth:agent', 'xss', 'setlocate']);

    //** AGENT EVENTS /
    Route::get('/events', [AgentController::class, 'events'])->name('events')->middleware(['auth:agent', 'xss', 'setlocate']);

    //** AGENT TICKETS /
    Route::get('/tickets', [AgentController::class, 'tickets'])->name('tickets')->middleware(['auth:agent', 'xss', 'setlocate']);

    //** AGENT PAYMENTS /
    Route::get('/profit', [AgentController::class, 'profit'])->name('profit')->middleware(['auth:agent', 'xss', 'setlocate']);

    //** AGENT Customer Offers /
    Route::get('/Offers', [AgentController::class, 'offers'])->name('offers')->middleware(['auth:agent', 'xss', 'setlocate']);

});


// *** GROUP ROUTES FOR RENT ITEMS ***//
Route::prefix('rentitem')->as('rentitem.')->group(function () {
    Route::get('/send', [RentItemController::class, 'senditemform'])->name('send.form')->middleware(['auth:employee', 'xss', 'setlocate']);  //*** ROUTE TO DISPLAY SEND ITEM FORM ***//
    Route::get('/finditems/{id}', [RentItemController::class, 'findorderitems'])->name('findorderitems')->middleware(['auth:employee', 'xss', 'setlocate']);  //*** ROUTE TO FIND ALL ORDER ITEMS FOR A SPECIFIC ORDER ***//
});

