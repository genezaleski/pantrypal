CREATE DATABASE seniorproject;
use seniorproject;
CREATE TABLE `User`
(
  `user_id` int PRIMARY KEY not null auto_increment,
  `oauth_token` varchar(255) unique,
  `user_name` varchar(255) not null unique,
  `first_name` varchar(255) not null,
  `last_name` varchar(255),
  `picture_path` varchar(255) not null
);

CREATE TABLE `RateRecipe`
(
  `ratedRecipe_id` int PRIMARY KEY not null auto_increment,
  `recipe_id` int not null,
  `user_id` int not null,
  `rating` enum('dislike','like') not null
);

CREATE TABLE `CommentRecipe`
(
  `comment_id` int PRIMARY KEY not null auto_increment,
  `user_id` int not null,
  `recipe_id` int not null,
  `comment_text` varchar(255) not null,
  `comment_time` datetime not null
);

CREATE TABLE `Recipe`
(
  `recipe_id` int PRIMARY KEY not null auto_increment,
  `api_name` varchar(255) not null,
  `api_recipe_id` varchar(255) not null,
  `title` varchar(255) not null,
  `author` varchar(255) not null,
  `recipe_link` varchar(2083) not null
);

CREATE TABLE `Allergy`
(
  `allergy_item_id` int PRIMARY KEY not null auto_increment,
  `allergy_itemName` varchar(255) not null,
  `user_id` int not null
);

CREATE TABLE `PantryItem`
(
  `pantry_item_id` int PRIMARY KEY not null auto_increment,
  `item_name` varchar(255) not null,
  `user_id` int not null
);

ALTER TABLE `Allergy` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

ALTER TABLE `PantryItem` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

ALTER TABLE `RateRecipe` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

ALTER TABLE `RateRecipe` ADD FOREIGN KEY (`recipe_id`) REFERENCES `Recipe` (`recipe_id`);

ALTER TABLE `CommentRecipe` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

ALTER TABLE `CommentRecipe` ADD FOREIGN KEY (`recipe_id`) REFERENCES `Recipe` (`recipe_id`);
