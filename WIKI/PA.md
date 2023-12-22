# PA: Product and Presentation

> TeamSync, a web application for streamlined project management in the remote work era, offers easy task creation, collaboration, and progress tracking. Users, categorized as visitors, workers, coordinators, or administrators, experience varying levels of access and roles. The interface prioritizes a user-friendly, intuitive design for a seamless experience across devices.


## A9: Product
 
In today's rapidly evolving work landscape, where remote work is growing very fast, teamwork and communication have become key factors to address workplace challenges and changes. This shift has created an increasing demand for effective project management tools. TeamSync was founded in response to this contemporary issue.

TeamSync is a web application built to simplify and enhance project management. It empowers teams to collaborate with ease, maintain flawless organization and communicate effortlessly, all of which leads to greater work efficiency.

In this application, users can easily create tasks, engage in discussions with colleagues and track the progress within a project.

In TeamSync, users are organized into different groups, each with its own set of permissions and roles. These groups include visitors, workers, coordinators and administrators.

Visitors, also known as unauthenticated users, are users who access the system without logging into an account. They have limited access to website features, although they can view generic pages such as 'About Us' and 'FAQs', where information about the system is displayed. Nevertheless, they can choose to create an account or login to unlock additional features.

Any authenticated user has the ability to search for public projects and, if they find a project of interest, submit an application. Once their application is accepted or they receive an invitation to join, the user becomes a worker on that project. Workers are the base of the system. They can access nearly all system features, participate in tasks, communicate with others in chat rooms and submit work within a project, and edit their profile whenever they want.

On the other hand, when a user creates a new project, he becomes the coordinator. They have a set of additional responsibilities and features that distinguish them from regular workers. Project coordinators gain enhanced control and management capabilities over workers and tasks. They can efficiently approve task completion, archive or modify task details and statuses, and oversee project details, while also managing team members and delivering tasks as part of the workflow.

Administrators hold the highest level of access and power within the system. They can search and consult every project, whether public or private, controll overall system security and manage user's behavior by taking actions such as banning them when necessary.

TeamSync's interface ensures a user-friendly,intuitive and responsive design, delivering an enjoyable experience whether accessed on a PC or a mobile device. With natural and intuitive navigation, users can expect a pleasant overall experience.

### 1. Installation

 The release with the final version of the source code in the group's Git repository is available here, with the PA tag.
 The docker command to launch the image available in the GitLab Container Registry:
``` 
docker run -it -p 8000:80 --name=lbaw23117 -e DB_DATABASE="lbaw23117" -e DB_SCHEMA="lbaw23117" -e DB_USERNAME="lbaw23117" -e DB_PASSWORD="reWisDQE" git.fe.up.pt:5050/lbaw/lbaw2324/lbaw23117 
```


### 2. Usage

URL to the product: http://lbaw23117.lbaw.fe.up.pt  

#### 2.1. Administration Credentials

> Administration URL: URL  

| Username | Password |
| -------- | -------- |
| admin@gmail.com | teamsync123 |

Table 1: TeamSync Administration Credentials

#### 2.2. User Credentials

| Type               | Email                     | Password         |
|--------------------|---------------------------|------------------|
| Project Coordinator account | quinn@example.com | teamsync123       |
| Worker Account |  bob@example.com | teamsync123 |

*(For project "Project Management Tool Implementation")*


Table 2: TeamSync User Credentials

### 3. Application Help

