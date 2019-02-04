create table users (
  username text primary key,
  password_hash text not_null,
  grade integer not_null,
  course integer not_null
);

create table productions (
  name text primary key,
  author text not_null
);
