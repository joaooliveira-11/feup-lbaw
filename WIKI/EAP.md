# EAP: Architecture Specification and Prototype

>TeamSync, a web application for streamlined project management in the remote work era, offers easy task creation, collaboration, and progress tracking. Users, categorized as visitors, workers, coordinators, or administrators, experience varying levels of access and roles. The interface prioritizes a user-friendly, intuitive design for a seamless experience across devices.

## A7: Web Resources Specification

This artifact documents the  architecture of the web application to be developed, indicating the catalog of resources, the properties of each resource, and the format of JSON responses. This artifact presents the documentation for TeamSync.

### 1. Overview

>This section defines an overview of the web application where the modules are identified and briefly described.

| Modules | Description |
|---------|-------------|
| M01: Authentication | Web resources associated with user authentication and registration, with features such as login/logout and registration. |
| M02: Individual Profile | Web resources associated with viewing and editing user information. |
| M03: Projects | Web resources associated with project creation, edition and deletion. |
| M04: Tasks | Web resources associated with tasks, with features such as task creation, edition and deletion. |
| M05: Search | Web resources associated with search features, such as searching users, projects and tasks. |
| M06: Comments | Web resources associated with comments, such as comment creation, deletion and visualization. |
| M07: Administration and Static Pages | Web resources associated with user management, such as blocking, unblocking and banning users, deleting comments and updating static pages: services, about, contact and faq. |

*Table 1: TeamSync Resources Overview*


### 2. Permissions

| Identifier | Name | Description |
| --- | --- | --- |
| VST | Visitor | An unauthenticated user. |
| AUS | User | An authenticated user. |
| WRK | Worker | An authenticad user that is a member of a project. |
| COR | Coordinator | An authenticad user that is the creator of a project.|
| ADM | Administrator | System administrator. |


*Table 2: TeamSync Permissions*


### 3. OpenAPI Specification

This section includes the complete API specification in OpenAPI (YAML) for the vertical prototype

