SET search_path TO lbaw23117;

INSERT INTO users (name, username, email, password, description, photo, isAdmin, isBanned, emailVerification) VALUES
('Alice Johnson', 'alicej', 'alice@example.com', 'securepwd123', 'User account for Alice', 'alice.jpg', TRUE, FALSE, TRUE),
('Bob Smith', 'bobsmith', 'bob@example.com', 'bobspassword456', 'User account for Bob', 'bob.jpg', FALSE, FALSE, TRUE),
('Charlie Brown', 'charlieb', 'charlie@example.com', 'strongpwd789', 'User account for Charlie', 'charlie.jpg', FALSE, FALSE, TRUE),
('David Wilson', 'davidw', 'david@example.com', 'davidpass4321', 'User account for David', 'david.jpg', FALSE, FALSE, TRUE),
('Eve Anderson', 'evea', 'eve@example.com', 'password1234', 'User account for Eve', 'eve.jpg', FALSE, FALSE, TRUE),
('Frank Miller', 'frankm', 'frank@example.com', 'millerpwd567', 'User account for Frank', 'frank.jpg', FALSE, FALSE, TRUE),
('Grace Martinez', 'gracem', 'grace@example.com', 'grace12345', 'User account for Grace', 'grace.jpg', FALSE, FALSE, TRUE),
('Henry Davis', 'henryd', 'henry@example.com', 'davishash123', 'User account for Henry', 'henry.jpg', FALSE, FALSE, TRUE),
('Ivy Taylor', 'ivyt', 'ivy@example.com', 'ivysecurepwd', 'User account for Ivy', 'ivy.jpg', FALSE, FALSE, TRUE),
('Jack Adams', 'jacka', 'jack@example.com', 'jackpass789', 'User account for Jack', 'jack.jpg', FALSE, FALSE, TRUE),
('Karen White', 'karenw', 'karen@example.com', 'karenpassword', 'User account for Karen', 'karen.jpg', FALSE, FALSE, TRUE),
('Liam Scott', 'liams', 'liam@example.com', 'liam123456', 'User account for Liam', 'liam.jpg', FALSE, FALSE, TRUE),
('Mia Turner', 'miat', 'mia@example.com', 'mia7890pwd', 'User account for Mia', 'mia.jpg', FALSE, FALSE, TRUE),
('Noah Lewis', 'noahl', 'noah@example.com', 'noahpass123', 'User account for Noah', 'noah.jpg', FALSE, FALSE, TRUE),
('Olivia Hall', 'oliviah', 'olivia@example.com', 'secureolivia', 'User account for Olivia', 'olivia.jpg', FALSE, FALSE, TRUE),
('Peter Baker', 'peterb', 'peter@example.com', 'peterpwd2021', 'User account for Peter', 'peter.jpg', FALSE, FALSE, TRUE),
('Quinn King', 'quinnk', 'quinn@example.com', 'kingpwd123', 'User account for Quinn', 'quinn.jpg', FALSE, FALSE, TRUE),
('Riley Garcia', 'rileyg', 'riley@example.com', 'rileypassword', 'User account for Riley', 'riley.jpg', FALSE, FALSE, TRUE),
('Sophia Allen', 'sophiaa', 'sophia@example.com', 'allen1234', 'User account for Sophia', 'sophia.jpg', FALSE, FALSE, TRUE),
('Thomas Wright', 'thomasw', 'thomas@example.com', 'pwdfortom', 'User account for Thomas', 'thomas.jpg', FALSE, FALSE, TRUE);


INSERT INTO interest (interest) VALUES
('Hiking'),
('Photography'),
('Cooking'),
('Reading'),
('Gaming'),
('Travel'),
('Swimming'),
('Cycling'),
('Music'),
('Art');

-- User_interests table, associating users with their interests

-- For user Alice Johnson

INSERT INTO user_interests (userId, interestId) VALUES (1, 1);  -- Alice is interested _in HikingInterests (userId, interestId) VALUES (1, 1);  -- Alice is interested in Hiking
INSERT INTO user_interests (userId, interestId) VALUES (1, 4);  -- Alice is interested in Reading
INSERT INTO user_interests (userId, interestId) VALUES (1, 7);  -- Alice is interested in Swimming

