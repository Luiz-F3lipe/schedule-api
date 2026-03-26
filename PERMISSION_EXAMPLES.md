# Exemplos de Requisições - Sistema de Permissões

## 🔐 Autenticação

Todas as requisições abaixo requerem autenticação via Sanctum. Adicione o header:
```
Authorization: Bearer {seu_token}
```

---

## 📋 Listar Todas as Permissões

```bash
GET /api/permissions
```

**Resposta:**
```json
{
  "success": true,
  "data": {
    "department": [
      {
        "id": 1,
        "name": "create_department",
        "resource": "department",
        "action": "create"
      },
      {
        "id": 2,
        "name": "edit_department",
        "resource": "department",
        "action": "edit"
      }
    ],
    "product": [
      {
        "id": 6,
        "name": "create_product",
        "resource": "product",
        "action": "create"
      }
    ]
  }
}
```

---

## 👤 Ver Permissões do Usuário Atual

```bash
GET /api/permissions/me
```

**Resposta:**
```json
{
  "success": true,
  "user": "Test User",
  "department": "Desenvolvimento",
  "permissions": {
    "department": [
      {
        "id": 1,
        "name": "create_department",
        "resource": "department",
        "action": "create"
      }
    ]
  }
}
```

---

## 🏢 Ver Permissões de um Departamento

```bash
GET /api/permissions/departments/1
```

**Resposta:**
```json
{
  "success": true,
  "department": "Desenvolvimento",
  "permissions": {
    "department": [...],
    "product": [...],
    "schedule": [...]
  }
}
```

---

## ➕ Adicionar Permissões a um Departamento

```bash
POST /api/permissions/departments/1/assign
Content-Type: application/json

{
  "permission_ids": [1, 2, 3, 4, 5]
}
```

**Resposta:**
```json
{
  "success": true,
  "message": "Permissions assigned successfully",
  "department": {
    "id": 1,
    "description": "Desenvolvimento",
    "permissions": [...]
  }
}
```

---

## ➖ Remover Permissões de um Departamento

```bash
POST /api/permissions/departments/1/remove
Content-Type: application/json

{
  "permission_ids": [1, 2]
}
```

**Resposta:**
```json
{
  "success": true,
  "message": "Permissions removed successfully",
  "department": {
    "id": 1,
    "description": "Desenvolvimento",
    "permissions": [...]
  }
}
```

---

## 🔄 Sincronizar Permissões (Substituir Todas)

```bash
POST /api/permissions/departments/1/sync
Content-Type: application/json

{
  "permission_ids": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
}
```

**Resposta:**
```json
{
  "success": true,
  "message": "Permissions synchronized successfully",
  "department": {
    "id": 1,
    "description": "Desenvolvimento",
    "permissions": [...]
  }
}
```

---

## 🚫 Exemplo de Erro - Sem Permissão

```bash
POST /api/departments
Content-Type: application/json

{
  "description": "Novo Departamento",
  "active": true
}
```

**Resposta (403):**
```json
{
  "message": "Unauthorized. You do not have permission to create department"
}
```

---

## 🎯 Exemplos de Uso nas Rotas

### Listar Departamentos
```bash
GET /api/departments
# Requer: permission:department,list
```

### Criar Departamento
```bash
POST /api/departments
# Requer: permission:department,create

{
  "description": "Marketing",
  "active": true
}
```

### Ver Detalhes do Departamento
```bash
GET /api/departments/1
# Requer: permission:department,show
```

### Editar Departamento
```bash
PUT /api/departments/1
# Requer: permission:department,edit

{
  "description": "Marketing Digital",
  "active": true
}
```

---

## 🔍 Consultas Úteis com SQL

### Ver todas as permissões de um departamento
```sql
SELECT p.* 
FROM permissions p
INNER JOIN department_permissions dp ON p.id = dp.permission_id
WHERE dp.department_id = 1;
```

### Ver todos os usuários com uma permissão específica
```sql
SELECT u.*, d.description as department 
FROM users u
INNER JOIN departments d ON u.department_id = d.id
INNER JOIN department_permissions dp ON d.id = dp.department_id
INNER JOIN permissions p ON dp.permission_id = p.id
WHERE p.resource = 'department' AND p.action = 'create';
```

### Contar permissões por departamento
```sql
SELECT d.description, COUNT(dp.permission_id) as total_permissions
FROM departments d
LEFT JOIN department_permissions dp ON d.id = dp.department_id
GROUP BY d.id, d.description
ORDER BY total_permissions DESC;
```

---

## 💡 Dicas

1. **Atribuir todas as permissões de um recurso:**
   ```bash
   # Pegar IDs de todas as permissões de 'product'
   SELECT id FROM permissions WHERE resource = 'product';
   
   # Depois usar esses IDs no endpoint /assign
   ```

2. **Remover todas as permissões de um departamento:**
   ```bash
   POST /api/permissions/departments/1/sync
   {
     "permission_ids": []
   }
   ```

3. **Clonar permissões de um departamento para outro:**
   ```php
   $departmentOrigin = Department::find(1);
   $departmentDestiny = Department::find(2);
   
   $permissionIds = $departmentOrigin->permissions()->pluck('id')->toArray();
   $departmentDestiny->permissions()->sync($permissionIds);
   ```