```yaml
openapi: 3.0.0

info:
  version: '1.0'
  title: 'LBAW TeamSync Web API'
  description: 'Web Resources Specification (A7) for TeamSync'

servers:
- url: http://lbaw23117.lbaw.fe.up.pt
  description: Production server

externalDocs:
  description: Find more info here.
  url: https://git.fe.up.pt/lbaw/lbaw2324/lbaw23117/-/wikis/home/EAP.md

tags:
  - name: 'M01: Authentication'
  - name: 'M02: Individual Profile'
  - name: 'M03: Projects'
  - name: 'M04: Tasks'
  - name: 'M05: Search'

##################     LOG IN     ##################

paths:
  /login:
    get:
      operationId: R101
      summary: 'R101: Login Form'
      description: 'Provide login form. Access: PUB'
      tags:
        - 'M01: Authentication'
      responses:
        '200':
          description: 'Ok. Show log-in UI'
    post:
      operationId: R102
      summary: 'R102: Login Action'
      description: 'Processes the login form submission. Access: PUB'
      tags:
        - 'M01: Authentication and Individual Profile'
 
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                email:          # <!--- form field name
                  type: string
                  format: email
                password:    # <!--- form field name
                  type: string
                  format: password
              required:
                - email
                - password
 
      responses:
        '302':
          description: 'Redirect after processing the login credentials.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful authentication. Redirect to home page.'
                  value: '/home'
                302Error:
                  description: 'Failed authentication. Redirect to login form.'
                  value: '/login'
 

##################     LOG OUT     ##################


  /logout:

    post:
      operationId: R103
      summary: 'R103: Logout Action'
      description: 'Logout the current authenticated user. Access: USR, ADM'
      tags:
        - 'M01: Authentication'
      responses:
        '302':
          description: 'Redirect after processing logout.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful logout. Redirect to landing page.'
                  value: '/index'



##################     REGISTER     ##################


  /register:
    get:
      operationId: R104
      summary: 'R104: Register Form'
      description: 'Provide new user registration form. Access: PUB'
      tags:
        - 'M01: Authentication'
      responses:
        '200':
          description: 'Ok. Show Sign-Up UI'

    post:
      operationId: R105
      summary: 'R105: Register Action'
      description: 'Processes the new user registration form submission. Access: PUB'
      tags:
        - 'M01: Authentication'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                username:
                  type: string
                email:
                  type: string
                  format: email
                password:
                  type: string
                  format: password
                confirm_password:
                  type: string
                  format: password
              required:
                - name
                - username
                - email
                - password
                - confirm_password

      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful registration. Redirect to home page.'
                  value: '/home'
                302Failure:
                  description: 'Failed registration. Redirect to register form.'
                  value: '/register'


##################     PROFILE     ##################

  /profile/{id}:
    get:
      operationId: R201
      summary: 'R201: View user profile'
      description: 'Show the individual user profile. Access: USR, ADM'
      tags:
        - 'M02:Individual Profile'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '200':
          description: 'Ok. Show view profile UI'
        '302':
          description: 'Redirect if user is not logged in or user does not exist.'
          headers:
            Location:
              schema:
                type: string
              example:
                302Failure:
                  description: 'Failed.'
                  value: '/'
                  
##################     EDIT PROFILE     ##################

  /edit-profile/{id}:
    get:
      operationId: R202
      summary: 'R202: Edit user profile form'
      description: 'Provide edit user profile form. Access: USR, ADM'
      tags:
        - 'M02:Individual Profile'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Ok. Show edit profile UI'
        '302':
          description: 'Redirect if user is not logged in or user does not exist.'
          headers:
            Location:
              schema:
                type: string
              example:
                302Failure:
                  description: 'Failed.'
                  value: '/'

    put:
      operationId: R203
      summary: 'R203: Update user profile'
      description: 'Processes the edit user profile form submission. Access: USR, ADM'
      tags:
        - 'M02:Individual Profile'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                username:
                  type: string
                email:
                  type: string
                  format: email
                password:
                  type: string
                  format: password
                confirm_password:
                  type: string
                  format: password
              required:
                - name
                - username
                - email
      responses:
        '302':
          description: 'Redirect after processing the updated user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful update. Redirect to profile page.'
                  value: '/profile/{id}'
                302Failure:
                  description: 'Failed update. Redirect to edit profile form.'
                  value: '/edit-profile/{id}'

##################     PROJECT     ##################

  /project/create:
    get:
      operationId: R301
      summary: 'R301: Create project form'
      description: 'Provide create project form. Access: USR, ADM'
      tags:
        - 'M03: Projects'
      responses:
        '200':
          description: 'Ok. Show create project UI'
        '302':
          description: 'Redirect if user is not logged in.'
          headers:
            Location:
              schema:
                type: string
              example:
                302Failure:
                  description: 'Failed.'
                  value: '/login'

    post:
      operationId: R302
      summary: 'R302: Create project'
      description: 'Processes the create project form submission. Access: USR, ADM'
      tags:
        - 'M03: Projects'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                title:
                  type: string
                description:
                  type: string
                finish_date:
                  type: string
              required:
                - title
                - description
      responses:
        '302':
          description: 'Redirect after processing the new project information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful creation. Redirect to project page.'
                  value: '/project/{project_id}'
                302Failure:
                  description: 'Failed creation. Redirect to create project form.'
                  value: '/project/create'

  /project/{project_id}:
    get:
      operationId: R303
      summary: 'R303: View project'
      description: 'Show the individual project. Access: USR, ADM'
      tags:
        - 'M03: Projects'
      parameters:
        - in: path
          name: project_id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Ok. Show view project UI'
        '302':
          description: 'Redirect if user is not logged in or project does not exist.'
          headers:
            Location:
              schema:
                type: string
              example:
                302Failure:
                  description: 'Failed.'
                  value: '/'

    
  /project/{project_id}/members:
    get:
      operationId: R304
      summary: 'R304: View project members'
      description: 'Show all project members. Access: USR, ADM'
      tags:
        - 'M03: Projects'
      parameters:
        - in: path
          name: project_id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Ok. Show view project members UI'
        '302':
          description: 'Redirect if user is not logged in or project does not exist.'
          headers:
            Location:
              schema:
                type: string
              example:
                302Failure:
                  description: 'Failed.'
                  value: '/'
                  
  
  /project/{project_id}/adduser:
    get:
      operationId: R305
      summary: 'R305: View non project members'
      description: 'Show all non project members. Access: USR, ADM'
      tags:
        - 'M03: Projects'
      parameters:
        - in: path
          name: project_id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Ok. Show view project members UI'
        '302':
          description: 'Redirect if user is not logged in or project does not exist.'
          headers:
            Location:
              schema:
                type: string
              example:
                302Failure:
                  description: 'Failed.'
                  value: '/'
                  
                  
    
    post:
      operationId: R306
      summary: 'R306: Add user to project'
      description: 'Processes the add user to project submission. Access: USR, ADM'
      tags:
        - 'M03: Projects'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                project_id:
                  type: integer
                user_id:
                  type: integer
      responses:
        '302':
          description: 'Redirect after processing the new project member.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful addition. Redirect to project members page.'
                  value: '/project/{project_id}/members'
                302Failure:
                  description: 'Failed addition. Redirect to non project members page.'
                  value: '/project/{project_id}/adduser'
   
                  
                  
##################     TASK     ##################

  /project/{project_id}/task/create:
    get:
      operationId: R401
      summary: 'R401: Create task form'
      description: 'Provide create task form. Access: USR, ADM'
      tags:
        - 'M04: Tasks'
      parameters:
        - in: path
          name: project_id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Ok. Show create task UI'
        '302':
          description: 'Redirect if user is not logged in or project does not exist.'
          headers:
            Location:
              schema:
                type: string
              example:
                302Failure:
                  description: 'Failed.'
                  value: '/login'

    post:
      operationId: R402
      summary: 'R402: Create task'
      description: 'Processes the create task form submission. Access: USR, ADM'
      tags:
        - 'M04: Tasks'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                title:
                  type: string
                description:
                  type: string
                finish_date:
                  type: string
                priority:
                  type: string
              required:
                - title
                - description
                - priority
                
      responses:
        '302':
          description: 'Redirect after processing the new task information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful creation. Redirect to task page.'
                  value: '/task/{task_id}'
                302Failure:
                  description: 'Failed creation. Redirect to create task form.'
                  value: '/project/{project_id}/task/create'

  /task/{task_id}:
    get:
      operationId: R403
      summary: 'R403: View task'
      description: 'Show the individual task. Access: USR, ADM'
      tags:
        - 'M04:Tasks'
      parameters:
        - in: path
          name: task_id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Ok. Show view task UI'
        '302':
          description: 'Redirect if user is not logged in or task does not exist.'
          headers:
            Location:
              schema:
                type: string
              example:
                302Failure:
                  description: 'Failed.'
                  value: '/'

  /task/{task_id}/edit:
    get:
      operationId: R404
      summary: 'R404: Edit task form'
      description: 'Provide edit task form. Access: USR, ADM'
      tags:
        - 'M04: Tasks'
      parameters:
        - in: path
          name: task_id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Ok. Show edit task UI'
        '302':
          description: 'Redirect if user is not logged in or task does not exist.'
          headers:
            Location:
              schema:
                type: string
              example:
                302Failure:
                  description: 'Failed.'
                  value: '/'

    patch:
      operationId: R405
      summary: 'R405: Update task'
      description: 'Processes the edit task form submission. Access: USR, ADM'
      tags:
        - 'M04: Tasks'
      parameters:
        - in: path
          name: task_id
          schema:
            type: integer
          required: true
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                title:
                  type: string
                description:
                  type: string
                finish_date:
                  type: string
                priority:
                  type: string
                 
              required:
                - title
                - description
                - priority
                
      responses:
        '302':
          description: 'Redirect after processing the updated task information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful update. Redirect to task page.'
                  value: '/task/{task_id}'
                302Failure:
                  description: 'Failed update. Redirect to edit task form.'
                  value: '/task/{task_id}/edit'
    
  /task/complete:
    patch:
      operationId: R406
      summary: 'R406: Complete Task'
      description: 'When a task is completed'
      tags:
        - 'M04: Tasks'
      parameters:
        - name: complete
          in: query
          schema:
            type: string
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                task_id:
                  type: integer
      responses:
        '200':
          description: Successful operation

  /search-projects:
    post:
      operationId: R501
      summary: 'R501: Search Project'
      description: 'Search for a project in all the public projects.'
      tags:
        - 'M05: Search'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                title:
                  type: string
                description:
                  type: string
              required:
                - title
                - description
      responses:
        '302':
          description: 'Redirect after processing the projects that match the input.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful creation. Redirect to task page.'
                  value: '/projects'
                302Failure:
                  description: 'Failed creation. Redirect to create task'
```


