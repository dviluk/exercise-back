<?php

namespace App\Repositories\V1;

use App\Models\Exercise;
use App\Repositories\Repository;
use DB;
use App\Enums\ManyToManyAction;
use App\Models\Difficulty;
use App\Models\Equipment;
use App\Models\Muscle;
use Arrays;
use Illuminate\Http\Request;

class ExercisesRepository extends Repository
{
    /**
     * Classname del modelo principal del repositorio (Model::class).
     *
     * @var string
     */
    protected $model = Exercise::class;

    /**
     * Contiene los keys de los posibles valores del atributo $data
     * en el método `create` y `update`.
     * 
     * @param array $data
     * @param string $method Indica el método donde se esta llamando.
     * @param array $options
     * @return array
     */
    protected function availableInputKeys(array $data, string $method, array $options = [])
    {
        return [
            'exercise_id',
            'difficulty_id',
            'image',
            'illustration',
            'name',
            'description',
            // Son opcionales
            'muscles',
            'equipment',
        ];
    }

    /**
     * Reglas que se aplicaran a los inputs.
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $method Indica el método donde se esta llamando.
     * @param mixed $id
     * @param array $options
     * @return array
     */
    public function inputRules(Request $request, string $method, $id = null, array $options = [])
    {
        $rules = [
            'exercise_id' => 'nullable|exists:' . Exercise::class . ',id',
            'difficulty_id' => 'required|exists:' . Difficulty::class . ',id',
            'image' => 'required|image',
            'illustration' => 'required|image',
            'name' => 'required|unique:' . Exercise::class . ',name',
            'description' => 'required',
            // Equipment
            'equipment' => 'required|array',
            'equipment.*' => 'exists:' . Equipment::class . ',id',
            // Muscles
            'muscles' => 'required|array',
            'muscles.*.id' => 'required|exists:' . Muscle::class . ',id',
            'muscles.*.primary' => 'required|boolean',
        ];

        if ($method === 'update') {
            $rules['name'] = $rules['name'] . ',' . $id . ',id';
            $rules['muscles'] = str_replace('required', 'nullable', $rules['muscles']);
            $rules['equipment'] = str_replace('required', 'nullable', $rules['equipment']);
        }

        return $rules;
    }

    /**
     * Valida si se puede crear un registro.
     * 
     * @param array $data 
     * @return void 
     */
    public function canCreate(array $data)
    {
        //
    }

    /**
     * Valida si se puede editar el registro.
     * 
     * @param Exercise $item 
     * @param null|array $data 
     * @return void 
     */
    public function canUpdate($item, ?array $data = [])
    {
        //
    }

    /**
     * Valida si se puede eliminar el registro.
     * 
     * @param Exercise $item 
     * @return void 
     */
    public function canDelete($item)
    {
        //
    }

    /**
     * Consulta todos los registros.
     *
     * @param array $options Las mismas opciones que en `Repository::prepareQuery($options)`
     * @return \Illuminate\Support\Collection|Exercise[]
     * @throws \Error
     */
    public function all(array $options = [])
    {
        return parent::all($options);
    }

    /**
     * Busca un registro por ID.
     *
     * @param int $id
     * @param array $options Las mismas opciones que en `Repository::prepareQuery($options)`
     * @return null|Exercise
     * @throws \Error
     */
    public function find($id, array $options = [])
    {
        return parent::find($id, $options);
    }

