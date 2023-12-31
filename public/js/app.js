function addEventListeners() {
  
  let changePic = document.querySelector('#fileInput');
  if (changePic != null)
  changePic.addEventListener('change', handleFileSelect);

  document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        this.parentNode.parentNode.classList.toggle('selected', this.checked);
    });
  });

  if (document.getElementById("CreateTaskModalButton")) {
    setupModalForm("createtaskform", 'CreateTaskModalButton', 'ModalCreateTask');
  }
  if (document.getElementById("EditTaskModalButton")) {
    setupModalForm("edittaskform", 'EditTaskModalButton', 'ModalEditTask');
  }
  if (document.getElementById("EditProjectModalButton")) {
    setupModalForm("editprojectform", 'EditProjectModalButton', 'ModalEditProject');
  }
  if (document.getElementById("CreateProjectModalButton")) {
    setupModalForm("createprojectform", 'CreateProjectModalButton', 'ModalCreateProject');
  }
  if (document.getElementById("assignUserButton")) {
    setupModalForm('assignTaskForm', 'assignUserButton', 'ModalAssignTask');
  }
  if (document.getElementById("AssignCoordinatorModalButton")) {
    setupModalForm('assignCoordinatorForm', 'AssignCoordinatorModalButton', 'ModalAssignCoordinator');
  }
  if (document.getElementById("AddMemberModalButton")) {
    setupModalForm("addmemberform", 'AddMemberModalButton', 'ModalAddMember');
  }

  if (document.getElementById("submit-comment-button")) {
    setupCommentForm("createcommentform");
  }
  if (document.getElementById("submit-message-button")) {
    setupMessageForm("createmessageform");
  }

  let commentsSection = document.querySelector('.comments-section');
  if (commentsSection) {
    commentsSection.addEventListener('click', handleDeleteComment);
    commentsSection.addEventListener('click', handleEditComment);
  }

  let chatSection = document.querySelector('.chat-section');
  if (chatSection) {
    chatSection.addEventListener('click', handleDeleteMessage);
    chatSection.addEventListener('click', handleEditMessage);
  }

  let notificationsButton = document.getElementById("notifications-button");
  if(notificationsButton){
    document.getElementById("notifications-button").addEventListener("click", function(event) {
      document.getElementById("notifications-dropdown").classList.toggle("hide");
    });
  }
  

  let leaveProjectButton = document.getElementById('leaveProject');
  if (leaveProjectButton) {
    leaveProjectButton.addEventListener('click', handleLeaveProjectClick);
  }
  
  let changeProjectvisibility = document.getElementById('visibilitySwitch');
  if (changeProjectvisibility) {
    changeProjectvisibility.addEventListener('change', handleProjectVisibility);
  }

  let changeProjectStatus = document.getElementById('statusSwitch');
  if (changeProjectStatus) {
    changeProjectStatus.addEventListener('change', handleProjectStatus);
  }

  let completetaskbtn = document.getElementById('completetaskbtn');
  if(completetaskbtn){
    completetaskbtn.addEventListener('click', handleCompleteTask);
  }

  let archivetaskbtn = document.getElementById('archivetaskbtn');
  if(archivetaskbtn){
    archivetaskbtn.addEventListener('click', handleArchiveTask);
  }

  //kick members as coordinator
  const members = document.getElementsByClassName('kick-member');
  for (let i = 0; i < members.length; i++) {
    members[i].addEventListener('click', function(event) {
      event.preventDefault();
      Swal.fire({
          title: "Are you sure?",
          text: "Once kicked, the member will not be able to rejoin the project!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, I am sure!',          

      })
      .then((result) => {
        if (result.isConfirmed) {
          const urlPath = window.location.pathname;
          const pathParts = urlPath.split('/');
          const projectId = pathParts[pathParts.length - 1];
          const memberId = document.querySelectorAll('.user-id')[i].id.substring(4);
          console.log("Project: "+projectId);
          console.log("Member: "+memberId);
          kickFromProject(memberId, projectId);
        }
      });
    });
  }
  
  let closeButton = document.querySelector('.close-notifications');
  if(closeButton) {
    closeButton.addEventListener('click', closeNotifications);
  }

  if(document.getElementById('userSearchInput')){
      document.getElementById('userSearchInput').addEventListener('input', function() {
        sendAjaxRequest('GET', '/search-users?search=' + this.value, {}, handleSearchUser);
    });
  }
  document.addEventListener("DOMContentLoaded", function() {
    var hamburger = document.getElementById('hamburger');
    var menu = document.querySelector('.navbar-list-ul');

    hamburger.addEventListener('click', function() {
        menu.classList.toggle('navbar-active');
    });
  });

  setupRadioButtons();
} 

function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}

function getCSRF() {
  let tokenField = document.createElement('input')
  tokenField.type = "hidden"
  tokenField.name = "_token"
  tokenField.value = document.querySelector("head meta[name='csrf-token']").content;
  return tokenField;
}  

function handleFileSelect(event) {
  const fileInput = event.target;
  console.log(event);
  const file = fileInput.files[0];

  if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
          const profilePicture = document.getElementById('profilePicture');
          profilePicture.src = e.target.result;
      };
      reader.readAsDataURL(file);
  }
}

function searchProjects(page = 1) {
  var input = document.getElementById('projectSearch');
  var filter = input.value;
  var url = '/search-projects?filter=' + encodeURIComponent(filter) + '&page=' + page;
  sendAjaxRequest('GET', url, {}, handleSearchProject);
}


function searchTasks() {
    const input = document.getElementById('taskSearch');
    const filter = input.value; 
    const project_id = document.getElementById('tasks-container').className.split(' ')[1];
    const statusFilter = document.getElementById('status-selected').value;
    const priorityFilter = document.getElementById('priority-selected').value;
    sendAjaxRequest('POST', '/search-tasks', { filter: filter, project_id : project_id, statusFilter: statusFilter, priorityFilter: priorityFilter}, handleSearchTask);
}

