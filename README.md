# NexTask

O NexTask é um sistema de gestão de tarefas desenvolvido em Laravel, que permite aos utilizadores criar, editar, eliminar e gerir tarefas com diferentes estados.

## Início Rápido

Para executar o NexTask localmente, siga estes passos:

```bash
git clone 
cd NexTask
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve


Pré-requisitos
PHP >= 7.3
MySQL ou outro banco de dados suportado pelo Laravel
Composer
Configuração
Após clonar o repositório e instalar as dependências, configure o seu arquivo .env com as informações do seu banco de dados.

Utilização
O NexTask possui várias funcionalidades-chave:

Login/Logout: Autenticação de utilizador.
Gestão de Tarefas: Crie, edite e elimine tarefas.
Alteração de Estado das Tarefas: Altere o estado das tarefas entre 'nova', 'em progresso' e 'concluída'.
Rotas
O sistema possui diversas rotas, separadas por autenticação e função:

Rotas de autenticação (/login, /logout)
Rotas de gestão de tarefas (/new_task, /edit_task/{id}, /delete_task/{id})
Rotas de atualização de estado e UI (/tasks/{id}/update_status, /updateUI)


Contribuições
Sinta-se à vontade para fazer fork do projeto, criar uma branch para a sua funcionalidade e submeter um pedido de pull.

Licença
Este projeto está sob a Licença MIT.

Contacto
Pedro Cunha - Pedro_Cunha-96@hotmail.com

Link do Projeto: https://github.com/PedroC96/NexTask