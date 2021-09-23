<?php

namespace App\Repositories\V1;

use App\Enums\Directories;
use App\Models\Equipment;
use App\Repositories\Repository;
use App\Repositories\Traits\RepositoryUtils;
use DB;
use Files;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EquipmentRepository extends Repository
{
    use  RepositoryUtils;

    /**
     * Classname del modelo principal del repositorio (Model::class).
     *
     * @var string
     */
    protected $model = Equipment::class;

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
            'name',
            'image',
            'description',
        ];

        if (array_key_exists('customId', $options)) {
            $inputs[] = 'id';
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
            'name' => 'required|unique:' . Equipment::class . ',name',
            'image' => 'required|image',
            'description' => 'required',
        ];

        if ($method === 'update') {
            $rules['name'] = $rules['name'] . ',' . $id . ',id';
            $rules['image'] = str_replace('required', 'nullable', $rules['name']);
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
     * @param Equipment $item 
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
     * @param Equipment $item 
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
            $this->handleDateInput($builder, $params['created_at'], true);
            $this->handleDateInput($builder, $params['updated_at'], true);
        }

        return $builder;
    }

    /**
     * Consulta todos los registros.
     *
     * @param array $options Las mismas opciones que en `Repository::prepareQuery($options)`
     * @return \Illuminate\Support\Collection|Equipment[]
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
     * @return null|Equipment
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
     * @return Equipment
     */
    public function findOrFail($id, array $options = [])
    {
        return parent::findOrFail($id, $options);
    }

    /**
     * Almacena una imagen.
     * 
     * @param \Illuminate\Http\UploadedFile $image 
     * @param \App\Models\Equipment $item 
     * @param string $method 
     * @return (null|string)[]|null 
     * @throws \Exception 
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException 
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException 
     */
    private function storeImage($image, &$item, string $method = 'create')
    {
        if ($image !== null) {
            $imageName = Files::generateName('image', [
                'prefix' => $item->id,
                'postfix' => 'random',
            ]);

            $image = Files::storeImage($image, Directories::EQUIPMENT_IMAGES(), $imageName, true);

            if ($image !== null) {
                if ($method === 'update') {
                    Files::deleteImage(Directories::EQUIPMENT_IMAGES(), $item->image);
                }

                $item->image =  $image['image'];
            }
        }

        return $image;
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data Contiene los campos a insertar en la tabla del modelo.
     * 
     * - (string)   `data.name`
     * - (string)   `data.description`
     * 
     * @return Equipment
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data, array $options = [])
    {
        $imagesToStore = [];

        DB::beginTransaction();
        try {
            /** @var \Illuminate\Http\UploadedFile */
            $image = $data['image'];
            $data['image'] = '';

            $item = parent::create($data, $options);

            $imagesToStore[] = $this->storeImage($image, $item);

            $item->update();

            DB::commit();

            return $item;
        } catch (\Throwable $th) {
            DB::rollBack();

            Files::deleteImagesStored($imagesToStore);

            throw $th;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param int $id
     * @param array $data Contiene los campos a actualizar.
     * 
     * - (string)   `data.name`
     * - (string)   `data.description`
     * 
     * @param array $options
     * @return Equipment
     * @throws \Exception
     * @throws \Throwable
     */
    public function update($id, array $data, array $options = [])
    {
        $imagesToStore = [];

        DB::beginTransaction();
        try {
            /** @var \Illuminate\Http\UploadedFile */
            $image = $data['image'] ?? null;
            unset($data['image']);

            $item = parent::update($id, $data, $options);

            $imagesToStore[] = $this->storeImage($image, $item, 'update');

            $item->update();

            DB::commit();

            return $item;
        } catch (\Throwable $th) {
            DB::rollBack();

            Files::deleteImagesStored($imagesToStore);

            throw $th;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param int $id
     * @param array $options
     * @return Equipment
     * @throws \Exception
     * @throws \Throwable
     */
    public function delete($id, array $options = [])
    {
        $options['onDeletePermanently'] = function (Equipment $item) {
            Files::deleteImage(Directories::EQUIPMENT_IMAGES(), $item->image);
        };

        return parent::delete($id, $options);
    }
}
