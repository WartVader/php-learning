INSERT INTO doingsdone.users
(date_reg, email, name, password) 
VALUES (NOW(), 'wartvader@gmail.com', 'wartvader', '123');

INSERT INTO doingsdone.projects
(name, user_id) VALUES 
('��������', 1),('�����', 1),('������', 1),
('�������� ����', 1),('����', 1);

INSERT INTO doingsdone.tasks
(user_id, proj_id, date_create, status, name, deadline) VALUES 
(1, 3, NOW(), 0, '������������� � IT ��������', '2018-12-01'),
(1, 3, NOW(), 0, '��������� �������� �������', '2018-12-25'),
(1, 2, NOW(), 1, '������� ������� ������� �������', '2018-12-21'),
(1, 1, NOW(), 0, '������� � ������', '2018-12-22'),
(1, 4, NOW(), 0, '������ ���� ��� ����', '2021-01-26'),
(1, 4, NOW(), 0, '�������� �����', null);

SELECT u.name, p.name FROM doingsdone.projects p 
INNER JOIN doingsdone.users u ON u.id = p.user_id;

SELECT p.name, COUNT(t.name) FROM doingsdone.tasks t 
INNER JOIN doingsdone.projects p ON p.id = t.proj_id
GROUP BY p.id;

SELECT p.name, t.name FROM doingsdone.tasks t 
INNER JOIN doingsdone.projects p ON p.id = t.proj_id
WHERE p.id = 1;