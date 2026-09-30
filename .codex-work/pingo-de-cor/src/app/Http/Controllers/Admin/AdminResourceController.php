<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class AdminResourceController extends Controller
{
    public function index(string $resource): View
    {
        $definition = $this->definition($resource);
        $primaryKey = $definition['primary_key'];
        $records = $definition['model']::query()->orderByDesc($primaryKey)->get();
        $fields = $this->hydrateOptions($definition['fields']);

        return view('admin.resources.index', compact('resource', 'definition', 'records', 'fields'));
    }

    public function store(Request $request, string $resource): RedirectResponse
    {
        $definition = $this->definition($resource);
        $validated = $request->validate($this->validationRules($definition, 'create'));
        $uploadedPaths = [];

        try {
            DB::beginTransaction();
            $data = $this->prepareData($request, $validated, $definition, $resource, $uploadedPaths);
            $definition['model']::query()->create($data);
            DB::commit();

            return $this->redirectTo($resource)
                ->with('sucesso', ucfirst($definition['singular']).' criado(a) com sucesso.');
        } catch (Throwable $exception) {
            DB::rollBack();
            $this->deleteImages($uploadedPaths);
            report($exception);

            return back()->withInput()->with('erro', 'Não foi possível criar o registro. Tente novamente.');
        }
    }

    public function update(Request $request, string $resource, int $id): RedirectResponse
    {
        $definition = $this->definition($resource);
        $record = $definition['model']::query()->findOrFail($id);
        $validated = $request->validate($this->validationRules($definition, 'update', $id));
        $uploadedPaths = [];
        $oldImages = [];

        try {
            DB::beginTransaction();
            $data = $this->prepareData(
                $request,
                $validated,
                $definition,
                $resource,
                $uploadedPaths,
                $record,
                $oldImages,
            );
            $record->update($data);
            DB::commit();
            $this->deleteImages($oldImages);

            return $this->redirectTo($resource)
                ->with('sucesso', ucfirst($definition['singular']).' atualizado(a) com sucesso.');
        } catch (Throwable $exception) {
            DB::rollBack();
            $this->deleteImages($uploadedPaths);
            report($exception);

            return back()->withInput()->with('erro', 'Não foi possível atualizar o registro. Tente novamente.');
        }
    }

    public function destroy(string $resource, int $id): RedirectResponse
    {
        $definition = $this->definition($resource);
        $record = $definition['model']::query()->findOrFail($id);
        $images = [];

        foreach ($definition['fields'] as $name => $field) {
            if (($field['type'] ?? null) === 'file' && $record->{$name}) {
                $images[] = $record->{$name};
            }
        }

        try {
            DB::transaction(fn () => $record->delete());
            $this->deleteImages($images);

            return $this->redirectTo($resource)
                ->with('sucesso', ucfirst($definition['singular']).' excluído(a) com sucesso.');
        } catch (QueryException $exception) {
            report($exception);

            return $this->redirectTo($resource)->with(
                'erro',
                'Este registro está sendo usado em outra seção e não pode ser excluído.',
            );
        } catch (Throwable $exception) {
            report($exception);

            return $this->redirectTo($resource)
                ->with('erro', 'Não foi possível excluir o registro. Tente novamente.');
        }
    }

    private function definition(string $resource): array
    {
        $definition = config("admin_resources.{$resource}");

        abort_unless(is_array($definition), 404);

        return $definition;
    }

    private function hydrateOptions(array $fields): array
    {
        foreach ($fields as &$field) {
            if (! isset($field['options_model'])) {
                continue;
            }

            $field['options'] = $field['options_model']::query()
                ->orderBy($field['option_label'])
                ->pluck($field['option_label'], $field['option_value'])
                ->all();
        }
        unset($field);

        return $fields;
    }

    private function validationRules(array $definition, string $operation, ?int $id = null): array
    {
        $rules = [];

        foreach ($definition['fields'] as $name => $field) {
            $fieldRules = $field[$operation.'_rules'] ?? $field['rules'] ?? ['nullable'];
            $rules[$name] = array_map(
                fn ($rule) => is_string($rule) ? str_replace('{id}', (string) $id, $rule) : $rule,
                $fieldRules,
            );
        }

        return $rules;
    }

    private function prepareData(
        Request $request,
        array $validated,
        array $definition,
        string $resource,
        array &$uploadedPaths,
        mixed $record = null,
        array &$oldImages = [],
    ): array {
        $data = [];
        $baseName = (string) ($validated[$definition['title_field']] ?? $definition['singular']);

        foreach ($definition['fields'] as $name => $field) {
            if (($field['type'] ?? null) === 'file') {
                if (! $request->hasFile($name)) {
                    continue;
                }

                if ($record && $record->{$name}) {
                    $oldImages[] = $record->{$name};
                }

                $path = $this->storeImage($request->file($name), $resource, $baseName);
                $uploadedPaths[] = $path;
                $data[$name] = $path;
                continue;
            }

            if (! array_key_exists($name, $validated)) {
                continue;
            }

            if (($field['hash'] ?? false) && blank($validated[$name])) {
                continue;
            }

            $data[$name] = ($field['hash'] ?? false)
                ? Hash::make($validated[$name])
                : $validated[$name];
        }

        return $data;
    }

    private function storeImage(UploadedFile $image, string $resource, string $baseName): string
    {
        $directory = public_path("adminDecor/uploads/{$resource}");
        File::ensureDirectoryExists($directory);

        $slug = Str::slug($baseName) ?: $resource;
        $extension = strtolower($image->getClientOriginalExtension() ?: $image->extension());
        $fileName = $slug.'_'.Str::lower(Str::random(10)).'.'.$extension;
        $image->move($directory, $fileName);

        return "adminDecor/uploads/{$resource}/{$fileName}";
    }

    private function deleteImages(array $paths): void
    {
        foreach (array_unique($paths) as $path) {
            if (! is_string($path) || ! Str::startsWith($path, 'adminDecor/uploads/')) {
                continue;
            }

            File::delete(public_path($path));
        }
    }

    private function redirectTo(string $resource): RedirectResponse
    {
        return redirect()->route('admin.resources.index', ['resource' => $resource]);
    }
}
