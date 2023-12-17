<?php

namespace App\Http\Livewire\Invoices;

use App\Exceptions\InvalidInvoiceTypeException;
use App\Models\Doctor;
use App\Models\FundAccount;
use App\Models\GroupService;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\SingleService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GroupInvoices extends Component
{

    public $stored_group_invoice, $updated_group_invoice, $discount_value, $patient_id,
        $doctor_id, $section_name, $type, $group_services_id, $group_invoice_id;
    public $show_table = true;
    public $tax_rate = 17;
    public $update_mode = false;
    public $price = 0;

    protected array $rules = [
        'patient_id' => 'required|integer|exists:App\Models\Patient,id',
        'doctor_id' => 'required|integer|exists:App\Models\Doctor,id',
        'type' => 'required|string|in:1,0',
        'group_services_id' => 'required|integer|exists:App\Models\GroupService,id',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

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

    public function get_group_services_price_details()
    {
        $this->price = GroupService::where('id', $this->group_services_id)->value('total_before_discount');
        $this->discount_value = GroupService::where('id', $this->group_services_id)->value('discount_value');
        $this->tax_rate = GroupService::where('id', $this->group_services_id)->value('tax_rate');
    }

    public function render()
    {
        return view('livewire.invoices.group-invoices', [
            'groupsServices' => GroupService::select('id')->get(['id']),
            'groupsInvoices' => Invoice::groupInvoices()->get(),
            'patients'=> Patient::with('user')->get(['id', 'user_id']),
            'doctors'=> Doctor::with('user')->get(['id', 'user_id']),
            'total_after_discount' =>  $this->get_total_after_discount(),
            'tax_value' => $this->get_tax_value() ,
            'total_with_tax'=> $this->get_total_with_tax(),
        ])->extends('dashboard.layouts');
    }

    public function create()
    {
        $this->updated_group_invoice = false;
        $this->update_mode = false;
        $this->show_table = false;
    }


    public function edit($id)
    {
        $this->resetErrorBag();
        $this->show_table = false;
        $this->stored_group_invoice = false;
        $this->update_mode = true;
        $Invoice = Invoice::findOrFail($id);
        $this->patient_id = $Invoice->patient_id;
        $this->doctor_id = $Invoice->doctor_id;
        $this->section_name = $this->get_doctor()->section->name;
        $this->group_invoice_id = $Invoice->id;
        $this->group_services_id = $Invoice->group_services_id;
        $this->discount_value = $Invoice->discount_value;
        $this->section_id = $Invoice->section_id;
        $this->price = $Invoice->price;
        $this->tax_rate = $Invoice->tax_rate;
        $this->type = $Invoice->payment_method;
    }


//$table->tinyInteger('invoice_type');   // ['single_service' => 0, 'group_services' => 1]);
//$table->tinyInteger('payment_method'); // ['cash' => 1, 'deferred' => 0]);
//$table->tinyInteger('invoice_status'); // ['pending' => 0, 'finish' => 1, 'revision' => 2]);



    public function updateOrStore()
    {
        $this->validate($this->rules);
        try {
            $InvoiceData = [
                'invoice_type' => 1,
                'invoice_status' => 0,
                'invoice_number' => '',
                'createable_type' => auth()->user()->hasRole(['admin', 'super_admin']) ? 'App\Models\Admin' :
                    'App\Models\BookingOfficer' ,
                'createable_id' => auth()->id(),
                'booking_officer_id' => null ,
                'date' => date('Y-m-d'),
                'patient_id' => $this->patient_id,
                'doctor_id' => $this->doctor_id,
                'section_id' => $this->get_doctor()->section->id,
                'group_services_id' => $this->group_services_id,
                'price' => $this->price,
                'discount_value' => $this->discount_value,
                'tax_rate' => $this->tax_rate,
                'tax_value' => $this->get_tax_value(),
                'total_with_tax'=> $this->get_total_with_tax(),
                'payment_method' => $this->type,
            ];
            DB::beginTransaction();

            if ($this->update_mode) {

                $Invoice = Invoice::findOrFail($this->group_invoice_id);

                $fundAccountData = [
                    'date' => now(),
                    'invoice_id' => $Invoice->id,
                    'debit' => $Invoice->total_with_tax,
                    'credit' => 0.00,
                ];

                $patientAccountData = array_merge($fundAccountData , ['patient_id' => $this->patient_id]);

                $Invoice->update($InvoiceData);
                if ($this->type == 'cash') {
                    $fundAccount = FundAccount::where('invoice_id', $Invoice->id)->first();
                    $fundAccount->update($fundAccountData);
                }  elseif ($this->type == 'deferred') {
                    $patientAccount =  PatientAccount::where('invoice_id', '=', $Invoice->id)->first();
                    $patientAccount->update($patientAccountData);
                }
                else {
                    DB::rollBack();
                    throw new InvalidInvoiceTypeException('Error in Invoice type');
                }
                DB::commit();
                $this->stored_group_invoice = false;
                $this->updated_group_invoice = true;
            } else {
                $Invoice = Invoice::create($InvoiceData);

                $fundAccountData = [
                    'date' => now(),
                    'invoice_id' => $Invoice->id,
                    'debit' => $Invoice->total_with_tax,
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
                $this->updated_group_invoice = false;
                $this->stored_group_invoice = true;
            }
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e);
        }

        $this->reset( 'patient_id', 'doctor_id', 'section_name', 'group_services_id',
            'price', 'discount_value', 'tax_rate', 'type');
        $this->show_table =true;
    }

    public function set_group_invoice_id($id)
    {
        $this->group_invoice_id = $id;
    }

    public function destroy()
    {
        Invoice::destroy($this->group_invoice_id);
        return redirect()->route('admin.group-invoices.index');
    }

    public function print($id)
    {
        $Invoice = Invoice::findOrFail($id);
        return redirect()->route('admin.group-invoice.print',[
            'group_services_name' => $Invoice->groupServices->name,
            'patient_name' => Patient::where('id', $Invoice->patient_id)->first()->name,
            'date' => $Invoice->date,
            'doctor_id' => $Invoice->doctor->name,
            'section_id' => $Invoice->section->name,
            'type' => $Invoice->payment_method,
            'price' => $Invoice->price,
            'discount_value' => $Invoice->discount_value,
            'tax_rate' => $Invoice->tax_rate,
            'total_with_tax' => $Invoice->total_with_tax,
        ]);
    }
}
