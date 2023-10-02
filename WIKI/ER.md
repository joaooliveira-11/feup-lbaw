# ER: Requirements Specification Component

## A1: TeamSync

In today's rapidly evolving work landscape, where remote work is growing very fast, teamwork and communication have become key factors to address workplace challenges and changes. This shift has created an increasing demand for effective project management tools. TeamSync was founded in response to this contemporary issue.

TeamSync is a web application built to simplify and enhance project management. It empowers teams to collaborate with ease, maintain flawless organization and communicate effortlessly, all of which leads to greater work efficiency.

In this application, users can easily create tasks, engage in discussions with colleagues and track the progress within a project.

In TeamSync, users are organized into different groups, each with its own set of permissions and roles. These groups include visitors, workers, coordinators and administrators.

Visitors, also known as unauthenticated users, are users who access the system without logging into an account. They have limited access to website features, although they can view generic pages such as 'About Us' and 'FAQs', where information about the system is displayed. Nevertheless, they can choose to create an account or login to unlock additional features.

Any authenticated user has the ability to search for public projects and, if they find a project of interest, submit an application. Once their application is accepted or they receive an invitation to join, the user becomes a worker on that project. Workers are the base of the system. They can access nearly all system features, participate in tasks, communicate with others in chat rooms and submit work within a project, and edit their profile whenever they want.

On the other hand, when a user creates a new project, he becomes the coordinator. They have a set of additional responsibilities and features that distinguish them from regular workers. Project coordinators gain enhanced control and management capabilities over workers and tasks. They can efficiently approve task completion, archive or modify task details and statuses, and oversee project details, while also managing team members and delivering tasks as part of the workflow.

Administrators hold the highest level of access and power within the system. They can search and consult every project, whether public or private, controll overall system security and manage user's behavior by taking actions such as banning them when necessary.

TeamSync's interface ensures a user-friendly,intuitive and responsive design, delivering an enjoyable experience whether accessed on a PC or a mobile device. With natural and intuitive navigation, users can expect a pleasant overall experience.

---


## A2: Actors and User Stories

The upcoming sections offer comprehensive insights into our project, including detailed descriptions of actors, user stories, and supplementary requirements such as business rules and technical requirements.


### 1. Actors

