# Laravel simple CRUD API with Authentification


## Requirements

- Laravel
- Composer
- Postman / Insomnia
- XAMPP / MySQL



## Authentification

#### All Users
- Get all Users : apiRoute: api/users, method: GET

#### To Register
- To Register : apiRoute: api/users/register, method: POST, (pass [name, email, password] in JSON format in INSOMNIA)

#### Connexion
- Connexion : apiRoute: api/users/login, method: POST, (pass [email, password] in JSON format in INSOMNIA)

#### Get connected User informations
- Connected User : apiRoute: api/user, method: GET



## CRUD Opérations

#### Get all Posts
- Get all Posts : apiRoute: api/posts
- Search in Posts : apiRoute: api/posts?search=word
- Paginate in posts : apiRoute: api/posts?page=value
- Here is all method: GET


- **For the three following actions User must be connected and must pass the BEARER TOKEN in the AUTHORIZATION FIELD of HEADERS in INSOMNIA**

#### Create Post
- Create new Post : apiRoute: api/posts/create, method: POST

#### Update Post
- Update one Post : apiRoute: api/posts/edit/{post}, method: PUT

#### Delete Posts
- Delete one Post : apiRoute: api/posts/{post}, method: DELETE
                