-- For user Bob Smith
INSERT INTO user_interests (userId, interestId) VALUES (2, 2);  -- Bob is interested in Photography
INSERT INTO user_interests (userId, interestId) VALUES (2, 5);  -- Bob is interested in Gaming

-- For user Charlie Brown
INSERT INTO user_interests (userId, interestId) VALUES (3, 3);  -- Charlie is interested in Cooking
INSERT INTO user_interests (userId, interestId) VALUES (3, 6);  -- Charlie is interested in Travel

-- Continue associating users with their interests here, following the same pattern

-- For user Sophia Allen
INSERT INTO user_interests (userId, interestId) VALUES (18, 2);  -- Sophia is interested in Photography
INSERT INTO user_interests (userId, interestId) VALUES (18, 9);  -- Sophia is interested in Music



INSERT INTO skill (skill) VALUES ('Programming');
INSERT INTO skill (skill) VALUES ('Web Development');
INSERT INTO skill (skill) VALUES ('Database Management');
INSERT INTO skill (skill) VALUES ('Graphic Design');
INSERT INTO skill (skill) VALUES ('Data Analysis');
INSERT INTO skill (skill) VALUES ('Project Management');
INSERT INTO skill (skill) VALUES ('Marketing');
INSERT INTO skill (skill) VALUES ('Writing');
INSERT INTO skill (skill) VALUES ('Customer Service');
INSERT INTO skill (skill) VALUES ('Sales');


-- User_skills table, associating users with their skills

-- For Alice Johnson (assuming user ID is 1)
INSERT INTO user_skills (userId, skillId) VALUES (1, 1);
INSERT INTO user_skills (userId, skillId) VALUES (1, 2);

-- For Bob Smith (assuming user ID is 2)
INSERT INTO user_skills (userId, skillId) VALUES (2, 4);
INSERT INTO user_skills (userId, skillId) VALUES (2, 7);

-- For Charlie Brown (assuming user ID is 3)
INSERT INTO user_skills (userId, skillId) VALUES (3, 3);
INSERT INTO user_skills (userId, skillId) VALUES (3, 2);

-- For David Wilson (assuming user ID is 4)
INSERT INTO User_skills (userId, skillId) VALUES (4, 10);
INSERT INTO User_skills (userId, skillId) VALUES (4, 8);

-- For Eve Anderson (assuming user ID is 5)
INSERT INTO user_skills (userId, skillId) VALUES (5, 7);
INSERT INTO user_skills (userId, skillId) VALUES (5, 4);

-- For Frank Miller (assuming user ID is 6)
INSERT INTO user_skills (userId, skillId) VALUES (6, 5);
INSERT INTO user_skills (userId, skillId) VALUES (6, 6);

-- For Grace Martinez (assuming user ID is 7)
INSERT INTO user_skills (userId, skillId) VALUES (7, 9);
INSERT INTO user_skills (userId, skillId) VALUES (7, 1);

-- For Henry Davis (assuming user ID is 8)
INSERT INTO user_skills (userId, skillId) VALUES (8, 3);
INSERT INTO user_skills (userId, skillId) VALUES (8, 6);

-- For Ivy Taylor (assuming user ID is 9)
INSERT INTO user_skills (userId, skillId) VALUES (9, 8);
INSERT INTO user_skills (userId, skillId) VALUES (9, 7);

-- For Jack Adams (assuming user ID is 10)
INSERT INTO user_skills (userId, skillId) VALUES (10, 2);
INSERT INTO user_skills (userId, skillId) VALUES (10, 4);

-- For Karen White (assuming user ID is 11)
INSERT INTO user_skills (userId, skillId) VALUES (11, 5);
INSERT INTO user_skills (userId, skillId) VALUES (11, 1);

-- For Liam Scott (assuming user ID is 12)
INSERT INTO user_skills (userId, skillId) VALUES (12, 2);
INSERT INTO user_skills (userId, skillId) VALUES (12, 7);

-- For Mia Turner (assuming user ID is 13)
INSERT INTO user_skills (userId, skillId) VALUES (13, 10);
INSERT INTO user_skills (userId, skillId) VALUES (13, 1);

