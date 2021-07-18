<?php

namespace App\Http\Controllers\API\V1\Admin;

use API;
use App\Enums\ManyToManyAction;
use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\WorkoutResource;
use App\Models\Difficulty;
use App\Models\Equipment;
use App\Models\Muscle;
use App\Models\Workout;
use App\Repositories\V1\WorkoutsRepository;
use Illuminate\Http\Request;

class WorkoutsController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\WorkoutsRepository
     */
    protected $repo = WorkoutsRepository::class;

    /**
     * @var \App\Http\Resources\V1\WorkoutResource
     */
    protected $resource = WorkoutResource::class;

    /**
     * Validate store request input.
     * 
     * @param \Illuminate\Http\Request $request 
     * @return array 
     */
    protected function storeValidator(Request $request): array
    {
        return [
            'workout_id' => 'nullable|exists:' . Workout::class . ',id',
            'difficulty_id' => 'required|exists:' . Difficulty::class . ',id',
            'cover' => 'required',
            'illustration' => 'required',
            'name' => 'required|unique:' . Workout::class . ',name',
            'description' => 'required',
            // Equipment
            'equipment' => 'required|array',
            'equipment.*' => 'exists:' . Equipment::class . ',id',
            // Muscles
            'muscles' => 'required|array',
            'muscles.*.id' => 'required|exists:' . Muscle::class . ',id',
            'muscles.*.primary' => 'required|boolean',
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

        $validations['name'] = $validations['name'] . ',' . $id . ',id';

        $validations['muscles'] = str_replace('required', 'nullable', $validations['muscles']);
        $validations['equipment'] = str_replace('required', 'nullable', $validations['equipment']);

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

    /**
     * Relaciones a cargar al consultar el listado.
     * 
     * @return array 
     */
    protected function indexRelations()
    {
        return [
            'workout',
            'difficulty',
        ];
    }

    /**
     * Relaciones a cargar al consultar 1 elemento.
     * 
     * @return array 
     */
    protected function showRelations()
    {
        return [
            'workout',
            'difficulty',
            'muscles',
            'equipment',
        ];
    }

    /**
     * Relaciones a cargar al consultar 1 elemento a editar.
     * 
     * @return array 
     */
    protected function editRelations()
    {
        return $this->showRelations();
    }

    /**
     * Agrega músculos.
     * 
     * @param \Illuminate\Http\Request $request 
     * @param mixed $id 
     * @return \Illuminate\Http\JsonResponse 
     * @throws \Error 
     * @throws \App\Utils\API\Error404 
     * @throws \InvalidArgumentException 
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException 
     */
    public function attachMuscles(Request $request, $id)
    {
        $request->validate([
            'muscles' => 'required|array|min:1',
            'muscles.*.id' => 'required|exists:' . Muscle::class . ',id',
            'muscles.*.primary' => 'required|boolean',
        ]);

        $data = $request->muscles;

        $this->repo->updateMuscles($id, ManyToManyAction::ATTACH(), $data);

        return API::response200();
    }

    /**
     * Elimina los músculos especificados (primarios o secundarios).
     * 
     * @param \Illuminate\Http\Request $request 
     * @param mixed $id 
     * @return \Illuminate\Http\JsonResponse 
     * @throws \Error 
     * @throws \App\Utils\API\Error404 
     * @throws \InvalidArgumentException 
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException 
     */
    public function detachMuscles(Request $request, $id)
    {
        $request->validate([
            'muscles' => 'required|array|min:1',
            'muscles.*' => 'exists:' . Muscle::class . ',id',
        ]);

        $data = $request->muscles;

        $this->repo->updateMuscles($id, ManyToManyAction::DETACH(), $data);

        return API::response200();
    }

    /**
     * Elimina todos los músculos (primarios o secundarios).
     * @param mixed $id 
     * @return \Illuminate\Http\JsonResponse 
     * @throws \Error 
     * @throws \App\Utils\API\Error404 
     * @throws \InvalidArgumentException 
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException 
     */
    public function detachAllMuscles($id)
    {
        $this->repo->updateMuscles($id, ManyToManyAction::DETACH_ALL());

        return API::response200();
    }

    /**
     * Agrega nuevos equipos.
     * 
     * 
     * @param \Illuminate\Http\Request $request 
     * @param mixed $id 
     * @return \Illuminate\Http\JsonResponse 
     * @throws \Error 
     * @throws \App\Utils\API\Error404 
     * @throws \InvalidArgumentException 
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException 
     */
    public function attachEquipment(Request $request, $id)
    {
        $request->validate([
            'equipment' => 'required|array|min:1',
            'equipment.*' => 'exists:' . Equipment::class . ',id',
        ]);

        $data = $request->equipment;

        $this->repo->updateEquipment($id, ManyToManyAction::ATTACH(), $data);

        return API::response200();
    }

    /**
     * Elimina los equipos especificados.
     * 
     * @param \Illuminate\Http\Request $request 
     * @param mixed $id 
     * @return \Illuminate\Http\JsonResponse 
     * @throws \Error 
     * @throws \App\Utils\API\Error404 
     * @throws \InvalidArgumentException 
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException 
     */
    public function detachEquipment(Request $request, $id)
    {
        $request->validate([
            'equipment' => 'required|array|min:1',
            'equipment.*' => 'exists:' . Equipment::class . ',id',
        ]);

        $data = $request->equipment;

        $this->repo->updateEquipment($id, ManyToManyAction::DETACH(), $data);

        return API::response200();
    }

    /**
     * Elimina todos los equipos asociados.
     * 
     * @param mixed $id 
     * @return \Illuminate\Http\JsonResponse 
     * @throws \Error 
     * @throws \App\Utils\API\Error404 
     * @throws \InvalidArgumentException 
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException 
     */
    public function detachAllEquipment($id)
    {
        $this->repo->updateEquipment($id, ManyToManyAction::DETACH_ALL());

        return API::response200();
    }
}
