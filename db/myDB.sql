CREATE TABLE users (
    userId          SERIAL          PRIMARY KEY,
    username        VARCHAR(20)     NOT NULL,
    email           VARCHAR(20)     NOT NULL,
    password        VARCHAR(20)     NOT NULL
);

CREATE TABLE recipe (
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
    recipeId        INT references recipe(recipeId) NOT NULL,
    ingredientId    INT references ingredients(ingredientId) NOT NULL,
    amount          INT             NOT NULL
);