# Instruções de Instalação

## Requisitos
- Docker
- Docker Compose

## Documentação Postman da api para importar no Postman caso prefira

- `./PHP_Teste.postman_collection.json`

### Caso não queira usar docker, você irá precisar configurar a aplicação com banco e redis local

## Passo a Passo para Instalar

Primeiro, clone aplicação:

```bash
git clone https://github.com/guilherme8787/php-test && cd php-test
```

### 2. Criar a Rede Docker

Em seguida, crie uma rede Docker para isolar os contêineres da aplicação:

```bash
docker network create --subnet=172.20.0.0/16 php-test
```

### 3. Subir os Contêineres

Suba os contêineres da aplicação utilizando o Docker Compose:

```bash
docker compose up -d --build
```

### 4. Executar Migrations e Seeders

Aguarde alguns segundos para que o banco de dados possa subir completamente. Depois, execute as migrations e seeders para configurar o banco de dados:

```bash
docker compose exec app php artisan migrate --seed
```

##### Obs: O comando acima deve ser executado a partir do mesmo diretório onde o arquivo docker-compose.yml está localizado.

### 5. Caso o Composer Falhe

Se o composer install falhar durante o build, você pode executar manualmente dentro do contêiner:

```bash
docker compose exec app composer install
```

### 6. Caso o .env não seja copiado de forma satisfatória

```bash
cp .env.example .env
```

### 7. URLs Acessíveis

- Aplicação: [http://127.0.0.1:9000](http://127.0.0.1:9000)
- Adminer (gerenciador de banco de dados): [http://127.0.0.1:8080](http://127.0.0.1:8080)

### 8. Executando as commands

## Execute a command abaixo para importar os times
```bash
docker compose exec app php artisan app:populate-teams-command
```

## Execute a command abaixo para importar os jogadores
```bash
docker compose exec app php artisan app:populate-players-command
```