function handleSearchTask(){
if (this.status >= 200 && this.status < 400) {
  var data = JSON.parse(this.response);
  var container = document.querySelector('#tasks-container');
  var ul = document.querySelector('.TasksList');
  if (!ul) {
      ul = document.createElement('ul');
      ul.classList.add('TasksList');
      container.appendChild(ul);
  }
  ul.innerHTML = '';

  if(data.length == 0){
    if(document.querySelector('.no-tasks') == null){
    const tasksContainer = document.getElementById('tasks-container');
    const div = document.createElement('div');
    div.classList.add('task-content');
    div.classList.add('no-tasks');
    div.textContent = "No tasks found";
    tasksContainer.appendChild(div);
    }
  }
  else{
    const noTasksDiv = document.querySelector('.no-tasks');
    if (noTasksDiv) {
        noTasksDiv.remove();
    }
  }

  data.forEach(task => {
      var li = document.createElement('li');
      li.classList.add('task-item');

      var div = document.createElement('div');

      var a = document.createElement('a');
      a.href = '/task/' + task.task_id;
      a.classList.add('task-link');
      a.classList.add('project-link');

      var title = document.createElement('p');
      title.classList.add('TaskTitle');
      title.textContent = task.title;
      div.appendChild(title);

      var description = document.createElement('p');
      description.classList.add('task-description');
      
      description.textContent = task.description;
      div.appendChild(description);

      var deadline = document.createElement('p');
      deadline.classList.add('FinishDate');
      if(task.finish_date == null) deadline.textContent = " Deadline: Not defined ";
      else{
      deadline.textContent = "Deadline: " + task.finish_date;
      }
      div.appendChild(deadline);

      li.appendChild(div);
      a.appendChild(li);
      ul.appendChild(a);
  });
}
else {
    console.error('Error:', this.status, this.statusText);
}
}


function handleSearchProject() {

  if (this.status >= 200 && this.status < 400) {
    var data = JSON.parse(this.response);
    var container = document.querySelector('#projects-container');
    var ul = container.querySelector('.projects-list');
    if (!ul) {
        ul = document.createElement('ul');
        ul.classList.add('projects-list');
        container.appendChild(ul);
    }
    ul.innerHTML = ''; 

    if(data.projects.length == 0){
      if(document.querySelector('.no-projects') == null){
      const div = document.createElement('div');
      div.classList.add('no-projects');
      div.textContent = "No projects found";
      ul.before(div);
      document.querySelector('.pagination-container').style.display = 'none';
      }
  }else{
      const noProjectsDiv = document.querySelector('.no-projects');
      if (noProjectsDiv) {
          noProjectsDiv.remove();
          document.querySelector('.pagination-container').style.display = 'block';
      }
  }

    data.projects.forEach(project => {
        var li = document.createElement('li');
        li.classList.add('project-item');

        var div = document.createElement('div');
        div.classList.add('project-content');
        div.classList.add(project.project_id);

        var a = document.createElement('a');
        a.href = '/project/' + project.project_id;
        a.classList.add('project-link');

        var title = document.createElement('h2');
        title.classList.add('projects-title');
        title.textContent = project.title;
        div.appendChild(title);

        var coordinator = document.createElement('p');
        coordinator.classList.add('project-coordinator');
        coordinator.classList.add('project-info');
        
        var id = project.created_by;

        var deadline = document.createElement('p');
        deadline.classList.add('project-deadline');
        deadline.classList.add('project-info');
        if(project.finish_date == null) deadline.textContent = " Not defined ";
        else{ deadline.textContent = project.finish_date;}
        div.appendChild(deadline);

        var otherdiv = document.createElement('div');
        otherdiv.classList.add('project-details');
        var description = document.createElement('p');
        description.classList.add('project-info');
        description.textContent = project.description;
        otherdiv.appendChild(description);
      

        li.appendChild(div);
        li.appendChild(otherdiv);
        a.appendChild(li);
        ul.appendChild(a);

        

        sendAjaxRequest('POST', '/user-name' ,{id : id}, function() {
          if (this.status >= 200 && this.status < 400) {
              var data = JSON.parse(this.response);
              var userName = data.name;
              var coordinator = document.createElement('p');
              coordinator.classList.add('project-info');
              coordinator.classList.add('project-coordinator');
              coordinator.textContent += userName;
              var element = document.querySelector('[class="' + project.project_id + '"]');
              div.appendChild(coordinator);
          }
      });

      document.querySelector('.pagination-container').innerHTML = '';
      if (data.currentPage != 1) {
        const previousPageUrl = document.createElement('button');
        previousPageUrl.onclick = function() {
          searchProjects(data.currentPage - 1);
      };
        previousPageUrl.textContent = 'Previous';
        previousPageUrl.classList.add('btn');
        document.querySelector('.pagination-container').appendChild(previousPageUrl);
      }
      const currentPage = document.createElement('span');
      currentPage.textContent = 'Page ' + data.currentPage + ' of ' + data.lastPage;
      document.querySelector('.pagination-container').appendChild(currentPage);
      if (data.hasMorePages) {
        const nextPageUrl = document.createElement('button');
        nextPageUrl.onclick = function() {
          searchProjects(data.currentPage + 1);
        };
        nextPageUrl.textContent = 'Next';
        nextPageUrl.classList.add('btn');
        document.querySelector('.pagination-container').appendChild(nextPageUrl);
      }

    });
} else {
    console.error('Error:', this.status, this.statusText);
}
}

function handleSearchUser() {
  if (this.status >= 200 && this.status < 400) {
    const data = JSON.parse(this.response);
    const container = document.querySelector('#userTableBody');
    container.innerHTML = '';

    if(data.length == 0){
      if(document.querySelector('.no-users') == null){
      const div = document.createElement('div');
      div.classList.add('no-users');
      div.textContent = "No users found";
      container.before(div);
      }
    }
       else {
        const noUsersDiv = document.querySelector('.no-users');
        if (noUsersDiv) {
            noUsersDiv.remove();
        }
      }


    data.forEach(user => {
      const tr = document.createElement('tr');
      tr.onclick = function() {
        window.location.href = '/profile/' + user.id;
      }
      const id = document.createElement('td');
      id.textContent = user.id;

      const name = document.createElement('td');
      name.textContent = user.name;

      const email = document.createElement('td');
      email.textContent = user.email;

      tr.appendChild(id);
      tr.appendChild(name);
      tr.appendChild(email);

      container.appendChild(tr);
    });
  }
}

function setupRadioButtons() {
const radios = document.querySelectorAll('#projectForm input[type="radio"]');

radios.forEach(function(radio) {
  radio.addEventListener('change', function() {
    const id = this.value;
    document.querySelector('label.selected').classList.toggle('selected', false);
    this.parentNode.classList.toggle('selected', this.checked);

    const toHide = document.querySelectorAll('#MainContent .selected');
    toHide.forEach(element => {
      element.classList.remove('selected');
    });

    const toDisplay = document.querySelectorAll('#MainContent div#' + id);
    toDisplay.forEach(element => {
      element.classList.add('selected');
    });

    if (id === 'Chat') {
      let chatSection = document.querySelector('.chat-section');
      chatSection.scrollTop = chatSection.scrollHeight;
  }

  });
});
}


