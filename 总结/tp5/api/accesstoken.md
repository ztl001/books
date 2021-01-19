## accessToken设计

### 简介

我们使用oAuth2协议做权限验证，所以我们需要先申请client_id和client_secret

获取access_token可以通过2中方式授权获取

* client_credentials
* login_token

### client_credentials

#### post参数

|      key      |        val         |
| :-----------: | :----------------: |
|  grant_type   | client_credentials |
|   client_id   |      xxxxxxx       |
| client_secret |      xxxxxxx       |

#### 返回值

```shell
{
  "access_token": "fnpi7B4wA4ZzTxkvjCnCESUyf6yPl7PXNgxZVne9",
  "token_type": "Bearer",
  "expires_in": 3600
}
```

### login_token

#### post参数

|      key      |     val     |
| :-----------: | :---------: |
|  grant_type   | login_token |
|   client_id   |   xxxxxx    |
| client_secret |   xxxxxx    |
|   username    | 用户唯一值  |
|  login_token  |   xxxxxx    |

#### 返回值

```shell
{
  "access_token": "A0nVbVy9waLf2v7Tr8npQZRd7SYw0Z4WPJkL8VFm",
  "token_type": "Bearer",
  "expires_in": 31536000,
  "refresh_token": "x1txmTcWP4l81BEbmlPdeOZWETvze13rBrDOzTmG"
}
```