## A8: Vertical prototype

>The Vertical Prototype encompasses the integration of essential features, validating the proposed architecture and providing an opportunity to familiarize oneself with the technologies employed in the project.

### 1. Implemented Features

#### 1.1. Implemented User Stories

> The following table describes the implemented user stories.

| User Story reference | Name | Priority | Description |
| --- | --- | --- | --- |
| US05 | Sign In | High | As a Visitor, I want to authenticate myself into the system, so that I can access privileged content and participate in projects. |
| US06 | Sign Up | High | As a Visitor, I want to register myself into the system, so that I can authenticate into the system. |
| US10 | Create Project | High | As an Authenticated User, I want to create a new project, so that I can develop my idea with other workers. |
| US11 | View my Projects | High | As an Authenticated User, I want to see my current projects, so that I can easily access them and organize my work. |
| US14 | Edit Profile | High | As an Authenticated User, I want to edit my profile picture and description, so that my profile can be kept up to date. |
| US15 | View Profile | High | As an Authenticated User, I want to view my profile, so that I can review and manage my personal information.|
| US16 | Log Out | High | As an Authenticated User, I want to log out of my account, so that I can safely exit the platform. |
| US19 | Search Projects | High | As a User, I want to search for projects, so that I can quickly find the projects I am most interested in. |
| US21 | Create Task | High | As a Worker, I want to create tasks to facilitate team coordination and task assignment. |
| US22 | Manage Tasks | High| As a Worker, I want to manage tasks, so that I can set their priority, labels and timeline. |
| US23 | View Task Details | High | As a Worker, I want to see the task details, so that I can better understand its objectives and method of work. |
| US25 | Complete Assigned Tasks | High | As a Worker, I want to mark my task as finished, so that I can move on to another task and keep the project organized. |
| US28 | View Project Members' Profile | High | As a Worker, I want to see the project members' profile, so that I can learn more about my coleagues. |
| US29 | Search Tasks | High | As a Worker, I want to search for tasks within a project, so that I can easily find tasks that are either completed or pending in order to decide the ones im most interested in. |
| US39 | Invite Users | High | As a Coordinator, i want to invite users to my projects, so that i can create a team to work on them. |
| US47 | Browse Projects | High | As an Admin, I want to view and search all the projects on the platform, so that I can keep track of how many projects have been completed and how many are still active. |
| US48 | View Project Details | High | As an Admin, I want to acess all the details of every project, so that I can stay informed about the project's progress and specifics.|