function handleCreateTask(event) {
  
  if (!isTaskFormValid()) {
    event.preventDefault();
  }
  
}

function handleEditTask(modalId, event) {
event.preventDefault();

if (!isTaskFormValid()) {
  return;
}

let url = this.getAttribute('action');
let formData = new FormData(this);
// formData.append('_method', 'PATCH');
let csrfToken = document.querySelector('input[name="_token"]').value;

fetch(url, {
  method: 'POST',
  body: formData,
  headers: {
    'X-Requested-With': 'XMLHttpRequest', 
    'X-CSRF-TOKEN': csrfToken,
  },
})
.then(response => response.json())
.then(data => {
  let modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
  modal.hide();
  
  let titleNode = document.createTextNode(data.task_title);
  if(data.task_finish_date){
    let finishDate = new Date(data.task_finish_date);
    let formattedFinishDate = finishDate.getFullYear() + '-' +
      String(finishDate.getMonth() + 1).padStart(2, '0') + '-' +
      String(finishDate.getDate()).padStart(2, '0') + ' ' +
      String(finishDate.getHours()).padStart(2, '0') + ':' +
      String(finishDate.getMinutes()).padStart(2, '0') + ':' +
      String(finishDate.getSeconds()).padStart(2, '0');
      let finishDateNode = document.createTextNode(formattedFinishDate);
      let finishDateElement = document.getElementById('task-details-finish_date');
      finishDateElement.parentNode.replaceChild(finishDateNode, finishDateElement.nextSibling);
  }
  else{
    let finishDateNode = document.createTextNode('Not defined');
    let finishDateElement = document.getElementById('task-details-finish_date');
    finishDateElement.parentNode.replaceChild(finishDateNode, finishDateElement.nextSibling);
  }

  let priorityNode = document.createTextNode(data.task_priority);

  let titleElement = document.getElementById('task-details-title');
  let priorityElement = document.getElementById('task-details-priority');

  titleElement.parentNode.replaceChild(titleNode, titleElement.nextSibling);
  priorityElement.parentNode.replaceChild(priorityNode, priorityElement.nextSibling);
  
  document.querySelector('#task-description p').textContent = data.task_description;
})
.catch(error => console.error('Error:', error));
}

function handleCreateProject(event) {
  
  if (!isProjectFormValid()) {
    event.preventDefault();
  }
  
}

function handleEditProject(modalId, event) {
event.preventDefault();
if (!isProjectFormValid()) {
  return;
}

let url = this.getAttribute('action');
let formData = new FormData(this);
formData.append('_method', 'PATCH');

fetch(url, {
  method: 'POST',
  body: formData,
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
  },
})
.then(response => response.json())
.then(data => {
  let modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
  modal.hide();
  if(data.project_finish_date){
    let finishDate = new Date(data.project_finish_date);
    let formattedFinishDate = finishDate.getFullYear() + '-' +
      String(finishDate.getMonth() + 1).padStart(2, '0') + '-' +
      String(finishDate.getDate()).padStart(2, '0') + ' ' +
      String(finishDate.getHours()).padStart(2, '0') + ':' +
      String(finishDate.getMinutes()).padStart(2, '0') + ':' +
      String(finishDate.getSeconds()).padStart(2, '0');

      let finishDateElement = document.querySelector('#ProjectDeadline #dashboard-project-content');
      finishDateElement.textContent = formattedFinishDate;
  }
  else{
    let finishDateElement = document.querySelector('#ProjectDeadline #dashboard-project-content');
    finishDateElement.textContent = 'Not defined';
  }

  let titleElement = document.querySelector('.sidebar-project-title');
  let descriptionElement = document.querySelector('#ProjectDescription #dashboard-project-content');

  titleElement.textContent = data.project_title;
  descriptionElement.textContent = data.project_description;
})
.catch(error => console.error('Error:', error));
}

function handleCreateComment(event) {
event.preventDefault();
if (!isCommentFormValid("comment-content", "createcomment-contentError")) {
  return;
}

let url = this.getAttribute('action');
let formData = new FormData(this);
let csrfToken = document.querySelector('input[name="_token"]').value;

fetch(url, {
  method: 'POST',
  body: formData,
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrfToken,
  },
})
.then(response => response.json())
.then(data => {
  let commentsSection = document.querySelector('.comments-section');

  let commentDiv = document.createElement('div');
  commentDiv.className = 'comment container';
  commentDiv.id = 'comment-' + data.comment_id;

  let userImage = document.createElement('img');
  userImage.src = data.comment_by_photo;
  userImage.className = 'user-image';
  userImage.alt = 'User Image';
  commentDiv.appendChild(userImage);

  let commentContentDiv = document.createElement('div');
  commentContentDiv.className = 'comment-content';

  let usernameH5 = document.createElement('h5');
  usernameH5.className = 'message-username';
  usernameH5.textContent = data.comment_comment_by;
  commentContentDiv.appendChild(usernameH5);

  let contentP = document.createElement('p');
  contentP.textContent = data.comment_content;
  contentP.id = 'comment-content-' + data.comment_id;
  commentContentDiv.appendChild(contentP);

  let commentInfoButtonsDiv = document.createElement('div');
  commentInfoButtonsDiv.className = 'comment-info-buttons';

  let messageInfoLeftDiv = document.createElement('div');
  messageInfoLeftDiv.className = 'message-info-left';

  let createDate = new Date(data.comment_create_date);
  let formattedCreateDate = createDate.getFullYear() + '-' +
  String(createDate.getMonth() + 1).padStart(2, '0') + '-' +
  String(createDate.getDate()).padStart(2, '0') + ' ' +
  String(createDate.getHours()).padStart(2, '0') + ':' +
  String(createDate.getMinutes()).padStart(2, '0') + ':' +
  String(createDate.getSeconds()).padStart(2, '0');

  let createDateH6 = document.createElement('h6');
  createDateH6.textContent = formattedCreateDate;
  messageInfoLeftDiv.appendChild(createDateH6);

  commentInfoButtonsDiv.appendChild(messageInfoLeftDiv);

  let commentButtonsDiv = document.createElement('div');
  commentButtonsDiv.className = 'comment-buttons';
  
  let editButton = document.createElement('button');
  editButton.type = 'button';
  editButton.className = 'comment-manage-button';
  editButton.textContent = 'Edit';
  editButton.id = 'EditCommentbtn';
  commentButtonsDiv.appendChild(editButton);

  let deleteButton = document.createElement('button');
  deleteButton.type = 'button';
  deleteButton.className = 'comment-manage-button';
  deleteButton.textContent = 'Delete';
  deleteButton.id = 'DeleteCommentbtn';
  commentButtonsDiv.appendChild(deleteButton);
  
  commentInfoButtonsDiv.appendChild(commentButtonsDiv);

  commentContentDiv.appendChild(commentInfoButtonsDiv);
  commentDiv.appendChild(commentContentDiv);
  commentsSection.appendChild(commentDiv);
  document.getElementById('comment-content').value = '';

  commentsSection.scrollTop = commentsSection.scrollHeight;
})
.catch(error => console.error('Error:', error));
}

