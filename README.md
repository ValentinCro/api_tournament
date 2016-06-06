# Saagie App Starter

This app provides a Symfony REST API.

## Installation

Clone the repository:

```bash
git clone https://github.com/saagie/saagie-app-starter.git
```

Run composer to install the dependencies:

```bash
composer install
```

Generate the SSH keys (remember the pass phrase for the next step):

```bash
mkdir -p var/jwt
openssl genrsa -out var/jwt/private.pem -aes256 4096
openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
```

Update the `jwt_key_pass_phrase` in the `app/security.yml` file with the pass phrase
you've entered before :

```yaml
[...]
jwt_public_key_path: '%kernel.root_dir%/../var/jwt/public.pem'
jwt_key_pass_phrase: pass_phrase_you-ve_entered_before
jwt_token_ttl: 86400
[...]
```

Get the `jwt` by running the following command :

```bash
curl -X POST http://localhost:8000/api/login_check -d _username=myuser -d _password=userpass
```

**Note** : The _username and the _password parameters are defined by the
security.providers.in_memory.memory.user parameter in the `security.yml` file.
You can use your own user provider such as `friendsofsymfony/user-bundle`.

You can now make request to the API with this HTTP header (replace `token` by the
token you get with the previous command):

| Key           | Value          |
|---------------|----------------|
| Authorization | Bearer `token` |