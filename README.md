# SGE - Sistema de Gerenciamento de Estoque

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
- Livewire
- MySQL / SQLite

---

## ⚡ Como Instalar por Script

O projeto possui automação completa via scripts para preparar todo o ambiente em computadores Windows sem ferramentas de desenvolvimento pré-instaladas.

### Arquivos de Automação

| Arquivo | Finalidade |
| :--- | :--- |
| **`instalar.bat`** | Ponto de entrada de 1 clique. Bypassa restrições do PowerShell e solicita permissão de Administrador quando necessário. |
| **`setup.ps1`** | Script PowerShell responsável por instalar dependências, compilar assets, configurar banco e iniciar o sistema. |
| **`iniciar.bat`** | Inicializador rápido para o dia a dia após a primeira instalação (não reinstala nada, apenas sobe o servidor e abre o navegador). |

### Passo a Passo para Primeira Instalação Automática

1. **Baixar ou clonar o projeto** para qualquer pasta da máquina.
2. Dê **2 cliques no arquivo `instalar.bat`**.
3. Se o Windows exibir a janela de Controle de Conta de Usuário (UAC), clique em **Sim** (necessário para o `winget` instalar os softwares no sistema).
4. O script executará automaticamente todas as etapas:
   - **Instalação de Dependências de Sistema:** Verifica e instala silenciosamente via `winget`:
     - **Git**
     - **PHP 8.3**
     - **Composer**
     - **Node.js LTS** (com NPM)
   - **Configuração do PHP (`php.ini`):** Habilita as extensões necessárias para o Laravel (`pdo_mysql`, `pdo_sqlite`, `sqlite3`, `curl`, `fileinfo`, `mbstring`, `openssl`, `zip`).
   - **Variáveis de Ambiente (`.env`):** Gera o arquivo `.env` a partir do `.env.example` e cria a chave de segurança (`APP_KEY`).
   - **Dependências do Projeto:** Executa `composer install` e `npm install`.
   - **Compilação de Assets:** Roda `npm run build` para gerar o CSS e JS via Vite.
   - **Banco de Dados Inteligente:**
     - Tenta se conectar ao MySQL local (`127.0.0.1:3306`).
     - Se o MySQL não estiver instalado ou em execução, o script **alterna automaticamente para SQLite**, criando o arquivo `database.sqlite` sem necessidade de configurações extras.
   - **Migrações e Seeds:** Cria as tabelas do banco e popula dados de demonstração através do `DashboardSeeder`.
5. Ao concluir, o navegador padrão será aberto em **[http://127.0.0.1:8000](http://127.0.0.1:8000)**.

### Execução Diária (Após já instalado)
Nas próximas vezes que quiser usar o sistema, não é necessário rodar o instalador novamente:
- Basta dar **2 cliques em `iniciar.bat`**.
- O navegador abrirá automaticamente em `http://127.0.0.1:8000` e o terminal manterá o servidor rodando.
- Para encerrar o servidor, feche a janela ou pressione `CTRL + C`.

---

## 🚀 Como Executar Manualmente (Ambiente já configurado / Linux / macOS)

### Pré-requisitos
Certifique-se de ter instalado no computador:
- **PHP** (versão 8.2 ou superior — ex.: via XAMPP, Laragon ou instalação direta)
- **Composer** (gerenciador de dependências do PHP)
- **Node.js** e **NPM** (para compilar os arquivos do frontend com Vite/Tailwind)
- **Git**

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

## 🔑 Credenciais de Teste
O login utiliza **Matrícula** (formato `A`, `G` ou `F` seguido de 8 números) e **Senha**:

| Perfil | Matrícula | Senha |
| :--- | :--- | :--- |
| **Gerente** (criado pelo `DashboardSeeder`) | `G20260001` | `password` |
| **Funcionário** (criado pelo `DashboardSeeder`) | `F20260002` | `password` |

*(Novos funcionários cadastrados pelo sistema recebem a senha padrão `Mudar@123`).*

---

## GitHub da Equipe
 - https://github.com/RenatoSZA
 - https://github.com/Daphinne
 - https://github.com/alineaguiargondim
 - https://github.com/gabryel544
 - https://github.com/dassa0
 - https://github.com/Maria-Santa22
