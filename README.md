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
- HTML / CSS / Tailwind CSS
- JavaScript / Vite
- PHP 8.2+ / Laravel 12
- Livewire
- MySQL / SQLite

---

## Como Executar em um PC "Virgem" (Windows)

O projeto possui automação completa via scripts para preparar todo o ambiente em computadores Windows 10/11 sem ferramentas de desenvolvimento pré-instaladas.

### Arquivos de Automação

| Arquivo | Finalidade |
| :--- | :--- |
| **`instalar.bat`** | Ponto de entrada de 1 clique. Bypassa restrições do PowerShell e solicita permissão de Administrador quando necessário. |
| **`setup.ps1`** | Script PowerShell responsável por instalar dependências, compilar assets, configurar banco e iniciar o sistema. |
| **`iniciar.bat`** | Inicializador rápido para o dia a dia após a primeira instalação (não reinstala nada, apenas sobe o servidor e abre o navegador). |

---

### Passo a Passo para Primeira Instalação

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
5. Ao concluir, o navegador padrão será aberto em `http://127.0.0.1:8000`.

---

### Execução Diária (Após já instalado)

Nas próximas vezes que quiser usar o sistema, não é necessário rodar o instalador novamente:
- Basta dar **2 cliques em `iniciar.bat`**.
- O navegador abrirá automaticamente em `http://127.0.0.1:8000` e o terminal manterá o servidor rodando.
- Para encerrar o servidor, feche a janela ou pressione `CTRL + C`.

---

## GitHub da Equipe
 - https://github.com/RenatoSZA
 - https://github.com/Daphinne
 - https://github.com/alineaguiargondim
 - https://github.com/gabryel544
 - https://github.com/dassa0
 - https://github.com/Maria-Santa22
