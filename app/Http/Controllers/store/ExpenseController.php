<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        get_locale();
        $store_id = get_current_store();
        $expenses = Expense::where('store_id', $store_id)->get();
        return view('store.expenses.index', ['expenses' => $expenses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        get_locale();
        return view('store.expenses.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store_id = get_current_store();
        request()->validate([
            'name' => 'required|max:255',
            'ammount' => 'required',
            'note' => 'nullable|max:255',
            'date' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:1000'
        ]);
        $data = [
            'name' => $request['name'],
            'ammount' => $request['ammount'],
            'date' => $request['date'],
            'store_id' => $store_id
        ];
        if ($request['note'] != null) $data['note'] = $request['note'];

        $expense = Expense::create($data);
        if ($expense) {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() .'.'. $file->getClientOriginalExtension();
                $path = $file->storeAs('expenses', $fileName, 'public');
                $expense->image = $path;
                $expense->save();
            }
            return back()->with(['success' => __('messages.create_success')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        get_locale();
        $expense = Expense::find($id);
        if($expense->store_id != get_current_store()) return abort(403);
        return view('store.expenses.update',['expense'=>$expense]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $store_id = get_current_store();
        $expense = Expense::find($id);
        if($expense->store_id != $store_id) return abort(403);
        request()->validate([
            'name' => 'required|max:255',
            'ammount' => 'required',
            'note' => 'nullable|max:255',
            'date' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:1000'
        ]);
        $data = [
            'name' => $request['name'],
            'ammount' => $request['ammount'],
            'date' => $request['date'],
        ];
        if ($request['note'] != null) $data['note'] = $request['note'];

        $expense->update($data);
        if ($request->hasFile('image')) {
            if($expense->image != null){
                Storage::disk('public')->delete($expense->image);
            }
            $file = $request->file('image');
            $fileName = time() .'.'. $file->getClientOriginalExtension();
            $path = $file->storeAs('expenses', $fileName, 'public');
            $expense->image = $path;
            $expense->save();
        }
        return back()->with(['success'=>__('messages.update_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        if($expense->image != null){
            Storage::disk('public')->delete($expense->image);
        }
        $expense->delete();
        return back()->with(['success'=>__('messages.delete_success')]);
    }
}
