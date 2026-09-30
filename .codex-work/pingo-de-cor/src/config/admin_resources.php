<?php

use App\Models\Banner;
use App\Models\Cliente;
use App\Models\Contato;
use App\Models\Depoimento;
use App\Models\Orcamento;
use App\Models\Projeto;
use App\Models\Publicacao;

return [
    'banners' => [
        'label' => 'Banners',
        'singular' => 'banner',
        'description' => 'Imagens e chamadas exibidas nos destaques do site.',
        'model' => Banner::class,
        'primary_key' => 'id_banner',
        'title_field' => 'titulo_banner',
        'fields' => [
            'titulo_banner' => [
                'label' => 'Título',
                'type' => 'text',
                'rules' => ['required', 'string', 'max:50'],
                'list' => true,
            ],
            'imagem_banner' => [
                'label' => 'Imagem',
                'type' => 'file',
                'accept' => 'image/jpeg,image/png,image/webp',
                'create_rules' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
                'update_rules' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
                'list' => true,
            ],
            'status_banner' => [
                'label' => 'Status',
                'type' => 'select',
                'options' => ['Ativo' => 'Ativo', 'Inativo' => 'Inativo'],
                'rules' => ['required', 'in:Ativo,Inativo'],
                'list' => true,
                'badge' => true,
            ],
        ],
    ],

    'clientes' => [
        'label' => 'Clientes',
        'singular' => 'cliente',
        'description' => 'Pessoas cadastradas e seus dados de acesso.',
        'model' => Cliente::class,
        'primary_key' => 'id_cliente',
        'title_field' => 'nome_cliente',
        'fields' => [
            'nome_cliente' => [
                'label' => 'Nome',
                'type' => 'text',
                'rules' => ['required', 'string', 'max:50'],
                'list' => true,
            ],
            'email_cliente' => [
                'label' => 'E-mail',
                'type' => 'email',
                'create_rules' => ['required', 'email', 'max:80', 'unique:tbl_cliente,email_cliente'],
                'update_rules' => ['required', 'email', 'max:80', 'unique:tbl_cliente,email_cliente,{id},id_cliente'],
                'list' => true,
            ],
            'senha_cliente' => [
                'label' => 'Senha',
                'type' => 'password',
                'create_rules' => ['required', 'string', 'min:6', 'max:255'],
                'update_rules' => ['nullable', 'string', 'min:6', 'max:255'],
                'hash' => true,
                'help' => 'Na edição, deixe em branco para manter a senha atual.',
            ],
            'foto_cliente' => [
                'label' => 'Foto',
                'type' => 'file',
                'accept' => 'image/jpeg,image/png,image/webp',
                'create_rules' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
                'update_rules' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
                'list' => true,
            ],
            'status_cliente' => [
                'label' => 'Status',
                'type' => 'select',
                'options' => ['Ativo' => 'Ativo', 'Inativo' => 'Inativo'],
                'rules' => ['required', 'in:Ativo,Inativo'],
                'list' => true,
                'badge' => true,
            ],
        ],
    ],

    'contatos' => [
        'label' => 'Contatos',
        'singular' => 'contato',
        'description' => 'Pedidos enviados pelo formulário de briefing.',
        'model' => Contato::class,
        'primary_key' => 'id_contato',
        'title_field' => 'nome_contato',
        'fields' => [
            'nome_contato' => ['label' => 'Nome', 'type' => 'text', 'rules' => ['required', 'string', 'max:60'], 'list' => true],
            'nome_companheiro_contato' => ['label' => 'Companheiro(a)', 'type' => 'text', 'rules' => ['required', 'string', 'max:70']],
            'nome_idade_criancas_contato' => ['label' => 'Crianças e idades', 'type' => 'text', 'rules' => ['required', 'string', 'max:60']],
            'email_contato' => ['label' => 'E-mail', 'type' => 'email', 'rules' => ['required', 'email', 'max:80'], 'list' => true],
            'telefone_contato' => ['label' => 'Telefone', 'type' => 'tel', 'rules' => ['required', 'string', 'max:15'], 'list' => true],
            'cidade_bairro_contato' => ['label' => 'Cidade / bairro', 'type' => 'text', 'rules' => ['required', 'string', 'max:32'], 'list' => true],
            'profissao_contato' => ['label' => 'Profissão', 'type' => 'text', 'rules' => ['required', 'string', 'max:80']],
            'origem_contato' => ['label' => 'Como nos conheceu', 'type' => 'text', 'rules' => ['required', 'string', 'max:23'], 'list' => true],
            'ajuda_contato' => ['label' => 'Como podemos ajudar', 'type' => 'text', 'rules' => ['required', 'string', 'max:47']],
            'metragem_contato' => ['label' => 'Metragem', 'type' => 'text', 'rules' => ['required', 'string', 'max:70']],
            'quantidades_ambientes_contato' => ['label' => 'Quantidade de ambientes', 'type' => 'text', 'rules' => ['required', 'string', 'max:14']],
            'trimestre_gestacao_contato' => ['label' => 'Trimestre da gestação', 'type' => 'text', 'rules' => ['required', 'string', 'max:37']],
            'prazo_contato' => ['label' => 'Prazo desejado', 'type' => 'text', 'rules' => ['required', 'string', 'max:15']],
            'detalhes_contato' => ['label' => 'Detalhes', 'type' => 'textarea', 'rules' => ['required', 'string', 'max:80'], 'wide' => true],
        ],
    ],

    'depoimentos' => [
        'label' => 'Depoimentos',
        'singular' => 'depoimento',
        'description' => 'Avaliações de clientes publicadas no site.',
        'model' => Depoimento::class,
        'primary_key' => 'id_depoimento',
        'title_field' => 'titulo_depoimento',
        'fields' => [
            'id_cliente' => [
                'label' => 'Cliente',
                'type' => 'select',
                'options_model' => Cliente::class,
                'option_value' => 'id_cliente',
                'option_label' => 'nome_cliente',
                'rules' => ['required', 'integer', 'exists:tbl_cliente,id_cliente'],
                'list' => true,
            ],
            'titulo_depoimento' => ['label' => 'Título', 'type' => 'text', 'rules' => ['required', 'string', 'max:50'], 'list' => true],
            'descricao_depoimento' => ['label' => 'Depoimento', 'type' => 'textarea', 'rules' => ['required', 'string'], 'list' => true, 'wide' => true],
            'nota_depoimento' => ['label' => 'Nota', 'type' => 'number', 'min' => 1, 'max' => 5, 'step' => 1, 'rules' => ['required', 'integer', 'between:1,5'], 'list' => true],
            'status_depoimento' => [
                'label' => 'Status',
                'type' => 'select',
                'options' => ['Ativo' => 'Ativo', 'Inativo' => 'Inativo'],
                'rules' => ['required', 'in:Ativo,Inativo'],
                'list' => true,
                'badge' => true,
            ],
        ],
    ],

    'orcamentos' => [
        'label' => 'Orçamentos',
        'singular' => 'orçamento',
        'description' => 'Propostas comerciais vinculadas aos contatos.',
        'model' => Orcamento::class,
        'primary_key' => 'id_orcamento',
        'title_field' => 'titulo_orcamento',
        'fields' => [
            'id_contato' => [
                'label' => 'Contato',
                'type' => 'select',
                'options_model' => Contato::class,
                'option_value' => 'id_contato',
                'option_label' => 'nome_contato',
                'rules' => ['required', 'integer', 'exists:tbl_contato,id_contato'],
                'list' => true,
            ],
            'titulo_orcamento' => ['label' => 'Título', 'type' => 'text', 'rules' => ['required', 'string', 'max:50'], 'list' => true],
            'valor_total_orcamento' => ['label' => 'Valor total', 'type' => 'number', 'min' => 0, 'step' => '0.01', 'rules' => ['required', 'numeric', 'min:0'], 'list' => true, 'money' => true],
            'prazo_execucao_orcamento' => ['label' => 'Prazo de execução', 'type' => 'text', 'rules' => ['required', 'string'], 'list' => true],
            'observacoes_orcamento' => ['label' => 'Observações', 'type' => 'textarea', 'rules' => ['required', 'string'], 'wide' => true],
            'status_orcamento' => [
                'label' => 'Status',
                'type' => 'select',
                'options' => ['Pendente' => 'Pendente', 'Analise' => 'Em análise', 'Aprovado' => 'Aprovado', 'Recusado' => 'Recusado'],
                'rules' => ['required', 'in:Pendente,Analise,Aprovado,Recusado'],
                'list' => true,
                'badge' => true,
            ],
        ],
    ],

    'projetos' => [
        'label' => 'Projetos',
        'singular' => 'projeto',
        'description' => 'Portfólio de ambientes apresentados no site.',
        'model' => Projeto::class,
        'primary_key' => 'id_projetos',
        'title_field' => 'nome_projetos',
        'fields' => [
            'nome_projetos' => ['label' => 'Nome', 'type' => 'text', 'rules' => ['required', 'string', 'max:30'], 'list' => true],
            'imagem_projetos' => [
                'label' => 'Imagem',
                'type' => 'file',
                'accept' => 'image/jpeg,image/png,image/webp',
                'create_rules' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
                'update_rules' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
                'list' => true,
            ],
            'status_projetos' => [
                'label' => 'Status',
                'type' => 'select',
                'options' => ['Ativo' => 'Ativo', 'Inativo' => 'Inativo'],
                'rules' => ['required', 'in:Ativo,Inativo'],
                'list' => true,
                'badge' => true,
            ],
        ],
    ],

    'publicacoes' => [
        'label' => 'Publicações',
        'singular' => 'publicação',
        'description' => 'Conteúdos, matérias e links externos.',
        'model' => Publicacao::class,
        'primary_key' => 'id_publicacoes',
        'title_field' => 'titulo_publicacoes',
        'fields' => [
            'titulo_publicacoes' => ['label' => 'Título', 'type' => 'text', 'rules' => ['required', 'string', 'max:100'], 'list' => true],
            'descricao_publicacoes' => ['label' => 'Descrição', 'type' => 'textarea', 'rules' => ['required', 'string'], 'list' => true, 'wide' => true],
            'imagem_publicacoes' => [
                'label' => 'Imagem',
                'type' => 'file',
                'accept' => 'image/jpeg,image/png,image/webp',
                'create_rules' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
                'update_rules' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
                'list' => true,
            ],
            'link_publicacoes' => ['label' => 'Link', 'type' => 'url', 'rules' => ['required', 'url', 'max:255'], 'list' => true],
            'data_publicacoes' => ['label' => 'Data da publicação', 'type' => 'datetime-local', 'rules' => ['required', 'date'], 'list' => true],
        ],
    ],
];