-- For Noah Lewis (assuming user ID is 14)
INSERT INTO user_skills (userId, skillId) VALUES (14, 3);
INSERT INTO user_skills (userId, skillId) VALUES (14, 10);

-- For Olivia Hall (assuming user ID is 15)
INSERT INTO user_skills (userId, skillId) VALUES (15, 3);
INSERT INTO user_skills (userId, skillId) VALUES (15, 6);

-- For Peter Baker (assuming user ID is 16)
INSERT INTO user_skills (userId, skillId) VALUES (16, 5);
INSERT INTO user_skills (userId, skillId) VALUES (16, 4);

-- For Quinn King (assuming user ID is 17)
INSERT INTO user_skills (userId, skillId) VALUES (17, 1);
INSERT INTO user_skills (userId, skillId) VALUES (17, 9);

-- For Riley Garcia (assuming user ID is 18)
INSERT INTO user_skills (userId, skillId) VALUES (18, 10);
INSERT INTO user_skills (userId, skillId) VALUES (18, 2);

-- For Sophia Allen (assuming user ID is 19)
INSERT INTO user_skills (userId, skillId) VALUES (19, 7);
INSERT INTO user_skills (userId, skillId) VALUES (19, 4);

-- For Thomas Wright (assuming user ID is 20)
INSERT INTO user_skills (userId, skillId) VALUES (20, 8);
INSERT INTO user_skills (userId, skillId) VALUES (20, 3);


INSERT INTO project (title, description, isPublic, archived, createDate, finishDate, createdBy, projectCoordinator) VALUES
('Website Redesign', 'Redesign our company website to improve user experience and visual appeal.', FALSE, FALSE, '2022-10-21', '2022-11-30', 2, 2),  -- Project 1 created by Alice Johnson and Alice is the coordinator
('Marketing Campaign for New Product', 'Plan and execute a marketing campaign for our upcoming product launch.', TRUE, FALSE, '2022-10-20', '2022-12-15', 3, 3),  -- Project 2 created by Charlie Brown, and Charlie is the coordinator
('Customer Support Enhancement', 'Improve our customer support system to provide better assistance to our clients.', TRUE, FALSE, '2022-10-20', NULL, 5, 5),  -- Project 3 created by Eve Anderson, and Eve is the coordinator
('Sales Optimization Strategy', 'Develop a strategy to optimize our sales processes and increase revenue.', FALSE, FALSE, '2022-10-12','2022-11-30', 7, 7),  -- Project 4 created by Grace Martinez, and Grace is the coordinator
('E-commerce Website Development', 'Create an e-commerce platform for our online store with secure payment processing.', TRUE, FALSE, '2022-9-25', '2022-12-20', 9, 9), -- Project 5 created by Ivy Taylor, and Ivy is the coordinator
('Content Marketing Plan', 'Plan and execute a content marketing strategy to enhance brand visibility.', TRUE, FALSE, '2022-10-13', '2022-11-30', 11, 11), -- Project 6 created by Karen White, and Karen is the coordinator
('Data Analysis for Market Insights', 'Analyze market data to provide insights and improve decision-making.', FALSE, FALSE, '2022-10-14', '2022-12-15', 13, 13), -- Project 7 created by Mia Turner, and Mia is the coordinator
('Social Media Engagement Campaign', 'Increase social media engagement and grow our online presence.', FALSE, TRUE, '2022-10-20', NULL, 15, 15), -- Project 8 created by Olivia Hall, and Olivia is the coordinator
('Project Management Tool Implementation', 'Implement a project management tool for efficient task tracking and coordination.', TRUE, FALSE, '2022-09-29', '2022-11-30',17, 17), -- Project 9 created by Quinn King, and Quinn is the coordinator
('Content Creation and Publishing', 'Create and publish engaging content to boost brand awareness and user engagement.',TRUE, FALSE, '2022-09-30', '2022-12-31', 19, 19),  -- Project 10 created by Sophia Allen, and Sophia is the coordinator
('Mobile App Development', 'Develop a mobile app to provide our users with a better mobile experience.', TRUE, FALSE, '2022-09-01', NULL, 2, 2),  -- Project 11 created by Bob Smith, and Bob is the coordinator
('Product Inventory Management', 'Implement a system to efficiently manage product inventory and restocking.',TRUE, FALSE, '2022-08-02', '2022-11-30', 4, 4),  -- Project 12 created by David Wilson, and David is the coordinator
('Content Writing for Blog', 'Create high-quality content for our company blog to engage readers.', FALSE, FALSE, '2022-01-03', NULL, 6, 6),  -- Project 13 created by Frank Miller, and Frank is the coordinator
('Customer Feedback Surveys', 'Design and conduct customer feedback surveys to gather insights for improvements.', TRUE, FALSE, '2022-02-04', '2022-12-15', 8, 8),  -- Project 14 created by Henry Davis, and Henry is the coordinator
('Social Media Advertising', 'Launch social media advertising campaigns to increase our online reach.', TRUE, FALSE, '2022-03-05', NULL, 10, 10), -- Project 15 created by Jack Adams, and Jack is the coordinator
('Database Optimization', 'Optimize our database systems for faster data retrieval and storage.', FALSE, FALSE, '2022-04-06', '2022-11-30', 12, 12), -- Project 16 created by Liam Scott, and Liam is the coordinator
('Web Security Audit', 'Perform a comprehensive security audit of our website and systems.', FALSE, FALSE, '2022-05-07', NULL, 14, 14), -- Project 17 created by Noah Lewis, and Noah is the coordinator
('Art Gallery Exhibition', 'Organize an art gallery exhibition to showcase local artists and their work.', TRUE, FALSE, '2022-06-08', '2022-12-31', 16, 16), -- Project 18 created by Peter Baker, and Peter is the coordinator
('Music Festival Planning', 'Plan and execute a music festival with multiple artists and stages.', TRUE, FALSE, '2022-07-09', NULL, 18, 18), -- Project 19 created by Quinn King, and Quinn is the coordinator
('Data Analytics Workshop', 'Host a workshop on data analytics to educate employees on data-driven decision-making.', TRUE, FALSE, '2022-09-10', '2022-11-30', 20, 20);  -- Project 20 created by Sophia Allen, and Sophia is the coordinator

