<?php

namespace App\Http\Livewire\Invoices;

use App\Events\MyEvent;
use App\Exceptions\InvalidInvoiceTypeException;
use App\Models\Doctor;
use App\Models\FundAccount;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\SingleService;
use App\Models\Invoice;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class SingleInvoices extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $storedInvoice, $updatedInvoice, $price, $discount_value,
        $patient_id, $doctor_id, $section_name, $type, $service_id, $single_invoice_id;
    public $showTable = true;
    public $tax_rate = 17;
    public $updateMode = false;

    protected array $rules = [
        'discount_value' => 'required|numeric|gt:0',
        'patient_id' => 'required|integer|exists:App\Models\Patient,id',
        'doctor_id' => 'required|integer|exists:App\Models\Doctor,id',
        'type' => 'required|in:1,0',
        'service_id' => 'required|integer|exists:App\Models\SingleService,id',
        'tax_rate' => 'required|numeric|lte:50|gte:1',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /*
              قيمة الضريبة (tax_rate) = (السعر - الخصم) * نسبة الضريبة / 100
     الاجمالي شامل الضريبة  (total_with_tax) = (السعر - الخصم) + قيمة الضريبة
     */

    public function get_total_after_discount()
    {
        return (is_numeric($this->price) ? $this->price : 0) -
            (is_numeric($this->discount_value) ? $this->discount_value : 0);
    }

    public function get_tax_value()
    {
        return $this->get_total_after_discount() * (is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100;
    }

    public function get_total_with_tax()
    {
        return $this->get_total_after_discount() + $this->get_tax_value();
    }

    public function get_doctor()
    {
        return Doctor::where('id', $this->doctor_id)->first()->load('section');
    }

    public function set_section_name()
    {
        $this->section_name = $this->get_doctor()->section->name;
    }

    public function get_service_price()
    {
        $this->price = SingleService::where('id', $this->service_id)->first()->price;
        return $this->price;
    }

    public function render()
    {
        return view('livewire.invoices.single-invoices', [
            'singleInvoices'=> Invoice::singleInvoices()->paginate(5),
            'patients'=> Patient::select('id', 'user_id')->get(),
            'doctors'=> Doctor::select('id', 'user_id')->get(),
            'services'=> SingleService::select('id')->get(),
            'total_after_discount' =>  $this->get_total_after_discount(),
            'tax_value' => $this->get_tax_value() ,
            'total_with_tax'=> $this->get_total_with_tax(),
        ]);
    }

    public function create()
    {
        $this->showTable = false;
    }

    public function edit($id)
    {
        $this->resetErrorBag();
        $this->showTable = false;
        $this->storedInvoice = false;
        $this->updateMode = true;
        $singleInvoice = Invoice::findOrFail($id);
        $this->patient_id = $singleInvoice->patient_id;
        $this->doctor_id = $singleInvoice->doctor_id;
        $this->section_name = $this->get_doctor()->section->name;
        $this->single_invoice_id = $singleInvoice->id;
        $this->discount_value = $singleInvoice->discount_value;
        $this->service_id = $singleInvoice->single_service_id;
        $this->price = $singleInvoice->price;
        $this->tax_rate = $singleInvoice->tax_rate;
        $this->type = $singleInvoice->payment_method;

    }


//$table->tinyInteger('invoice_type');   // ['single_service' => 0, 'group_services' => 1]);
//$table->tinyInteger('payment_method'); // ['cash' => 1, 'deferred' => 0]);
//$table->tinyInteger('invoice_status'); // ['pending' => 0, 'finish' => 1, 'revision' => 2]);


//    public function getNextInvoiceNumber()
//    {
//        $currentYear = now()->year;
//        $maxInvoiceNumber = Invoice::whereYear('created_at', $currentYear)->max('invoice_number');
//        if($maxInvoiceNumber) {
//            return ++ $maxInvoiceNumber;
//        }
//        return $currentYear. '0008';
//    }

    public function updateOrStore()
    {
        $this->validate($this->rules);
        try {
            $singleInvoiceData = [
                'invoice_type' => 0,
                'invoice_status' => 0,
                'date' => date('Y-m-d'),
                'invoice_number' => '',
                'createable_type' => auth()->user()->hasRole(['admin', 'super_admin']) ? 'App\Models\Admin' :
                    'App\Models\BookingOfficer' ,
                'createable_id' => auth()->id(),
                'booking_officer_id' => null ,
                'patient_id' => $this->patient_id,
                'doctor_id' => $this->doctor_id,
                'single_service_id' => $this->service_id,
                'price' => $this->get_service_price(),
                'discount_value' => $this->discount_value,
                'tax_rate' => $this->tax_rate,
                'tax_value' => $this->get_tax_value(),
                'total_with_tax'=> $this->get_total_with_tax(),
                'payment_method' => $this->type,
            ];

            DB::beginTransaction();
            if ($this->updateMode) {

                $singleInvoice = Invoice::findOrFail($this->single_invoice_id);

                $fundAccountData = [
                    'date' => Carbon::now(),
                    'invoice_id' => $singleInvoice->id,
                    'debit' => $singleInvoice->total_with_tax,
                    'credit' => 0.00,
                ];

                $patientAccountData = array_merge($fundAccountData , ['patient_id' => $this->patient_id]);

                $singleInvoice->update($singleInvoiceData);

                if ($this->type == 1) {
                    $fundAccount = FundAccount::where('invoice_id', '=', $singleInvoice->id)->first();
                    $fundAccount->update($fundAccountData);
                }  elseif ($this->type == 0) {
                    $patientAccount =  PatientAccount::where('invoice_id', '=', $singleInvoice->id)->first();
                    $patientAccount->update($patientAccountData);
                }
                else {
                    DB::rollBack();
                    throw new InvalidInvoiceTypeException('Error in Invoice type');
                }
                DB::commit();
                $this->storedInvoice = false;
                $this->updatedInvoice = true;
            } else {
                $singleInvoice = Invoice::create($singleInvoiceData);

                $fundAccountData = [
                    'date' => Carbon::now(),
                    'invoice_id' => $singleInvoice->id,
                    'debit' => $singleInvoice->total_with_tax,
                    'credit' => 0.00,
                ];

                $patientAccountData = array_merge($fundAccountData , ['patient_id' => $this->patient_id]);

                if ($this->type == 1) {
                    FundAccount::create($fundAccountData);
                } elseif ($this->type == 0) {
                    PatientAccount::create($patientAccountData);
                } else {
                    DB::rollBack();
                    throw new InvalidInvoiceTypeException('Error in Invoice type');
                }

                DB::commit();
                $this->updatedInvoice = false;
                $this->storedInvoice =true;
            }
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e);
        }

        $this->reset( 'patient_id', 'doctor_id', 'section_name', 'service_id',
            'price', 'discount_value', 'tax_rate', 'type');
        $this->showTable =true;
    }

    public function set_single_invoice_id($id)
    {
        $this->single_invoice_id = $id;
    }

    public function destroy()
    {
        Invoice::destroy($this->single_invoice_id);
        return redirect()->route('admin.single-invoice.index');
    }

    public function print($id)
    {
        $singleInvoice = Invoice::findorfail($id);
       return redirect()->route('admin.single-invoice.print',[
           'service_name' => $singleInvoice->singleService->name,
            'patient_name' => Patient::where('id', $singleInvoice->patient_id)->first()->name,
            'date' => $singleInvoice->date,
            'doctor_id' => $singleInvoice->doctor->name,
            'section_id' => $singleInvoice->section->name,
            'type' => $singleInvoice->type,
            'price' => $singleInvoice->price,
            'discount_value' => $singleInvoice->discount_value,
            'tax_rate' => $singleInvoice->tax_rate,
            'total_with_tax' => $singleInvoice->total_with_tax,
        ]);
    }
}
