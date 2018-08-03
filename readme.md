### Start

Create tables.

`bin/console doctrine:schema:create`

To be able to test the app You need a Token

There is two user in configuration storage.
`test/testpass` and `admin/kitten`

Send a json to `/api/get-token` endpoint in format:
```json
{
    "username": "test",
    "password": "testpass"
}
```
response will be something like:
```json
{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1MzMyMjU3MDUsImV4cCI6MTUzMzIyOTMwNSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdCJ9.HxlTULEYe36xOG-7av0F57NPx3zzFX_sDXEJCTxRREuYCpQ6eqhNGuaoAGy_6pdEtLEqexPq1LOepTd6X_riFrtQFxHl7eQknWdsRL7XTNN23Op3P-5Oqao3I4uHb6-HMTMvmrsWpDxeeMsjSBdhVQfRlyW6InZ2EkneEiwmBBbuBKpZwSmxdKTMcblRMpf95scFFsTrlmirerxvdFyJHVufNdzKLpjT-F-Y74kWMImHo6Aou5RSk5gRRpAN-tqTRJHyYMGohf2apjNUzAYMto5xZa9h4gT8bU8yTE37pRKgZ2_DxRYBc9IB1e00Qfq1ri29361YuS31Wtkcipgl-1-blifru6wekrvyV-V8Gyqaam6OE-R7aYi8uI6dZGGI5I0XmrqLoPtW7hPPFWTgSoOsZJjGGbI3bnCzHsRbIrdJECtOWkk3oVX3fa-T3ceOinMf9TfrKPNcyMQbta4N3WN0zkmSCnrRVV2Q-fXFJuwzLjC21dVpK7zJf_Y6qvcN4E6HEW8zy9WhnouD-HnOp_5KVNtWNAuOyMoMkLk_03MeQ73j__GzpY209erejj2nCxto5UKKdyhsjcVtdhvbQ50UNl5CxB1xWk2_0FwPawBwik5VyT4Oz6apOArDCXQWCbDOKTOLbZrRu1z6_cm-7cjDzg9DIftPgymW2HfZ9YI"}
```

then include the received token to *Authorization* header with prepended `Baerer `

```text
Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1MzMyMjU3MDUsImV4cCI6MTUzMzIyOTMwNSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdCJ9.HxlTULEYe36xOG-7av0F57NPx3zzFX_sDXEJCTxRREuYCpQ6eqhNGuaoAGy_6pdEtLEqexPq1LOepTd6X_riFrtQFxHl7eQknWdsRL7XTNN23Op3P-5Oqao3I4uHb6-HMTMvmrsWpDxeeMsjSBdhVQfRlyW6InZ2EkneEiwmBBbuBKpZwSmxdKTMcblRMpf95scFFsTrlmirerxvdFyJHVufNdzKLpjT-F-Y74kWMImHo6Aou5RSk5gRRpAN-tqTRJHyYMGohf2apjNUzAYMto5xZa9h4gT8bU8yTE37pRKgZ2_DxRYBc9IB1e00Qfq1ri29361YuS31Wtkcipgl-1-blifru6wekrvyV-V8Gyqaam6OE-R7aYi8uI6dZGGI5I0XmrqLoPtW7hPPFWTgSoOsZJjGGbI3bnCzHsRbIrdJECtOWkk3oVX3fa-T3ceOinMf9TfrKPNcyMQbta4N3WN0zkmSCnrRVV2Q-fXFJuwzLjC21dVpK7zJf_Y6qvcN4E6HEW8zy9WhnouD-HnOp_5KVNtWNAuOyMoMkLk_03MeQ73j__GzpY209erejj2nCxto5UKKdyhsjcVtdhvbQ50UNl5CxB1xWk2_0FwPawBwik5VyT4Oz6apOArDCXQWCbDOKTOLbZrRu1z6_cm-7cjDzg9DIftPgymW2HfZ9YI
```

#### Endpoin list

- Create League [POST] `/api/league`
- List of Teams by League [GET]`/api/teams/league/{id}`
- Delete League [DELETE]`/api/league/{id}`
- Update Team [PUT, Patch] `/api/team/{id}`
- Delete Team [DELETE] `/api/team/{id}`
- List all Teams [GET] `/api/teams`
- Create Team [POST] `/api/team`
- Get Token [POST] `/api/get-token`


#### Not required

Generate the SSH keys :

``` bash
$ mkdir config/jwt
$ openssl genrsa -out config/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

In case first ```openssl``` command forces you to input password use following to get the private key decrypted
``` bash
$ openssl rsa -in config/jwt/private.pem -out config/jwt/private2.pem
$ mv config/jwt/private.pem config/jwt/private.pem-back
$ mv config/jwt/private2.pem config/jwt/private.pem
```