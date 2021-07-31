<?php

namespace App\Http\Controllers\API\V1\Admin;

use API;
use App\Enums\ManyToManyAction;
use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\ExerciseResource;
use App\Models\Equipment;
use App\Models\Muscle;
use App\Repositories\V1\ExercisesRepository;
use Illuminate\Http\Request;

class ExercisesController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\ExercisesRepository
     */
    protected $repo = ExercisesRepository::class;

    /**
     * @var \App\Http\Resources\V1\ExerciseResource
     */
    protected $resource = ExerciseResource::class;

    /**
     * Indica las relaciones que se cargaran según el método indicado.
     * 
     * @param string $method 
     * @return array 
     */
    protected function loadRelations(string $method)
    {
        $relations = [];

        if ($method === 'index') {
            $relations = [
                'exercise',
                'difficulty',
            ];
        }

        if ($method === 'show' || $method === 'edit') {
            $relations = [
                'exercise',
                'difficulty',
                'muscles',
                'equipment',
            ];
        }

        return $relations;
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
