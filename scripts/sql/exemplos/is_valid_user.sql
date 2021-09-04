---
--- compare passwords
---
DROP FUNCTION IF EXISTS is_valid_password;
CREATE OR REPLACE FUNCTION is_valid_password(_user varchar, _pw varchar, out boolean)
AS $$
with test AS (
    SELECT true AS valid,
        false AS invalid FROM usuario
        WHERE login = _user AND senha = crypt(_pw, senha))
SELECT test.valid FROM test;
$$ language sql;

--test
SELECT q.is_valid_password = true
FROM (SELECT * FROM is_valid_password('mauro.miranda', '12345678'))q;

-- ENABLE PGCRYPTO
CREATE EXTENSION pgcrypto;
-- inserir usuário com senha criptografada
INSERT INTO users (email, password) VALUES ('johndoe@mail.com', crypt('johnpassword', gen_salt('bf')));
-- Busca com senha correta
SELECT id FROM users WHERE email = 'johndoe@mail.com' AND password = crypt('johnpassword', password);
-- Busca com senha errada
SELECT id FROM users WHERE email = 'johndoe@mail.com' AND password = crypt('wrongpassword', password);