INSERT INTO project_users (projectId, userId) VALUES
(1, 3),
(1, 8),
(2, 7),
(2, 17),
(2, 12),
(2, 11),
(3, 8),
(5, 3),
(4, 5),
(6, 4);

INSERT INTO task (title, description, priority, createDate, finishDate, state, createBy, assignedTo, projectTask) VALUES
('Redesign Homepage Banner', 'Create a new homepage banner design for the website with a focus on our upcoming product launch.', 'High', '2022-10-17 08:00:00', '2022-10-18 16:00:00', 'assigned', 1, 2, 1),  -- Task 1 created by Alice Johnson, assigned to Bob Smith, part of Project 1 
('Keyword Research for Marketing', 'Conduct keyword research to identify target keywords for our marketing campaign.', 'Medium', '2022-10-17 09:00:00', NULL, 'open', 3, NULL, 2),  -- Task 2 created by Charlie Brown, not assigned, part of Project 2
('Customer Support Ticket System Upgrade', 'Upgrade our customer support ticket system to improve response times and user experience.', 'Low', '2022-10-17 10:00:00', '2022-10-19 14:00:00', 'assigned', 5, 6, 3),  -- Task 3 created by Eve Anderson, assigned to Frank Miller, part of Project 3
('Sales Report Analysis', 'Analyze recent sales reports to identify trends and opportunities for growth.', 'High', '2022-10-17 11:00:00', NULL, 'open', 7, NULL, 4),  -- Task 4 created by Grace Martinez, not assigned, part of Project 4
('Mobile App UI Design', 'Design the user interface for the mobile app, focusing on a user-friendly experience.', 'Medium', '2022-10-17 12:00:00', '2022-10-20 12:00:00', 'assigned', 9, 10, 5), -- Task 5 created by Ivy Taylor, assigned to Jack Adams, part of Project 5
('Content Marketing Calendar Planning', 'Plan the content marketing calendar for the next quarter to align with our brand strategy.', 'Low', '2022-10-17 13:00:00', NULL, 'open', 11, NULL, 6), -- Task 6 created by Karen White, not assigned, part of Project 6
('Market Data Presentation', 'Prepare a presentation with insights from market data analysis for the executive team.', 'High', '2022-10-17 14:00:00', '2022-10-21 10:00:00', 'archived', 13, 14, 7), -- Task 7 created by Mia Turner, assigned to Noah Lewis, archived by the coordinator as feedback, part of Project 7
('Social Media Content Creation', 'Create engaging social media content to boost user engagement and brand visibility.', 'Medium', '2022-10-17 15:00:00', NULL, 'open', 15, NULL, 8), -- Task 8 created by Olivia Hall, not assigned, part of Project 8
('Project Management Tool Implementation', 'Implement a project management tool for efficient task tracking and coordination.', 'Low', '2022-10-17 16:00:00', '2022-10-22 18:00:00', 'open', 17, 18, 9), -- Task 9 created by Quinn King, assigned to Riley Garcia, and completed waiting for aproval, part of Project 9
('Blog Article Writing', 'Write a blog article on data analytics and its impact on business decision-making for the company blog.', 'High', '2022-10-17 17:00:00', NULL, 'open', 19, NULL, 10); -- Task 10 created by Sophia Allen, not assigned, part of Project 10