For assistance, users are encouraged to visit many pages such as:
- the FAQ page, where they will find comprehensive answers to any questions they might have.
![Faqs](https://hackmd.io/_uploads/SkE-9HGD6.png)

- the About page, where users can have a better understanding of what is TeamSync.
![About Us](https://hackmd.io/_uploads/r1SDKrMv6.png)


Also, appart from static pages, we have contextual help in create and edit task and project forms:
- Create Project Contextual help
![Create_Project_Help](https://hackmd.io/_uploads/ry1F5BzwT.png)



### 4. Input Validation

> User input was validated using various methods, both on client side and on server side. 
> An example of input validation on client side:

For example, in create task, we used javascript to prevent the default submission of the form if it has errors:
```javascript
function isTaskFormValid() {
let title = document.getElementById("title").value;
let description = document.getElementById("description").value;
let finishDate = document.getElementById("finish_date").value;

document.getElementById('titleError').innerHTML = '';
document.getElementById('descriptionError').innerHTML = '';
document.getElementById('finish_dateError').innerHTML = '';

if (title.length < 15 || title.length > 50) {
    document.getElementById('titleError').innerHTML = 'Title must be between 15 and 50 characters long';
    return false;
}

if (description.length < 100 || description.length > 300) {
    document.getElementById('descriptionError').innerHTML = 'Description must be between 100 and 300 characters long';
    return false;
}

if (finishDate) {
  if(new Date(finishDate) <= new Date()){
    document.getElementById('finish_dateError').innerHTML = 'Finish date must be after today';
    return false;
  }
}

return true;
}
```
Apart from validations after user actions, we also used sweet alert for error prevention popus. For example, when a user clicks on "leave project", it shows the following warning:
![Warning_on_leaveproject](https://hackmd.io/_uploads/B1pEoHGva.png)

>An example of input validation on server side:
For example, to validate the user input in edit profile we used laravel validator by using "lluminate\Http\Request":
```php
public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:25',
            'username' => 'required|string|max:12|unique:users,username,' . $user->id,
            'email' => 'required|email|max:20|unique:users,email,' . $user->id,
        ]);

        if ($request->current_password && !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match our records.']);
        }

        $request->validate([
            'current_password' => ['nullable', 'required_with:new_password,new_password_confirmation'],
            'new_password' => ['nullable', 'required_with:current_password,new_password_confirmation', 'confirmed', 'min:8'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->description = $request->description;

        if ($request->new_password) {
            $user->password = Hash::make($request->new_password);
        }

        
        $user->save();
        
        $user->interests()->sync( $request->interests);
        $user->skills()->sync( $request->skills);


        return redirect()->route('show', $user->id)
            ->withSuccess('You have successfully updated your profile!');
    }
```


### 5. Check Accessibility and Usability

The checklist of accessibility and usability can be seen in the following links:

> [Accessibility Checklist](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23117/-/blob/main/docs/Checklist%20de%20Acessibilidade.pdf?ref_type=heads): 14/18
> [Usability Checklist](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23117/-/blob/main/docs/Checklist%20de%20Usabilidade.pdf?ref_type=heads): 25/28

### 6. HTML & CSS Validation

The checklist of html and css validation can be seen in the following links:

> HTML: https://validator.w3.org/nu/  
> CSS: https://jigsaw.w3.org/css-validator/  

### 7. Revisions to the Project

1. Added tables to database.
2. Created new triggers and fixed the old ones.
3. Changed the priority of some user stories.
4. Corrected the mandatory user stories in the previous delivery that were not fully implemented.

### 8. Implementation Details

#### 8.1. Libraries Used

- Laravel, server-side management 
- Bootstrap, frontend responsive and intuitive
- FontAwesome, icons and buttons.
- SweetAlert, clean and easy to use frontend popups. 

#### 8.2 User Stories

The table below shows all the user stories implemented in the project and the members who developed them.

| Identifier | Name | Priority | Team Members | State
| --- | --- | --- | --- | --- |
| US01 | View Main Page | High | **Samuel** | 100% |
| US02 | Accept Email Invitation | Medium | | 0% |
| US03 | View About Us Page | High | **Samuel** | 100% |
| US04 | Consult FAQs | High | **Samuel** | 100% |
| US05 | Sign In | High | **Inês** | 100% |
| US06 | Sign Up | High | **Inês** | 100% |
| US07 | Recover Password | High | **Inês** | 100% |
| US08 | Forgot Password | High | **Inês** | 100% |
| US09 | Sign In using OAuth API | Low | **João** | 100% |
| US10 | Sign Up using OAuth API | Low | **João** | 100% |
| US11 | Create Project | High | **João** | 100% |
| US12 | View my Projects | High | **Samuel** | 100% |
| US13 | View all Projects | High | **Inês** | 100% |
| US14 | Mark Project as Favourite | High | **Pedro** | 100% |
| US15 | View My Notifications | High | **Pedro** | 100% |
| US16 | Edit Profile | High | **Inês**, João, **Pedro** | 100% |
| US17 | View Profile | High | **Pedro** | 100% | 
| US18 | Log Out | High | **Inês** | 100% |
| US19 | Manage Project Invitation | Medium | **Pedro** | 100% |
| US20 | Join Project | Low | **Pedro** | 100% |
| US21 | Search Projects | Low | **Inês**, Pedro | 100% |
| US22 | Delete Account | Medium | **Inês**, Pedro | 100% |
| US23 | Create Task | High | **João**, Samuel | 100% |
| US24 | Manage Tasks | High| **João**, Samuel | 100% |
| US25 | View Task Details | High | João, **Samuel** | 100% |
| US26 | Comment on Task | High | **João**, Samuel | 100% |
| US27 | Complete Assigned Tasks | High | **João** | 100% |
| US28 | Leave Project | High | **Pedro** | 100% |
| US29 | View Project Members | High | **Samuel** | 100% |
| US30 | View Project Members' Profile | High | **Samuel** | 100% |
| US31 | Search Tasks | High | Inês, **Pedro** | 100% |
| US32 | Assigned Task Notification | Medium | **Pedro** | 100% |
| US33 | Completed Task Notification | Medium | **Pedro** | 100% |
| US34 | Change in Project Coordinator Notification | Medium | **Pedro** | 100% |
| US35 | Accepted Invitation Notification | Medium | **Pedro** | 100% |
| US36 | Browse Project Message Forum | Medium | **João**, Pedro | 100% |
| US37 | Communicate With Others | Medium | **João**, Pedro | 100% |
| US38 | Edit Post | Low | **João** | 100% |
| US39 | Delete Post | Low | **João** | 100% |
| US40 | Invite Users | High | **Pedro** | 100% |
| US41 | Assign New Coordinator | Medium | **Pedro**, João | 100% |
| US42 | Edit Project Details | Medium | **João** | 100% |
| US43 | Assign Tasks to Members | Medium |**João** | 100% |
| US44 | Remove Project Member | Medium | **Pedro** | 100% |
| US45 | Archive Project | Medium | **João**, Samuel | 100% |
| US46 | Archive Tasks | Medium | João, **Samuel** | 100% |
| US47 | Browse Projects | Medium | **Pedro** | 100% |
| US48 | View Project Details | High | **João** | 100% |
| US49 | View Users | High | **Samuel** | 100% |
| US50 | Ban Users | Medium | **Inês** | 100% |
| US51 | Unban Users | Medium | **Inês** | 100% |
| US52 | Search users | Medium | **Inês**, Pedro | 100% |
| US53 | Create users | High | **Inês** | 100% |
| US54 | Support Profile Picture | Medium | **Inês** | 100% |
| US55 | Administrator Accounts | High | **Inês** | 100% |
| US56 | Submit File to Task | Low | **João**, Samuel | 100% |
| US57 | Download File from Task | Low | **João** | 100% |
| US58 | Filters on tasks | Low | **Pedro** | 100% |
| US59 | Change project status (public/private) | Low | João, **Samuel** | 100% |
| US60 | View Upcoming Tasks | Low | **Samuel**, João | 100% |
| US61 | View Project Progression | Low | **Samuel** | 100% |
| US62 | View Tasks | High | **Samuel** | 100% |
| US63 | Contextual Help | High | **Samuel** | 100% |
| US64 | View Landing Page | High | **Samuel** | 100% |
| US64 | View System Statistics | Low | **Samuel** | 100% |



*Table 6: TeamSync implemented User Stories*


---


## A10: Presentation
 
### 1. Product presentation

We have developed a project management website where any registered user can create their own project and add tasks, which will be assigned to the users involved in the project. In addition, it is possible for all users to see the details of public projects and the projects to which they belong. In order to maximize good user interaction with the platform, users can search for the projects or tasks they want to see.


TeamSync is made with HTML5, JavaScript, CSS. We used two frameworks, Bootstrap and Laravel. We used Bootstrap to improve the user interface and Laravel for back-end. Our platform has a simple design and navigation structures, the sidebar, making the user experience enjoyable. Also, if users have question on how to use our website, we have the About and Faqs static pages.
> URL to the product: http://lbaw23117.lbaw.fe.up.pt  


### 2. Video presentation

![VideoPage](https://hackmd.io/_uploads/BJ-91LMDa.png)


You can see the video [here](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23117/-/blob/main/docs/lbaw23117.mp4?ref_type=heads).

---


## Revision history

Changes made to the first submission:
1. 23/11/2023 - PA Created
1. 10/12/2023 - Added content to A9
3. 18/12/2023 - Started A10
4. 21/12/2023 - Finished A10 and fixed A9

***

GROUP23117, 21/12/2023

* Inês Oliveira, up202103343@edu.fe.up.pt
* João Oliveira, up202108737@edu.fe.up.pt
* Pedro Magalhães, up202108756@edu.fe.up.pt (editor)
* Samuel Oliveira, up202108751@edu.fe.up.pt