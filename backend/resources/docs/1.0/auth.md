<a name="login"></a>

# Login

### Endpoint (Login)

Create a session and retrieve a web token.

| Method |     URL      | Headers |
| :----: | :----------: | :-----: |
|  POST  | `/api/login` |    -    |

#### Body rules

```json
{
    "email": "string",
    "password": "string"
}
```

### Responses

Código `201`

Created

```json
{
    "access_token": "string",
    "token_type": "string"
}
```

Código `400`

Bad credentials

```json
{
    "message": "string"
}
```

---

---

<br />

<a name="logout"></a>

# Logout

### Endpoint (Logout)

Destroy a session and token created previously.

| Method |      URL      | Headers |
| :----: | :-----------: | :-----: |
| DELETE | `/api/logout` |  AUTH   |

### Responses

Código `200`

Successfuly logged out.

```json
{
    "message": "string"
}
```

Código `401`

Unauthenticated.

```json
{
    "message": "string"
}
```
