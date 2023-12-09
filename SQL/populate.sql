SET search_path TO lbaw23117;

-----------------------------------------
-- Populate the database
-----------------------------------------

INSERT INTO users (name, username, email, password, description, is_admin, is_banned, email_verification) VALUES
('Admin', 'admin', 'admin@gmail.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'User account for Admin', TRUE, FALSE, TRUE),
('Bob Smith', 'bobsmith', 'bob@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'User account for Bob', FALSE, FALSE, TRUE),
('Charlie Brown', 'charlieb', 'charlie@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'User account for Charlie', FALSE, FALSE, TRUE),
('Dav_id Wilson', 'dav_idw', 'dav_id@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'User account for Dav_id', FALSE, TRUE, TRUE),
('Eve Anderson', 'evea', 'eve@example.com', 'password1234', 'User account for Eve', FALSE, FALSE, TRUE),
('Frank Miller', 'frankm', 'frank@example.com', 'millerpwd567', 'User account for Frank', FALSE, FALSE, TRUE),
('Grace Martinez', 'gracem', 'grace@example.com', 'grace12345', 'User account for Grace', FALSE, FALSE, TRUE),
('Henry Davis', 'henryd', 'henry@example.com', 'davishash123', 'User account for Henry', FALSE, FALSE, TRUE),
('Ivy Taylor', 'ivyt', 'ivy@example.com', 'ivysecurepwd', 'User account for Ivy', FALSE, FALSE, TRUE),
('Jack Adams', 'jacka', 'jack@example.com', 'jackpass789', 'User account for Jack', FALSE, FALSE, TRUE),
('Karen White', 'karenw', 'karen@example.com', 'karenpassword', 'User account for Karen', FALSE, FALSE, TRUE),
('Liam Scott', 'liams', 'liam@example.com', 'liam123456', 'User account for Liam', FALSE, FALSE, TRUE),
('Mia Turner', 'miat', 'mia@example.com', 'mia7890pwd', 'User account for Mia', FALSE, FALSE, TRUE),
('Noah Lewis', 'noahl', 'noah@example.com', 'noahpass123', 'User account for Noah', FALSE, FALSE, TRUE),
('Olivia Hall', 'oliviah', 'olivia@example.com', 'secureolivia', 'User account for Olivia', FALSE, FALSE, TRUE),
('Peter Baker', 'peterb', 'peter@example.com', 'peterpwd2021', 'User account for Peter', FALSE, FALSE, TRUE),
('Quinn King', 'quinnk', 'quinn@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'User account for Quinn', FALSE, FALSE, TRUE),
('Riley Garcia', 'rileyg', 'riley@example.com', 'rileypassword', 'User account for Riley', FALSE, FALSE, TRUE),
('Sophia Allen', 'sophiaa', 'sophia@example.com', 'allen1234', 'User account for Sophia', FALSE, FALSE, TRUE),
('Thomas Wright', 'thomasw', 'thomas@example.com', 'pwdfortom', 'User account for Thomas', FALSE, FALSE, TRUE),
('Oliver Smith', 'olivers', 'oliver@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'User account for Oliver', FALSE, FALSE, TRUE),
('Penelope Johnson', 'penelopej', 'penelope@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'User account for Penelope', FALSE, FALSE, TRUE),
('Quincy Adams', 'quincya', 'quincy@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'User account for Quincy', FALSE, FALSE, TRUE),
('Rose Carter', 'rosec', 'rose@example.com', 'rosecarterpwd', 'User account for Rose', FALSE, FALSE, TRUE),
('Samuel Parker', 'samuelp', 'samuel@example.com', 'sampassword123', 'User account for Samuel', FALSE, FALSE, TRUE),
('Tiffany Walker', 'tiffanyw', 'tiffany@example.com', 'tiffwalkersecure', 'User account for Tiffany', FALSE, FALSE, TRUE),
('Ulysses Morris', 'ulyssesm', 'ulysses@example.com', 'ulyssespwd', 'User account for Ulysses', FALSE, FALSE, TRUE),
('Victoria Garcia', 'victoriag', 'victoria@example.com', 'victoriapass', 'User account for Victoria', FALSE, FALSE, TRUE),
('William Adams', 'williama', 'william@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'User account for William', FALSE, FALSE, TRUE),
('Xander King', 'xanderk', 'xander@example.com', 'xander12345', 'User account for Xander', FALSE, FALSE, TRUE),
('Yara Lopez', 'yaral', 'yara@example.com', 'yarasecurepwd', 'User account for Yara', FALSE, FALSE, TRUE),
('Zane Scott', 'zanes', 'zane@example.com', 'zanesecure', 'User account for Zane', FALSE, FALSE, TRUE),
('Ava Turner', 'avat', 'ava@example.com', 'avapassword', 'User account for Ava', FALSE, FALSE, TRUE),
('Benjamin Foster', 'benjaminf', 'benjamin@example.com', 'benjamin123', 'User account for Benjamin', FALSE, FALSE, TRUE),
('Chloe Davis', 'chloed', 'chloe@example.com', 'chloepwd', 'User account for Chloe', FALSE, FALSE, TRUE);

INSERT INTO interest (interest) VALUES
('Coding'),
('Web Development'),
('Machine Learning'),
('Open Source'),
('Data Science'),
('Problem Solving'),
('V_ideo Games'),
('AI and Robotics'),
('Blockchain'),
('Cybersecurity'),
('DevOps'),
('Cloud Computing'),
('Agile Methodology'),
('Hackathons'),
('Tech Conferences'),
('Programming Competitions'),
('Linux');


INSERT INTO user_interests (user_id, interest_id) VALUES 
(1, 1),
(1, 4),
(1, 7),
(2, 12),
(2, 15),
(3, 13),
(3, 16),
(4, 2),
(4, 9),
(5, 10),
(5, 11),
(6, 3),
(6, 5),
(7, 6),
(7, 8),
(8, 12),
(8, 13),
(9, 14),
(9, 1),
(10, 15),
(10, 17),
(11, 12),
(11, 15),
(12, 13), 
(12, 16),
(13, 13), 
(13, 16),
(14, 12), 
(14, 4),
(15, 3),
(15, 12), 
(16, 1), 
(16, 16),
(17, 7),
(17, 8),
(18, 17),
(18, 9),
(19, 9),
(19, 4),
(20, 11),
(20, 10),
(21, 2),
(21, 6),
(22, 5),
(22, 9),
(23, 1),
(23, 7),
(24, 3),
(24, 11),
(25, 4),
(25, 12),
(26, 10),
(26, 16),
(27, 14),
(27, 5),
(28, 8),
(28, 15);

INSERT INTO skill (skill) VALUES 
('Programming'),
('Web Development'),
('Database Management'),
('Graphic Design'),
('Data Analysis'),
('Project Management'),
('Marketing'),
('Cybersecurity'),
('DevOps'),
('IT Support'),
('Software Development'),
('Data Science');


INSERT INTO user_skills (user_id, skill_id) VALUES 
(2, 4),
(2, 7),
(3, 3),
(3, 2),
(4, 10),
(4, 8),
(5, 1),
(5, 12),
(6, 5),
(6, 6),
(7, 9),
(7, 7),
(8, 11),
(8, 6),
(9, 8),
(9, 7),
(10, 2),
(10, 4),
(11, 5),
(11, 1),
(12, 3),
(12, 7),
(13, 10),
(13, 1),
(14, 5),
(14, 10),
(15, 12),
(15, 6),
(16, 5),
(16, 11),
(17, 1),
(17, 9),
(18, 10),
(18, 2),
(19, 7),
(19, 4),
(20, 8),
(20, 3),
(21, 2),
(21, 6),
(22, 5),
(22, 9),
(23, 1),
(23, 7),
(24, 3),
(24, 1),
(25, 4),
(25, 2),
(26, 10),
(26, 6),
(27, 4),
(27, 5),
(28, 8),
(28, 5);


INSERT INTO project (title, description, is_public, archived, create_date, finish_date, created_by, project_coordinator) VALUES
('Website Redesign', 'Redesign our company website to improve user experience and visual appeal.', FALSE, FALSE, '2022-10-21', '2023-11-30', 2, 2),
('Marketing Campaign for New Product', 'Plan and execute a marketing campaign for our upcoming product launch.', TRUE, FALSE, '2022-10-20', '2022-12-15', 3, 3),
('Customer Support Enhancement', 'Improve our customer support system to prov_ide better assistance to our clients.', TRUE, FALSE, '2022-10-20', NULL, 5, 5),
('Sales Optimization Strategy', 'Develop a strategy to optimize our sales processes and increase revenue.', FALSE, FALSE, '2022-10-12','2022-11-30', 7, 7),
('E-commerce Website Development', 'Create an e-commerce platform for our online store with secure payment processing.', TRUE, FALSE, '2022-9-25', '2022-12-20', 9, 9),
('Content Marketing Plan', 'Plan and execute a content marketing strategy to enhance brand visibility.', TRUE, FALSE, '2022-10-13', '2022-11-30', 11, 11), 
('Data Analysis for Market Insights', 'Analyze market data to prov_ide insights and improve decision-making.', FALSE, FALSE, '2022-10-14', '2022-12-15', 13, 13),
('Social Media Engagement Campaign', 'Increase social media engagement and grow our online presence.', FALSE, TRUE, '2022-10-20', NULL, 15, 15),
('Project Management Tool Implementation', 'Implement a project management tool for efficient task tracking and coordination.', TRUE, FALSE, '2022-09-29', '2022-11-30',17, 17),
('Content Creation and Publishing', 'Create and publish engaging content to boost brand awareness and user engagement.',TRUE, FALSE, '2022-09-30', '2022-12-31', 19, 19),
('Mobile App Development', 'Develop a mobile app to prov_ide our users with a better mobile experience.', TRUE, FALSE, '2022-09-01', NULL, 2, 2),
('Product Inventory Management', 'Implement a system to efficiently manage product inventory and restocking.',TRUE, FALSE, '2022-08-02', '2022-11-30', 4, 4),
('Content Writing for Blog', 'Create high-quality content for our company blog to engage readers.', FALSE, FALSE, '2022-01-03', NULL, 5, 5),
('Customer Feedback Surveys', 'Design and conduct customer feedback surveys to gather insights for improvements.', TRUE, FALSE, '2022-02-04', '2022-12-15', 12, 12),
('Social Media Advertising', 'Launch social media advertising campaigns to increase our online reach.', TRUE, FALSE, '2022-03-05', NULL, 7, 7),
('Database Optimization', 'Optimize our database systems for faster data retrieval and storage.', FALSE, FALSE, '2022-04-06', '2022-11-30', 6, 6),
('Web Security Audit', 'Perform a comprehensive security audit of our website and systems.', FALSE, FALSE, '2022-05-07', NULL, 14, 14),
('Art Gallery Exhibition', 'Organize an art gallery exhibition to showcase local artists and their work.', TRUE, FALSE, '2022-06-08', '2022-12-31', 16, 16),
('Music Festival Planning', 'Plan and execute a music festival with multiple artists and stages.', TRUE, FALSE, '2022-07-09', NULL, 11, 11),
('Data Analytics Workshop', 'Host a workshop on data analytics to educate employees on data-driven decision-making.', TRUE, FALSE, '2022-09-10', '2022-11-30', 15, 15),
('AI Chatbot Development', 'Develop an AI-powered chatbot to improve customer support.', FALSE, FALSE, '2022-11-01', '2023-01-15', 21, 21),
('Mobile App UI Redesign', 'Redesign the user interface of our mobile app for a modern look and feel.', TRUE, FALSE, '2022-11-05', '2022-12-31', 22, 22),
('Digital Marketing Campaign', 'Execute a comprehensive digital marketing campaign to boost brand awareness.', TRUE, FALSE, '2022-11-10', '2023-02-28', 23, 23),
('Data Visualization Dashboard', 'Create an interactive data visualization dashboard for real-time insights.', FALSE, FALSE, '2022-11-12', '2023-03-31', 24, 24),
('Cloud Migration Strategy', 'Develop a strategy for migrating our IT infrastructure to the cloud.', TRUE, FALSE, '2022-11-15', '2023-04-30', 25, 25),
('Scrum Master Training', 'Provide Scrum Master training for team members to improve Agile practices.', FALSE, FALSE, '2022-11-18', '2023-03-15', 26, 26),
('Content Writing Workshop', 'Host a workshop on effective content writing techniques for marketing purposes.', TRUE, FALSE, '2022-11-20', '2023-05-31', 27, 27),
('Database Optimization Project', 'Optimize database performance for faster data retrieval and reporting.', FALSE, FALSE, '2022-11-22', '2023-06-30', 28, 28),
('Product Launch Event', 'Organize a grand event for the launch of our latest product.', TRUE, FALSE, '2023-01-10', '2023-02-28', 7, 7),
('Market Research for Expansion', 'Conduct in-depth market research to identify new opportunities for expansion.', TRUE, FALSE, '2023-02-15', NULL, 3, 3),
('Supply Chain Optimization', 'Optimize our supply chain processes for cost reduction and efficiency improvement.', TRUE, FALSE, '2023-03-20', '2023-06-30', 5, 5),
('Employee Training Program', 'Develop and implement a comprehensive employee training program.', FALSE, FALSE, '2023-04-05', '2023-12-31', 7, 7),
('New Website Features Development', 'Add new features and functionality to our company website.', TRUE, FALSE, '2023-05-10', '2023-08-31', 9, 9),
('Content Localization Project', 'Localize our content for international markets and audiences.', TRUE, FALSE, '2023-06-15', NULL, 11, 11),
('Quality Assurance and Testing', 'Conduct extensive quality assurance and testing for our software products.', FALSE, FALSE, '2023-07-20', '2023-11-30', 13, 13),
('Green Initiative Campaign', 'Launch an environmental sustainability campaign to reduce our carbon footprint.', TRUE, FALSE, '2023-08-05', NULL, 15, 15),
('Customer Loyalty Program', 'Create a customer loyalty program to reward and retain our loyal customers.', TRUE, FALSE, '2023-09-10', '2023-12-31', 17, 17),
('Sales and Marketing Alignment', 'Align sales and marketing teams for improved lead generation and conversion.', TRUE, FALSE, '2023-10-15', NULL, 19, 19),
('AI-powered Chat Support', 'Implement AI-driven chat support to enhance customer service.', TRUE, FALSE, '2023-11-20', NULL, 21, 21),
('Mobile App Performance Optimization', 'Optimize the performance of our mobile app for faster response times.', TRUE, FALSE, '2023-11-01', '2024-02-29', 23, 23),
('Digital Advertising Campaign', 'Launch a targeted digital advertising campaign to boost online sales.', TRUE, FALSE, '2023-01-05', '2024-03-31', 25, 25),
('Big Data Analytics Project', 'Utilize big data analytics to gain valuable insights for strategic decision-making.', TRUE, FALSE, '2023-02-10', NULL, 27, 27),
('IT Security Enhancement', 'Enhance IT security measures to protect against cyber threats and data breaches.', FALSE, FALSE, '2023-03-15', '2024-06-30', 29, 29);


INSERT INTO project_users (project_id, user_id) VALUES
(1, 3), (1, 8), (1, 10), (1, 12), (1, 13),
(2, 7), (2, 11), (2, 12), (2, 14), (2, 15),
(3, 8), (3, 13), (3, 16), (3, 18), (3, 19),
(4, 4), (4, 5), (4, 6), (4, 12), (4, 8),
(5, 6), (5, 15), (5, 16), (5, 17), (5, 18),
(6, 12), (6, 14), (6, 15), (6, 17), (6, 18),
(7, 4), (7, 9), (7, 10), (7, 11), (7, 12),
(8, 10), (8, 13), (8, 16), (8, 7), (8, 18),
(9, 2), (9, 5), (9, 7), (9, 14), (9, 15),
(10, 8), (10, 14), (10, 16), (10, 18), (10, 9),
(11, 7), (11, 12), (11, 15), (11, 17), (11, 19),
(12, 2), (12, 3), (12, 6), (12, 9), (12, 11),
(13, 18), (13, 19), (13, 20), (13, 21), (13, 22),
(14, 6), (14, 16), (14, 17), (14, 19), (14, 21),
(15, 11), (15, 15), (15, 20), (15, 22), (15, 23),
(16, 8), (16, 13), (16, 17), (16, 19), (16, 23),
(17, 2), (17, 9), (17, 11), (17, 12), (17, 13),
(18, 4), (18, 5), (18, 7), (18, 10), (18, 12),
(19, 6), (19, 16), (19, 19), (19, 20), (19, 24),
(20, 10), (20, 12), (20, 14), (20, 18), (20, 23),
(21, 3), (21, 8), (21, 10), (21, 12), (21, 13),
(22, 7), (22, 11), (22, 12), (22, 14), (22, 15),
(23, 8), (23, 13), (23, 16), (23, 18), (23, 19),
(24, 4), (24, 5), (24, 6), (24, 7), (24, 8),
(25, 6), (25, 15), (25, 16), (25, 17), (25, 18),
(26, 12), (26, 13), (26, 15), (26, 17), (26, 18),
(27, 4), (27, 9), (27, 10), (27, 11), (27, 12),
(28, 10), (28, 13), (28, 16), (28, 17), (28, 18),
(29, 2), (29, 5), (29, 8), (29, 14), (29, 15),
(30, 8), (30, 14), (30, 16), (30, 18), (30, 19),
(31, 7), (31, 12), (31, 15), (31, 17), (31, 19),
(32, 2), (32, 3), (32, 6), (32, 9), (32, 11),
(33, 18), (33, 19), (33, 20), (33, 21), (33, 22),
(34, 6), (34, 16), (34, 17), (34, 19), (34, 21),
(35, 11), (35, 15), (35, 20), (35, 22), (35, 23),
(36, 8), (36, 13), (36, 17), (36, 19), (36, 23),
(37, 2), (37, 9), (37, 11), (37, 12), (37, 13),
(38, 4), (38, 5), (38, 7), (38, 10), (38, 12),
(39, 6), (39, 16), (39, 19), (39, 20), (39, 24),
(40, 10), (40, 12), (40, 14), (40, 18), (40, 22),
(41, 3), (41, 9), (41, 15), (41, 12), (41, 19),
(42, 7), (42, 2), (42, 5), (42, 17), (42, 22),
(43, 2), (43, 11), (43, 13), (43, 18), (43, 14);



INSERT INTO task (title, description, priority, create_date, finish_date, state, create_by, assigned_to, project_task) VALUES
-- Tasks for Project 1 (Website Redesign)
('Design New Website Homepage', 'Create a visually appealing homepage design for the website, incorporating our brand colors and elements.', 'High', '2022-12-01 09:00:00', NULL, 'open', 8, 3, 1),
('Keyword Research and Analysis', 'Conduct comprehensive keyword research to identify high-impact keywords for our SEO strategy.', 'Medium', '2022-12-01 10:00:00', NULL, 'open', 10, 8, 1),
('Plan Product Launch Event', 'Coordinate all aspects of our upcoming product launch event, including venue, invitations, and logistics.', 'High', '2022-12-01 11:00:00', NULL, 'open', 3, 10, 1),
('Upgrade Customer Support System', 'Enhance our customer support ticket system to improve response times and streamline customer interactions.', 'Medium', '2022-12-01 12:00:00', NULL, 'open', 10, 12, 1),
('Analyze Sales Trends', 'Examine recent sales reports and identify trends to optimize our sales strategy.', 'Low', '2022-12-01 13:00:00', NULL, 'open', 12, 13, 1),
('Design Mobile App Interface', 'Create an intuitive and user-friendly interface design for our mobile app.', 'Medium', '2022-12-01 14:00:00', NULL, 'open', 13, 3, 1),
('Create Wireframes for Website Redesign', 'Develop wireframes for the new website design to visualize layout and structure.', 'Medium', '2022-12-02 09:00:00', NULL, 'open', 3, 13, 1),
('Content Audit and Optimization', 'Review existing website content, identify areas for improvement, and optimize for SEO.', 'High', '2022-12-02 10:00:00', NULL, 'open', 8, 8, 1),
('Implement Responsive Design', 'Ensure that the website is responsive and functions well on various devices (desktop, mobile, tablet).', 'Medium', '2022-12-02 11:00:00', NULL, 'open', 13, 10, 1),
('User Testing and Feedback Gathering', 'Conduct user testing sessions to gather feedback on the new website design and functionality.', 'Low', '2022-12-02 12:00:00', NULL, 'open', 10, 8, 1),

-- Tasks for Project 2 (Marketing Campaign for New Product)
('Social Media Marketing Campaign', 'Launch a targeted social media marketing campaign to increase brand awareness and engagement for our upcoming product.', 'High', '2022-12-02 09:00:00', NULL, 'open', 11, 7, 2),
('Content Marketing Strategy', 'Develop a comprehensive content marketing strategy aligned with our brand and audience for the new product launch.', 'Low', '2022-12-02 10:00:00', NULL, 'open', 7, 11, 2),
('Product Development Planning', 'Plan the development roadmap for our upcoming product, defining milestones and deadlines in preparation for the launch campaign.', 'High', '2022-12-02 11:00:00', NULL, 'open', 12, 12, 2),
('Website Redesign', 'Revamp the website design to enhance user experience and align with the latest design trends as part of the new product marketing campaign.', 'Medium', '2022-12-02 12:00:00', NULL, 'open', 15, 14, 2),
('Market Research Analysis', 'Conduct in-depth market research to identify potential growth opportunities and market trends that can inform our new product marketing campaign.', 'Medium', '2022-12-02 13:00:00', NULL, 'open', 7, 15, 2),
('User Interface Testing', 'Perform thorough testing of the mobile app user interface to ensure a bug-free experience for users of our new product.', 'Low', '2022-12-02 14:00:00', NULL, 'open', 14, 7, 2),
('Email Marketing Campaign', 'Develop and execute an email marketing campaign targeting our existing customer base to promote the new product.', 'High', '2022-12-03 09:00:00', NULL, 'open', 14, 12, 2),
('Ad Campaign Creative Design', 'Create eye-catching ad creatives for online advertising channels to support the marketing campaign for the new product.', 'High', '2022-12-03 10:00:00', NULL, 'open', 12, 14, 2),

-- Tasks for Project 3 (Customer Support Enhancement)
('Financial Analysis Report', 'Prepare a detailed financial analysis report based on the latest financial data and trends.', 'High', '2022-12-03 09:00:00', NULL, 'open', 13, 8, 3),
('Customer Feedback Analysis', 'Analyze customer feedback data to identify areas for improvement and enhance customer satisfaction.', 'High', '2022-12-03 10:00:00', NULL, 'open', 8, 13, 3),
('Software Development', 'Develop and test new software features to improve our product functionality and user experience.', 'Low', '2022-12-03 11:00:00', NULL, 'open', 16, 16, 3),
('Database Optimization', 'Optimize the database performance to ensure fast data retrieval and efficient data storage.', 'Medium', '2022-12-03 12:00:00', NULL, 'open', 18, 18, 3),
('Content Creation', 'Generate engaging content for our blog and social media channels to increase brand visibility.', 'Low', '2022-12-03 13:00:00', NULL, 'open', 8, 19, 3),
('User Training Session', 'Organize a training session to educate employees on the latest software updates and features.', 'Medium', '2022-12-03 14:00:00', NULL, 'open', 19, 8, 3),

-- Tasks for Project 4 (Sales Optimization Strategy)
('Sales Process Analysis', 'Conduct an in-depth analysis of our current sales processes to identify areas for improvement.', 'High', '2022-12-04 09:00:00', NULL, 'open', 4, 4, 4),
('Revenue Growth Plan', 'Develop a plan to increase revenue through targeted sales initiatives and strategies.', 'High', '2022-12-04 10:00:00', NULL, 'open', 4, 5, 4),
('Competitor Analysis', 'Analyze our competitors sales strategies and market positioning to gain a competitive edge.', 'Low', '2022-12-04 11:00:00', NULL, 'open', 12, 6, 4),
('Sales Team Training', 'Provide training sessions for our sales team to enhance their skills and product knowledge.', 'Medium', '2022-12-04 12:00:00', NULL, 'open', 5, 12, 4),
('Customer Relationship Management', 'Implement a CRM system to streamline customer interactions and improve sales tracking.', 'Medium', '2022-12-04 13:00:00', NULL, 'open', 8, 8, 4),
('Sales Performance Metrics', 'Define key performance metrics and measurement methods to track sales performance.', 'Low', '2022-12-04 14:00:00', NULL, 'open', 12, 4, 4),

-- Tasks for Project 5 (E-commerce Website Development)
('Payment Gateway Integration', 'Integrate secure payment gateways into the e-commerce website for smooth and safe transactions.', 'High', '2022-12-05 09:00:00', NULL, 'open', 15, 6, 5),
('Product Catalog Setup', 'Create a comprehensive product catalog with detailed descriptions and images for the online store.', 'High', '2022-12-05 10:00:00', NULL, 'open', 16, 15, 5),
('User Account Management', 'Implement user account management features to allow customers to register and manage their profiles.', 'Medium', '2022-12-05 11:00:00', NULL, 'open', 18, 16, 5),
('Security and Data Protection', 'Enhance website security and data protection measures to safeguard customer information.', 'Low', '2022-12-05 12:00:00', NULL, 'open', 18, 17, 5),
('Responsive Design Implementation', 'Ensure the e-commerce website is responsive and provides a seamless experience on all devices.', 'Medium', '2022-12-05 13:00:00', NULL, 'open', 15, 18, 5),
('Checkout Process Optimization', 'Optimize the checkout process to reduce cart abandonment and increase conversions.', 'Medium', '2022-12-05 14:00:00', NULL, 'open', 18, 6, 5),

-- Tasks for Project 6 (Content Marketing Plan)
('Content Calendar Creation', 'Develop a content calendar outlining content topics and publication schedules for the upcoming months.', 'Low', '2022-12-06 09:00:00', NULL, 'open', 14, 12, 6),
('Keyword Research and SEO Optimization', 'Conduct keyword research and optimize existing content for improved search engine rankings.', 'High', '2022-12-06 10:00:00', NULL, 'open', 12, 14, 6),
('Blog Post Writing', 'Produce engaging blog posts on relevant topics to attract and educate our target audience.', 'High', '2022-12-06 11:00:00', NULL, 'open', 17, 15, 6),
('Social Media Content Creation', 'Create compelling social media content to share our blog posts and engage with our audience.', 'Medium', '2022-12-06 12:00:00', NULL, 'open', 15, 17, 6),
('Email Newsletter Campaign', 'Plan and execute email newsletter campaigns to keep subscribers informed and engaged.', 'Low', '2022-12-06 13:00:00', NULL, 'open', 12, 18, 6),
('Content Performance Analysis', 'Analyze the performance of published content to refine the content marketing strategy.', 'Medium', '2022-12-06 14:00:00', NULL, 'open', 18, 12, 6),

-- Tasks for Project 7 (Data Analysis for Market Insights)
('Data Collection and Aggregation', 'Collect and aggregate relevant market data from various sources for analysis.', 'High', '2022-12-07 09:00:00', NULL, 'open', 9, 4, 7),
('Market Segmentation Analysis', 'Segment the market data to identify distinct customer groups and their characteristics.', 'High', '2022-12-07 10:00:00', NULL, 'open', 4, 9, 7),
('Competitor Analysis', 'Analyze the strategies and performance of competitors in the market.', 'High', '2022-12-07 11:00:00', NULL, 'open', 11, 10, 7),
('Trend Identification', 'Identify market trends and emerging patterns that can impact business decisions.', 'Medium', '2022-12-07 12:00:00', NULL, 'open', 10, 11, 7),
('Data Visualization and Reporting', 'Create visual reports and dashboards to present market insights to stakeholders.', 'Medium', '2022-12-07 13:00:00', NULL, 'open', 4, 12, 7),
('Strategic Recommendations', 'Provide strategic recommendations based on the analysis to guide decision-making.', 'Medium', '2022-12-07 14:00:00', NULL, 'open', 12, 4, 7),

-- Tasks for Project 8 (Social Media Engagement Campaign)
('Social Media Content Strategy', 'Develop a content strategy to enhance social media engagement and brand visibility.', 'Low', '2022-12-08 09:00:00', NULL, 'open', 13, 10, 8),
('Content Creation and Scheduling', 'Create and schedule engaging social media content to boost online presence.', 'High', '2022-12-08 10:00:00', NULL, 'open', 10, 13, 8),
('Audience Engagement Analysis', 'Analyze social media engagement metrics to identify opportunities for improvement.', 'High', '2022-12-08 11:00:00', NULL, 'open', 7, 16, 8),
('Influencer Collaboration', 'Collaborate with social media influencers to expand reach and engagement.', 'Medium', '2022-12-08 12:00:00', NULL, 'open', 16, 7, 8),
('Performance Reporting', 'Generate performance reports and insights to track the success of the campaign.', 'Low', '2022-12-08 13:00:00', NULL, 'open', 10, 18, 8),
('Campaign Optimization', 'Optimize the social media engagement campaign based on data-driven insights.', 'Medium', '2022-12-08 14:00:00', NULL, 'open', 18, 10, 8),

-- Tasks for Project 9 (Project Management Tool Implementation)
('Requirements Gathering', 'Gather and document the requirements for the project management tool.', 'High', '2022-12-09 09:00:00', NULL, 'open', 5, 2, 9),
('Tool Selection and Setup', 'Select the appropriate project management tool and set up the system.', 'Low', '2022-12-09 10:00:00', NULL, 'open', 2, 5, 9),
('User Training and Onboarding', 'Provide training and onboarding sessions for team members to use the tool effectively.', 'High', '2022-12-09 11:00:00', NULL, 'open', 2, 2, 9),
('Integration with Existing Systems', 'Integrate the project management tool with existing systems for seamless coordination.', 'Medium', '2022-12-09 12:00:00', NULL, 'open', 15, 14, 9),
('Testing and Quality Assurance', 'Thoroughly test the tools functionality and ensure quality assurance.', 'Low', '2022-12-09 13:00:00', NULL, 'open', 14, 15, 9),
('Tool Documentation', 'Create documentation for the project management tool for reference and support.', 'Medium', '2022-12-09 14:00:00', NULL, 'open', 5, 2, 9),

-- Tasks for Project 10 (Content Creation and Publishing)
('Content Planning and Ideation', 'Plan and ideate content ideas that align with the brand and target audience.', 'High', '2022-12-10 09:00:00', NULL, 'open', 14, 8, 10),
('Content Creation and Editing', 'Create and edit high-quality content, including articles, videos, and graphics.', 'Low', '2022-12-10 10:00:00', NULL, 'open', 8, 14, 10),
('Content Publishing and Promotion', 'Publish content on various platforms and promote it to the target audience.', 'High', '2022-12-10 11:00:00', NULL, 'open', 16, 16, 10),
('Audience Engagement Monitoring', 'Monitor audience engagement and interactions with published content.', 'Low', '2022-12-10 12:00:00', NULL, 'open', 18, 18, 10),
('Performance Analytics and Reporting', 'Analyze content performance and generate reports for optimization.', 'Medium', '2022-12-10 13:00:00', NULL, 'open', 8, 9, 10),
('Content Calendar Management', 'Manage and update the content calendar for consistent publishing schedules.', 'Medium', '2022-12-10 14:00:00', NULL, 'open', 9, 8, 10),

-- Tasks for Project 11 (Mobile App Development)
('App Requirements Analysis', 'Analyze and document the requirements for the mobile app development project.', 'Low', '2022-12-11 09:00:00', NULL, 'open', 12, 7, 11),
('App Design and Wireframing', 'Create the apps design and wireframes to visualize its user interface and functionality.', 'High', '2022-12-11 10:00:00', NULL, 'open', 7, 12, 11),
('Development and Coding', 'Develop and code the mobile app according to the approved design and requirements.', 'High', '2022-12-11 11:00:00', NULL, 'open', 17, 15, 11),
('Testing and Quality Assurance', 'Thoroughly test the mobile app to identify and resolve any bugs or issues.', 'Medium', '2022-12-11 12:00:00', NULL, 'open', 17, 17, 11),
('App Deployment and Launch', 'Prepare for the apps deployment to app stores and plan its official launch.', 'Low', '2022-12-11 13:00:00', NULL, 'open', 15, 19, 11),
('User Feedback and Iteration', 'Collect user feedback and make iterative improvements to the app.', 'Medium', '2022-12-11 14:00:00', NULL, 'open', 19, 7, 11),

-- Tasks for Project 12 (Product Inventory Management)
('Inventory System Analysis', 'Analyze the current inventory management system and identify shortcomings.', 'High', '2022-12-12 09:00:00', NULL, 'open', 6, 3, 12),
('Feature Enhancement Planning', 'Plan the enhancement of inventory management system features for efficiency.', 'Low', '2022-12-12 10:00:00', NULL, 'open', 2, 6, 12),
('Development and Implementation', 'Develop and implement the enhanced features in the inventory system.', 'High', '2022-12-12 11:00:00', NULL, 'open', 3, 2, 12),
('Testing and Quality Assurance', 'Conduct rigorous testing to ensure the reliability and accuracy of the system.', 'Medium', '2022-12-12 12:00:00', NULL, 'open', 3, 9, 12),
('User Training and Adoption', 'Provide training to users for effective utilization of the enhanced inventory system.', 'Low', '2022-12-12 13:00:00', NULL, 'open', 9, 3, 12),
('System Maintenance and Support', 'Offer ongoing maintenance and support for the improved inventory management system.', 'Medium', '2022-12-12 14:00:00', NULL, 'open', 11, 11, 12),

-- Tasks for Project 13 (Content Writing for Blog)
('Topic Ideation and Research', 'Research and brainstorm topics for blog posts that resonate with our target audience.', 'High', '2022-12-13 09:00:00', NULL, 'open', 19, 18, 13),
('Content Creation and Editing', 'Write high-quality blog content and edit it for clarity and engagement.', 'Low', '2022-12-13 10:00:00', NULL, 'open', 18, 19, 13),
('SEO Optimization', 'Optimize blog posts for search engines to improve visibility and organic traffic.', 'High', '2022-12-13 11:00:00', NULL, 'open', 21, 20, 13),
('Publishing and Promotion', 'Publish blog posts on our website and promote them on social media and other platforms.', 'Low', '2022-12-13 12:00:00', NULL, 'open', 20, 21, 13),
('Audience Engagement Monitoring', 'Monitor reader engagement and respond to comments and feedback on blog posts.', 'Medium', '2022-12-13 13:00:00', NULL, 'open', 19, 22, 13),
('Performance Analytics', 'Analyze blog post performance using analytics tools and make data-driven improvements.', 'Medium', '2022-12-13 14:00:00', NULL, 'open', 21, 19, 13),

-- Tasks for Project 14 (Customer Feedback Surveys)
('Survey Design and Questionnaire', 'Design the customer feedback survey and create a structured questionnaire.', 'Low', '2022-12-14 09:00:00', NULL, 'open', 16, 6, 14),
('Survey Distribution', 'Distribute the surveys to customers through email, website, and other channels.', 'High', '2022-12-14 10:00:00', NULL, 'open', 17, 16, 14),
('Data Collection and Analysis', 'Collect survey responses and analyze the data to extract valuable insights.', 'High', '2022-12-14 11:00:00', NULL, 'open', 6, 17, 14),
('Feedback Implementation', 'Implement changes and improvements based on the gathered customer feedback.', 'Medium', '2022-12-14 12:00:00', NULL, 'open', 19, 21, 14),
('Report Generation', 'Generate detailed reports summarizing the survey results and findings.', 'Low', '2022-12-14 13:00:00', NULL, 'open', 21, 19, 14),
('Continuous Feedback Loop', 'Establish a continuous feedback loop to regularly gather and act on customer feedback.', 'Medium', '2022-12-14 14:00:00', NULL, 'open', 6, 6, 14),

-- Tasks for Project 15 (Social Media Advertising)
('Ad Campaign Planning', 'Plan the content and strategy for social media advertising campaigns.', 'High', '2022-12-15 09:00:00', NULL, 'open', 15, 11, 15),
('Ad Creative Design', 'Create visually appealing ad creatives for use in social media campaigns.', 'Low', '2022-12-15 10:00:00', NULL, 'open', 11, 15, 15),
('Campaign Launch and Monitoring', 'Launch advertising campaigns on social media platforms and monitor their performance.', 'High', '2022-12-15 11:00:00', NULL, 'open', 22, 20, 15),
('Ad Campaign Optimization', 'Optimize ad campaigns based on real-time data and insights for better results.', 'Medium', '2022-12-15 12:00:00', NULL, 'open', 20, 22, 15),
('Audience Targeting', 'Refine audience targeting to reach the most relevant and engaged users.', 'Low', '2022-12-15 13:00:00', NULL, 'open', 23, 15, 15),
('Performance Reporting', 'Generate reports on ad campaign performance and provide insights for improvement.', 'Medium', '2022-12-15 14:00:00', NULL, 'open', 15, 23, 15),

-- Tasks for Project 16 (Database Optimization)
('Database Performance Analysis', 'Analyze the performance of our database systems and identify bottlenecks.', 'High', '2022-12-16 09:00:00', NULL, 'open', 13, 8, 16),
('Optimization Strategy Planning', 'Plan the database optimization strategy and prioritize areas for improvement.', 'Low', '2022-12-16 10:00:00', NULL, 'open', 17, 13, 16),
('Implementation of Optimization', 'Implement database optimization measures to improve data retrieval and storage.', 'High', '2022-12-16 11:00:00', NULL, 'open', 8, 17, 16),
('Testing and Validation', 'Thoroughly test the optimized database systems to ensure data integrity and performance.', 'Medium', '2022-12-16 12:00:00', NULL, 'open', 23, 19, 16),
('Documentation and Maintenance', 'Document the optimization process and establish ongoing maintenance procedures.', 'Low', '2022-12-16 13:00:00', NULL, 'open', 19, 23, 16),
('Performance Monitoring', 'Continuously monitor database performance and make adjustments as needed.', 'Medium', '2022-12-16 14:00:00', NULL, 'open', 13, 13, 16),

-- Tasks for Project 17 (Web Security Audit)
('Security Assessment Planning', 'Plan the comprehensive security assessment of our website and systems.', 'High', '2022-12-17 09:00:00', NULL, 'open', 9, 2, 17),
('Vulnerability Scanning', 'Perform vulnerability scanning to identify potential security weaknesses.', 'Low', '2022-12-17 10:00:00', NULL, 'open', 11, 9, 17),
('Penetration Testing', 'Conduct penetration testing to simulate real-world attacks and assess security defenses.', 'High', '2022-12-17 11:00:00', NULL, 'open', 2, 11, 17),
('Security Report Generation', 'Generate a detailed security report with findings and recommendations.', 'Low', '2022-12-17 12:00:00', NULL, 'open', 11, 12, 17),
('Security Remediation', 'Implement security improvements and remediation measures based on audit findings.', 'Medium', '2022-12-17 13:00:00', NULL, 'open', 13, 12, 17),
('Ongoing Security Monitoring', 'Establish continuous security monitoring to prevent future vulnerabilities.', 'Medium', '2022-12-17 14:00:00', NULL, 'open', 12, 13, 17),

-- Tasks for Project 18 (Art Gallery Exhibition)
('Artwork Selection and Curation', 'Select and curate artworks from local artists for the exhibition.', 'High', '2022-12-18 09:00:00', NULL, 'open', 5, 4, 18),
('Exhibition Planning and Setup', 'Plan the exhibition logistics and set up the gallery for the event.', 'Low', '2022-12-18 10:00:00', NULL, 'open', 4, 5, 18),
('Event Promotion and Marketing', 'Promote the art gallery exhibition through various marketing channels.', 'High', '2022-12-18 11:00:00', NULL, 'open', 10, 7, 18),
('Opening Night Event', 'Organize the opening night event with artists, guests, and art enthusiasts.', 'Low', '2022-12-18 12:00:00', NULL, 'open', 7, 10, 18),
('Exhibition Duration Management', 'Manage the exhibition throughout its duration and facilitate art sales.', 'Medium', '2022-12-18 13:00:00', NULL, 'open', 10, 10, 18),
('Exhibition Closure and Evaluation', 'Close the exhibition and evaluate its success and impact on the community.', 'Medium', '2022-12-18 14:00:00', NULL, 'open', 12, 12, 18),

-- Tasks for Project 19 (Music Festival Planning)
('Artist Selection and Booking', 'Select and book various artists and bands for the music festival lineup.', 'High', '2022-12-20 09:00:00', NULL, 'open', 16, 6, 19),
('Venue Reservation and Setup', 'Secure the festival venue and plan the setup for multiple stages and areas.', 'Low', '2022-12-20 10:00:00', NULL, 'open', 6, 16, 19),
('Ticketing and Promotion', 'Set up ticketing systems and promote the music festival through marketing campaigns.', 'High', '2022-12-20 11:00:00', NULL, 'open', 6, 19, 19),
('Logistics and Infrastructure', 'Handle logistics, infrastructure, and permits required for the festival.', 'Medium', '2022-12-20 12:00:00', NULL, 'open', 20, 20, 19),
('Event Management and Security', 'Manage event operations and ensure security measures for attendees.', 'Medium', '2022-12-20 13:00:00', NULL, 'open', 24, 20, 19),
('Concert Promotion and Merchandise', 'Promote individual artist performances and sell festival merchandise.', 'Low', '2022-12-20 14:00:00', NULL, 'open', 20, 24, 19),

-- Tasks for Project 20 (Data Analytics Workshop)
('Workshop Curriculum Design', 'Design the curriculum and content for the data analytics workshop.', 'High', '2022-12-21 09:00:00', NULL, 'open', 12, 10, 20),
('Trainer Selection and Booking', 'Select and book qualified trainers or instructors for the workshop.', 'Low', '2022-12-21 10:00:00', NULL, 'open', 10, 12, 20),
('Workshop Material Preparation', 'Prepare workshop materials, presentations, and handouts for participants.', 'High', '2022-12-21 11:00:00', NULL, 'open', 18, 14, 20),
('Participant Enrollment', 'Enroll employees and participants for the data analytics workshop.', 'Medium', '2022-12-21 12:00:00', NULL, 'open', 14, 18, 20),
('Workshop Execution', 'Conduct the data analytics workshop, providing hands-on training and education.', 'Low', '2022-12-21 13:00:00', NULL, 'open', 12, 23, 20),
('Workshop Evaluation and Feedback', 'Gather participant feedback and evaluate the effectiveness of the workshop.', 'Medium', '2022-12-21 14:00:00', NULL, 'open', 10, 14, 20),

-- Tasks for Project 21 (AI Chatbot Development)
('Chatbot Design and Architecture', 'Design the AI chatbots architecture and define its functionalities.', 'High', '2022-12-22 09:00:00', NULL, 'open', 8, 3, 21),
('Development and Integration', 'Develop and integrate the AI chatbot into our customer support systems.', 'Low', '2022-12-22 10:00:00', NULL, 'open', 3, 8, 21),
('Training and AI Model', 'Train the chatbots AI model using historical data and real interactions.', 'High', '2022-12-22 11:00:00', NULL, 'open', 12, 10, 21),
('Testing and User Experience', 'Thoroughly test the chatbot and ensure a seamless user experience.', 'Low', '2022-12-22 12:00:00', NULL, 'open', 13, 12, 21),
('Deployment and Monitoring', 'Deploy the AI chatbot and monitor its performance and interactions.', 'Medium', '2022-12-22 13:00:00', NULL, 'open', 10, 13, 21),
('User Training and Support', 'Provide training to support staff for effective use of the AI chatbot.', 'Medium', '2022-12-22 14:00:00', NULL, 'open', 3, 3, 21),

-- Tasks for Project 22 (Mobile App UI Redesign)
('UI/UX Analysis and Research', 'Analyze current UI/UX, conduct user research, and identify improvement areas.', 'High', '2022-12-23 09:00:00', NULL, 'open', 14, 7, 22),
('UI Design and Prototyping', 'Create new UI designs and prototypes for the mobile app with modern aesthetics.', 'High', '2022-12-23 10:00:00', NULL, 'open', 11, 11, 22),
('User Testing and Feedback', 'Test the redesigned UI with users and gather feedback for refinements.', 'Low', '2022-12-23 11:00:00', NULL, 'open', 7, 12, 22),
('UI Implementation and Development', 'Implement the new UI design into the mobile app development.', 'Medium', '2022-12-23 12:00:00', NULL, 'open', 12, 14, 22),
('Testing and Bug Fixes', 'Thoroughly test the redesigned app and fix any UI-related bugs or issues.', 'Low', '2022-12-23 13:00:00', NULL, 'open', 11, 15, 22),
('App Release and User Training', 'Release the updated mobile app and provide user training if needed.', 'Medium', '2022-12-23 14:00:00', NULL, 'open', 15, 11, 22),

-- Tasks for Project 23 (Digital Marketing Campaign)
('Campaign Strategy and Planning', 'Develop a comprehensive digital marketing strategy and campaign plan.', 'High', '2022-12-24 09:00:00', NULL, 'open', 16, 8, 23),
('Content Creation and Marketing Collateral', 'Create marketing content, ads, and collateral for the campaign.', 'High', '2022-12-24 10:00:00', NULL, 'open', 13, 13, 23),
('Campaign Execution', 'Execute the digital marketing campaign across various channels and platforms.', 'High', '2022-12-24 11:00:00', NULL, 'open', 8, 16, 23),
('Monitoring and Optimization', 'Continuously monitor campaign performance and optimize for better results.', 'Low', '2022-12-24 12:00:00', NULL, 'open', 19, 18, 23),
('Audience Engagement and Interaction', 'Engage with the audience, respond to inquiries, and manage interactions.', 'Medium', '2022-12-24 13:00:00', NULL, 'open', 8, 19, 23),
('Campaign Reporting and Analysis', 'Generate detailed reports and analyze campaign data for insights.', 'Low', '2022-12-24 14:00:00', NULL, 'open', 19, 8, 23),

-- Tasks for Project 24 (Data Visualization Dashboard)
('Requirements Gathering', 'Gather requirements and expectations for the data visualization dashboard.', 'High', '2022-11-12 09:00:00', NULL, 'open', 4, 4, 24),
('Data Source Integration', 'Integrate data sources to feed into the data visualization dashboard.', 'High', '2022-11-12 10:00:00', NULL, 'open', 5, 4, 24),
('Dashboard Design and Layout', 'Design the layout and visual elements of the data visualization dashboard.', 'High', '2022-11-12 11:00:00', NULL, 'open', 6, 5, 24),
('Data Visualization Development', 'Develop interactive data visualizations using suitable tools and technologies.', 'Low', '2022-11-12 12:00:00', NULL, 'open', 7, 6, 24),
('User Testing and Feedback', 'Conduct user testing and gather feedback for dashboard usability and improvements.', 'Medium', '2022-11-12 13:00:00', NULL, 'open', 8, 7, 24),
('Dashboard Deployment', 'Deploy the data visualization dashboard for real-time insights and access.', 'Medium', '2022-11-12 14:00:00', NULL, 'open', 5, 8, 24),

-- Tasks for Project 25 (Cloud Migration Strategy)
('Infrastructure Assessment', 'Assess current IT infrastructure to identify components for cloud migration.', 'High', '2022-12-26 09:00:00', NULL, 'open', 15, 6, 25),
('Cloud Provider Selection', 'Select a cloud provider and plan for resources and services to be utilized.', 'Low', '2022-12-26 10:00:00', NULL, 'open', 6, 15, 25),
('Migration Planning and Strategy', 'Develop a detailed migration plan and strategy, including timelines and budgets.', 'Low', '2022-12-26 11:00:00', NULL, 'open', 18, 16, 25),
('Data Migration and Testing', 'Migrate data to the cloud and test applications and services in the new environment.', 'Medium', '2022-12-26 12:00:00', NULL, 'open', 17, 17, 25),
('Security and Compliance', 'Ensure security and compliance measures are in place for the cloud environment.', 'Medium', '2022-12-26 13:00:00', NULL, 'open', 15, 18, 25),
('Deployment and Transition', 'Deploy applications and services to the cloud and transition operations.', 'Medium', '2022-12-26 14:00:00', NULL, 'open', 16, 15, 25),

-- Tasks for Project 26 (Scrum Master Training)
('Training Program Development', 'Develop a comprehensive Scrum Master training program and curriculum.', 'High', '2022-12-27 09:00:00', NULL, 'open', 13, 12, 26),
('Trainer Selection and Booking', 'Select and book experienced Scrum trainers or instructors for the training.', 'High', '2022-12-27 10:00:00', NULL, 'open', 15, 13, 26),
('Training Material Preparation', 'Prepare training materials, presentations, and resources for participants.', 'Low', '2022-12-27 11:00:00', NULL, 'open', 12, 15, 26),
('Participant Enrollment', 'Enroll team members and participants for the Scrum Master training program.', 'Medium', '2022-12-27 12:00:00', NULL, 'open', 13, 17, 26),
('Training Delivery and Workshops', 'Deliver training sessions and workshops on Scrum methodologies and practices.', 'Medium', '2022-12-27 13:00:00', NULL, 'open', 18, 13, 26),
('Assessment and Certification', 'Assess participants knowledge and provide Scrum Master certification upon completion.', 'Low', '2022-12-27 14:00:00', NULL, 'open', 17, 18, 26),

-- Tasks for Project 27 (Content Writing Workshop)
('Workshop Planning and Curriculum', 'Plan the content writing workshop and develop the curriculum.', 'High', '2023-11-10 09:00:00', NULL, 'open', 9, 4, 27),
('Trainer Selection and Booking', 'Select and book experienced trainers for the content writing workshop.', 'High', '2023-11-10 10:00:00', NULL, 'open', 10, 9, 27),
('Workshop Material Preparation', 'Prepare workshop materials, presentations, and handouts for participants.', 'High', '2023-11-10 11:00:00', NULL, 'open', 4, 10, 27),
('Participant Enrollment', 'Enroll participants and communicate logistics for the workshop.', 'Medium', '2023-11-10 12:00:00', NULL, 'open', 11, 11, 27),
('Workshop Delivery and Exercises', 'Conduct the content writing workshop, including practical writing exercises.', 'Low', '2023-11-10 13:00:00', NULL, 'open', 12, 12, 27),
('Feedback Collection and Improvement', 'Collect feedback from participants and make improvements for future workshops.', 'Medium', '2023-11-10 14:00:00', NULL, 'open', 12, 11, 27),

-- Tasks for Project 28 (Database Optimization Project)
('Database Performance Analysis', 'Analyze the current database performance and identify bottlenecks.', 'High', '2023-11-15 09:00:00', NULL, 'open', 13, 10, 28),
('Optimization Strategy Development', 'Develop a strategy for optimizing database performance and scalability.', 'High', '2023-11-15 10:00:00', NULL, 'open', 18, 13, 28),
('Implementation of Database Changes', 'Implement necessary changes to optimize the database performance.', 'Low', '2023-11-15 11:00:00', NULL, 'open', 17, 16, 28),
('Testing and Benchmarking', 'Thoroughly test the optimized database and benchmark its performance.', 'Medium', '2023-11-15 12:00:00', NULL, 'open', 18, 10, 28),
('Documentation and Reporting', 'Document the changes made and provide a performance report.', 'Low', '2023-11-15 13:00:00', NULL, 'open', 17, 18, 28),
('Ongoing Monitoring and Maintenance', 'Establish procedures for ongoing monitoring and maintenance of the database.', 'Medium', '2023-11-15 14:00:00', NULL, 'open', 16, 17, 28),

-- Tasks for Project 29 (Product Launch Event)
('Event Planning and Concept', 'Plan the concept and theme of the product launch event.', 'High', '2023-01-05 09:00:00', NULL, 'open', 5, 2, 29),
('Venue Selection and Booking', 'Select and book a suitable venue for the product launch event.', 'High', '2023-01-05 10:00:00', NULL, 'open', 8, 5, 29),
('Invitations and Guest List', 'Prepare invitations and create a guest list for the event.', 'High', '2023-01-05 11:00:00', NULL, 'open', 14, 8, 29),
('Event Promotion and Marketing', 'Promote the product launch event through marketing campaigns and channels.', 'Low', '2023-01-05 12:00:00', NULL, 'open', 2, 14, 29),
('Logistics and Setup', 'Handle event logistics, setup, and decorations for a successful launch.', 'Medium', '2023-01-05 13:00:00', NULL, 'open', 14, 15, 29),
('Event Execution and Presentation', 'Execute the product launch event, including product presentation.', 'Low', '2023-01-05 14:00:00', NULL, 'open', 15, 2, 29),

-- Tasks for Project 30 (Market Research for Expansion)
('Market Research Planning', 'Plan the market research approach, objectives, and methodologies.', 'High', '2023-02-20 09:00:00', NULL, 'open', 14, 8, 30),
('Data Collection and Analysis', 'Collect market data and analyze it to identify expansion opportunities.', 'High', '2023-02-20 10:00:00', NULL, 'open', 8, 14, 30),
('Market Trends and Competitor Analysis', 'Analyze market trends and study competitors in potential expansion markets.', 'High', '2023-02-20 11:00:00', NULL, 'open', 18, 16, 30),
('Report Preparation and Recommendations', 'Prepare a detailed market research report with expansion recommendations.', 'Medium', '2023-02-20 12:00:00', NULL, 'open', 16, 18, 30),
('Presentation to Stakeholders', 'Present the research findings and recommendations to key stakeholders.', 'Low', '2023-02-20 13:00:00', NULL, 'open', 19, 19, 30),
('Decision and Planning', 'Make decisions and plan strategies for expansion based on the research.', 'Medium', '2023-02-20 14:00:00', NULL, 'open', 14, 16, 30),

-- Tasks for Project 31 (Supply Chain Optimization)
('Supply Chain Assessment', 'Assess the current supply chain processes, including inventory and logistics.', 'High', '2023-03-25 09:00:00', NULL, 'open', 12, 7, 31),
('Optimization Strategy Development', 'Develop a strategy for optimizing supply chain processes for cost reduction.', 'High', '2023-03-25 10:00:00', NULL, 'open', 12, 12, 31),
('Implementation of Process Changes', 'Implement necessary changes to optimize the supply chain processes.', 'High', '2023-03-25 11:00:00', NULL, 'open', 7, 15, 31),
('Testing and Performance Evaluation', 'Thoroughly test the optimized supply chain processes and evaluate their performance.', 'Low', '2023-03-25 12:00:00', NULL, 'open', 15, 17, 31),
('Documentation and Reporting', 'Document the changes made and provide a performance report for stakeholders.', 'Medium', '2023-03-25 13:00:00', NULL, 'open', 17, 19, 31),
('Ongoing Monitoring and Improvements', 'Establish procedures for ongoing monitoring and improvements in the supply chain.', 'Medium', '2023-03-25 14:00:00', NULL, 'open', 19, 15, 31),

-- Tasks for Project 32 (Employee Training Program)
('Training Needs Assessment', 'Assess the training needs of employees across various departments.', 'High', '2023-04-10 09:00:00', NULL, 'open', 3, 2, 32),
('Curriculum Development', 'Develop a comprehensive training curriculum based on identified needs.', 'High', '2023-04-10 10:00:00', NULL, 'open', 2, 3, 32),
('Trainer Selection and Booking', 'Select qualified trainers or instructors for each training module.', 'High', '2023-04-10 11:00:00', NULL, 'open', 9, 6, 32),
('Training Material Preparation', 'Prepare training materials, presentations, and resources for each module.', 'Low', '2023-04-10 12:00:00', NULL, 'open', 3, 9, 32),
('Participant Enrollment and Scheduling', 'Enroll employees in appropriate training modules and schedule sessions.', 'Medium', '2023-04-10 13:00:00', NULL, 'open', 9, 11, 32),
('Training Delivery and Evaluation', 'Deliver training sessions and evaluate participant performance.', 'Medium', '2023-04-10 14:00:00', NULL, 'open', 11, 6, 32),

-- Tasks for Project 33 (New Website Features Development)
('Feature Specification and Requirements', 'Specify and gather requirements for the new website features.', 'High', '2023-05-15 09:00:00', NULL, 'open', 19, 18, 33),
('Design and Prototyping', 'Design the new features and create prototypes for development.', 'High', '2023-05-15 10:00:00', NULL, 'open', 20, 19, 33),
('Development and Coding', 'Develop and code the new website features according to specifications.', 'High', '2023-05-15 11:00:00', NULL, 'open', 21, 20, 33),
('Testing and Quality Assurance', 'Thoroughly test the new features for functionality and quality.', 'Low', '2023-05-15 12:00:00', NULL, 'open', 21, 21, 33),
('Integration and Deployment', 'Integrate the new features into the website and deploy them.', 'Medium', '2023-05-15 13:00:00', NULL, 'open', 21, 22, 33),
('User Training and Documentation', 'Provide training to website users and create user documentation.', 'Medium', '2023-05-15 14:00:00', NULL, 'open', 21, 21, 33),

-- Tasks for Project 34 (Content Localization Project)
('Market Research for Localization', 'Conduct market research to identify localization needs and target markets.', 'High', '2023-06-16 09:00:00', NULL, 'open', 16, 6, 34),
('Translation and Localization', 'Translate and adapt content for international markets and audiences.', 'High', '2023-06-16 10:00:00', NULL, 'open', 6, 16, 34),
('Cultural Sensitivity Assessment', 'Assess content for cultural sensitivity and make necessary adjustments.', 'High', '2023-06-16 11:00:00', NULL, 'open', 17, 16, 34),
('Testing and Validation', 'Test localized content with target audiences and validate its effectiveness.', 'Low', '2023-06-16 12:00:00', NULL, 'open', 19, 17, 34),
('Content Rollout and Promotion', 'Roll out localized content and promote it to international markets.', 'Medium', '2023-06-16 13:00:00', NULL, 'open', 21, 19, 34),
('Feedback Collection and Improvements', 'Collect feedback on localized content and make necessary improvements.', 'Medium', '2023-06-16 14:00:00', NULL, 'open', 17, 21, 34),

-- Tasks for Project 35 (Quality Assurance and Testing)
('Test Planning and Strategy', 'Develop a comprehensive test plan and testing strategy for software products.', 'Low', '2023-07-21 09:00:00', NULL, 'open', 11, 11, 35),
('Test Case Design', 'Design test cases and scenarios to cover all aspects of software functionality.', 'High', '2023-07-21 10:00:00', NULL, 'open', 22, 15, 35),
('Testing Execution', 'Execute test cases and perform testing on various software modules and features.', 'High', '2023-07-21 11:00:00', NULL, 'open', 22, 20, 35),
('Defect Identification and Reporting', 'Identify defects and issues and report them for resolution.', 'Medium', '2023-07-21 12:00:00', NULL, 'open', 20, 22, 35),
('Regression Testing', 'Conduct regression testing to ensure that new changes do not affect existing functionality.', 'Medium', '2023-07-21 13:00:00', NULL, 'open', 15, 23, 35),
('User Acceptance Testing (UAT)', 'Coordinate UAT with stakeholders to gain their approval and feedback.', 'Medium', '2023-07-21 14:00:00', NULL, 'open', 23, 22, 35),

-- Tasks for Project 36 (Green Initiative Campaign)
('Campaign Strategy and Planning', 'Develop a comprehensive strategy and plan for the green initiative campaign.', 'Low', '2023-08-06 09:00:00', NULL, 'open', 13, 8, 36),
('Content Creation and Messaging', 'Create campaign content and messaging to promote sustainability and eco-friendliness.', 'High', '2023-08-06 10:00:00', NULL, 'open', 13, 13, 36),
('Campaign Launch and Promotion', 'Launch the green initiative campaign and promote it through various channels.', 'High', '2023-08-06 11:00:00', NULL, 'open', 19, 17, 36),
('Monitoring and Reporting', 'Monitor campaign progress and generate reports on its impact and engagement.', 'Medium', '2023-08-06 12:00:00', NULL, 'open', 17, 19, 36),
('Sustainability Partnerships', 'Establish partnerships with organizations that support environmental sustainability.', 'Medium', '2023-08-06 13:00:00', NULL, 'open', 23, 23, 36),
('Feedback Collection and Improvements', 'Collect feedback from stakeholders and make improvements to the campaign.', 'Low', '2023-08-06 14:00:00', NULL, 'open', 23, 19, 36),

-- Tasks for Project 37 (Customer Loyalty Program)
('Program Strategy and Design', 'Develop the strategy and design for the customer loyalty program.', 'High', '2023-09-11 09:00:00', NULL, 'open', 9, 2, 37),
('Rewards and Incentives Planning', 'Plan rewards and incentives to offer loyal customers as part of the program.', 'High', '2023-09-11 10:00:00', NULL, 'open', 2, 9, 37),
('Program Launch and Promotion', 'Launch the customer loyalty program and promote it to existing customers.', 'High', '2023-09-11 11:00:00', NULL, 'open', 12, 11, 37),
('Membership Enrollment and Management', 'Enroll customers in the program and manage their membership status.', 'Low', '2023-09-11 12:00:00', NULL, 'open', 11, 12, 37),
('Customer Engagement and Communication', 'Engage with program members and communicate offers and benefits.', 'Medium', '2023-09-11 13:00:00', NULL, 'open', 13, 13, 37),
('Performance Evaluation and Adjustments', 'Evaluate the programs performance and make adjustments as needed for better results.', 'Low', '2023-09-11 14:00:00', NULL, 'open', 9, 12, 37),

-- Tasks for Project 38 (Sales and Marketing Alignment)
('Alignment Strategy Development', 'Develop a strategy for aligning sales and marketing teams for improved lead generation and conversion.', 'High', '2023-10-16 09:00:00', NULL, 'open', 5, 4, 38),
('Team Training and Workshops', 'Conduct training sessions and workshops to educate both teams on alignment principles.', 'High', '2023-10-16 10:00:00', NULL, 'open', 7, 5, 38),
('Collaborative Campaign Planning', 'Plan collaborative marketing and sales campaigns to target leads and prospects.', 'Low', '2023-10-16 11:00:00', NULL, 'open', 10, 7, 38),
('Performance Metrics and KPIs', 'Define performance metrics and KPIs to track alignment effectiveness.', 'Medium', '2023-10-16 12:00:00', NULL, 'open', 12, 10, 38),
('Communication and Feedback Channels', 'Establish effective communication and feedback channels between teams.', 'Medium', '2023-10-16 13:00:00', NULL, 'open', 7, 10, 38),
('Continuous Alignment Improvement', 'Continuously monitor and improve alignment strategies and practices.', 'Low', '2023-10-16 14:00:00', NULL, 'open', 4, 12, 38),

-- Tasks for Project 39 (AI-powered Chat Support)
('Chatbot Development and Training', 'Develop and train the AI-powered chatbot for customer support.', 'High', '2023-11-21 09:00:00', NULL, 'open', 6, 6, 39),
('Integration with Customer Support Systems', 'Integrate the chatbot with existing customer support systems.', 'Low', '2023-11-21 10:00:00', NULL, 'open', 16, 19, 39),
('User Testing and Feedback', 'Test the chatbot with users and gather feedback for improvements.', 'High', '2023-11-21 11:00:00', NULL, 'open', 19, 16, 39),
('Launch and Deployment', 'Launch the AI-powered chatbot for customer service on relevant platforms.', 'Medium', '2023-11-21 12:00:00', NULL, 'open', 24, 20, 39),
('Performance Monitoring and Enhancements', 'Monitor chatbot performance and make enhancements for better service.', 'Low', '2023-11-21 13:00:00', NULL, 'open', 20, 24, 39),
('Customer Support Team Collaboration', 'Collaborate with the customer support team for seamless chatbot integration.', 'Medium', '2023-11-21 14:00:00', NULL, 'open', 24, 24, 39),

-- Tasks for Project 40 (Mobile App Performance Optimization)
('App Performance Analysis', 'Analyze the current mobile app performance and identify areas for optimization.', 'High', '2023-11-02 09:00:00', NULL, 'open', 12, 10, 40),
('Optimization Strategy Development', 'Develop a strategy for optimizing the mobile apps performance and responsiveness.', 'Low', '2023-11-02 10:00:00', NULL, 'open', 14, 12, 40),
('Implementation of Performance Enhancements', 'Implement enhancements to improve app performance and reduce response times.', 'High', '2023-11-02 11:00:00', NULL, 'open', 10, 14, 40),
('Testing and Validation', 'Thoroughly test the apps performance enhancements to ensure effectiveness.', 'Low', '2023-11-02 12:00:00', NULL, 'open', 18, 18, 40),
('User Feedback and Testing', 'Gather user feedback and conduct testing to validate the improvements.', 'Medium', '2023-11-02 13:00:00', NULL, 'open', 22, 18, 40),
('Deployment of Optimized Version', 'Deploy the optimized version of the mobile app for users to access.', 'Medium', '2023-11-02 14:00:00', NULL, 'open', 10, 22, 40),

-- Tasks for Project 41 (Digital Advertising Campaign)
('Campaign Strategy and Planning', 'Develop a comprehensive strategy and plan for the digital advertising campaign.', 'Low', '2023-01-06 09:00:00', NULL, 'open', 9, 3, 41),
('Ad Creative Development', 'Create compelling ad creatives and visuals for use in digital advertising.', 'High', '2023-01-06 10:00:00', NULL, 'open', 3, 9, 41),
('Media Buying and Placement', 'Plan media buying and ad placement across relevant online platforms.', 'High', '2023-01-06 11:00:00', NULL, 'open', 15, 9, 41),
('Campaign Launch and Monitoring', 'Launch the digital advertising campaign and continuously monitor its performance.', 'Medium', '2023-01-06 12:00:00', NULL, 'open', 9, 15, 41),
('Audience Targeting and Segmentation', 'Define target audiences and segment them for more effective ad delivery.', 'Medium', '2023-01-06 13:00:00', NULL, 'open', 12, 15, 41),
('Budget Management and Optimization', 'Manage campaign budgets and optimize spending for maximum ROI.', 'Low', '2023-01-06 14:00:00', NULL, 'open', 15, 12, 41),

-- Tasks for Project 42 (Big Data Analytics Project)
('Data Source Identification', 'Identify and gather data sources for the big data analytics project.', 'High', '2023-02-10 09:00:00', NULL, 'open', 2, 7, 42),
('Data Processing and Integration', 'Process and integrate data from multiple sources for analysis.', 'High', '2023-02-10 10:00:00', NULL, 'open', 7, 2, 42),
('Analytics Model Development', 'Develop analytics models and algorithms to extract insights.', 'High', '2023-02-10 11:00:00', NULL, 'open', 17, 5, 42),
('Data Visualization and Reporting', 'Create data visualizations and reports to communicate insights.', 'Low', '2023-02-10 12:00:00', NULL, 'open', 5, 17, 42),
('Insights Review and Action Planning', 'Review insights and develop action plans based on findings.', 'Medium', '2023-02-10 13:00:00', NULL, 'open', 22, 22, 42),

-- Tasks for Project 43 (IT Security Enhancement)
('Security Assessment and Vulnerability Scanning', 'Assess current security measures and perform vulnerability scanning.', 'High', '2023-03-15 09:00:00', NULL, 'open', 11, 2, 43),
('Security Policy and Procedure Review', 'Review and update security policies and procedures for compliance.', 'Low', '2023-03-15 10:00:00', NULL, 'open', 2, 11, 43),
('Implementation of Security Measures', 'Implement recommended security measures and enhancements.', 'High', '2023-03-15 11:00:00', NULL, 'open', 18, 13, 43),
('Employee Security Training', 'Conduct security awareness training for employees to enhance cybersecurity.', 'Medium', '2023-03-15 12:00:00', NULL, 'open', 14, 18, 43),
('Security Incident Response Planning', 'Develop an incident response plan for handling security incidents.', 'Medium', '2023-03-15 13:00:00', NULL, 'open', 13, 14, 43);


INSERT INTO comment (content, create_date, edited, comment_by, task_comment) VALUES
('Great progress on this task!', '2022-10-17 08:30:00', FALSE, 8, 1),
('The new design looks fantastic!', '2022-10-17 14:15:00', FALSE, 11, 15),
('I need some more information to proceed.', '2022-10-17 16:30:00', FALSE, 5, 28),
('I am making good progress on this task.', '2022-10-18 12:45:00', FALSE, 6, 33), 
('Looking forward to seeing the content!', '2022-10-19 09:30:00', TRUE, 14, 39),
('Tool implementation is on track.', '2022-10-19 13:55:00', FALSE, 15, 41), 
('Keep up the good work!', '2022-10-20 14:25:00', FALSE, 10, 46),
('Let me know if you need assistance.', '2022-10-21 15:30:00', FALSE, 18, 51),
('Let me know if you need assistance.', '2022-10-21 15:30:00', FALSE, 18, 32),
('Let me know if you need assistance.', '2022-10-21 15:30:00', FALSE, 18, 32),
('Let me know if you need assistance.', '2022-10-21 15:30:00', FALSE, 18, 32),
('Let me know if you need assistance.', '2022-10-21 15:30:00', FALSE, 18, 32);


INSERT INTO invite (title, description, create_date, invited_by, invited_to, project_invite) VALUES
('Web Development Collaboration', 'Join us in an exciting web development project to create innovative solutions.', '2022-10-21', 2, 5, 1),
('Marketing Campaign Team', 'Collaborate on a strategic marketing campaign to boost brand visibility and growth.', '2022-10-22', 9, 11, 5),
('Data Analysis Team Invitation', 'Join our team of data analysts to uncover valuable insights and drive informed decisions.', '2022-10-23', 13, 6, 7),
('Sales Optimization Initiative', 'Participate in an initiative to optimize our sales processes and increase revenue.', '2022-10-24', 2, 8, 11),
('E-commerce Platform Development', 'Get involved in the creation of an e-commerce platform for our online store.', '2022-10-25', 7, 10, 15),
('Content Marketing Collaboration', 'Collaborate on a content marketing strategy to enhance brand visibility and user engagement.', '2022-10-26', 16, 11, 18);


INSERT INTO message (content, create_date, edited, message_by, project_message) VALUES 
('Welcome to our project! We are excited to have you on board.', '2022-10-25', FALSE, 13, 3),
('Lets collaborate and make this project a success!', '2022-10-26', TRUE, 10, 8),
('Important update: We will have a team meeting tomorrow at 2 PM.', '2022-10-27', FALSE, 15, 5),
('Great job on completing your tasks ahead of schedule!', '2022-10-28', FALSE, 16, 14),
('Reminder: The project deadline is approaching. Keep up the good work!', '2022-10-29', FALSE, 2, 17);


-----------------------------------------
-- end
-----------------------------------------