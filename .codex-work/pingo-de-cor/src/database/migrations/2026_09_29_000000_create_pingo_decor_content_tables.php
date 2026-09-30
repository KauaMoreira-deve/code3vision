<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tbl_banner')) {
            Schema::create('tbl_banner', function (Blueprint $table): void {
                $table->increments('id_banner');
                $table->string('titulo_banner', 50);
                $table->string('imagem_banner', 255);
                $table->string('status_banner', 10);
                $table->dateTime('data_criacao_banner')->useCurrent();
                $table->dateTime('data_atualizacao_banner')->useCurrent();
            });
        }

        if (! Schema::hasTable('tbl_cliente')) {
            Schema::create('tbl_cliente', function (Blueprint $table): void {
                $table->increments('id_cliente');
                $table->string('nome_cliente', 50);
                $table->string('email_cliente', 80)->unique();
                $table->string('senha_cliente');
                $table->string('foto_cliente', 255);
                $table->string('status_cliente', 10);
                $table->dateTime('data_criacao_cliente')->useCurrent();
                $table->dateTime('data_atualizacao_cliente')->useCurrent();
            });
        }

        if (! Schema::hasTable('tbl_contato')) {
            Schema::create('tbl_contato', function (Blueprint $table): void {
                $table->increments('id_contato');
                $table->string('nome_contato', 60);
                $table->string('nome_companheiro_contato', 70);
                $table->string('nome_idade_criancas_contato', 60);
                $table->string('email_contato', 80);
                $table->string('telefone_contato', 15);
                $table->string('cidade_bairro_contato', 32);
                $table->string('profissao_contato', 80);
                $table->string('origem_contato', 23);
                $table->string('ajuda_contato', 47);
                $table->string('metragem_contato', 70);
                $table->string('quantidades_ambientes_contato', 14);
                $table->string('trimestre_gestacao_contato', 37);
                $table->string('prazo_contato', 15);
                $table->string('detalhes_contato', 80);
                $table->dateTime('data_criacao_contato')->useCurrent();
                $table->dateTime('data_atualizacao_contato')->useCurrent();
            });
        }

        if (! Schema::hasTable('tbl_depoimento')) {
            Schema::create('tbl_depoimento', function (Blueprint $table): void {
                $table->increments('id_depoimento');
                $table->unsignedInteger('id_cliente')->index();
                $table->string('titulo_depoimento', 50);
                $table->text('descricao_depoimento');
                $table->unsignedTinyInteger('nota_depoimento');
                $table->string('status_depoimento', 10);
                $table->dateTime('data_criacao_depoimento')->useCurrent();
                $table->dateTime('data_atualizacao_depoimento')->useCurrent();
            });
        }

        if (! Schema::hasTable('tbl_orcamento')) {
            Schema::create('tbl_orcamento', function (Blueprint $table): void {
                $table->increments('id_orcamento');
                $table->unsignedInteger('id_contato')->index();
                $table->string('titulo_orcamento', 50);
                $table->decimal('valor_total_orcamento', 10, 2);
                $table->text('prazo_execucao_orcamento');
                $table->text('observacoes_orcamento');
                $table->string('status_orcamento', 10);
                $table->dateTime('data_criacao_orcamento')->useCurrent();
                $table->dateTime('data_atualizacao_orcamento')->useCurrent();
            });
        }

        if (! Schema::hasTable('tbl_projetos')) {
            Schema::create('tbl_projetos', function (Blueprint $table): void {
                $table->increments('id_projetos');
                $table->string('nome_projetos', 30);
                $table->string('imagem_projetos', 255);
                $table->string('status_projetos', 10);
                $table->dateTime('data_criacao_projetos')->useCurrent();
                $table->dateTime('data_atualizacao_projetos')->useCurrent();
            });
        }

        if (! Schema::hasTable('tbl_publicacoes')) {
            Schema::create('tbl_publicacoes', function (Blueprint $table): void {
                $table->increments('id_publicacoes');
                $table->string('titulo_publicacoes', 100);
                $table->text('descricao_publicacoes');
                $table->string('imagem_publicacoes');
                $table->string('link_publicacoes');
                $table->dateTime('data_publicacoes');
                $table->dateTime('data_criacao_publicacoes')->useCurrent();
                $table->dateTime('data_atualizacao_publicacoes')->useCurrent();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_publicacoes');
        Schema::dropIfExists('tbl_projetos');
        Schema::dropIfExists('tbl_orcamento');
        Schema::dropIfExists('tbl_depoimento');
        Schema::dropIfExists('tbl_contato');
        Schema::dropIfExists('tbl_cliente');
        Schema::dropIfExists('tbl_banner');
    }
};
