CREATE TABLE users (
    userId          SERIAL          PRIMARY KEY,
    username        VARCHAR(20)     NOT NULL,
    email           VARCHAR(30)     NOT NULL,
    password        VARCHAR(72)     NOT NULL
);

CREATE TABLE recipes (
    recipeId        SERIAL          PRIMARY KEY,
    userId          INT references users(userId) NOT NULL,
    recipeName      VARCHAR(20)     NOT NULL,
    recipeDesc      VARCHAR(200)    NOT NULL,
    recipeInstruct  TEXT            NOT NULL
);

CREATE TABLE ingredients (
    ingredientId    SERIAL          PRIMARY KEY,
    name            VARCHAR(20)     NOT NULL
);

CREATE TABLE recipeIngredient (
    recIngId        SERIAL          PRIMARY KEY,
    recipeId        INT references recipes(recipeId) NOT NULL,
    ingredientId    INT references ingredients(ingredientId) NOT NULL,
    amount          INT             NOT NULL,
    measurement     VARCHAR(10)     NOT NULL
);

alter table recipeIngredient
drop constraint recipeingredient_recipeid_fkey,
add constraint recipeingredient_recipeid_fkey
   foreign key (recipeId)
   references recipes(recipeId)
   on delete cascade;

alter table recipes
add constraint recipes_userid_fkey
   foreign key (userId)
   references users(userId)
   on delete cascade;
   
SELECT con.*
       FROM pg_catalog.pg_constraint con
            INNER JOIN pg_catalog.pg_class rel
                       ON rel.oid = con.conrelid
            INNER JOIN pg_catalog.pg_namespace nsp
                       ON nsp.oid = connamespace
       WHERE rel.relname = 'recipes';

SELECT i.name 
	FROM recipeIngredient ri 
	INNER JOIN ingredients i ON ri.ingredientId = i.ingredientId
	INNER JOIN recipes r on ri.recipeId = r.recipeId
	WHERE
	ri.recipeId = 1;