*Table 3: TeamSync Implemented User Stories*

>All the mandatory user stories have been implemented, and we've also made a few additions.

#### 1.2. Implemented Web Resources


> Module M01: Authentication  

| Web Resource Reference | URL |
| --- | --- |
| R01: Login Form | /login |
| R02: Login Action | POST /login |
| R03: Logout Action | POST /logout |
| R04: Register Form | /register |
| R05: Register Action | POST /register |

*Table 4: Authentication Implementation*

> Module M02: Individual Profile 

| Web Resource Reference | URL |
| --- | --- |
| R06: View profile | /profile/{id} |
| R07: Edit Profile | /edit-profile/{id} |
| R08: Update Profile | PUT /profile/{id} |

*Table 5: Individual Profile Implementation*

> Module M03: Projects 

| Web Resource Reference | URL   |
| --- | --- |
| R09: Create Project Form | /project/create |
| R10: Create Project Action | POST /project/create |
| R11: Show Projects | /projects |
| R12: Sohwn Project Members | /project/{id}/members |
| R13: Show Project Card | /project/{id} |
| R14: Show Project Tasks | /project/{project_id}/tasks |
| R15: Add User to Project | /project/{project_id}/adduser |
| R16: Add User to Project | POST /project/add-user |

*Table 6: Projects Implementation*

> Module M04: Tasks

| Web Resource Reference | URL                            |
| --- | --- |
| R17: Create Task Form | /project/{project_id}/task/create |
| R18: Create Task Action | POST /task/create |
| R19: Show Task | /task/{task_id} |
| R20: Edit Task Form | /task/{task_id}/edit |
| R21: Edit Task Action | PATCH /task/edit |
| R22: Complete Task Action | PATCH /task/complete |

*Table 7: Tasks Implementation*

> Module M05: Search
 
| Web Resource Reference | URL |
| --- | --- |
| R23: Search Projects | POST /search-projects |

*Table 8: Search Implementation*

### 2. Prototype

The prototype is available at http://lbaw23117.lbaw.fe.up.pt

Credentials: 

|Type of User | Email | Password|
|---|---|---
| Admin | admin@gmail.com | 1234 |
| Regular | bob@example.com | 1234 |

*Table 9: TeamSync Credentials*

The code is available at https://git.fe.up.pt/lbaw/lbaw2324/lbaw23117

---


## Revision history

Changes made to the first submission:
1. 23/10/2023 - EAP Created
1. 23/10/2023 - Added content to A7
3. 25/10/2023 - Started A8
4. 3/11/2023 - Finished A7
5. 20/11/2023 - Finished A8 and fixed A7

***

GROUP23117, 23/10/2023

* Inês Oliveira, up202103343@edu.fe.up.pt
* João Oliveira, up202108737@edu.fe.up.pt 
* Pedro Magalhães, up202108756@edu.fe.up.pt
* Samuel Oliveira, up202108751@edu.fe.up.pt (editor)