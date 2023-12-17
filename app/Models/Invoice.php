<?php

namespace App\Models;

use App\Observers\AnyModelObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use \Znck\Eloquent\Traits\BelongsToThrough;


class Invoice extends Model
{
    use HasFactory, BelongsToThrough;

    protected $fillable = [
        'invoice_type', 'payment_method', 'invoice_status', 'date', 'patient_id', 'doctor_id',
        'single_service_id', 'group_services_id', 'price', 'discount_value', 'tax_rate', 'tax_value',
        'total_with_tax', 'createable_type', 'createable_id', 'booking_officer_id', 'invoice_number'
    ];

    protected static function booted()
    {
        static::observe(AnyModelObserver::class);
    }

    public function singleService()
    {
        return $this->belongsTo(SingleService::class, 'single_service_id')
            ->with('translations');
    }

    public function groupServices()
    {
        return $this->belongsTo(GroupService::class, 'group_services_id');
    }

    public function patientUser()
    {
        return $this->belongsToThrough(User::class, Patient::class)->withTranslation();
    }

    public function doctorUser()
    {
        return $this->belongsToThrough(User::class, Doctor::class)->withTranslation();
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id')->with('doctor.user.translations');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id')->with('patient.user.translations');
    }

    public function section()
    {
        return $this->belongsToThrough(Section::class, Doctor::class)->with('translations');
    }


    public function getFullInvoiceNumberAttribute(): string
    {
        return 'WE-'. now()->year."#000000{$this->invoice_number}";
    }

    public function setInvoiceNumberAttribute()
    {
        $this->attributes['invoice_number'] = Invoice::max('invoice_number') + 1;
    }

    public function scopeSingleInvoices(Builder $query)
    {
        $query
            ->where('invoice_type', 0)
            ->whereNotNull('single_service_id')
            ->whereNull('group_services_id')
            ->select('id', 'invoice_type', 'payment_method', 'invoice_status', 'date', 'patient_id',
                'doctor_id', 'single_service_id',  'price', 'discount_value', 'tax_rate', 'tax_value',
                'total_with_tax', 'invoice_number')
            ->with(['patientUser.translations', 'doctorUser.translations', 'section.translations',
                'singleService.translations']);
    }

        public function scopeGroupInvoices(Builder $query)
    {
        $query
            ->where('invoice_type', '=', 1)
            ->whereNotNull('group_services_id')
            ->whereNull('single_service_id')
            ->select('id', 'invoice_type', 'payment_method', 'invoice_status', 'date', 'patient_id',
                'doctor_id', 'group_services_id',  'price', 'discount_value', 'tax_rate', 'tax_value',
                'total_with_tax', 'invoice_number')
            ->with(['patientUser.translations', 'doctorUser.translations', 'section.translations',
                'groupServices.translations']);
    }


    public function scopeAllDoctorInvoices(Builder $query)
    {
        $query
            ->whereIn('invoice_status', ['revision', 'finish', 'pending'])
            ->where('doctor_id', auth()->id())
            ->select('id', 'date', 'price', 'discount_value', 'patient_id',
                'tax_rate', 'tax_value', 'total_with_tax', 'invoice_status', 'single_service_id', 'group_services_id')
            ->with(['patient', 'singleService.translations', 'groupServices.translations']);
    }

    public function scopeDoctorCompletedInvoices(Builder $query)
    {
         $query
             ->select('id', 'date', 'price', 'discount_value', 'patient_id',
             'tax_rate', 'tax_value', 'total_with_tax', 'invoice_status', 'single_service_id', 'group_services_id')
            ->where('doctor_id', auth()->guard('doctor')->id())
            ->where('invoice_status', '=', 'finish')
            ->with(['patient', 'singleService', 'groupServices']);
    }

    public function scopeDoctorRevisionsInvoices(Builder $query)
    {
        $query
            ->select('id', 'date', 'price', 'discount_value', 'patient_id',
            'tax_rate', 'tax_value', 'total_with_tax', 'invoice_status', 'single_service_id', 'group_services_id')
            ->where('doctor_id', '=',  auth()->guard('doctor')->id())
            ->where('invoice_status', '=', 'revision')
            ->with(['patient', 'singleService', 'groupServices']);
    }
}
