<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Repositories\V1\UsersRepository;
use Illuminate\Http\Request;

class UsersController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\UsersRepository
     */
    protected $repo = UsersRepository::class;

    /**
     * @var \App\Http\Resources\V1\UserResource
     */
    protected $resource = UserResource::class;

    /**
     * Validate store request input.
     * 
     * @param \Illuminate\Http\Request $request 
     * @return array 
     */
    protected function storeValidator(Request $request): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:' . User::class . ',email',
            'password' => 'required|confirmed|min:8',
        ];
    }

    /**
     * Get data from store request.
     * 
     * @param \Illuminate\Http\Request $request 
     * @return array 
     */
    protected function getStoreData(Request $request): array
    {
        return $request->all();
    }

    /**
     * Get data from update request.
     * 
     * @param \Illuminate\Http\Request $request 
     * @param string $id 
     * @return array 
     */
    protected function updateValidator(Request $request, string $id): array
    {
        $validations = $this->storeValidator($request);

        $validations['email'] = $validations['email'] . ',' . $id . ',id';
        $validations['password'] = str_replace('required', 'nullable', $validations['password']);

        return $validations;
    }

    /**
     * Get data from update request.
     * 
     * @param \Illuminate\Http\Request $request 
     * @param string $id 
     * @return array 
     */
    protected function getUpdateData(Request $request, string $id): array
    {
        return $this->getStoreData($request);
    }
}
