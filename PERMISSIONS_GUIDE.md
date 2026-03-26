# Sistema de Controle de Acesso

Este projeto implementa um sistema de controle de acesso baseado em permissões por departamento.

## 📋 Estrutura

### Tabelas Criadas

1. **permissions** - Armazena todas as permissões disponíveis
   - `id`: ID da permissão
   - `name`: Nome da permissão (ex: create_department, edit_product)
   - `resource`: Recurso (ex: department, product, schedule_status, system, user)
   - `action`: Ação (ex: create, edit, list, show, delete)

2. **department_permissions** - Relacionamento entre departamentos e permissões
   - `department_id`: ID do departamento
   - `permission_id`: ID da permissão

### Models

- **Permission**: Model para gerenciar permissões
- **Department**: Atualizado com relacionamento de permissões
- **User**: Atualizado com método `hasPermission()` e relacionamento com departamento

## 🚀 Como Usar

### 1. Verificar Permissões no Controller

```php
if (!$request->user()->hasPermission('department', 'create')) {
    return response()->json(['message' => 'Unauthorized'], 403);
}
```

### 2. Usar Middleware nas Rotas

```php
Route::get('/departments', [DepartmentController::class, 'index'])
    ->middleware('permission:department,list');

Route::post('/departments', [DepartmentController::class, 'store'])
    ->middleware('permission:department,create');
```

### 3. Adicionar Permissões a um Departamento

```php
$department = Department::find(1);
$permissions = Permission::whereIn('resource', ['product', 'schedule'])->get();
$department->permissions()->attach($permissions);
```

### 4. Verificar Permissões de um Usuário

```php
$user = User::find(1);

if ($user->hasPermission('product', 'edit')) {
    // Usuário tem permissão para editar produtos
}
```

## 📦 Recursos Disponíveis

Por padrão, o sistema cria permissões para os seguintes recursos:
- `department` - Departamentos
- `product` - Produtos
- `schedule_status` - Status de agendamento
- `system` - Sistemas
- `user` - Usuários
- `schedule` - Agendamentos
- `password` - Senhas

## 🎯 Ações Disponíveis

Cada recurso possui as seguintes ações:
- `create` - Criar novo registro
- `edit` - Editar registro existente
- `list` - Listar todos os registros
- `show` - Ver detalhes de um registro
- `delete` - Deletar um registro

## ➕ Como Adicionar Novos Recursos

### 1. Adicionar no PermissionSeeder

```php
$resources = [
    'department',
    'product',
    'schedule_status',
    'system',
    'user',
    'schedule',
    'password',
    'novo_recurso', // Adicione aqui
];
```

### 2. Rodar o Seeder

```bash
php artisan db:seed --class=PermissionSeeder
```

### 3. Aplicar nas Rotas

```php
Route::prefix('novo-recurso')->group(function () {
    Route::get('/', [NovoRecursoController::class, 'index'])
        ->middleware('permission:novo_recurso,list');
    Route::post('/', [NovoRecursoController::class, 'store'])
        ->middleware('permission:novo_recurso,create');
});
```

## 🎭 Departamentos Seed

O seeder cria 7 departamentos com permissões pré-configuradas:

1. **Administrador** - Todas as permissões
2. **Desenvolvimento** - Permissões para todos os recursos exceto gerenciamento de usuários
3. **Suporte** - Apenas permissões de visualização (list e show)
4. **Financeiro** - Sem permissões iniciais
5. **Implantação** - Sem permissões iniciais
6. **Diretoria** - Sem permissões iniciais
7. **Comercial** - Sem permissões iniciais

## 📊 Exemplo de Uso Completo

```php
// 1. Criar um usuário no departamento de Desenvolvimento
$user = User::create([
    'name' => 'João Silva',
    'email' => 'joao@example.com',
    'password' => bcrypt('senha123'),
    'department_id' => 1, // Desenvolvimento
]);

// 2. Verificar permissões
$user->hasPermission('product', 'create'); // true
$user->hasPermission('user', 'edit'); // false

// 3. Adicionar permissões específicas a um departamento
$financeiro = Department::where('description', 'Financeiro')->first();
$permissoes = Permission::where('resource', 'schedule')
    ->whereIn('action', ['list', 'show'])
    ->get();
$financeiro->permissions()->attach($permissoes);
```

## 🔄 Atualizar Banco de Dados

Para recriar todas as tabelas e popular novamente:

```bash
php artisan migrate:fresh --seed
```

## 🛡️ Middleware CheckPermission

O middleware `CheckPermission` verifica automaticamente se o usuário autenticado possui a permissão necessária para acessar a rota.

**Parâmetros:**
- `resource`: Nome do recurso (ex: department, product)
- `action`: Ação desejada (ex: create, edit, list, show, delete)

**Resposta de erro:**
```json
{
    "message": "Unauthorized. You do not have permission to create department"
}
```

## 📝 Notas Importantes

1. O usuário DEVE ter um `department_id` válido para ter permissões
2. As permissões são verificadas através do departamento do usuário
3. Um usuário sem departamento não terá nenhuma permissão
4. É possível adicionar múltiplas permissões a um departamento de uma vez
5. O sistema usa snake_case para os nomes dos recursos (ex: schedule_status, não scheduleStatus)
