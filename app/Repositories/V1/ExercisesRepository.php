<?php

namespace App\Repositories\V1;

use App\Enums\Directories;
use App\Models\Exercise;
use App\Repositories\Repository;
use DB;
use App\Enums\ManyToManyAction;
use App\Models\Difficulty;
use App\Models\Equipment;
use App\Models\Muscle;
use App\Repositories\Traits\RepositoryUtils;
use Arrays;
use Files;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ExercisesRepository extends Repository
{
    use  RepositoryUtils;

    /**
     * Classname del modelo principal del repositorio (Model::class).
     *
     * @var string
     */
    protected $model = Exercise::class;

    /**
     * Indica por que columna ordenar los resultados.
     * 
     * ['column', 'asc'|'desc', ?'localized']
     * 
     * (opcional) Si se indica `localized` se buscara la columna en la db según el idioma actual de 
     * la aplicación.
     * 
     * Ej. Se pasa la columna `product`, se ordenara por la columna `product_en` si la
     * aplicación esta en ingles.
     * 
     * @var array
     */
    protected $orderBy = ['name', 'asc'];

    /**
     * Contiene los keys de los posibles valores del atributo $data
     * en el método `create` y `update`.
     * 
     * @param array $data
     * @param string $method Indica el método donde se esta llamando.
     * @param array $options
     * @return array
     */
    public function availableInputKeys(array $data, string $method, array $options = [])
    {
        $inputs = [
            'difficulty_id',
            'image',
            'illustration',
            'name',
            'description',
            // Son opcionales
            'muscles',
            'equipment',
        ];

        if ($method === 'index') {
            $inputs = array_merge($inputs, [
                'created_at',
                'updated_at',
                'deleted_at',
            ]);
        }

        return $inputs;
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
    public function canCreate(array $data, array $options = [])
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
    public function canUpdate($item, ?array $data = [], array $options = [])
    {
        //
    }

    /**
     * Valida si se puede eliminar el registro.
     * 
     * @param Exercise $item 
     * @return void 
     */
    public function canDelete($item, array $options = [])
    {
        //
    }

    /**
     * Permite encargarse de las opciones adicionales.
     *
     * @param Builder $builder
     * @param array $options
     * @return Builder
     */
    public function handleOptions(Builder $builder, array $options = [])
    {
        $params = $options['params'] ?? null;

        if ($params !== null) {
            $this->handleSearchInput($builder, $params['name']);
            $this->handleWhereHas($builder, 'difficulty', $params['difficulty']);
            $this->handleDateInput($builder, $params['created_at'], true);
            $this->handleDateInput($builder, $params['updated_at'], true);
        }

        return $builder;
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
     * - (string)   `data.difficulty_id`: 
     * - (file)     `data.image`: 
     * - (file)     `data.illustration`: 
     * - (string)   `data.name`: 
     * - (string)   `data.description`: 
     * - (array)    `data.muscles`: Revisar `$this->updateMuscles()`
     * - (array)    `data.equipment`: Revisar `$this->updateEquipment()`
     * 
     * @return Exercise
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data, array $options = [])
    {
        $imagesToStore = [];

        DB::beginTransaction();
        try {
            $data = Arrays::preserveKeys($data, $this->availableInputKeys($data, 'create'));

            $muscles = $data['muscles'] ?? [];
            $equipment = $data['equipment'] ?? [];

            /** @var \Illuminate\Http\UploadedFile|null */
            $image = $data['image'] ?? null;
            /** @var \Illuminate\Http\UploadedFile|null */
            $illustration = $data['illustration'] ?? null;

            $data['image'] = $data['illustration'] = 'no_image.jpg';

            $data = Arrays::omitKeys($data, [
                'muscles',
                'equipment',
            ]);

            /** @var \App\Models\Exercise */
            $item = parent::create($data, $options);

            if ($image !== null) {
                $imageName = Files::generateName('image', [
                    'prefix' => $item->id,
                ]);

                $imagesToStore[] = $image = Files::storeImage($image, Directories::EXERCISES_IMAGES(), $imageName, true);

                if ($image !== null) {
                    $item->image = $image['image'];
                }
            }

            if ($illustration !== null) {
                $illustrationName = Files::generateName('illustration', [
                    'prefix' => $item->id,
                ]);

                $imagesToStore[] = $illustration = Files::storeImage($illustration, Directories::EXERCISES_ILLUSTRATIONS(), $illustrationName, true);

                if ($image !== null) {
                    $item->illustration = $illustration['image'];
                }
            }

            $item->update();

            $this->updateEquipment($item, ManyToManyAction::ATTACH(), $equipment);
            $this->updateMuscles($item, ManyToManyAction::ATTACH(), $muscles);

            DB::commit();

            return $item;
        } catch (\Throwable $e) {
            Files::deleteImagesStored($imagesToStore);

            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
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
        $imagesToStore = [];

        DB::beginTransaction();
        try {
            $data = Arrays::preserveKeys($data, $this->availableInputKeys($data, 'create'));

            $muscles = $data['muscles'] ?? [];
            $equipment = $data['equipment'] ?? [];

            /** @var \Illuminate\Http\UploadedFile|null */
            $image = $data['image'] ?? null;
            /** @var \Illuminate\Http\UploadedFile|null */
            $illustration = $data['illustration'] ?? null;

            $data = Arrays::omitKeys($data, [
                'muscles',
                'equipment',
                'image',
                'illustration',
            ]);

            /** @var \App\Models\Exercise */
            $item = parent::update($id, $data, $options);

            if ($image !== null) {
                $imageName = Files::generateName('image', [
                    'prefix' => $item->id,
                ]);

                $imagesToStore[] = $image = Files::storeImage($image, Directories::EXERCISES_IMAGES(), $imageName, true);

                if ($image !== null) {
                    $item->image = $image['image'];
                }
            }

            if ($illustration !== null) {
                $illustrationName = Files::generateName('illustration', [
                    'prefix' => $item->id,
                ]);

                $imagesToStore[] = $illustration = Files::storeImage($illustration, Directories::EXERCISES_ILLUSTRATIONS(), $illustrationName, true);

                if ($image !== null) {
                    $item->illustration = $illustration['image'];
                }
            }

            $item->update();

            $this->updateEquipment($item, ManyToManyAction::ATTACH(), $equipment);
            $this->updateMuscles($item, ManyToManyAction::ATTACH(), $muscles);

            DB::commit();

            return $item;
        } catch (\Throwable $e) {
            Files::deleteImagesStored($imagesToStore);

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
        return $this->defaultUpdateManyToManyRelation($id, $action, $data, array_merge([
            'relationName' => 'muscles',
            'relatedKey' => 'muscle_id',
            'isArrayOfIds' => false,
        ], $options));
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
        return $this->defaultUpdateManyToManyRelation($id, $action, $data, array_merge([
            'relationName' => 'equipment',
            'relatedKey' => 'equipment_id',
        ], $options));
    }
}
