<?php

namespace App\Http\Controllers;
use App\Services\Contracts\CustomerServiceInterface;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;


class CustomerController extends Controller
{
      public function __construct(
        private readonly CustomerServiceInterface $customerService
    ) {}
    public function index ()
    {
        $customers = $this->customerService->getAllCustomers();
        return view('admin.customers.index', compact('customers'));
    }
    public function create () 
    {
        return view('admin.customers.create');
    }
    public function store (StoreCustomerRequest $request) 
    {
        $this->customerService->storeCustomer($request->validated());
        return redirect()->route('admin.customers.index')->with('success','Khách hàn vừa được tạo thành công ');
    }
    public function edit ($id) 
    {
        $customer = $this->customerService->getById($id);   
        return view('admin.customers.edit', compact('customer'));
    }
    public function update (UpdateCustomerRequest $request, $id)
    {
        $this->customerService->updateCustomer($request->validated(), $id);
        return redirect()->route('admin.customers.index')->with('success','Thông tin khách hàng vừa được bạn cập nhật thành công');
    }
    public function destroy ($id)
    {
        $this->customerService->deleteCustomer($id);
        return redirect()->route('admin.customers.index')->with('success','Xóa khách hàng thành công ');
    }
}
