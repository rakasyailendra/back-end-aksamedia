<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::with('division')
            ->when(request('name'), fn($query, $name) => $query->where('name', 'like', "%{$name}%"))
            ->when(request('division_id'), fn($query, $id) => $query->where('division_id', $id))
            ->paginate(5);

        return EmployeeResource::collection($employees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\EmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/employees');
            $validated['image'] = $path;
        }

        $employee = Employee::create($validated);

        return new EmployeeResource($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        // Mengembalikan data satu pegawai menggunakan EmployeeResource
        return new EmployeeResource($employee->load('division'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EmployeeRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        // Ambil data yang sudah divalidasi
        $validated = $request->validated();

        // Cek jika ada file gambar baru yang di-upload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($employee->image) {
                Storage::delete($employee->image);
            }

            // Simpan gambar baru dan update path-nya
            $path = $request->file('image')->store('public/employees');
            $validated['image'] = $path;
        }

        // Update data pegawai
        $employee->update($validated);

        // Kembalikan response
        return new EmployeeResource($employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        // Hapus gambar dari storage jika ada
        if ($employee->image) {
            Storage::delete($employee->image);
        }

        // Hapus data pegawai dari database
        $employee->delete();

        // Kembalikan response JSON sesuai format yang diminta
        return response()->json([
            'status' => 'success',
            'message' => 'Data karyawan berhasil dihapus.'
        ]);
    }
}