![UsersUML](https://hackmd.io/_uploads/H1eg8MPgp.png)

*Figure 1: Actors UML*

---

| Identifier | Description |
| --- | --- |
| User | Generic user that has access to general information. |
| Visitor | Unauthenticated user that has access generic pages such as 'About Us' and 'FAQs' and can log-in or sign up. |
| Authenticated User | User that can edit his personal data, search, create and join projects. |
| Worker | Authenticated user that is enrolled on one or many projects, is able to create and participate in tasks, talk with others and submit work. |
| Coordinator | Authenticated user that is the creator, supervisor and also a worker of a project. In addiction, can edit the project details, assign tasks to members, manage team members and archive it upon successful completion of all tasks and work. |
|Administrator | Authenticated user who is responsible for managing users' behaviour and supervising all projects. |
| OAuth API | Gmail API, used to register and authenticate users in the system. |

*Table 1: TeamSync actor's Description*


### 2. User Stories

#### 2.1. **User**

| Identifier | Name | Priority | Description |
| --- | --- | --- | --- |
| US01 | View Main Page | High | As a User, I want to access the home page, so that I can explore the website before deciding to sign up.|
| US02 | Accept Email Invitation | High | As a User, I want to receive an invitation by email, so that I can create my account more securely. |
| US03 | View About Us Page | Medium | As a User, i want to view the about page, so that I can learn about the creators of the website. |
| US04 | Consult FAQs | Medium | As a User, I want to consult the FAQs section, so that I can find answers to my doubts.|

*Table 2: User's User Stories*


#### 2.2. **Visitor**

| Identifier | Name | Priority | Description |
| --- | --- | --- | --- |
| US05 | Sign In | High | As a Visitor, I want to authenticate myself into the system, so that I can access privileged content and participate in projects. |
| US06 | Sign Up | High | As a Visitor, I want to register myself into the system, so that I can authenticate into the system. |
| US07 | Recover Password | Medium | As a Visitor, I want to recover my password so that I don't lose access to my account. |
| US08 | Sign In using OAuth API | Low | As a Visitor, I want to authenticate through my Google account, so that I can authenticate myself into the system without needing to input the full log in credentials. |
| US09 | Sign Up using OAuth API | Low | As a Visitor, I want to register a new account linked to my Google account, so that I do not need to create a whole new account to use the platform. |

*Table 3: Visitor's User Stories*


#### 2.3. **Authenticated User**

| Identifier | Name | Priority | Description |
| --- | --- | --- | --- |
| US10 | Create Project | High | As an Authenticated User, I want to create a new project, so that I can develop my idea with other workers. |
| US11 | View my Projects | High | As an Authenticated User, I want to see my current projects, so that I can easily access them and organize my work. |
| US12 | Mark Project as Favourite | High | As an Authenticated User, I want to mark projects as favourites, so that I can keep an eye on my favourite projects, and possibly join them. |
| US13 | View My Notifications | High | As an Authenticated User, I want to see my notifications, so that I can stay updated, not miss any important updates, and efficiently manage my project-related activities. |
| US14 | Edit Profile | High | As an Authenticated User, I want to edit my profile picture and description, so that my profile can be kept up to date. |
| US15 | View Profile | High | As an Authenticated User, I want to view my profile, so that I can review and manage my personal information.|
| US16 | Log Out | High | As an Authenticated User, I want to log out of my account, so that I can safely exit the platform. |
| US17 | Manage Project Invitation | Medium | As an Authenticated User, I want to accept or deny a project invitation, so that I can decide which projects to be part of. |
| US18 | Join Project | Low | As an Authenticated User, i want to join a project, either by being invited by a coordinator, or by application, so that i can put my skills to work and gain experience. |
| US19 | Search Projects | Low | As a User, I want to search for projects, so that I can quickly find the projects I am most interested in. |
| US20 | Delete Account | Low| As an Authenticated User, I want to delete my account, so that i remove my personal information from the system.|

*Table 4: Authenticated User Stories*


#### 2.4. **Worker**

| Identifier | Name | Priority | Description |
| --- | --- | --- | --- |
| US21 | Create Task | High | As a Worker, I want to create tasks to facilitate team coordination and task assignment. |
| US22 | Manage Tasks | High| As a Worker, I want to manage tasks, so that I can set their priority, labels and timeline. |
| US23 | View Task Details | High | As a Worker, I want to see the task details, so that I can better understand its objectives and method of work. |
| US24 | Comment on Task | High | As a Worker, I want to comment on tasks, so that I can provide feedback. |
| US25 | Complete Assigned Tasks | High | As a Worker, I want to mark my task as finished, so that I can move on to another task and keep the project organized. |
| US26 | Leave Project | High | As a Worker, I want to leave a project, so that I can participate only in projects where I feel comfortable in. |
| US27 | View Project Members | High | As a Worker, I want to see a project's team, so that I can see what members I will be working with. |
| US28 | View Project Members' Profile | High | As a Worker, I want to see the project members' profile, so that I can learn more about my coleagues. |
| US29 | Search Tasks | High | As a Worker, I want to search for tasks within a project, so that I can easily find tasks that are either completed or pending in order to decide the ones im most interested in. |
| US30 | Assigned Task Notification | High | As a Worker, I want to receive notifications when tasks are assigned to me, so that I can start working on my assigned tasks. |
| US31 | Completed Task Notification | High | As a Worker, I want to receive notifications when my assigned tasks are archived by the project's coordinator so that i can start working on another task. |
| US32 | Change in Project Coordinator Notification | High | As a Worker, I want to receive notifications when there's a change in the project coordinator for projects I'm a part of, so that I'm aware of any shifts in project leadership.|
| US33 | Accepted Invitation Notification | High | As a Worker, I want to receive notifications when a new worker joins a project I'm enrolled in, so that I can have a better understanding of my project team and collaborate effectively. |
| US34 | Browse Project Message Forum | Medium | As a Worker, I want to browse through a project's message forum, so that I can see what the members have been talking about. |
| US35 | Communicate With Others | Medium | As a Worker, I want to communicate with others through diverse chat rooms, so that I can inform and be informed by others about the current and future states of the project. |
| US36 | View Project Timeline | Low | As a Worker, I want to see a project's timeline, so that I know when the project needs are to be completed. |
| US37 | Edit Post | Low | As a Worker, I want to edit my posts in the project's message forum, so that I can correct errors or provide updated information when needed. |
| US38 | Delete Post | Low | As a Worker, I want to delete my posts in the project's message forum, so that I can remove irrelevant information as necessary. |


*Table 5: Worker User Stories*


#### 2.5. **Coordinator**

| Identifier | Name | Priority | Description |
| --- | --- | --- | --- | 
| US39 | Invite Users | High | As a Coordinator, i want to invite users to my projects, so that i can create a team to work on them. |
| US40 | Assign New Coordinator | High | As a Coordinator, I want to promote another worker to coordinator, so that I can transfer my leadership to someone else. |
| US41 | Edit Project Details | High | As a Coordinator, I want to edit the project details, so that I can keep the details up to date, for example a change in the delivery timeline. |
| US42 | Assign Tasks to Members | High | As a Coordinator, I want to assign different tasks to the members of the project, so that the project is well organized. |
| US43 | Remove Project Member | High | As a Coordinator, I want to remove a member of the project, so that I can maintain the project environment professional. |
| US44 | Archive Project | High | As a Coordinator, I want to archive a project, so that I can move on to new projects. |
| US45 | Archive Tasks | Medium | As a Coordinator, I want to archive tasks after team members mark them as completed, ensuring that all tasks are reviewed before closing them.|
| US46 | Invite Users via Email | Low | As a Coordinator, I want to invite members via email, so that members can see their invitations without needing to log in to the platform. |

*Table 6: Coordinator User Stories*


#### 2.6. **Administrator**

| Identifier | Name | Priority | Description |
| --- | --- | --- | --- | 
| US47 | Browse Projects | High | As an Admin, I want to view and search all the projects on the platform, so that I can keep track of how many projects have been completed and how many are still active. |
| US48 | View Project Details | High | As an Admin, I want to acess all the details of every project, so that I can stay informed about the project's progress and specifics.|
| US49 | View Users | Medium | As an Admin, I want to view all the users registered on the platform, so that I can keep track of the growth of the platform. |
| US50 | Ban Users | Medium | As an Admin, I want to ban users that are being unprofessional, so that the platform can be kept civilized. |
| US51 | Add FAQ | Medium | As an Admin, I want to add a FAQ, so that i can provide helpful information to users. |

*Table 7: Administrator User Stories*



### 3. Supplementary Requirements


#### 3.1. Business rules

| Identifier | Name | Description |
| --- | --- | --- |
| BR01 | Unique Email | Each email can only be used in one account. If a user tries to create an account with an already existing email, an error should be displayed. |
| BR02 | Unique Username | Each username can only be used in one account. If a user tries to create an account with an already existing username, an error should be displayed. |
| BR03 | Administrator Independency | Administrator accounts are independent of the user accounts, i.e. they cannot create or participate in projects. |
| BR04 | Project's Visibility | The creator of the project can choose whether it is public or private. Authenticated users can search for public projects and ask to join. |
| BR05 | Deletion of an account | When a user chooses to delete their account, their data, including messages and work, will be kept in the system and their username will be replaced with "Deleted user". Administrators are not authorized to delete their accounts and coordinators must delegate this task to another user before deleting. |
| BR06 | Deadline Validation | The estimated deadline for completing a project/task must be set to a date later than the date of its creation. |
| BR07 | Self-Review Restriction | Users are not allowed comment or review their assigned tasks to maintain objectivity and fairness in assessments.

*Table 8: TeamSync business rules*


#### 3.2. Technical requirements

| Identifier | Name | Description |
| --- | --- | --- |
| TR01 | Availability | The system must maintain an availability rate of 99% every 24 hours. |
| TR02 | Accessibility | The system must ensure that everyone can access the pages, regardless of whether or not they have a disability or which web browser they use. |
| **TR03** | **Usability** | **The TeamSync system should be straightforward and user-friendly. <br><br> Ensure that users, even those with limited project management tool experience, can quickly adapt, be more efficient, and enjoy a positive user experience, ultimately promoting accessibility and adoption.** |
| TR04 | Performance | The system must ensure fast response times without disrupting users' product experience. |
| TR05 | Web application | The system should be developed as a web application featuring dynamic pages, utilizing technologies such as HTML5, JavaScript, CSS3, and PHP. |
| **TR06** | **Portability** | **The server-side system should be platform-agnostic, ensuring compatibility across various platforms such as Linux, Mac OS, and others. <br><br> Ensuring platform-agnostic compatibility, including Linux, Mac OS, and others, is essential as it expands the system's user base, enhances accessibility, and reduces adoption barriers by allowing users to choose their preferred operating system.** |
| TR07 | Database | The PostgreSQL database management system must be used, with a version of 11 or higher. |
| TR08 | **Security** | **The system shall safeguard information against unauthorized access by implementing an authentication and verification system. <br><br> Security is crucial to protect user information. Implementing authentication and verification ensures that only authorized users can access the system, safeguarding sensitive data and maintaining user trust.** |
| TR09 | Robustness | The system must be designed to effectively handle and maintain operation even in the presence of runtime errors. |
| TR10 | Scalability | The system must be ready to accommodate an increasing number of users and their interactions as it scales. |
| TR11 | Ethics | The system must adhere to ethical principles in software development, which means it should refrain from collecting or sharing personal user details or usage data without obtaining full acknowledgment and authorization from the data owner. |

*Table 9: TeamSync technical requirements*


#### 3.3. Restrictions

| Identifier | Name | Description |
| --- | --- | --- |
| C01 | Deadline | The system should be ready to be used at the end of the semester. |
| C02 | Database | The database must use PostgreSQL. |

*Table 10: TeamSync project restrictions*

---


## A3: Information Architecture

This artifact contains a site map and three wireframes to show a better representation of TeamSync's pages and the design style that will be used.

### 1. Sitemap

The TeamSync system has several areas, including  the first page to be accessed, pages with authentication features, pages with administration features, static pages with information features, user pages and pages used to explore and access project.

![sitemap](https://hackmd.io/_uploads/BkV7kYwep.png)



*Figure 2: TeamSync SiteMap*

### 2. Wireframes

Wireframes for the Project Page (Project Pages), Profile Page (User Pages) and Sign In Page (Authentication Pages) are displayed in the images below.

#### UI01: Project Page

![projectPage](https://hackmd.io/_uploads/BkBLBFwxT.png)


*Figure 3: Project Page Wireframe*

#### UI02: Profile Page

![profilePage](https://hackmd.io/_uploads/r1_7SFwx6.png)


*Figure 4: Profile Page Wireframe*

#### UI03: Sign In Page

![signinPage](https://hackmd.io/_uploads/BJ6f7Fvga.png)

*Figure 5: Sign In Page Wireframe*

---

## Revision history

Changes made to the first submission:
1. 20/09/2023 - ER Created
2. 20/09/2023 - Added content to A1
3. 23/09/2023 - Finished A1 and started A2
4. 28/09/2023 - Finished A2 and corrected errors in A1
5. 30/09/2023 - Started A3
6. 01/10/2023 - Finished A3

***

GROUP23117, 22/09/2023

* Inês Oliveira, up202103343@edu.fe.up.pt
* João Oliveira, up202108737@edu.fe.up.pt 
* Pedro Magalhães, up202108756@edu.fe.up.pt
* Samuel Oliveira, up202108751@edu.fe.up.pt