function handleCreateMessage(event) {
event.preventDefault();

if (!isMessageFormValid("message-content", "createmessage-contentError")) {
  return;
}

let url = this.getAttribute('action');
let formData = new FormData(this);
let csrfToken = document.querySelector('input[name="_token"]').value;

fetch(url, {
  method: 'POST',
  body: formData,
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrfToken,
  },
})
.catch(error => console.error('Error:', error));
}

function handleAddMember(modalId, event) {
  event.preventDefault();
  let url = this.getAttribute('action');
  let formData = new FormData(this);
  sendAjaxRequest('POST', url, {project_id: formData.get('project_id'),  member_id: formData.get('member_id')}, function() {
    if (this.status >= 200 && this.status < 400) {
      let modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
      modal.hide();
      location.reload();
    }
  });
}

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

function isProjectFormValid() {
let title = document.getElementById("proj_title").value;
let description = document.getElementById("proj_description").value;
let finishDate = document.getElementById("proj_finish_date").value;

document.getElementById('proj_titleError').innerHTML = '';
document.getElementById('proj_descriptionError').innerHTML = '';
document.getElementById('proj_finish_dateError').innerHTML = '';

if (title.length < 15 || title.length > 50) {
    document.getElementById('proj_titleError').innerHTML = 'Title must be between 15 and 50 characters long';
    return false;
}

if (description.length < 100 || description.length > 300) {
    document.getElementById('proj_descriptionError').innerHTML = 'Description must be between 100 and 300 characters long';
    return false;
}

if (finishDate) {
  if(new Date(finishDate) <= new Date()){
    document.getElementById('proj_finish_dateError').innerHTML = 'Finish date must be after today';
    return false;
  }
}

return true;
}


function isCommentFormValid(contentId, errorId) {
  let content = document.getElementById(contentId).value;
  document.getElementById(errorId).innerHTML = '';

  if (content.length < 1 || content.length > 300) {
    document.getElementById(contentId).classList.add('validation-err');
    document.getElementById(errorId).innerHTML = 'Comment content must be between 1 and 300 characters long';
    return false;
  }

  return true;
}

function isMessageFormValid(contentId, errorId) {
  let content = document.getElementById(contentId).value;
  document.getElementById(errorId).innerHTML = '';

  if (content.length < 1 || content.length > 300) {
    document.getElementById(contentId).classList.add('validation-err');
    document.getElementById(errorId).innerHTML = 'Message content must be between 1 and 300 characters long';
    return false;
  }

  return true;
}

function setupModalForm(formId, buttonId, modalId) {
let form = document.getElementById(formId);
switch (formId) {
  case 'addmemberform':
    document.getElementById(formId).addEventListener("submit", handleAddMember.bind(form, modalId));
    break;
  case 'createtaskform':
    document.getElementById(formId).addEventListener("submit", handleCreateTask);
    break;
  case 'edittaskform':
    document.getElementById(formId).addEventListener("submit", handleEditTask.bind(form, modalId));
    break;
  case 'editprojectform':
    document.getElementById(formId).addEventListener("submit", handleEditProject.bind(form, modalId));
    break;
  case 'createprojectform':
    document.getElementById(formId).addEventListener("submit", handleCreateProject);
    break;
  case'assignTaskForm':
    assign_task_to();
    break;
  case 'assignCoordinatorForm':
    assign_coordinator();
    break;
}
document.getElementById(buttonId).addEventListener('click', function () {
  let modal = new bootstrap.Modal(document.getElementById(modalId));
  modal.show();
});
}

function setupCommentForm(formId) {
  let form = document.getElementById(formId);
  document.getElementById(formId).addEventListener("submit", handleCreateComment.bind(form));
}


function setupMessageForm(formId) {
  let form = document.getElementById(formId);
  document.getElementById(formId).addEventListener("submit", handleCreateMessage.bind(form));
}


function dismiss_notification(notificationId) {
  console.log(notificationId);
  sendAjaxRequest('POST', '/dismiss-notification', {notificationId: notificationId}, function() {
    if (this.status >= 200 && this.status < 400) {
      const prev_number = document.getElementById('noti-number').textContent;
      if(prev_number == 1){
        document.getElementById('noti-number').textContent = '';
        document.getElementById('noti-number').classList.add('hide');
      }else {
        document.getElementById('noti-number').textContent = prev_number - 1;
      }
    
      let notificationElement = document.getElementById('n'+notificationId);
      notificationElement.style.transition = "transform 0.5s ease-out";
      notificationElement.style.transform = "translateX(100%)";
      setTimeout(function() {
          notificationElement.style.display = "none";
      }, 500);
    }
  });
}

function dismissAll() {
  const notifications = document.querySelectorAll('.notification');
  notifications.forEach(notification => {
    const notification_id = notification.id.substring(1); 
    dismiss_notification(notification_id);
  });
}

function accept_invite(reference_id, notification_id, member_id) {
  console.log(reference_id);
  console.log(notification_id);
  console.log(member_id);
  sendAjaxRequest('POST', '/addMember', {reference_id: reference_id, member_id: member_id}, function() {
    if (this.status >= 200 && this.status < 400) {
      const response = JSON.parse(this.response);
      console.log(response);
      dismiss_notification(notification_id);
    }
  });
}

function removeFromProject(projectId){
  const is_coordinator = document.querySelector('#leaveProject.coordinator');
  if(is_coordinator != null){
    assignCoordinator(projectId);
  }else{
    sendAjaxRequest('DELETE', '/leaveProject/'+projectId, {}, function() {
      if (this.status >= 200 && this.status < 400) {
        const response = JSON.parse(this.response);
        window.location.href = '/home';
      }
    });
  }
}

function kickFromProject(memberId, projectId){
  sendAjaxRequest('DELETE', '/kickMember/'+memberId+'/'+projectId, {}, function() {
    if (this.status >= 200 && this.status < 400) {
      location.reload();
    }
  });
}