INSERT INTO comment (content, createDate, edited, commentBy, taskComment) VALUES
('Great progress on this task!', '2022-10-17 08:30:00', FALSE, 3, 1),  -- Comment 1 by Bob Smith on Task 1 
('I will take care of this. Thanks!', '2022-10-17 10:45:00', FALSE, 1, 5),  -- Comment 2 by Alice Johnson on Task 5
('The new design looks fantastic!', '2022-10-17 14:15:00', FALSE, 4, 3),  -- Comment 3 by David Wilson on Task 3
('I need some more information to proceed.', '2022-10-17 16:30:00', FALSE, 6, 4),  -- Comment 4 by Frank Miller on Task 4
('Task completed ahead of schedule!', '2022-10-18 10:00:00', FALSE, 2, 5), -- Comment 5 by Bob Smith on Task 5
('I am making good progress on this task.', '2022-10-18 12:45:00', FALSE, 5, 6), -- Comment 6 by Eve Anderson on Task 6
('Great insights in the report!', '2022-10-18 16:20:00', FALSE, 7, 7), -- Comment 7 by Grace Martinez on Task 7
('Looking forward to seeing the content!', '2022-10-19 09:30:00', FALSE, 1, 8), -- Comment 8 by Alice Johnson on Task 8
('Tool implementation is on track.', '2022-10-19 13:55:00', FALSE, 18, 9), -- Comment 9 by Riley Garcia on Task 9
('Article is ready for review.', '2022-10-20 10:10:00', FALSE, 19, 10); -- Comment 10 by Sophia Allen on Task 10


INSERT INTO invite (title, description, createDate, invitedBy, invitedTo, projectInvite) VALUES
('Invite 1', 'This is an example invite 1', '2022-10-21', 1, 2, 1),
('Invite 2', 'This is an example invite 2', '2022-10-22', 3, 4, 2),
('Invite 3', 'This is an example invite 3', '2022-10-23', 5, 6, 3),
('Invite 4', 'This is an example invite 4', '2022-10-24', 7, 8, 4),
('Invite 5', 'This is an example invite 5', '2022-10-25', 9, 10, 5),
('Invite 6', 'This is an example invite 6', '2022-10-26', 11, 12, 6),
('Invite 7', 'This is an example invite 7', '2022-10-27', 13, 14, 7),
('Invite 8', 'This is an example invite 8', '2022-10-28', 15, 16, 8),
('Invite 9', 'This is an example invite 9', '2022-10-29', 17, 18, 9),
('Invite 10', 'This is an example invite 10', '2022-10-30', 19, 20, 10);

INSERT INTO message (content, createDate, edited, messageBy, projectMessage) VALUES 
('Hello', '2022-10-21', FALSE, 7, 2),
('Bye', '2022-10-23', FALSE, 12, 2);