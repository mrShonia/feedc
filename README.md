# API Documentation

https://documenter.getpostman.com/view/1523213/Szf53Us2?version=latest

# Database structure
 - user_contacts Table 
```-- auto-generated definition
create table user_contacts
(
  id              int unsigned auto_increment primary key,
  owner_user_id   int          not null,
  person_name     varchar(255) null,
  person_lastname varchar(255) null,
  created_at      timestamp    null,
  updated_at      timestamp    null
)

```
- users Table 
```-- auto-generated definition
   create table users
   (
     id         int unsigned auto_increment primary key,
     username   varchar(255) null,
     password   varchar(255) null,
     token      varchar(255) null,
     created_at timestamp    null,
     updated_at timestamp    null
   )
   

```

- person_numbers Table 
```
create table test.person_numbers
(
  id            int unsigned auto_increment primary key,
  owner_user_id int         not null,
  person_id     int         not null,
  number        varchar(30) null,
  created_at    timestamp   null,
  updated_at    timestamp   null
)

create index person_numbers_owner_user_id_index
  on feedc_db.person_numbers (owner_user_id);

create index person_numbers_person_id_index
  on feedc_db.person_numbers (person_id);


```