function assignCoordinator(projectId){
const members = document.getElementsByClassName('user-id');
  
  const options = {};
  for(let i = 0; i < members.length; i++){
    const memberId = document.querySelectorAll('.user-id em')[i].textContent;
    options[i] = memberId;
  }
  Swal.fire({
    title: "You are the coordinator of this project!",
    text: "You need to nominate another coordinator before leaving the project!",
    icon: "warning",
    input: 'select',
    inputOptions: options,
    inputPlaceholder: 'Select a member',
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Ok',          
  })
  .then((result) => {
    if (result.isConfirmed) {
      const username = options[result.value].substring(1);
      sendAjaxRequest('POST', '/leaveAsCoordinator/'+username+'/'+projectId, {}, function() {
        if (this.status >= 200 && this.status < 400) {
          window.location.href = '/home';
        }
      });
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
addEventListeners();
let commentsSection = document.querySelector(".comments-section");
if (commentsSection) {
  commentsSection.scrollTop = commentsSection.scrollHeight;
}
});

function handleDelete(event, buttonId, itemClass, deleteUrl) {
  if (event.target.id !== buttonId) return;
    let itemDiv = event.target.closest('.' + itemClass);
    let itemId = itemDiv.id.split('-')[1];
    let csrfToken = document.querySelector('#csrf-token').value;
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(deleteUrl + itemId, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': csrfToken
          }
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            itemDiv.remove();
          } 
        })
        .catch((error) => {
          console.error('Error:', error);
        });
      }
    })
}

function EditMessage(event, buttonId, itemClass, editUrl) {
  if (event.target.id !== buttonId) return;

  let messageDiv = event.target.closest('.' + itemClass);
  let messageId = messageDiv.id.split('-')[1];
  let messageContent = document.getElementById('message-content-' + messageId).innerText;
  let csrfToken = document.querySelector('#csrf-token').value;

  let createForm = document.getElementById('createmessageform');
  let editForm = document.getElementById('editmessageform');
  createForm.classList.add('hide-message-form');
  editForm.classList.remove('hide-message-form');

  editForm.action = editUrl + messageId;
  editForm.elements['content'].value = messageContent;

  editForm.onsubmit = function(e) {
    e.preventDefault();

    if (!isMessageFormValid("edit-message-content", "editmessage-contentError")) return;

    let data = {
      content: editForm.elements['content'].value
    };

    fetch(editForm.action, {
      method: 'PATCH',
      body: JSON.stringify(data),
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrfToken,
      },
    })
    .then(response => {
      if (!response.ok) throw new Error('Network response was not ok');
      return response.json();
    })
    .then(data => {
      document.getElementById('message-content-' + messageId).innerText = data.message_content;
      let messageInfoButtonsDiv = messageDiv.querySelector('.message-info-buttons');
      let messageInfoLeftDiv = messageInfoButtonsDiv.querySelector('.message-info-left');
  
      if (data.edited) {
        let existingEditedElement = messageInfoLeftDiv.querySelector('h6[style="font-style: italic;"]');
        if (!existingEditedElement) {
          let editedElement = document.createElement('h6');
          editedElement.style.fontStyle = 'italic';
          editedElement.innerText = 'Edited';
          messageInfoLeftDiv.appendChild(editedElement);
        }
      }

      editForm.elements['content'].value = '';
      editForm.action = '';
      createForm.classList.remove('hide-message-form');
      editForm.classList.add('hide-message-form');
    })
    .catch(error => console.error('Error:', error));
  };
}

function EditComment(event, buttonId, itemClass, editUrl) {
  if (event.target.id !== buttonId) return;

  let commentDiv = event.target.closest('.' + itemClass);
  let commentId = commentDiv.id.split('-')[1];
  let commentContent = document.getElementById('comment-content-' + commentId).innerText;
  let csrfToken = document.querySelector('#csrf-token').value;

  let createForm = document.getElementById('createcommentform');
  let editForm = document.getElementById('editcommentform');
  createForm.classList.add('hide-message-form');
  editForm.classList.remove('hide-message-form');

  editForm.action = editUrl + commentId;
  editForm.elements['content'].value = commentContent;

  editForm.onsubmit = function(e) {
    e.preventDefault();

    if (!isCommentFormValid("edit-comment-content", "editcomment-contentError")) return;

    let data = {
      content: editForm.elements['content'].value
    };

    fetch(editForm.action, {
      method: 'PATCH',
      body: JSON.stringify(data),
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrfToken,
      },
    })
    .then(response => {
      if (!response.ok) throw new Error('Network response was not ok');
      return response.json();
    })
    .then(data => {
      document.getElementById('comment-content-' + commentId).innerText = data.comment_content;
      let commentInfoButtonsDiv = commentDiv.querySelector('.comment-info-buttons');
      let messageInfoLeftDiv = commentInfoButtonsDiv.querySelector('.message-info-left');
  
      if (data.edited) {
        let existingEditedElement = messageInfoLeftDiv.querySelector('h6[style="font-style: italic;"]');
        if (!existingEditedElement) {
          let editedElement = document.createElement('h6');
          editedElement.style.fontStyle = 'italic';
          editedElement.innerText = 'Edited';
          messageInfoLeftDiv.appendChild(editedElement);
        }
      }
      editForm.elements['content'].value = '';
      editForm.action = '';
      createForm.classList.remove('hide-message-form');
      editForm.classList.add('hide-message-form');
    })
    .catch(error => console.error('Error:', error));
  };
}

function handleDeleteComment(event) {
  handleDelete(event, 'DeleteCommentbtn', 'comment', '/comment/delete/');
}

function handleDeleteMessage(event) {
  handleDelete(event, 'DeleteMessagebtn', 'message-chat', '/message/delete/');
}

function  handleEditMessage(event) {
  EditMessage(event, 'EditMessagebtn', 'message-chat', '/message/edit/');
}

function handleEditComment(event){
  EditComment(event, 'EditCommentbtn', 'comment', '/comment/edit/');
}

// pusher 

const pusherAppKey = "fb8ef8f4fa10afc9c38c";
const pusherCluster = "eu";


const pusher = new Pusher(pusherAppKey, {
cluster: pusherCluster,
encrypted: true
});

//notifications channel
const channel = pusher.subscribe('notifications');
channel.bind('notification-invite', function(data) {
  
  if(data.user_id == userId){
    sendAjaxRequest('GET', '/notifications' , {}, handleRefreshNotifications);
  }
});

channel.bind('accepted-invite', function(data) {
    sendAjaxRequest('GET', '/notifications' , {}, handleRefreshNotifications);  
});

