<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Traits\PaginationTrait;
use App\Services\Contracts\CustomerServiceInterface;
use App\Utils\Countries;
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
        $filters = $request->input('filter', []);
        $customers = $this->customerService->getPaginated($filters, $perPage);
        $this->validatePageNumber($customers->currentPage(), $customers->lastPage(), 'abort');

        return view('admin.customers.index', [
            'customers' => $customers,
            'countries' => $this->customerService->getDistinctCountries(),
        ]);
    }

    public function create()
    {
        $countries = Countries::getList();

        return view('admin.customers.create', compact('countries'));
    }

    public function store(StoreCustomerRequest $request)
    {
        try {
            $this->customerService->create($request->validated());

            return redirect()->route('admin.customers.index')->with('success', 'Khách hàng vừa được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi: '.$e->getMessage());
        }
    }

    public function edit($id)
    {
        return view('admin.customers.edit', [
            'customer' => $this->customerService->findById($id),
            'countries' => Countries::getList(),
        ]);
    }

    public function show($id)
    {
        return view('admin.customers.show', [
            'customer' => $this->customerService->findById($id),
        ]);
    }

    public function update(UpdateCustomerRequest $request, $id)
    {
        try {
            $this->customerService->update($id, $request->validated());

            return redirect()->route('admin.customers.index')->with('success', 'Thông tin khách hàng vừa được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->customerService->delete($id);

            return redirect()->route('admin.customers.index')->with('success', 'Xóa khách hàng thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: '.$e->getMessage());
        }
    }
}
