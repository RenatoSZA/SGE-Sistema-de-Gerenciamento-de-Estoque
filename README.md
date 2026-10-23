# SGE-Sistema-de-Gerenciamento-de-Estoque

## Descrição
O Sistema de Gerenciamento de Estoque foi desenvolvido para auxiliar empresas no controle de produtos, entradas, saídas e organização do estoque de forma prática e eficiente. O sistema permite acompanhar a quantidade disponível de cada item, registrar movimentações e gerar maior controle sobre os produtos armazenados.

## Funcionalidades
- Cadastro de produtos
- Atualização de estoque
- Registro de entradas e saídas
- Consulta de produtos
- Controle de quantidade disponível
- Exclusão e edição de produtos
- Relatórios básicos de movimentação

## Tecnologias Utilizadas
- HTML / Blade
- CSS / Tailwind CSS / Vite
- JavaScript
- PHP 8.2+ / Laravel 12
- MySQL / SQLite

## 🚀 Como Executar o Projeto Localmente

### Pré-requisitos
Certifique-se de ter instalado no computador:
- **PHP** (versão 8.2 ou superior — ex.: via XAMPP, Laragon ou instalação direta)
- **Composer** (gerenciador de dependências do PHP)
- **Node.js** e **NPM** (para compilar os arquivos do frontend com Vite/Tailwind)
- **Git**

---

### Passo a Passo

#### 1. Clonar o repositório e entrar na pasta do sistema
```bash
git clone https://github.com/RenatoSZA/SGE-Sistema-de-Gerenciamento-de-Estoque.git
cd SGE-Sistema-de-Gerenciamento-de-Estoque/SGE
```

#### 2. Instalar as dependências do PHP e do Node.js
```bash
composer install
npm install
```

#### 3. Configurar o arquivo de ambiente (`.env`)
Copie o arquivo `.env.example` para `.env` e gere a chave de criptografia da aplicação:
```bash
# No Windows (CMD / PowerShell):
copy .env.example .env

# No Linux / macOS:
cp .env.example .env

php artisan key:generate
```

#### 4. Configurar o Banco de Dados
Por padrão, o projeto está configurado no `.env.example` para utilizar **SQLite** (dispensa servidor MySQL):
```bash
# No Windows (PowerShell):
New-Item -ItemType File -Path database/database.sqlite -Force

# No Linux / macOS:
touch database/database.sqlite
```
> **Opcional (MySQL / MariaDB via XAMPP):** Caso prefira usar MySQL, altere `DB_CONNECTION=mysql` no `.env`, descomente e configure `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD`, ou importe o dump `database/CopiaBD.sql` no phpMyAdmin.

Em seguida, execute as migrações e popule o banco com os dados iniciais:
```bash
php artisan migrate
php artisan db:seed --class=DashboardSeeder
```

#### 5. Compilar o Frontend e Iniciar o Servidor
Compile os ativos visuais (Tailwind CSS / Vite) e inicie o servidor do Laravel:
```bash
npm run build
php artisan serve
```
*(Opcionalmente, durante o desenvolvimento, você pode rodar `npm run dev` em um terminal separado junto com `php artisan serve`).*

Acesse no navegador: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

### 🔑 Credenciais de Teste
O login utiliza **Matrícula** (formato `A`, `G` ou `F` seguido de 8 números) e **Senha**:

| Perfil | Matrícula | Senha |
| :--- | :--- | :--- |
| **Gerente** (criado pelo `DashboardSeeder`) | `G20260001` | `password` |
| **Funcionário** (criado pelo `DashboardSeeder`) | `F20260002` | `password` |

*(Novos funcionários cadastrados pelo sistema recebem a senha padrão `Mudar@123`).*

## GitHub da Equipe
 - https://github.com/RenatoSZA
 - https://github.com/Daphinne
 - https://github.com/alineaguiargondim
 - https://github.com/gabryel544
 - https://github.com/dassa0
 - https://github.com/Maria-Santa22