channel.bind('notification-coordinator', function(data) {
  sendAjaxRequest('GET', '/notifications' , {}, handleRefreshNotifications);  
});

channel.bind('notification-forum', function(data) {
  sendAjaxRequest('GET', '/notifications' , {}, handleRefreshNotifications);  
});

channel.bind('assigned-task', function(data) {
  sendAjaxRequest('GET', '/notifications' , {}, handleRefreshNotifications);  
});

channel.bind('notification-comment', function(data) {
  sendAjaxRequest('GET', '/notifications' , {}, handleRefreshNotifications);  
});

channel.bind('notification-archived', function(data) {
  sendAjaxRequest('GET', '/notifications' , {}, handleRefreshNotifications);  
});


//chat channel
const chatChannel = pusher.subscribe('chat');
chatChannel.bind('chat-message', function(data) {

console.log(data);

let chatSection = document.querySelector('.chat-section');

  let messageDiv = document.createElement('div');
  messageDiv.className = 'message-chat container';
  messageDiv.id = 'message-' + data.message_id;

  let userImage = document.createElement('img');
  userImage.src = "../"+data.photo_path
  userImage.className = 'user-image';
  userImage.alt = 'Gmail Image';
  messageDiv.appendChild(userImage);

  let messageContentDiv = document.createElement('div');
  messageContentDiv.className = 'message-content';

  let usernameH5 = document.createElement('h5');
  usernameH5.className = 'message-username';
  usernameH5.textContent = data.message_by;
  messageContentDiv.appendChild(usernameH5);

  let contentP = document.createElement('p');
  contentP.textContent = data.message;
  contentP.id = 'message-content-' + data.message_id;
  messageContentDiv.appendChild(contentP);

  let messageInfoButtonsDiv = document.createElement('div');
  messageInfoButtonsDiv.className = 'message-info-buttons';

  let messageInfoLeftDiv = document.createElement('div');
  messageInfoLeftDiv.className = 'message-info-left';

  let createDate = new Date(data.create_date);
  let formattedCreateDate = createDate.getFullYear() + '-' +
  String(createDate.getMonth() + 1).padStart(2, '0') + '-' +
  String(createDate.getDate()).padStart(2, '0') + ' ' +
  String(createDate.getHours()).padStart(2, '0') + ':' +
  String(createDate.getMinutes()).padStart(2, '0') + ':' +
  String(createDate.getSeconds()).padStart(2, '0');

  let createDateH6 = document.createElement('h6');
  createDateH6.textContent = formattedCreateDate;
  messageInfoLeftDiv.appendChild(createDateH6);

  messageInfoButtonsDiv.appendChild(messageInfoLeftDiv);

  let messageButtonsDiv = document.createElement('div');
  messageButtonsDiv.className = 'message-buttons';
  
  const name = document.querySelector('.chat-section').id;
  if(name === data.message_by){
    let editButton = document.createElement('button');
    editButton.type = 'button';
    editButton.className = 'message-manage-button';
    editButton.textContent = 'Edit';
    editButton.id = 'EditMessagebtn';
    messageButtonsDiv.appendChild(editButton);

    let deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.className = 'message-manage-button';
    deleteButton.textContent = 'Delete';
    deleteButton.id = 'DeleteMessagebtn';
    messageButtonsDiv.appendChild(deleteButton);
  }
  messageInfoButtonsDiv.appendChild(messageButtonsDiv);

  messageContentDiv.appendChild(messageInfoButtonsDiv);
  messageDiv.appendChild(messageContentDiv);
  chatSection.appendChild(messageDiv);
  document.getElementById('message-content').value = '';

  chatSection.scrollTop = chatSection.scrollHeight;

});

