INSERT INTO users(user_id, password, name) VALUES('miyamori', 'test', '�{�X');
INSERT INTO users(user_id, password, name) VALUES('yasuhara', 'test', '����');
INSERT INTO users(user_id, password, name) VALUES('sakaki', 'test', '���');

INSERT INTO comments(user_id, comment) VALUES(1, '���͂悤�I');
INSERT INTO comments(parent_comment_id, user_id, comment) VALUES(1, 2, '���͂悤�I');
INSERT INTO comments(user_id, comment) VALUES(2, '���₷�݁I');
INSERT INTO comments(user_id, comment) VALUES(1, '�����Ă��܂��I');
INSERT INTO comments(user_id, comment) VALUES(3, '�����Ă�����Ⴂ�I');
INSERT INTO comments(user_id, comment) VALUES(1, '�������܁I');
INSERT INTO comments(parent_comment_id, user_id, comment) VALUES(6, 2, '��������I');
