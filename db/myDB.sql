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