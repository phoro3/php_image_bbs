INSERT INTO users(user_id, password, name) VALUES('miyamori', 'test', '宮森');
INSERT INTO users(user_id, password, name) VALUES('yasuhara', 'test', '安原');
INSERT INTO users(user_id, password, name) VALUES('sakaki', 'test', '坂木');

INSERT INTO comments(user_id, comment) VALUES(1, 'おはよう！');
INSERT INTO comments(parent_comment_id, user_id, comment) VALUES(1, 2, 'おはよう！');
INSERT INTO comments(user_id, comment) VALUES(2, 'おやすみ！');
INSERT INTO comments(user_id, comment) VALUES(1, 'いってきます！');
INSERT INTO comments(user_id, comment) VALUES(3, 'いってらっしゃい！');
INSERT INTO comments(user_id, comment) VALUES(1, 'ただいま！');
INSERT INTO comments(parent_comment_id, user_id, comment) VALUES(6, 2, 'おかえり！');
