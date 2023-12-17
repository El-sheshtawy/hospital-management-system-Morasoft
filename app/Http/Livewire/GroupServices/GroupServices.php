<?php

namespace App\Http\Livewire\GroupServices;

use App\Models\GroupService;
use App\Models\SingleService;
use App\Rules\ForbiddenWords;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class GroupServices extends Component
{
    public $group_name, $description, $services, $group_id;
    public $groupServices = [];
    public $discount_value = 0;
    public $taxes = 10;
    public $storedGroup = false;
    public $showTable = true;
    public $updateMode = false;
    public $updatedGroup = false;
    public $deletedGroup = false;
    public $showErrors = false;

    protected function rules(): array
    {
        return [
            'description' => 'required',
            'groupServices' => 'required|array|min:1',
            'groupServices.*.service_id' => 'required|integer|distinct',
            'groupServices.*.quantity' => 'required|numeric|gte:1|lte:10',
        ];
    }

    protected array $messages = [
        'groupServices.required' => 'Click on add single service and select one service at least',
        'groupServices.*.quantity.required' => 'Select the number of times',
        'groupServices.*.quantity.gte' => 'The times number of any single service cannot be less than 1',
        'groupServices.*.quantity.lte' => 'The times number of any single service cannot be more than 10',
        'groupServices.*.service_id.required' => 'Choose a service from the list',
        'groupServices.*.service_id.distinct' => 'Attention there is a duplicate individual service name!!'
    ];

    public function attributes(): array
    {
        return [
            'description' => 'services group description (by att function)',
        ];
    }

   // Validate group_name (while store and update)
   public function getGroupNameProperty(): array
   {
       return [
           'group_name' => $this->group_name,
       ];
   }

    public function getStoredGroupNameRules(): array
    {
        return [
            'group_name' => ['required', 'string', 'not_in:sex,kill,fuck', 'min:4',
                'unique:group_service_translations,name', new ForbiddenWords(),
            ]
        ];
    }

    public function getGroupNameMessages(): array
    {
        return [
            'group_name.unique' =>'This name already exists before as :attribute',
            'group_name.required' => 'The :attribute cannot be empty',
            'group_name.not_in' => 'This word not allowed to use in system and website!!',
            'group_name.min' => 'The :attribute cannot be less than :min chars',
        ];
    }

    public function getGroupNameAttribute(): array
    {
        return [
            'group_name' => 'SHESHTAWY GROUP'
        ];
    }



    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->services = SingleService::all();
    }

    public function get_total_befor_discount(): float|int
    {
        $total = 0;
        foreach ($this->groupServices as $selectedService) {
            if ($selectedService['is_saved'] && $selectedService['service_price'] && $selectedService['quantity']) {
                $total += $selectedService['service_price'] * $selectedService['quantity'];
            }
        }
        return $total;
    }

    public function get_total_after_discount(): float|int|string
    {
        return $this->get_total_befor_discount() - (is_numeric($this->discount_value) ? $this->discount_value : 0);
    }

    public function get_total_with_taxes()
    {
        return $this->get_total_after_discount() * (1 + (is_numeric($this->taxes) ? $this->taxes : 0) / 100);
    }

    public function render()
    {
        return view('livewire.group-services.group-services', [
            'groups' => GroupService::all(),
            'subtotal' => $this->get_total_after_discount(),
            'total' => $this->get_total_with_taxes(),
        ]);
    }

    public function add()
    {
        $this->updateMode = false;
        $this->showErrors = false;
        $this->storedGroup = false;
        $this->updatedGroup = false;
        $this->deletedGroup = false;
        foreach ($this->groupServices as $key => $selectedService) {
            if (!$selectedService['is_saved']) {
                $this->addError('groupServices.' . $key, 'يجب حفظ هذا الخدمة قبل إنشاء خدمة جديدة.');
                return;
            }
        }

        $this->groupServices[] = [
            'service_id' => '',
            'quantity' => '',
            'is_saved' => false,
            'service_name' => '',
            'service_price' => 0
        ];
    }

    public function setDefaultQuantity($index)
    {
        $this->groupServices[$index]['quantity'] = 1;
    }

    public function editSelectedService($index)
    {
        foreach ($this->groupServices as $key => $selectedService) {
            if (!$selectedService['is_saved']) {
                $this->addError('groupServices.' . $key, 'يجب حفظ هذا الخدمة قبل تعديل خدمة اخري.');
                return;
            }
        }
        $this->groupServices[$index]['is_saved'] = false;
    }


    public function save($index)
    {
        $this->resetErrorBag();
        $service = $this->services->find($this->groupServices[$index]['service_id']);
        $this->groupServices[$index]['service_name'] = $service->name;
        $this->groupServices[$index]['service_price'] = $service->price;
        if ($this->groupServices[$index]['quantity'] <= 0 || $this->groupServices[$index]['quantity'] > 10) {
            $this->groupServices[$index]['is_saved'] = false;
            $this->addError("groupServices.{$index}", ' يجب ان تكون عدد المرات اكبر من 0 واصغر من 10');
            return;
        }
        foreach ($this->groupServices as $selectedService)  {
            if ($selectedService['is_saved'] === true && $selectedService['service_id'] == $service->id ) {
                $this->groupServices[$index]['is_saved'] = false;
                $this->addError("groupServices.{$index}", 'يجب ان تكون القمية غير مكررة ');
                return;
            }
        }
        $this->groupServices[$index]['is_saved'] = true;
    }

    public function remove($index)
    {
        unset($this->groupServices[$index]);
        $this->groupServices = array_values($this->groupServices);
    }


    public function storeOrUpdate()
    {
        $validation = Validator::make([
            'description' => $this->description,
            'groupServices' => $this->groupServices,
            ], $this->rules(), $this->messages, $this->attributes());
        if ($validation->fails()) {
            $this->showErrors = true;
            $validation->validate();
        }

        try {
            DB::beginTransaction();

            if ($this->updateMode) {
                $group = GroupService::findOrFail($this->group_id);

                $groupServiceStoredValidator = Validator::make($this->getGroupNameProperty(), [
                        'group_name' => ['required', 'string', 'not_in:sex,kill,fuck', 'min:4',
                            Rule::unique('group_service_translations', 'name')->ignore($group->id)
                            , new ForbiddenWords()]
                ], $this->getGroupNameMessages(), $this->getGroupNameAttribute());


                if ($groupServiceStoredValidator->fails()) {
                    $this->showErrors = true;
                    $groupServiceStoredValidator->validate();
                }

                $group->update([
                    'total_before_discount' => $this->get_total_befor_discount(),
                    'discount_value' => $this->discount_value,
                    'total_after_discount' => $this->get_total_after_discount(),
                    'tax_rate' => $this->taxes,
                    'total_with_tax' => $this->get_total_with_taxes(),
                    'name' => $this->group_name,
                    'description' => $this->description,
                    'updated_at' => Carbon::now(),
                    ]);

                $group->group_service()->detach();

                foreach ($this->groupServices as $selectedService) {
                    $group->group_service()->attach($selectedService['service_id'], [
                        'quantity' => $selectedService['quantity']
                    ]);

                    if (count($this->groupServices) < 2 &&  $selectedService['quantity']== 1) {
                        DB::rollBack();
                        $this->addError('length',
                            'خطأ أثناء التعديل!! يجب ان تزيد مجموعة الخدمات عن خدمة واحدة أو أن تكون
                             عدد مرات استخدام الخدمة الواحدة أكتر من مرة.');
                        $this->showErrors = true;
                        return;
                    }
                }

                $this->storedGroup = false;
                $this->updatedGroup = true;

            } else {
                $groupServiceStoredValidator = Validator::make($this->getGroupNameProperty(),
                    $this->getStoredGroupNameRules(),
                    $this->getGroupNameMessages(), $this->getGroupNameAttribute());

                if ($groupServiceStoredValidator->fails()) {
                    $this->showErrors = true;
                    $groupServiceStoredValidator->validate();
                }
                $group = GroupService::create([
                    'total_before_discount' => $this->get_total_befor_discount(),
                    'discount_value' => $this->discount_value,
                    'total_after_discount' => $this->get_total_after_discount(),
                    'tax_rate' => $this->taxes,
                    'total_with_tax' => $this->get_total_with_taxes(),
                    'name' => $this->group_name,
                    'description' => $this->description,
                    'updated_at' => null,
                    ]);

                foreach ($this->groupServices as $selectedService) {
                    $group->group_service()->attach($selectedService['service_id'], [
                        'quantity' => $selectedService['quantity']
                    ]);

                    if (count($this->groupServices) < 2 &&  $selectedService['quantity']== 1) {
                        DB::rollBack();
                        $this->addError('length', 'يجب ان تزيد مجموعة الخدمات عن خدمة واحدة أو أن تكون
                         عدد مرات استخدام الخدمة الواحدة أكتر من مرة');
                        $this->showErrors = true;
                        return;
                    }
                }

                $this->updatedGroup = false;
                $this->storedGroup = true;
            }

            DB::commit();
            $this->reset('groupServices', 'group_name', 'description');
            $this->discount_value = 0;
            $this->showTable = true;
        } catch (\Exception $error) {
            DB::rollBack();
            $this->storedGroup = false;
            $this->updatedGroup = false;
            $this->addError('errors', $error->getMessage());
        }
    }

    public function clear_errors_alerts_inputs_and_hideTable()
    {
        $this->resetErrorBag();
        $this->reset('groupServices', 'group_name', 'description');
        $this->showTable = false;
        $this->showErrors = false;
        $this->storedGroup = false;
        $this->updatedGroup = false;
        $this->deletedGroup = false;
    }

    public function create()
    {
        $this->clear_errors_alerts_inputs_and_hideTable();
        $this->updateMode = false;
    }

    public function edit($id)
    {
        $this->clear_errors_alerts_inputs_and_hideTable();
        $this->updateMode = true;
        $group = GroupService::where('id',$id)->first();
        $this->group_id = $id;
        $this->group_name= $group->name;
        $this->description= $group->description;

        $this->discount_value = intval($group->discount_value);
        $this->storedGroup = false;

        foreach ($group->group_service as $serviceSelected)
        {
            $this->groupServices[] = [
                'service_id' => $serviceSelected->id,
                'quantity' => $serviceSelected->pivot->quantity,
                'is_saved' => true,
                'service_name' => $serviceSelected->name,
                'service_price' => $serviceSelected->price
            ];
        }
    }

    public function destroy($id)
    {
        GroupService::destroy($id);
        $this->updatedGroup = false;
        $this->storedGroup = false;
        $this->deletedGroup = true;
        $this->showTable = true;
    }


    // This function uses for making dark functions light up (only for format some code).
    public function lightUpSomeFunctions(): array
    {
      return [
          'update_or_store' => $this->storeOrUpdate(),
          'setDefaultQuantity' => $this->setDefaultQuantity() ,
          'editSelectedService' => $this->editSelectedService() ,
      ];
    }
}

// Save All code
