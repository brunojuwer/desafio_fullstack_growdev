## Projeto fullstack mentores

### Features do projeto:
- Cadastro de mentores.
- Autenticação e autorização.
- Filtro e busca por Nome, E-mail e CPF.

---

#### Configurações para rodar o projeto
Após clonar o repo entre na pasta `backend` e crie um arquivo chamado `.env` ou apenas renomeie o arquivo `.env.example`;
- OBS: é necessário configurar a conexão com o banco de dados mysql.

#### Instalação das dependências do backend
```bash
composer install
```

#### Gerar a APP_KEY da API
```bash
php artisan key:generate
```

#### Rodar as migrations do banco
```bash
php artisan migrate
```

#### Criar um usuário para o primeiro acesso a aplicação
```bash
php artisan db:seed
```
Credênciais do usuário após o seed:
 - emai: admin@email.com
 - senha: password


#### Subir o servidor de desenvolvimento da API
```bash
php artisan serve
```

----

#### Instalar as dependências do frontend
Entre na pasta frontend e crie um arquivo chamado .env ou apenas renomeie o arquivo .env.example;

```bash
npm install
```

#### Rodar o frontend

```bash
npm run dev
```

---

## Imagens das telas

### Tela do mentor com permissão de ADMIN
![image](https://github.com/user-attachments/assets/08e1efd6-29dd-4484-a7cc-ec011e966d0a)

### Tela do mentor com permissão de VIEWER
![image](https://github.com/user-attachments/assets/a7f4b6fa-fb58-4c1b-96b8-54f026028e2d)

### Tela de Login
![image](https://github.com/user-attachments/assets/4899a37d-e07c-4f3e-bf7d-ecee45b1b370)

### Modal de criação de mentor
![image](https://github.com/user-attachments/assets/2450e58a-5c5b-4ce5-a863-f52e22233627)

### Modal de edição de mentor
![image](https://github.com/user-attachments/assets/3dadb352-c794-4add-8bc7-a85393ce0e91)

### Modal de deleção do mentor
![image](https://github.com/user-attachments/assets/7f248ef3-7eb8-48a7-a0aa-b196b04978a1)


