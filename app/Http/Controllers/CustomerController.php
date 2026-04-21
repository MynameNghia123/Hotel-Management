<?php

namespace App\Http\Controllers;
use App\Services\Contracts\CustomerServiceInterface;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Traits\PaginationTrait;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use PaginationTrait;
    
    public function __construct(
        private readonly CustomerServiceInterface $customerService
    ) {}
    
    public function index(Request $request)
    {
        $perPage = $this->getPerPage(10);
        $filters = $request->with('filter', []);
       
        $countries = $this->customerService->getDistinctCountries();
        $customers = $this->customerService->getPaginated($filters, $perPage);
        $this->validatePageNumber($customers->currentPage(), $customers->lastPage(), 'abort');  
        return view('admin.customers.index', compact('customers', 'countries'));
    }
    
    public function create()
    {
        $countries = \App\Utils\Countries::getList();
        return view('admin.customers.create', compact('countries'));
    }
    
    public function store(StoreCustomerRequest $request)
    {
        try {
            $this->customerService->create($request->validated());
            return redirect()->route('admin.customers.index')->with('success', 'Khách hàng vừa được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
    
    public function edit($id)
    {
        $customer = $this->customerService->findById($id);
        $countries = \App\Utils\Countries::getList();
        return view('admin.customers.edit', compact('customer', 'countries'));
    }

    public function show($id)
    {
        $customer = $this->customerService->findById($id);
        return view('admin.customers.show', compact('customer'));
    }
    
    public function update(UpdateCustomerRequest $request, $id)
    {
        try {
            $this->customerService->update($id, $request->validated());
            return redirect()->route('admin.customers.index')->with('success', 'Thông tin khách hàng vừa được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $this->customerService->delete($id);
            return redirect()->route('admin.customers.index')->with('success', 'Xóa khách hàng thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