function handleRefreshNotifications() {
    if(this.status >= 200 && this.status < 400) {
      var data = JSON.parse(this.response);
      document.getElementById('notifications-list').innerHTML = "";
      
      let new_notis = 0;

      data.notifications.forEach(notification => {
        if(!notification.viewed){
        new_notis++;
        const li = document.createElement('li');
        li.classList.add('notification');
        li.classList.add(notification.type+"-notification");
        li.id = 'n' + notification.notification_id;
        if(notification.type == "invite") {
          let description_invite = document.createElement('p');
          description_invite.classList.add('notification-text');
          description_invite.textContent = "You have been invited to join the project ";
        
          const accept = document.createElement('button');
          accept.classList.add('invite-accept');
          accept.onclick = function() {
            accept_invite(notification.reference_id, notification.notification_id, notification.emited_to);
        };
          const iconaccept = document.createElement('i');
          iconaccept.classList.add('fa-solid');
          iconaccept.classList.add('fa-check');
          accept.appendChild(iconaccept);
  
          const deny = document.createElement('button');
          deny.classList.add('notification-deny');
          deny.onclick = function() {
            dismiss_notification(notification.notification_id);
          };
          const icondeny = document.createElement('i');
          icondeny.classList.add('fa-solid');
          icondeny.classList.add('fa-ban');
          deny.appendChild(icondeny);
  
          li.appendChild(description_invite);
          li.appendChild(accept);
          li.appendChild(deny);

        }
          else if(notification.type == "acceptedinvite") {
              let description_coordinator = document.createElement('p');
              description_coordinator.classList.add('notification-text');
              description_coordinator.textContent = "Your invitation to join the project was accepted";

              const dismiss = document.createElement('button');
              dismiss.classList.add('notification-dismiss');
              dismiss.onclick = function() {
                dismiss_notification(notification.notification_id);
              };
              const icondismiss = document.createElement('i');
              icondismiss.classList.add('fa-solid');
              icondismiss.classList.add('fa-eye');

              dismiss.appendChild(icondismiss);

              const reference_btn = document.createElement('button');
              reference_btn.classList.add('notification-reference');

              const reference = document.createElement('a');
              reference.href = "/project/" + notification.reference_id;
              
              const iconreference = document.createElement('i');
              iconreference.classList.add('fa-solid');
              iconreference.classList.add('fa-arrow-right');

              reference_btn.appendChild(iconreference);
              reference.appendChild(reference_btn);


              li.appendChild(description_coordinator);
              li.appendChild(reference);
              li.appendChild(dismiss);
          }else if(notification.type == "coordinator") {
              let description_coordinator = document.createElement('p');
              description_coordinator.classList.add('notification-text');
              description_coordinator.textContent = "There as been a change of coordinator in the project";

              const dismiss = document.createElement('button');
              dismiss.classList.add('notification-dismiss');
              dismiss.onclick = function() {
                dismiss_notification(notification.notification_id);
              };
              const icondismiss = document.createElement('i');
              icondismiss.classList.add('fa-solid');
              icondismiss.classList.add('fa-eye');

              dismiss.appendChild(icondismiss);

              const reference_btn = document.createElement('button');
              reference_btn.classList.add('notification-reference');

              const reference = document.createElement('a');
              reference.href = "/project/" + notification.reference_id;
              
              const iconreference = document.createElement('i');
              iconreference.classList.add('fa-solid');
              iconreference.classList.add('fa-arrow-right');

              reference_btn.appendChild(iconreference);
              reference.appendChild(reference_btn);



              li.appendChild(description_coordinator);
              li.appendChild(reference);
              li.appendChild(dismiss);
          } else if(notification.type == "forum") {
            let description_coordinator = document.createElement('p');
            description_coordinator.classList.add('notification-text');
            description_coordinator.textContent = "New message in the project chat";

            const dismiss = document.createElement('button');
            dismiss.classList.add('notification-dismiss');
            dismiss.onclick = function() {
              dismiss_notification(notification.notification_id);
            };
            const icondismiss = document.createElement('i');
            icondismiss.classList.add('fa-solid');
            icondismiss.classList.add('fa-eye');

            dismiss.appendChild(icondismiss);

            const reference_btn = document.createElement('button');
              reference_btn.classList.add('notification-reference');

              const reference = document.createElement('a');
              reference.href = "/project/" + notification.reference_id;
              
              const iconreference = document.createElement('i');
              iconreference.classList.add('fa-solid');
              iconreference.classList.add('fa-arrow-right');

              reference_btn.appendChild(iconreference);
              reference.appendChild(reference_btn);


            li.appendChild(description_coordinator);
            li.appendChild(reference);
            li.appendChild(dismiss);
        } else if(notification.type === "comment") {
          let description_accepted = document.createElement('p');
              description_accepted.classList.add('notification-text');
              description_accepted.textContent = "You have a new comment on the task.";

              const dismiss = document.createElement('button');
              dismiss.classList.add('notification-dismiss');
              dismiss.onclick = function() {
                dismiss_notification(notification.notification_id);
              };
              const icondismiss = document.createElement('i');
              icondismiss.classList.add('fa-solid');
              icondismiss.classList.add('fa-eye');

              dismiss.appendChild(icondismiss);

              const reference_btn = document.createElement('button');
              reference_btn.classList.add('notification-reference');

              const reference = document.createElement('a');
              reference.href = "/task/" + notification.reference_id;
              
              const iconreference = document.createElement('i');
              iconreference.classList.add('fa-solid');
              iconreference.classList.add('fa-arrow-right');

              reference_btn.appendChild(iconreference);
              reference.appendChild(reference_btn);


              li.appendChild(description_accepted);
              li.appendChild(reference);
              li.appendChild(dismiss);
      } else if(notification.type === "assignedtask") {
        let description_accepted = document.createElement('p');
            description_accepted.classList.add('notification-text');
            description_accepted.textContent = "You have been assigned to a task.";

            const dismiss = document.createElement('button');
            dismiss.classList.add('notification-dismiss');
            dismiss.onclick = function() {
              dismiss_notification(notification.notification_id);
            };
            const icondismiss = document.createElement('i');
            icondismiss.classList.add('fa-solid');
            icondismiss.classList.add('fa-eye');

            dismiss.appendChild(icondismiss);

            const reference_btn = document.createElement('button');
              reference_btn.classList.add('notification-reference');

              const reference = document.createElement('a');
              reference.href = "/task/" + notification.reference_id;
              
              const iconreference = document.createElement('i');
              iconreference.classList.add('fa-solid');
              iconreference.classList.add('fa-arrow-right');

              reference_btn.appendChild(iconreference);
              reference.appendChild(reference_btn);


              li.appendChild(description_accepted);
              li.appendChild(reference);
              li.appendChild(dismiss);
    } else if(notification.type === "archivedtask") {
      let description_accepted = document.createElement('p');
          description_accepted.classList.add('notification-text');
          description_accepted.textContent = "The task has been completed and archived.";

          const dismiss = document.createElement('button');
          dismiss.classList.add('notification-dismiss');
          dismiss.onclick = function() {
            dismiss_notification(notification.notification_id);
          };
          const icondismiss = document.createElement('i');
          icondismiss.classList.add('fa-solid');
          icondismiss.classList.add('fa-eye');

          dismiss.appendChild(icondismiss);

          const reference_btn = document.createElement('button');
              reference_btn.classList.add('notification-reference');

              const reference = document.createElement('a');
              reference.href = "/task/" + notification.reference_id;
              
              const iconreference = document.createElement('i');
              iconreference.classList.add('fa-solid');
              iconreference.classList.add('fa-arrow-right');

              reference_btn.appendChild(iconreference);
              reference.appendChild(reference_btn);


              li.appendChild(description_accepted);
              li.appendChild(reference);
              li.appendChild(dismiss);
  } else {
              let description_default = document.createElement('p');
              description_default.classList.add('notification-text');
              description_default.textContent = "You have a new notification in the project";
              li.appendChild(description_default);
          }

        document.getElementById('notifications-list').appendChild(li);
         } });

         if(new_notis > 0){
          document.getElementById('noti-number').classList.remove('hide');
          document.getElementById('noti-number').textContent = new_notis;
        }
    }
}


function handleLeaveProjectClick(event) {
event.preventDefault();
Swal.fire({
    title: "Are you sure?",
    text: "You are leaving this project!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, I am sure!',          

})
.then((result) => {
  if (result.isConfirmed) {
    const urlPath = window.location.pathname;
    const pathParts = urlPath.split('/');
    const projectId = pathParts[pathParts.length - 1];
    console.log(projectId);
    removeFromProject(projectId);
  }
});
}

function handleProjectVisibility() {

  const projectId = this.closest('.switch').dataset.projectId;
  const is_public = this.checked ? false : true;

  fetch(`/project/${projectId}/changevisibility`, {
      method: 'PATCH',
      headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
          is_public: is_public
      })
  })
  .then(response => response.json())
  .then(data => {
    this.checked = !(data.is_public);
  })
  .catch(error => {
    console.error('Error:', error);
    this.checked = !this.checked;
  });
}