    /**
     * Busca un registro por ID, si no se encuentra se genera un error.
     *
     * @param int $id
     * @param array $options
     * @return Exercise
     */
    public function findOrFail($id, array $options = [])
    {
        return parent::findOrFail($id, $options);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data Contiene los campos a insertar en la tabla del modelo.
     * 
     * - (string)   `data.exercise_id`: 
     * - (string)   `data.difficulty_id`: 
     * - (file)     `data.image`: 
     * - (file)     `data.illustration`: 
     * - (string)   `data.name`: 
     * - (string)   `data.description`: 
     * 
     * Opcionales: 
     * 
     * - (array)    `data.muscles`: Revisar `$this->updateMuscles()`
     * - (array)    `data.equipment`: Revisar `$this->updateEquipment()`
     * 
     * @return Exercise
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data, array $options = [])
    {
        // TODO: Guardar imagen e ilustración
        DB::beginTransaction();
        try {
            $data = Arrays::preserveKeys($data, $this->availableInputKeys($data, 'create'));

            $muscles = $data['muscles'] ?? [];
            $equipment = $data['equipment'] ?? [];

            $data = Arrays::omitKeys($data, [
                'muscles',
                'equipment',
            ]);

            $item = parent::create($data);

            $this->updateEquipment($item, ManyToManyAction::ATTACH(), $equipment);
            $this->updateMuscles($item, ManyToManyAction::ATTACH(), $muscles);

            DB::commit();

            return $item;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * - (string)   `data.exercise_id`: 
     * - (string)   `data.difficulty_id`: 
     * - (file)     `data.image`: 
     * - (file)     `data.illustration`: 
     * - (string)   `data.name`: 
     * - (string)   `data.description`: 
     * 
     * Opcionales: 
     * 
     * - (array)    `data.muscles`: Revisar `$this->updateMuscles()`
     *                              Si se pasa un arreglo vació se eliminan todos los items asociados.
     * - (array)    `data.equipment`: Revisar `$this->updateEquipment()`
     *                                Si se pasa un arreglo vació se eliminan todos los items asociados.
     * 
     * @param int $id
     * @param array $data Contiene los campos a actualizar.
     * @param array $options
     * @return Exercise
     * @throws \Exception
     * @throws \Throwable
     */
    public function update($id, array $data, array $options = [])
    {
        DB::beginTransaction();
        try {
            $data = Arrays::preserveKeys($data, $this->availableInputKeys($data, 'update'));

            $muscles = $data['muscles'] ?? null;
            $equipment = $data['equipment'] ?? null;

            $data = Arrays::omitKeys($data, [
                'muscles',
                'equipment',
            ]);

            $item = parent::update($id, $data, $options);

            if (!is_null($equipment)) {
                $this->updateEquipment($item, ManyToManyAction::SYNC(), $equipment);
            }

            if (!is_null($muscles)) {
                $this->updateMuscles($item, ManyToManyAction::SYNC(), $muscles);
            }

            DB::commit();

            return $item;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param int $id
     * @param array $options
     * @return Exercise
     * @throws \Exception
     * @throws \Throwable
     */
    public function delete($id, array $options = [])
    {
        return parent::delete($id, $options);
    }

    /**
     * Actualiza los músculos asociados.
     * 
     * @param mixed $id 
     * @param \App\Enums\ManyToManyAction $action 
     * @param array $data 
     * 
     * attach|sync
     * 
     * - (string)   `data.*.id`: muscle id
     * - (bool)     `data.*.primary`
     * 
     * detach 
     * 
     * - (string)   `data.*`: muscle id.
     * 
     * @param array $options
     * 
     * - (bool) returnAttachedItems: Indica si se retornaran los items agregados.
     * 
     * @return Exercise|\App\Models\Muscle[]
     * @throws \Error 
     * @throws \App\Utils\API\Error404 
     * @throws \InvalidArgumentException 
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException 
     */
    public function updateMuscles($id, ManyToManyAction $action, array $data = [], array $options = [])
    {
        $item = $this->findOrFail($id);

        $relation = $item->muscles();

        $manyToManyOptions = [
            'isArrayOfIds' => false,
        ];

        $changes = $this->manyToManyActions($relation, $action, $data, $manyToManyOptions);

        if (isset($options['returnAttachedItems'])) {
            return $relation->wherePivotIn('muscle_id', $changes)->get();
        }

        return $item;
    }

    /**
     * Actualiza el equipo asociado.
     * 
     * @param mixed $id 
     * @param \App\Enums\ManyToManyAction $action 
     * @param array $data ids de los items
     * 
     * - (string) `data.*`: equipment id.
     * 
     * @param array $options
     * 
     * - (bool) returnAttachedItems: Indica si se retornaran los items agregados.
     * 
     * @return Exercise|\App\Models\Equipment[]
     * @throws \Error 
     * @throws \App\Utils\API\Error404 
     * @throws \InvalidArgumentException 
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException 
     */
    public function updateEquipment($id, ManyToManyAction $action, array $data = [], array $options = [])
    {
        $item = $this->findOrFail($id);

        $relation = $item->equipment();

        $changes = $this->manyToManyActions($relation, $action, $data);

        if (isset($options['returnAttachedItems'])) {
            return $relation->wherePivotIn('muscle_id', $changes)->get();
        }

        return $item;
    }
}
