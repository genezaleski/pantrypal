use seniorproject;

insert into User (oauth_token,user_name)
values ('QQQQQ','alexjenkins223'),
('BBBBB','johnabram234'),
('ABCDE','user1'),
('DDDCE','bobstewart22');


insert into Recipe (api_name,api_recipe_id,title,recipe_link)
values ('spoon','123qef',"Mom's Mac and Cheese","Food Netwok",'foodnetwork.com/mac&cheese'),
('spoon','405tcx',"Best PB&J","Food Network",'foodnetwork.com/pb&j'),
('spoon','sf0123',"Amazingly Cheesy Grilled Cheese","Food Network",'foodnetwork.com/grilledcheese'),
('spoon','3902sd',"Not Your Standard Chicken Salad!","Food Network",'foodnetwork.com/chickensalad'),
('spoon','dfapoi',"5 Minute Tuna Salad","Food Network",'foodnetwork.com/tunasalad'),
('spoon','1230sd',"Original Caesar Salad","Food Network",'foodnetwork.com/caesarsalad'),
('spoon','po023d',"30 Minute Buffalo Chicken",'"Food Network",foodnetwork.com/buffalochicken'),
('spoon','kk1234',"Ez Bake Pizza","Food Network",'foodnetwork.com/pizza');

insert into Allergy (allergy_itemName, user_id)
values ('banana',3),
('strawberry',3),
('clams',3),
('asparagus',4),
('broccoli',4),
('grapes',5),
('shrimp',6),
('chicken',6),
('orange',6),
('apple',6);

insert into PantryItem (item_name,user_id)
values ('bread',3),
('beer',3),
('chicken',3),
('steak',4),
('chicken',4),
('asparagus',4),
('tuna',5),
('cheese',5),
('chips',6),
('popcorn',6);

insert into CommentRecipe (user_id,recipe_id,comment_text,comment_time)
values (3,2,'Best Peanut Butter and Jelly I have ever had!','2019-3-11 13:23:44'),
(4,2,'MOST SOGGY PBJ EVER!','2018-4-11 13:23:44'),
(4,1,'This mac and cheese was perfect.','2017-11-21 08:23:44'),
(5,6,'Tastes exactly like my grandmother made.','2015-1-06 02:14:33');

insert into RateRecipe (user_id, recipe_id, rating)
values (3,2,'like'),
(4,2,'dislike'),
(4,1,'like'),
(5,6,'like'),
(4, 218411, 'like'),
(5, 218411, 'like'),
(6, 218411, 'dislike');




select * from User;
select * from Recipe;
select * from Allergy;
select * from PantryItem;
select * from CommentRecipe;
select * from RateRecipe;
