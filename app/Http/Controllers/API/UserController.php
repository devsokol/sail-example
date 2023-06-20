<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\Models\User;
use App\Exceptions\StoreErrorHandler;
use Exception;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * The user service instance.
     *
     * @var UserService
     */
    protected $userService;

    /**
     * Create a new UserController instance.
     *
     * @param UserService $userService The user service instance.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param UserRequest $request The incoming HTTP request.
     * @param StoreErrorHandler $errorHandler The error handler for the operation.
     *
     * @throws Exception If an error occurs while creating the user.
     *
     * @return Response The HTTP response object.
     */
    public function store(UserRequest $request, StoreErrorHandler $errorHandler): Response
    {
        try {
            $user = $this->userService->store($request->validated());

            return response()->json($user, Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $errorHandler->handle($exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request The incoming HTTP request.
     * @param StoreErrorHandler $errorHandler The error handler for the operation.
     * @param User $user The user instance to be updated.
     *
     * @throws Exception If an error occurs while updating the user.
     *
     * @return Response The HTTP response object.
     */
    public function update(UserRequest $request, StoreErrorHandler $errorHandler, User $user): Response
    {
        try {
            $user->fill($request->validated());
            $user->save();

            return response()->json($user, Response::HTTP_OK);
        } catch (Exception $exception) {
            return $errorHandler->handle($exception);
        }
    }

    /**
     * Delete a user from the database.
     *
     * @param User $user The user instance to be deleted.
     *
     * @return Response The HTTP response object.
     */
    public function destroy(User $user): Response
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
