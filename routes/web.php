<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrintController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|routesAdminController
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/patient/create/save', [App\Http\Controllers\HomeController::class, 'createPatientSave'])->name('patient.create.save');
Route::get('/patient/edit/{patient_id}', [App\Http\Controllers\HomeController::class, 'editPatient'])->name('patient.edit');
Route::post('/patient/update/{id}', [App\Http\Controllers\HomeController::class, 'updatePatient'])->name('patient.update');
Route::get('/patient/remove/{id}', [App\Http\Controllers\HomeController::class, 'removePatient'])->name('patient.remove');
Route::get('/patient/{id}', [App\Http\Controllers\HomeController::class, 'fetchPatient'])->name('patient.fetch');
Route::get('/patient', [App\Http\Controllers\HomeController::class, 'fetchAdditionalData'])->name('home.addditional');
Route::get('/patient/pdf', [App\Http\Controllers\PrintController::class, 'patientPdf'])->name('patient.pdf');
Route::get('patient/pdf/{patientid}', [App\Http\Controllers\PrintController::class, 'patientPdf'])->name('patient.pdf');
Route::get('muncity/get/{province_id}', [App\Http\Controllers\HomeController::class, 'muncityGet'])->name('muncity.get');
Route::get('barangay/get/{muncity_id}', [App\Http\Controllers\HomeController::class, 'barangayGet'])->name('barangay.get');
Route::match(['get', 'post'],'/update/amount/{patientId}/{amount}', [App\Http\Controllers\HomeController::class, 'updateAmount'])->name('update.amount');
Route::get('/group', [App\Http\Controllers\HomeController::class, 'group'])->name('group');
Route::match(['get', 'post'],'/proponent/report/{pro_group}', [App\Http\Controllers\HomeController::class, 'getProponentReport'])->name('proponent.report');
Route::match(['get', 'post'],'/facility/report/{facility_id}', [App\Http\Controllers\HomeController::class, 'getFacilityReport'])->name('facility.report');
Route::get('/report', [App\Http\Controllers\HomeController::class, 'report'])->name('report');
Route::get('/report/facility', [App\Http\Controllers\HomeController::class, 'reportFacility'])->name('report.facility');
Route::get('/facility/proponent/{facility_id}', [App\Http\Controllers\HomeController::class, 'facilityProponentGet'])->name('facility.proponent.get');
Route::get('/patient/code/{proponent_id}/{facility_id}', [App\Http\Controllers\HomeController::class, 'forPatientCode'])->name('facility.patient.code');
Route::get('/patient/proponent/{fundsource_id}', [App\Http\Controllers\HomeController::class, 'forPatientFacilityCode'])->name('facility.patient.code');
Route::match(['get', 'post'],'patient/mails', [App\Http\Controllers\PrintController::class, 'sendMultiple'])->name('sent.mails');
Route::get('patient/sendpdf/{patientid}', [App\Http\Controllers\PrintController::class, 'sendpatientPdf'])->name('patient.sendpdf');
Route::get('/facility/list', [App\Http\Controllers\FacilityController::class, 'index'])->name('facility');
Route::get('facility/edit/{main_id}', [App\Http\Controllers\FacilityController::class, 'facilityEdit'])->name('facility.edit');
Route::get('transaction/get', [App\Http\Controllers\HomeController::class, 'transactionGet'])->name('transaction.get');
Route::post('facility/update', [App\Http\Controllers\FacilityController::class, 'facilityUpdate'])->name('facility.update');
Route::get('/patient/history/{id}', [App\Http\Controllers\HomeController::class, 'patientHistory'])->name('patient.history');
Route::get('/mail/history/{id}', [App\Http\Controllers\HomeController::class, 'mailHistory'])->name('mail.history');

















