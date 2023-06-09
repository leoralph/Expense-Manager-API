<?php

namespace App\Http\Controllers;

use App\Events\ExpenseCreated;
use App\Http\Requests\ExpensePaginationRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Request;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Expense::class, 'expense');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ExpensePaginationRequest $request)
    {
        $expenses = auth()->user()->expenses();

        if ($request->has('search')) {
            $expenses->where('description', 'like', "%{$request->search}%");
        }

        if ($request->has('sort_by')) {
            $expenses->orderBy($request->sort_by, $request->sort_direction ?? 'asc');
        }

        return ExpenseResource::collection($expenses->paginate($request->per_page));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request): JsonResponse
    {
        $expense = new Expense($request->validated());

        $expense->user()->associate(auth()->user());

        $expense->save();

        event(new ExpenseCreated($expense));

        return response()->json([
            'message' => __('messages.expense.created'),
            'expense' => ExpenseResource::make($expense)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense): JsonResponse
    {
        $expense->update($request->validated());

        return response()->json([
            'message' => __('messages.expense.updated'),
            'expense' => $expense
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return response()->json([
            'message' => __('messages.expense.deleted')
        ], 200);
    }
}
