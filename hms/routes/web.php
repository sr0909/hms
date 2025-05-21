<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentDetailsController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffDetailsController;
use App\Http\Controllers\AppointmentTimeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MedicineCategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\RunningNoController;
use App\Http\Controllers\TreatmentTypeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientDetailsController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicalRecordDetailsController;
use App\Http\Controllers\DiagnosisDetailsController;
use App\Http\Controllers\TreatmentDetailsController;
use App\Http\Controllers\PrescriptionDetailsController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedicineDetailsController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryDetailsController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\PrescriptionApprovalController;
use App\Http\Controllers\PrescriptionApprovalDetailsController;

// Login, Sign Up & Logout
Route::get('/', [LoginController::class, 'index'])->name('/');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/signup', [LoginController::class, 'create'])->name('signup');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Forget password & reset password
Route::post('/forgetpassword', [LoginController::class, 'sendResetLinkEmail'])->name('forgetpassword');
Route::get('password/reset/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [LoginController::class, 'reset'])->name('password.update');

// Unauthorized Access
Route::get('/unauthorizedaccess', [AuthorizationController::class, 'index'])->name('unauthorizedaccess');

// Dashboard
Route::middleware(['auth', 'role:super admin,admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:pharmacist'])->group(function () {
    Route::get('/pharmacist/dashboard', [DashboardController::class, 'pharmacistIndex'])->name('pharmacist.dashboard');
});

// Super Admin Role
Route::middleware(['auth', 'role:super admin'])->group(function () {
    // Staff Management
    Route::get('/staffmanagement', [StaffController::class, 'index'])->name('staffmanagement');
    Route::get('/staffmanagement/details/{id?}', [StaffDetailsController::class, 'index'])->name('staffmanagement.details');
    Route::post('/staffmanagement/create', [StaffDetailsController::class, 'create'])->name('staffmanagement.create');
    Route::post('/staffmanagement/edit/{id}', [StaffDetailsController::class, 'edit'])->name('staffmanagement.edit');
    Route::post('/staffmanagement/delete/{id}', [StaffDetailsController::class, 'destroy'])->name('staffmanagement.delete');
    Route::post('/getstaffid', [StaffDetailsController::class, 'getStaffId'])->name('getStaffId');

    // Master Data
    Route::prefix('masterdata')->group(function() {
        Route::get('/appointmenttime', [AppointmentTimeController::class, 'index'])->name('masterdata.appointmenttime');
        Route::post('/appointmenttime/create', [AppointmentTimeController::class, 'create'])->name('appointmenttime.create');
        Route::post('/appointmenttime/edit/{id}', [AppointmentTimeController::class, 'edit'])->name('appointmenttime.edit');
        Route::post('/appointmenttime/delete/{id}', [AppointmentTimeController::class, 'destroy'])->name('appointmenttime.delete');
        Route::post('/getappointmenttime', [AppointmentTimeController::class, 'getAppointmentTime'])->name('getAppointmentTime');

        Route::get('/country', [CountryController::class, 'index'])->name('masterdata.country');
        Route::post('/country/create', [CountryController::class, 'create'])->name('country.create');
        Route::post('/country/edit/{id}', [CountryController::class, 'edit'])->name('country.edit');
        Route::post('/country/delete/{id}', [CountryController::class, 'destroy'])->name('country.delete');
        Route::post('/getcountry', [CountryController::class, 'getCountry'])->name('getCountry');

        Route::get('/department', [DepartmentController::class, 'index'])->name('masterdata.department');
        Route::post('/department/create', [DepartmentController::class, 'create'])->name('department.create');
        Route::post('/department/edit/{id}', [DepartmentController::class, 'edit'])->name('department.edit');
        Route::post('/department/delete/{id}', [DepartmentController::class, 'destroy'])->name('department.delete');
        Route::post('/getdepartment', [DepartmentController::class, 'getDepartment'])->name('getDepartment');

        // Route::get('/medicinecategory', [MedicineCategoryController::class, 'index'])->name('masterdata.medicinecategory');
        // Route::post('/medicinecategory/create', [MedicineCategoryController::class, 'create'])->name('medicinecategory.create');
        // Route::post('/medicinecategory/edit/{id}', [MedicineCategoryController::class, 'edit'])->name('medicinecategory.edit');
        // Route::post('/medicinecategory/delete/{id}', [MedicineCategoryController::class, 'destroy'])->name('medicinecategory.delete');
        // Route::post('/getmedicinecategory', [MedicineCategoryController::class, 'getMedicineCategory'])->name('getMedicineCategory');
        
        Route::get('/runningno', [RunningNoController::class, 'index'])->name('masterdata.runningno');
        Route::post('/runningno/create', [RunningNoController::class, 'create'])->name('runningno.create');
        Route::post('/runningno/edit/{id}', [RunningNoController::class, 'edit'])->name('runningno.edit');
        Route::post('/runningno/delete/{id}', [RunningNoController::class, 'destroy'])->name('runningno.delete');
        Route::post('/getrunningno', [RunningNoController::class, 'getRunningno'])->name('getRunningno');

        Route::get('/treatmenttype', [TreatmentTypeController::class, 'index'])->name('masterdata.treatmenttype');
        Route::post('/treatmenttype/create', [TreatmentTypeController::class, 'create'])->name('treatmenttype.create');
        Route::post('/treatmenttype/edit/{id}', [TreatmentTypeController::class, 'edit'])->name('treatmenttype.edit');
        Route::post('/treatmenttype/delete/{id}', [TreatmentTypeController::class, 'destroy'])->name('treatmenttype.delete');
        Route::post('/gettreatmenttype', [TreatmentTypeController::class, 'getTreatmentType'])->name('getTreatmentType');
    });
});

Route::middleware(['auth', 'role:super admin,pharmacist'])->group(function () {
    // Prescription Approval
    Route::get('/prescriptionapproval', [PrescriptionApprovalController::class, 'index'])->name('prescriptionapproval');
    Route::get('/prescriptionapproval/approval/{id?}', [PrescriptionApprovalDetailsController::class, 'index'])->name('prescriptionapproval.approval');
    Route::get('/prescriptionapproval/details/{id?}', [PrescriptionApprovalDetailsController::class, 'prescriptionDetailsIndex'])->name('prescriptionapproval.details');
    Route::post('/prescriptionapproval/edit/{id}', [PrescriptionApprovalDetailsController::class, 'edit'])->name('prescriptionapproval.edit');
    Route::post('/prescriptionapproval/delete/{id}', [PrescriptionApprovalDetailsController::class, 'destroy'])->name('prescriptionapproval.delete');
    Route::post('/prescriptionapproval/approve/{id}', [PrescriptionApprovalDetailsController::class, 'approve'])->name('prescriptionapproval.approve');
    Route::post('/prescriptionapproval/reject/{id}', [PrescriptionApprovalDetailsController::class, 'reject'])->name('prescriptionapproval.reject');

    // Master Data
    Route::prefix('masterdata')->group(function() {
        Route::get('/medicinecategory', [MedicineCategoryController::class, 'index'])->name('masterdata.medicinecategory');
        Route::post('/medicinecategory/create', [MedicineCategoryController::class, 'create'])->name('medicinecategory.create');
        Route::post('/medicinecategory/edit/{id}', [MedicineCategoryController::class, 'edit'])->name('medicinecategory.edit');
        Route::post('/medicinecategory/delete/{id}', [MedicineCategoryController::class, 'destroy'])->name('medicinecategory.delete');
        Route::post('/getmedicinecategory', [MedicineCategoryController::class, 'getMedicineCategory'])->name('getMedicineCategory');
    });
});

// Doctor Role
Route::middleware(['auth', 'role:doctor'])->group(function () {
    // Dashboard
    Route::get('/doctor/dashboard', [DashboardController::class, 'doctorIndex'])->name('doctor.dashboard');

    // Appointment
    Route::get('/admin/appointment/details/{id?}', [AppointmentDetailsController::class, 'adminIndex'])->name('admin.appointment.details');
    Route::post('/getpatientnamelist', [AppointmentDetailsController::class, 'getPatientNameList'])->name('getPatientNameList');
    
    // Medical Record
    // Route::get('/medicalrecord', [MedicalRecordController::class, 'index'])->name('medicalrecord');
    Route::get('/medicalrecord/details/{id?}', [MedicalRecordDetailsController::class, 'index'])->name('medicalrecord.details');
    Route::post('/medicalrecord/create', [MedicalRecordDetailsController::class, 'create'])->name('medicalrecord.create');
    Route::post('/medicalrecord/edit/{id}', [MedicalRecordDetailsController::class, 'edit'])->name('medicalrecord.edit');
    Route::post('/medicalrecord/delete/{id}', [MedicalRecordDetailsController::class, 'destroy'])->name('medicalrecord.delete');
    Route::post('/getmedicalrecordid', [MedicalRecordDetailsController::class, 'getMedicalRecordId'])->name('getMedicalRecordId');
    Route::post('/getmrcreatedstatus', [MedicalRecordDetailsController::class, 'getMRCreatedStatus'])->name('getMRCreatedStatus');

    
    Route::prefix('medicalrecord')->group(function() {
        // Diagnosis
        Route::get('/{medicalrecordID}/diagnosis/details/{id?}', [DiagnosisDetailsController::class, 'index'])->name('diagnosis.details');
        Route::post('/diagnosis/create', [DiagnosisDetailsController::class, 'create'])->name('diagnosis.create');
        Route::post('/diagnosis/edit/{id}', [DiagnosisDetailsController::class, 'edit'])->name('diagnosis.edit');
        Route::post('/diagnosis/delete/{id}', [DiagnosisDetailsController::class, 'destroy'])->name('diagnosis.delete');

        // Treatment
        Route::get('/{medicalrecordID}/diagnosis/{diagnosisID}/treatment/details/{id?}', [TreatmentDetailsController::class, 'index'])->name('treatment.details');
        Route::post('/treatment/create', [TreatmentDetailsController::class, 'create'])->name('treatment.create');
        Route::post('/treatment/edit/{id}', [TreatmentDetailsController::class, 'edit'])->name('treatment.edit');
        Route::post('/treatment/delete/{id}', [TreatmentDetailsController::class, 'destroy'])->name('treatment.delete');

        // Prescription
        Route::get('/{medicalrecordID}/diagnosis/{diagnosisID}/treatment/{treatmentID}/prescription/details/{id?}', [PrescriptionDetailsController::class, 'index'])->name('prescription.details');
        Route::post('/prescription/create', [PrescriptionDetailsController::class, 'create'])->name('prescription.create');
        Route::post('/prescription/edit/{id}', [PrescriptionDetailsController::class, 'edit'])->name('prescription.edit');
        Route::post('/prescription/delete/{id}', [PrescriptionDetailsController::class, 'destroy'])->name('prescription.delete');
    });

    Route::post('/getdiagnosisid', [DiagnosisDetailsController::class, 'getDiagnosisId'])->name('getDiagnosisId');
    Route::post('/getdiagnosiscreatedstatus', [DiagnosisDetailsController::class, 'getDiagnosisCreatedStatus'])->name('getDiagnosisCreatedStatus');

    Route::post('/gettreatmentid', [TreatmentDetailsController::class, 'getTreatmentId'])->name('getTreatmentId');
    Route::post('/gettreatmentcreatedstatus', [TreatmentDetailsController::class, 'getTreatmentCreatedStatus'])->name('getTreatmentCreatedStatus');
});

Route::middleware(['auth', 'role:super admin,admin,doctor'])->group(function () {
    // Patient Management
    Route::get('/patient', [PatientController::class, 'index'])->name('patient');
    Route::get('/patient/details/{id?}', [PatientDetailsController::class, 'index'])->name('patient.details');
    Route::post('/patient/edit/{id}', [PatientDetailsController::class, 'edit'])->name('patient.edit');
    Route::post('/patient/delete/{id}', [PatientDetailsController::class, 'destroy'])->name('patient.delete');
    Route::post('/getnewpatientid', [PatientDetailsController::class, 'getNewPatientId'])->name('getNewPatientId');
});

Route::middleware(['auth', 'role:normal user,doctor'])->group(function () {
    // Appointment
    Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment');
    Route::get('/appointment/search', [AppointmentDetailsController::class, 'searchindex'])->name('appointment.search');
    Route::get('/appointment/details/{id?}', [AppointmentDetailsController::class, 'index'])->name('appointment.details');
    Route::post('/appointment/create', [AppointmentDetailsController::class, 'create'])->name('appointment.create');
    Route::post('/appointment/edit/{id}', [AppointmentDetailsController::class, 'edit'])->name('appointment.edit');
    Route::post('/appointment/delete/{id}', [AppointmentDetailsController::class, 'destroy'])->name('appointment.delete');
    Route::post('/getpatientid', [AppointmentDetailsController::class, 'getPatientId'])->name('getPatientId');

    // Medical Record
    Route::get('/medicalrecord', [MedicalRecordController::class, 'index'])->name('medicalrecord');
    Route::get('/medicalrecord/print/{id}', [MedicalRecordController::class, 'print'])->name('medicalrecord.print');
});

Route::middleware(['auth', 'role:super admin,admin,pharmacist'])->group(function () {
    // Medicine Management
    Route::get('/medicine', [MedicineController::class, 'index'])->name('medicine');
    Route::get('/medicine/details/{id?}', [MedicineDetailsController::class, 'index'])->name('medicine.details');
    Route::post('/medicine/create', [MedicineDetailsController::class, 'create'])->name('medicine.create');
    Route::post('/medicine/edit/{id}', [MedicineDetailsController::class, 'edit'])->name('medicine.edit');
    Route::post('/medicine/delete/{id}', [MedicineDetailsController::class, 'destroy'])->name('medicine.delete');
    Route::post('/getmedicineid', [MedicineDetailsController::class, 'getMedicineId'])->name('getMedicineId');
    Route::post('/getmedicinecategorylist', [MedicineDetailsController::class, 'getMedicineCategoryList'])->name('getMedicineCategoryList');

    // Inventory Management
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::get('/inventory/details/{id?}', [InventoryDetailsController::class, 'index'])->name('inventory.details');
    Route::post('/inventory/create', [InventoryDetailsController::class, 'create'])->name('inventory.create');
    Route::post('/inventory/edit/{id}', [InventoryDetailsController::class, 'edit'])->name('inventory.edit');
    Route::post('/inventory/delete/{id}', [InventoryDetailsController::class, 'destroy'])->name('inventory.delete');
    // Route::post('/getmedicinenamelist', [InventoryDetailsController::class, 'getMedicineNameList'])->name('getMedicineNameList');
});

Route::middleware(['auth', 'role:super admin,admin,pharmacist,doctor'])->group(function () {
    Route::post('/getmedicinenamelist', [InventoryDetailsController::class, 'getMedicineNameList'])->name('getMedicineNameList');
    Route::post('/getmedicinedosage', [PrescriptionDetailsController::class, 'getMedicineDosage'])->name('getMedicineDosage');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Patient Management
Route::post('/patient/create', [PatientController::class, 'create'])->name('patient.create');

// My Account
Route::get('/myaccount', [MyAccountController::class, 'index'])->name('myaccount');
Route::post('/myaccount/edit/{id}', [MyAccountController::class, 'edit'])->name('myaccount.edit');
Route::post('/staff/myaccount/edit/{id}', [MyAccountController::class, 'staffEdit'])->name('staffmyaccount.edit');
Route::post('/changepass', [MyAccountController::class, 'changePass'])->name('changePass');

?>