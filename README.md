# SymfonyApp
# How to install project
1. install docker and docker compose
2. run in terminal 'make dc_build'
3. run in terminal 'make php', then run composer install
4. make request with postman to endpoint localhost:8080/api/register to register user with email and password. For example: { "email":"user@gmail.com, "password":"password123"}
5. make request to localhost:8080/api/login to login and copy access_token
6. make request to localhost:8080/api/token/refresh with token in body {"refreshToken":"copied_access_token"}
7. make request to localhost:8080/logout with Authorization Bearer copied_access_token