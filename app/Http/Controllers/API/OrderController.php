<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\StoreErrorHandler;
use Exception;
use App\Services\OrderService;
use App\Models\Order;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Enums\OrderStatus;

class OrderController extends Controller
{
    /**
     * The order service instance.
     *
     * @var OrderService
     */
    protected $orderService;

    /**
     * Create a new OrderService instance.
     *
     * @param OrderService $orderService The order service instance.
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of orders with optional status filtering.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $status = $request->query('status');

        if ($status && !in_array($status, OrderStatus::getAllowedValues())) {
            return response()->json(['error' => 'Invalid status'], Response::HTTP_BAD_REQUEST);
        }

        $orders = Order::when($status, function ($query, $status) {
            return $query->where('status', $status);
        })->get();

        return response()->json($orders, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param OrderRequest $request The incoming HTTP request.
     * @param StoreErrorHandler $errorHandler The error handler for the operation.
     *
     * @throws Exception If an error occurs while creating the order.
     *
     * @return Response The HTTP response object.
     */
    public function store(OrderRequest $request, StoreErrorHandler $errorHandler): Response
    {
        try {
            $userId = auth()->user()->id;
            $goodId = $request->validated('good_id');

            $order = $this->orderService->create($userId, $goodId);

            return response()->json($order, Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $errorHandler->handle($exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderRequest $request The incoming HTTP request.
     * @param StoreErrorHandler $errorHandler The error handler for the operation.
     * @param Order $order The user instance to be updated.
     *
     * @throws Exception If an error occurs while updating the order.
     *
     * @return Response The HTTP response object.
     */
    public function update(OrderRequest $request, StoreErrorHandler $errorHandler, Order $order): Response
    {
        Gate::authorize('check', $order);

        try {
            $order->fill($request->validated());
            $order->save();

            return response()->json($order, Response::HTTP_OK);
        } catch (Exception $exception) {
            return $errorHandler->handle($exception);
        }
    }

    /**
     * Delete a order from the database.
     *
     * @param Order $user The user instance to be deleted.
     *
     * @return Response The HTTP response object.
     */
    public function destroy(Order $order): Response
    {
        Gate::authorize('check', $order);

        $order->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
