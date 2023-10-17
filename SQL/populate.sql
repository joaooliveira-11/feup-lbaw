INSERT INTO User (name, username, email, password, description, photo, isAdmin, isBanned, emailVerification) VALUES

('Nome1', 'Username1', 'email1@example.com', 'password1', 'Descrição1', 'photo1.jpg', 0, 0, 0),

INSERT INTO Interest (interest) VALUES
('Interesse Exemplo 1');

INSERT INTO UserInterests (userId, interestId) VALUES
(2, 1);

INSERT INTO Skill (skill) VALUES 
('Habilidade Exemplo 1');

INSERT INTO UserSkills (skill) VALUES 
('Habilidade Exemplo 1');

INSERT INTO Project (title, description, createdBy, projectCoordinator)
