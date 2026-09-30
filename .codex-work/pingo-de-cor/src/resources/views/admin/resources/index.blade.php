@extends('layout.admin')

@section('title', $definition['label'])
@section('page-title', $definition['label'])

@section('content')
    @php
        $listFields = collect($fields)->filter(fn ($field) => $field['list'] ?? false);
        $primaryKey = $definition['primary_key'];
    @endphp

    <section class="page-heading page-heading-actions">
        <div>
            <span class="eyebrow">Gerenciamento</span>
            <h1>{{ $definition['label'] }}</h1>
            <p>{{ $definition['description'] }}</p>
        </div>
        <button class="button button-primary" type="button" data-dialog-open="create-dialog">
            <span aria-hidden="true">+</span> Criar {{ $definition['singular'] }}
        </button>
    </section>

    <section class="data-card">
        <div class="data-toolbar">
            <div>
                <h2>Registros</h2>
                <span>{{ $records->count() }} {{ $records->count() === 1 ? 'item' : 'itens' }}</span>
            </div>
            <label class="search-box">
                <span class="sr-only">Pesquisar em {{ strtolower($definition['label']) }}</span>
                <span aria-hidden="true">⌕</span>
                <input type="search" placeholder="Pesquisar..." data-table-search autocomplete="off">
            </label>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        @foreach ($listFields as $field)<th scope="col">{{ $field['label'] }}</th>@endforeach
                        <th scope="col" class="actions-column">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $record)
                        @php
                            $recordId = $record->{$primaryKey};
                            $recordData = [];
                            foreach ($fields as $fieldName => $field) {
                                $fieldValue = $record->{$fieldName};
                                if (($field['type'] ?? null) === 'datetime-local' && $fieldValue) {
                                    $fieldValue = \Illuminate\Support\Carbon::parse($fieldValue)->format('Y-m-d\TH:i');
                                }
                                $recordData[$fieldName] = $fieldValue;
                            }
                        @endphp
                        <tr data-table-row>
                            <td><span class="record-id">{{ $recordId }}</span></td>
                            @foreach ($listFields as $fieldName => $field)
                                @php $value = $record->{$fieldName}; @endphp
                                <td>
                                    @if (($field['type'] ?? null) === 'file')
                                        <div class="image-cell">
                                            <img src="{{ \Illuminate\Support\Str::startsWith($value, 'adminDecor/') ? asset($value) : asset('pingoDecor/assets/'.$value) }}"
                                                 alt="" loading="lazy" onerror="this.hidden=true;this.nextElementSibling.hidden=false">
                                            <span hidden>Imagem</span>
                                        </div>
                                    @elseif (! empty($field['options']))
                                        @php $displayValue = $field['options'][$value] ?? $value; @endphp
                                        @if ($field['badge'] ?? false)
                                            <span class="status-badge status-{{ \Illuminate\Support\Str::slug($value) }}">{{ $displayValue }}</span>
                                        @else
                                            <span class="cell-strong">{{ $displayValue }}</span>
                                        @endif
                                    @elseif ($field['money'] ?? false)
                                        <span class="cell-strong">R$ {{ number_format((float) $value, 2, ',', '.') }}</span>
                                    @elseif (($field['type'] ?? null) === 'datetime-local')
                                        <span>{{ $value ? \Illuminate\Support\Carbon::parse($value)->format('d/m/Y H:i') : '—' }}</span>
                                    @elseif (($field['type'] ?? null) === 'url')
                                        <a class="table-link" href="{{ $value }}" target="_blank" rel="noreferrer">Abrir link ↗</a>
                                    @else
                                        <span class="cell-text" title="{{ $value }}">{{ \Illuminate\Support\Str::limit($value, 58) }}</span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="actions-column">
                                <div class="row-actions">
                                    <button type="button" class="icon-button" title="Editar"
                                            aria-label="Editar {{ $definition['singular'] }} {{ $recordId }}"
                                            data-edit-record="{{ $recordId }}">
                                        <span aria-hidden="true">✎</span>
                                    </button>
                                    <button type="button" class="icon-button icon-button-danger" title="Excluir"
                                            aria-label="Excluir {{ $definition['singular'] }} {{ $recordId }}"
                                            data-delete-record="{{ $recordId }}"
                                            data-delete-title="{{ $record->{$definition['title_field']} }}">
                                        <span aria-hidden="true">⌫</span>
                                    </button>
                                </div>
                                <script type="application/json" id="record-json-{{ $recordId }}">{!! json_encode($recordData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="{{ $listFields->count() + 2 }}">
                                <div>
                                    <span aria-hidden="true">+</span>
                                    <strong>Nenhum registro encontrado</strong>
                                    <p>Crie o primeiro {{ $definition['singular'] }} desta seção.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <p class="no-search-results" data-no-search-results hidden>Nenhum item corresponde à pesquisa.</p>
    </section>

    <dialog class="admin-dialog" id="create-dialog" aria-labelledby="create-dialog-title">
        <form action="{{ route('admin.resources.store', ['resource' => $resource]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_form_mode" value="create">
            <header class="dialog-header">
                <div><span class="eyebrow">Novo registro</span><h2 id="create-dialog-title">Criar {{ $definition['singular'] }}</h2></div>
                <button type="button" class="dialog-close" data-dialog-close aria-label="Fechar">×</button>
            </header>
            <div class="dialog-body form-grid">
                @include('admin.resources._form_fields', ['mode' => 'create'])
            </div>
            <footer class="dialog-footer">
                <button type="button" class="button button-secondary" data-dialog-close>Cancelar</button>
                <button type="submit" class="button button-primary">Criar {{ $definition['singular'] }}</button>
            </footer>
        </form>
    </dialog>

    <dialog class="admin-dialog" id="edit-dialog" aria-labelledby="edit-dialog-title"
            data-update-template="{{ route('admin.resources.update', ['resource' => $resource, 'id' => '__ID__']) }}">
        <form action="" method="post" enctype="multipart/form-data" data-edit-form>
            @csrf
            @method('put')
            <input type="hidden" name="_form_mode" value="edit">
            <input type="hidden" name="_record_id" value="" data-edit-record-id>
            <header class="dialog-header">
                <div><span class="eyebrow">Editar registro</span><h2 id="edit-dialog-title">Editar {{ $definition['singular'] }}</h2></div>
                <button type="button" class="dialog-close" data-dialog-close aria-label="Fechar">×</button>
            </header>
            <div class="dialog-body form-grid">
                @include('admin.resources._form_fields', ['mode' => 'edit'])
            </div>
            <footer class="dialog-footer">
                <button type="button" class="button button-secondary" data-dialog-close>Cancelar</button>
                <button type="submit" class="button button-primary">Salvar alterações</button>
            </footer>
        </form>
    </dialog>

    <dialog class="admin-dialog confirm-dialog" id="delete-dialog" aria-labelledby="delete-dialog-title"
            data-delete-template="{{ route('admin.resources.destroy', ['resource' => $resource, 'id' => '__ID__']) }}">
        <form action="" method="post" data-delete-form>
            @csrf
            @method('delete')
            <header class="dialog-header">
                <div><span class="eyebrow eyebrow-danger">Exclusão permanente</span><h2 id="delete-dialog-title">Excluir {{ $definition['singular'] }}?</h2></div>
                <button type="button" class="dialog-close" data-dialog-close aria-label="Fechar">×</button>
            </header>
            <div class="dialog-body">
                <p>Você está prestes a excluir <strong data-delete-name></strong>. Esta ação não pode ser desfeita.</p>
            </div>
            <footer class="dialog-footer">
                <button type="button" class="button button-secondary" data-dialog-close>Cancelar</button>
                <button type="submit" class="button button-danger">Sim, excluir</button>
            </footer>
        </form>
    </dialog>
@endsection

@push('scripts')
    <script>
        window.adminFormRecovery = @json([
            'mode' => old('_form_mode'),
            'recordId' => old('_record_id'),
            'values' => old(),
        ]);
    </script>
@endpush
