INSERT INTO users VALUES 
(DEFAULT, 'mitch', 'mitch.hudson18@gmail.com', '$2y$10$yhMEJERjpgSy9Ums6/tEoeqwnB6mw4vPG1otdAJwCqqZqK.aLt8da');
INSERT INTO users VALUES 
(DEFAULT, 'admin', 'mhudsontech@gmail.com', '$2y$10$8Hk1fL7ULUnks5hG1njzY.vQZV38JFRWvy0lMVQjzQ.2QeOgKpi7u');
INSERT INTO users VALUES
(DEFAULT, 'lina', 'example@gmail.com', '$2y$10$82Q1tCUOPgPjDlYBg4yrvuQRx4SHEXaOl2P4yYcOEmgRDXsHdenV.');

INSERT INTO recipes VALUES
(DEFAULT, 1, 'Mac and Cheese', 'How to make Mac and Cheese', 'This is sample text for where the recipe instructions will go.');
INSERT INTO recipes VALUES
(DEFAULT, 2, 'Pepperoni Pizza', 'How to make pepperoni pizza', 'This is sample text for where the recipe instructions will go.');
INSERT INTO recipes VALUES
(DEFAULT, 3, 'Mashed Potatoes', 'How to make cheesy mashed potatoes', 'This is sample text for where the recipe instructions will go.');

INSERT INTO ingredients VALUES
(DEFAULT, 'Noodles');
INSERT INTO ingredients VALUES
(DEFAULT, 'Dough');
INSERT INTO ingredients VALUES
(DEFAULT, 'Russet');

INSERT INTO recipeIngredient VALUES
(DEFAULT, 1, 1, 2, 'cups');
INSERT INTO recipeIngredient VALUES
(DEFAULT, 2, 2, 1, 'package');
INSERT INTO recipeIngredient VALUES
(DEFAULT, 3, 3, 5, 'potatos');