function updateButtonsVisibility(archived) {
  const buttons = ['AddMemberModalButton', 'CreateTaskModalButton', 'EditProjectModalButton', 'AssignCoordinatorModalButton', 'createmessageform'];

  buttons.forEach(buttonId => {
    const button = document.getElementById(buttonId);
    if (button) {
      if (archived) {
        button.classList.add('archived-btn');
      } else {
        button.classList.remove('archived-btn');
      }
    }
  });

  const editdelbtns = document.querySelectorAll('.message-manage-button');
  editdelbtns.forEach(button => {
    if(archived) button.classList.add('archived-btn');
    else button.classList.remove('archived-btn');
  });
}

function handleProjectStatus() {
  const projectId = this.closest('.switch').dataset.projectId;
  const archived = this.checked;

  fetch(`/project/${projectId}/changestatus`, {
      method: 'PATCH',
      headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
          archived: archived
      })
  })
  .then(response => response.json())
  .then(data => {
      this.checked = data.archived;
      updateButtonsVisibility(data.archived)
  })
  .catch(error => {
      console.error('Error:', error);
      this.checked = !this.checked;
  });
}

function favoriteProject(userId){
  const urlPath = window.location.pathname;
  const pathParts = urlPath.split('/');
  const projectId = pathParts[pathParts.length - 1];

  sendAjaxRequest('POST', '/favoriteProject', {projectId: projectId, userId: userId}, function() {
    if (this.status >= 200 && this.status < 400) {
      const response = JSON.parse(this.responseText);
      const favoriteCount = document.querySelector('#Favorites p');
      favoriteCount.textContent = response.favoritesCount;
      const favoriteButton = document.querySelector('#favorite-btn');
      if(response.job === "add"){
        favoriteButton.innerHTML = '<i class="fa-solid fa-heart"></i>';
      }
      if(response.job  === "remove"){
        favoriteButton.innerHTML = '<i class="fa-regular fa-heart"></i>';
      }
    }
  });
}

function assign_task_to(){
  const members = document.querySelectorAll('.assign_task_member');
  members.forEach(function(member) {
    member.addEventListener('click', function() {
      members.forEach(function(member) {
        member.classList.remove('selected');
      });
      this.classList.add('selected');
      document.getElementById('assign_task_to').value = this.getAttribute('data-id');
    });
  });

  if (members.length > 0) {
    members[0].click();
  }
}

function assign_coordinator(){
  const members = document.querySelectorAll('.assign_coordinator_member');
  const form = document.getElementById('assignCoordinatorForm');
  const projectId = document.getElementById('project_id').value;
  members.forEach(function(member) {
    member.addEventListener('click', function() {
      members.forEach(function(member) {
        member.classList.remove('selected');
      });
      this.classList.add('selected');
      const username = this.getAttribute('data-id');
      document.getElementById('assign_coordinator').value = username;
      form.action = '/changeCoordinator/' + username + '/' + projectId;
    });
  });

  if (members.length > 0) {
    members[0].click();
  }
}


function handleCompleteTask() {
let taskId = this.getAttribute('data-task-id');
let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
fetch(`/task/complete/${taskId}`, { 
  method: 'PATCH',
  headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken
  },
})
.then(response => response.json())
.then(data => {
    let stateElement = document.getElementById('task-details-state');
    if (stateElement && stateElement.nextSibling.nodeType === Node.TEXT_NODE) {
      stateElement.nextSibling.nodeValue = 'completed';
      let completebtn = document.getElementById('completetaskbtn');
      completebtn.classList.add('archived-btn'); // hide btn
    }
  })
  .catch((error) => {
    console.error('Error:', error);
  });
}

function handle_taskarchived_btns() {
const buttons = ['upload_file_form','EditTaskModalButton', 'assignUserButton', 'completetaskbtn', 'archivetaskbtn', 'createcommentform'];

  buttons.forEach(buttonId => {
    const button = document.getElementById(buttonId);
    if (button) {
      button.classList.add('archived-btn');
    }
  });

  const editdelbtns = document.querySelectorAll('.comment-manage-button');
  editdelbtns.forEach(button => {
    button.classList.add('archived-btn');
  });
}

function handleArchiveTask() {
  let taskId = this.getAttribute('data-task-id');
  let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, archive it!'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`/task/archive/${taskId}`, { 
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
      })
      .then(response => response.json())
      .then(data => {
          let stateElement = document.getElementById('task-details-state');
          if (stateElement && stateElement.nextSibling.nodeType === Node.TEXT_NODE) {
            stateElement.nextSibling.nodeValue = 'archived';
            handle_taskarchived_btns();
          }
        })
        .catch((error) => {
          console.error('Error:', error);
        });
    }
  })
}

function closeNotifications() {
  document.getElementById("notifications-dropdown").classList.toggle("hide");
}

function updateUserTable(users) {
  var tableBody = document.getElementById('userTableBody');
  tableBody.innerHTML = '';
  users.forEach(function(user) {
      var row = document.createElement('tr');
      row.innerHTML = '<td>' + user.id + '</td>' +
                      '<td>' + user.name + '</td>' +
                      '<td>' + user.email + '</td>';
      tableBody.appendChild(row);
  });
}

let valueDisplays = document.querySelectorAll(".num");
let interval = 2500;
let initialDelay = 1000;

valueDisplays.forEach((valueDisplay) => {
  let startValue = 0;
  let endValue = parseInt(valueDisplay.getAttribute("data-val"));

  setTimeout(() => {
    let duration = Math.floor(interval / endValue);
    let counter = setInterval(function () {
      startValue += 1;
      valueDisplay.textContent = startValue;
      if (startValue == endValue) {
        clearInterval(counter);
      }
    },
    duration);
  },
  initialDelay);
});

let toggles = document.getElementsByClassName('faq-toggle');
let contentDiv = document.getElementsByClassName('faq-content');
let icons = document.getElementsByClassName('icon');

for(let i=0; i<toggles.length; i++){
    toggles[i].addEventListener('click', ()=>{
        if( parseInt(contentDiv[i].style.height) != contentDiv[i].scrollHeight){
            contentDiv[i].style.height = contentDiv[i].scrollHeight + "px";
            toggles[i].style.color = "#543CE7";
            toggles[i].style.fontWeight = "600";
            icons[i].classList.remove('fa-plus');
            icons[i].classList.add('fa-minus');
        }
        else{
            contentDiv[i].style.height = "0px";
            toggles[i].style.color = "#111130";
            toggles[i].style.fontWeight = "400";
            icons[i].classList.remove('fa-minus');
            icons[i].classList.add('fa-plus');
        }

        for(let j=0; j<contentDiv.length; j++){
            if(j!==i){
                contentDiv[j].style.height = "0px";
                toggles[j].style.color = "#111130";
                icons[j].classList.remove('fa-minus');
                icons[j].classList.add('fa-plus');
            }
        }
    });
}